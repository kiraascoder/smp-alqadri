<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konselings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // siswa
            $table->foreignId('guru_bk_id')->constrained('users')->onDelete('cascade'); // guru BK
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('tempat')->default('Ruang BK');
            $table->text('topik')->nullable();
            $table->foreignId('laporan_id')->nullable()->constrained('laporans')->onDelete('set null');
            $table->enum('status', ['dijadwalkan', 'selesai', 'batal'])->default('dijadwalkan');
            $table->string('alasan_batal')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling');
    }
};
