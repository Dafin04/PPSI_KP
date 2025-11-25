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
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-indigo-600 font-semibold">Dashboard</p>
            <h2 class="text-3xl font-bold text-gray-900">Dashboard Admin</h2>
            <p class="text-sm text-gray-600">Ringkasan pengelolaan Sistem KP.</p>
        </div>
    </x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Dashboard Admin</h3>
                <p class="text-sm text-gray-600">Ringkasan monitoring KP ditampilkan di bawah.</p>
            </div>

            @include('admin.monitoring._content')
        </div>
    </div>
</x-app-layout>
