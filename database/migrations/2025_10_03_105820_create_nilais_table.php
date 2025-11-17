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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            $table->foreignId('pembimbing_lapangan_id')->constrained('users')->onDelete('cascade');
            $table->decimal('nilai_pembimbing', 5, 2)->nullable();
            $table->decimal('nilai_lapangan', 5, 2)->nullable();
            $table->decimal('nilai_seminar', 5, 2)->nullable();
            $table->decimal('total_nilai', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
