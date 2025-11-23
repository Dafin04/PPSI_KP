<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama tabel utama yang dipakai model: pembimbing_lapangans
        Schema::table('pembimbing_lapangans', function (Blueprint $table) {
            if (!Schema::hasColumn('pembimbing_lapangans', 'instansi_id')) {
                $table->foreignId('instansi_id')
                    ->nullable()
                    ->constrained('instansis')
                    ->nullOnDelete();
            }
        });

        // Tabel lama (jika masih dipakai di env tertentu)
        if (Schema::hasTable('pembimbing_lapangan')) {
            Schema::table('pembimbing_lapangan', function (Blueprint $table) {
                if (!Schema::hasColumn('pembimbing_lapangan', 'instansi_id')) {
                    $table->foreignId('instansi_id')
                        ->nullable()
                        ->constrained('instansis')
                        ->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('pembimbing_lapangans', function (Blueprint $table) {
            if (Schema::hasColumn('pembimbing_lapangans', 'instansi_id')) {
                $table->dropForeign(['instansi_id']);
                $table->dropColumn('instansi_id');
            }
        });

        if (Schema::hasTable('pembimbing_lapangan')) {
            Schema::table('pembimbing_lapangan', function (Blueprint $table) {
                if (Schema::hasColumn('pembimbing_lapangan', 'instansi_id')) {
                    $table->dropForeign(['instansi_id']);
                    $table->dropColumn('instansi_id');
                }
            });
        }
    }
};
