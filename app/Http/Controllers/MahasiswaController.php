<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;
use App\Models\KerjaPraktek;
use App\Models\Seminar;
use App\Models\Proposal;
use App\Models\Bimbingan;
use App\Models\Laporan;
use App\Models\Nilai;
use App\Models\Kuesioner;
use App\Models\Instansi;
use App\Models\Dosen;
use App\Models\Lowongan;
use App\Models\PendaftaranKP;

class MahasiswaController extends Controller
{
    public const MIN_BIMBINGAN = 10;

    private function approvedBimbinganCount(?Mahasiswa $mahasiswa): int
    {
        if (!$mahasiswa) {
            return 0;
        }

        return Bimbingan::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'disetujui')
            ->count();
    }

    private function hasCompletedBimbingan(?Mahasiswa $mahasiswa): bool
    {
        return $this->approvedBimbinganCount($mahasiswa) >= self::MIN_BIMBINGAN;
    }

    private function resolveMahasiswaProfile(): Mahasiswa
    {
        $user = auth()->user();

        if ($user->mahasiswa) {
            return $user->mahasiswa;
        }

        return Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $user->nim ?? '',
            'prodi' => $user->jurusan ?? '',
            'angkatan' => $user->angkatan ?? now()->year,
            'ipk' => $user->ipk ?? null,
        ]);
    }

    // ======================
    // DASHBOARD
    // ======================
    public function dashboard()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $kpAktifCount = Schema::hasTable('kerja_prakteks')
            ? KerjaPraktek::where('mahasiswa_id', $mahasiswa->id ?? 0)
                ->whereIn('status', ['draft', 'diajukan', 'disetujui', 'berlangsung'])
                ->count()
            : 0;

        $bimbinganCount = Schema::hasTable('bimbingans')
            ? Bimbingan::where('mahasiswa_id', $mahasiswa->id ?? 0)->count()
            : 0;

        $laporanCount = Schema::hasTable('laporans')
            ? Laporan::where('mahasiswa_id', $mahasiswa->id ?? 0)->count()
            : 0;

        $seminarCount = Schema::hasTable('seminars')
            ? Seminar::where('mahasiswa_id', $mahasiswa->id ?? 0)->count()
            : 0;

        return view('mahasiswa.dashboard', compact(
            'mahasiswa', 'kpAktifCount', 'bimbinganCount', 'laporanCount', 'seminarCount'
        ));
    }

    // ======================
    // LAPORAN CRUD
    // ======================
    public function indexLaporan()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $laporans = $mahasiswa ? $mahasiswa->laporans()->latest()->get() : collect();
        $canUploadFinal = $this->hasCompletedBimbingan($mahasiswa);

        return view('mahasiswa.laporan.index', compact('laporans', 'canUploadFinal'));
    }

    public function createLaporan()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$this->hasCompletedBimbingan($mahasiswa)) {
            return redirect()->route('mahasiswa.laporan.index')
                ->with('error', 'Minimal ' . self::MIN_BIMBINGAN . ' bimbingan disetujui sebelum unggah laporan akhir.');
        }

        return view('mahasiswa.laporan.create');
    }

    public function storeLaporan(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$this->hasCompletedBimbingan($mahasiswa)) {
            return redirect()->route('mahasiswa.laporan.index')
                ->with('error', 'Lengkapi minimal ' . self::MIN_BIMBINGAN . ' bimbingan disetujui sebelum unggah laporan.');
        }

        $validated = $request->validate([
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak',
        ]);

        $filePath = $request->file('file_laporan')->store('laporans', 'public');

        Laporan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'file_laporan' => $filePath,
            'status' => $validated['status'],
            'status_verifikasi' => $validated['status'],
            'tanggal_upload' => now(),
        ]);

        return redirect()->route('mahasiswa.laporan.index')->with('success', 'Laporan berhasil dibuat.');
    }

    public function editLaporan(Laporan $laporan)
    {
        return view('mahasiswa.laporan.edit', compact('laporan'));
    }

    public function updateLaporan(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak',
        ]);

        if ($request->hasFile('file_laporan')) {
            if ($laporan->file_laporan) {
                Storage::disk('public')->delete($laporan->file_laporan);
            }
            $laporan->file_laporan = $request->file('file_laporan')->store('laporans', 'public');
        }

        $laporan->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('mahasiswa.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroyLaporan(Laporan $laporan)
    {
        if ($laporan->file_laporan) {
            Storage::disk('public')->delete($laporan->file_laporan);
        }
        $laporan->delete();

        return redirect()->route('mahasiswa.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    // ======================
    // NILAI
    // ======================
    public function nilai()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $nilais = $mahasiswa ? $mahasiswa->nilais()->latest()->get() : collect();
        return view('mahasiswa.nilai', compact('nilais'));
    }

    // ======================
    // KUESIONER CRUD
    // ======================
    public function indexKuesioner()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $kuesioners = $mahasiswa ? $mahasiswa->kuesioners()->latest()->get() : collect();
        return view('mahasiswa.kuesioner.index', compact('kuesioners'));
    }

    public function createKuesioner()
    {
        return view('mahasiswa.kuesioner.create');
    }

    public function storeKuesioner(Request $request)
    {
        $validated = $request->validate([
            'pembimbing_lapangan_id' => 'required|exists:users,id',
            'isi_kuesioner' => 'required|string',
            'tipe' => 'required|in:mahasiswa,instansi',
        ]);

        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.kuesioner.index')->with('error', 'Profil mahasiswa belum dibuat.');
        }

        Kuesioner::create([
            'mahasiswa_id' => $mahasiswa->id,
            'pembimbing_lapangan_id' => $validated['pembimbing_lapangan_id'],
            'isi_kuesioner' => $validated['isi_kuesioner'],
            'tipe' => $validated['tipe'],
        ]);

        return redirect()->route('mahasiswa.kuesioner.index')->with('success', 'Kuesioner berhasil dibuat.');
    }

    // ======================
    // BIMBINGAN CRUD
    // ======================
    public function indexBimbingan()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $bimbingans = $mahasiswa ? $mahasiswa->bimbingans()->latest()->get() : collect();
        $dosens = Dosen::all();
        $approvedBimbinganCount = $this->approvedBimbinganCount($mahasiswa);

        $minimumBimbingan = self::MIN_BIMBINGAN;

        return view('mahasiswa.bimbingan.index', compact('bimbingans', 'dosens', 'approvedBimbinganCount', 'minimumBimbingan'));
    }

    public function createBimbingan()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Profil mahasiswa belum lengkap.');
        }

        $proposals = Proposal::where('mahasiswa_id', $mahasiswa->id)->get();
        $existingDates = Bimbingan::where('mahasiswa_id', $mahasiswa->id)->pluck('tanggal_bimbingan')->toArray();

        $minimumBimbingan = self::MIN_BIMBINGAN;

        return view('mahasiswa.bimbingan.create', compact('proposals', 'existingDates', 'minimumBimbingan'));
    }

    public function storeBimbingan(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.bimbingan.index')->with('error', 'Profil mahasiswa belum lengkap.');
        }

        $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
            'tanggal_bimbingan' => [
                'required',
                'date',
                'after_or_equal:today',
                Rule::unique('bimbingans', 'tanggal_bimbingan')
                    ->where(fn ($query) => $query->where('mahasiswa_id', $mahasiswa->id)),
            ],
            'waktu_bimbingan' => 'required|date_format:H:i',
            'topik_bimbingan' => 'required|string',
            'catatan' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
        ]);

        $proposal = Proposal::find($request->proposal_id);
        $dosenPembimbingId = $proposal->dosen_id ?? null;

        if (!$dosenPembimbingId) {
            return back()->with('error', 'Dosen pembimbing tidak ditemukan untuk proposal ini.');
        }

        $fileLampiranPath = $request->hasFile('file_lampiran')
            ? $request->file('file_lampiran')->store('lampiran_bimbingan', 'public')
            : null;

        $kerjaPraktekId = $proposal->kerja_praktek_id;
        if (!$kerjaPraktekId) {
            $kerjaPraktekId = KerjaPraktek::where('mahasiswa_id', auth()->id())
                ->orderByDesc('created_at')
                ->value('id');
        }

        if (!$kerjaPraktekId) {
            return back()->withInput()->with('error', 'Data KP mahasiswa belum ditemukan. Pastikan pengajuan KP sudah disetujui.');
        }

        Bimbingan::create([
            'kerja_praktek_id' => $kerjaPraktekId,
            'dosen_pembimbing_id' => $proposal->dosen_id ?? null,
            'mahasiswa_id' => $mahasiswa->id,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'waktu_bimbingan' => $request->waktu_bimbingan,
            'topik_bimbingan' => $request->topik_bimbingan,
            'hasil_bimbingan' => $request->catatan,
            'catatan' => $request->catatan,
            'metode' => 'offline',
            'durasi_menit' => 60,
            'file_lampiran' => $fileLampiranPath,
            'rating_kualitas' => null,
            'feedback_mahasiswa' => null,
            'status' => 'menunggu',
            'periode_id' => \App\Models\PeriodeKp::activeId(),
        ]);

        if ($proposal->kerja_praktek_id) {
            $kp = KerjaPraktek::find($proposal->kerja_praktek_id);
            if ($kp) {
                $jumlah = Bimbingan::where('kerja_praktek_id', $kp->id)->count();
                $kp->jumlah_bimbingan = $jumlah;
                $kp->save();
            }
        }

        return redirect()->route('mahasiswa.bimbingan.index')->with('success', 'Data bimbingan berhasil disimpan.');
    }

    public function editBimbingan(Bimbingan $bimbingan)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if ($bimbingan->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $proposals = Proposal::where('mahasiswa_id', $mahasiswa->id)->get();
        $existingDates = Bimbingan::where('mahasiswa_id', $mahasiswa->id)->pluck('tanggal_bimbingan')->toArray();
        $minimumBimbingan = self::MIN_BIMBINGAN;

        return view('mahasiswa.bimbingan.edit', compact('bimbingan', 'proposals', 'existingDates', 'minimumBimbingan'));
    }

    public function updateBimbingan(Request $request, Bimbingan $bimbingan)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if ($bimbingan->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
            'tanggal_bimbingan' => [
                'required',
                'date',
                Rule::unique('bimbingans', 'tanggal_bimbingan')
                    ->where(fn ($query) => $query->where('mahasiswa_id', $mahasiswa->id))
                    ->ignore($bimbingan->id),
            ],
            'waktu_bimbingan' => 'required|date_format:H:i',
            'topik_bimbingan' => 'required|string',
            'catatan' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('file_lampiran')) {
            if ($bimbingan->file_lampiran) {
                Storage::disk('public')->delete($bimbingan->file_lampiran);
            }
            $validated['file_lampiran'] = $request->file('file_lampiran')->store('lampiran_bimbingan', 'public');
        }

        $bimbingan->update($validated + [
            'hasil_bimbingan' => $validated['catatan'] ?? $bimbingan->hasil_bimbingan,
        ]);

        return redirect()->route('mahasiswa.bimbingan.index')->with('success', 'Bimbingan berhasil diperbarui.');
    }

    public function destroyBimbingan(Bimbingan $bimbingan)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if ($bimbingan->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $bimbingan->delete();

        return redirect()->route('mahasiswa.bimbingan.index')->with('success', 'Bimbingan berhasil dihapus.');
    }

    // ======================
    // PROFIL MAHASISWA
    // ======================
    public function editProfil()
    {
        $mahasiswa = $this->resolveMahasiswaProfile();
        return view('mahasiswa.profil', compact('mahasiswa'));
    }

    public function updateProfil(Request $request)
    {
        $mahasiswa = $this->resolveMahasiswaProfile();

        $validated = $request->validate([
            'nim' => 'required|string|max:50',
            'prodi' => 'nullable|string|max:100',
            'angkatan' => 'nullable|integer|min:2000|max:' . now()->year,
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.profil')->with('success', 'Profil mahasiswa berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    // ======================
    // INSTANSI CRUD
    // ======================
    public function indexInstansi(Request $request)
    {
        $search = $request->q;

        $instansis = Instansi::with('kuotas')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nama_instansi', 'like', "%{$search}%")
                        ->orWhere('kota', 'like', "%{$search}%")
                        ->orWhere('provinsi', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_instansi')
            ->get();

        $lowonganAktif = Lowongan::with('instansi')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('judul_lowongan', 'like', "%{$search}%")
                        ->orWhere('kebutuhan_keahlian', 'like', "%{$search}%")
                        ->orWhereHas('instansi', fn($i) => $i->where('nama_instansi', 'like', "%{$search}%"));
                });
            })
            ->orderBy('tanggal_mulai')
            ->get();

        return view('mahasiswa.instansi.index', compact('instansis', 'lowonganAktif', 'search'));
    }

    public function createInstansi()
    {
        return view('mahasiswa.instansi.create');
    }

    public function storeInstansi(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string',
            'telepon' => 'nullable|string',
            'kontak_person' => 'nullable|string',
            'jenis_instansi' => 'nullable|string',
            'kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'proposal_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'bukti_ipk_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'prestasi_akademik' => 'nullable|string',
            'prestasi_non_akademik' => 'nullable|string',
            'pengalaman_si' => 'required|string',
        ]);

        $mahasiswaProfile = $this->resolveMahasiswaProfile();
        $user = auth()->user();
        $proposalPath = $request->file('proposal_file')->store('instansi/proposal', 'public');
        $buktiIpkPath = $request->file('bukti_ipk_file')->store('bukti_ipk', 'public');

        DB::transaction(function () use ($validated, $mahasiswaProfile, $user, $proposalPath, $buktiIpkPath) {
            $instansi = Instansi::create([
                'nama_instansi' => $validated['nama_instansi'],
                'alamat' => $validated['alamat'],
                'kontak' => $validated['kontak'],
                'telepon' => $validated['telepon'],
                'kontak_person' => $validated['kontak_person'],
                'jenis_instansi' => $validated['jenis_instansi'],
                'kota' => $validated['kota'],
                'provinsi' => $validated['provinsi'],
                'kode_pos' => $validated['kode_pos'],
                'email' => $validated['email'],
                'website' => $validated['website'],
                'status' => false,
                'status_verifikasi' => 'belum divalidasi',
                'pengusul_mahasiswa_id' => $mahasiswaProfile->id,
                'proposal_file_path' => $proposalPath,
            ]);

            $defaultStart = now()->addWeek();
            $periodeId = \App\Models\PeriodeKp::activeId();
            $kerjaPraktek = KerjaPraktek::firstOrCreate(
                [
                    'mahasiswa_id' => $user->id,
                    'instansi_id' => $instansi->id,
                ],
                [
                    'judul_kp' => 'Kerja Praktek ' . $instansi->nama_instansi,
                    'deskripsi_kp' => 'Pengajuan otomatis KP pada ' . $instansi->nama_instansi,
                    'status' => 'diajukan',
                    'tanggal_mulai' => $defaultStart,
                    'tanggal_selesai' => $defaultStart->copy()->addWeeks(8),
                    'durasi_minggu' => 8,
                    'pilihan_1' => $instansi->nama_instansi,
                    'instansi_diterima' => $instansi->nama_instansi,
                    'proposal_file' => $proposalPath,
                    'bukti_ipk_file' => $buktiIpkPath,
                    'prestasi_akademik' => $validated['prestasi_akademik'] ?? null,
                    'prestasi_non_akademik' => $validated['prestasi_non_akademik'] ?? null,
                    'pengalaman_si' => $validated['pengalaman_si'] ?? null,
                    'periode_id' => $periodeId,
                ]
            );

            $kerjaPraktek->update([
                'status' => 'diajukan',
                'instansi_diterima' => $instansi->nama_instansi,
                'proposal_file' => $proposalPath,
                'bukti_ipk_file' => $buktiIpkPath,
                'prestasi_akademik' => $validated['prestasi_akademik'] ?? null,
                'prestasi_non_akademik' => $validated['prestasi_non_akademik'] ?? null,
                'pengalaman_si' => $validated['pengalaman_si'] ?? null,
                'periode_id' => $periodeId,
            ]);
            $kerjaPraktek->updateProgress('menunggu');

            PendaftaranKP::updateOrCreate(
                [
                    'mahasiswa_id' => $mahasiswaProfile->id,
                    'kerja_praktek_id' => $kerjaPraktek->id,
                ],
                [
                    'status' => PendaftaranKP::STATUS_MENUNGGU,
                    'tanggal_daftar' => now(),
                    'jenis' => 'instansi',
                    'bukti_ipk_file' => $buktiIpkPath,
                    'prestasi_akademik' => $validated['prestasi_akademik'] ?? null,
                    'prestasi_non_akademik' => $validated['prestasi_non_akademik'] ?? null,
                    'pengalaman_si' => $validated['pengalaman_si'] ?? null,
                ]
            );
        });

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Usulan instansi berhasil diajukan dan menunggu verifikasi admin.');
    }

    // ======================
    // SEMINAR
    // ======================
    public function indexSeminar()
    {
        $user = auth()->user();
        $seminars = Seminar::with(['ketuaPenguji', 'pembimbingPenguji'])
            ->where('mahasiswa_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
        $mahasiswa = $user->mahasiswa;
        $approvedBimbinganCount = $this->approvedBimbinganCount($mahasiswa);

        return view('mahasiswa.seminar.index', compact('seminars', 'approvedBimbinganCount'));
    }

    public function createSeminar()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$this->hasCompletedBimbingan($mahasiswa)) {
            return redirect()->route('mahasiswa.seminar.index')
                ->with('error', 'Minimal ' . self::MIN_BIMBINGAN . ' bimbingan disetujui sebelum mengajukan seminar.');
        }

        $instansis = Instansi::aktif()->orderBy('nama_instansi')->get();

        return view('mahasiswa.seminar.create', compact('instansis'));
    }

    public function storeSeminar(Request $request)
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        if (!$this->hasCompletedBimbingan($mahasiswa)) {
            return redirect()->route('mahasiswa.seminar.index')
                ->with('error', 'Minimal ' . self::MIN_BIMBINGAN . ' bimbingan disetujui sebelum mengajukan seminar.');
        }

        $validated = $request->validate([
            'judul_seminar' => 'required|string|max:255',
            'abstrak' => 'nullable|string',
            'tanggal_seminar' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'metode' => 'required|in:offline,online',
            'tempat' => 'nullable|string|max:255',
            'link_online' => 'nullable|url',
            'presentasi_file' => 'nullable|file|mimes:ppt,pptx,pdf|max:5120',
            'opsi_kelanjutan' => 'nullable|in:lanjut,ganti',
            'judul_kp_baru' => 'required_if:opsi_kelanjutan,ganti|string|max:255',
            'instansi_id_baru' => 'nullable|exists:instansis,id',
        ]);

        $kerjaPraktek = KerjaPraktek::where('mahasiswa_id', $user->id)
            ->orderByDesc('created_at')
            ->firstOrFail();

        if (($validated['opsi_kelanjutan'] ?? 'lanjut') === 'ganti') {
            $kerjaPraktek->judul_kp = $validated['judul_kp_baru'];
            if (!empty($validated['instansi_id_baru'])) {
                $kerjaPraktek->instansi_id = $validated['instansi_id_baru'];
            }
            $kerjaPraktek->save();
        }

        $presentasiPath = null;
        if ($request->hasFile('presentasi_file')) {
            $presentasiPath = $request->file('presentasi_file')->store('seminar/presentasi', 'public');
        }

        Seminar::create([
            'kerja_praktek_id' => $kerjaPraktek->id,
            'mahasiswa_id' => $user->id,
            'judul_seminar' => $validated['judul_seminar'],
            'abstrak' => $validated['abstrak'] ?? null,
            'tanggal_seminar' => $validated['tanggal_seminar'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'tempat' => $validated['tempat'] ?? null,
            'metode' => $validated['metode'],
            'link_online' => $validated['link_online'] ?? null,
            'presentasi_file' => $presentasiPath,
            'status' => 'diajukan',
            'status_revisi' => 'belum_dikirim',
        ]);

        return redirect()->route('mahasiswa.seminar.index')->with('success', 'Pengajuan seminar berhasil dikirim dan menunggu verifikasi dosen pembimbing.');
    }

    public function uploadSeminarRevision(Request $request, Seminar $seminar)
    {
        $user = auth()->user();

        if ($seminar->mahasiswa_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengunggah revisi untuk seminar ini.');
        }

        if (!$seminar->needsRevision()) {
            return back()->with('error', 'Tidak ada permintaan revisi untuk seminar ini.');
        }

        if (!$this->hasCompletedBimbingan($user->mahasiswa)) {
            return back()->with('error', 'Pastikan minimal ' . self::MIN_BIMBINGAN . ' bimbingan disetujui sebelum mengunggah revisi.');
        }

        $validated = $request->validate([
            'file_revisi' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($seminar->file_revisi_path) {
            Storage::disk('public')->delete($seminar->file_revisi_path);
        }

        $path = $request->file('file_revisi')->store('seminar/revisi', 'public');
        $seminar->markRevisionUploaded($path);

        return back()->with('success', 'File revisi berhasil diunggah dan menunggu persetujuan dosen penguji.');
    }
}
