<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Usulkan Instansi</p>
                    <h1 class="text-xl font-semibold text-gray-900">Instansi Mandiri</h1>
                    <p class="text-sm text-gray-500">Isi detail instansi yang akan diajukan. Admin/Kaprodi akan memverifikasi sebelum dapat dipilih mahasiswa lain.</p>
                </div>

                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                            Pastikan seluruh kolom wajib telah diisi dengan benar.
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.instansi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-semibold text-gray-800">Nama Instansi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_instansi" value="{{ old('nama_instansi') }}" required
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <x-input-error class="mt-1" :messages="$errors->get('nama_instansi')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Kota</label>
                                <input type="text" name="kota" value="{{ old('kota') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <x-input-error class="mt-1" :messages="$errors->get('kota')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <x-input-error class="mt-1" :messages="$errors->get('provinsi')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Kontak</label>
                                <input type="text" name="kontak" value="{{ old('kontak') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <x-input-error class="mt-1" :messages="$errors->get('kontak')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <x-input-error class="mt-1" :messages="$errors->get('telepon')" />
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-semibold text-gray-800">Alamat <span class="text-red-500">*</span></label>
                                <textarea name="alamat" rows="3" required
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('alamat') }}</textarea>
                                <x-input-error class="mt-1" :messages="$errors->get('alamat')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <x-input-error class="mt-1" :messages="$errors->get('email')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Website</label>
                                <input type="url" name="website" value="{{ old('website') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <x-input-error class="mt-1" :messages="$errors->get('website')" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-800">Jenis Instansi (Opsional)</label>
                            <input type="text" name="jenis_instansi" value="{{ old('jenis_instansi') }}"
                                   class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <x-input-error class="mt-1" :messages="$errors->get('jenis_instansi')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Upload Proposal Instansi (PDF/DOC) <span class="text-red-500">*</span></label>
                                <input type="file" name="proposal_file" required
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <p class="text-xs text-gray-500">Maksimal 5 MB.</p>
                                <x-input-error class="mt-1" :messages="$errors->get('proposal_file')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Bukti IPK (PDF/JPG/PNG) <span class="text-red-500">*</span></label>
                                <input type="file" name="bukti_ipk_file" required
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <p class="text-xs text-gray-500">Wajib, maks 2 MB.</p>
                                <x-input-error class="mt-1" :messages="$errors->get('bukti_ipk_file')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Prestasi Akademik (Opsional)</label>
                                <textarea name="prestasi_akademik" rows="2"
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('prestasi_akademik') }}</textarea>
                                <x-input-error class="mt-1" :messages="$errors->get('prestasi_akademik')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Prestasi Non-Akademik (Opsional)</label>
                                <textarea name="prestasi_non_akademik" rows="2"
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('prestasi_non_akademik') }}</textarea>
                                <x-input-error class="mt-1" :messages="$errors->get('prestasi_non_akademik')" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Pengalaman di Sistem Informasi <span class="text-red-500">*</span></label>
                                <textarea name="pengalaman_si" rows="2" required
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('pengalaman_si') }}</textarea>
                                <x-input-error class="mt-1" :messages="$errors->get('pengalaman_si')" />
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">Setelah dikirim, pengajuan menunggu verifikasi admin/Kaprodi.</p>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('mahasiswa.instansi.index') }}"
                                   class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</a>
                                <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700">Kirim Pengajuan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
