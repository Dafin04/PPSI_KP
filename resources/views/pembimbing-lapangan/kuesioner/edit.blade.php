@php
    $data = json_decode($kuesioner->isi_kuesioner ?? '{}', true) ?? [];
@endphp

<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Survey Kepuasan</h2></x-slot>

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
                    <form method="POST" action="{{ route('lapangan.kuesioner.update', $kuesioner) }}" class="space-y-5">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Nama*</label>
                                <input type="text" name="nama" value="{{ old('nama', $data['nama'] ?? '') }}" class="w-full border-gray-300 rounded-md" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Jabatan*</label>
                                <input type="text" name="jabatan" value="{{ old('jabatan', $data['jabatan'] ?? '') }}" class="w-full border-gray-300 rounded-md" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Nama Institusi/Organisasi/Perusahaan*</label>
                                <input type="text" name="institusi" value="{{ old('institusi', $data['institusi'] ?? '') }}" class="w-full border-gray-300 rounded-md" required>
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
                                            <input type="radio" name="manfaat" value="{{ $val }}" class="text-orange-600" @checked(old('manfaat', $data['manfaat'] ?? '')===$val) required>
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
                                            <input type="radio" name="kemampuan_kerja" value="{{ $val }}" class="text-orange-600" @checked(old('kemampuan_kerja', $data['kemampuan_kerja'] ?? '')===$val) required>
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
                                            <input type="radio" name="kemandirian" value="{{ $val }}" class="text-orange-600" @checked(old('kemandirian', $data['kemandirian'] ?? '')===$val) required>
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
                                            <input type="radio" name="penguasaan_materi" value="{{ $val }}" class="text-orange-600" @checked(old('penguasaan_materi', $data['penguasaan_materi'] ?? '')===$val) required>
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
                                            <input type="radio" name="penguasaan_si" value="{{ $val }}" class="text-orange-600" @checked(old('penguasaan_si', $data['penguasaan_si'] ?? '')===$val) required>
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
                                            <input type="radio" name="kerjasama" value="{{ $val }}" class="text-orange-600" @checked(old('kerjasama', $data['kerjasama'] ?? '')===$val) required>
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
                                            <input type="radio" name="etika" value="{{ $val }}" class="text-orange-600" @checked(old('etika', $data['etika'] ?? '')===$val) required>
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
                                            <input type="radio" name="sinergi" value="{{ $val }}" class="text-orange-600" @checked(old('sinergi', $data['sinergi'] ?? '')===$val) required>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Bersedia tindak lanjut KP?*</label>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-700">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="lanjut" value="ya" class="text-orange-600" @checked(old('lanjut', $data['lanjut'] ?? '')==='ya') required> Ya
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="lanjut" value="tidak" class="text-orange-600" @checked(old('lanjut', $data['lanjut'] ?? '')==='tidak') required> Tidak
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Jumlah mahasiswa ditawarkan tahun depan</label>
                                    <input type="number" min="0" name="jumlah_mahasiswa" value="{{ old('jumlah_mahasiswa', $data['jumlah_mahasiswa'] ?? $kuesioner->kuota_tahun_depan) }}" class="w-full border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Saran mata kuliah untuk kurikulum SI</label>
                                <textarea name="saran_matkul" rows="3" class="w-full border-gray-300 rounded-md" placeholder="Tuliskan mata kuliah atau topik yang perlu ditambahkan">{{ old('saran_matkul', $data['saran_matkul'] ?? $kuesioner->saran_kegiatan) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Saran kemampuan mahasiswa SI yang perlu ditingkatkan</label>
                                <textarea name="saran_kemampuan" rows="3" class="w-full border-gray-300 rounded-md" placeholder="Tuliskan kemampuan teknis/softskill yang perlu ditingkatkan">{{ old('saran_kemampuan', $data['saran_kemampuan'] ?? $kuesioner->kebutuhan_skill) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-3">
                            <a href="{{ route('lapangan.kuesioner.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
