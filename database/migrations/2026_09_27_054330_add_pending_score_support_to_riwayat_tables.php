<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_pelanggaran', function (Blueprint $table) {
            $table->unsignedBigInteger('pelanggaran_id')
                ->nullable()
                ->change();

            $table->integer('skor')
                ->nullable()
                ->change();

            $table->foreignId('dinilai_oleh')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('dinilai_pada')
                ->nullable()
                ->after('dinilai_oleh');
        });


        Schema::table('riwayat_kebajikan', function (Blueprint $table) {
            $table->unsignedBigInteger('kebajikan_id')
                ->nullable()
                ->change();

            $table->integer('skor')
                ->nullable()
                ->change();

            $table->foreignId('dinilai_oleh')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('dinilai_pada')
                ->nullable()
                ->after('dinilai_oleh');
        });
    }


    public function down(): void
    {
        Schema::table('riwayat_pelanggaran', function (Blueprint $table) {
            $table->dropForeign(['dinilai_oleh']);

            $table->dropColumn([
                'dinilai_oleh',
                'dinilai_pada',
            ]);

            $table->unsignedBigInteger('pelanggaran_id')
                ->nullable(false)
                ->change();

            $table->integer('skor')
                ->nullable(false)
                ->change();
        });


        Schema::table('riwayat_kebajikan', function (Blueprint $table) {
            $table->dropForeign(['dinilai_oleh']);

            $table->dropColumn([
                'dinilai_oleh',
                'dinilai_pada',
            ]);

            $table->unsignedBigInteger('kebajikan_id')
                ->nullable(false)
                ->change();

            $table->integer('skor')
                ->nullable(false)
                ->change();
        });
    }
};
