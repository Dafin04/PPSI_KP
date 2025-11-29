<x-app-layout>
    <div class="py-8 space-y-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Instansi & Tawaran KP</h3>
                        <p class="text-sm text-gray-500">Mahasiswa boleh memilih instansi meski kuota penuh, seleksi tetap oleh koordinator.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <form method="GET" action="{{ route('mahasiswa.instansi.index') }}" class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </span>
                            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari instansi / lowongan..."
                                   class="w-full rounded-xl border border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
                        </form>
                        <a href="{{ route('mahasiswa.instansi.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Usulkan Instansi Mandiri
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-6 py-3">Instansi</th>
                                    <th class="px-6 py-3">Lokasi</th>
                                    <th class="px-6 py-3">Kuota Terbaru</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($instansis as $instansi)
                                    @php $kuotaTerbaru = optional($instansi->kuotas->sortByDesc('tahun')->first()); @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-900 font-medium">{{ $instansi->nama_instansi }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $instansi->kota ?? '-' }} {{ $instansi->provinsi ? ' - '.$instansi->provinsi : '' }}</td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $kuotaTerbaru ? $kuotaTerbaru->jumlah . ' mahasiswa (' . $kuotaTerbaru->tahun . ')' : '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if(($instansi->status ?? false))
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Terbuka</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">Belum ada instansi kerja sama terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Lowongan KP Aktif</h3>
                    <p class="text-sm text-gray-500">Lowongan terbaru dari instansi mitra.</p>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-6 py-3">Instansi</th>
                                    <th class="px-6 py-3">Judul Lowongan</th>
                                    <th class="px-6 py-3">Kebutuhan Skill</th>
                                    <th class="px-6 py-3">Kuota</th>
                                    <th class="px-6 py-3">Periode</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($lowonganAktif as $lowongan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-900 font-medium">{{ $lowongan->instansi->nama_instansi ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $lowongan->judul_lowongan }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $lowongan->kebutuhan_keahlian ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $lowongan->jumlah_kuota ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ optional($lowongan->tanggal_mulai)->format('d M Y') }} - {{ optional($lowongan->tanggal_selesai)->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">Belum ada lowongan aktif.</td>
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
