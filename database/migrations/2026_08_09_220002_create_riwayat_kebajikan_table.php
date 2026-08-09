<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('riwayat_kebajikan')) {
            Schema::create('riwayat_kebajikan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
                $table->foreignId('kebajikan_id')->constrained('kebajikans')->restrictOnDelete();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->date('tanggal');
                $table->unsignedSmallInteger('skor');
                $table->text('keterangan')->nullable();
                $table->timestamps();

                $table->index(['siswa_id', 'tanggal']);
                $table->index(['created_by', 'tanggal']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_kebajikan');
    }
};
