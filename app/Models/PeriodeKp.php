<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeKp extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'tgl_mulai_pendaftaran',
        'tgl_selesai_pendaftaran',
        'status',
        'keterangan',
    ];

    public static function activeId(): ?int
    {
        return static::where('status', 'Aktif')->latest()->value('id');
    }
}
