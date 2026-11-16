# Import Riwayat Historis Siswa Lama

Command ini mengimpor rekap poin pelanggaran/kebajikan sebelum sistem digunakan.

## Sumber Excel

Sheet yang dibaca:
- Kelas 7
- Kelas 8
- Kelas 9

Kolom:
- B = NAMA SISWA
- C = KLS/Kelas
- E = (+) kebajikan
- F = (--) pelanggaran

Nilai POIN 100 dan TOTAL tidak diimpor sebagai riwayat karena keduanya bukan kejadian pelanggaran/kebajikan.

## Prinsip keamanan

- Tidak menghapus data production.
- Tidak mengubah master pelanggaran/kebajikan.
- Tidak membuat jenis pelanggaran/kebajikan fiktif.
- Hanya membuat maksimal satu riwayat agregat pelanggaran dan satu riwayat agregat kebajikan per siswa untuk snapshot historis.
- Pencocokan nama yang meragukan tidak dipaksakan; command membuat mapping JSON.
- `score_bk` hanya ditambah sebesar poin pelanggaran historis yang benar-benar baru dibuat.
- Menjalankan command kedua kali tidak menggandakan data historis.

## Instalasi

1. Salin file ke:
   `app/Console/Commands/ImportRiwayatSiswaLama.php`
2. Pastikan `phpoffice/phpspreadsheet` tersedia di project.
3. Pastikan command terdaftar otomatis oleh Laravel versi project.

## Dry run

```bash
php artisan sekolah:import-riwayat-lama "storage/app/import/Draft Pelanggaran dan Kebajikan Siswa.xlsx" --dry-run
```

Jika file berada di root project:

```bash
php artisan sekolah:import-riwayat-lama "Draft Pelanggaran dan Kebajikan Siswa.xlsx" --dry-run
```

## Mapping

Jika ada nama yang belum aman dicocokkan, command membuat:

- `storage/app/import/riwayat_siswa_mapping.json`
- `storage/app/import/riwayat_siswa_mapping_saran.txt`

Isi `student_id` pada JSON hanya setelah diverifikasi.

Lalu jalankan:

```bash
php artisan sekolah:import-riwayat-lama "Draft Pelanggaran dan Kebajikan Siswa.xlsx" --mapping="storage/app/import/riwayat_siswa_mapping.json"
```

## Snapshot date

Default: `2026-11-02`.

Bisa diubah:

```bash
--date=2026-11-02
```
