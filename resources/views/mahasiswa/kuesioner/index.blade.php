<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kuesioner KP</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-gray-700 font-semibold">Daftar Kuesioner</div>
                        <a href="{{ route('mahasiswa.kuesioner.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg">Isi Kuesioner</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600">Tipe</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600">Isi</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($kuesioners ?? [] as $k)
                                <tr>
                                    <td class="px-4 py-2 capitalize">{{ $k->tipe }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($k->isi_kuesioner, 80) }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('mahasiswa.kuesioner.edit', $k) }}" class="text-indigo-600 hover:underline">Ubah</a>
                                    </td>
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

