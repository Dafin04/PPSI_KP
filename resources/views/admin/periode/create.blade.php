<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Periode KP') }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-sm text-gray-500">Formulir penambahan periode baru</p>
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Periode KP</h3>
                </div>
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.periode.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" placeholder="2024/2025"
                                       class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                @error('tahun_ajaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                                <select name="semester" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                    <option value="">Pilih</option>
                                    <option value="Ganjil" @selected(old('semester')=='Ganjil')>Ganjil</option>
                                    <option value="Genap" @selected(old('semester')=='Genap')>Genap</option>
                                </select>
                                @error('semester') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Pendaftaran</label>
                                <input type="date" name="tgl_mulai_pendaftaran" value="{{ old('tgl_mulai_pendaftaran') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                @error('tgl_mulai_pendaftaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai Pendaftaran</label>
                                <input type="date" name="tgl_selesai_pendaftaran" value="{{ old('tgl_selesai_pendaftaran') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                @error('tgl_selesai_pendaftaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                    <option value="Aktif" @selected(old('status')=='Aktif')>Aktif</option>
                                    <option value="Ditutup" @selected(old('status')=='Ditutup')>Ditutup</option>
                                    <option value="Arsip" @selected(old('status')=='Arsip')>Arsip</option>
                                </select>
                                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan (Opsional)</label>
                                <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Catatan periode">
                                @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.periode.index') }}" class="text-gray-600 hover:text-gray-900 font-semibold">Batal</a>
                            <button type="submit" class="inline-flex items-center px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-100">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
