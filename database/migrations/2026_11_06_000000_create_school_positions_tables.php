<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('school_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()
                ->constrained('school_positions')->restrictOnDelete();
            $table->string('title', 150);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_homepage')->default(false);
            $table->timestamps();
            $table->index(['parent_id', 'is_active', 'sort_order']);
        });

        Schema::create('school_position_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_position_id')
                ->constrained('school_positions')->restrictOnDelete();
            $table->string('name', 150);
            $table->string('subtitle', 180)->nullable();
            $table->string('photo_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(
                ['school_position_id', 'is_active', 'sort_order'],
                'spm_position_active_sort_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_position_members');
        Schema::dropIfExists('school_positions');
    }
};
