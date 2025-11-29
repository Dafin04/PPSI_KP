<x-app-layout>
@php
    $totalCards = max(($kpAktifCount ?? 0) + ($bimbinganCount ?? 0) + ($laporanCount ?? 0) + ($seminarCount ?? 0), 1);
    $statusCards = [
        [
            'label' => 'KP Aktif',
            'value' => $kpAktifCount ?? 0,
            'desc' => 'Pengajuan/instansi aktif',
        ],
        [
            'label' => 'Sesi Bimbingan',
            'value' => $bimbinganCount ?? 0,
            'desc' => 'Total sesi bimbingan',
        ],
        [
            'label' => 'Laporan Terunggah',
            'value' => $laporanCount ?? 0,
            'desc' => 'Laporan yang diunggah',
        ],
        [
            'label' => 'Seminar',
            'value' => $seminarCount ?? 0,
            'desc' => 'Ajukan/cek jadwal seminar',
        ],
    ];
@endphp
    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
            {{-- Top bar: judul kiri, profil kanan --}}
            <div class="flex items-start gap-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Mahasiswa</h1>
                    <p class="text-sm text-gray-600">Pantau progres KP Anda: pengajuan, bimbingan, seminar, hingga laporan.</p>
                </div>
                <div class="flex items-center gap-3 px-4 py-2 rounded-full border bg-white shadow-sm self-start">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold">
                        {{ strtoupper(Str::substr(auth()->user()->name ?? auth()->user()->nama ?? 'M', 0, 1)) }}
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? auth()->user()->nama }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            {{-- Informasi & Pengumuman --}}
            <div class="space-y-3 text-sm">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span class="text-pink-500">📣</span> Informasi & Pengumuman
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 shadow-sm">
                        <div class="flex gap-3 items-start text-blue-800">
                            <span class="text-xl">👋</span>
                            <div>
                                <p class="font-semibold text-blue-900 text-base">Halo, {{ auth()->user()->name ?? 'Mahasiswa' }}!</p>
                                <p class="text-blue-800 mt-1">
                                    Pastikan data KP, jadwal bimbingan, dan seminar kamu selalu up to date. Cek aksi cepat di bawah untuk memulai.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 shadow-sm">
                        <div class="flex gap-3 items-start text-emerald-800">
                            <span class="text-xl">💡</span>
                            <div>
                                <p class="font-semibold text-emerald-900 text-base">Tips Progres KP</p>
                                <ul class="text-emerald-800 mt-1 list-disc list-inside space-y-1">
                                    <li>Minimal 10 bimbingan sebelum unggah laporan</li>
                                    <li>Jadwalkan bimbingan tanpa tanggal ganda</li>
                                    <li>Unggah proposal saat pengajuan instansi</li>
                                    <li>Pastikan seminar terjadwal sebelum revisi akhir</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status KP ala admin (warna biru, gabungan statistik) --}}
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($statusCards as $card)
                    <div class="bg-[#1a246a] text-white rounded-3xl p-5 text-center shadow-sm">
                        <p class="text-xs font-semibold tracking-wide uppercase">{{ strtoupper($card['label']) }}</p>
                        <p class="text-3xl font-semibold mt-2">{{ $card['value'] }}</p>
                        <p class="text-sm mt-2 text-white/80">{{ $card['desc'] }}</p>
                    </div>
                @endforeach
            </section>

            {{-- Ringkasan & Grafik sederhana --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @php
                    $chartItems = [
                        ['label' => 'KP Aktif', 'val' => $kpAktifCount ?? 0, 'color' => '#3b82f6'],
                        ['label' => 'Bimbingan', 'val' => $bimbinganCount ?? 0, 'color' => '#10b981'],
                        ['label' => 'Laporan', 'val' => $laporanCount ?? 0, 'color' => '#f59e0b'],
                        ['label' => 'Seminar', 'val' => $seminarCount ?? 0, 'color' => '#6366f1'],
                    ];
                    $totalVal = max(array_sum(array_column($chartItems, 'val')), 1);
                    $angles = [];
                    $cursor = 0;
                    foreach ($chartItems as $item) {
                        $deg = ($item['val'] / $totalVal) * 360;
                        $angles[] = [$cursor, $cursor + $deg, $item['color']];
                        $cursor += $deg;
                    }
                    $gradientParts = collect($angles)->map(fn($a) => "{$a[2]} {$a[0]}deg {$a[1]}deg")->implode(', ');
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Ringkasan Progres</h3>
                    </div>
                    <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-center sm:justify-center sm:gap-12">
                        <div class="relative w-40 h-40">
                            <div class="w-full h-full rounded-full" style="background: conic-gradient({{ $gradientParts }}), #e5e7eb;"></div>
                            <div class="absolute inset-4 bg-white rounded-full flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="text-xl font-semibold text-gray-900">{{ $totalVal }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3 text-sm text-gray-700 w-full sm:w-72 text-center sm:text-left">
                            @foreach($chartItems as $item)
                                @php $pct = round(($item['val'] / $totalVal) * 100); @endphp
                                <div class="flex items-center justify-between gap-6">
                                    <div class="flex items-center gap-3 min-w-[120px]">
                                        <span class="w-3 h-3 rounded-full" style="background: {{ $item['color'] }}"></span>
                                        <span class="font-medium">{{ $item['label'] }}</span>
                                    </div>
                                    <span class="text-gray-900 font-semibold">{{ $item['val'] }} ({{ $pct }}%)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Highlight</h3>
                    </div>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li>• Pastikan jadwal bimbingan minimal 10 kali sebelum unggah laporan.</li>
                        <li>• Pantau status seminar Anda setelah dosen menjadwalkan.</li>
                        <li>• Perbarui profil mahasiswa dan dokumen pendukung.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
