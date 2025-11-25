<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kerja_prakteks', function (Blueprint $table) {
            $table->string('bukti_ipk_file')->nullable()->after('proposal_file');
            $table->text('prestasi_akademik')->nullable()->after('bukti_ipk_file');
            $table->text('prestasi_non_akademik')->nullable()->after('prestasi_akademik');
            $table->text('pengalaman_si')->nullable()->after('prestasi_non_akademik');
        });

        Schema::table('pendaftaran_kps', function (Blueprint $table) {
            $table->string('bukti_ipk_file')->nullable()->after('jenis');
            $table->text('prestasi_akademik')->nullable()->after('bukti_ipk_file');
            $table->text('prestasi_non_akademik')->nullable()->after('prestasi_akademik');
            $table->text('pengalaman_si')->nullable()->after('prestasi_non_akademik');
        });
    }

    public function down(): void
    {
        Schema::table('kerja_prakteks', function (Blueprint $table) {
            $table->dropColumn(['bukti_ipk_file', 'prestasi_akademik', 'prestasi_non_akademik', 'pengalaman_si']);
        });

        Schema::table('pendaftaran_kps', function (Blueprint $table) {
            $table->dropColumn(['bukti_ipk_file', 'prestasi_akademik', 'prestasi_non_akademik', 'pengalaman_si']);
        });
    }
};
