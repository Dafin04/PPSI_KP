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
        Schema::table('seminars', function (Blueprint $table) {
            $table->text('catatan_revisi')->nullable()->after('catatan_penilaian');
            $table->string('status_revisi')->default('belum_dikirim')->after('catatan_revisi');
            $table->string('file_revisi_path')->nullable()->after('status_revisi');
            $table->timestamp('revisi_disetujui_at')->nullable()->after('file_revisi_path');

            $table->decimal('nilai_penguji_angka', 5, 2)->nullable()->after('nilai_akhir_seminar');
            $table->string('nilai_penguji_huruf', 2)->nullable()->after('nilai_penguji_angka');
            $table->timestamp('nilai_penguji_input_at')->nullable()->after('nilai_penguji_huruf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->dropColumn([
                'catatan_revisi',
                'status_revisi',
                'file_revisi_path',
                'revisi_disetujui_at',
                'nilai_penguji_angka',
                'nilai_penguji_huruf',
                'nilai_penguji_input_at',
            ]);
        });
    }
};
