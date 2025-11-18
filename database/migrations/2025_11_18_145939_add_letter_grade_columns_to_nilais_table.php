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
        Schema::table('nilais', function (Blueprint $table) {
            $table->string('nilai_pembimbing_huruf', 2)->nullable()->after('nilai_pembimbing');
            $table->string('nilai_lapangan_huruf', 2)->nullable()->after('nilai_lapangan');
            $table->string('nilai_seminar_huruf', 2)->nullable()->after('nilai_seminar');
            $table->string('nilai_mutu', 2)->nullable()->after('total_nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn([
                'nilai_pembimbing_huruf',
                'nilai_lapangan_huruf',
                'nilai_seminar_huruf',
                'nilai_mutu',
            ]);
        });
    }
};
