<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Usulan Kuota Tahun Depan</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('lapangan.kuota.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg">Ajukan Kuota</a>
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left">Instansi</th>
                                <th class="px-4 py-2 text-left">Tahun</th>
                                <th class="px-4 py-2 text-left">Jumlah</th>
                                <th class="px-4 py-2"></th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($kuotas as $k)
                                <tr>
                                    <td class="px-4 py-2">{{ $k->instansi->nama_instansi ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $k->tahun }}</td>
                                    <td class="px-4 py-2">{{ $k->jumlah }}</td>
                                    <td class="px-4 py-2 text-right"><a href="{{ route('lapangan.kuota.edit', $k) }}" class="text-indigo-600 hover:underline">Edit</a></td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="4">Belum ada usulan kuota.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
