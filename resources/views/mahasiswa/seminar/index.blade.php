<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Seminar</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Bimbingan disetujui: <strong>{{ $approvedBimbinganCount }}/10</strong>. Pengajuan seminar hanya diproses setelah minimal 10 bimbingan disetujui.
                </div>
                <a href="{{ route('mahasiswa.seminar.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-indigo-700">Ajukan Seminar</a>
            </div>

            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Judul</th>
                                <th class="px-4 py-2 text-left">Metode</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Revisi</th>
                                <th class="px-4 py-2 text-left">Penguji/Pembimbing</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($seminars as $s)
                                <tr>
                                    <td class="px-4 py-2">{{ optional($s->tanggal_seminar)->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ $s->judul_seminar }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $s->metode ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        {!! $s->status_badge ?? ucfirst($s->status) !!}
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($s->catatan_revisi)
                                            <p class="text-sm text-gray-700">{{ $s->catatan_revisi }}</p>
                                            <span class="text-xs text-gray-500">Status: {{ str_replace('_',' ', $s->status_revisi ?? '-') }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $s->pembimbingPenguji->name ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        @if($s->status_revisi === 'butuh_revisi')
                                            <form method="POST" action="{{ route('mahasiswa.seminar.revisi', $s) }}" enctype="multipart/form-data" class="space-y-2">
                                                @csrf
                                                <input type="file" name="file_revisi" accept=".pdf,.doc,.docx" required class="w-full text-sm border-gray-300 rounded-md">
                                                <button class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-1 text-white text-xs hover:bg-emerald-700">Unggah Revisi</button>
                                            </form>
                                        @elseif($s->status_revisi === 'menunggu_persetujuan')
                                            <span class="text-xs text-gray-500">Menunggu persetujuan dosen penguji</span>
                                        @elseif($s->status_revisi === 'disetujui')
                                            <span class="text-xs text-green-600">Revisi disetujui</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="7">Belum ada pengajuan seminar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
