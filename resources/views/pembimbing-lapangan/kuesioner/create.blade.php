<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Kuesioner Instansi</p>
                    <h3 class="text-lg font-semibold text-gray-900">Isi Kuesioner</h3>
                    <p class="text-sm text-gray-500">Sampaikan kepuasan, saran, dan kebutuhan. Sertifikat terbit otomatis setelah kuesioner tersimpan.</p>
                </div>

                <div class="p-6">
                    <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-800 mb-4">
                        <p class="font-semibold">Survey Kepuasan Pengguna</p>
                        <p>Visi baru SI: <span class="font-medium">"Menjadi Program Studi Sistem Informasi yang unggul pada bidang sistem informasi dan bisnis digital serta menghasilkan lulusan yang memiliki kompetensi nasional dan global pada tahun 2031".</span></p>
                    </div>

                    <form method="POST" action="{{ route('lapangan.kuesioner.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nama*</label>
                                <input name="nama" type="text" value="{{ old('nama', auth()->user()->name ?? '') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Jabatan*</label>
                                <input name="jabatan" type="text" value="{{ old('jabatan') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nama Institusi/Organisasi/Perusahaan*</label>
                                <input name="institusi" type="text" value="{{ old('institusi') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Apakah kegiatan kerja praktek ini bermanfaat untuk Saudara/Institusi Saudara?*</label>
                                <div class="space-y-2">
                                    @foreach(['tidak' => 'Tidak bermanfaat', 'kurang' => 'Kurang bermanfaat', 'baik' => 'Bermanfaat', 'sangat' => 'Sangat bermanfaat'] as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="manfaat" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('manfaat')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Bagaimana kemampuan dan hasil kerja mahasiswa SI?*</label>
                                <div class="space-y-2">
                                    @php $opsi = ['tidak_baik' => 'Tidak Baik', 'kurang_baik' => 'Kurang Baik', 'cukup_baik' => 'Cukup Baik', 'sangat_baik' => 'Sangat Baik']; @endphp
                                    @foreach($opsi as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="kemampuan_kerja" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('kemampuan_kerja')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Bagaimana sifat kemandirian mahasiswa SI?*</label>
                                <div class="space-y-2">
                                    @foreach($opsi as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="kemandirian" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('kemandirian')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Bagaimanakah penguasaan materi dan Bahasa Inggris?*</label>
                                <div class="space-y-2">
                                    @foreach($opsi as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="penguasaan_materi" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('penguasaan_materi')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Penguasaan SI & bisnis digital di tempat Saudara?*</label>
                                <div class="space-y-2">
                                    @foreach($opsi as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="penguasaan_si" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('penguasaan_si')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Sikap dalam tim & menjalin kerjasama?*</label>
                                <div class="space-y-2">
                                    @foreach($opsi as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="kerjasama" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('kerjasama')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Etika dan attitude mahasiswa SI?*</label>
                                <div class="space-y-2">
                                    @foreach($opsi as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="etika" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('etika')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Apakah hasil KP bersinergi dengan program kerja instansi?*</label>
                                <div class="space-y-2">
                                    @foreach(['tidak' => 'Tidak', 'sedikit' => 'Sedikit', 'sedang' => 'Sedang', 'besar' => 'Besar'] as $val => $label)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" name="sinergi" value="{{ $val }}" class="text-blue-600 border-gray-300 focus:ring-blue-500" @checked(old('sinergi')==$val) required>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Jika bersedia, berapa jumlah mahasiswa yang ditawarkan untuk KP/Magang di tahun depan?</label>
                                <input name="kuota_tahun_depan" type="number" value="{{ old('kuota_tahun_depan') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Saran mata kuliah/skill tambahan (agar sesuai kebutuhan stakeholder)</label>
                                <textarea name="saran_matkul" rows="3"
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('saran_matkul') }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Saran kemampuan mahasiswa SI yang perlu ditingkatkan (nasional/global)</label>
                                <textarea name="saran_kemampuan" rows="3"
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('saran_kemampuan') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('lapangan.kuesioner.index') }}"
                               class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</a>
                            <button class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700">
                                Simpan Kuesioner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
