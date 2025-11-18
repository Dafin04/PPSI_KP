<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajukan Seminar</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <form method="POST" action="{{ route('mahasiswa.seminar.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">@csrf
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Judul Seminar</label>
                        <input name="judul_seminar" type="text" class="w-full border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Abstrak (opsional)</label>
                        <textarea name="abstrak" rows="4" class="w-full border-gray-300 rounded-lg"></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Tanggal Seminar</label>
                            <input name="tanggal_seminar" type="date" class="w-full border-gray-300 rounded-lg" required />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Metode</label>
                            <select name="metode" class="w-full border-gray-300 rounded-lg" required>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Waktu Mulai</label>
                            <input name="waktu_mulai" type="time" class="w-full border-gray-300 rounded-lg" required />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Waktu Selesai</label>
                            <input name="waktu_selesai" type="time" class="w-full border-gray-300 rounded-lg" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Tempat (jika offline)</label>
                            <input name="tempat" type="text" class="w-full border-gray-300 rounded-lg" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Link (jika online)</label>
                            <input name="link_online" type="url" class="w-full border-gray-300 rounded-lg" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Opsi Kelanjutan Jika Tidak Lulus</label>
                        <select name="opsi_kelanjutan" class="w-full border-gray-300 rounded-lg">
                            <option value="lanjut">Melanjutkan KP yang sama</option>
                            <option value="ganti">Ganti judul dan/atau instansi</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Judul KP Baru (opsional)</label>
                            <input name="judul_kp_baru" type="text" class="w-full border-gray-300 rounded-lg" placeholder="Isi jika ingin mengganti judul" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Instansi Baru (opsional)</label>
                            <select name="instansi_id_baru" class="w-full border-gray-300 rounded-lg">
                                <option value="">Tetap gunakan instansi saat ini</option>
                                @foreach($instansis as $instansi)
                                    <option value="{{ $instansi->id }}">{{ $instansi->nama_instansi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">File Presentasi (opsional, PDF/PPT)</label>
                        <input name="presentasi_file" type="file" class="w-full border-gray-300 rounded-lg" />
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('mahasiswa.seminar.index') }}" class="text-gray-600">Batal</a>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-indigo-700">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
