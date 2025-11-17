<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // proposals: status_validasi + tanggal_upload
        if (Schema::hasTable('proposals')) {
            Schema::table('proposals', function (Blueprint $table) {
                if (!Schema::hasColumn('proposals', 'status_validasi')) {
                    $table->string('status_validasi')->nullable()->after('status');
                }
                if (!Schema::hasColumn('proposals', 'tanggal_upload')) {
                    $table->date('tanggal_upload')->nullable()->after('status_validasi');
                }
            });
        }

        // laporans: tanggal_upload + status_verifikasi
        if (Schema::hasTable('laporans')) {
            Schema::table('laporans', function (Blueprint $table) {
                if (!Schema::hasColumn('laporans', 'tanggal_upload')) {
                    $table->date('tanggal_upload')->nullable()->after('status');
                }
                if (!Schema::hasColumn('laporans', 'status_verifikasi')) {
                    $table->string('status_verifikasi')->nullable()->after('tanggal_upload');
                }
            });
        }

        // kuesioners: jenis, pertanyaan, jawaban, status
        if (Schema::hasTable('kuesioners')) {
            Schema::table('kuesioners', function (Blueprint $table) {
                if (!Schema::hasColumn('kuesioners', 'jenis')) {
                    $table->string('jenis')->nullable()->after('tipe');
                }
                if (!Schema::hasColumn('kuesioners', 'pertanyaan')) {
                    $table->text('pertanyaan')->nullable()->after('jenis');
                }
                if (!Schema::hasColumn('kuesioners', 'jawaban')) {
                    $table->text('jawaban')->nullable()->after('pertanyaan');
                }
                if (!Schema::hasColumn('kuesioners', 'status')) {
                    $table->string('status')->nullable()->after('jawaban');
                }
            });
        }

        // instansis: status_verifikasi
        if (Schema::hasTable('instansis')) {
            Schema::table('instansis', function (Blueprint $table) {
                if (!Schema::hasColumn('instansis', 'status_verifikasi')) {
                    // Tambahkan tanpa asumsi posisi kolom sebelumnya
                    $table->string('status_verifikasi')->nullable();
                }
            });
        }

        // pembimbing_lapangans
        if (!Schema::hasTable('pembimbing_lapangans')) {
            Schema::create('pembimbing_lapangans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('instansi')->nullable();
                $table->timestamps();
            });
        }

        // pendaftaran_kps
        if (!Schema::hasTable('pendaftaran_kps')) {
            Schema::create('pendaftaran_kps', function (Blueprint $table) {
                $table->id();
                $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
                $table->foreignId('kerja_praktek_id')->nullable()->constrained('kerja_prakteks')->nullOnDelete();
                $table->string('jenis')->nullable();
                $table->date('tanggal_daftar')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Tidak menghapus tabel karena bisa ada data produksi
        if (Schema::hasTable('pendaftaran_kps')) {
            Schema::dropIfExists('pendaftaran_kps');
        }
        if (Schema::hasTable('pembimbing_lapangans')) {
            Schema::dropIfExists('pembimbing_lapangans');
        }
        if (Schema::hasTable('instansis')) {
            Schema::table('instansis', function (Blueprint $table) {
                if (Schema::hasColumn('instansis', 'status_verifikasi')) {
                    $table->dropColumn('status_verifikasi');
                }
            });
        }
        if (Schema::hasTable('kuesioners')) {
            Schema::table('kuesioners', function (Blueprint $table) {
                foreach (['jenis','pertanyaan','jawaban','status'] as $col) {
                    if (Schema::hasColumn('kuesioners', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
        if (Schema::hasTable('laporans')) {
            Schema::table('laporans', function (Blueprint $table) {
                foreach (['tanggal_upload','status_verifikasi'] as $col) {
                    if (Schema::hasColumn('laporans', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
        if (Schema::hasTable('proposals')) {
            Schema::table('proposals', function (Blueprint $table) {
                foreach (['status_validasi','tanggal_upload'] as $col) {
                    if (Schema::hasColumn('proposals', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
