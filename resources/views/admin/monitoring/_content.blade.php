@php
    use App\Models\KerjaPraktek;
    use App\Models\Bimbingan;
    use App\Models\Seminar;
    use App\Models\Nilai;
    use App\Models\Instansi;

    // Aggregasi dasar
    $kpByStatus = $kpByStatus ?? KerjaPraktek::select('status', \DB::raw('COUNT(*) as total'))
        ->groupBy('status')->pluck('total','status')->toArray();
    $totalKP = $totalKP ?? KerjaPraktek::count();
    $kpBerlangsung = $kpBerlangsung ?? ($kpByStatus['berlangsung'] ?? 0);
    $kpSelesai = $kpSelesai ?? ($kpByStatus['selesai'] ?? 0);
    $bimbinganCount = $bimbinganCount ?? Bimbingan::count();
    $seminarMenunggu = $seminarMenunggu ?? Seminar::where('status','diajukan')->count();
    $seminarTerjadwal = $seminarTerjadwal ?? Seminar::where('status','dijadwalkan')->count();
    $seminarSelesai = $seminarSelesai ?? Seminar::where('status','selesai')->count();
    $nilaiLulus = $nilaiLulus ?? Nilai::where('nilai_mutu','>=','C')->count();
    $nilaiTidak = $nilaiTidak ?? Nilai::where('nilai_mutu','D')->count();
    $instansiTop = $instansiTop ?? \App\Models\Instansi::select('instansis.*', \DB::raw('COUNT(kerja_prakteks.id) as total'))
        ->leftJoin('kerja_prakteks', 'kerja_prakteks.instansi_id', '=', 'instansis.id')
        ->whereNotNull('kerja_prakteks.instansi_id')
        ->groupBy('instansis.id')
        ->orderByDesc('total')
        ->limit(6)
        ->get()
        ->map(fn($row) => (object)[
            'instansi' => $row,
            'total' => $row->total,
        ]);

    $totalAll = max(1, (int) ($totalKP ?? 0));
    $statusOrder = ['diajukan','berlangsung','selesai','ditolak'];
    $labels = [
        'diajukan' => 'Diajukan',
        'berlangsung' => 'Berlangsung',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];
    $colors = [
        'diajukan' => 'bg-amber-500',
        'berlangsung' => 'bg-indigo-500',
        'selesai' => 'bg-emerald-500',
        'ditolak' => 'bg-rose-500',
    ];
    $items = [];
    foreach ($statusOrder as $k) { $items[$k] = (int) ($kpByStatus[$k] ?? 0); }
    foreach (($kpByStatus ?? []) as $k => $v) { if (!array_key_exists($k, $items)) { $items[$k] = (int) $v; } }
@endphp

<!-- Ringkasan modern tanpa tabel -->
<section class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $chips = [
                ['label'=>'Pendaftaran (Diajukan)','val'=>$items['diajukan'] ?? 0,'desc'=>'Menunggu verifikasi admin','color'=>'indigo'],
                ['label'=>'Sedang KP','val'=>$items['berlangsung'] ?? 0,'desc'=>'Proses bimbingan berjalan','color'=>'blue'],
                ['label'=>'Selesai / Kelulusan','val'=>$items['selesai'] ?? 0,'desc'=>'Siap rekap nilai','color'=>'emerald'],
                ['label'=>'Ditolak','val'=>$items['ditolak'] ?? 0,'desc'=>'Perlu pengajuan ulang','color'=>'rose'],
            ];
        @endphp
        @foreach($chips as $c)
            <div class="rounded-2xl bg-white border border-gray-100 shadow-sm p-4">
                <p class="text-xs font-semibold text-{{ $c['color'] }}-700 uppercase tracking-wide">{{ $c['label'] }}</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $c['val'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $c['desc'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Distribusi Status KP</h3>
            <div class="space-y-3">
                @foreach($items as $key => $val)
                    @php
                        $label = $labels[$key] ?? ucfirst($key ?: 'Tidak diketahui');
                        $pct = round(($val / $totalAll) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm text-gray-700 mb-1">
                            <span>{{ $label }}</span>
                            <span class="font-medium">{{ $val }} mahasiswa</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-100">
                            <div class="h-2 rounded-full {{ $colors[$key] ?? 'bg-gray-400' }}" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Highlight Aktivitas</h3>
            <div class="space-y-3 text-sm text-gray-700">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 h-2 w-2 rounded-full bg-indigo-500"></span>
                    <div>
                        <p class="font-semibold">Bimbingan aktif</p>
                        <p class="text-gray-500">Total bimbingan tercatat: {{ $bimbinganCount }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 h-2 w-2 rounded-full bg-blue-500"></span>
                    <div>
                        <p class="font-semibold">Seminar</p>
                        <p class="text-gray-500">Menunggu jadwal: {{ $seminarMenunggu }}, Terjadwal: {{ $seminarTerjadwal }}, Selesai: {{ $seminarSelesai }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 h-2 w-2 rounded-full bg-emerald-500"></span>
                    <div>
                        <p class="font-semibold">Kelulusan</p>
                        <p class="text-gray-500">Lulus (≥C+): {{ $nilaiLulus }}, Tidak lulus (D): {{ $nilaiTidak }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <!-- Ringkasan Aktivitas (kiri) -->
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-base font-semibold text-gray-900">Ringkasan Aktivitas</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl p-4 text-center ring-1 ring-indigo-100 bg-indigo-50">
                <p class="text-xs text-indigo-700">KP Berlangsung</p>
                <p class="mt-1 text-2xl font-semibold text-indigo-900">{{ $kpBerlangsung }}</p>
            </div>
            <div class="rounded-xl p-4 text-center ring-1 ring-emerald-100 bg-emerald-50">
                <p class="text-xs text-emerald-700">KP Selesai</p>
                <p class="mt-1 text-2xl font-semibold text-emerald-900">{{ $kpSelesai }}</p>
            </div>
            <div class="rounded-xl p-4 text-center ring-1 ring-amber-100 bg-amber-50">
                <p class="text-xs text-amber-700">Total Bimbingan</p>
                <p class="mt-1 text-2xl font-semibold text-amber-900">{{ $bimbinganCount }}</p>
            </div>
        </div>
    </div>

    <!-- Distribusi Status KP (kanan) -->
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-900">Distribusi Status KP</h3>
            <span class="text-xs text-gray-500">Total: {{ $totalKP }}</span>
        </div>
        <ul class="space-y-4">
            @forelse($items as $key => $val)
                @php
                    $pct = round(($val / $totalAll) * 100);
                    $label = $labels[$key] ?? ucfirst($key ?: 'Tidak diketahui');
                    $bar = $colors[$key] ?? 'bg-gray-400';
                @endphp
                <li>
                    <div class="mb-1 flex items-center justify-between text-sm">
                        <span class="text-gray-700">{{ $label }}</span>
                        <span class="font-medium text-gray-900">{{ $val }}</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-100">
                        <div class="h-2 rounded-full {{ $bar }}" style="width: {{ $pct }}%"></div>
                    </div>
                </li>
            @empty
                <li class="text-sm text-gray-500">Belum ada data status.</li>
            @endforelse
        </ul>
    </div>
</section>
