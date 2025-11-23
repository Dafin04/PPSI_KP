<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Instansi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_instansi',
        'alamat',
        'kontak',
        'telepon',
        'kontak_person',
        'jenis_instansi',
        'kota',
        'provinsi',
        'kode_pos',
        'email',
        'website',
        'status',
        'status_aktif',
        'status_verifikasi',
        'pengusul_mahasiswa_id',
        'proposal_file_path',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function lowonganKPs()
    {
        return $this->hasMany(LowonganKP::class);
    }

    public function kuotas()
    {
        return $this->hasMany(Kuota::class);
    }

    public function pembimbingLapangans()
    {
        return $this->hasMany(PembimbingLapangan::class);
    }

    // Scope untuk instansi aktif
    public function scopeAktif($query)
    {
        $table = $this->getTable();
        // Wajib: hanya instansi yang terverifikasi
        if (Schema::hasColumn($table, 'status_verifikasi')) {
            $query->where('status_verifikasi', 'disetujui');
        }
        // Aktif berdasarkan kolom status/status_aktif bila tersedia
        if (Schema::hasColumn($table, 'status')) {
            $query->where('status', true);
        } elseif (Schema::hasColumn($table, 'status_aktif')) {
            $query->where('status_aktif', true);
        }
        return $query;
    }
}
