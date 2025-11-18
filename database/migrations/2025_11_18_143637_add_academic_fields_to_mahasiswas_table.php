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
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->decimal('ipk', 3, 2)->nullable()->after('angkatan'); // IPK with 2 decimal places
            $table->text('prestasi_akademik')->nullable()->after('ipk');
            $table->text('prestasi_non_akademik')->nullable()->after('prestasi_akademik');
            $table->text('pengalaman_si')->nullable()->after('prestasi_non_akademik'); // Pengalaman bidang Sistem Informasi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['ipk', 'prestasi_akademik', 'prestasi_non_akademik', 'pengalaman_si']);
        });
    }
};
