<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lowongan extends Model
{
    protected $fillable = [
        'instansi_id',
        'judul_lowongan',
        'deskripsi',
        'kebutuhan_keahlian',
        'jumlah_kuota',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status_aktif' => 'boolean',
    ];

    /**
     * Relasi dengan Instansi
     */
    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    /**
     * Scope untuk lowongan aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true)
                    ->where('tanggal_selesai', '>=', now());
    }
}
