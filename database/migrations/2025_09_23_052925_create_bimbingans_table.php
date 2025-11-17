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
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kerja_praktek_id')->constrained('kerja_prakteks')->onDelete('cascade');
            $table->foreignId('dosen_pembimbing_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');

            // Informasi bimbingan
            $table->date('tanggal_bimbingan');
            $table->text('topik_bimbingan');
            $table->text('hasil_bimbingan');
            $table->text('catatan')->nullable();
            $table->string('metode')->default('offline'); // offline, online
            $table->integer('durasi_menit')->default(60);
            $table->string('status')->default('selesai'); // dijadwalkan, berlangsung, selesai, dibatalkan

            // File lampiran
            $table->string('file_lampiran')->nullable();

            // Rating dan feedback
            $table->integer('rating_kualitas')->nullable(); // 1-5
            $table->text('feedback_mahasiswa')->nullable();
            $table->text('feedback_dosen')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingans');
    }
};
