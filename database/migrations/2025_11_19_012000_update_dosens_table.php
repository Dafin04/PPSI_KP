<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dosens')) {
            Schema::table('dosens', function (Blueprint $table) {
                if (!Schema::hasColumn('dosens', 'prodi')) {
                    $table->string('prodi')->nullable();
                }
                if (!Schema::hasColumn('dosens', 'keahlian')) {
                    $table->string('keahlian')->nullable();
                }
                if (!Schema::hasColumn('dosens', 'status_aktif')) {
                    $table->boolean('status_aktif')->default(true);
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('dosens')) {
            Schema::table('dosens', function (Blueprint $table) {
                if (Schema::hasColumn('dosens', 'prodi')) {
                    $table->dropColumn('prodi');
                }
                if (Schema::hasColumn('dosens', 'keahlian')) {
                    $table->dropColumn('keahlian');
                }
                if (Schema::hasColumn('dosens', 'status_aktif')) {
                    $table->dropColumn('status_aktif');
                }
            });
        }
    }
};
