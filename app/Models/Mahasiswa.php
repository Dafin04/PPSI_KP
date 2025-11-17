<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        'angkatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function kuesioners()
    {
        return $this->hasMany(Kuesioner::class);
    }

    public function pendaftaranKps()
    {
        return $this->hasMany(PendaftaranKP::class);
    }
}
