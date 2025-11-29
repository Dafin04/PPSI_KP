<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Seminar KP</h3>
                        <p class="text-sm text-gray-500">Ajukan seminar, pantau status revisi, dan lihat jadwal.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 text-sm text-gray-600">
                        <span class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 border border-blue-100">
                            Bimbingan disetujui: <strong class="ml-1">{{ $approvedBimbinganCount }}/10</strong>
                        </span>
                        <a href="{{ route('mahasiswa.seminar.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Ajukan Seminar
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Tanggal</th>
                                    <th class="px-5 py-3">Judul</th>
                                    <th class="px-5 py-3">Metode/Tempat</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Revisi</th>
                                    <th class="px-5 py-3">Penguji/Pembimbing</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($seminars as $s)
                                    @php
                                        $statusRevisi = $s->status_revisi ?? '-';
                                        $statusColor = match($statusRevisi) {
                                            'butuh_revisi' => 'bg-amber-100 text-amber-700',
                                            'menunggu_persetujuan' => 'bg-yellow-100 text-yellow-700',
                                            'disetujui' => 'bg-green-100 text-green-700',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-gray-900 font-semibold">{{ optional($s->tanggal_seminar)->format('d M Y') ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $s->waktu_mulai ? $s->waktu_mulai.' - '.$s->waktu_selesai : '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-gray-900 font-semibold">{{ $s->judul_seminar }}</div>
                                            <div class="text-xs text-gray-600 line-clamp-2">{{ $s->abstrak ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            <div class="capitalize">{{ $s->metode ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $s->tempat ?? $s->link_online ?? '-' }}</div>
                                        </td>
                                        <td class="px-5 py-4">{!! $s->status_badge ?? ucfirst($s->status) !!}</td>
                                        <td class="px-5 py-4">
                                            @if($s->catatan_revisi)
                                                <div class="text-sm text-gray-800">{{ $s->catatan_revisi }}</div>
                                                <span class="inline-flex items-center px-2.5 py-1 mt-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                                    {{ str_replace('_',' ', $statusRevisi) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-900">
                                            <div class="font-semibold">{{ $s->pembimbingPenguji->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $s->pembimbingPenguji->role ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                @if($s->status_revisi === 'butuh_revisi')
                                                    <form method="POST" action="{{ route('mahasiswa.seminar.revisi', $s) }}" enctype="multipart/form-data" class="flex flex-col gap-2 w-48">
                                                        @csrf
                                                        <input type="file" name="file_revisi" accept=".pdf,.doc,.docx"
                                                               class="rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100" required>
                                                        <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-emerald-200 text-emerald-700 bg-emerald-50 px-3 py-1.5 text-xs font-semibold hover:bg-emerald-100">
                                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                                            Unggah Revisi
                                                        </button>
                                                    </form>
                                                @elseif($s->status_revisi === 'menunggu_persetujuan')
                                                    <span class="text-xs text-gray-500">Menunggu persetujuan penguji</span>
                                                @elseif($s->status_revisi === 'disetujui')
                                                    <span class="text-xs text-green-600">Revisi disetujui</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">Belum ada pengajuan seminar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
