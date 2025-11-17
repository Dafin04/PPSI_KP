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
                <a href="{{ route('mahasiswa.laporan.create') }}"
                   class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-indigo-700">
                    Unggah Laporan
                </a>
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

            @php
                $hasNote = \Illuminate\Support\Facades\Schema::hasColumn('laporans', 'catatan_validasi');
            @endphp

            <!-- Tabel Laporan -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Judul</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                @if($hasNote)
                                    <th class="px-4 py-2 text-left">Catatan Dosen</th>
                                @endif
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($laporans as $l)
                                <tr>
                                    <td class="px-4 py-2">{{ $l->judul }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $l->status ?? ($l->status_validasi ?? '-') }}</td>
                                    @if($hasNote)
                                        <td class="px-4 py-2 text-gray-600">{{ $l->catatan_validasi ?? '-' }}</td>
                                    @endif
                                    <td class="px-4 py-2">{{ optional($l->tanggal_upload ?? $l->created_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('mahasiswa.laporan.edit', $l) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        <form action="{{ route('mahasiswa.laporan.destroy', $l) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Hapus</button>
                                        </form>
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
