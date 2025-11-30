<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Penguji Seminar</p>
                    <h3 class="text-lg font-semibold text-gray-900">Penilaian & Revisi Seminar KP</h3>
                    <p class="text-sm text-gray-500">Lihat penugasan seminar, lalu buka detail untuk input nilai/revisi.</p>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Mahasiswa</th>
                                    <th class="px-5 py-3">Jadwal</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Penguji</th>
                                    <th class="px-5 py-3 text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($seminars as $s)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="text-gray-900 font-semibold">{{ $s->mahasiswa->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $s->mahasiswa->nim ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-gray-900 font-semibold">{{ optional($s->tanggal_seminar)->format('d M Y') ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $s->waktu_mulai ? $s->waktu_mulai.' - '.$s->waktu_selesai : '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">{!! $s->status_badge ?? ucfirst($s->status) !!}</td>
                                        <td class="px-5 py-4 text-gray-700 space-y-1">
                                            <div class="text-xs text-gray-500">Ketua: <span class="text-gray-900">{{ optional($s->ketuaPenguji)->name ?? '-' }}</span></div>
                                            <div class="text-xs text-gray-500">A1: <span class="text-gray-900">{{ optional($s->anggotaPenguji1)->name ?? '-' }}</span></div>
                                            <div class="text-xs text-gray-500">A2: <span class="text-gray-900">{{ optional($s->anggotaPenguji2)->name ?? '-' }}</span></div>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <a href="{{ route('dosen.seminar.show', $s) }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50 text-sm font-semibold">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="px-6 py-6 text-center text-gray-500" colspan="5">Belum ada penugasan seminar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
