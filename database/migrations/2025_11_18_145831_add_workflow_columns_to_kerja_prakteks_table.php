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
        Schema::table('kerja_prakteks', function (Blueprint $table) {
            $table->string('progress_status')
                ->default('menunggu')
                ->after('status');
            $table->timestamp('progress_status_updated_at')
                ->nullable()
                ->after('progress_status');

            $table->string('hasil_akhir')
                ->default('menunggu')
                ->after('nilai_akhir');
            $table->timestamp('hasil_akhir_ditetapkan_at')
                ->nullable()
                ->after('hasil_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kerja_prakteks', function (Blueprint $table) {
            $table->dropColumn([
                'progress_status',
                'progress_status_updated_at',
                'hasil_akhir',
                'hasil_akhir_ditetapkan_at',
            ]);
        });
    }
};
