<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Kuesioner Instansi</p>
                        <h3 class="text-lg font-semibold text-gray-900">Penilaian & Sertifikat</h3>
                        <p class="text-sm text-gray-500">Isi kepuasan, kebutuhan, dan dapatkan sertifikat pembimbing lapangan.</p>
                    </div>
                    <a href="{{ route('lapangan.kuesioner.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Isi Kuesioner
                    </a>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Tanggal</th>
                                    <th class="px-5 py-3">Kuota Tahun Depan</th>
                                    <th class="px-5 py-3">Kepuasan</th>
                                    <th class="px-5 py-3">Saran</th>
                                    <th class="px-5 py-3">Sertifikat</th>
                                    <th class="px-5 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($kuesioners as $k)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $k->created_at->format('d M Y') }}</td>
                                        <td class="px-5 py-4 text-gray-700">{{ $k->kuota_tahun_depan ?? '-' }}</td>
                                        <td class="px-5 py-4 capitalize text-gray-700">{{ str_replace('_',' ', $k->tingkat_kepuasan ?? '-') }}</td>
                                        <td class="px-5 py-4 text-gray-600">{{ Str::limit($k->saran_kegiatan, 60) }}</td>
                                        <td class="px-5 py-4">
                                            @if($k->hasCertificate())
                                                <a href="{{ asset('storage/'.$k->sertifikat_path) }}" target="_blank"
                                                   class="inline-flex items-center gap-1 text-emerald-600 hover:underline">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5l-6-6h4.5v-6h3v6H18l-6 6z" /></svg>
                                                    Unduh Sertifikat
                                                </a>
                                            @else
                                                <span class="text-gray-400">Belum tersedia</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <a href="{{ route('lapangan.kuesioner.edit', $k) }}"
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-amber-200 text-amber-600 hover:bg-amber-50"
                                               title="Edit">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="px-6 py-6 text-center text-gray-500" colspan="6">Belum ada kuesioner.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
