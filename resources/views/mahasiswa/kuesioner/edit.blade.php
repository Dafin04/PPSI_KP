<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ubah Kuesioner</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('mahasiswa.kuesioner.update', $kuesioner) }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Tipe</label>
                                <select name="tipe" class="w-full border-gray-300 rounded-md">
                                    <option value="mahasiswa" @selected($kuesioner->tipe==='mahasiswa')>Mahasiswa</option>
                                    <option value="instansi" @selected($kuesioner->tipe==='instansi')>Instansi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Isi Kuesioner</label>
                                <textarea name="isi_kuesioner" rows="5" class="w-full border-gray-300 rounded-md" required>{{ old('isi_kuesioner', $kuesioner->isi_kuesioner) }}</textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-2">
                            <a href="{{ route('mahasiswa.kuesioner.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

