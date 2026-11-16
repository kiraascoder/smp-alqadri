<?php

namespace App\Console\Commands;

use App\Models\Kelas;
use App\Models\RiwayatKebajikan;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;

class ImportRiwayatSiswaLama extends Command
{
    protected $signature = 'sekolah:import-riwayat-lama
                            {file : Path file Excel rekap pelanggaran dan kebajikan}
                            {--dry-run : Hanya memeriksa dan menghitung data tanpa mengubah database}
                            {--date=2026-11-02 : Tanggal snapshot historis}
                            {--mapping= : Path JSON mapping untuk nama yang tidak dapat dicocokkan otomatis}
                            {--created-by= : ID user pembuat data historis, opsional}
                            {--min-score=0.90 : Skor minimum fuzzy matching otomatis}
                            {--margin=0.08 : Selisih minimum skor dengan kandidat kedua}';

    protected $description = 'Import rekap historis pelanggaran dan kebajikan siswa dari Excel.';

    private const HISTORICAL_LABEL = 'Rekap historis sebelum sistem digunakan.';

    private array $classMap = [];
    private array $studentsByClass = [];
    private array $studentsByExactKey = [];
    private array $studentsByCompactKey = [];

    public function handle(): int
    {
        $file = $this->resolveFilePath($this->argument('file'));
        $date = (string) $this->option('date');

        if (! $file || ! is_file($file)) {
            $this->error('File Excel tidak ditemukan.');
            return self::FAILURE;
        }

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $this->error('Format --date harus YYYY-MM-DD.');
            return self::FAILURE;
        }

        $minScore = (float) $this->option('min-score');
        $margin = (float) $this->option('margin');

        if ($minScore < 0 || $minScore > 1 || $margin < 0 || $margin > 1) {
            $this->error('--min-score dan --margin harus berada di antara 0 dan 1.');
            return self::FAILURE;
        }

        try {
            $spreadsheet = IOFactory::load($file);
        } catch (Throwable $e) {
            $this->error('File Excel tidak dapat dibaca: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->loadMasterStudents();

        $rows = $this->readRows($spreadsheet);

        if (empty($rows)) {
            $this->error('Tidak ada data siswa yang dapat dibaca dari sheet Kelas 7, Kelas 8, atau Kelas 9.');
            return self::FAILURE;
        }

        $mapping = $this->loadMapping();
        $resolved = [];
        $unresolved = [];
        $zeroRows = 0;
        $invalidRows = [];

        foreach ($rows as $row) {
            $plus = $this->toInt($row['plus']);
            $minus = $this->toInt($row['minus']);

            if ($plus === 0 && $minus === 0) {
                $zeroRows++;
                continue;
            }

            $classKey = $this->normalizeClass($row['class']);
            $mappingKey = $classKey . '|' . $this->normalizeName($row['name']);

            $student = $this->resolveStudent(
                $row['name'],
                $classKey,
                $mapping[$mappingKey] ?? null,
                $minScore,
                $margin
            );

            if (! $student) {
                $unresolved[] = [
                    'row' => $row,
                    'mapping_key' => $mappingKey,
                    'suggestions' => $this->suggestStudents($row['name'], $classKey),
                ];
                continue;
            }

            $resolved[] = [
                'row' => $row,
                'student' => $student,
                'plus' => $plus,
                'minus' => $minus,
            ];
        }

        $this->printSummary(
            $file,
            $date,
            $rows,
            $resolved,
            $unresolved,
            $zeroRows,
            $invalidRows
        );

        if (! empty($unresolved)) {
            $mappingPath = $this->writeMappingTemplate($unresolved);

            $this->newLine();
            $this->error('Import dihentikan karena masih ada data siswa yang belum dapat dicocokkan dengan aman.');
            $this->line('Template mapping: ' . $mappingPath);
            $this->line('Isi nilai student_id pada file tersebut, lalu jalankan kembali command dengan --mapping=' . $mappingPath);

            return self::FAILURE;
        }

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->info('DRY RUN: tidak ada perubahan database.');
            $this->printProjectedScores($resolved);
            return self::SUCCESS;
        }

        $createdBy = $this->option('created-by');

        if ($createdBy !== null && ! ctype_digit((string) $createdBy)) {
            $this->error('--created-by harus berupa ID user berupa angka.');
            return self::FAILURE;
        }

        $result = [
            'pelanggaran_baru' => 0,
            'pelanggaran_dilewati' => 0,
            'kebajikan_baru' => 0,
            'kebajikan_dilewati' => 0,
            'siswa_diperbarui' => 0,
        ];

        DB::transaction(function () use ($resolved, $date, $createdBy, &$result) {
            foreach ($resolved as $item) {
                $student = $item['student'];
                $studentId = (int) $student->id;

                if ($item['minus'] > 0) {
                    $exists = RiwayatPelanggaran::query()
                        ->where('siswa_id', $studentId)
                        ->whereNull('pelanggaran_id')
                        ->whereDate('tanggal', $date)
                        ->where('skor', $item['minus'])
                        ->where('keterangan', self::HISTORICAL_LABEL)
                        ->exists();

                    if ($exists) {
                        $result['pelanggaran_dilewati']++;
                    } else {
                        RiwayatPelanggaran::create([
                            'siswa_id' => $studentId,
                            'pelanggaran_id' => null,
                            'created_by' => $createdBy !== null ? (int) $createdBy : null,
                            'skor' => $item['minus'],
                            'tanggal' => $date,
                            'keterangan' => self::HISTORICAL_LABEL,
                        ]);

                        /*
                         * score_bk merupakan agregat poin pelanggaran siswa.
                         * Jangan menghitung ulang dari seluruh riwayat karena
                         * nilai score_bk yang sudah ada di production harus
                         * tetap dipertahankan. Tambahkan hanya data historis
                         * yang benar-benar baru dibuat pada import ini.
                         */
                        Siswa::query()
                            ->whereKey($studentId)
                            ->increment('score_bk', $item['minus']);

                        $result['pelanggaran_baru']++;
                        $result['siswa_diperbarui']++;
                    }
                }

                if ($item['plus'] > 0) {
                    $exists = RiwayatKebajikan::query()
                        ->where('siswa_id', $studentId)
                        ->whereNull('kebajikan_id')
                        ->whereDate('tanggal', $date)
                        ->where('skor', $item['plus'])
                        ->where('keterangan', self::HISTORICAL_LABEL)
                        ->exists();

                    if ($exists) {
                        $result['kebajikan_dilewati']++;
                    } else {
                        RiwayatKebajikan::create([
                            'siswa_id' => $studentId,
                            'kebajikan_id' => null,
                            'skor' => $item['plus'],
                            'tanggal' => $date,
                            'keterangan' => self::HISTORICAL_LABEL,
                            'created_by' => $createdBy !== null ? (int) $createdBy : null,
                        ]);

                        $result['kebajikan_baru']++;
                    }
                }
            }
        });

        $this->newLine();
        $this->info('IMPORT SELESAI');
        $this->line('Riwayat pelanggaran baru : ' . $result['pelanggaran_baru']);
        $this->line('Riwayat pelanggaran skip : ' . $result['pelanggaran_dilewati']);
        $this->line('Riwayat kebajikan baru   : ' . $result['kebajikan_baru']);
        $this->line('Riwayat kebajikan skip   : ' . $result['kebajikan_dilewati']);
        $this->line('Siswa score_bk dihitung ulang: ' . $result['siswa_diperbarui']);

        return self::SUCCESS;
    }

    private function loadMasterStudents(): void
    {
        $this->classMap = Kelas::query()
            ->get(['id', 'nama_kelas'])
            ->mapWithKeys(fn($kelas) => [
                $this->normalizeClass($kelas->nama_kelas) => (int) $kelas->id,
            ])
            ->all();

        $students = Siswa::query()
            ->get(['id', 'kelas_id', 'nama', 'score_bk']);

        foreach ($students as $student) {
            $classKey = $this->classKeyFromId((int) $student->kelas_id);

            if (! $classKey) {
                continue;
            }

            $this->studentsByClass[$classKey][] = $student;

            $exactKey = $classKey . '|' . $this->normalizeName($student->nama);
            $compactKey = $classKey . '|' . $this->compactName($student->nama);

            $this->studentsByExactKey[$exactKey][] = $student;
            $this->studentsByCompactKey[$compactKey][] = $student;
        }
    }

    private function classKeyFromId(int $classId): ?string
    {
        foreach ($this->classMap as $key => $id) {
            if ($id === $classId) {
                return $key;
            }
        }

        return null;
    }

    private function readRows($spreadsheet): array
    {
        $rows = [];

        foreach (['Kelas 7', 'Kelas 8', 'Kelas 9'] as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);

            if (! $sheet) {
                $this->warn("Sheet '{$sheetName}' tidak ditemukan, dilewati.");
                continue;
            }

            foreach ($sheet->getRowIterator(4) as $row) {
                $rowNumber = $row->getRowIndex();
                $name = trim((string) $sheet->getCell('B' . $rowNumber)->getValue());
                $class = trim((string) $sheet->getCell('C' . $rowNumber)->getValue());

                if ($name === '') {
                    continue;
                }

                $rows[] = [
                    'sheet' => $sheetName,
                    'row' => $rowNumber,
                    'name' => $name,
                    'class' => $class,
                    'plus' => $sheet->getCell('E' . $rowNumber)->getValue(),
                    'minus' => $sheet->getCell('F' . $rowNumber)->getValue(),
                    'total' => $sheet->getCell('G' . $rowNumber)->getCalculatedValue(),
                ];
            }
        }

        return $rows;
    }

    private function resolveStudent(
        string $sourceName,
        string $classKey,
        ?int $mappedStudentId,
        float $minScore,
        float $margin
    ): ?Siswa {
        if ($mappedStudentId) {
            $student = Siswa::query()->find($mappedStudentId);

            if ($student && $this->classKeyFromId((int) $student->kelas_id) === $classKey) {
                return $student;
            }

            return null;
        }

        $exactKey = $classKey . '|' . $this->normalizeName($sourceName);
        $exact = $this->studentsByExactKey[$exactKey] ?? [];

        if (count($exact) === 1) {
            return $exact[0];
        }

        $compactKey = $classKey . '|' . $this->compactName($sourceName);
        $compact = $this->studentsByCompactKey[$compactKey] ?? [];

        if (count($compact) === 1) {
            return $compact[0];
        }

        $candidates = $this->rankCandidates($sourceName, $classKey);

        if (empty($candidates)) {
            return null;
        }

        $best = $candidates[0];
        $secondScore = $candidates[1]['score'] ?? 0;

        if ($best['score'] >= $minScore && ($best['score'] - $secondScore) >= $margin) {
            return $best['student'];
        }

        return null;
    }

    private function rankCandidates(string $sourceName, string $classKey): array
    {
        $candidates = [];

        foreach ($this->studentsByClass[$classKey] ?? [] as $student) {
            $candidates[] = [
                'student' => $student,
                'score' => $this->matchScore($sourceName, $student->nama),
            ];
        }

        usort($candidates, fn($a, $b) => $b['score'] <=> $a['score']);

        return $candidates;
    }

    private function suggestStudents(string $sourceName, string $classKey): array
    {
        return collect($this->rankCandidates($sourceName, $classKey))
            ->take(5)
            ->map(fn($item) => [
                'student_id' => (int) $item['student']->id,
                'nama' => $item['student']->nama,
                'score' => round($item['score'], 4),
            ])
            ->values()
            ->all();
    }

    private function matchScore(string $sourceName, string $targetName): float
    {
        $source = $this->normalizeName($sourceName);
        $target = $this->normalizeName($targetName);

        if ($source === $target) {
            return 1.0;
        }

        $sourceCompact = str_replace(' ', '', $source);
        $targetCompact = str_replace(' ', '', $target);

        similar_text($source, $target, $sequencePercent);
        similar_text($sourceCompact, $targetCompact, $compactPercent);

        $sourceTokens = $source === '' ? [] : explode(' ', $source);
        $targetTokens = $target === '' ? [] : explode(' ', $target);

        $matchedTokens = 0;

        foreach ($sourceTokens as $sourceToken) {
            foreach ($targetTokens as $targetToken) {
                if (
                    $sourceToken === $targetToken ||
                    Str::contains($targetToken, $sourceToken) ||
                    Str::contains($sourceToken, $targetToken)
                ) {
                    $matchedTokens++;
                    break;
                }
            }
        }

        $coverage = count($sourceTokens) > 0
            ? $matchedTokens / count($sourceTokens)
            : 0;

        return round(
            (0.50 * $coverage) +
                (0.30 * ($compactPercent / 100)) +
                (0.20 * ($sequencePercent / 100)),
            6
        );
    }

    private function normalizeName(string $value): string
    {
        $value = Str::upper(Str::ascii($value));
        $value = preg_replace('/[^A-Z0-9]+/', ' ', $value) ?? '';
        $value = preg_replace('/\s+/', ' ', trim($value)) ?? '';

        $tokens = $value === '' ? [] : explode(' ', $value);
        $tokens = array_map(
            fn($token) => match ($token) {
                'MUH', 'MH' => 'MUHAMMAD',
                default => $token,
            },
            $tokens
        );

        $merged = [];

        for ($i = 0; $i < count($tokens); $i++) {
            if ($tokens[$i] === 'AL' && isset($tokens[$i + 1])) {
                $merged[] = 'AL' . $tokens[$i + 1];
                $i++;
                continue;
            }

            $merged[] = $tokens[$i];
        }

        return implode(' ', $merged);
    }

    private function compactName(string $value): string
    {
        return str_replace(' ', '', $this->normalizeName($value));
    }

    private function normalizeClass(string $value): string
    {
        $value = Str::upper(trim($value));

        if (preg_match('/([789])\s*[\.\- ]*\s*([ABC])/', $value, $match)) {
            return 'KELAS ' . $match[1] . $match[2];
        }

        if (preg_match('/KELAS\s*([789])\s*([ABC])?/', $value, $match)) {
            return 'KELAS ' . $match[1] . ($match[2] ?? '');
        }

        return $this->normalizeName($value);
    }

    private function toInt($value): int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return (int) round((float) $value);
        }

        $value = preg_replace('/[^0-9\-]/', '', (string) $value) ?? '';

        return $value === '' ? 0 : (int) $value;
    }

    private function loadMapping(): array
    {
        $path = $this->option('mapping');

        if (! $path) {
            return [];
        }

        $path = $this->resolveFilePath($path) ?? $path;

        if (! is_file($path)) {
            $this->error('File mapping tidak ditemukan: ' . $path);
            return [];
        }

        $json = json_decode((string) file_get_contents($path), true);

        if (! is_array($json)) {
            $this->error('File mapping bukan JSON object yang valid: ' . $path);
            return [];
        }

        $mapping = [];

        foreach ($json as $key => $studentId) {
            if ($studentId === null || $studentId === '') {
                continue;
            }

            if (! is_numeric($studentId)) {
                $this->warn("Mapping '{$key}' memiliki student_id tidak valid dan akan diabaikan.");
                continue;
            }

            $mapping[$key] = (int) $studentId;
        }

        return $mapping;
    }

    private function writeMappingTemplate(array $unresolved): string
    {
        $directory = storage_path('app/import');

        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $path = $directory . '/riwayat_siswa_mapping.json';
        $data = [];

        foreach ($unresolved as $item) {
            $data[$item['mapping_key']] = null;
        }

        file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL
        );

        $suggestionPath = $directory . '/riwayat_siswa_mapping_saran.txt';
        $lines = [
            'Saran pencocokan nama siswa untuk import riwayat historis.',
            'Periksa setiap kandidat sebelum memasukkan student_id ke JSON mapping.',
            '',
        ];

        foreach ($unresolved as $item) {
            $row = $item['row'];
            $lines[] = 'SOURCE: ' . $row['name'] . ' | ' . $row['class'];

            if (empty($item['suggestions'])) {
                $lines[] = '  - Tidak ada kandidat pada kelas yang sama.';
            } else {
                foreach ($item['suggestions'] as $suggestion) {
                    $lines[] = sprintf(
                        '  - ID %d | %s | score %.4f',
                        $suggestion['student_id'],
                        $suggestion['nama'],
                        $suggestion['score']
                    );
                }
            }

            $lines[] = '';
        }

        file_put_contents($suggestionPath, implode(PHP_EOL, $lines));

        return $path;
    }

    private function printSummary(
        string $file,
        string $date,
        array $rows,
        array $resolved,
        array $unresolved,
        int $zeroRows,
        array $invalidRows
    ): void {
        $totalPlus = array_sum(array_column($resolved, 'plus'));
        $totalMinus = array_sum(array_column($resolved, 'minus'));

        $this->newLine();
        $this->info('========================================');
        $this->info('IMPORT RIWAYAT HISTORIS SISWA');
        $this->info('========================================');
        $this->line('File                    : ' . $file);
        $this->line('Tanggal snapshot        : ' . $date);
        $this->line('Total baris siswa       : ' . count($rows));
        $this->line('Baris dengan poin       : ' . count($resolved));
        $this->line('Baris poin 0 / 0        : ' . $zeroRows);
        $this->line('Siswa cocok otomatis    : ' . count($resolved));
        $this->line('Siswa belum cocok       : ' . count($unresolved));
        $this->line('Total poin kebajikan    : +' . $totalPlus);
        $this->line('Total poin pelanggaran  : -' . $totalMinus);

        if (! empty($unresolved)) {
            $this->newLine();
            $this->warn('DATA BELUM COCOK:');

            foreach ($unresolved as $item) {
                $row = $item['row'];
                $this->line(
                    '- ' . $row['name'] .
                        ' | ' . $row['class'] .
                        ' | +' . $this->toInt($row['plus']) .
                        ' | -' . $this->toInt($row['minus'])
                );
            }
        }
    }

    private function printProjectedScores(array $resolved): void
    {
        $grouped = [];

        foreach ($resolved as $item) {
            $id = (int) $item['student']->id;
            $grouped[$id] ??= [
                'student' => $item['student'],
                'minus' => 0,
            ];

            $grouped[$id]['minus'] += $item['minus'];
        }

        $this->newLine();
        $this->info('PROYEKSI SCORE_BK');

        foreach ($grouped as $item) {
            $existingHistoryScore = (int) RiwayatPelanggaran::query()
                ->where('siswa_id', $item['student']->id)
                ->whereNotNull('skor')
                ->sum('skor');

            $projected = $existingHistoryScore + $item['minus'];

            $this->line(
                $item['student']->id .
                    ' | ' . $item['student']->nama .
                    ' | history=' . $existingHistoryScore .
                    ' | import=+' . $item['minus'] .
                    ' | projected=' . $projected
            );
        }
    }

    private function resolveFilePath(?string $file): ?string
    {
        if (! $file) {
            return null;
        }

        $candidates = [
            $file,
            base_path($file),
            storage_path('app/' . ltrim($file, '/')),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return realpath($candidate) ?: $candidate;
            }
        }

        return null;
    }
}
