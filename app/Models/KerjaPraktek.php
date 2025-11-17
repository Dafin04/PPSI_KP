<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KerjaPraktek extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'instansi_id',
        'dosen_pembimbing_id',
        'pengawas_lapangan_id',
        'judul_kp',
        'deskripsi_kp',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_minggu',
        'pilihan_1',
        'pilihan_2',
        'pilihan_3',
        'instansi_diterima',
        'proposal_file',
        'laporan_akhir_file',
        'lembar_pengesahan_file',
        'nilai_dosen_pembimbing',
        'nilai_pengawas_lapangan',
        'nilai_akhir',
        'catatan_nilai',
        'sudah_seminar',
        'tanggal_seminar',
        'lolos_seminar',
        'catatan_seminar',
        'jumlah_bimbingan',
        'riwayat_bimbingan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_seminar' => 'date',
        'sudah_seminar' => 'boolean',
        'lolos_seminar' => 'boolean',
        'riwayat_bimbingan' => 'array',
        'nilai_dosen_pembimbing' => 'decimal:2',
        'nilai_pengawas_lapangan' => 'decimal:2',
        'nilai_akhir' => 'decimal:2'
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }

    public function pengawasLapangan()
    {
        return $this->belongsTo(User::class, 'pengawas_lapangan_id');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['disetujui', 'berlangsung']);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeByDosen($query, $dosenId)
    {
        return $query->where('dosen_pembimbing_id', $dosenId);
    }

    public function scopeByPengawas($query, $pengawasId)
    {
        return $query->where('pengawas_lapangan_id', $pengawasId);
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'draft' => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded">Draft</span>',
            'diajukan' => '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Diajukan</span>',
            'disetujui' => '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Disetujui</span>',
            'ditolak' => '<span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>',
            'berlangsung' => '<span class="bg-green-100 text-green-800 px-2 py-1 rounded">Berlangsung</span>',
            'selesai' => '<span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">Selesai</span>',
            'gagal' => '<span class="bg-red-100 text-red-800 px-2 py-1 rounded">Gagal</span>',
            default => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded">Unknown</span>'
        };
    }

    public function isEditable()
    {
        return in_array($this->status, ['draft', 'ditolak']);
    }

    public function canUploadLaporan()
    {
        return in_array($this->status, ['berlangsung', 'selesai']);
    }

    public function hitungNilaiAkhir()
    {
        if ($this->nilai_dosen_pembimbing && $this->nilai_pengawas_lapangan) {
            $this->nilai_akhir = ($this->nilai_dosen_pembimbing * 0.6) + ($this->nilai_pengawas_lapangan * 0.4);
            $this->save();
        }
    }

    // Additional relationships
    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class);
    }

    public function seminar()
    {
        return $this->hasOne(Seminar::class);
    }
}
