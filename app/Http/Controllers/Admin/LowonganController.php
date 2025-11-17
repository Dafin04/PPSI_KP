<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lowongans = Lowongan::with('instansi')->paginate(10);
        return view('admin.lowongan.index', compact('lowongans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instansis = Instansi::where('status_aktif', true)->get();
        return view('admin.lowongan.create', compact('instansis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'judul_lowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kebutuhan_keahlian' => 'nullable|string',
            'jumlah_kuota' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        Lowongan::create($request->all());

        return redirect()->route('admin.lowongan.index')
                        ->with('success', 'Lowongan KP berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lowongan $lowongan)
    {
        return view('admin.lowongan.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lowongan $lowongan)
    {
        $instansis = Instansi::where('status_aktif', true)->get();
        return view('admin.lowongan.edit', compact('lowongan', 'instansis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'judul_lowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kebutuhan_keahlian' => 'nullable|string',
            'jumlah_kuota' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        $lowongan->update($request->all());

        return redirect()->route('admin.lowongan.index')
                        ->with('success', 'Lowongan KP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')
                        ->with('success', 'Lowongan KP berhasil dihapus.');
    }
}
