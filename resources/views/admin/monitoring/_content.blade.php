@php
    use App\Models\KerjaPraktek;
    use App\Models\Bimbingan;
    use App\Models\Seminar;
    use App\Models\Nilai;
    use App\Models\Instansi;

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
    $instansiTop = $instansiTop ?? Instansi::select('instansis.*', \DB::raw('COUNT(kerja_prakteks.id) as total'))
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
                ['label'=>'Pendaftaran (Diajukan)','val'=>$items['diajukan'] ?? 0,'desc'=>'Menunggu verifikasi admin'],
                ['label'=>'Sedang KP','val'=>$items['berlangsung'] ?? 0,'desc'=>'Proses bimbingan berjalan'],
                ['label'=>'Selesai / Kelulusan','val'=>$items['selesai'] ?? 0,'desc'=>'Siap rekap nilai'],
                ['label'=>'Ditolak','val'=>$items['ditolak'] ?? 0,'desc'=>'Perlu pengajuan ulang'],
            ];
        @endphp
        @foreach($chips as $c)
            <div class="rounded-2xl bg-[#1a246a] text-white shadow-sm p-4 border border-[#1a246a] flex flex-col items-center text-center">
                <p class="text-xs font-semibold uppercase tracking-wide text-white/80">{{ $c['label'] }}</p>
                <p class="text-3xl font-bold mt-1">{{ $c['val'] }}</p>
                <p class="text-xs text-white/80 mt-1">{{ $c['desc'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-3xl bg-white border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs uppercase font-semibold text-gray-500">Distribusi</p>
                    <h3 class="text-lg font-semibold text-gray-900">Status KP</h3>
                </div>
                <span class="text-xs text-gray-500">Total: {{ $totalKP }}</span>
            </div>
            <div class="space-y-4">
                @foreach($items as $key => $val)
                    @php
                        $label = $labels[$key] ?? ucfirst($key ?: 'Tidak diketahui');
                        $pct = round(($val / $totalAll) * 100);
                    @endphp
                    <div class="space-y-1">
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>{{ $label }}</span>
                            <span class="font-semibold text-gray-900">{{ $val }} mhs</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full {{ $colors[$key] ?? 'bg-gray-400' }}" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs uppercase font-semibold text-gray-500">Aktivitas</p>
                    <h3 class="text-lg font-semibold text-gray-900">Highlight</h3>
                </div>
            </div>
            <div class="space-y-4 text-sm text-gray-700">
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
                        <p class="text-gray-500">Menunggu: {{ $seminarMenunggu }}, Terjadwal: {{ $seminarTerjadwal }}, Selesai: {{ $seminarSelesai }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 h-2 w-2 rounded-full bg-emerald-500"></span>
                    <div>
                        <p class="font-semibold">Kelulusan</p>
                        <p class="text-gray-500">Lulus (≥ C+): {{ $nilaiLulus }}, Tidak lulus (D): {{ $nilaiTidak }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
