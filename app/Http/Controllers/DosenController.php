<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Proposal;
use App\Models\Bimbingan;
use App\Models\Nilai;
use Illuminate\Http\Request;
use App\Models\KerjaPraktek;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Schema;

class DosenController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();
        $totalMahasiswa = \App\Models\KerjaPraktek::where('dosen_pembimbing_id', $userId)->distinct('mahasiswa_id')->count('mahasiswa_id');
        $kpMembimbingCount = \App\Models\KerjaPraktek::where('dosen_pembimbing_id', $userId)->count();
        $pendingApprovalsCount = \App\Models\KerjaPraktek::where('dosen_pembimbing_id', $userId)->where('status','diajukan')->count();
        $completedKpCount = \App\Models\KerjaPraktek::where('dosen_pembimbing_id', $userId)->where('status','selesai')->count();

        return view('dosen.dashboard', compact('totalMahasiswa','kpMembimbingCount','pendingApprovalsCount','completedKpCount'));
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
                    'status' => 'pending',
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
            'status' => 'nullable|in:terjadwal,berlangsung,selesai,dibatalkan',
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

        return redirect()->route('dosen.bimbingan.index')->with('success', 'Bimbingan diperbarui.');
    }

    // CRUD Nilai (penilaian mahasiswa)
    public function indexNilai()
    {
        $nilais = Nilai::where('dosen_id', auth()->id())->orderByDesc('created_at')->get();
        return view('dosen.nilai.index', compact('nilais'));
    }

    public function createNilai()
    {
        return view('dosen.nilai.create');
    }

    public function storeNilai(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'pembimbing_lapangan_id' => 'required|exists:users,id',
            'nilai_pembimbing' => 'nullable|numeric|min:0|max:100',
            'nilai_lapangan' => 'nullable|numeric|min:0|max:100',
            'nilai_seminar' => 'nullable|numeric|min:0|max:100',
            'total_nilai' => 'nullable|numeric|min:0|max:100',
        ]);

        Nilai::create([
            'mahasiswa_id' => $validated['mahasiswa_id'],
            'dosen_id' => auth()->id(),
            'pembimbing_lapangan_id' => $validated['pembimbing_lapangan_id'],
            'nilai_pembimbing' => $validated['nilai_pembimbing'],
            'nilai_lapangan' => $validated['nilai_lapangan'],
            'nilai_seminar' => $validated['nilai_seminar'],
            'total_nilai' => $validated['total_nilai'],
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
                if (!is_null($validated['nilai_lapangan'] ?? null)) {
                    $kp->nilai_pengawas_lapangan = $validated['nilai_lapangan'];
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
            'nilai_lapangan' => 'nullable|numeric|min:0|max:100',
            'nilai_seminar' => 'nullable|numeric|min:0|max:100',
            'total_nilai' => 'nullable|numeric|min:0|max:100',
        ]);

        $nilai->update($validated);

        // Sinkronkan ke KP
        $m = \App\Models\Mahasiswa::find($nilai->mahasiswa_id);
        if ($m) {
            $kp = \App\Models\KerjaPraktek::where('mahasiswa_id', $m->user_id)
                ->orderByDesc('created_at')->first();
            if ($kp) {
                if (!is_null($validated['nilai_pembimbing'] ?? null)) {
                    $kp->nilai_dosen_pembimbing = $validated['nilai_pembimbing'];
                }
                if (!is_null($validated['nilai_lapangan'] ?? null)) {
                    $kp->nilai_pengawas_lapangan = $validated['nilai_lapangan'];
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
        $seminars = \App\Models\Seminar::where(function($q) use ($uid){
            $q->where('ketua_penguji_id',$uid)
              ->orWhere('anggota_penguji_1_id',$uid)
              ->orWhere('anggota_penguji_2_id',$uid)
              ->orWhere('pembimbing_penguji_id',$uid);
        })->orderByDesc('tanggal_seminar')->get();
        return view('dosen.seminar.index', compact('seminars'));
    }

    public function updateSeminar(Request $request, \App\Models\Seminar $seminar)
    {
        $validated = $request->validate([
            'nilai_ketua_penguji' => 'nullable|numeric|min:0|max:100',
            'nilai_anggota_1' => 'nullable|numeric|min:0|max:100',
            'nilai_anggota_2' => 'nullable|numeric|min:0|max:100',
            'nilai_pembimbing' => 'nullable|numeric|min:0|max:100',
            'catatan_penilaian' => 'nullable|string',
        ]);
        $seminar->update($validated);
        $seminar->hitungNilaiAkhir();
        return back()->with('success','Penilaian seminar diperbarui');
    }
}
