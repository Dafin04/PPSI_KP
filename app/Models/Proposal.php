<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'judul',
        'file_proposal',
        // Lama: status
        'status',
        // Baru sesuai diagram
        'status_validasi',
        'tanggal_upload',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
