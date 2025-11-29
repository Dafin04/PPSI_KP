<x-app-layout>
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Dashboard Pembimbing Lapangan</h1>
                    <p class="text-sm text-gray-600">Pantau penilaian lapangan, kuesioner, dan usulan kuota.</p>
                </div>
                <div class="flex items-center gap-3 bg-white border border-gray-100 rounded-full px-4 py-2 shadow-sm">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 font-semibold flex items-center justify-center">
                        {{ strtoupper(substr(auth()->user()->name ?? 'PL',0,1)) }}
                    </div>
                    <div class="text-sm">
                        <p class="font-semibold text-gray-900">{{ auth()->user()->name ?? auth()->user()->nama }}</p>
                        <p class="text-gray-500 text-xs">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi & Tips -->
            <div class="space-y-3 text-sm">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span class="text-pink-500">📢</span> Informasi & Pengumuman
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">
                    <p class="font-semibold">👋 Halo, {{ auth()->user()->name ?? 'Pembimbing Lapangan' }}!</p>
                    <p>Pastikan penilaian lapangan diisi tepat waktu dan kuesioner di-submit untuk menerbitkan sertifikat.</p>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-900">
                    <p class="font-semibold flex items-center gap-2">
                        <span class="text-lg">💡</span>Tips
                    </p>
                    <ul class="list-disc list-inside space-y-1 mt-1">
                        <li>Isi kuesioner setelah mahasiswa selesai KP.</li>
                        <li>Terbitkan sertifikat pembimbing lapangan dari halaman kuesioner.</li>
                        <li>Ajukan kuota tahun depan bila siap menerima mahasiswa baru.</li>
                    </ul>
                </div>
                </div>
            </div>

            <!-- Statistik cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $statCards = [
                        ['label' => 'Nilai Lapangan', 'desc' => 'Total penilaian diberikan', 'value' => $nilaiCount ?? 0],
                        ['label' => 'Kuesioner', 'desc' => 'Kuesioner dikirim', 'value' => $kuesionerCount ?? 0],
                        ['label' => 'Usulan Kuota', 'desc' => 'Kuota diajukan', 'value' => $kuotaCount ?? 0],
                        ['label' => 'Instansi Terdata', 'desc' => 'Instansi terdaftar', 'value' => $instansiCount ?? 0],
                    ];
                @endphp
                @foreach($statCards as $card)
                    <div class="rounded-3xl bg-[#1a246a] text-white p-4 shadow-sm text-center flex flex-col items-center justify-center">
                        <p class="text-xs font-semibold uppercase tracking-widest">{{ $card['label'] }}</p>
                        <p class="text-3xl font-bold mt-1">{{ $card['value'] }}</p>
                        <p class="text-sm text-white/80 mt-1">{{ $card['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Ringkasan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @php
                    $chartItems = [
                        ['label' => 'Nilai Lapangan', 'val' => $nilaiCount ?? 0, 'color' => '#3b82f6'],
                        ['label' => 'Kuesioner', 'val' => $kuesionerCount ?? 0, 'color' => '#10b981'],
                        ['label' => 'Usulan Kuota', 'val' => $kuotaCount ?? 0, 'color' => '#f59e0b'],
                        ['label' => 'Instansi Terdata', 'val' => $instansiCount ?? 0, 'color' => '#6366f1'],
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
                                    <div class="flex items-center gap-3 min-w-[140px]">
                                        <span class="w-3 h-3 rounded-full" style="background: {{ $item['color'] }}"></span>
                                        <span class="font-medium">{{ $item['label'] }}</span>
                                    </div>
                                    <span class="text-gray-900 font-semibold">{{ $item['val'] }} ({{ $pct }}%)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-gray-100 bg-white p-6">
                    <p class="text-base font-semibold text-gray-900 mb-3">Highlight</p>
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Isi kuesioner untuk mendapatkan sertifikat PL.</li>
                        <li>Review nilai lapangan sebelum disinkronkan ke sistem KP.</li>
                        <li>Ajukan kuota lebih awal untuk periode berikut.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
