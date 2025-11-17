<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proposals') && !Schema::hasColumn('proposals', 'dosen_id')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->foreignId('dosen_id')->nullable()->after('mahasiswa_id')->constrained('users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('proposals') && Schema::hasColumn('proposals', 'dosen_id')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropForeign(['dosen_id']);
                $table->dropColumn('dosen_id');
            });
        }
    }
};

