<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'pembimbing_lapangan_id',
        // Kolom lama (kompatibilitas)
        'isi_kuesioner',
        'tipe',
        // Kolom baru agar sesuai diagram
        'jenis',
        'pertanyaan',
        'jawaban',
        'status',
        'kuota_tahun_depan',
        'saran_kegiatan',
        'kebutuhan_skill',
        'tingkat_kepuasan',
        'sertifikat_path',
        'sertifikat_dibuat_pada',
    ];

    protected $casts = [
        'kuota_tahun_depan' => 'integer',
        'sertifikat_dibuat_pada' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pembimbingLapangan()
    {
        return $this->belongsTo(User::class, 'pembimbing_lapangan_id');
    }

    public function hasCertificate(): bool
    {
        return !empty($this->sertifikat_path);
    }
}
