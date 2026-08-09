<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('kebajikans')) {
            Schema::create('kebajikans', function (Blueprint $table) {
                $table->id();
                $table->text('deskripsi');
                $table->unsignedSmallInteger('skor');
                $table->timestamps();

                $table->index('skor');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kebajikans');
    }
};
