<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'file_laporan',
        // Lama
        'status',
        // Baru
        'tanggal_upload',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
