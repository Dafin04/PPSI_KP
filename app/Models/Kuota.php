<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'instansi_id',
        'tahun',
        'jumlah',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'jumlah' => 'integer',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
