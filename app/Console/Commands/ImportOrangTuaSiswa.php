<?php

namespace App\Console\Commands;

use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;

class ImportOrangTuaSiswa extends Command
{
    protected $signature = 'sekolah:import-orang-tua
                            {file : Path file Excel data orang tua}
                            {--dry-run : Hanya memeriksa data tanpa mengubah database}';

    protected $description = 'Import akun orang tua dan relasi siswa dari file Excel.';

    public function handle(): int
    {
        $file = $this->resolveFilePath($this->argument('file'));

        if (! $file || ! is_file($file)) {
            $this->error('File Excel tidak ditemukan.');
            return self::FAILURE;
        }

        try {
            $spreadsheet = IOFactory::load($file);
        } catch (Throwable $e) {
            $this->error(
                'File Excel tidak dapat dibaca: ' . $e->getMessage()
            );

            return self::FAILURE;
        }

        [$rows, $stats] = $this->readRows($spreadsheet);

        if (! empty($stats['errors'])) {
            foreach ($stats['errors'] as $error) {
                $this->warn($error);
            }
        }

        if (empty($rows)) {
            $this->error(
                'Tidak ada data valid yang dapat diproses.'
            );

            return self::FAILURE;
        }

        $groups = collect($rows)
            ->groupBy('phone')
            ->all();

        $duplicateGroups = collect($groups)
            ->filter(fn($group) => count($group) > 1);

        $this->newLine();
        $this->info('========================================');
        $this->info('IMPORT DATA ORANG TUA');
        $this->info('========================================');

        $this->line('File                  : ' . $file);
        $this->line('Data siswa valid      : ' . count($rows));
        $this->line('Baris kosong          : ' . $stats['blank_rows']);
        $this->line(
            'Nomor tidak valid     : ' .
                count($stats['invalid_phones'])
        );
        $this->line(
            'Nomor WhatsApp unik   : ' .
                count($groups)
        );
        $this->line(
            'Nomor dipakai >1 anak : ' .
                $duplicateGroups->count()
        );

        if ($duplicateGroups->isNotEmpty()) {
            $this->newLine();
            $this->info(
                'Nomor yang terhubung ke beberapa siswa:'
            );

            foreach ($duplicateGroups as $phone => $group) {
                $children = collect($group)
                    ->map(
                        fn($row) =>
                        $row['nama_siswa'] .
                            ' (' .
                            $row['kelas'] .
                            ')'
                    )
                    ->implode(', ');

                $this->line(
                    "- {$phone} => {$children}"
                );
            }
        }

        if (! empty($stats['invalid_phones'])) {
            $this->newLine();
            $this->warn(
                'Nomor WhatsApp yang perlu diperiksa:'
            );

            foreach ($stats['invalid_phones'] as $invalid) {
                $this->line(
                    "- {$invalid['nama_siswa']} " .
                        "({$invalid['kelas']}) => " .
                        "{$invalid['raw_phone']}"
                );
            }
        }

        $indexes = $this->buildIndexes();

        $resolution = $this->validateGroups(
            $groups,
            $indexes
        );

        $this->newLine();
        $this->info(
            'Hasil pencocokan dengan database:'
        );

        $this->line(
            'Grup siap diimport    : ' .
                count($resolution['ready'])
        );

        $this->line(
            'Grup bermasalah       : ' .
                count($resolution['failed'])
        );

        if (! empty($resolution['fuzzy'])) {
            $this->newLine();
            $this->info(
                'Pencocokan nama otomatis:'
            );

            foreach ($resolution['fuzzy'] as $match) {
                $score = number_format(
                    $match['score'] * 100,
                    1
                );

                $this->line(
                    "- {$match['input']} " .
                        "({$match['kelas']}) => " .
                        "{$match['database']} " .
                        "[{$match['type']}, {$score}%]"
                );
            }
        }

        if (! empty($resolution['failed'])) {
            $this->newLine();
            $this->warn(
                'Data yang masih perlu diperiksa:'
            );

            foreach ($resolution['failed'] as $failed) {
                $this->warn(
                    "- {$failed['phone']}: " .
                        $failed['reason']
                );
            }
        }

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->info(
                'DRY RUN selesai. Tidak ada perubahan database.'
            );

            return self::SUCCESS;
        }

        if (empty($resolution['ready'])) {
            $this->error(
                'Tidak ada grup yang siap diimport. ' .
                    'Perbaiki data/database terlebih dahulu.'
            );

            return self::FAILURE;
        }

        $createdUsers = 0;
        $updatedUsers = 0;
        $linkedStudents = 0;
        $importedGroups = 0;
        $failedImports = [];

        foreach ($resolution['ready'] as $groupData) {
            try {
                DB::transaction(
                    function () use (
                        $groupData,
                        &$createdUsers,
                        &$updatedUsers,
                        &$linkedStudents,
                        &$importedGroups
                    ) {
                        $phone = $groupData['phone'];

                        $studentModels =
                            $groupData['students'];

                        $user = $groupData['existing_user_id']
                            ? User::find(
                                $groupData['existing_user_id']
                            )
                            : null;

                        if (
                            $groupData['existing_user_id']
                            && ! $user
                        ) {
                            throw new \RuntimeException(
                                'Akun orang tua dengan ID ' .
                                    $groupData['existing_user_id'] .
                                    ' tidak ditemukan saat import.'
                            );
                        }

                        $parentName =
                            'Orang Tua ' .
                            collect($studentModels)
                            ->map(
                                fn($student) =>
                                $student->nama
                            )
                            ->unique()
                            ->implode(' & ');

                        if (! $user) {
                            $user = User::create([
                                'name' => Str::limit(
                                    $parentName,
                                    255,
                                    ''
                                ),
                                'email' =>
                                $this->generateInternalEmail(
                                    $phone
                                ),
                                'no_hp' => $phone,
                               'password' => Hash::make('password123!'),
                                'role' =>
                                User::ROLE_ORANG_TUA,
                            ]);

                            $createdUsers++;
                        } else {
                            if ($user->no_hp !== $phone) {
                                $user->no_hp = $phone;
                                $user->save();
                            }

                            $updatedUsers++;
                        }

                        $orangTua = OrangTua::where(
                            'user_id',
                            $user->id
                        )->first();

                        if (! $orangTua) {
                            $orangTua = new OrangTua();

                            $orangTua->user_id =
                                $user->id;

                            $orangTua->save();
                        }

                        foreach ($studentModels as $student) {
                            $student->orang_tua_id =
                                $orangTua->id;

                            $student->save();

                            $linkedStudents++;
                        }

                        $importedGroups++;
                    }
                );
            } catch (Throwable $e) {
                $failedImports[] = [
                    'phone' => $groupData['phone'],
                    'reason' => $e->getMessage(),
                ];
            }
        }

        $this->newLine();
        $this->info('========================================');
        $this->info('IMPORT SELESAI');
        $this->info('========================================');

        $this->line(
            'Akun orang tua baru   : ' .
                $createdUsers
        );

        $this->line(
            'Akun orang tua lama   : ' .
                $updatedUsers
        );

        $this->line(
            'Grup berhasil         : ' .
                $importedGroups
        );

        $this->line(
            'Siswa terhubung       : ' .
                $linkedStudents
        );

        $this->line(
            'Grup gagal saat import: ' .
                count($failedImports)
        );

        foreach ($failedImports as $failed) {
            $this->error(
                "- {$failed['phone']}: " .
                    $failed['reason']
            );
        }

        return empty($failedImports)
            ? self::SUCCESS
            : self::FAILURE;
    }

    private function resolveFilePath(
        string $path
    ): ?string {
        if (is_file($path)) {
            return realpath($path) ?: $path;
        }

        $basePath = base_path($path);

        if (is_file($basePath)) {
            return realpath($basePath) ?: $basePath;
        }

        return null;
    }

    private function readRows($spreadsheet): array
    {
        $rows = [];

        $stats = [
            'blank_rows' => 0,
            'invalid_phones' => [],
            'errors' => [],
        ];

        foreach (
            $spreadsheet->getWorksheetIterator()
            as $sheet
        ) {
            $highestRow =
                $sheet->getHighestDataRow();

            $highestColumn =
                $sheet->getHighestDataColumn();

            if ($highestRow < 1) {
                continue;
            }

            $highestColumnIndex =
                Coordinate::columnIndexFromString(
                    $highestColumn
                );

            $headers = [];

            for (
                $columnIndex = 1;
                $columnIndex <= $highestColumnIndex;
                $columnIndex++
            ) {
                $column =
                    Coordinate::stringFromColumnIndex(
                        $columnIndex
                    );

                $header =
                    $this->normalizeHeader(
                        $sheet
                            ->getCell($column . '1')
                            ->getFormattedValue()
                    );

                if ($header !== '') {
                    $headers[$header] = $column;
                }
            }

            $kelasColumn =
                $headers['kelas'] ?? null;

            $phoneColumn =
                $headers['no hp ortu'] ?? null;

            $studentColumn =
                $headers['nama siswa'] ?? null;

            if (
                ! $kelasColumn ||
                ! $phoneColumn ||
                ! $studentColumn
            ) {
                $stats['errors'][] =
                    "Sheet {$sheet->getTitle()} " .
                    "dilewati karena header wajib " .
                    "tidak lengkap.";

                continue;
            }

            for (
                $rowNumber = 2;
                $rowNumber <= $highestRow;
                $rowNumber++
            ) {
                $kelas = trim(
                    (string) $sheet
                        ->getCell(
                            $kelasColumn . $rowNumber
                        )
                        ->getFormattedValue()
                );

                $rawPhone = trim(
                    (string) $sheet
                        ->getCell(
                            $phoneColumn . $rowNumber
                        )
                        ->getFormattedValue()
                );

                $namaSiswa = trim(
                    (string) $sheet
                        ->getCell(
                            $studentColumn . $rowNumber
                        )
                        ->getFormattedValue()
                );

                if (
                    $kelas === '' &&
                    $rawPhone === '' &&
                    $namaSiswa === ''
                ) {
                    $stats['blank_rows']++;
                    continue;
                }

                if (
                    $kelas === '' ||
                    $namaSiswa === ''
                ) {
                    $stats['errors'][] =
                        "Sheet {$sheet->getTitle()} " .
                        "baris {$rowNumber}: kelas " .
                        "atau nama siswa kosong.";

                    continue;
                }

                $phone =
                    $this->normalizePhone($rawPhone);

                if (! $phone) {
                    $stats['invalid_phones'][] = [
                        'sheet' =>
                        $sheet->getTitle(),
                        'row' => $rowNumber,
                        'kelas' => $kelas,
                        'nama_siswa' => $namaSiswa,
                        'raw_phone' => $rawPhone,
                    ];

                    continue;
                }

                $rows[] = [
                    'sheet' =>
                    $sheet->getTitle(),
                    'row' => $rowNumber,
                    'kelas' => $kelas,
                    'nama_siswa' => $namaSiswa,
                    'phone' => $phone,
                ];
            }
        }

        return [
            $rows,
            $stats,
        ];
    }

    private function buildIndexes(): array
    {
        $kelasIndex = [];

        foreach (Kelas::all() as $kelas) {
            $key =
                $this->normalizeClass(
                    $kelas->nama_kelas
                );

            if ($key !== '') {
                $kelasIndex[$key][] = $kelas;
            }
        }

        $siswaIndex = [];

        foreach (
            Siswa::with('kelas')->get()
            as $siswa
        ) {
            $kelasName =
                $siswa->kelas?->nama_kelas;

            if (! $kelasName) {
                continue;
            }

            $key = $this->studentKey(
                $siswa->nama,
                $kelasName
            );

            $siswaIndex[$key][] = $siswa;
        }

        $parentIndex = [];

        $parentUsers = User::where(
            'role',
            User::ROLE_ORANG_TUA
        )
            ->whereNotNull('no_hp')
            ->get();

        $parentProfiles = OrangTua::whereIn(
            'user_id',
            $parentUsers->pluck('id')
        )
            ->get()
            ->keyBy('user_id');

        foreach ($parentUsers as $user) {
            $phone =
                $this->normalizePhone(
                    $user->no_hp
                );

            if (! $phone) {
                continue;
            }

            $parentIndex[$phone][] = [
                'user_id' => $user->id,
                'orang_tua_id' =>
                $parentProfiles
                    ->get($user->id)?->id,
            ];
        }

        return [
            'kelas' => $kelasIndex,
            'siswa' => $siswaIndex,
            'orang_tua' => $parentIndex,
        ];
    }

    private function validateGroups(
        array $groups,
        array $indexes
    ): array {
        $ready = [];
        $failed = [];
        $fuzzy = [];

        foreach ($groups as $phone => $group) {
            $studentModels = [];
            $studentMatches = [];
            $reason = null;

            $existingParents =
                $indexes['orang_tua'][$phone] ?? [];

            if (count($existingParents) > 1) {
                $failed[] = [
                    'phone' => $phone,
                    'reason' =>
                    'Nomor WhatsApp sudah dipakai ' .
                        'oleh lebih dari satu akun orang tua.',
                ];

                continue;
            }

            $existingOrangTuaId =
                $existingParents[0]['orang_tua_id']
                ?? null;

            foreach ($group as $row) {
                $kelasKey =
                    $this->normalizeClass(
                        $row['kelas']
                    );

                $kelasMatches =
                    $indexes['kelas'][$kelasKey]
                    ?? [];

                if (count($kelasMatches) !== 1) {
                    $reason =
                        count($kelasMatches) === 0
                        ? "Kelas {$row['kelas']} tidak ditemukan."
                        : "Kelas {$row['kelas']} " .
                        "terduplikasi di database.";

                    break;
                }

                $match =
                    $this->resolveStudentMatch(
                        $row['nama_siswa'],
                        $row['kelas'],
                        $indexes['siswa']
                    );

                if (! $match['accepted']) {
                    if (
                        $match['type'] === 'ambiguous'
                    ) {
                        $reason =
                            "Siswa {$row['nama_siswa']} " .
                            "({$row['kelas']}) memiliki " .
                            "kandidat yang ambigu.";
                    } else {
                        $reason =
                            "Siswa {$row['nama_siswa']} " .
                            "({$row['kelas']}) tidak " .
                            "dapat dicocokkan dengan aman.";
                    }

                    if (
                        ! empty($match['suggestions'])
                    ) {
                        $suggestions =
                            collect(
                                $match['suggestions']
                            )
                            ->map(
                                fn($suggestion) =>
                                $suggestion['student']->nama
                            )
                            ->implode(', ');

                        $reason .=
                            " Kandidat terdekat: " .
                            $suggestions . '.';
                    }

                    break;
                }

                $student =
                    $match['student'];

                if (
                    $student->orang_tua_id !== null &&
                    $student->orang_tua_id !==
                    $existingOrangTuaId
                ) {
                    $reason =
                        "Siswa {$row['nama_siswa']} " .
                        "({$row['kelas']}) sudah " .
                        "terhubung ke orang tua lain.";

                    break;
                }

                $studentModels[] =
                    $student;

                if (
                    $match['type'] !== 'exact'
                ) {
                    $studentMatch = [
                        'input' =>
                        $row['nama_siswa'],
                        'kelas' =>
                        $row['kelas'],
                        'database' =>
                        $student->nama,
                        'type' =>
                        $match['type'],
                        'score' =>
                        $match['score'],
                    ];

                    $studentMatches[] =
                        $studentMatch;

                    $fuzzy[] =
                        $studentMatch;
                }
            }

            if ($reason) {
                $failed[] = [
                    'phone' => $phone,
                    'reason' => $reason,
                ];

                continue;
            }

            $ready[] = [
                'phone' => $phone,
                'rows' => $group,
                'students' =>
                $studentModels,
                'student_matches' =>
                $studentMatches,
                'existing_user_id' =>
                $existingParents[0]['user_id']
                    ?? null,
                'existing_orang_tua_id' =>
                $existingOrangTuaId,
            ];
        }

        return [
            'ready' => $ready,
            'failed' => $failed,
            'fuzzy' => $fuzzy,
        ];
    }

    private function resolveStudentMatch(
        string $nama,
        string $kelas,
        array $studentIndex
    ): array {
        $nameKey =
            $this->normalizeStudentName(
                $nama
            );

        $classKey =
            $this->normalizeClass(
                $kelas
            );

        $exactKey =
            $nameKey . '|' . $classKey;

        $exactMatches =
            $studentIndex[$exactKey] ?? [];

        if (count($exactMatches) === 1) {
            return [
                'accepted' => true,
                'student' =>
                $exactMatches[0],
                'type' => 'exact',
                'score' => 1.0,
                'suggestions' => [],
            ];
        }

        if (count($exactMatches) > 1) {
            return [
                'accepted' => false,
                'student' => null,
                'type' => 'ambiguous',
                'score' => 1.0,
                'suggestions' =>
                collect($exactMatches)
                    ->map(
                        fn($student) => [
                            'student' =>
                            $student,
                            'score' => 1.0,
                        ]
                    )
                    ->all(),
            ];
        }

        $candidates = [];

        foreach (
            $studentIndex as $key => $students
        ) {
            $parts =
                explode('|', $key, 2);

            if (
                count($parts) !== 2 ||
                $parts[1] !== $classKey
            ) {
                continue;
            }

            foreach ($students as $student) {
                $metrics =
                    $this->studentNameMatchMetrics(
                        $nama,
                        $student->nama
                    );

                if (
                    $metrics['score'] >= 0.55
                ) {
                    $candidates[] = [
                        'student' =>
                        $student,
                        'score' =>
                        $metrics['score'],
                        'metrics' =>
                        $metrics,
                    ];
                }
            }
        }

        usort(
            $candidates,
            fn($a, $b) =>
            $b['score'] <=> $a['score']
        );

        if (empty($candidates)) {
            return [
                'accepted' => false,
                'student' => null,
                'type' => 'not_found',
                'score' => 0,
                'suggestions' => [],
            ];
        }

        $best = $candidates[0];

        $second =
            $candidates[1] ?? null;

        if (
            ! $this->isSafeStudentMatch(
                $best,
                $second
            )
        ) {
            return [
                'accepted' => false,
                'student' => null,
                'type' => 'ambiguous',
                'score' =>
                $best['score'],
                'suggestions' =>
                array_slice(
                    $candidates,
                    0,
                    3
                ),
            ];
        }

        return [
            'accepted' => true,
            'student' =>
            $best['student'],
            'type' => 'fuzzy',
            'score' =>
            $best['score'],
            'suggestions' =>
            array_slice(
                $candidates,
                0,
                3
            ),
        ];
    }

    private function isSafeStudentMatch(
        array $best,
        ?array $second
    ): bool {
        if (
            $second !== null &&
            ($best['score'] -
                $second['score']) < 0.08
        ) {
            return false;
        }

        $metrics =
            $best['metrics'];

        if (
            $metrics['meaningful_tokens'] <= 1
        ) {
            return (
                $best['score'] >= 0.90 &&
                (
                    $metrics['strong_tokens'] >= 1 ||
                    $metrics['whole'] >= 0.90
                )
            );
        }

        if (
            $metrics['whole'] >= 0.90
        ) {
            return true;
        }

        if (
            $metrics['token_average'] >= 0.82 &&
            $metrics['strong_tokens'] >= 2
        ) {
            return true;
        }

        return (
            $metrics['whole'] >= 0.70 &&
            $metrics['token_average'] >= 0.70 &&
            $metrics['strong_tokens'] >= 1 &&
            $metrics['strong_token_max_length'] >= 6
        );
    }

    private function studentNameMatchMetrics(
        string $source,
        string $candidate
    ): array {
        $sourceNormalized =
            $this->normalizeStudentName(
                $source
            );

        $candidateNormalized =
            $this->normalizeStudentName(
                $candidate
            );

        similar_text(
            $sourceNormalized,
            $candidateNormalized,
            $wholePercent
        );

        $whole =
            $wholePercent / 100;

        $score = $whole;

        if (
            strlen($sourceNormalized) >= 4 &&
            str_contains(
                $candidateNormalized,
                $sourceNormalized
            )
        ) {
            $score =
                max(
                    $score,
                    0.96
                );
        }

        $sourceTokens =
            $this->studentNameTokens(
                $source
            );

        $candidateTokens =
            $this->studentNameTokens(
                $candidate
            );

        $meaningfulTokens =
            array_values(
                array_filter(
                    $sourceTokens,
                    fn($token) =>
                    strlen($token) >= 3
                )
            );

        $tokenScores = [];

        $strongTokens = 0;

        $strongTokenMaxLength = 0;

        foreach (
            $meaningfulTokens
            as $sourceToken
        ) {
            $bestTokenScore = 0;

            $bestStrong = false;

            foreach (
                $candidateTokens
                as $candidateToken
            ) {
                if (
                    $sourceToken ===
                    $candidateToken
                ) {
                    $tokenScore = 1.0;
                    $strong = true;
                } elseif (
                    $this->isNameAbbreviation(
                        $sourceToken,
                        $candidateToken
                    )
                ) {
                    $tokenScore = 0.95;
                    $strong = true;
                } elseif (
                    strlen($sourceToken) >= 3 &&
                    str_starts_with(
                        $candidateToken,
                        $sourceToken
                    )
                ) {
                    $tokenScore = 0.94;
                    $strong = true;
                } elseif (
                    strlen($sourceToken) >= 5 &&
                    str_contains(
                        $candidateToken,
                        $sourceToken
                    )
                ) {
                    $tokenScore = 0.92;
                    $strong = true;
                } else {
                    similar_text(
                        $sourceToken,
                        $candidateToken,
                        $tokenPercent
                    );

                    $tokenScore =
                        $tokenPercent / 100;

                    $strong =
                        $tokenScore >= 0.85;
                }

                if (
                    $tokenScore >
                    $bestTokenScore
                ) {
                    $bestTokenScore =
                        $tokenScore;

                    $bestStrong =
                        $strong;
                }
            }

            $tokenScores[] =
                $bestTokenScore;

            if ($bestStrong) {
                $strongTokens++;

                $strongTokenMaxLength =
                    max(
                        $strongTokenMaxLength,
                        strlen($sourceToken)
                    );
            }
        }

        $tokenAverage =
            empty($tokenScores)
            ? 0
            : array_sum(
                $tokenScores
            ) / count(
                $tokenScores
            );

        $score =
            max(
                $score,
                $tokenAverage
            );

        return [
            'score' => $score,
            'whole' => $whole,
            'token_average' =>
            $tokenAverage,
            'meaningful_tokens' =>
            count($meaningfulTokens),
            'strong_tokens' =>
            $strongTokens,
            'strong_token_max_length' =>
            $strongTokenMaxLength,
        ];
    }

    private function isNameAbbreviation(
        string $sourceToken,
        string $candidateToken
    ): bool {
        $sourceToken =
            mb_strtoupper(
                $sourceToken,
                'UTF-8'
            );

        $candidateToken =
            mb_strtoupper(
                $candidateToken,
                'UTF-8'
            );

        $muhammadAliases = [
            'MUH',
            'MUHD',
            'MUHAMMAD',
            'MOH',
            'MOHAMMAD',
            'MUHAMAD',
            'MUJ',
        ];

        if (
            in_array(
                $sourceToken,
                $muhammadAliases,
                true
            )
            &&
            in_array(
                $candidateToken,
                $muhammadAliases,
                true
            )
        ) {
            return true;
        }

        if (
            strlen($sourceToken) >= 2 &&
            strlen($sourceToken) < strlen($candidateToken) &&
            str_starts_with(
                $candidateToken,
                $sourceToken
            )
        ) {
            return true;
        }

        return false;
    }

    private function studentNameTokens(
        string $value
    ): array {
        $value =
            mb_strtoupper(
                trim($value),
                'UTF-8'
            );

        $value =
            preg_replace(
                '/[^A-Z0-9]+/u',
                ' ',
                $value
            ) ?? $value;

        $value =
            preg_replace(
                '/\s+/u',
                ' ',
                $value
            ) ?? $value;

        return array_values(
            array_filter(
                explode(
                    ' ',
                    trim($value)
                )
            )
        );
    }

    private function generateInternalEmail(
        string $phone
    ): string {
        $base =
            "ortu.{$phone}@smpalqadri.sch.id";

        $email = $base;

        $counter = 1;

        while (
            User::where(
                'email',
                $email
            )->exists()
        ) {
            $email =
                "ortu.{$phone}." .
                $counter .
                "@smpalqadri.sch.id";

            $counter++;
        }

        return $email;
    }

    private function studentKey(
        string $nama,
        string $kelas
    ): string {
        return
            $this->normalizeStudentName(
                $nama
            )
            . '|'
            .
            $this->normalizeClass(
                $kelas
            );
    }

    private function normalizeHeader(
        ?string $value
    ): string {
        $value =
            trim(
                (string) $value
            );

        $value =
            mb_strtolower(
                $value,
                'UTF-8'
            );

        $value =
            preg_replace(
                '/[^a-z0-9]+/u',
                ' ',
                $value
            ) ?? $value;

        return trim(
            preg_replace(
                '/\s+/u',
                ' ',
                $value
            ) ?? $value
        );
    }

    private function normalizeStudentName(
        ?string $value
    ): string {
        $value =
            trim(
                (string) $value
            );

        $value =
            mb_strtoupper(
                $value,
                'UTF-8'
            );

        $value =
            preg_replace(
                '/[^A-Z0-9]+/u',
                '',
                $value
            ) ?? $value;

        return $value;
    }

    private function normalizeClass(
        ?string $value
    ): string {
        $value =
            trim(
                (string) $value
            );

        $value =
            mb_strtoupper(
                $value,
                'UTF-8'
            );

        $value =
            preg_replace(
                '/[^A-Z0-9]+/u',
                '',
                $value
            ) ?? $value;

        $value =
            preg_replace(
                '/^KELAS/',
                '',
                $value
            ) ?? $value;

        return $value;
    }

    private function normalizeText(
        ?string $value
    ): string {
        $value =
            trim(
                (string) $value
            );

        $value =
            preg_replace(
                '/\s+/u',
                ' ',
                $value
            ) ?? $value;

        return mb_strtoupper(
            $value,
            'UTF-8'
        );
    }

    private function normalizePhone(
        ?string $value
    ): ?string {
        $phone =
            preg_replace(
                '/\D+/',
                '',
                (string) $value
            ) ?? '';

        if ($phone === '') {
            return null;
        }

        if (
            str_starts_with(
                $phone,
                '0'
            )
        ) {
            $phone =
                '62' .
                substr(
                    $phone,
                    1
                );
        } elseif (
            str_starts_with(
                $phone,
                '8'
            )
        ) {
            $phone =
                '62' .
                $phone;
        }

        if (
            ! preg_match(
                '/^628\d{8,12}$/',
                $phone
            )
        ) {
            return null;
        }

        return $phone;
    }
}
