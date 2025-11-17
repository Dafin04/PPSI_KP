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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('email');
            $table->string('nip')->nullable()->after('nim');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nip');
            $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('no_telepon')->nullable()->after('alamat');
            $table->string('jurusan')->nullable()->after('no_telepon');
            $table->string('fakultas')->nullable()->after('jurusan');
            $table->string('angkatan')->nullable()->after('fakultas');
            $table->integer('semester')->nullable()->after('angkatan');
            $table->decimal('ipk', 3, 2)->nullable()->after('semester');
            $table->string('foto_profil')->nullable()->after('ipk');
            $table->boolean('status_aktif')->default(true)->after('foto_profil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nim', 'nip', 'jenis_kelamin', 'tanggal_lahir', 'alamat',
                'no_telepon', 'jurusan', 'fakultas', 'angkatan', 'semester',
                'ipk', 'foto_profil', 'status_aktif'
            ]);
        });
    }
};
