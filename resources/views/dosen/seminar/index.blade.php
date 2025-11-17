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
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Nilai Akhir</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($seminars as $s)
                                <tr>
                                    <td class="px-4 py-2">{{ $s->mahasiswa->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ optional($s->tanggal_seminar)->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ $s->nilai_akhir_seminar }}</td>
                                    <td class="px-4 py-2">
                                        <form method="POST" action="{{ route('dosen.seminar.update', $s) }}" class="flex flex-wrap gap-2 items-center">@csrf
                                            <input name="nilai_ketua_penguji" type="number" step="0.01" placeholder="Ketua" class="w-24 border-gray-300 rounded-md" />
                                            <input name="nilai_anggota_1" type="number" step="0.01" placeholder="Anggota 1" class="w-24 border-gray-300 rounded-md" />
                                            <input name="nilai_anggota_2" type="number" step="0.01" placeholder="Anggota 2" class="w-24 border-gray-300 rounded-md" />
                                            <input name="nilai_pembimbing" type="number" step="0.01" placeholder="Pembimbing" class="w-24 border-gray-300 rounded-md" />
                                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-3 py-1 rounded-md">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="4">Belum ada penugasan seminar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

