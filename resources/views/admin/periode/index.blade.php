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
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Tahun Ajaran</th>
                                    <th class="px-4 py-2 text-left">Semester</th>
                                    <th class="px-4 py-2 text-left">Pendaftaran</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($periodes as $periode)
                                    <tr>
                                        <td class="px-4 py-2 font-medium text-gray-800">{{ $periode->tahun_ajaran }}</td>
                                        <td class="px-4 py-2">{{ $periode->semester }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            {{ optional($periode->tgl_mulai_pendaftaran)->format('d M Y') ?? '-' }} s/d
                                            {{ optional($periode->tgl_selesai_pendaftaran)->format('d M Y') ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            @if($periode->status === 'Aktif')
                                                <span class="px-2 py-1 text-xs rounded-md bg-green-100 text-green-700 font-semibold">Aktif</span>
                                            @elseif($periode->status === 'Ditutup')
                                                <span class="px-2 py-1 text-xs rounded-md bg-yellow-100 text-yellow-700 font-semibold">Ditutup</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-md bg-gray-100 text-gray-700 font-semibold">Arsip</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 space-x-2">
                                            @if($periode->status !== 'Aktif')
                                                <form action="{{ route('admin.periode.aktif', $periode) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="text-blue-600 hover:underline text-sm">Set Aktif</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.periode.edit', $periode) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                                            <form action="{{ route('admin.periode.destroy', $periode) }}" method="POST" class="inline" onsubmit="return confirm('Hapus periode ini? Data tetap ada, tapi periode hilang.');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:underline text-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada periode.</td>
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
