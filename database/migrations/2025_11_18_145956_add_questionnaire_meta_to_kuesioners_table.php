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
        Schema::table('kuesioners', function (Blueprint $table) {
            $table->unsignedSmallInteger('kuota_tahun_depan')->nullable()->after('tipe');
            $table->text('saran_kegiatan')->nullable()->after('kuota_tahun_depan');
            $table->text('kebutuhan_skill')->nullable()->after('saran_kegiatan');
            $table->enum('tingkat_kepuasan', ['puas', 'tidak_puas'])->nullable()->after('kebutuhan_skill');
            $table->string('sertifikat_path')->nullable()->after('tingkat_kepuasan');
            $table->timestamp('sertifikat_dibuat_pada')->nullable()->after('sertifikat_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuesioners', function (Blueprint $table) {
            $table->dropColumn([
                'kuota_tahun_depan',
                'saran_kegiatan',
                'kebutuhan_skill',
                'tingkat_kepuasan',
                'sertifikat_path',
                'sertifikat_dibuat_pada',
            ]);
        });
    }
};
