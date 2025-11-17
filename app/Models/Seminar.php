<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = [
        'kerja_praktek_id',
        'mahasiswa_id',
        'judul_seminar',
        'abstrak',
        'tanggal_seminar',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'metode',
        'link_online',
        'ketua_penguji_id',
        'anggota_penguji_1_id',
        'anggota_penguji_2_id',
        'pembimbing_penguji_id',
        'proposal_file',
        'presentasi_file',
        'laporan_seminar_file',
        'nilai_ketua_penguji',
        'nilai_anggota_1',
        'nilai_anggota_2',
        'nilai_pembimbing',
        'nilai_akhir_seminar',
        'catatan_penilaian',
        'status',
        'lolos',
        'alasan_tidak_lolos',
        'kehadiran_penguji',
        'jumlah_peserta'
    ];

    protected $casts = [
        'tanggal_seminar' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
        'lolos' => 'boolean',
        'kehadiran_penguji' => 'array',
        'nilai_ketua_penguji' => 'decimal:2',
        'nilai_anggota_1' => 'decimal:2',
        'nilai_anggota_2' => 'decimal:2',
        'nilai_pembimbing' => 'decimal:2',
        'nilai_akhir_seminar' => 'decimal:2'
    ];

    // Relationships
    public function kerjaPraktek()
    {
        return $this->belongsTo(KerjaPraktek::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function ketuaPenguji()
    {
        return $this->belongsTo(User::class, 'ketua_penguji_id');
    }

    public function anggotaPenguji1()
    {
        return $this->belongsTo(User::class, 'anggota_penguji_1_id');
    }

    public function anggotaPenguji2()
    {
        return $this->belongsTo(User::class, 'anggota_penguji_2_id');
    }

    public function pembimbingPenguji()
    {
        return $this->belongsTo(User::class, 'pembimbing_penguji_id');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeLolos($query)
    {
        return $query->where('lolos', true);
    }

    public function scopeTidakLolos($query)
    {
        return $query->where('lolos', false);
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'dijadwalkan' => '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Dijadwalkan</span>',
            'berlangsung' => '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Berlangsung</span>',
            'selesai' => '<span class="bg-green-100 text-green-800 px-2 py-1 rounded">Selesai</span>',
            'dibatalkan' => '<span class="bg-red-100 text-red-800 px-2 py-1 rounded">Dibatalkan</span>',
            default => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded">Unknown</span>'
        };
    }

    public function getMetodeBadgeAttribute()
    {
        return match($this->metode) {
            'offline' => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded">Offline</span>',
            'online' => '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Online</span>',
            default => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded">Unknown</span>'
        };
    }

    public function getHasilBadgeAttribute()
    {
        return $this->lolos
            ? '<span class="bg-green-100 text-green-800 px-2 py-1 rounded">Lolos</span>'
            : '<span class="bg-red-100 text-red-800 px-2 py-1 rounded">Tidak Lolos</span>';
    }

    public function hitungNilaiAkhir()
    {
        $nilai = [];
        if ($this->nilai_ketua_penguji) $nilai[] = $this->nilai_ketua_penguji;
        if ($this->nilai_anggota_1) $nilai[] = $this->nilai_anggota_1;
        if ($this->nilai_anggota_2) $nilai[] = $this->nilai_anggota_2;
        if ($this->nilai_pembimbing) $nilai[] = $this->nilai_pembimbing;

        if (!empty($nilai)) {
            $this->nilai_akhir_seminar = array_sum($nilai) / count($nilai);
            $this->save();
        }
    }

    public function isEditable()
    {
        return in_array($this->status, ['dijadwalkan']);
    }

    public function canStart()
    {
        return $this->status === 'dijadwalkan' && $this->tanggal_seminar <= now()->toDateString();
    }
}
