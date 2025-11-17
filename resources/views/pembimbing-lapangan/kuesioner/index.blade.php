<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Kuesioner Instansi</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('lapangan.kuesioner.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg">Isi Kuesioner</a>
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Ringkasan</th>
                                <th class="px-4 py-2"></th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($kuesioners as $k)
                                <tr>
                                    <td class="px-4 py-2">{{ $k->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($k->isi_kuesioner, 80) }}</td>
                                    <td class="px-4 py-2 text-right"><a href="{{ route('lapangan.kuesioner.edit', $k) }}" class="text-indigo-600 hover:underline">Edit</a></td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="3">Belum ada kuesioner.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

