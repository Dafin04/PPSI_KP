<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'pembimbing_lapangan_id',
        'nilai_pembimbing',
        'nilai_lapangan',
        'nilai_seminar',
        'total_nilai',
        'nilai_pembimbing_huruf',
        'nilai_lapangan_huruf',
        'nilai_seminar_huruf',
        'nilai_mutu',
    ];

    protected $casts = [
        'nilai_pembimbing' => 'decimal:2',
        'nilai_lapangan' => 'decimal:2',
        'nilai_seminar' => 'decimal:2',
        'total_nilai' => 'decimal:2',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function pembimbingLapangan()
    {
        return $this->belongsTo(User::class, 'pembimbing_lapangan_id');
    }

    public static function konversiHuruf(?float $nilai): ?string
    {
        if ($nilai === null) {
            return null;
        }

        return match (true) {
            $nilai >= 85 => 'A',
            $nilai >= 75 => 'B',
            $nilai >= 65 => 'C',
            default => 'D',
        };
    }

    public function getNilaiHurufAttribute(): ?string
    {
        if ($this->nilai_mutu) {
            return $this->nilai_mutu;
        }

        return self::konversiHuruf($this->total_nilai);
    }
}
