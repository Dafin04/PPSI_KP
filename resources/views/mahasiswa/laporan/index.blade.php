<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Laporan Kerja Praktek</h3>
                        <p class="text-sm text-gray-500">Unggah revisi seminar dan laporan akhir setelah bimbingan terpenuhi.</p>
                    </div>
                    @if($canUploadFinal)
                        <a href="{{ route('mahasiswa.laporan.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Unggah Laporan
                        </a>
                    @else
                        <span class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gray-100 text-gray-500 text-sm font-semibold">
                            Unggah Laporan (terkunci)
                        </span>
                    @endif
                </div>

                <div class="p-6 space-y-4">
                    @if(session('success'))
                        <div class="rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @unless($canUploadFinal)
                        <div class="rounded-xl border border-yellow-100 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                            Minimal 10 bimbingan berstatus disetujui sebelum unggah revisi seminar dan laporan akhir.
                        </div>
                    @endunless

                    @php $hasNote = \Illuminate\Support\Facades\Schema::hasColumn('laporans', 'catatan_validasi'); @endphp

                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Judul</th>
                                    @if($hasNote)
                                        <th class="px-5 py-3">Catatan Dosen</th>
                                    @endif
                                    <th class="px-5 py-3">Tanggal</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($laporans as $l)
                                    @php
                                        $status = $l->status ?? ($l->status_validasi ?? '-');
                                        $judul = $l->judul ?: \App\Models\KerjaPraktek::where('mahasiswa_id', $l->mahasiswa_id)->latest()->value('judul_kp');
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $judul ?? '-' }}</td>
                                        @if($hasNote)
                                            <td class="px-5 py-4 text-gray-600">{{ $l->catatan_validasi ?? '-' }}</td>
                                        @endif
                                        <td class="px-5 py-4 text-gray-700">{{ optional($l->tanggal_upload ?? $l->created_at)->format('d M Y') }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                @if($l->file_laporan)
                                                    <a href="{{ asset('storage/'.$l->file_laporan) }}" target="_blank"
                                                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50"
                                                       title="Lihat lampiran">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5.25v13.5m7.5-7.5h-15" /></svg>
                                                    </a>
                                                @else
                                                    <span class="text-xs text-gray-400">Tidak ada file</span>
                                                @endif
                                                <form action="{{ route('mahasiswa.laporan.destroy', $l) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-red-200 text-red-600 hover:bg-red-50"
                                                            title="Hapus">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $hasNote ? 4 : 3 }}" class="px-6 py-6 text-center text-gray-500">Belum ada laporan.</td>
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
