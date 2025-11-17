<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Proposal Kerja Praktek</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end">
                <a href="{{ route('mahasiswa.proposal.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-indigo-700">Unggah Proposal</a>
            </div>

            @if(session('success'))
                <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">{{ session('error') }}</div>
            @endif

            @php $hasNote = \Illuminate\Support\Facades\Schema::hasColumn('proposals','catatan_validasi'); @endphp

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Judul</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                @if($hasNote)
                                    <th class="px-4 py-2 text-left">Catatan Dosen</th>
                                @endif
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($proposals as $p)
                                <tr>
                                    <td class="px-4 py-2">{{ $p->judul }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $p->status ?? ($p->status_validasi ?? '-') }}</td>
                                    @if($hasNote)
                                        <td class="px-4 py-2 text-gray-600">{{ $p->catatan_validasi ?? '-' }}</td>
                                    @endif
                                    <td class="px-4 py-2">{{ optional($p->tanggal_upload ?? $p->created_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('mahasiswa.proposal.edit', $p) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        <form action="{{ route('mahasiswa.proposal.destroy', $p) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus proposal ini?')">@csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-3 text-gray-500">Belum ada proposal.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

