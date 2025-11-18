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
        if (!Schema::hasColumn('bimbingans', 'tanggal_bimbingan')) {
            return;
        }

        Schema::table('bimbingans', function (Blueprint $table) {
            $table->unique(
                ['mahasiswa_id', 'tanggal_bimbingan'],
                'bimbingan_mahasiswa_tanggal_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('bimbingans', 'tanggal_bimbingan')) {
            return;
        }

        Schema::table('bimbingans', function (Blueprint $table) {
            $table->dropUnique('bimbingan_mahasiswa_tanggal_unique');
        });
    }
};
