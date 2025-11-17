<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'nip',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'jurusan',
        'fakultas',
        'angkatan',
        'semester',
        'ipk',
        'foto_profil',
        'status_aktif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'ipk' => 'decimal:2',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi many-to-many dengan Role
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Assign role ke user
     */
    public function assignRole(string $roleSlug): void
    {
        $normalized = $this->normalizeRoleSlug($roleSlug);
        $role = Role::where('slug', $normalized)->first();

        if ($role) {
            // Pastikan hanya satu role yang aktif
            $this->roles()->sync([$role->id]);

            // Sinkronkan juga kolom enum users.role agar konsisten dengan middleware/routing lama
            $this->role = $this->toUserRoleEnum($normalized);
            $this->save();
        }
    }

    /**
     * Assign role berdasarkan ID role
     */
    public function assignRoleById(int $roleId): void
    {
        $role = Role::find($roleId);
        if ($role) {
            $this->roles()->sync([$role->id]);
            $this->role = $this->toUserRoleEnum($this->normalizeRoleSlug($role->slug));
            $this->save();
        }
    }

    private function normalizeRoleSlug(string $slug): string
    {
        // Konsolidasikan penamaan agar seragam di seluruh aplikasi
        return match ($slug) {
            'dosen-biasa', 'dosen' => 'dosen',
            'pembimbing-lapangan', 'pembimbing_lapangan' => 'pembimbing_lapangan',
            default => $slug,
        };
    }

    private function toUserRoleEnum(string $normalizedSlug): string
    {
        // Nilai yang valid di kolom users.role (enum)
        return match ($normalizedSlug) {
            'admin' => 'admin',
            'mahasiswa' => 'mahasiswa',
            'dosen' => 'dosen',
            'pembimbing_lapangan' => 'pembimbing_lapangan',
            default => 'mahasiswa',
        };
    }

    /**
     * Mengecek apakah user memiliki role tertentu
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    /**
     * Mengecek apakah user memiliki salah satu dari beberapa role
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    /**
     * Mendapatkan role utama user (role pertama)
     */
    public function getPrimaryRole(): ?Role
    {
        return $this->roles()->first();
    }

    /**
     * Mendapatkan nama role utama dalam bahasa Indonesia
     */
    public function getRoleNameAttribute(): string
    {
        $primaryRole = $this->getPrimaryRole();
        return $primaryRole ? $primaryRole->name : 'Tidak ada role';
    }

    /**
     * Profil Mahasiswa terkait user (jika ada)
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    /**
     * KP sebagai mahasiswa
     */
    public function kerjaPrakteks()
    {
        return $this->hasMany(KerjaPraktek::class, 'mahasiswa_id');
    }

    /**
     * KP sebagai dosen pembimbing
     */
    public function kerjaPrakteksSebagaiPembimbing()
    {
        return $this->hasMany(KerjaPraktek::class, 'dosen_pembimbing_id');
    }

    /**
     * KP sebagai pengawas lapangan
     */
    public function kerjaPrakteksSebagaiPengawas()
    {
        return $this->hasMany(KerjaPraktek::class, 'pengawas_lapangan_id');
    }

    /**
     * Bimbingan sebagai dosen pembimbing
     */
    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'dosen_pembimbing_id');
    }

    /**
     * Bimbingan sebagai mahasiswa
     */
    public function bimbingansSebagaiMahasiswa()
    {
        return $this->hasMany(Bimbingan::class, 'mahasiswa_id');
    }

    /**
     * Seminar sebagai ketua penguji
     */
    public function seminarsSebagaiKetuaPenguji()
    {
        return $this->hasMany(Seminar::class, 'ketua_penguji_id');
    }

    /**
     * Seminar sebagai anggota penguji 1
     */
    public function seminarsSebagaiAnggota1()
    {
        return $this->hasMany(Seminar::class, 'anggota_penguji_1_id');
    }

    /**
     * Seminar sebagai anggota penguji 2
     */
    public function seminarsSebagaiAnggota2()
    {
        return $this->hasMany(Seminar::class, 'anggota_penguji_2_id');
    }

    /**
     * Seminar sebagai pembimbing penguji
     */
    public function seminarsSebagaiPembimbingPenguji()
    {
        return $this->hasMany(Seminar::class, 'pembimbing_penguji_id');
    }

    /**
     * Seminar sebagai mahasiswa
     */
    public function seminars()
    {
        return $this->hasMany(Seminar::class, 'mahasiswa_id');
    }

    /**
     * Scope untuk dosen aktif
     */
    public function scopeDosenAktif($query)
    {
        return $query->where('status_aktif', true)
            ->whereHas('roles', function ($q) {
                $q->whereIn('slug', ['dosen', 'admin']);
            });
    }
}
