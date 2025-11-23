<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel utama
        if (Schema::hasTable('pembimbing_lapangans')) {
            Schema::table('pembimbing_lapangans', function (Blueprint $table) {
                if (!Schema::hasColumn('pembimbing_lapangans', 'nip')) {
                    $table->string('nip')->nullable();
                }
                if (!Schema::hasColumn('pembimbing_lapangans', 'jabatan')) {
                    $table->string('jabatan')->nullable();
                }
                if (!Schema::hasColumn('pembimbing_lapangans', 'kontak')) {
                    $table->string('kontak')->nullable();
                }
            });
        }

        // Fallback tabel lama (jika masih ada)
        if (Schema::hasTable('pembimbing_lapangan')) {
            Schema::table('pembimbing_lapangan', function (Blueprint $table) {
                if (!Schema::hasColumn('pembimbing_lapangan', 'nip')) {
                    $table->string('nip')->nullable();
                }
                if (!Schema::hasColumn('pembimbing_lapangan', 'jabatan')) {
                    $table->string('jabatan')->nullable();
                }
                if (!Schema::hasColumn('pembimbing_lapangan', 'kontak')) {
                    $table->string('kontak')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pembimbing_lapangans')) {
            Schema::table('pembimbing_lapangans', function (Blueprint $table) {
                foreach (['kontak', 'jabatan', 'nip'] as $col) {
                    if (Schema::hasColumn('pembimbing_lapangans', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('pembimbing_lapangan')) {
            Schema::table('pembimbing_lapangan', function (Blueprint $table) {
                foreach (['kontak', 'jabatan', 'nip'] as $col) {
                    if (Schema::hasColumn('pembimbing_lapangan', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
