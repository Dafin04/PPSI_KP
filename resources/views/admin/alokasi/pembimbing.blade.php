@php use Illuminate\Support\Str; @endphp
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
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left border-b">Mahasiswa</th>
                                    <th class="px-4 py-2 text-left border-b">IPK</th>
                                    <th class="px-4 py-2 text-left border-b">Instansi</th>
                                    <th class="px-4 py-2 text-left border-b">Judul</th>
                                    <th class="px-4 py-2 text-left border-b">Bukti & Profil</th>
                                    <th class="px-4 py-2 text-left border-b">Pembimbing</th>
                                    <th class="px-4 py-2 text-left border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($kps as $kp)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b">{{ $kp->mahasiswa->name ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ optional($kp->mahasiswa->mahasiswa)->ipk ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $kp->instansi->nama_instansi ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $kp->judul_kp ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b text-xs text-gray-700 space-y-1 break-words">
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold">Bukti IPK:</span>
                                                @if($kp->bukti_ipk_file)
                                                    <a href="{{ asset('storage/'.$kp->bukti_ipk_file) }}" target="_blank" class="inline-flex items-center px-2 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50">Lihat</a>
                                                @else
                                                    <span class="text-gray-400">Tidak ada</span>
                                                @endif
                                            </div>
                                            <div><span class="font-semibold">Prestasi Akademik:</span> {{ $kp->prestasi_akademik ? Str::limit($kp->prestasi_akademik, 80) : '-' }}</div>
                                            <div><span class="font-semibold">Prestasi Non-Akademik:</span> {{ $kp->prestasi_non_akademik ? Str::limit($kp->prestasi_non_akademik, 80) : '-' }}</div>
                                            <div><span class="font-semibold">Pengalaman SI:</span> {{ $kp->pengalaman_si ? Str::limit($kp->pengalaman_si, 80) : '-' }}</div>
                                        </td>
                                        <td class="px-4 py-2 border-b">{{ $kp->dosenPembimbing->name ?? 'Belum ditentukan' }}</td>
                                        <td class="px-4 py-2 border-b">
                                            <div class="flex flex-col gap-2">
                                                <form method="POST" action="{{ route('admin.alokasi.pembimbing.set', $kp) }}" class="flex items-center gap-2">
                                                    @csrf
                                                    <select name="dosen_pembimbing_id" class="border rounded py-1 px-2 text-sm">
                                                        @foreach($dosens as $dosen)
                                                            <option value="{{ $dosen->id }}" @selected($kp->dosen_pembimbing_id == $dosen->id)>
                                                                {{ $dosen->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-medium">Simpan</button>
                                                </form>
                                                <a href="{{ route('kerja-praktek.show', $kp) }}"
                                                   class="inline-flex items-center px-3 py-1 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-medium">
                                                    Lihat Detail
                                                </a>
                                            </div>
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
