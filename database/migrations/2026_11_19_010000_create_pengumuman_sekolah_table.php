<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 180);
            $table->string('slug', 200)->unique();
            $table->string('kategori', 100)->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('gambar')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('nama_lampiran')->nullable();
            $table->string('status', 20)->default('draft');
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->date('expires_on')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Nama index eksplisit agar tidak melewati batas 64 karakter MySQL.
            $table->index(['status', 'is_pinned', 'published_at'], 'pg_status_pin_pub_idx');
            $table->index('expires_on', 'pg_expires_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman_sekolah');
    }
};
