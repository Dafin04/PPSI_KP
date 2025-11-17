<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring & Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Ringkasan Utama -->
            <section>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <x-stat-card label="Total KP" :value="$totalKP" color="blue" />
                    <x-stat-card label="KP Berlangsung" :value="$kpBerlangsung" color="indigo" />
                    <x-stat-card label="KP Selesai" :value="$kpSelesai" color="emerald" />
                    <x-stat-card label="Total Bimbingan" :value="$bimbinganCount" color="amber" />
                </div>
            </section>

            @php
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

            <!-- Top Instansi table -->
            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-gray-900">Instansi Dengan KP Terbanyak</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full overflow-hidden rounded-lg text-sm">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium">Instansi</th>
                                <th class="px-4 py-2 text-left font-medium">Total KP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($instansiTop as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $row->instansi->nama_instansi ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-gray-900">{{ $row->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-4 text-gray-500" colspan="2">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
