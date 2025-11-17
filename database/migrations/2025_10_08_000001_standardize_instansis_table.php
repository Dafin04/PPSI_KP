<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Jika tabel belum ada sama sekali, buat dengan skema standar
        if (!Schema::hasTable('instansis')) {
            Schema::create('instansis', function (Blueprint $table) {
                $table->id();
                $table->string('nama_instansi');
                $table->text('alamat');
                $table->string('kontak')->nullable();
                $table->string('telepon')->nullable();
                $table->string('kontak_person')->nullable();
                $table->string('jenis_instansi')->nullable();
                $table->string('kota')->nullable();
                $table->string('provinsi')->nullable();
                $table->string('kode_pos')->nullable();
                $table->string('email')->nullable();
                $table->string('website')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
            return;
        }

        // Tambahkan kolom yang belum ada (non-destruktif)
        $addStringNullable = function (string $col) {
            if (!Schema::hasColumn('instansis', $col)) {
                Schema::table('instansis', function (Blueprint $table) use ($col) {
                    $table->string($col)->nullable();
                });
            }
        };

        foreach (['kontak','telepon','kontak_person','jenis_instansi','kota','provinsi','kode_pos','email','website'] as $col) {
            $addStringNullable($col);
        }

        // Kolom status standar
        if (!Schema::hasColumn('instansis', 'status')) {
            Schema::table('instansis', function (Blueprint $table) {
                $table->boolean('status')->default(true);
            });
            // Jika ada status_aktif sebelumnya, salin nilainya
            if (Schema::hasColumn('instansis', 'status_aktif')) {
                try {
                    DB::statement('UPDATE instansis SET status = status_aktif');
                } catch (\Throwable $e) {
                    // abaikan jika DB tidak mendukung pernyataan ini
                }
            }
        }
    }

    public function down(): void
    {
        // Tidak melakukan perubahan destruktif (aman untuk rollback)
        // Jika ingin, Anda bisa menghapus kolom tambahan di sini.
    }
};

