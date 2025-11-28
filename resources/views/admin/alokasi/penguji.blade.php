<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alokasi Penguji Seminar</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-sm text-gray-500">Tetapkan ketua/anggota penguji untuk mahasiswa seminar KP</p>
                    <h3 class="text-lg font-semibold text-gray-900">Data Alokasi Penguji</h3>
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
                                <th class="px-6 py-3">Judul Seminar</th>
                                <th class="px-6 py-3">Ketua</th>
                                <th class="px-6 py-3">Anggota 1</th>
                                <th class="px-6 py-3">Anggota 2</th>
                                <th class="px-6 py-3">Pembimbing</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($seminars as $seminar)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $seminar->mahasiswa->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $seminar->judul_seminar ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ optional($seminar->ketuaPenguji)->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ optional($seminar->anggotaPenguji1)->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ optional($seminar->anggotaPenguji2)->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ optional($seminar->pembimbingPenguji)->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.alokasi.penguji.set', $seminar) }}" class="flex flex-col gap-2 md:flex-row md:items-center md:justify-end">
                                            @csrf
                                            <select name="ketua_penguji_id" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Ketua</option>
                                                @foreach($dosens as $dosen)
                                                    <option value="{{ $dosen->id }}" @selected($seminar->ketua_penguji_id == $dosen->id)>{{ $dosen->name }}</option>
                                                @endforeach
                                            </select>
                                            <select name="anggota_penguji_1_id" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Anggota 1</option>
                                                @foreach($dosens as $dosen)
                                                    <option value="{{ $dosen->id }}" @selected($seminar->anggota_penguji_1_id == $dosen->id)>{{ $dosen->name }}</option>
                                                @endforeach
                                            </select>
                                            <select name="anggota_penguji_2_id" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Anggota 2</option>
                                                @foreach($dosens as $dosen)
                                                    <option value="{{ $dosen->id }}" @selected($seminar->anggota_penguji_2_id == $dosen->id)>{{ $dosen->name }}</option>
                                                @endforeach
                                            </select>
                                            <select name="pembimbing_penguji_id" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Pembimbing</option>
                                                @foreach($dosens as $dosen)
                                                    <option value="{{ $dosen->id }}" @selected($seminar->pembimbing_penguji_id == $dosen->id)>{{ $dosen->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="p-2 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50" title="Simpan">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                <span class="sr-only">Simpan</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $seminars->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
