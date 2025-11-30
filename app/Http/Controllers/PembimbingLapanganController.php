<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kuesioner;
use App\Models\Kuota;
use App\Models\Instansi;
use App\Models\Mahasiswa;
use App\Services\SertifikatKpGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PembimbingLapanganController extends Controller
{
    public function __construct(
        private SertifikatKpGenerator $sertifikatKpGenerator
    ) {
    }

    public function dashboard()
    {
        $userId = auth()->id();
        $nilaiCount = Nilai::where('pembimbing_lapangan_id', $userId)->count();
        $kuesionerCount = Kuesioner::where('pembimbing_lapangan_id', $userId)->count();
        // tabel kuotas tidak menyimpan pembimbing, cukup total
        $kuotaCount = Kuota::count();
        $instansiCount = Instansi::count();

        return view('pembimbing-lapangan.dashboard', compact(
            'nilaiCount', 'kuesionerCount', 'kuotaCount', 'instansiCount'
        ));
    }

    // CRUD Nilai (penilaian mahasiswa)
    public function indexNilai()
    {
        $nilais = Nilai::where('pembimbing_lapangan_id', auth()->id())->get();
        return view('pembimbing-lapangan.nilai.index', compact('nilais'));
    }

    public function createNilai()
    {
        $instansiId = auth()->user()->instansi_id ?? optional(auth()->user()->pembimbingLapangan)->instansi_id;
        $mahasiswaList = collect();
        if ($instansiId) {
            $mahasiswaIds = \App\Models\KerjaPraktek::where('instansi_id', $instansiId)
                ->pluck('mahasiswa_id')
                ->unique();
            $mahasiswaList = \App\Models\Mahasiswa::with('user')
                ->whereIn('user_id', $mahasiswaIds)
                ->get();
        }
        return view('pembimbing-lapangan.nilai.create', compact('mahasiswaList'));
    }

    public function storeNilai(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'nilai_lapangan' => 'nullable|numeric|min:0|max:100',
        ]);

        // temukan profil mahasiswa dan KP terkait
        $m = \App\Models\Mahasiswa::find($validated['mahasiswa_id']);
        $kp = $m ? \App\Models\KerjaPraktek::where('mahasiswa_id', $m->user_id)->latest()->first() : null;
        // ambil profil dosen pembimbing (untuk memenuhi FK dosen_id)
        $dosenProfileId = null;
        if ($kp && $kp->dosen_pembimbing_id) {
            $dosenProfileId = \App\Models\Dosen::where('user_id', $kp->dosen_pembimbing_id)->value('id');
        }
        if (!$dosenProfileId) {
            return back()->withInput()->with('error', 'Dosen pembimbing belum ditetapkan untuk KP mahasiswa ini.');
        }

        $nilai = Nilai::create([
            'mahasiswa_id' => $m->id,
            'dosen_id' => $dosenProfileId,
            'pembimbing_lapangan_id' => auth()->id(),
            'nilai_lapangan' => $validated['nilai_lapangan'],
        ]);

        if ($kp && !is_null($validated['nilai_lapangan'] ?? null)) {
            $kp->nilai_pengawas_lapangan = $validated['nilai_lapangan'];
            $kp->save();
            $kp->hitungNilaiAkhir();
        }

        return redirect()->route('lapangan.nilai.index')->with('success', 'Nilai lapangan ditambahkan.');
    }

    public function editNilai(Nilai $nilai)
    {
        $mahasiswaIds = \App\Models\KerjaPraktek::where('instansi_id', auth()->user()->instansi_id ?? null)
            ->pluck('mahasiswa_id')
            ->unique();
        $mahasiswaList = \App\Models\Mahasiswa::with('user')
            ->whereIn('user_id', $mahasiswaIds)
            ->get();
        return view('pembimbing-lapangan.nilai.edit', compact('nilai','mahasiswaList'));
    }

    public function updateNilai(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'nilai_lapangan' => 'nullable|numeric|min:0|max:100',
        ]);

        $nilai->update($validated);

        $m = \App\Models\Mahasiswa::find($nilai->mahasiswa_id);
        if ($m) {
            $kp = \App\Models\KerjaPraktek::where('mahasiswa_id', $m->user_id)
                ->orderByDesc('created_at')->first();
            if ($kp && !is_null($validated['nilai_lapangan'] ?? null)) {
                $kp->nilai_pengawas_lapangan = $validated['nilai_lapangan'];
                $kp->save();
                $kp->hitungNilaiAkhir();
            }
        }

        return redirect()->route('pembimbing-lapangan.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    // CRUD Kuesioner (feedback mahasiswa)
    public function indexKuesioner()
    {
        $kuesioners = Kuesioner::where('pembimbing_lapangan_id', auth()->id())->get();
        return view('pembimbing-lapangan.kuesioner.index', compact('kuesioners'));
    }

    public function showKuesioner(Kuesioner $kuesioner)
    {
        return view('pembimbing-lapangan.kuesioner.show', compact('kuesioner'));
    }

    public function createKuesioner()
    {
        return view('pembimbing-lapangan.kuesioner.create');
    }

    public function storeKuesioner(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'manfaat' => 'required|in:tidak,kurang,baik,sangat',
            'kemampuan_kerja' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'kemandirian' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'penguasaan_materi' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'penguasaan_si' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'kerjasama' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'etika' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'sinergi' => 'required|in:tidak,sedikit,sedang,besar',
            'lanjut' => 'required|in:ya,tidak',
            // form field memakai kuota_tahun_depan, tetap dukung nama lama (jumlah_mahasiswa)
            'kuota_tahun_depan' => 'nullable|integer|min:0',
            'jumlah_mahasiswa' => 'nullable|integer|min:0',
            'saran_matkul' => 'nullable|string',
            'saran_kemampuan' => 'nullable|string',
        ]);

        $payload = [
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'],
            'institusi' => $validated['institusi'],
            'manfaat' => $validated['manfaat'],
            'kemampuan_kerja' => $validated['kemampuan_kerja'],
            'kemandirian' => $validated['kemandirian'],
            'penguasaan_materi' => $validated['penguasaan_materi'],
            'penguasaan_si' => $validated['penguasaan_si'],
            'kerjasama' => $validated['kerjasama'],
            'etika' => $validated['etika'],
            'sinergi' => $validated['sinergi'],
            'lanjut' => $validated['lanjut'],
            'jumlah_mahasiswa' => $validated['kuota_tahun_depan'] ?? $validated['jumlah_mahasiswa'] ?? null,
            'saran_matkul' => $validated['saran_matkul'] ?? '',
            'saran_kemampuan' => $validated['saran_kemampuan'] ?? '',
        ];

        $kepuasan = in_array($validated['manfaat'], ['baik', 'sangat']) ? 'puas' : 'tidak_puas';

        // Hubungkan kuesioner ke profil mahasiswa (FK ke mahasiswas.id) dengan membuat entri dummy bila belum ada.
        $user = auth()->user();
        $mahasiswaProfile = Mahasiswa::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nim' => 'PL-' . $user->id,
                'prodi' => '',
                'angkatan' => now()->year,
                'ipk' => null,
                'nama' => $user->name ?? '',
            ]
        );
        $mahasiswaId = $mahasiswaProfile->id;

        // siapkan data utama sesuai kolom yang ada agar tidak error jika migrasi opsional belum jalan
        $data = [
            'pembimbing_lapangan_id' => auth()->id(),
            'mahasiswa_id' => $mahasiswaId,
            'isi_kuesioner' => json_encode($payload),
            'tipe' => 'instansi',
        ];
        if (Schema::hasColumn('kuesioners', 'kuota_tahun_depan')) {
            $data['kuota_tahun_depan'] = $validated['kuota_tahun_depan'] ?? $validated['jumlah_mahasiswa'] ?? null;
        }
        if (Schema::hasColumn('kuesioners', 'saran_kegiatan')) {
            $data['saran_kegiatan'] = $validated['saran_matkul'] ?? '';
        }
        if (Schema::hasColumn('kuesioners', 'kebutuhan_skill')) {
            $data['kebutuhan_skill'] = $validated['saran_kemampuan'] ?? '';
        }
        if (Schema::hasColumn('kuesioners', 'tingkat_kepuasan')) {
            $data['tingkat_kepuasan'] = $kepuasan;
        }

        $kuesioner = Kuesioner::create($data);

        $user = auth()->user();
        $pembimbing = \App\Models\PembimbingLapangan::with('instansi')->where('user_id', $user->id)->first();
        $instansiName = $pembimbing?->instansi?->nama_instansi ?? $user->fakultas ?? 'Mitra KP';
        $certificatePath = $this->sertifikatKpGenerator->generate([
            'nama_pembimbing' => $user->name,
            'nik' => $user->nip ?? $user->id,
            'semester' => now()->month >= 7 ? 'Ganjil' : 'Genap',
            'tahun' => now()->format('Y'),
            'nama_kaprodi' => 'Kaprodi Sistem Informasi',
            'instansi' => $instansiName,
        ]);

        if (Schema::hasColumn('kuesioners', 'sertifikat_path')) {
            $kuesioner->update([
                'sertifikat_path' => $certificatePath,
                'sertifikat_dibuat_pada' => now(),
            ]);
        }

        return redirect()->route('lapangan.kuesioner.index')->with('success', 'Kuesioner tersimpan.');
    }

    public function editKuesioner(Kuesioner $kuesioner)
    {
        return view('pembimbing-lapangan.kuesioner.edit', compact('kuesioner'));
    }

    public function updateKuesioner(Request $request, Kuesioner $kuesioner)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'manfaat' => 'required|in:tidak,kurang,baik,sangat',
            'kemampuan_kerja' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'kemandirian' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'penguasaan_materi' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'penguasaan_si' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'kerjasama' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'etika' => 'required|in:tidak_baik,kurang_baik,cukup_baik,sangat_baik',
            'sinergi' => 'required|in:tidak,sedikit,sedang,besar',
            'lanjut' => 'required|in:ya,tidak',
            'jumlah_mahasiswa' => 'nullable|integer|min:0',
            'saran_matkul' => 'nullable|string',
            'saran_kemampuan' => 'nullable|string',
        ]);

        $payload = [
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'],
            'institusi' => $validated['institusi'],
            'manfaat' => $validated['manfaat'],
            'kemampuan_kerja' => $validated['kemampuan_kerja'],
            'kemandirian' => $validated['kemandirian'],
            'penguasaan_materi' => $validated['penguasaan_materi'],
            'penguasaan_si' => $validated['penguasaan_si'],
            'kerjasama' => $validated['kerjasama'],
            'etika' => $validated['etika'],
            'sinergi' => $validated['sinergi'],
            'lanjut' => $validated['lanjut'],
            'jumlah_mahasiswa' => $validated['jumlah_mahasiswa'] ?? null,
            'saran_matkul' => $validated['saran_matkul'] ?? '',
            'saran_kemampuan' => $validated['saran_kemampuan'] ?? '',
        ];

        $kepuasan = in_array($validated['manfaat'], ['baik', 'sangat']) ? 'puas' : 'tidak_puas';

        $kuesioner->update([
            'isi_kuesioner' => json_encode($payload),
            'kuota_tahun_depan' => $validated['jumlah_mahasiswa'] ?? null,
            'saran_kegiatan' => $validated['saran_matkul'] ?? '',
            'kebutuhan_skill' => $validated['saran_kemampuan'] ?? '',
            'tingkat_kepuasan' => $kepuasan,
        ]);
        return redirect()->route('lapangan.kuesioner.index')->with('success', 'Kuesioner diperbarui.');
    }

    // Kuota tahun depan
    public function indexKuota()
    {
        $kuotas = Kuota::with('instansi')->orderByDesc('tahun')->get();
        return view('pembimbing-lapangan.kuota.index', compact('kuotas'));
    }

    public function createKuota()
    {
        $instansis = Instansi::orderBy('nama_instansi')->get();
        return view('pembimbing-lapangan.kuota.create', compact('instansis'));
    }

    public function storeKuota(Request $request)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);
        Kuota::create($validated);
        return redirect()->route('lapangan.kuota.index')->with('success', 'Usulan kuota tersimpan.');
    }

    public function editKuota(Kuota $kuota)
    {
        $instansis = Instansi::orderBy('nama_instansi')->get();
        return view('pembimbing-lapangan.kuota.edit', compact('kuota','instansis'));
    }

    public function updateKuota(Request $request, Kuota $kuota)
    {
        $validated = $request->validate([
            'instansi_id' => 'required|exists:instansis,id',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);
        $kuota->update($validated);
        return redirect()->route('lapangan.kuota.index')->with('success', 'Usulan kuota diperbarui.');
    }

    // TODO: Laporan monitoring mahasiswa
    // TODO: Evaluasi mahasiswa

    // ======================
    // PROFIL PEMBIMBING LAPANGAN
    // ======================
    public function editProfil()
    {
        $user = auth()->user();
        $pembimbing = \App\Models\PembimbingLapangan::with('instansi')->firstOrCreate(
            ['user_id' => $user->id],
            ['instansi_id' => null, 'instansi' => $user->fakultas ?? null, 'nip' => $user->nip ?? null, 'jabatan' => $user->jabatan ?? null]
        );
        $instansis = Instansi::orderBy('nama_instansi')->get();

        return view('pembimbing-lapangan.profil', compact('pembimbing', 'instansis', 'user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $pembimbing = \App\Models\PembimbingLapangan::firstOrCreate(
            ['user_id' => $user->id],
            ['instansi_id' => null]
        );

        $validated = $request->validate([
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'instansi_id' => 'nullable|exists:instansis,id',
            'kontak' => 'nullable|string|max:255',
        ]);

        $pembimbing->update($validated);

        return redirect()->route('lapangan.profil')->with('success', 'Profil pembimbing lapangan diperbarui.');
    }
}
