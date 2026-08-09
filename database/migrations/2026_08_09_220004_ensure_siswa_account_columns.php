<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('siswa')) {
            return;
        }

        $hasUserId = Schema::hasColumn('siswa', 'user_id');
        $hasNisn = Schema::hasColumn('siswa', 'nisn');
        $hasScoreBk = Schema::hasColumn('siswa', 'score_bk');

        Schema::table('siswa', function (Blueprint $table) use ($hasUserId, $hasNisn, $hasScoreBk) {
            if (! $hasUserId) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->index('user_id');
            }

            if (! $hasNisn) {
                $table->string('nisn', 30)->nullable()->after('user_id');
                $table->index('nisn');
            }

            if (! $hasScoreBk) {
                $table->unsignedInteger('score_bk')->default(0);
            }
        });
    }

    public function down(): void
    {
        // No-op untuk menjaga kompatibilitas dan mencegah kehilangan data production.
    }
};
