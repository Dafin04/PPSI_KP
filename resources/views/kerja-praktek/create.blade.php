<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4 lg:px-0">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex flex-col gap-1">
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Pendaftaran KP</p>
                <h1 class="text-xl font-semibold text-gray-900">Daftar Kerja Praktek</h1>
                <p class="text-sm text-gray-500">Lengkapi data KP, pilihan instansi, dan unggah dokumen pendukung.</p>
            </div>

            <div class="px-6 py-5 space-y-6">
                @if ($errors->any())
                    <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ __('Periksa kembali isian Anda. Pastikan semua kolom wajib terisi dengan benar.') }}
                        <ul class="mt-2 list-disc list-inside text-xs text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kerja-praktek.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label for="judul_kp" class="text-sm font-semibold text-gray-800">Judul Kerja Praktek</label>
                                <input id="judul_kp" name="judul_kp" type="text" value="{{ old('judul_kp') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                       required>
                                <x-input-error :messages="$errors->get('judul_kp')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label for="durasi_minggu" class="text-sm font-semibold text-gray-800">Durasi (minggu)</label>
                                <input id="durasi_minggu" name="durasi_minggu" type="number" min="4" max="16" value="{{ old('durasi_minggu') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                       required>
                                <x-input-error :messages="$errors->get('durasi_minggu')" class="mt-1" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="deskripsi_kp" class="text-sm font-semibold text-gray-800">Deskripsi Kerja Praktek</label>
                            <textarea id="deskripsi_kp" name="deskripsi_kp" rows="4"
                                      class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                      required>{{ old('deskripsi_kp') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kp')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label for="tanggal_mulai" class="text-sm font-semibold text-gray-800">Tanggal Mulai</label>
                                <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                       required>
                                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label for="tanggal_selesai" class="text-sm font-semibold text-gray-800">Tanggal Selesai</label>
                                <input id="tanggal_selesai" name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                       required>
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-1" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label for="instansi_id" class="text-sm font-semibold text-gray-800">Instansi (Pilihan KP 1)</label>
                                <select id="instansi_id" name="instansi_id"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                        required>
                                    <option value="">Pilih Instansi</option>
                                    @foreach($instansis as $instansi)
                                        <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                            {{ $instansi->nama_instansi }} - {{ $instansi->kota }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('instansi_id')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label for="dosen_pembimbing_id" class="text-sm font-semibold text-gray-800">Dosen Pembimbing</label>
                                <select id="dosen_pembimbing_id" name="dosen_pembimbing_id"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                        required>
                                    <option value="">Pilih Dosen Pembimbing</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing_id') == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->name }} - {{ $dosen->nip }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('dosen_pembimbing_id')" class="mt-1" />
                            </div>
                        </div>

                        <input type="hidden" id="pilihan_1" name="pilihan_1" value="{{ old('pilihan_1') }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label for="pilihan_2" class="text-sm font-semibold text-gray-800">Pilihan Tempat KP 2 (Opsional)</label>
                                <select id="pilihan_2" name="pilihan_2"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">Pilih Instansi</option>
                                    @foreach($instansis as $instansi)
                                        <option value="{{ $instansi->nama_instansi }}" {{ old('pilihan_2') == $instansi->nama_instansi ? 'selected' : '' }}>
                                            {{ $instansi->nama_instansi }} - {{ $instansi->kota }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('pilihan_2')" class="mt-1" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label for="proposal_file" class="text-sm font-semibold text-gray-800">Unggah Proposal (PDF/DOC)</label>
                                <input id="proposal_file" name="proposal_file" type="file"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <p class="text-xs text-gray-500">Maksimal 2MB.</p>
                                <x-input-error :messages="$errors->get('proposal_file')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label for="bukti_ipk_file" class="text-sm font-semibold text-gray-800">Bukti IPK (PDF/JPG/PNG)</label>
                                <input id="bukti_ipk_file" name="bukti_ipk_file" type="file" required
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <p class="text-xs text-gray-500">Wajib diisi, maksimal 2MB.</p>
                                <x-input-error :messages="$errors->get('bukti_ipk_file')" class="mt-1" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="pengalaman_si" class="text-sm font-semibold text-gray-800">Pengalaman di Sistem Informasi</label>
                            <textarea id="pengalaman_si" name="pengalaman_si" rows="3"
                                      class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                      required>{{ old('pengalaman_si') }}</textarea>
                            <x-input-error :messages="$errors->get('pengalaman_si')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label for="prestasi_akademik" class="text-sm font-semibold text-gray-800">Prestasi Akademik (Opsional)</label>
                                <textarea id="prestasi_akademik" name="prestasi_akademik" rows="2"
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('prestasi_akademik') }}</textarea>
                                <x-input-error :messages="$errors->get('prestasi_akademik')" class="mt-1" />
                            </div>
                            <div class="space-y-2">
                                <label for="prestasi_non_akademik" class="text-sm font-semibold text-gray-800">Prestasi Non-Akademik (Opsional)</label>
                                <textarea id="prestasi_non_akademik" name="prestasi_non_akademik" rows="2"
                                          class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('prestasi_non_akademik') }}</textarea>
                                <x-input-error :messages="$errors->get('prestasi_non_akademik')" class="mt-1" />
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">Pastikan data benar. Setelah disetujui admin, data akan terkunci.</p>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('kerja-praktek.index') }}"
                                   class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 rounded-xl bg-[#1a246a] text-white font-semibold shadow hover:bg-[#11194d]">
                                    Simpan Pendaftaran
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    const instansiSelect = document.getElementById('instansi_id');
    const pilihan1Input = document.getElementById('pilihan_1');

    function syncPilihan1() {
        const selected = instansiSelect.options[instansiSelect.selectedIndex];
        pilihan1Input.value = selected ? selected.text : '';
    }

    if (instansiSelect && pilihan1Input) {
        instansiSelect.addEventListener('change', syncPilihan1);
        syncPilihan1();
    }
</script>
@endpush
