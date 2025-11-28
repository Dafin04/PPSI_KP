<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Periode KP</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Atur periode aktif dan arsip untuk siklus KP</p>
                        <h3 class="text-lg font-semibold text-gray-900">Data Periode KP</h3>
                    </div>
                    <a href="{{ route('admin.periode.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Periode
                    </a>
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
                                <th class="px-6 py-3">Tahun Ajaran</th>
                                <th class="px-6 py-3">Semester</th>
                                <th class="px-6 py-3">Pendaftaran</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($periodes as $periode)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $periode->tahun_ajaran }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $periode->semester }}</td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ optional($periode->tgl_mulai_pendaftaran)->format('d M Y') ?? '-' }} s/d
                                        {{ optional($periode->tgl_selesai_pendaftaran)->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($periode->status === 'Aktif')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                        @elseif($periode->status === 'Ditutup')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Ditutup</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">Arsip</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            @if($periode->status !== 'Aktif')
                                                <form action="{{ route('admin.periode.aktif', $periode) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="p-2 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50" title="Set aktif">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                        <span class="sr-only">Set aktif</span>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.periode.edit', $periode) }}" class="p-2 rounded-lg border border-amber-200 text-amber-700 hover:bg-amber-50" title="Edit">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                                <span class="sr-only">Edit</span>
                                            </a>
                                            <form action="{{ route('admin.periode.destroy', $periode) }}" method="POST" class="inline" onsubmit="event.preventDefault(); if (confirm('Hapus periode ini? Data tetap ada, tapi periode hilang.')) this.submit();">
                                                @csrf @method('DELETE')
                                                <button class="p-2 rounded-lg border border-red-200 text-red-700 hover:bg-red-50" title="Hapus">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                    <span class="sr-only">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-gray-500">Belum ada periode.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $periodes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
