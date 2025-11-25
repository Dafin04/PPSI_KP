<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Instansi & Tawaran KP
        </h2>
    </x-slot>

    <div class="py-10 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm text-gray-600">Mahasiswa bebas memilih instansi meskipun kuota penuh. Seleksi akhir akan ditentukan oleh koordinator.</p>
                <a href="{{ route('mahasiswa.instansi.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">Usulkan Instansi Mandiri</a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Instansi Kerja Sama</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left border-b">Instansi</th>
                                    <th class="px-4 py-2 text-left border-b">Kota</th>
                                    <th class="px-4 py-2 text-left border-b">Kuota Terbaru</th>
                                    <th class="px-4 py-2 text-left border-b">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($instansis as $instansi)
                                    @php
                                        $kuotaTerbaru = optional($instansi->kuotas->sortByDesc('tahun')->first());
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b font-medium text-gray-800">{{ $instansi->nama_instansi }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ $instansi->kota ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">
                                            {{ $kuotaTerbaru ? $kuotaTerbaru->jumlah . ' mahasiswa (' . $kuotaTerbaru->tahun . ')' : '-' }}
                                        </td>
                                        <td class="px-4 py-2 border-b">
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-semibold
                                                {{ ($instansi->status ?? false) ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                                {{ ($instansi->status ?? false) ? 'Terbuka' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">Belum ada instansi kerja sama terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Lowongan KP Aktif</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left border-b">Instansi</th>
                                    <th class="px-4 py-2 text-left border-b">Judul Lowongan</th>
                                    <th class="px-4 py-2 text-left border-b">Kebutuhan Skill</th>
                                    <th class="px-4 py-2 text-left border-b">Kuota</th>
                                    <th class="px-4 py-2 text-left border-b">Periode</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($lowonganAktif as $lowongan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b font-medium text-gray-800">{{ $lowongan->instansi->nama_instansi ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $lowongan->judul_lowongan }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ $lowongan->kebutuhan_keahlian ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $lowongan->jumlah_kuota ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">
                                            {{ optional($lowongan->tanggal_mulai)->format('d M Y') }} - {{ optional($lowongan->tanggal_selesai)->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">Belum ada lowongan aktif.</td>
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
