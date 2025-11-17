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
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left">Judul KP</th>
                                    <th class="px-4 py-2 text-left">Mahasiswa</th>
                                    <th class="px-4 py-2 text-left">Instansi</th>
                                    <th class="px-4 py-2 text-left">Dosen Pembimbing</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Tanggal Mulai</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kerjaPrakteks as $kp)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ Str::limit($kp->judul_kp, 50) }}</td>
                                        <td class="px-4 py-2">{{ $kp->mahasiswa->name }}</td>
                                        <td class="px-4 py-2">{{ $kp->instansi->nama_instansi }}</td>
                                        <td class="px-4 py-2">{{ $kp->dosenPembimbing->name ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            {!! $kp->getStatusBadgeAttribute() !!}
                                        </td>
                                        <td class="px-4 py-2">{{ $kp->tanggal_mulai->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('kerja-praktek.show', $kp) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                            @if($kp->isEditable() && $kp->mahasiswa_id === auth()->id())
                                                <a href="{{ route('kerja-praktek.edit', $kp) }}" class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                                            @endif
                                            @if($kp->status === 'draft' && $kp->mahasiswa_id === auth()->id())
                                                <form action="{{ route('kerja-praktek.submit', $kp) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900" onclick="return confirm('Apakah Anda yakin ingin mengajukan pendaftaran ini?')">Ajukan</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                            Belum ada pendaftaran kerja praktek
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
