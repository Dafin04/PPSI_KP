<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Bimbingan extends Model
{
    use HasFactory;

    // Gabungkan kemungkinan kolom dari dua skema yang berbeda
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'dosen_pembimbing_id',
        'kerja_praktek_id',
        'catatan',
        'topik_bimbingan',
        'hasil_bimbingan',
        'waktu_bimbingan',
        'metode',
        'durasi_menit',
        'status',
        'tanggal',
        'tanggal_bimbingan',
        'file_lampiran',
        'rating_kualitas',
        'feedback_mahasiswa',
        'feedback_dosen',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_bimbingan' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        // Skema lama: dosen_id, skema baru: dosen_pembimbing_id
        $fk = Schema::hasColumn($this->getTable(), 'dosen_id') ? 'dosen_id' : 'dosen_pembimbing_id';
        return $this->belongsTo(User::class, $fk);
    }

    public function dosenPembimbingUser()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }
}
