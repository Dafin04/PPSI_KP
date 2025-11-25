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
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 border-b">Tipe</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 border-b">Isi</th>
                                    <th class="px-4 py-2 border-b"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($kuesioners ?? [] as $k)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b capitalize">{{ $k->tipe }}</td>
                                    <td class="px-4 py-2 border-b">{{ Str::limit($k->isi_kuesioner, 80) }}</td>
                                    <td class="px-4 py-2 border-b text-right">
                                        <a href="{{ route('mahasiswa.kuesioner.edit', $k) }}"
                                           class="inline-flex items-center px-3 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-medium">
                                            Ubah
                                        </a>
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
