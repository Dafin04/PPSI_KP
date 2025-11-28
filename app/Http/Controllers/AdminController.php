<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Models\PembimbingLapangan;
use App\Models\Lowongan;
use App\Models\Kuota;
use App\Models\KerjaPraktek;
use App\Models\Seminar;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\Mahasiswa;
use App\Models\PendaftaranKP;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function ensureBaseRoles(): void
    {
        // Sinkronisasi slug lama ke baru agar konsisten
        if ($old = Role::where('slug', 'dosen-biasa')->first()) {
            $new = Role::firstOrCreate(['slug' => 'dosen'], ['name' => 'Dosen']);
            if ($old->id !== $new->id) {
                DB::table('user_roles')->where('role_id', $old->id)->update(['role_id' => $new->id]);
                $old->delete();
            }
        }
        if ($old = Role::where('slug', 'pembimbing-lapangan')->first()) {
            $new = Role::firstOrCreate(['slug' => 'pembimbing_lapangan'], ['name' => 'Pembimbing Lapangan']);
            if ($old->id !== $new->id) {
                DB::table('user_roles')->where('role_id', $old->id)->update(['role_id' => $new->id]);
                $old->delete();
            }
        }

        // Gunakan slug yang konsisten dengan middleware/routes
        Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        Role::firstOrCreate(['slug' => 'mahasiswa'], ['name' => 'Mahasiswa']);
        Role::firstOrCreate(['slug' => 'dosen'], ['name' => 'Dosen']);
        Role::firstOrCreate(['slug' => 'pembimbing_lapangan'], ['name' => 'Pembimbing Lapangan']);
    }
    private function instansiStatusColumn(): string
    {
        if (Schema::hasColumn('instansis', 'status')) return 'status';
        if (Schema::hasColumn('instansis', 'status_aktif')) return 'status_aktif';
        return 'status';
    }

    private function instansiKontakColumn(): ?string
    {
        if (Schema::hasColumn('instansis', 'kontak')) return 'kontak';
        if (Schema::hasColumn('instansis', 'telepon')) return 'telepon';
        if (Schema::hasColumn('instansis', 'kontak_person')) return 'kontak_person';
        return null;
    }

    private function buildInstansiPayload(Request $request): array
    {
        $columns = Schema::getColumnListing('instansis');

        $mapping = [
            'nama_instansi' => ['nama_instansi'],
            'alamat' => ['alamat'],
            'kontak' => ['kontak','telepon','kontak_person'],
            'jenis_instansi' => ['jenis_instansi'],
            'kota' => ['kota'],
            'provinsi' => ['provinsi'],
            'kode_pos' => ['kode_pos'],
            'email' => ['email'],
            'website' => ['website'],
        ];

        $data = [];

        // Nama + alamat wajib
        $data['nama_instansi'] = $request->input('nama_instansi');
        $data['alamat'] = $request->input('alamat');

        foreach ($mapping as $input => $candidates) {
            $col = collect($candidates)->first(fn($c) => in_array($c, $columns, true));
            if (!$col) continue;
            $val = $request->input($input);
            if ($val === null) {
                // Untuk kolom non-null di skema lama, kirim string kosong agar insert tidak gagal
                $val = '';
            }
            $data[$col] = $val;
        }

        // Status
        $statusCol = $this->instansiStatusColumn();
        if (in_array($statusCol, $columns, true)) {
            $data[$statusCol] = (bool) $request->boolean('status', true);
        }

        return $data;
    }
    public function dashboard()
    {
        $this->ensureBaseRoles();
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $roleStats = Role::withCount('users')->get();
        $totalLowongan = Lowongan::count();
        $activeLowongan = Lowongan::where('status_aktif', true)->count();

        $totalInstansi = Instansi::count();
        // Fallback untuk kompatibilitas kolom lama (status_aktif)
        if (Schema::hasColumn('instansis', 'status')) {
            $activeInstansi = Instansi::where('status', true)->count();
        } elseif (Schema::hasColumn('instansis', 'status_aktif')) {
            $activeInstansi = Instansi::where('status_aktif', true)->count();
        } else {
            $activeInstansi = 0;
        }

        $totalKP = KerjaPraktek::count();
        $activeKP = KerjaPraktek::aktif()->count();

        // Tambahan untuk tampilan ala admin modern
        $recentUsers = User::with('roles')->latest()->take(5)->get();
        $kpByStatus = KerjaPraktek::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->pluck('total','status');

        // Top instansi berdasarkan jumlah KP
        $instansiTop = DB::table('kerja_prakteks')
            ->join('instansis','instansis.id','=','kerja_prakteks.instansi_id')
            ->select('instansis.nama_instansi as nama', DB::raw('count(*) as total'))
            ->whereNotNull('kerja_prakteks.instansi_id')
            ->groupBy('instansis.nama_instansi')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // KPI tambahan untuk kartu statistik utama
        $mhsAktifKP = KerjaPraktek::whereIn('status', ['disetujui','berlangsung'])
            ->distinct('mahasiswa_id')->count('mahasiswa_id');
        $instansiTerdaftar = $totalInstansi;
        $dosenPembimbingCount = User::whereHas('roles', function ($q) {
            $q->whereIn('slug', ['dosen']);
        })->count();
        $laporanMasuk = DB::table('kerja_prakteks')->whereNotNull('laporan_akhir_file')->count();

        // Tren mahasiswa KP per bulan (8 bulan terakhir)
        $start = now()->subMonths(7)->startOfMonth();
        $trendMonths = [];
        $trendCounts = [];
        for ($i=0; $i<8; $i++) {
            $month = $start->copy()->addMonths($i);
            $trendMonths[] = $month->format('M Y');
            $trendCounts[] = KerjaPraktek::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Aktivitas terbaru sederhana (pendaftaran KP terakhir)
        $kpTerbaru = KerjaPraktek::with('mahasiswa')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRoles',
            'roleStats',
            'totalLowongan',
            'activeLowongan',
            'totalInstansi',
            'activeInstansi',
            'totalKP',
            'activeKP',
            'recentUsers',
            'kpByStatus',
            'instansiTop',
            'mhsAktifKP',
            'instansiTerdaftar',
            'dosenPembimbingCount',
            'laporanMasuk',
            'trendMonths',
            'trendCounts',
            'kpTerbaru'
        ));
    }

    // CRUD User
    public function indexUsers()
    {
        $this->ensureBaseRoles();
        $users = User::with('roles')->paginate(15);
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,mahasiswa,dosen,pembimbing_lapangan',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users')->with('success', 'User berhasil dibuat.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,mahasiswa,dosen,pembimbing_lapangan',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        // Update roles
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    public function assignRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->assignRoleById((int) $validated['role_id']);

        return redirect()->route('admin.users')->with('success', 'Role pengguna berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    // CRUD Instansi
    public function indexInstansi(Request $request)
    {
        $query = Instansi::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_instansi', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%")
                  ->orWhere('kontak_person', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('provinsi', 'like', "%{$search}%");
            });
        }

        $instansis = $query->orderBy('nama_instansi')->paginate(15)->withQueryString();
        return view('admin.instansi.index', compact('instansis'));
    }

    public function createInstansi()
    {
        $pembimbingLapangans = PembimbingLapangan::with('user')->orderBy('id')->get();
        return view('admin.instansi.create', compact('pembimbingLapangans'));
    }

    public function storeInstansi(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:255',
            'jenis_instansi' => 'sometimes|string|nullable',
            'kota' => 'sometimes|string|nullable',
            'provinsi' => 'sometimes|string|nullable',
            'kode_pos' => 'sometimes|string|nullable',
            'email' => 'sometimes|email|nullable',
            'website' => 'sometimes|url|nullable',
            'status' => 'boolean',
            'pembimbing_lapangan_ids' => 'nullable|array',
            'pembimbing_lapangan_ids.*' => 'exists:pembimbing_lapangans,id',
        ]);
        $data = $this->buildInstansiPayload($request);
        $instansi = Instansi::create($data);

        $ids = collect($validated['pembimbing_lapangan_ids'] ?? [])->map(fn($id) => (int) $id)->all();
        if (!empty($ids)) {
            PembimbingLapangan::whereIn('id', $ids)->update(['instansi_id' => $instansi->id]);
        }

        return redirect()->route('admin.instansi.index')->with('success', 'Instansi berhasil dibuat.');
    }

    public function editInstansi(Instansi $instansi)
    {
        $pembimbingLapangans = PembimbingLapangan::with('user')->orderBy('id')->get();
        $selectedPembimbingIds = $instansi->pembimbingLapangans()->pluck('id')->toArray();

        return view('admin.instansi.edit', compact('instansi', 'pembimbingLapangans', 'selectedPembimbingIds'));
    }

    public function updateInstansi(Request $request, Instansi $instansi)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:255',
            'jenis_instansi' => 'sometimes|string|nullable',
            'kota' => 'sometimes|string|nullable',
            'provinsi' => 'sometimes|string|nullable',
            'kode_pos' => 'sometimes|string|nullable',
            'email' => 'sometimes|email|nullable',
            'website' => 'sometimes|url|nullable',
            'status' => 'boolean',
            'pembimbing_lapangan_ids' => 'nullable|array',
            'pembimbing_lapangan_ids.*' => 'exists:pembimbing_lapangans,id',
        ]);
        $data = $this->buildInstansiPayload($request);
        $instansi->update($data);

        $ids = collect($validated['pembimbing_lapangan_ids'] ?? [])->map(fn($id) => (int) $id)->all();
        // Lepas PL yang tidak dipilih
        $instansi->pembimbingLapangans()->whereNotIn('id', $ids)->update(['instansi_id' => null]);
        // Pasang PL yang dipilih
        if (!empty($ids)) {
            PembimbingLapangan::whereIn('id', $ids)->update(['instansi_id' => $instansi->id]);
        }

        return redirect()->route('admin.instansi.index')->with('success', 'Instansi berhasil diperbarui.');
    }

    public function destroyInstansi(Instansi $instansi)
    {
        $instansi->delete();
        return redirect()->route('admin.instansi.index')->with('success', 'Instansi berhasil dihapus.');
    }

    // Verifikasi instansi usulan
    public function verifyInstansi(Instansi $instansi)
    {
        DB::transaction(function () use ($instansi) {
            $instansi->status_verifikasi = 'disetujui';
            if (Schema::hasColumn('instansis','status')) $instansi->status = true;
            if (Schema::hasColumn('instansis','status_aktif')) $instansi->status_aktif = true;
            $instansi->save();

            $this->syncPengusulKerjaPraktek($instansi, true);
        });

        return back()->with('success','Instansi disetujui dan KP mahasiswa siap dialokasikan.');
    }

    public function rejectInstansi(Instansi $instansi)
    {
        DB::transaction(function () use ($instansi) {
            $instansi->status_verifikasi = 'ditolak';
            if (Schema::hasColumn('instansis','status')) $instansi->status = false;
            if (Schema::hasColumn('instansis','status_aktif')) $instansi->status_aktif = false;
            $instansi->save();

            $this->syncPengusulKerjaPraktek($instansi, false);
        });

        return back()->with('success','Instansi ditolak.');
    }

    // CRUD LowonganKP
    public function indexLowongan()
    {
        $lowongans = Lowongan::with('instansi')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function createLowongan()
    {
        $instansis = Instansi::all();
        return view('admin.lowongan.create', compact('instansis'));
    }

    public function storeLowongan(Request $request)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'judul_lowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kebutuhan_keahlian' => 'nullable|string',
            'jumlah_kuota' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        Lowongan::create($validated);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan KP berhasil dibuat.');
    }

    public function editLowongan(Lowongan $lowongan)
    {
        $instansis = Instansi::all();
        return view('admin.lowongan.edit', compact('lowongan', 'instansis'));
    }

    private function syncPengusulKerjaPraktek(Instansi $instansi, bool $approved): void
    {
        if (!$instansi->pengusul_mahasiswa_id) {
            return;
        }

        $mahasiswa = Mahasiswa::with('user')->find($instansi->pengusul_mahasiswa_id);
        if (!$mahasiswa || !$mahasiswa->user) {
            return;
        }

        $startDate = now();
        $kerjaPraktek = KerjaPraktek::firstOrCreate(
            [
                'mahasiswa_id' => $mahasiswa->user_id,
                'instansi_id' => $instansi->id,
            ],
            [
                'judul_kp' => 'Kerja Praktek ' . $instansi->nama_instansi,
                'deskripsi_kp' => 'Dibuat otomatis dari usulan instansi.',
                'status' => 'diajukan',
                'tanggal_mulai' => $startDate,
                'tanggal_selesai' => $startDate->copy()->addWeeks(8),
                'durasi_minggu' => 8,
                'pilihan_1' => $instansi->nama_instansi,
                'instansi_diterima' => $instansi->nama_instansi,
                'proposal_file' => $instansi->proposal_file_path,
            ]
        );

        if ($approved) {
            $kerjaPraktek->update([
                'status' => 'berlangsung',
                'instansi_diterima' => $instansi->nama_instansi,
            ]);
            $kerjaPraktek->updateProgress('kp_dimulai');
            $pendaftaranStatus = PendaftaranKP::STATUS_SEDANG_KP;
        } else {
            $kerjaPraktek->update([
                'status' => 'ditolak',
            ]);
            $pendaftaranStatus = PendaftaranKP::STATUS_DITOLAK;
        }

        PendaftaranKP::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswa->id,
                'kerja_praktek_id' => $kerjaPraktek->id,
            ],
            [
                'status' => $pendaftaranStatus,
                'tanggal_daftar' => now(),
                'jenis' => 'instansi',
            ]
        );
    }

    public function updateLowongan(Request $request, Lowongan $lowongan)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'judul_lowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kebutuhan_keahlian' => 'nullable|string',
            'jumlah_kuota' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        $lowongan->update($validated);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan KP berhasil diperbarui.');
    }

    public function destroyLowongan(Lowongan $lowongan)
    {
        $lowongan->delete();
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan KP berhasil dihapus.');
    }

    // CRUD Kuota
    public function indexKuota()
    {
        $kuotas = Kuota::all();
        return view('admin.kuota.index', compact('kuotas'));
    }

    public function createKuota()
    {
        $instansis = Instansi::all();
        return view('admin.kuota.create', compact('instansis'));
    }

    public function storeKuota(Request $request)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        Kuota::create($validated);

        return redirect()->route('admin.kuota.index')->with('success', 'Kuota berhasil dibuat.');
    }

    public function editKuota(Kuota $kuota)
    {
        $instansis = Instansi::all();
        return view('admin.kuota.edit', compact('kuota', 'instansis'));
    }

    public function updateKuota(Request $request, Kuota $kuota)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        $kuota->update($validated);

        return redirect()->route('admin.kuota.index')->with('success', 'Kuota berhasil diperbarui.');
    }

    public function destroyKuota(Kuota $kuota)
    {
        $kuota->delete();
        return redirect()->route('admin.kuota.index')->with('success', 'Kuota berhasil dihapus.');
    }

    // Alokasi Dosen Pembimbing
    public function alokasiPembimbing(Request $request)
    {
        $query = KerjaPraktek::with(['mahasiswa.mahasiswa', 'dosenPembimbing', 'instansi']);

        if ($request->filled('instansi_id')) {
            $query->where('instansi_id', $request->instansi_id);
        }

        if ($request->get('sort') === 'ipk') {
            $query->leftJoin('mahasiswas', 'mahasiswas.user_id', '=', 'kerja_prakteks.mahasiswa_id')
                ->select('kerja_prakteks.*', 'mahasiswas.ipk as mahasiswa_ipk')
                ->orderByDesc('mahasiswas.ipk');
        } else {
            $query->orderBy('kerja_prakteks.created_at', 'desc');
        }

        $kps = $query->paginate(15)->withQueryString();
        $dosens = User::where('status_aktif', true)
            ->whereHas('roles', function ($q) {
                $q->whereIn('slug', ['dosen']);
            })
            ->orderBy('name')
            ->get();

        $instansis = Instansi::orderBy('nama_instansi')->get();
        $filters = [
            'instansi_id' => $request->input('instansi_id'),
            'sort' => $request->input('sort'),
        ];

        return view('admin.alokasi.pembimbing', compact('kps', 'dosens', 'instansis', 'filters'));
    }

    public function setPembimbing(Request $request, KerjaPraktek $kerjaPraktek)
    {
        $validated = $request->validate([
            'dosen_pembimbing_id' => 'required|exists:users,id',
        ]);

        $kerjaPraktek->update(['dosen_pembimbing_id' => $validated['dosen_pembimbing_id']]);

        // Jika KP masih diajukan, anggap penetapan pembimbing sebagai persetujuan
        if ($kerjaPraktek->status === 'diajukan') {
            $kerjaPraktek->update(['status' => 'berlangsung']);
            $kerjaPraktek->updateProgress('kp_dimulai');
        }

        // Sinkronkan juga proposal mahasiswa tersebut agar terindeks di dashboard dosen
        $mahasiswaUserId = $kerjaPraktek->mahasiswa_id; // user.id milik mahasiswa
        $mhs = \App\Models\Mahasiswa::where('user_id', $mahasiswaUserId)->first();
        if (!$mhs) {
            $mhs = \App\Models\Mahasiswa::create([
                'user_id' => $mahasiswaUserId,
                'nim' => '',
                'prodi' => '',
                'angkatan' => (int) now()->format('Y')
            ]);
        }
            if ($mhs) {
                // Set dosen_id untuk semua proposal mahasiswa tsb
                Proposal::where('mahasiswa_id', $mhs->id)
                    ->update(['dosen_id' => (int) $validated['dosen_pembimbing_id']]);

                // Jika mahasiswa belum punya proposal sama sekali, buat draft dari data KP
                if (!Proposal::where('mahasiswa_id', $mhs->id)->exists()) {
                    Proposal::create([
                        'mahasiswa_id' => $mhs->id,
                        'dosen_id' => (int) $validated['dosen_pembimbing_id'],
                        'judul' => $kerjaPraktek->judul_kp ?? 'Judul KP',
                        'file_proposal' => '',
                        'status' => 'diajukan',
                        'status_validasi' => 'diajukan',
                        'tanggal_upload' => now(),
                        'periode_id' => $kerjaPraktek->periode_id,
                    ]);
                }
            }

        return back()->with('success', 'Dosen pembimbing berhasil dialokasikan.');
    }

    // Alokasi Penguji Seminar
    public function alokasiPenguji()
    {
        $seminars = Seminar::with(['mahasiswa', 'kerjaPraktek'])
            ->orderBy('tanggal_seminar', 'desc')
            ->paginate(15);
        $dosens = User::where('status_aktif', true)
            ->whereHas('roles', function ($q) {
                $q->whereIn('slug', ['dosen']);
            })
            ->orderBy('name')
            ->get();

        return view('admin.alokasi.penguji', compact('seminars', 'dosens'));
    }

    public function setPenguji(Request $request, Seminar $seminar)
    {
        $validated = $request->validate([
            'ketua_penguji_id' => 'nullable|exists:users,id',
            'anggota_penguji_1_id' => 'nullable|exists:users,id',
            'anggota_penguji_2_id' => 'nullable|exists:users,id',
            'pembimbing_penguji_id' => 'nullable|exists:users,id',
        ]);

        $selected = collect($validated)->filter();
        if ($selected->duplicates()->isNotEmpty()) {
            return back()->with('error', 'Setiap dosen penguji harus unik.');
        }

        $pembimbingId = optional($seminar->kerjaPraktek)->dosen_pembimbing_id;
        if ($pembimbingId && $selected->contains($pembimbingId)) {
            return back()->with('error', 'Dosen pembimbing tidak boleh menjadi penguji.');
        }

        $seminar->update($validated);

        return back()->with('success', 'Penguji seminar berhasil diperbarui.');
    }

    // Kuesioner Pembimbing Lapangan (instansi)
    public function kuesionerInstansi()
    {
        $kuesioners = \App\Models\Kuesioner::with('pembimbingLapangan')
            ->where('tipe', 'instansi')
            ->latest()
            ->get();

        return view('admin.kuesioner.index', compact('kuesioners'));
    }

    public function approveAllKerjaPraktek()
    {
        $kps = KerjaPraktek::where('status', 'diajukan')->get();

        foreach ($kps as $kp) {
            $kp->update(['status' => 'berlangsung']);
            $kp->updateProgress('kp_dimulai');
        }

        return back()->with('success', 'Seluruh pengajuan KP sudah disetujui dan otomatis dimulai.');
    }

    public function tetapkanHasil(Request $request, KerjaPraktek $kerjaPraktek)
    {
        $validated = $request->validate([
            'hasil_akhir' => 'required|in:lulus,tidak_lulus',
        ]);

        $kerjaPraktek->tetapkanHasilAkhir($validated['hasil_akhir']);

        return back()->with('success', 'Hasil akhir KP berhasil diperbarui.');
    }

    // Monitoring & Laporan
    public function monitoring()
    {
        $periodeQuery = KerjaPraktek::periodeAktif();

        $totalMahasiswa = User::whereHas('roles', fn($q) => $q->where('slug', 'mahasiswa'))->count();
        $totalDosen = User::whereHas('roles', fn($q) => $q->whereIn('slug', ['dosen']))->count();
        $kpByStatus = (clone $periodeQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->pluck('total','status');
        $totalKP = (clone $periodeQuery)->count();
        $kpSelesai = (clone $periodeQuery)->where('status','selesai')->count();
        $kpBerlangsung = (clone $periodeQuery)->where('status','berlangsung')->count();

        $aktifKpIds = (clone $periodeQuery)->pluck('id');
        $bimbinganCount = DB::table('bimbingans')
            ->whereIn('kerja_praktek_id', $aktifKpIds)
            ->count();

        $instansiTop = (clone $periodeQuery)
            ->select('instansi_id', DB::raw('count(*) as total'))
            ->whereNotNull('instansi_id')
            ->groupBy('instansi_id')
            ->orderByDesc('total')
            ->with('instansi')
            ->take(5)
            ->get();

        return view('admin.monitoring.index', compact(
            'totalMahasiswa','totalDosen','totalKP','kpByStatus','kpSelesai','kpBerlangsung','bimbinganCount','instansiTop'
        ));
    }
}

