<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansis = Instansi::paginate(10);
        return view('admin.instansi.index', compact('instansis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.instansi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'jenis_instansi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'kontak_person' => 'nullable|string|max:255',
            'jabatan_kontak' => 'nullable|string|max:255',
            'no_hp_kontak' => 'nullable|string|max:20',
            'kuota_mahasiswa' => 'nullable|integer|min:0',
            'kebutuhan_keahlian' => 'nullable|string',
            'status_aktif' => 'boolean',
            'fasilitas' => 'nullable|array',
        ]);

        Instansi::create($validated);

        return redirect()->route('admin.instansi.index')->with('success', 'Instansi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instansi $instansi)
    {
        return view('admin.instansi.show', compact('instansi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instansi $instansi)
    {
        return view('admin.instansi.edit', compact('instansi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instansi $instansi)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'jenis_instansi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'kontak_person' => 'nullable|string|max:255',
            'jabatan_kontak' => 'nullable|string|max:255',
            'no_hp_kontak' => 'nullable|string|max:20',
            'kuota_mahasiswa' => 'nullable|integer|min:0',
            'kebutuhan_keahlian' => 'nullable|string',
            'status_aktif' => 'boolean',
            'fasilitas' => 'nullable|array',
        ]);

        $instansi->update($validated);

        return redirect()->route('admin.instansi.index')->with('success', 'Instansi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instansi $instansi)
    {
        $instansi->delete();

        return redirect()->route('admin.instansi.index')->with('success', 'Instansi berhasil dihapus.');
    }
}
