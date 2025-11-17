<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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

class MahasiswaController extends Controller
{
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
    // PROPOSAL CRUD
    // ======================
    public function indexProposal()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $proposals = $mahasiswa ? $mahasiswa->proposals()->latest()->get() : collect();
        return view('mahasiswa.proposal.index', compact('proposals'));
    }

    public function createProposal()
    {
        return view('mahasiswa.proposal.create');
    }

    public function storeProposal(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak',
        ]);

        $mahasiswa = auth()->user()->mahasiswa;
        $filePath = $request->file('file_proposal')->store('proposals', 'public');

        Proposal::create([
            'mahasiswa_id' => $mahasiswa->id,
            'judul' => $validated['judul'],
            'file_proposal' => $filePath,
            'status' => $validated['status'],
            'status_validasi' => 'belum divalidasi',
            'tanggal_upload' => now(),
        ]);

        return redirect()->route('mahasiswa.proposal.index')->with('success', 'Proposal berhasil dibuat.');
    }

    public function editProposal(Proposal $proposal)
    {
        return view('mahasiswa.proposal.edit', compact('proposal'));
    }

    public function updateProposal(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file_proposal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak',
        ]);

        if ($request->hasFile('file_proposal')) {
            if ($proposal->file_proposal) {
                Storage::disk('public')->delete($proposal->file_proposal);
            }
            $proposal->file_proposal = $request->file('file_proposal')->store('proposals', 'public');
        }

        $proposal->update([
            'judul' => $validated['judul'],
            'status' => $validated['status'],
            'status_validasi' => $validated['status'],
        ]);

        return redirect()->route('mahasiswa.proposal.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    public function destroyProposal(Proposal $proposal)
    {
        if ($proposal->file_proposal) {
            Storage::disk('public')->delete($proposal->file_proposal);
        }
        $proposal->delete();

        return redirect()->route('mahasiswa.proposal.index')->with('success', 'Proposal berhasil dihapus.');
    }

    // ======================
    // LAPORAN CRUD
    // ======================
    public function indexLaporan()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $laporans = $mahasiswa ? $mahasiswa->laporans()->latest()->get() : collect();
        return view('mahasiswa.laporan.index', compact('laporans'));
    }

    public function createLaporan()
    {
        return view('mahasiswa.laporan.create');
    }

    public function storeLaporan(Request $request)
    {
        $validated = $request->validate([
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak',
        ]);

        $mahasiswa = auth()->user()->mahasiswa;
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

        return view('mahasiswa.bimbingan.index', compact('bimbingans', 'dosens'));
    }

    public function createBimbingan()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $proposals = Proposal::where('mahasiswa_id', $mahasiswa->id)->get();
        $existingDates = Bimbingan::where('mahasiswa_id', $mahasiswa->id)->pluck('tanggal_bimbingan')->toArray();

        return view('mahasiswa.bimbingan.create', compact('proposals', 'existingDates'));
    }

    public function storeBimbingan(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
            'tanggal_bimbingan' => 'required|date',
            'topik_bimbingan' => 'required|string',
            'hasil_bimbingan' => 'required|string',
            'catatan' => 'nullable|string',
            'metode' => 'nullable|string',
            'durasi_menit' => 'nullable|integer',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
            'rating_kualitas' => 'nullable|integer|min:1|max:5',
            'feedback_mahasiswa' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $mahasiswa = auth()->user()->mahasiswa;

        $proposal = Proposal::find($request->proposal_id);
        $dosenPembimbingId = $proposal->dosen_id ?? null;

        if (!$dosenPembimbingId) {
            return back()->with('error', 'Dosen pembimbing tidak ditemukan untuk proposal ini.');
        }

        $fileLampiranPath = $request->hasFile('file_lampiran')
            ? $request->file('file_lampiran')->store('lampiran_bimbingan', 'public')
            : null;

        Bimbingan::create([
            'kerja_praktek_id' => $proposal->kerja_praktek_id ?? null,
            'dosen_pembimbing_id' => $proposal->dosen_id ?? null,
            'mahasiswa_id' => $mahasiswa->id,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'topik_bimbingan' => $request->topik_bimbingan,
            'hasil_bimbingan' => $request->hasil_bimbingan,
            'catatan' => $request->catatan,
            'metode' => $request->metode ?? 'offline',
            'durasi_menit' => $request->durasi_menit ?? 60,
            'file_lampiran' => $fileLampiranPath,
            'rating_kualitas' => $request->rating_kualitas,
            'feedback_mahasiswa' => $request->feedback_mahasiswa,
            'status' => $request->status ?? 'menunggu',
        ]);

        return redirect()->route('mahasiswa.bimbingan.index')->with('success', 'Data bimbingan berhasil disimpan.');
    }

    public function editBimbingan(Bimbingan $bimbingan)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if ($bimbingan->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('mahasiswa.bimbingan.edit', compact('bimbingan'));
    }

    public function updateBimbingan(Request $request, Bimbingan $bimbingan)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if ($bimbingan->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'tanggal_bimbingan' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'required|in:menunggu,disetujui,ditolak',
        ]);

        $bimbingan->update($validated);

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
}
