<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Usulkan Instansi Mandiri
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-200">
                <div class="p-6 space-y-6">
                    <p class="text-sm text-gray-600">
                        Isi data instansi yang ingin diajukan. Setelah dikirim, admin/Kaprodi akan memverifikasi terlebih dahulu sebelum bisa dipilih oleh mahasiswa lain.
                    </p>

                    <form action="{{ route('mahasiswa.instansi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Instansi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_instansi" value="{{ old('nama_instansi') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('nama_instansi')" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat <span class="text-red-500">*</span></label>
                                <textarea name="alamat" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('alamat') }}</textarea>
                                <x-input-error class="mt-1" :messages="$errors->get('alamat')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kota</label>
                                <input type="text" name="kota" value="{{ old('kota') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('kota')" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('provinsi')" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('kode_pos')" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Instansi</label>
                                <select name="jenis_instansi" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih Jenis</option>
                                    @foreach(['swasta' => 'Swasta', 'pemerintah' => 'Pemerintah', 'bumn' => 'BUMN', 'bumd' => 'BUMD', 'lainnya' => 'Lainnya'] as $key => $label)
                                        <option value="{{ $key }}" @selected(old('jenis_instansi') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-1" :messages="$errors->get('jenis_instansi')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('telepon')" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('email')" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" name="website" value="{{ old('website') }}" placeholder="https://contoh.com" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('website')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kontak Person</label>
                                <input type="text" name="kontak_person" value="{{ old('kontak_person') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-1" :messages="$errors->get('kontak_person')" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kontak Tambahan</label>
                                <textarea name="kontak" rows="2" class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('kontak') }}</textarea>
                                <x-input-error class="mt-1" :messages="$errors->get('kontak')" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proposal KP <span class="text-red-500">*</span></label>
                            <input type="file" name="proposal_file" accept=".pdf,.doc,.docx" required class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">Format PDF/DOC/DOCX, maksimal 5 MB.</p>
                            <x-input-error class="mt-1" :messages="$errors->get('proposal_file')" />
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('mahasiswa.instansi.index') }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Ajukan Instansi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
