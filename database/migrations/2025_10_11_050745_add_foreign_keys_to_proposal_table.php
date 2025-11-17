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
        // Skipped: skema sudah memakai tabel plural dan kolom FK dibuat di migrasi lain
        // Dibiarkan kosong agar tidak error saat dijalankan pada skema baru
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
