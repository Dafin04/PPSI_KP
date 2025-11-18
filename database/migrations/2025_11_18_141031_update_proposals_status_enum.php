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
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'ditolak'])->default('draft')->after('file_proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending')->after('file_proposal');
        });
    }
};
