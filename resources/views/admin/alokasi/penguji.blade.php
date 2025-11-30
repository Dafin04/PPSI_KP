<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alokasi Penguji Seminar</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-sm text-gray-500">Tetapkan ketua/anggota penguji untuk mahasiswa seminar KP</p>
                    <h3 class="text-lg font-semibold text-gray-900">Data Alokasi Penguji</h3>
                </div>

                @if(session('success'))
                    <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                <th class="px-6 py-3">Mahasiswa</th>
                                <th class="px-6 py-3">Judul</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Penguji</th>
                                <th class="px-6 py-3 text-right">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($seminars as $seminar)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $seminar->mahasiswa->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700 line-clamp-2">{{ $seminar->judul_seminar ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ optional($seminar->tanggal_seminar)->format('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700 space-y-1">
                                        <div class="text-xs text-gray-500">Ketua: <span class="text-gray-900">{{ optional($seminar->ketuaPenguji)->name ?? '-' }}</span></div>
                                        <div class="text-xs text-gray-500">A1: <span class="text-gray-900">{{ optional($seminar->anggotaPenguji1)->name ?? '-' }}</span></div>
                                        <div class="text-xs text-gray-500">A2: <span class="text-gray-900">{{ optional($seminar->anggotaPenguji2)->name ?? '-' }}</span></div>
                                        <div class="text-xs text-gray-500">Pembimbing: <span class="text-gray-900">{{ optional($seminar->pembimbingPenguji)->name ?? '-' }}</span></div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.alokasi.penguji.detail', $seminar) }}"
                                           class="inline-flex items-center px-3 py-2 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50 text-sm font-semibold">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $seminars->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
