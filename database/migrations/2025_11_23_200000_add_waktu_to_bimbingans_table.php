<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bimbingans') && !Schema::hasColumn('bimbingans', 'waktu_bimbingan')) {
            Schema::table('bimbingans', function (Blueprint $table) {
                $table->time('waktu_bimbingan')->nullable()->after('tanggal_bimbingan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bimbingans') && Schema::hasColumn('bimbingans', 'waktu_bimbingan')) {
            Schema::table('bimbingans', function (Blueprint $table) {
                $table->dropColumn('waktu_bimbingan');
            });
        }
    }
};
