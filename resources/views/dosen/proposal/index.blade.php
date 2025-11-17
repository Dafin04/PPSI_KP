<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Validasi Judul/Proposal</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left">Mahasiswa</th>
                                <th class="px-4 py-2 text-left">Judul</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($proposals as $p)
                                <tr>
                                    <td class="px-4 py-2">{{ optional(optional($p->mahasiswa)->user)->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $p->judul }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $p->status }}</td>
                                    <td class="px-4 py-2">
                                        @php $hasCatatan = Schema::hasColumn('proposals','catatan_validasi'); @endphp
                                        <div class="space-y-2">
                                            @if($hasCatatan)
                                                <form method="POST" action="{{ route('dosen.proposal.approve', $p) }}" class="inline">@csrf
                                                    <input type="text" name="catatan_validasi" placeholder="Catatan (opsional)" class="border-gray-300 rounded-md text-sm" />
                                                    <button class="ml-2 text-green-600 hover:underline">Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('dosen.proposal.reject', $p) }}" class="inline ml-2">@csrf
                                                    <input type="text" name="catatan_validasi" placeholder="Alasan (opsional)" class="border-gray-300 rounded-md text-sm" />
                                                    <button class="ml-2 text-red-600 hover:underline">Tolak</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('dosen.proposal.approve', $p) }}" class="inline">@csrf
                                                    <button class="text-green-600 hover:underline">Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('dosen.proposal.reject', $p) }}" class="inline ml-2">@csrf
                                                    <button class="text-red-600 hover:underline">Tolak</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="4">Belum ada proposal.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
