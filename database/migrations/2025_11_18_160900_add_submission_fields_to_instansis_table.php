<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instansis', function (Blueprint $table) {
            if (!Schema::hasColumn('instansis', 'pengusul_mahasiswa_id')) {
                $table->foreignId('pengusul_mahasiswa_id')
                    ->nullable()
                    ->constrained('mahasiswas')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('instansis', 'proposal_file_path')) {
                $table->string('proposal_file_path')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('instansis', function (Blueprint $table) {
            if (Schema::hasColumn('instansis', 'pengusul_mahasiswa_id')) {
                $table->dropForeign(['pengusul_mahasiswa_id']);
                $table->dropColumn('pengusul_mahasiswa_id');
            }

            if (Schema::hasColumn('instansis', 'proposal_file_path')) {
                $table->dropColumn('proposal_file_path');
            }
        });
    }
};
