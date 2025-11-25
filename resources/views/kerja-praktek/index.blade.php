<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kerja Praktek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Daftar Pendaftaran Kerja Praktek</h3>
                        @if(auth()->user()->hasRole('mahasiswa'))
                            <a href="{{ route('kerja-praktek.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Daftar KP Baru
                            </a>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left border-b">Judul KP</th>
                                    <th class="px-4 py-2 text-left border-b">Mahasiswa</th>
                                    <th class="px-4 py-2 text-left border-b">Instansi</th>
                                    <th class="px-4 py-2 text-left border-b">Dosen Pembimbing</th>
                                    <th class="px-4 py-2 text-left border-b">Status</th>
                                    <th class="px-4 py-2 text-left border-b">Tanggal Mulai</th>
                                    <th class="px-4 py-2 text-left border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($kerjaPrakteks as $kp)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b">{{ Str::limit($kp->judul_kp, 50) }}</td>
                                        <td class="px-4 py-2 border-b">{{ $kp->mahasiswa->name }}</td>
                                        <td class="px-4 py-2 border-b">{{ $kp->instansi->nama_instansi }}</td>
                                        <td class="px-4 py-2 border-b">{{ $kp->dosenPembimbing->name ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">
                                            {!! $kp->getStatusBadgeAttribute() !!}
                                        </td>
                                        <td class="px-4 py-2 border-b">{{ optional($kp->tanggal_mulai)->format('d/m/Y') ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('kerja-praktek.show', $kp) }}"
                                                   class="inline-flex items-center px-3 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-medium">
                                                    Lihat
                                                </a>
                                                @if($kp->isEditable() && $kp->mahasiswa_id === auth()->id())
                                                    <a href="{{ route('kerja-praktek.edit', $kp) }}"
                                                       class="inline-flex items-center px-3 py-1 rounded-md border border-amber-200 text-amber-700 hover:bg-amber-50 text-xs font-medium">
                                                        Edit
                                                    </a>
                                                @endif
                                                @if($kp->status === 'draft' && $kp->mahasiswa_id === auth()->id())
                                                    <form action="{{ route('kerja-praktek.submit', $kp) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1 rounded-md border border-green-200 text-green-700 hover:bg-green-50 text-xs font-medium"
                                                                onclick="return confirm('Apakah Anda yakin ingin mengajukan pendaftaran ini?')">
                                                            Ajukan
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                            Belum ada pendaftaran kerja praktek.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($kerjaPrakteks->hasPages())
                        <div class="mt-4">
                            {{ $kerjaPrakteks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
