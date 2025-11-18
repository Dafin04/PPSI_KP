<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Input Nilai Pembimbing</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('dosen.nilai.store') }}" class="space-y-4">@csrf
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Mahasiswa ID</label>
                            <input name="mahasiswa_id" class="w-full border-gray-300 rounded-md" required />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Pembimbing Lapangan (User ID)</label>
                            <input name="pembimbing_lapangan_id" class="w-full border-gray-300 rounded-md" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm">Nilai Pembimbing</label><input name="nilai_pembimbing" type="number" step="0.01" class="w-full border-gray-300 rounded-md" /></div>
                            <div><label class="block text-sm">Nilai Lapangan</label><input name="nilai_lapangan" type="number" step="0.01" class="w-full border-gray-300 rounded-md" /></div>
                            <div><label class="block text-sm">Nilai Seminar</label><input name="nilai_seminar" type="number" step="0.01" class="w-full border-gray-300 rounded-md" /></div>
                            <div><label class="block text-sm">Total Nilai</label><input name="total_nilai" type="number" step="0.01" class="w-full border-gray-300 rounded-md" /></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm">Huruf Pembimbing</label>
                                <select name="nilai_pembimbing_huruf" class="w-full border-gray-300 rounded-md">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}">{{ $huruf }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm">Huruf Lapangan</label>
                                <select name="nilai_lapangan_huruf" class="w-full border-gray-300 rounded-md">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}">{{ $huruf }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm">Huruf Seminar</label>
                                <select name="nilai_seminar_huruf" class="w-full border-gray-300 rounded-md">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}">{{ $huruf }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm">Huruf Total</label>
                                <select name="nilai_mutu" class="w-full border-gray-300 rounded-md">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}">{{ $huruf }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('dosen.nilai.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
