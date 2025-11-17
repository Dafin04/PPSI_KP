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
        Schema::create('kerja_prakteks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instansi_id')->constrained('instansis')->onDelete('cascade');
            $table->foreignId('dosen_pembimbing_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('pengawas_lapangan_id')->nullable()->constrained('users')->onDelete('set null');

            // Informasi KP
            $table->string('judul_kp');
            $table->text('deskripsi_kp')->nullable();
            $table->string('status')->default('draft'); // draft, diajukan, disetujui, ditolak, berlangsung, selesai, gagal
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi_minggu')->default(8);

            // Pilihan instansi (3 opsi)
            $table->string('pilihan_1')->nullable();
            $table->string('pilihan_2')->nullable();
            $table->string('pilihan_3')->nullable();
            $table->string('instansi_diterima')->nullable();

            // File uploads
            $table->string('proposal_file')->nullable();
            $table->string('laporan_akhir_file')->nullable();
            $table->string('lembar_pengesahan_file')->nullable();

            // Penilaian
            $table->decimal('nilai_dosen_pembimbing', 5, 2)->nullable();
            $table->decimal('nilai_pengawas_lapangan', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->text('catatan_nilai')->nullable();

            // Status dan validasi
            $table->boolean('sudah_seminar')->default(false);
            $table->date('tanggal_seminar')->nullable();
            $table->boolean('lolos_seminar')->default(false);
            $table->text('catatan_seminar')->nullable();

            // Riwayat bimbingan
            $table->integer('jumlah_bimbingan')->default(0);
            $table->json('riwayat_bimbingan')->nullable(); // menyimpan array bimbingan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerja_prakteks');
    }
};
