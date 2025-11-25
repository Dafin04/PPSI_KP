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
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left border-b">Mahasiswa</th>
                                    <th class="px-4 py-2 text-left border-b">Judul Seminar</th>
                                    <th class="px-4 py-2 text-left border-b">Ketua</th>
                                    <th class="px-4 py-2 text-left border-b">Anggota 1</th>
                                    <th class="px-4 py-2 text-left border-b">Anggota 2</th>
                                    <th class="px-4 py-2 text-left border-b">Pembimbing</th>
                                    <th class="px-4 py-2 text-left border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($seminars as $seminar)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b">{{ $seminar->mahasiswa->name ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $seminar->judul_seminar ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b" colspan="4">
                                            <form method="POST" action="{{ route('admin.alokasi.penguji.set', $seminar) }}" class="grid grid-cols-1 md:grid-cols-4 gap-2 items-center">
                                                @csrf
                                                <select name="ketua_penguji_id" class="border rounded py-1 px-2 text-sm">
                                                    <option value="">-</option>
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}" @selected($seminar->ketua_penguji_id == $dosen->id)>{{ $dosen->name }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="anggota_penguji_1_id" class="border rounded py-1 px-2 text-sm">
                                                    <option value="">-</option>
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}" @selected($seminar->anggota_penguji_1_id == $dosen->id)>{{ $dosen->name }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="anggota_penguji_2_id" class="border rounded py-1 px-2 text-sm">
                                                    <option value="">-</option>
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}" @selected($seminar->anggota_penguji_2_id == $dosen->id)>{{ $dosen->name }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="pembimbing_penguji_id" class="border rounded py-1 px-2 text-sm">
                                                    <option value="">-</option>
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}" @selected($seminar->pembimbing_penguji_id == $dosen->id)>{{ $dosen->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="flex md:justify-end">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-medium">Simpan</button>
                                                </div>
                                            </form>
                                        </td>
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
