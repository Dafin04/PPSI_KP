<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alokasi Penguji Seminar') }}
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

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left">Mahasiswa</th>
                                    <th class="px-4 py-2 text-left">Judul Seminar</th>
                                    <th class="px-4 py-2 text-left">Ketua</th>
                                    <th class="px-4 py-2 text-left">Anggota 1</th>
                                    <th class="px-4 py-2 text-left">Anggota 2</th>
                                    <th class="px-4 py-2 text-left">Pembimbing</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($seminars as $seminar)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $seminar->mahasiswa->name ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $seminar->judul_seminar ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            <form method="POST" action="{{ route('admin.alokasi.penguji.set', $seminar) }}">
                                                @csrf
                                                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 items-center">
                                                    <select name="ketua_penguji_id" class="border rounded py-1 px-2">
                                                        <option value="">-</option>
                                                        @foreach($dosens as $dosen)
                                                            <option value="{{ $dosen->id }}" @selected($seminar->ketua_penguji_id == $dosen->id)>{{ $dosen->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select name="anggota_penguji_1_id" class="border rounded py-1 px-2">
                                                        <option value="">-</option>
                                                        @foreach($dosens as $dosen)
                                                            <option value="{{ $dosen->id }}" @selected($seminar->anggota_penguji_1_id == $dosen->id)>{{ $dosen->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select name="anggota_penguji_2_id" class="border rounded py-1 px-2">
                                                        <option value="">-</option>
                                                        @foreach($dosens as $dosen)
                                                            <option value="{{ $dosen->id }}" @selected($seminar->anggota_penguji_2_id == $dosen->id)>{{ $dosen->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select name="pembimbing_penguji_id" class="border rounded py-1 px-2">
                                                        <option value="">-</option>
                                                        @foreach($dosens as $dosen)
                                                            <option value="{{ $dosen->id }}" @selected($seminar->pembimbing_penguji_id == $dosen->id)>{{ $dosen->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">Simpan</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2" colspan="2"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $seminars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

