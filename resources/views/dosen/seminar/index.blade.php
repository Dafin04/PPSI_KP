<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Penguji Seminar</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left">Mahasiswa</th>
                                <th class="px-4 py-2 text-left">Jadwal</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Catatan Revisi</th>
                                <th class="px-4 py-2 text-left">Input Nilai</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($seminars as $s)
                                    @php
                                        $isPembimbing = optional($s->kerjaPraktek)->dosen_pembimbing_id === auth()->id() || $s->pembimbing_penguji_id === auth()->id();
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-2">{{ $s->mahasiswa->name ?? '-' }}</td>
                                      <td class="px-4 py-2">
                                            {{ optional($s->tanggal_seminar)->format('d M Y') }}<br>
                                            <span class="text-xs text-gray-500">{{ $s->waktu_mulai }} - {{ $s->waktu_selesai }}</span>
                                        </td>
                                        <td class="px-4 py-2">{!! $s->status_badge ?? ucfirst($s->status) !!}</td>
                                        <td class="px-4 py-2 text-gray-700">
                                            @if($s->catatan_revisi)
                                                <p>{{ $s->catatan_revisi }}</p>
                                                <span class="text-xs text-gray-500">Status revisi: {{ str_replace('_',' ', $s->status_revisi ?? '-') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <form method="POST" action="{{ route('dosen.seminar.update', $s) }}" class="flex flex-wrap gap-2 items-center">@csrf
                                                <input name="nilai_ketua_penguji" type="number" step="0.01" placeholder="Ketua" class="w-20 border-gray-300 rounded-md" />
                                                <input name="nilai_anggota_1" type="number" step="0.01" placeholder="Angg 1" class="w-20 border-gray-300 rounded-md" />
                                                <input name="nilai_anggota_2" type="number" step="0.01" placeholder="Angg 2" class="w-20 border-gray-300 rounded-md" />
                                                <input name="nilai_pembimbing" type="number" step="0.01" placeholder="Pemb." class="w-20 border-gray-300 rounded-md" />
                                                <input name="nilai_penguji_angka" type="number" step="0.01" placeholder="Final" class="w-20 border-gray-300 rounded-md" />
                                                <select name="nilai_penguji_huruf" class="border-gray-300 rounded-md text-xs">
                                                    <option value="">Huruf</option>
                                                    @foreach(['A','B','C','D'] as $huruf)
                                                        <option value="{{ $huruf }}">{{ $huruf }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-1 rounded-md">Simpan</button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2 space-y-2">
                                            @if($isPembimbing)
                                                <form method="POST" action="{{ route('dosen.seminar.approve', $s) }}">
                                                    @csrf
                                                    <button class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-1 text-white text-xs hover:bg-emerald-700">Approve Seminar</button>
                                                </form>
                                            @endif

                                            <form method="POST" action="{{ route('dosen.seminar.revisi', $s) }}" class="space-y-1">
                                                @csrf
                                                <input name="catatan_revisi" type="text" class="w-full border-gray-300 rounded-md text-xs" placeholder="Catatan revisi">
                                                <button class="inline-flex items-center rounded-md bg-yellow-500 px-3 py-1 text-white text-xs hover:bg-yellow-600">Minta Revisi</button>
                                            </form>

                                            @if($s->status_revisi === 'menunggu_persetujuan')
                                                <form method="POST" action="{{ route('dosen.seminar.revisi.approve', $s) }}">
                                                    @csrf
                                                    <button class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1 text-white text-xs hover:bg-blue-700">Setujui Revisi</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="px-4 py-3 text-gray-500" colspan="6">Belum ada penugasan seminar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
