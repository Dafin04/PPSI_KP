<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Kerja Praktek
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tombol Upload -->
            <div class="flex justify-end">
                @if($canUploadFinal)
                    <a href="{{ route('mahasiswa.laporan.create') }}"
                       class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-indigo-700">
                        Unggah Laporan
                    </a>
                @else
                    <span class="inline-flex items-center rounded-lg bg-gray-200 px-4 py-2 text-gray-500 text-sm cursor-not-allowed" title="Lengkapi minimal 10 bimbingan disetujui terlebih dahulu">
                        Unggah Laporan (terkunci)
                    </span>
                @endif
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @unless($canUploadFinal)
                <div class="rounded border border-yellow-200 bg-yellow-50 px-4 py-3 text-yellow-800">
                    Minimal 10 bimbingan berstatus disetujui sebelum unggah revisi seminar dan laporan akhir.
                </div>
            @endunless

            @php
                $hasNote = \Illuminate\Support\Facades\Schema::hasColumn('laporans', 'catatan_validasi');
            @endphp

            <!-- Tabel Laporan -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full table-auto border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left border-b">Judul</th>
                                <th class="px-4 py-2 text-left border-b">Status</th>
                                @if($hasNote)
                                    <th class="px-4 py-2 text-left border-b">Catatan Dosen</th>
                                @endif
                                <th class="px-4 py-2 text-left border-b">Tanggal</th>
                                <th class="px-4 py-2 text-left border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($laporans as $l)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b">{{ $l->judul }}</td>
                                    <td class="px-4 py-2 border-b capitalize">{{ $l->status ?? ($l->status_validasi ?? '-') }}</td>
                                    @if($hasNote)
                                        <td class="px-4 py-2 border-b text-gray-600">{{ $l->catatan_validasi ?? '-' }}</td>
                                    @endif
                                    <td class="px-4 py-2 border-b">{{ optional($l->tanggal_upload ?? $l->created_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('mahasiswa.laporan.edit', $l) }}"
                                               class="inline-flex items-center px-3 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-medium">
                                                Edit
                                            </a>
                                            <form action="{{ route('mahasiswa.laporan.destroy', $l) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="inline-flex items-center px-3 py-1 rounded-md border border-red-200 text-red-700 hover:bg-red-50 text-xs font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-gray-500">Belum ada laporan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
