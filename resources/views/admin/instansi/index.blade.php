<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
{{ __('Kelola Instansi') }}
</h2>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Kontainer utama diubah untuk mengambil lebar penuh. --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium">Daftar Instansi</h3>
                    <a href="{{ route('admin.instansi.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Tambah Instansi
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    {{-- Tambahkan kelas w-full di sini untuk memastikan tabel menggunakan lebar penuh kontainer --}}
                    <table class="min-w-full table-auto w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- Mengatur lebar minimal agar header terlihat jelas --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[35%] min-w-[150px]">Nama Instansi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[30%] min-w-[120px]">Kontak</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[10%] min-w-[80px]">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[10%] min-w-[80px]">Verifikasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[10%] min-w-[120px]">Pembimbing Lapangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[15%] min-w-[150px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($instansis as $instansi)
                                <tr>
                                    {{-- Gunakan break-words untuk teks panjang --}}
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 break-words">
                                        {{ $instansi->nama_instansi }}
                                    </td>
                                    {{-- Gunakan break-words untuk kontak panjang --}}
                                    <td class="px-6 py-4 text-sm text-gray-500 break-words">
                                        {{ $instansi->kontak ?? $instansi->telepon ?? $instansi->kontak_person ?? '-' }}
                                    </td>
                                    {{-- Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(($instansi->status ?? $instansi->status_aktif ?? false))
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Tidak aktif
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Verifikasi --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php $v = $instansi->status_verifikasi ?? null; @endphp
                                        @if($v === 'disetujui')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-700">Disetujui</span>
                                        @elseif($v === 'ditolak')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-50 text-red-700">Ditolak</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-50 text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    {{-- Pembimbing Lapangan --}}
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $instansi->pembimbingLapangans->count() }} terdaftar
                                    </td>
                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if(($instansi->status_verifikasi ?? 'pending') === 'pending')
                                            <form method="POST" action="{{ route('admin.instansi.verify', $instansi) }}" class="inline">@csrf
                                                <button class="text-green-600 hover:underline mr-2">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.instansi.reject', $instansi) }}" class="inline">@csrf
                                                <button class="text-red-600 hover:underline mr-3">Tolak</button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.instansi.edit', $instansi) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form method="POST" action="{{ route('admin.instansi.destroy', $instansi) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            {{-- Menggunakan tombol khusus untuk konfirmasi, bukan alert() --}}
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus instansi ini?')) { this.closest('form').submit(); }">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Kolom data kosong harus mencakup semua kolom (colspan=5) --}}
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data instansi.
                                        <a href="{{ route('admin.instansi.create') }}" class="text-blue-500 hover:underline ml-2">Tambahkan Instansi sekarang.</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $instansis->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
