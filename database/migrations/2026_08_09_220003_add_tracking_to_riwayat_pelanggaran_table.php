<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('riwayat_pelanggaran')) {
            return;
        }

        $hasSkor = Schema::hasColumn('riwayat_pelanggaran', 'skor');
        $hasCreatedBy = Schema::hasColumn('riwayat_pelanggaran', 'created_by');

        Schema::table('riwayat_pelanggaran', function (Blueprint $table) use ($hasSkor, $hasCreatedBy) {
            if (! $hasSkor) {
                $table->unsignedSmallInteger('skor')->nullable()->after('pelanggaran_id');
            }

            if (! $hasCreatedBy) {
                // Sengaja tanpa FK agar aman pada database lama yang sudah berisi data.
                $table->unsignedBigInteger('created_by')->nullable()->after('skor');
                $table->index('created_by');
            }
        });
    }

    public function down(): void
    {
        // No-op untuk mencegah rollback menghapus kolom yang mungkin sudah ada
        // sebelum paket refactor diterapkan pada database production.
    }
};
