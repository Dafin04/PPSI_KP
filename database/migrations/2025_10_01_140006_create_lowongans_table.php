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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained()->onDelete('cascade');
            $table->string('judul_lowongan');
            $table->text('deskripsi');
            $table->text('kebutuhan_keahlian')->nullable();
            $table->integer('jumlah_kuota');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
