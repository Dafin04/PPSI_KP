<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Kerja Praktek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('kerja-praktek.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="judul_kp" value="Judul Kerja Praktek" />
                            <x-text-input id="judul_kp" name="judul_kp" type="text" class="mt-1 block w-full"
                                        value="{{ old('judul_kp') }}" required />
                            <x-input-error :messages="$errors->get('judul_kp')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deskripsi_kp" value="Deskripsi Kerja Praktek" />
                            <textarea id="deskripsi_kp" name="deskripsi_kp" rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>{{ old('deskripsi_kp') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kp')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="tanggal_mulai" value="Tanggal Mulai" />
                                <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full"
                                            value="{{ old('tanggal_mulai') }}" required />
                                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_selesai" value="Tanggal Selesai" />
                                <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full"
                                            value="{{ old('tanggal_selesai') }}" required />
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="durasi_minggu" value="Durasi (minggu)" />
                            <x-text-input id="durasi_minggu" name="durasi_minggu" type="number" class="mt-1 block w-full"
                                        value="{{ old('durasi_minggu') }}" min="4" max="16" required />
                            <x-input-error :messages="$errors->get('durasi_minggu')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="instansi_id" value="Instansi" />
                            <select id="instansi_id" name="instansi_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Instansi</option>
                                @foreach($instansis as $instansi)
                                    <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                        {{ $instansi->nama_instansi }} - {{ $instansi->kota }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('instansi_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="dosen_pembimbing_id" value="Dosen Pembimbing" />
                            <select id="dosen_pembimbing_id" name="dosen_pembimbing_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Dosen Pembimbing</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->name }} - {{ $dosen->nip }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('dosen_pembimbing_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pilihan_1" value="Pilihan Tempat KP 1" />
                            <x-text-input id="pilihan_1" name="pilihan_1" type="text" class="mt-1 block w-full"
                                        value="{{ old('pilihan_1') }}" placeholder="Nama perusahaan/divisi yang diinginkan" required />
                            <x-input-error :messages="$errors->get('pilihan_1')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pilihan_2" value="Pilihan Tempat KP 2 (Opsional)" />
                            <x-text-input id="pilihan_2" name="pilihan_2" type="text" class="mt-1 block w-full"
                                        value="{{ old('pilihan_2') }}" placeholder="Pilihan kedua" />
                            <x-input-error :messages="$errors->get('pilihan_2')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pilihan_3" value="Pilihan Tempat KP 3 (Opsional)" />
                            <x-text-input id="pilihan_3" name="pilihan_3" type="text" class="mt-1 block w-full"
                                        value="{{ old('pilihan_3') }}" placeholder="Pilihan ketiga" />
                            <x-input-error :messages="$errors->get('pilihan_3')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="proposal_file" value="File Proposal (PDF/DOC/DOCX, Max 2MB)" />
                            <input id="proposal_file" name="proposal_file" type="file"
                                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                   accept=".pdf,.doc,.docx" />
                            <x-input-error :messages="$errors->get('proposal_file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('kerja-praktek.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                            <x-primary-button>
                                Simpan sebagai Draft
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
