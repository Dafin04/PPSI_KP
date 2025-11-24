<?php

namespace App\Http\Controllers;

use App\Models\PeriodeKp;
use Illuminate\Http\Request;

class PeriodeKpController extends Controller
{
    public function index()
    {
        $periodes = PeriodeKp::orderByDesc('created_at')->paginate(10);
        return view('admin.periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'tgl_mulai_pendaftaran' => 'nullable|date',
            'tgl_selesai_pendaftaran' => 'nullable|date|after_or_equal:tgl_mulai_pendaftaran',
            'status' => 'required|in:Aktif,Ditutup,Arsip',
            'keterangan' => 'nullable|string',
        ]);

        if ($validated['status'] === 'Aktif') {
            PeriodeKp::where('status', 'Aktif')->update(['status' => 'Ditutup']);
        }

        PeriodeKp::create($validated);

        return redirect()->route('admin.periode.index')->with('success', 'Periode KP berhasil dibuat.');
    }

    public function edit(PeriodeKp $periodeKp)
    {
        return view('admin.periode.edit', compact('periodeKp'));
    }

    public function update(Request $request, PeriodeKp $periodeKp)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'tgl_mulai_pendaftaran' => 'nullable|date',
            'tgl_selesai_pendaftaran' => 'nullable|date|after_or_equal:tgl_mulai_pendaftaran',
            'status' => 'required|in:Aktif,Ditutup,Arsip',
            'keterangan' => 'nullable|string',
        ]);

        if ($validated['status'] === 'Aktif') {
            PeriodeKp::where('status', 'Aktif')->where('id', '!=', $periodeKp->id)->update(['status' => 'Ditutup']);
        }

        $periodeKp->update($validated);

        return redirect()->route('admin.periode.index')->with('success', 'Periode KP diperbarui.');
    }

    public function destroy(PeriodeKp $periodeKp)
    {
        $periodeKp->delete();
        return back()->with('success', 'Periode KP dihapus.');
    }

    public function setAktif(PeriodeKp $periodeKp)
    {
        PeriodeKp::where('status', 'Aktif')->update(['status' => 'Ditutup']);
        $periodeKp->update(['status' => 'Aktif']);
        return back()->with('success', 'Periode KP diaktifkan.');
    }
}
