<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranKP extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_kps';

    protected $fillable = [
        'mahasiswa_id',
        'kerja_praktek_id',
        'jenis',
        'tanggal_daftar',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function kerjaPraktek()
    {
        return $this->belongsTo(KerjaPraktek::class);
    }
}

