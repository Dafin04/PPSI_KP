<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Seminar</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end">
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
                                <th class="px-4 py-2 text-left">Penguji/Pembimbing</th>
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
                                    <td class="px-4 py-2">{{ $s->pembimbingPenguji->name ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="5">Belum ada pengajuan seminar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

