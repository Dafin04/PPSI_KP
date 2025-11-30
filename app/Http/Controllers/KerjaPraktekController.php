<?php

namespace App\Http\Controllers;

use App\Models\KerjaPraktek;
use App\Models\Instansi;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Proposal;
use App\Models\Mahasiswa;
use App\Models\PendaftaranKP;

class KerjaPraktekController extends Controller
{
    private const MIN_BIMBINGAN = 10;
    /**
     * Display a listing of KP registrations
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->q;

        if ($user->hasRole('admin')) {
            $query = KerjaPraktek::with(['mahasiswa', 'instansi', 'dosenPembimbing', 'pengawasLapangan'])
                ->orderBy('created_at', 'desc');
        } elseif ($user->hasRole('dosen-biasa')) {
            $query = KerjaPraktek::with(['mahasiswa', 'instansi', 'pengawasLapangan'])
                ->where('dosen_pembimbing_id', $user->id)
                ->orderBy('created_at', 'desc');
        } elseif ($user->hasRole('mahasiswa')) {
            $query = KerjaPraktek::with(['instansi', 'dosenPembimbing', 'pengawasLapangan'])
                ->where('mahasiswa_id', $user->id)
                ->orderBy('created_at', 'desc');
        } else {
            abort(403, 'Akses ditolak');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_kp', 'like', "%{$search}%")
                  ->orWhereHas('instansi', fn($i) => $i->where('nama_instansi', 'like', "%{$search}%"));
            });
        }

        $kerjaPrakteks = $query->paginate(15)->withQueryString();

        return view('kerja-praktek.index', compact('kerjaPrakteks', 'search'));
    }

    /**
     * Show the form for creating a new KP registration
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user->hasRole('mahasiswa')) {
            abort(403, 'Hanya mahasiswa yang dapat mendaftar KP');
        }

        $instansis = Instansi::aktif()->orderBy('nama_instansi')->get();
        $dosens = User::dosenAktif()->orderBy('name')->get();

        return view('kerja-praktek.create', compact('instansis', 'dosens'));
    }

    /**
     * Store a newly created KP registration
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasRole('mahasiswa')) {
            abort(403, 'Hanya mahasiswa yang dapat mendaftar KP');
        }

        // Isi otomatis pilihan_1 dari instansi terpilih jika belum ada
        if (!$request->filled('pilihan_1') && $request->filled('instansi_id')) {
            $instansiNama = Instansi::where('id', $request->instansi_id)->value('nama_instansi');
            $request->merge(['pilihan_1' => $instansiNama]);
        }

        $request->validate([
            'judul_kp' => 'required|string|max:255',
            'deskripsi_kp' => 'required|string',
            'tanggal_mulai' => 'required|date|after:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'durasi_minggu' => 'required|integer|min:4|max:16',
            'pilihan_1' => 'required|string|max:255',
            'pilihan_2' => 'nullable|string|max:255',
            'pilihan_3' => 'nullable|string|max:255',
            'dosen_pembimbing_id' => 'required|exists:users,id',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bukti_ipk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'prestasi_akademik' => 'nullable|string',
            'prestasi_non_akademik' => 'nullable|string',
            'pengalaman_si' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['mahasiswa_id'] = $user->id;
            $data['status'] = 'draft';
            $data['periode_id'] = \App\Models\PeriodeKp::activeId();

            // Handle file upload
            if ($request->hasFile('proposal_file')) {
                $file = $request->file('proposal_file');
                $filename = 'proposal_' . $user->nim . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('proposals', $filename, 'public');
                $data['proposal_file'] = $path;
            }
            if ($request->hasFile('bukti_ipk_file')) {
                $file = $request->file('bukti_ipk_file');
                $filename = 'bukti_ipk_' . $user->nim . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_ipk', $filename, 'public');
                $data['bukti_ipk_file'] = $path;
            }

            $kerjaPraktek = KerjaPraktek::create($data);
            $this->syncPendaftaran($kerjaPraktek, PendaftaranKP::STATUS_DRAFT);

            DB::commit();

            return redirect()->route('kerja-praktek.index')
                ->with('success', 'Pendaftaran KP berhasil disimpan sebagai draft');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified KP registration
     */
    public function show(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        // Check authorization
        if (!$this->canAccessKerjaPraktek($kerjaPraktek)) {
            abort(403, 'Akses ditolak');
        }

        $kerjaPraktek->load([
            'mahasiswa',
            'instansi',
            'dosenPembimbing',
            'pengawasLapangan',
            'bimbingans' => function($query) {
                $query->orderBy('tanggal_bimbingan', 'desc');
            },
            'seminar'
        ]);

        $bimbingans = $kerjaPraktek->bimbingans;
        $seminar = $kerjaPraktek->seminar;

        return view('kerja-praktek.show', compact('kerjaPraktek', 'bimbingans', 'seminar'));
    }

    /**
     * Show the form for editing the specified KP registration
     */
    public function edit(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if (!$kerjaPraktek->isEditable() || $kerjaPraktek->mahasiswa_id !== $user->id) {
            abort(403, 'Tidak dapat mengedit pendaftaran ini');
        }

        $instansis = Instansi::aktif()->orderBy('nama_instansi')->get();
        $dosens = User::dosenAktif()->orderBy('name')->get();

        return view('kerja-praktek.edit', compact('kerjaPraktek', 'instansis', 'dosens'));
    }

    /**
     * Update the specified KP registration
     */
    public function update(Request $request, KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if (!$kerjaPraktek->isEditable() || $kerjaPraktek->mahasiswa_id !== $user->id) {
            abort(403, 'Tidak dapat mengupdate pendaftaran ini');
        }

        // Isi otomatis pilihan_1 dari instansi terpilih jika belum ada
        if (!$request->filled('pilihan_1') && $request->filled('instansi_id')) {
            $instansiNama = Instansi::where('id', $request->instansi_id)->value('nama_instansi');
            $request->merge(['pilihan_1' => $instansiNama]);
        }

        $request->validate([
            'judul_kp' => 'required|string|max:255',
            'deskripsi_kp' => 'required|string',
            'tanggal_mulai' => 'required|date|after:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'durasi_minggu' => 'required|integer|min:4|max:16',
            'pilihan_1' => 'required|string|max:255',
            'pilihan_2' => 'nullable|string|max:255',
            'pilihan_3' => 'nullable|string|max:255',
            'dosen_pembimbing_id' => 'required|exists:users,id',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bukti_ipk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'prestasi_akademik' => 'nullable|string',
            'prestasi_non_akademik' => 'nullable|string',
            'pengalaman_si' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('proposal_file')) {
                // Delete old file if exists
                if ($kerjaPraktek->proposal_file) {
                    Storage::disk('public')->delete($kerjaPraktek->proposal_file);
                }

                $file = $request->file('proposal_file');
                $filename = 'proposal_' . $user->nim . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('proposals', $filename, 'public');
                $data['proposal_file'] = $path;
            }
            if ($request->hasFile('bukti_ipk_file')) {
                if ($kerjaPraktek->bukti_ipk_file) {
                    Storage::disk('public')->delete($kerjaPraktek->bukti_ipk_file);
                }
                $file = $request->file('bukti_ipk_file');
                $filename = 'bukti_ipk_' . $user->nim . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_ipk', $filename, 'public');
                $data['bukti_ipk_file'] = $path;
            }

            $kerjaPraktek->update($data);

            DB::commit();

            return redirect()->route('kerja-praktek.show', $kerjaPraktek)
                ->with('success', 'Pendaftaran KP berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Submit KP registration for approval
     */
    public function submit(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if ($kerjaPraktek->mahasiswa_id !== $user->id || $kerjaPraktek->status !== 'draft') {
            abort(403, 'Tidak dapat mengajukan pendaftaran ini');
        }

        $kerjaPraktek->update(['status' => 'diajukan']);
        $kerjaPraktek->updateProgress('menunggu');
        $this->syncPendaftaran($kerjaPraktek, PendaftaranKP::STATUS_MENUNGGU);

        // Sinkronkan proposal agar muncul di Validasi Proposal dosen pembimbing
        try {
            $mhs = Mahasiswa::where('user_id', $kerjaPraktek->mahasiswa_id)->first();
            if (!$mhs) {
                $mhs = Mahasiswa::create([
                    'user_id' => $kerjaPraktek->mahasiswa_id,
                    'nim' => '', 'prodi' => '', 'angkatan' => (int) now()->format('Y')
                ]);
            }
            $proposal = Proposal::firstOrCreate(
                [
                    'mahasiswa_id' => $mhs->id,
                    'judul' => $kerjaPraktek->judul_kp ?? 'Judul KP',
                ],
                [
                    'file_proposal' => '',
                    'status' => 'pending',
                    'status_validasi' => 'pending',
                    'tanggal_upload' => now(),
                ]
            );
            if (!$proposal->dosen_id && !empty($kerjaPraktek->dosen_pembimbing_id)) {
                $proposal->dosen_id = $kerjaPraktek->dosen_pembimbing_id;
                $proposal->save();
            }
        } catch (\Throwable $e) {
            // abaikan supaya submit tetap sukses
        }

        return redirect()->route('kerja-praktek.show', $kerjaPraktek)
            ->with('success', 'Pendaftaran KP berhasil diajukan untuk disetujui');
    }

    /**
     * Approve KP registration (Admin/Dosen)
     */
    public function approve(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) || !$this->canApproveKerjaPraktek($kerjaPraktek)) {
            abort(403, 'Tidak memiliki akses untuk menyetujui');
        }

        $kerjaPraktek->update(['status' => 'berlangsung']);
        $kerjaPraktek->updateProgress('kp_dimulai');
        $this->syncPendaftaran($kerjaPraktek, PendaftaranKP::STATUS_SEDANG_KP);

        return back()->with('success', 'Pendaftaran KP berhasil disetujui');
    }

    /**
     * Reject KP registration (Admin/Dosen)
     */
    public function reject(Request $request, KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) || !$this->canApproveKerjaPraktek($kerjaPraktek)) {
            abort(403, 'Tidak memiliki akses untuk menolak');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $kerjaPraktek->update([
            'status' => 'ditolak',
            'catatan_nilai' => $request->alasan_penolakan
        ]);
        $this->syncPendaftaran($kerjaPraktek, PendaftaranKP::STATUS_DITOLAK);

        return back()->with('success', 'Pendaftaran KP berhasil ditolak');
    }

    /**
     * Start KP (set to berlangsung)
     */
    public function start(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if (!$this->canManageKerjaPraktek($kerjaPraktek)) {
            abort(403, 'Tidak memiliki akses untuk memulai KP');
        }

        if ($kerjaPraktek->status !== 'disetujui') {
            abort(403, 'KP belum disetujui');
        }

        $kerjaPraktek->update(['status' => 'berlangsung']);
        $this->syncPendaftaran($kerjaPraktek, PendaftaranKP::STATUS_SEDANG_KP);

        return back()->with('success', 'KP berhasil dimulai');
    }

    /**
     * Complete KP (set to selesai)
     */
    public function complete(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if (!$this->canManageKerjaPraktek($kerjaPraktek)) {
            abort(403, 'Tidak memiliki akses untuk menyelesaikan KP');
        }

        if ($kerjaPraktek->status !== 'berlangsung') {
            abort(403, 'KP belum berlangsung');
        }

        $kerjaPraktek->update(['status' => 'selesai']);
        $this->syncPendaftaran($kerjaPraktek, PendaftaranKP::STATUS_SELESAI);

        return back()->with('success', 'KP berhasil diselesaikan');
    }

    /**
     * Upload final report
     */
    public function uploadLaporan(Request $request, KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        if (!$kerjaPraktek->canUploadLaporan() || $kerjaPraktek->mahasiswa_id !== $user->id) {
            abort(403, 'Tidak dapat mengupload laporan');
        }

        if (!$this->hasMetBimbinganRequirement($kerjaPraktek)) {
            abort(403, 'Lengkapi minimal ' . self::MIN_BIMBINGAN . ' bimbingan disetujui sebelum unggah laporan akhir.');
        }

        $request->validate([
            'laporan_akhir_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'lembar_pengesahan_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $data = [];

            // Upload laporan akhir
            if ($request->hasFile('laporan_akhir_file')) {
                if ($kerjaPraktek->laporan_akhir_file) {
                    Storage::disk('public')->delete($kerjaPraktek->laporan_akhir_file);
                }

                $file = $request->file('laporan_akhir_file');
                $filename = 'laporan_akhir_' . $user->nim . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('laporan_akhir', $filename, 'public');
                $data['laporan_akhir_file'] = $path;
            }

            // Upload lembar pengesahan
            if ($request->hasFile('lembar_pengesahan_file')) {
                if ($kerjaPraktek->lembar_pengesahan_file) {
                    Storage::disk('public')->delete($kerjaPraktek->lembar_pengesahan_file);
                }

                $file = $request->file('lembar_pengesahan_file');
                $filename = 'pengesahan_' . $user->nim . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pengesahan', $filename, 'public');
                $data['lembar_pengesahan_file'] = $path;
            }

            $kerjaPraktek->update($data);

            DB::commit();

            return back()->with('success', 'Laporan berhasil diupload');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat upload: ' . $e->getMessage());
        }
    }

    /**
     * Download file
     */
    public function downloadFile($type, KerjaPraktek $kerjaPraktek)
    {
        if (!$this->canAccessKerjaPraktek($kerjaPraktek)) {
            abort(403, 'Akses ditolak');
        }

        $fileField = $type . '_file';
        if (!$kerjaPraktek->$fileField) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($kerjaPraktek->$fileField);
    }

    /**
     * Helper methods
     */
    private function syncPendaftaran(KerjaPraktek $kerjaPraktek, ?string $status = null): void
    {
        $mahasiswaId = $this->resolveMahasiswaId($kerjaPraktek->mahasiswa_id);
        if (!$mahasiswaId) {
            return;
        }

        $pendaftaran = PendaftaranKP::firstOrNew([
            'mahasiswa_id' => $mahasiswaId,
            'kerja_praktek_id' => $kerjaPraktek->id,
        ]);

        if (!$pendaftaran->exists) {
            $pendaftaran->jenis = 'instansi';
            $pendaftaran->tanggal_daftar = now();
            $pendaftaran->status = $status ?? PendaftaranKP::STATUS_DRAFT;
        } elseif ($status !== null) {
            $pendaftaran->status = $status;
        }

        if (!$pendaftaran->tanggal_daftar) {
            $pendaftaran->tanggal_daftar = now();
        }

        // sinkron data pendukung
        $pendaftaran->bukti_ipk_file = $kerjaPraktek->bukti_ipk_file;
        $pendaftaran->prestasi_akademik = $kerjaPraktek->prestasi_akademik;
        $pendaftaran->prestasi_non_akademik = $kerjaPraktek->prestasi_non_akademik;
        $pendaftaran->pengalaman_si = $kerjaPraktek->pengalaman_si;

        $pendaftaran->save();
    }

    private function resolveMahasiswaId(int $userId): ?int
    {
        $mahasiswa = Mahasiswa::firstOrCreate(
            ['user_id' => $userId],
            [
                'nim' => '',
                'prodi' => '',
                'angkatan' => (int) now()->format('Y'),
            ]
        );

        return $mahasiswa->id;
    }

    private function canAccessKerjaPraktek(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        return $user->hasRole('admin') ||
               $kerjaPraktek->mahasiswa_id === $user->id ||
               $kerjaPraktek->dosen_pembimbing_id === $user->id ||
               $kerjaPraktek->pengawas_lapangan_id === $user->id;
    }

    private function canApproveKerjaPraktek(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        return $user->hasRole('admin') ||
               ($user->hasAnyRole(['dosen','dosen-biasa']) && $kerjaPraktek->dosen_pembimbing_id === $user->id);
    }

    private function canManageKerjaPraktek(KerjaPraktek $kerjaPraktek)
    {
        $user = Auth::user();

        return $user->hasRole('admin') ||
               $kerjaPraktek->dosen_pembimbing_id === $user->id ||
               $kerjaPraktek->pengawas_lapangan_id === $user->id;
    }

    private function hasMetBimbinganRequirement(KerjaPraktek $kerjaPraktek): bool
    {
        $mahasiswa = Mahasiswa::where('user_id', $kerjaPraktek->mahasiswa_id)->first();

        if (!$mahasiswa) {
            return false;
        }

        return Bimbingan::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'disetujui')
            ->count() >= self::MIN_BIMBINGAN;
    }
}
