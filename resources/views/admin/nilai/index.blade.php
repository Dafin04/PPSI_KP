<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-indigo-600 font-semibold">Nilai Data KP</p>
            <h2 class="text-2xl font-bold text-gray-900">Rekap Nilai Mahasiswa</h2>
            <p class="text-sm text-gray-600">Lihat nilai pembimbing, seminar, dan lapangan. Set huruf akhir.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Nilai KP</h3>
                        <p class="text-sm text-gray-500">Bobot rata-rata 3 komponen (pembimbing, seminar, lapangan).</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Mahasiswa</th>
                                    <th class="px-5 py-3 text-center">Nilai Pembimbing</th>
                                    <th class="px-5 py-3 text-center">Nilai Seminar</th>
                                    <th class="px-5 py-3 text-center">Nilai Lapangan</th>
                                    <th class="px-5 py-3 text-center">Total (avg)</th>
                                    <th class="px-5 py-3 text-center">Huruf Akhir</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($records as $r)
                                    @php
                                        $p = $r->nilai_pembimbing;
                                        $s = $r->nilai_seminar;
                                        $l = $r->nilai_lapangan;
                                        $total = null;
                                        if(!is_null($p) && !is_null($s) && !is_null($l)){
                                            $total = round(($p + $s + $l) / 3, 2);
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="text-gray-900 font-semibold">{{ $r->mahasiswa->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $r->mahasiswa->nim ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-center text-gray-800">{{ $p ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center text-gray-800">{{ $s ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center text-gray-800">{{ $l ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center font-semibold text-gray-900">{{ $total ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @if($r->exists)
                                        <form method="POST" action="{{ route('admin.nilai.update', $r) }}" class="inline-flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <select name="nilai_mutu" class="rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-100">
                                                <option value="">--</option>
                                                @foreach(['A','B','C','D'] as $huruf)
                                                    <option value="{{ $huruf }}" @selected($r->nilai_mutu === $huruf)>{{ $huruf }}</option>
                                                @endforeach
                                            </select>
                                            <button class="inline-flex items-center justify-center rounded-lg border border-blue-200 text-blue-700 bg-blue-50 px-3 py-1.5 text-xs font-semibold hover:bg-blue-100">
                                                Simpan
                                            </button>
                                        </form>
                                        @else
                                            <span class="text-xs text-gray-400">Belum bisa rekap</span>
                                        @endif
                                    </td>
                                        <td class="px-5 py-4 text-center text-xs text-gray-500">
                                            @if($total)
                                                <span class="text-green-600 font-semibold">Siap direkap</span>
                                            @else
                                                <span class="text-amber-600 font-semibold">Menunggu nilai lengkap</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="px-6 py-6 text-center text-gray-500">Belum ada nilai.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
