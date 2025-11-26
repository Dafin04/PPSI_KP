@php
    use App\Models\PeriodeKp;
    use App\Models\KerjaPraktek;
    use App\Models\Bimbingan;
    use App\Models\Seminar;
    use App\Models\Nilai;
    use App\Models\Instansi;
    use App\Models\Proposal;

    $periodes = PeriodeKp::orderByDesc('created_at')->get();
    $activePeriodeId = request('periode_id', PeriodeKp::activeId());
    $periode = $activePeriodeId ? PeriodeKp::find($activePeriodeId) : null;

    $kpBase = KerjaPraktek::query();
    $bimbinganBase = Bimbingan::query();
    $seminarBase = Seminar::query();
    $nilaiBase = Nilai::query();
    $proposalBase = Proposal::query();

    if ($activePeriodeId) {
        $kpBase->where('periode_id', $activePeriodeId);
        $bimbinganBase->where('periode_id', $activePeriodeId);
        $seminarBase->where('periode_id', $activePeriodeId);
        $nilaiBase->where('periode_id', $activePeriodeId);
        $proposalBase->where('periode_id', $activePeriodeId);
    }

    $totalMhsKp = (clone $kpBase)->count();
    $statusPendaftaran = [
        'diajukan'  => (clone $kpBase)->where('status', 'diajukan')->count(),
        'disetujui' => (clone $kpBase)->where('status', 'disetujui')->count(),
        'ditolak'   => (clone $kpBase)->where('status', 'ditolak')->count(),
    ];
    $proposalAcc = (clone $proposalBase)->where('status', 'disetujui')->count();
    $proposalRevisi = (clone $proposalBase)
        ->where(fn ($q) => $q->where('status', 'ditolak')->orWhere('status_validasi', 'revisi'))
        ->count();
    $proposalMenunggu = max((clone $proposalBase)->count() - $proposalAcc - $proposalRevisi, 0);
    $bimbinganSiap = (clone $kpBase)->where('jumlah_bimbingan', '>=', 10)->count();
    $bimbinganBelum = max($totalMhsKp - $bimbinganSiap, 0);
    $seminarTerjadwal = (clone $seminarBase)->where('status', 'dijadwalkan')->count();
    $seminarMenunggu = (clone $seminarBase)->where('status', 'diajukan')->count();
    $seminarSelesai = (clone $seminarBase)->where('status', 'selesai')->count();
    $nilaiLulus = (clone $nilaiBase)->where('nilai_mutu', '>=', 'C')->count();
    $nilaiTidak = (clone $nilaiBase)->where('nilai_mutu', 'D')->count();
    $instansiAktif = Instansi::where('status', true)->count();

    $pendaftaranList = (clone $kpBase)->with(['mahasiswa.mahasiswa', 'instansi'])
        ->latest()->take(5)->get();
    $bimbinganList = (clone $kpBase)->with(['mahasiswa', 'dosenPembimbing'])
        ->latest()->take(5)->get();
    $seminarList = (clone $seminarBase)->with(['mahasiswa', 'kerjaPraktek.dosenPembimbing', 'ketuaPenguji'])
        ->latest()->take(5)->get();
    $nilaiList = (clone $nilaiBase)->with('mahasiswa')
        ->latest()->take(5)->get();
@endphp

<x-app-layout>
    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
            {{-- Top bar: judul kiri, profil kanan --}}
            <div class="flex items-start gap-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
                    <p class="text-sm text-gray-600">Kelola & pantau seluruh proses KP dengan cepat.</p>
                </div>
                <div class="flex items-center gap-3 px-4 py-2 rounded-full border bg-white shadow-sm self-start">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold">
                        {{ strtoupper(Str::substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->nama ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            {{-- Informasi & Pengumuman --}}
            <div class="space-y-3 text-sm">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span class="text-pink-500">📢</span> Informasi & Pengumuman
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 shadow-sm">
                        <div class="flex gap-3 items-start text-blue-800">
                            <span class="text-xl">👋</span>
                            <div>
                                <p class="font-semibold text-blue-900 text-base">Selamat datang di dashboard Admin!</p>
                                <p class="text-blue-800 mt-1">
                                    Anda memiliki akses penuh untuk mengelola sistem KP. Pastikan semua pengguna memiliki role yang sesuai dengan tugasnya.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 shadow-sm">
                        <div class="flex gap-3 items-start text-emerald-800">
                            <span class="text-xl">💡</span>
                            <div>
                                <p class="font-semibold text-emerald-900 text-base">Tips Pengelolaan Sistem</p>
                                <ul class="text-emerald-800 mt-1 list-disc list-inside space-y-1">
                                    <li>Pastikan setiap pengguna memiliki role yang tepat</li>
                                    <li>Monitor aktivitas KP secara berkala</li>
                                    <li>Backup data sistem secara rutin</li>
                                    <li>Update informasi kontak dosen dan mahasiswa</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Konten utama (gunakan data lama) --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                @include('admin.monitoring._content')
            </div>
        </div>
    </div>
</x-app-layout>
