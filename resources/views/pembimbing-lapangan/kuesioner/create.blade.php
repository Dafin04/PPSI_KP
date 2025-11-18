<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Isi Kuesioner Instansi</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('lapangan.kuesioner.store') }}" class="space-y-4">@csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Jumlah Kuota KP Tahun Depan</label>
                                <input type="number" min="0" name="kuota_tahun_depan" value="{{ old('kuota_tahun_depan') }}" class="w-full border-gray-300 rounded-md" required>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Tingkat Kepuasan</label>
                                <select name="tingkat_kepuasan" class="w-full border-gray-300 rounded-md" required>
                                    <option value="">Pilih</option>
                                    <option value="puas" @selected(old('tingkat_kepuasan') === 'puas')>Puas</option>
                                    <option value="tidak_puas" @selected(old('tingkat_kepuasan') === 'tidak_puas')>Tidak Puas</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Saran Kegiatan KP</label>
                            <textarea name="saran_kegiatan" rows="3" class="w-full border-gray-300 rounded-md" required>{{ old('saran_kegiatan') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Kebutuhan Skill Mahasiswa</label>
                            <textarea name="kebutuhan_skill" rows="3" class="w-full border-gray-300 rounded-md" required>{{ old('kebutuhan_skill') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Masukan/Feedback Tambahan</label>
                            <textarea name="isi_kuesioner" rows="4" class="w-full border-gray-300 rounded-md">{{ old('isi_kuesioner') }}</textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('lapangan.kuesioner.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
