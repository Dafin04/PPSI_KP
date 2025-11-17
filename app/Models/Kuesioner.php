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
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pembimbingLapangan()
    {
        return $this->belongsTo(User::class, 'pembimbing_lapangan_id');
    }
}
