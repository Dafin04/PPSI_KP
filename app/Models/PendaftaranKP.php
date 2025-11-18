<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranKP extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_SEDANG_KP = 'sedang_kp';
    public const STATUS_DITOLAK = 'ditolak';
    public const STATUS_SELESAI = 'selesai';

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
