<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_kebajikan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->foreignId('kebajikan_id')
                ->constrained('kebajikans')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Snapshot skor
            |--------------------------------------------------------------------------
            | Skor disimpan di sini supaya jika master kebajikan berubah
            | dari 5 menjadi 10, riwayat lama tetap 5.
            */
            $table->unsignedInteger('skor');

            $table->date('tanggal');

            $table->text('keterangan')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Guru yang memberikan poin
            |--------------------------------------------------------------------------
            */
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'siswa_id',
                'tanggal',
            ]);

            $table->index([
                'created_by',
                'tanggal',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_kebajikan');
    }
};
