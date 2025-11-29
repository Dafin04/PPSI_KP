<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Seminar KP</p>
                    <h1 class="text-xl font-semibold text-gray-900">Ajukan Seminar</h1>
                    <p class="text-sm text-gray-500">Isi detail seminar, jadwal, dan kelengkapan jika perlu mengganti judul/instansi.</p>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('mahasiswa.seminar.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Judul Seminar</label>
                                <input name="judul_seminar" type="text" value="{{ old('judul_seminar') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required />
                                <x-input-error :messages="$errors->get('judul_seminar')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">File Presentasi (opsional, PDF/PPT)</label>
                                <input name="presentasi_file" type="file"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                                <x-input-error :messages="$errors->get('presentasi_file')" class="mt-1" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-800">Abstrak (opsional)</label>
                            <textarea name="abstrak" rows="4"
                                      class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('abstrak') }}</textarea>
                            <x-input-error :messages="$errors->get('abstrak')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Tanggal Seminar</label>
                                <input name="tanggal_seminar" type="date" value="{{ old('tanggal_seminar') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required />
                                <x-input-error :messages="$errors->get('tanggal_seminar')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Metode</label>
                                <select name="metode"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required>
                                    <option value="offline" @selected(old('metode')==='offline')>Offline</option>
                                    <option value="online" @selected(old('metode')==='online')>Online</option>
                                </select>
                                <x-input-error :messages="$errors->get('metode')" class="mt-1" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Waktu Mulai</label>
                                <input name="waktu_mulai" type="time" value="{{ old('waktu_mulai') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required />
                                <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Waktu Selesai</label>
                                <input name="waktu_selesai" type="time" value="{{ old('waktu_selesai') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required />
                                <x-input-error :messages="$errors->get('waktu_selesai')" class="mt-1" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Tempat (jika offline)</label>
                                <input name="tempat" type="text" value="{{ old('tempat') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                                <x-input-error :messages="$errors->get('tempat')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Link (jika online)</label>
                                <input name="link_online" type="url" value="{{ old('link_online') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                                <x-input-error :messages="$errors->get('link_online')" class="mt-1" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-800">Opsi Kelanjutan Jika Tidak Lulus</label>
                            <select name="opsi_kelanjutan"
                                    class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="lanjut" @selected(old('opsi_kelanjutan')==='lanjut')>Melanjutkan KP yang sama</option>
                                <option value="ganti" @selected(old('opsi_kelanjutan')==='ganti')>Ganti judul dan/atau instansi</option>
                            </select>
                            <x-input-error :messages="$errors->get('opsi_kelanjutan')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Judul KP Baru (opsional)</label>
                                <input name="judul_kp_baru" type="text" value="{{ old('judul_kp_baru') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Isi jika ingin mengganti judul" />
                                <x-input-error :messages="$errors->get('judul_kp_baru')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Instansi Baru (opsional)</label>
                                <select name="instansi_id_baru"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">Tetap gunakan instansi saat ini</option>
                                    @foreach($instansis as $instansi)
                                        <option value="{{ $instansi->id }}" @selected(old('instansi_id_baru')==$instansi->id)>{{ $instansi->nama_instansi }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('instansi_id_baru')" class="mt-1" />
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">Pastikan minimal 10 bimbingan disetujui sebelum mengajukan.</p>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('mahasiswa.seminar.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</a>
                                <button type="submit" class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-2.5 text-white text-sm font-semibold shadow hover:bg-blue-700">Ajukan Seminar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
