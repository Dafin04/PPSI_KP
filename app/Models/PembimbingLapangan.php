<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembimbingLapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instansi',
        'instansi_id',
        'nip',
        'jabatan',
        'kontak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
