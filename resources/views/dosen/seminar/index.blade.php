<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Penguji Seminar</p>
                    <h3 class="text-lg font-semibold text-gray-900">Penilaian & Revisi Seminar KP</h3>
                    <p class="text-sm text-gray-500">Input nilai, beri catatan revisi, dan setujui revisi seminar.</p>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Mahasiswa</th>
                                    <th class="px-5 py-3">Jadwal</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Catatan Revisi</th>
                                    <th class="px-5 py-3">Input Nilai</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($seminars as $s)
                                    @php
                                        $isPembimbing = optional($s->kerjaPraktek)->dosen_pembimbing_id === auth()->id() || $s->pembimbing_penguji_id === auth()->id();
                                        $statusRevisi = $s->status_revisi ?? '-';
                                        $statusColor = match($statusRevisi) {
                                            'butuh_revisi' => 'bg-amber-100 text-amber-700',
                                            'menunggu_persetujuan' => 'bg-yellow-100 text-yellow-700',
                                            'disetujui' => 'bg-green-100 text-green-700',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                    @endphp
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
                                        <td class="px-5 py-4">
                                            <form method="POST" action="{{ route('dosen.seminar.update', $s) }}" class="flex flex-col gap-2">
                                                @csrf
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                    <input name="nilai_ketua_penguji" type="number" step="0.01" placeholder="Ketua" class="w-full rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100" />
                                                    <input name="nilai_anggota_1" type="number" step="0.01" placeholder="Angg 1" class="w-full rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100" />
                                                    <input name="nilai_anggota_2" type="number" step="0.01" placeholder="Angg 2" class="w-full rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100" />
                                                    <input name="nilai_pembimbing" type="number" step="0.01" placeholder="Pemb." class="w-full rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100" />
                                                    <input name="nilai_penguji_angka" type="number" step="0.01" placeholder="Final" class="w-full rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100" />
                                                    <select name="nilai_penguji_huruf" class="w-full rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100">
                                                        <option value="">Huruf</option>
                                                        @foreach(['A','B','C','D'] as $huruf)
                                                            <option value="{{ $huruf }}">{{ $huruf }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex justify-end">
                                                    <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-blue-200 text-blue-700 bg-blue-50 px-3 py-1.5 text-xs font-semibold hover:bg-blue-100">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                        Simpan Nilai
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex flex-col gap-2">
                                                @if($isPembimbing)
                                                    <form method="POST" action="{{ route('dosen.seminar.approve', $s) }}">
                                                        @csrf
                                                        <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-emerald-200 text-emerald-700 bg-emerald-50 px-3 py-1.5 text-xs font-semibold hover:bg-emerald-100">
                                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                            Approve Seminar
                                                        </button>
                                                    </form>
                                                @endif

                                                <form method="POST" action="{{ route('dosen.seminar.revisi', $s) }}" class="space-y-2">
                                                    @csrf
                                                    <input name="catatan_revisi" type="text" class="w-full rounded-lg border-gray-200 text-xs focus:border-blue-500 focus:ring-blue-100" placeholder="Catatan revisi">
                                                    <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-amber-200 text-amber-700 bg-amber-50 px-3 py-1.5 text-xs font-semibold hover:bg-amber-100">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                                        Minta Revisi
                                                    </button>
                                                </form>

                                                @if($s->status_revisi === 'menunggu_persetujuan')
                                                    <form method="POST" action="{{ route('dosen.seminar.revisi.approve', $s) }}">
                                                        @csrf
                                                        <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-blue-200 text-blue-700 bg-blue-50 px-3 py-1.5 text-xs font-semibold hover:bg-blue-100">
                                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                            Setujui Revisi
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="px-6 py-6 text-center text-gray-500" colspan="6">Belum ada penugasan seminar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
