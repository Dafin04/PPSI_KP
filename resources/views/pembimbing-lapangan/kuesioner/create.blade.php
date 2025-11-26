<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Survey Kepuasan Pengguna</h2></x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-500 uppercase tracking-wide">Visi Program Studi Sistem Informasi</p>
                    <p class="text-base text-gray-800">
                        "Menjadi Program Studi Sistem Informasi yang unggul pada bidang sistem informasi dan bisnis digital serta menghasilkan lulusan yang memiliki kompetensi nasional dan global pada tahun 2031”.
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <form method="POST" action="{{ route('lapangan.kuesioner.store') }}" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Nama*</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border-gray-300 rounded-md" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Jabatan*</label>
                                <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full border-gray-300 rounded-md" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Nama Institusi/Organisasi/Perusahaan*</label>
                                <input type="text" name="institusi" value="{{ old('institusi') }}" class="w-full border-gray-300 rounded-md" required>
                            </div>
                        </div>

                        @php
                            $opsi4 = [
                                'tidak_baik' => 'Tidak Baik',
                                'kurang_baik' => 'Kurang Baik',
                                'cukup_baik' => 'Cukup Baik',
                                'sangat_baik' => 'Sangat Baik',
                            ];
                        @endphp

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Apakah kegiatan kerja praktek ini bermanfaat?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach(['tidak'=>'Tidak bermanfaat','kurang'=>'Kurang bermanfaat','baik'=>'Bermanfaat','sangat'=>'Sangat bermanfaat'] as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="manfaat" value="{{ $val }}" class="text-orange-600" @checked(old('manfaat')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Kemampuan & hasil kerja mahasiswa SI di tempat kerja Saudara?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach($opsi4 as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="kemampuan_kerja" value="{{ $val }}" class="text-orange-600" @checked(old('kemampuan_kerja')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Kemandirian mahasiswa SI?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach($opsi4 as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="kemandirian" value="{{ $val }}" class="text-orange-600" @checked(old('kemandirian')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Penguasaan materi & Bahasa Inggris?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach($opsi4 as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="penguasaan_materi" value="{{ $val }}" class="text-orange-600" @checked(old('penguasaan_materi')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Penguasaan sistem informasi & bisnis digital?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach($opsi4 as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="penguasaan_si" value="{{ $val }}" class="text-orange-600" @checked(old('penguasaan_si')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Sikap dalam tim & kerjasama?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach($opsi4 as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="kerjasama" value="{{ $val }}" class="text-orange-600" @checked(old('kerjasama')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Etika & attitude mahasiswa SI?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach($opsi4 as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="etika" value="{{ $val }}" class="text-orange-600" @checked(old('etika')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Sinergi hasil KP dengan program kerja instansi?*</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                                    @foreach(['tidak'=>'Tidak','sedikit'=>'Sedikit','sedang'=>'Sedang','besar'=>'Besar'] as $val=>$label)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="sinergi" value="{{ $val }}" class="text-orange-600" @checked(old('sinergi')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Bersedia tindak lanjut KP?*</label>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-700">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="lanjut" value="ya" class="text-orange-600" @checked(old('lanjut')==='ya') required> Ya
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="lanjut" value="tidak" class="text-orange-600" @checked(old('lanjut')==='tidak') required> Tidak
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Jumlah mahasiswa ditawarkan tahun depan</label>
                                    <input type="number" min="0" name="jumlah_mahasiswa" value="{{ old('jumlah_mahasiswa') }}" class="w-full border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Saran mata kuliah untuk kurikulum SI</label>
                                <textarea name="saran_matkul" rows="3" class="w-full border-gray-300 rounded-md" placeholder="Tuliskan mata kuliah atau topik yang perlu ditambahkan">{{ old('saran_matkul') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Saran kemampuan mahasiswa SI yang perlu ditingkatkan</label>
                                <textarea name="saran_kemampuan" rows="3" class="w-full border-gray-300 rounded-md" placeholder="Tuliskan kemampuan teknis/softskill yang perlu ditingkatkan">{{ old('saran_kemampuan') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4">
                            <a href="{{ route('lapangan.kuesioner.index') }}" class="text-gray-600">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
