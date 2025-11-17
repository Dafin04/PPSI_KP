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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kerja_praktek_id')->constrained('kerja_prakteks')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');

            // Informasi seminar
            $table->string('judul_seminar');
            $table->text('abstrak')->nullable();
            $table->date('tanggal_seminar');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('tempat')->nullable();
            $table->string('metode')->default('offline'); // offline, online
            $table->string('link_online')->nullable();

            // Panitia seminar
            $table->foreignId('ketua_penguji_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('anggota_penguji_1_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('anggota_penguji_2_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('pembimbing_penguji_id')->nullable()->constrained('users')->onDelete('set null');

            // File dan dokumen
            $table->string('proposal_file')->nullable();
            $table->string('presentasi_file')->nullable();
            $table->string('laporan_seminar_file')->nullable();

            // Penilaian
            $table->decimal('nilai_ketua_penguji', 5, 2)->nullable();
            $table->decimal('nilai_anggota_1', 5, 2)->nullable();
            $table->decimal('nilai_anggota_2', 5, 2)->nullable();
            $table->decimal('nilai_pembimbing', 5, 2)->nullable();
            $table->decimal('nilai_akhir_seminar', 5, 2)->nullable();
            $table->text('catatan_penilaian')->nullable();

            // Status
            $table->string('status')->default('dijadwalkan'); // dijadwalkan, berlangsung, selesai, dibatalkan
            $table->boolean('lolos')->default(false);
            $table->text('alasan_tidak_lolos')->nullable();

            // Kehadiran
            $table->json('kehadiran_penguji')->nullable(); // menyimpan status kehadiran
            $table->integer('jumlah_peserta')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
