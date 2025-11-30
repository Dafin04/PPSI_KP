<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Penguji Seminar</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-indigo-600 uppercase tracking-widest">Penguji Seminar</p>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $seminar->judul_seminar ?? 'Seminar KP' }}</h3>
                    <p class="text-sm text-gray-500">Mahasiswa: {{ optional($seminar->mahasiswa)->name ?? '-' }} | Tanggal: {{ optional($seminar->tanggal_seminar)->format('d M Y') ?? '-' }}</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('admin.alokasi.penguji.set', $seminar) }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-800">Ketua Penguji</label>
                                <select name="ketua_penguji_id" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dosens as $d)
                                        <option value="{{ $d->id }}" @selected($seminar->ketua_penguji_id == $d->id)>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-800">Anggota Penguji 1</label>
                                <select name="anggota_penguji_1_id" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dosens as $d)
                                        <option value="{{ $d->id }}" @selected($seminar->anggota_penguji_1_id == $d->id)>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-800">Anggota Penguji 2</label>
                                <select name="anggota_penguji_2_id" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dosens as $d)
                                        <option value="{{ $d->id }}" @selected($seminar->anggota_penguji_2_id == $d->id)>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-800">Pembimbing Penguji</label>
                                <select name="pembimbing_penguji_id" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dosens as $d)
                                        <option value="{{ $d->id }}" @selected($seminar->pembimbing_penguji_id == $d->id)>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <a href="{{ route('admin.alokasi.penguji') }}" class="text-gray-600 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">Kembali</a>
                            <button class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">Simpan Penguji</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
