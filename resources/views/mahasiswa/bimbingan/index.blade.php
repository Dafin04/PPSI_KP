<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Bimbingan Kerja Praktek</h3>
                        <p class="text-sm text-gray-500">Catat sesi bimbingan, pantau status persetujuan dosen, dan unggah lampiran.</p>
                    </div>
                    <a href="{{ route('mahasiswa.bimbingan.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Bimbingan
                    </a>
                </div>

                <div class="p-6 space-y-4">
                    @if(session('success'))
                        <div class="rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                        Progres bimbingan disetujui: <strong>{{ $approvedBimbinganCount }}/{{ $minimumBimbingan }}</strong>. Minimal {{ $minimumBimbingan }} sesi disetujui sebelum pengajuan seminar dan unggah laporan akhir.
                    </div>

                    @if($bimbingans->isEmpty())
                        <p class="text-gray-500">Belum ada data bimbingan.</p>
                    @else
                        <div class="overflow-x-auto border border-gray-100 rounded-xl">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                        <th class="px-5 py-3">Tanggal</th>
                                        <th class="px-5 py-3">Topik & Hasil</th>
                                        <th class="px-5 py-3">Metode</th>
                                        <th class="px-5 py-3">Durasi</th>
                                        <th class="px-5 py-3">Status</th>
                                        <th class="px-5 py-3">Lampiran</th>
                                        <th class="px-5 py-3">Dosen</th>
                                        <th class="px-5 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($bimbingans as $bimbingan)
                                        @php
                                            $status = $bimbingan->status ?? 'menunggu';
                                            $statusColor = match($status) {
                                                'disetujui' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                                'selesai' => 'bg-blue-100 text-blue-700',
                                                default => 'bg-yellow-100 text-yellow-700'
                                            };
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-5 py-4 text-gray-900 font-medium whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($bimbingan->tanggal_bimbingan)->format('d M Y') ?? '-' }}
                                                <div class="text-xs text-gray-500">{{ $bimbingan->waktu_bimbingan ?? '' }}</div>
                                            </td>
                                            <td class="px-5 py-4">
                                                <div class="text-gray-900 font-semibold">{{ $bimbingan->topik_bimbingan ?? '-' }}</div>
                                                <div class="text-xs text-gray-600 line-clamp-2">{{ $bimbingan->hasil_bimbingan ?? '-' }}</div>
                                            </td>
                                            <td class="px-5 py-4 text-gray-700 capitalize">{{ $bimbingan->metode ?? '-' }}</td>
                                            <td class="px-5 py-4 text-gray-700">{{ $bimbingan->durasi_menit ?? '-' }} menit</td>
                                            <td class="px-5 py-4">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4 text-gray-700">
                                                @if($bimbingan->file_lampiran)
                                                    <a href="{{ asset('storage/' . $bimbingan->file_lampiran) }}" target="_blank"
                                                       class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25L4.75 10 9 5.75M4.75 10H15a2.25 2.25 0 012.25 2.25v6" /></svg>
                                                        Lihat
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-4 text-gray-900">{{ $bimbingan->dosen->nama ?? '-' }}</td>
                                            <td class="px-5 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('mahasiswa.bimbingan.edit', $bimbingan->id) }}"
                                                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-amber-200 text-amber-600 hover:bg-amber-50"
                                                       title="Edit">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                                    </a>
                                                    <form action="{{ route('mahasiswa.bimbingan.destroy', $bimbingan->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
