<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pelanggarans')) {
            return;
        }

        if (! Schema::hasColumn('pelanggarans', 'skor')) {
            Schema::table('pelanggarans', function (Blueprint $table) {
                $table->unsignedSmallInteger('skor')->nullable()->after('deskripsi');
            });
        }

        // Kompatibilitas migration lama yang masih memakai pengurangan_score.
        if (Schema::hasColumn('pelanggarans', 'pengurangan_score')) {
            DB::statement('UPDATE pelanggarans SET skor = COALESCE(skor, pengurangan_score)');
        }

        // Migration lama memakai ENUM ringan/sedang/berat. Ubah menjadi string agar
        // nilai resmi Ringan, Sedang, Sangat Berat dapat dipakai tanpa truncation.
        if (Schema::hasColumn('pelanggarans', 'kategori')) {
            DB::statement("ALTER TABLE pelanggarans MODIFY kategori VARCHAR(50) NOT NULL");

            DB::table('pelanggarans')->where('kategori', 'ringan')->update(['kategori' => 'Ringan']);
            DB::table('pelanggarans')->where('kategori', 'sedang')->update(['kategori' => 'Sedang']);
            DB::table('pelanggarans')->where('kategori', 'berat')->update(['kategori' => 'Sangat Berat']);
        }
    }

    public function down(): void
    {
        // Tidak dikembalikan ke ENUM lama karena dapat membuang nilai "Sangat Berat".
    }
};
