<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Instansi</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Data Instansi</h3>
                        <p class="text-sm text-gray-500">Daftar instansi mitra KP</p>

                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <form method="GET" action="{{ route('admin.instansi.index') }}" class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </span>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari instansi..."
                                   class="w-full rounded-xl border border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
                        </form>
                        <a href="{{ route('admin.instansi.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Tambah Instansi
                        </a>
                    </div>
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
                                <th class="px-6 py-3">Nama Instansi</th>
                                <th class="px-6 py-3">Kontak</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Verifikasi</th>
                                <th class="px-6 py-3">Pembimbing Lapangan</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($instansis as $instansi)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $instansi->nama_instansi }}</td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $instansi->kontak ?? $instansi->telepon ?? $instansi->kontak_person ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(($instansi->status ?? $instansi->status_aktif ?? false))
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Tidak aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $v = $instansi->status_verifikasi ?? null; @endphp
                                        @if($v === 'disetujui')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700">Disetujui</span>
                                        @elseif($v === 'ditolak')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">Ditolak</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $instansi->pembimbingLapangans->count() }} terdaftar
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                        @if(($instansi->status_verifikasi ?? 'pending') === 'pending')
                                            <form method="POST" action="{{ route('admin.instansi.verify', $instansi) }}" class="inline">@csrf
                                                <button class="p-2 rounded-lg border border-green-200 text-green-700 hover:bg-green-50" title="Setujui">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    <span class="sr-only">Setujui</span>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.instansi.reject', $instansi) }}" class="inline">@csrf
                                                <button class="p-2 rounded-lg border border-red-200 text-red-700 hover:bg-red-50" title="Tolak">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    <span class="sr-only">Tolak</span>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.instansi.edit', $instansi) }}" class="p-2 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50" title="Edit">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.instansi.destroy', $instansi) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg border border-red-200 text-red-700 hover:bg-red-50"
                                                onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus instansi ini?')) { this.closest('form').submit(); }" title="Hapus">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                <span class="sr-only">Hapus</span>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                        Tidak ada data instansi.
                                        <a href="{{ route('admin.instansi.create') }}" class="text-blue-600 font-semibold hover:underline ml-1">Tambah instansi</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $instansis->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
