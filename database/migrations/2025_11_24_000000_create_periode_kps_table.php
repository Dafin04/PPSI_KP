<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('periode_kps')) {
            Schema::create('periode_kps', function (Blueprint $table) {
                $table->id();
                $table->string('tahun_ajaran');
                $table->enum('semester', ['Ganjil', 'Genap']);
                $table->date('tgl_mulai_pendaftaran')->nullable();
                $table->date('tgl_selesai_pendaftaran')->nullable();
                $table->enum('status', ['Aktif', 'Ditutup', 'Arsip'])->default('Aktif');
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        $targets = [
            'kerja_prakteks',
            'pendaftaran_kps',
            'proposals',
            'bimbingans',
            'laporans',
            'nilais',
            'seminars',
            'kuesioners',
            'kuotas',
        ];

        foreach ($targets as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'periode_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreignId('periode_id')->nullable()->constrained('periode_kps')->nullOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        $targets = [
            'kerja_prakteks',
            'pendaftaran_kps',
            'proposals',
            'bimbingans',
            'laporans',
            'nilais',
            'seminars',
            'kuesioners',
            'kuotas',
        ];

        foreach ($targets as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'periode_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['periode_id']);
                    $table->dropColumn('periode_id');
                });
            }
        }

        Schema::dropIfExists('periode_kps');
    }
};
