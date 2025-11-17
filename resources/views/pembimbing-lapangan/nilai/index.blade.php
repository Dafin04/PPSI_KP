<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Nilai Lapangan</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('lapangan.nilai.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg">Input Nilai</a>
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left">Mahasiswa</th>
                                <th class="px-4 py-2 text-left">Nilai Lapangan</th>
                                <th class="px-4 py-2"></th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($nilais as $n)
                                <tr>
                                    <td class="px-4 py-2">{{ $n->mahasiswa->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $n->nilai_lapangan }}</td>
                                    <td class="px-4 py-2 text-right"><a href="{{ route('lapangan.nilai.edit', $n) }}" class="text-indigo-600 hover:underline">Edit</a></td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="3">Belum ada nilai.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

