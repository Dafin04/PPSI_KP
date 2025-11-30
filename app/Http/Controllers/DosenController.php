<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Proposal;
use App\Models\Bimbingan;
use App\Models\Nilai;
use Illuminate\Http\Request;
use App\Models\KerjaPraktek;
use App\Models\Mahasiswa;
use App\Models\Seminar;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Arr;
use App\Notifications\SeminarApprovedNotification;

class DosenController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();
        $totalMahasiswa = KerjaPraktek::where('dosen_pembimbing_id', $userId)->distinct('mahasiswa_id')->count('mahasiswa_id');
        $kpMembimbingCount = KerjaPraktek::where('dosen_pembimbing_id', $userId)->count();
        $pendingApprovalsCount = KerjaPraktek::where('dosen_pembimbing_id', $userId)->where('status','diajukan')->count();
        $completedKpCount = KerjaPraktek::where('dosen_pembimbing_id', $userId)->where('status','selesai')->count();

        $proposalCount = Proposal::where('dosen_id', $userId)->count();
        $bimbinganCount = Bimbingan::where('dosen_pembimbing_id', $userId)->count();
        $nilaiCount = Nilai::where('dosen_id', $userId)->count();
        $seminarCount = Seminar::where(function($q) use ($userId) {
            $q->where('pembimbing_penguji_id', $userId)
              ->orWhere('ketua_penguji_id', $userId)
              ->orWhere('anggota_penguji_1_id', $userId)
              ->orWhere('anggota_penguji_2_id', $userId);
        })->count();

        return view('dosen.dashboard', compact(
            'totalMahasiswa','kpMembimbingCount','pendingApprovalsCount','completedKpCount',
            'proposalCount','bimbinganCount','nilaiCount','seminarCount'
        ));
    }

    // CRUD Proposal (review dan approval)
    public function indexProposal()
    {
        $uid = auth()->id();

        // Sinkronkan proposal untuk semua KP yang masih diajukan di bawah dosen ini
        $this->syncProposalsForPendingKP($uid);

        // Ambil hanya yang perlu divalidasi (status pending/diajukan)
        $proposals = Proposal::where('dosen_id', $uid)
            ->whereIn('status', ['pending','diajukan'])
            ->orderByDesc('created_at')
            ->get();

        return view('dosen.proposal.index', compact('proposals'));
    }

    private function syncProposalsForPendingKP(int $dosenId): void
    {
        // Cari semua KP yang belum diproses dan sudah memiliki dosen pembimbing ini
        $kps = KerjaPraktek::where('dosen_pembimbing_id', $dosenId)
            ->where('status', 'diajukan')
            ->get();

        foreach ($kps as $kp) {
            // Pastikan ada profil mahasiswa (tabel mahasiswas)
            $mhs = Mahasiswa::where('user_id', $kp->mahasiswa_id)->first();
            if (!$mhs) {
                $mhs = Mahasiswa::create([
                    'user_id' => $kp->mahasiswa_id,
                    'nim' => '',
                    'prodi' => '',
                    'angkatan' => (int) now()->format('Y')
                ]);
            }

            // Jika mahasiswa belum punya proposal sama sekali, buatkan pending
            if (!Proposal::where('mahasiswa_id', $mhs->id)->exists()) {
                Proposal::create([
                    'mahasiswa_id' => $mhs->id,
                    'dosen_id' => $dosenId,
                    'judul' => $kp->judul_kp ?? 'Judul KP',
                    'file_proposal' => '',
                    // gunakan status yang valid di kolom enum
                    'status' => 'diajukan',
                    'status_validasi' => 'pending',
                    'tanggal_upload' => now(),
                ]);
            } else {
                // Pastikan semua proposal mahasiswa itu diarahkan ke dosen ini bila kosong
                Proposal::where('mahasiswa_id', $mhs->id)
                    ->whereNull('dosen_id')
                    ->update(['dosen_id' => $dosenId]);
            }
        }
    }

    public function showProposal(Proposal $proposal)
    {
        return view('dosen.proposal.show', compact('proposal'));
    }

    public function approveProposal(Request $request, Proposal $proposal)
    {
        $note = $request->input('catatan_validasi');
        $payload = ['status' => 'disetujui', 'status_validasi' => 'disetujui'];
        if (\Illuminate\Support\Facades\Schema::hasColumn('proposals','catatan_validasi')) {
            $payload['catatan_validasi'] = $note;
        }
        $proposal->update($payload);
        return redirect()->route('dosen.proposal.index')->with('success', 'Proposal disetujui.');
    }

    public function rejectProposal(Request $request, Proposal $proposal)
    {
        $note = $request->input('catatan_validasi');
        $payload = ['status' => 'ditolak', 'status_validasi' => 'ditolak'];
        if (\Illuminate\Support\Facades\Schema::hasColumn('proposals','catatan_validasi')) {
            $payload['catatan_validasi'] = $note;
        }
        $proposal->update($payload);
        return redirect()->route('dosen.proposal.index')->with('success', 'Proposal ditolak.');
    }

    // CRUD Bimbingan (jadwal dan catatan)
    public function indexBimbingan()
    {
        $bimbingans = Bimbingan::query()
            ->where(function($q){
                $uid = auth()->id();
                $q->where('dosen_pembimbing_id', $uid);
                if (Schema::hasColumn('bimbingans', 'dosen_id')) {
                    $q->orWhere('dosen_id', $uid);
                }
            })
            ->orderByDesc('created_at')
            ->get();
        return view('dosen.bimbingan.index', compact('bimbingans'));
    }

    public function showBimbingan(Bimbingan $bimbingan)
    {
        return view('dosen.bimbingan.show', compact('bimbingan'));
    }

    public function updateBimbingan(Request $request, Bimbingan $bimbingan)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string',
            'status' => 'nullable|in:menunggu,disetujui,ditolak',
            'feedback_dosen' => 'nullable|string',
        ]);

        $payload = [];
        if (!empty($validated['status'])) $payload['status'] = $validated['status'];
        if (!empty($validated['catatan'])) $payload['catatan'] = $validated['catatan'];
        if (\Illuminate\Support\Facades\Schema::hasColumn('bimbingans','feedback_dosen')) {
            if (!empty($validated['feedback_dosen'])) $payload['feedback_dosen'] = $validated['feedback_dosen'];
        } else {
            if (!empty($validated['feedback_dosen'])) {
                $payload['catatan'] = trim(($payload['catatan'] ?? ($bimbingan->catatan ?? '')) . "\nFeedback dosen: " . $validated['feedback_dosen']);
            }
        }

        if (!empty($payload)) $bimbingan->update($payload);

        // Jika ACC, update jumlah bimbingan disetujui pada KP
        if (($payload['status'] ?? null) === 'disetujui' && $bimbingan->kerja_praktek_id) {
            $jumlah = Bimbingan::where('kerja_praktek_id', $bimbingan->kerja_praktek_id)
                ->where('status', 'disetujui')
                ->count();
            if ($kp = \App\Models\KerjaPraktek::find($bimbingan->kerja_praktek_id)) {
                $kp->jumlah_bimbingan = $jumlah;
                $kp->save();
            }
        }

        return redirect()->route('dosen.bimbingan.index')->with('success', 'Bimbingan diperbarui.');
    }

    // CRUD Nilai (penilaian mahasiswa)
    public function indexNilai()
    {
        $user = auth()->user();
        $dosenProfile = $user->dosen ?? Dosen::firstOrCreate(
            ['user_id' => $user->id],
            ['nip' => $user->nip ?? '', 'jabatan' => $user->jabatan ?? '', 'status_aktif' => true]
        );

        $nilais = Nilai::where('dosen_id', $dosenProfile->id)
            ->orderByDesc('created_at')
            ->get();
        return view('dosen.nilai.index', compact('nilais'));
    }

    public function createNilai()
    {
        $mahasiswaList = Mahasiswa::with('user')->orderBy('user_id')->get();
        return view('dosen.nilai.create', compact('mahasiswaList'));
    }

    public function storeNilai(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'nilai_pembimbing' => 'nullable|numeric|min:0|max:100',
        ]);

        // Pastikan dosen profile ada (karena FK nilais.dosen_id mengarah ke tabel dosens)
        $user = auth()->user();
        $dosenProfile = $user->dosen ?? Dosen::firstOrCreate(
            ['user_id' => $user->id],
            ['nip' => $user->nip ?? '', 'jabatan' => $user->jabatan ?? '', 'status_aktif' => true]
        );

        $nilai = Nilai::create([
            'mahasiswa_id' => $validated['mahasiswa_id'],
            'dosen_id' => $dosenProfile->id,
            // isi dengan user dosen saat ini supaya kolom NOT NULL terpenuhi (PL tidak diinput di sini)
            'pembimbing_lapangan_id' => auth()->id(),
            'nilai_pembimbing' => $validated['nilai_pembimbing'],
            'nilai_seminar' => null,
            'nilai_pembimbing_huruf' => null,
            'nilai_seminar_huruf' => null,
            'nilai_mutu' => null,
        ]);

        // Sinkronkan komponen nilai ke entitas KP agar nilai akhir terhitung
        $m = \App\Models\Mahasiswa::find($validated['mahasiswa_id']);
        if ($m) {
            $kp = \App\Models\KerjaPraktek::where('mahasiswa_id', $m->user_id)
                ->orderByDesc('created_at')->first();
            if ($kp) {
                if (!is_null($validated['nilai_pembimbing'] ?? null)) {
                    $kp->nilai_dosen_pembimbing = $validated['nilai_pembimbing'];
                }
                $kp->save();
                $kp->hitungNilaiAkhir();
            }
        }

        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil dibuat.');
    }

    public function editNilai(Nilai $nilai)
    {
        return view('dosen.nilai.edit', compact('nilai'));
    }

    public function updateNilai(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'nilai_pembimbing' => 'nullable|numeric|min:0|max:100',
        ]);

        $nilai->update([
            'nilai_pembimbing' => $validated['nilai_pembimbing'],
            'nilai_seminar' => null,
            'nilai_pembimbing_huruf' => null,
            'nilai_seminar_huruf' => null,
        ]);

        $nilai->save();

        // Sinkronkan ke KP
        $m = \App\Models\Mahasiswa::find($nilai->mahasiswa_id);
        if ($m) {
            $kp = \App\Models\KerjaPraktek::where('mahasiswa_id', $m->user_id)
                ->orderByDesc('created_at')->first();
            if ($kp) {
                if (!is_null($validated['nilai_pembimbing'] ?? null)) {
                    $kp->nilai_dosen_pembimbing = $validated['nilai_pembimbing'];
                }
                $kp->save();
                $kp->hitungNilaiAkhir();
            }
        }

        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroyNilai(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    public function indexSeminar()
    {
        $uid = auth()->id();
        $seminars = Seminar::with('kerjaPraktek')->where(function($q) use ($uid){
            $q->where('ketua_penguji_id',$uid)
              ->orWhere('anggota_penguji_1_id',$uid)
              ->orWhere('anggota_penguji_2_id',$uid)
              ->orWhere('pembimbing_penguji_id',$uid);
        })
        ->where(function($q) {
            $q->whereNull('lolos')->orWhere('lolos', false);
        })
        ->orderByDesc('tanggal_seminar')
        ->get();

        return view('dosen.seminar.index', compact('seminars'));
    }

    public function showSeminar(Seminar $seminar)
    {
        return view('dosen.seminar.show', compact('seminar'));
    }

    public function approveSeminar(Request $request, Seminar $seminar)
    {
        $uid = auth()->id();
        $isPembimbing = optional($seminar->kerjaPraktek)->dosen_pembimbing_id === $uid
            || $seminar->pembimbing_penguji_id === $uid;

        if (!$isPembimbing) {
            abort(403, 'Hanya dosen pembimbing yang dapat menyetujui seminar.');
        }

        $seminar->update(['status' => 'dijadwalkan']);

        if ($seminar->mahasiswa) {
            $seminar->mahasiswa->notify(new SeminarApprovedNotification($seminar, 'disetujui'));
        }

        return back()->with('success', 'Seminar disetujui dan mahasiswa menerima notifikasi.');
    }

    public function requestSeminarRevision(Request $request, Seminar $seminar)
    {
        if (!$this->isPenguji($seminar, auth()->id())) {
            abort(403, 'Hanya dosen penguji yang dapat memberikan revisi.');
        }

        $validated = $request->validate([
            'catatan_revisi' => 'required|string',
        ]);

        $seminar->markRevisionRequest($validated['catatan_revisi']);

        if ($seminar->mahasiswa) {
            $seminar->mahasiswa->notify(new SeminarApprovedNotification($seminar, 'butuh_revisi'));
        }

        return back()->with('success', 'Catatan revisi disimpan.');
    }

    public function approveSeminarRevision(Seminar $seminar)
    {
        if (!$this->isPenguji($seminar, auth()->id())) {
            abort(403, 'Hanya dosen penguji yang dapat menyetujui revisi.');
        }

        $seminar->approveRevision();

        return back()->with('success', 'Revisi seminar telah disetujui.');
    }

    public function updateSeminar(Request $request, Seminar $seminar)
    {
        if (!$this->isPenguji($seminar, auth()->id())) {
            abort(403, 'Hanya dosen penguji yang dapat menilai seminar.');
        }

        $validated = $request->validate([
            'nilai_ketua_penguji' => 'nullable|numeric|min:0|max:100',
            'nilai_anggota_1' => 'nullable|numeric|min:0|max:100',
            'nilai_anggota_2' => 'nullable|numeric|min:0|max:100',
            'nilai_pembimbing' => 'nullable|numeric|min:0|max:100',
            'catatan_penilaian' => 'nullable|string',
            'nilai_penguji_angka' => 'nullable|numeric|min:0|max:100',
            'nilai_penguji_huruf' => 'nullable|in:A,B,C,D',
        ]);

        $nilaiPenguji = [
            'angka' => $validated['nilai_penguji_angka'] ?? null,
            'huruf' => $validated['nilai_penguji_huruf'] ?? null,
        ];

        $payload = Arr::except($validated, ['nilai_penguji_angka', 'nilai_penguji_huruf']);

        $seminar->update($payload);

        if (!is_null($nilaiPenguji['angka']) || !is_null($nilaiPenguji['huruf'])) {
            $seminar->setPengujiGrade($nilaiPenguji['angka'], $nilaiPenguji['huruf']);
        }

        // Tandai selesai jika nilai final sudah diisi
        if (!is_null($nilaiPenguji['angka'])) {
            $seminar->status = 'selesai';
            $seminar->save();
        }

        $seminar->hitungNilaiAkhir();

        return back()->with('success', 'Penilaian seminar diperbarui');
    }

    private function isPenguji(Seminar $seminar, int $userId): bool
    {
        $pengujiIds = array_filter([
            $seminar->ketua_penguji_id,
            $seminar->anggota_penguji_1_id,
            $seminar->anggota_penguji_2_id,
            $seminar->pembimbing_penguji_id,
        ]);

        return in_array($userId, $pengujiIds, true);
    }

    // ======================
    // PROFIL DOSEN
    // ======================
    public function editProfil()
    {
        $user = auth()->user();
        $dosen = $user->dosen ?: \App\Models\Dosen::create([
            'user_id' => $user->id,
            'nip' => $user->nip ?? '',
            'jabatan' => '',
            'status_aktif' => true,
        ]);

        return view('dosen.profil', compact('dosen', 'user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $dosen = $user->dosen ?: \App\Models\Dosen::create([
            'user_id' => $user->id,
            'nip' => '',
            'jabatan' => '',
            'status_aktif' => true,
        ]);

        $validated = $request->validate([
            'nip' => 'required|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'prodi' => 'nullable|string|max:100',
            'keahlian' => 'nullable|string|max:255',
            'status_aktif' => 'nullable|boolean',
        ]);

        $dosen->update($validated);

        return redirect()->route('dosen.profil')->with('success', 'Profil dosen berhasil diperbarui.');
    }
}
