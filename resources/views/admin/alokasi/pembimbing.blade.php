<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alokasi Dosen Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="GET" class="flex flex-wrap gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Filter Instansi</label>
                            <select name="instansi_id" class="border-gray-300 rounded-md">
                                <option value="">Semua Instansi</option>
                                @foreach($instansis as $instansi)
                                    <option value="{{ $instansi->id }}" @selected(($filters['instansi_id'] ?? '') == $instansi->id)>{{ $instansi->nama_instansi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Urutkan</label>
                            <select name="sort" class="border-gray-300 rounded-md">
                                <option value="">Terbaru</option>
                                <option value="ipk" @selected(($filters['sort'] ?? '') === 'ipk')>IPK Tertinggi</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">Terapkan</button>
                            <a href="{{ route('admin.alokasi.pembimbing') }}" class="text-sm text-gray-600">Reset</a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left">Mahasiswa</th>
                                    <th class="px-4 py-2 text-left">IPK</th>
                                    <th class="px-4 py-2 text-left">Instansi</th>
                                    <th class="px-4 py-2 text-left">Judul</th>
                                    <th class="px-4 py-2 text-left">Pembimbing</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kps as $kp)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $kp->mahasiswa->name ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ optional($kp->mahasiswa->mahasiswa)->ipk ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $kp->instansi->nama_instansi ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $kp->judul_kp ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $kp->dosenPembimbing->name ?? 'Belum ditentukan' }}</td>
                                        <td class="px-4 py-2">
                                            <form method="POST" action="{{ route('admin.alokasi.pembimbing.set', $kp) }}" class="flex items-center gap-2">
                                                @csrf
                                                <select name="dosen_pembimbing_id" class="border rounded py-1 px-2">
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}" @selected($kp->dosen_pembimbing_id == $dosen->id)>
                                                            {{ $dosen->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">Simpan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $kps->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
