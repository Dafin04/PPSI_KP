<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'jabatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
