<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proposals') && !Schema::hasColumn('proposals', 'catatan_validasi')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->text('catatan_validasi')->nullable()->after('status_validasi');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('proposals') && Schema::hasColumn('proposals', 'catatan_validasi')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropColumn('catatan_validasi');
            });
        }
    }
};

