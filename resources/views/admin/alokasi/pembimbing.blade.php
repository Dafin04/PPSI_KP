@php use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alokasi Dosen Pembimbing</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Data Alokasi Pembimbing</h3>
                        <p class="text-sm text-gray-500">Pilih dosen pembimbing untuk mahasiswa KP</p>
                    </div>
                    <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <div class="relative w-full sm:w-56">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </span>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari mahasiswa/instansi..."
                                   class="w-full rounded-xl border border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div class="flex gap-3">
                            <select name="instansi_id" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Instansi</option>
                                @foreach($instansis as $instansi)
                                    <option value="{{ $instansi->id }}" @selected(($filters['instansi_id'] ?? '') == $instansi->id)>{{ $instansi->nama_instansi }}</option>
                                @endforeach
                            </select>
                            <select name="sort" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Terbaru</option>
                                <option value="ipk" @selected(($filters['sort'] ?? '') === 'ipk')>IPK Tertinggi</option>
                            </select>
                            <button class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700">
                                Terapkan
                            </button>
                            <a href="{{ route('admin.alokasi.pembimbing') }}" class="inline-flex items-center px-3 py-2 rounded-xl border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                Reset
                            </a>
                        </div>
                    </form>
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
                                <th class="px-6 py-3">Mahasiswa</th>
                                <th class="px-6 py-3">IPK</th>
                                <th class="px-6 py-3">Instansi</th>
                                <th class="px-6 py-3">Judul KP</th>
                                <th class="px-6 py-3">Pembimbing</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($kps as $kp)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $kp->mahasiswa->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ optional($kp->mahasiswa->mahasiswa)->ipk ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $kp->instansi->nama_instansi ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $kp->judul_kp ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $kp->dosenPembimbing->name ?? 'Belum ditentukan' }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <form method="POST" action="{{ route('admin.alokasi.pembimbing.set', $kp) }}" class="flex items-center gap-2">
                                                @csrf
                                                <select name="dosen_pembimbing_id" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}" @selected($kp->dosen_pembimbing_id == $dosen->id)>
                                                            {{ $dosen->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="p-2 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50" title="Simpan">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    <span class="sr-only">Simpan</span>
                                                </button>
                                            </form>
                                            <a href="{{ route('kerja-praktek.show', $kp) }}"
                                               class="p-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50" title="Lihat detail">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <span class="sr-only">Lihat detail</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $kps->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
