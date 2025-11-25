<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Periode KP</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800">Daftar Periode</h3>
                            <p class="text-sm text-gray-500">Kelola periode aktif/arsip untuk proses KP.</p>
                        </div>
                        <a href="{{ route('admin.periode.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">Tambah Periode</a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left border-b">Tahun Ajaran</th>
                                    <th class="px-4 py-2 text-left border-b">Semester</th>
                                    <th class="px-4 py-2 text-left border-b">Pendaftaran</th>
                                    <th class="px-4 py-2 text-left border-b">Status</th>
                                    <th class="px-4 py-2 text-left border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($periodes as $periode)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b font-medium text-gray-800">{{ $periode->tahun_ajaran }}</td>
                                        <td class="px-4 py-2 border-b">{{ $periode->semester }}</td>
                                        <td class="px-4 py-2 border-b text-sm text-gray-600">
                                            {{ optional($periode->tgl_mulai_pendaftaran)->format('d M Y') ?? '-' }} s/d
                                            {{ optional($periode->tgl_selesai_pendaftaran)->format('d M Y') ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 border-b">
                                            @if($periode->status === 'Aktif')
                                                <span class="px-2 py-1 text-xs rounded-md bg-green-100 text-green-700 font-semibold">Aktif</span>
                                            @elseif($periode->status === 'Ditutup')
                                                <span class="px-2 py-1 text-xs rounded-md bg-yellow-100 text-yellow-700 font-semibold">Ditutup</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-md bg-gray-100 text-gray-700 font-semibold">Arsip</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border-b space-x-2">
                                            @if($periode->status !== 'Aktif')
                                                <form action="{{ route('admin.periode.aktif', $periode) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="inline-flex items-center px-3 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-medium">Set Aktif</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.periode.edit', $periode) }}" class="inline-flex items-center px-3 py-1 rounded-md border border-amber-200 text-amber-700 hover:bg-amber-50 text-xs font-medium">Edit</a>
                                            <form action="{{ route('admin.periode.destroy', $periode) }}" method="POST" class="inline" onsubmit="return confirm('Hapus periode ini? Data tetap ada, tapi periode hilang.');">
                                                @csrf @method('DELETE')
                                                <button class="inline-flex items-center px-3 py-1 rounded-md border border-red-200 text-red-700 hover:bg-red-50 text-xs font-medium">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-500 border-b">Belum ada periode.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>
                        {{ $periodes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
