<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kerja Praktek') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 md:p-8 space-y-8">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Header judul & status --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <p class="text-sm text-gray-500">Judul KP</p>
                        <h3 class="text-2xl font-semibold text-gray-900">{{ $kerjaPraktek->judul_kp }}</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Status:</span>
                        {!! $kerjaPraktek->getStatusBadgeAttribute() !!}
                    </div>
                </div>

                {{-- Informasi ringkas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                        <p class="text-sm font-semibold text-gray-800">Informasi Mahasiswa</p>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p><span class="font-medium">Nama:</span> {{ $kerjaPraktek->mahasiswa->name }}</p>
                            <p><span class="font-medium">NIM:</span> {{ $kerjaPraktek->mahasiswa->nim }}</p>
                            <p><span class="font-medium">Jurusan:</span> {{ $kerjaPraktek->mahasiswa->jurusan }}</p>
                            <p><span class="font-medium">Angkatan:</span> {{ $kerjaPraktek->mahasiswa->angkatan }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                        <p class="text-sm font-semibold text-gray-800">Informasi KP</p>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p><span class="font-medium">Instansi:</span> {{ $kerjaPraktek->instansi->nama_instansi }}</p>
                            <p><span class="font-medium">Dosen Pembimbing:</span> {{ $kerjaPraktek->dosenPembimbing->name ?? '-' }}</p>
                            <p><span class="font-medium">Pengawas Lapangan:</span> {{ $kerjaPraktek->pengawasLapangan->name ?? '-' }}</p>
                            <p><span class="font-medium">Durasi:</span> {{ $kerjaPraktek->durasi_minggu }} minggu</p>
                        </div>
                    </div>
                </div>

                {{-- Periode & pilihan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-100 rounded-xl p-4 space-y-2 shadow-sm">
                        <p class="text-sm font-semibold text-gray-800">Periode KP</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
                            <p><span class="font-medium">Tanggal Mulai:</span> {{ $kerjaPraktek->tanggal_mulai->format('d F Y') }}</p>
                            <p><span class="font-medium">Tanggal Selesai:</span> {{ $kerjaPraktek->tanggal_selesai->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-xl p-4 space-y-2 shadow-sm">
                        <p class="text-sm font-semibold text-gray-800">Pilihan Tempat KP</p>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p><span class="font-medium">Pilihan 1:</span> {{ $kerjaPraktek->pilihan_1 }}</p>
                            @if($kerjaPraktek->pilihan_2)
                                <p><span class="font-medium">Pilihan 2:</span> {{ $kerjaPraktek->pilihan_2 }}</p>
                            @endif
                            @if($kerjaPraktek->pilihan_3)
                                <p><span class="font-medium">Pilihan 3:</span> {{ $kerjaPraktek->pilihan_3 }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Deskripsi KP</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $kerjaPraktek->deskripsi_kp }}</p>
                </div>

                {{-- Data pendukung --}}
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm space-y-3">
                    <p class="text-sm font-semibold text-gray-800">Data Pendukung Mahasiswa</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div class="space-y-1">
                            <p class="font-medium text-gray-800">Bukti IPK</p>
                            @if($kerjaPraktek->bukti_ipk_file)
                                <a href="{{ asset('storage/'.$kerjaPraktek->bukti_ipk_file) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5A2.25 2.25 0 005.25 10.5v7.5A2.25 2.25 0 007.5 20.25h9a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0016.5 8.25H15m-6 0V6a3 3 0 016 0v2.25m-6 0h6" /></svg>
                                    Lihat Bukti IPK
                                </a>
                            @else
                                <span class="text-gray-500">Tidak ada file</span>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <p class="font-medium text-gray-800">Pengalaman Sistem Informasi</p>
                            <p>{{ $kerjaPraktek->pengalaman_si ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2 space-y-1">
                            <p class="font-medium text-gray-800">Prestasi Akademik (Opsional)</p>
                            <p>{{ $kerjaPraktek->prestasi_akademik ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2 space-y-1">
                            <p class="font-medium text-gray-800">Prestasi Non-Akademik (Opsional)</p>
                            <p>{{ $kerjaPraktek->prestasi_non_akademik ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- File lampiran --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($kerjaPraktek->proposal_file)
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 space-y-2">
                            <p class="text-sm font-semibold text-blue-900">File Proposal</p>
                            <a href="{{ route('kerja-praktek.download', ['type' => 'proposal', 'kerjaPraktek' => $kerjaPraktek]) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5A2.25 2.25 0 005.25 10.5v7.5A2.25 2.25 0 007.5 20.25h9a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0016.5 8.25H15m-6 0V6a3 3 0 016 0v2.25m-6 0h6" /></svg>
                                Download Proposal
                            </a>
                        </div>
                    @endif
                    @if($kerjaPraktek->laporan_akhir_file)
                        <div class="bg-green-50 border border-green-100 rounded-xl p-4 space-y-2">
                            <p class="text-sm font-semibold text-green-900">Laporan Akhir</p>
                            <a href="{{ route('kerja-praktek.download', ['type' => 'laporan_akhir', 'kerjaPraktek' => $kerjaPraktek]) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold shadow hover:bg-green-700">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5A2.25 2.25 0 005.25 10.5v7.5A2.25 2.25 0 007.5 20.25h9a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0016.5 8.25H15m-6 0V6a3 3 0 016 0v2.25m-6 0h6" /></svg>
                                Download Laporan
                            </a>
                        </div>
                    @endif
                    @if($kerjaPraktek->lembar_pengesahan_file)
                        <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 space-y-2">
                            <p class="text-sm font-semibold text-purple-900">Lembar Pengesahan</p>
                            <a href="{{ route('kerja-praktek.download', ['type' => 'lembar_pengesahan', 'kerjaPraktek' => $kerjaPraktek]) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-semibold shadow hover:bg-purple-700">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5A2.25 2.25 0 005.25 10.5v7.5A2.25 2.25 0 007.5 20.25h9a2.25 2.25 0 002.25-2.25v-7.5A2.25 2.25 0 0016.5 8.25H15m-6 0V6a3 3 0 016 0v2.25m-6 0h6" /></svg>
                                Download Pengesahan
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Upload laporan untuk mahasiswa --}}
                @if($kerjaPraktek->canUploadLaporan() && $kerjaPraktek->mahasiswa_id === auth()->id())
                    <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm space-y-3">
                        <p class="text-sm font-semibold text-gray-800">Upload Laporan</p>
                        <form action="{{ route('kerja-praktek.upload-laporan', $kerjaPraktek) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="laporan_akhir_file" value="Laporan Akhir (PDF/DOC/DOCX, Max 5MB)" />
                                <input id="laporan_akhir_file" name="laporan_akhir_file" type="file"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm"
                                       accept=".pdf,.doc,.docx" />
                                <x-input-error :messages="$errors->get('laporan_akhir_file')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="lembar_pengesahan_file" value="Lembar Pengesahan (PDF/JPG/JPEG/PNG, Max 2MB)" />
                                <input id="lembar_pengesahan_file" name="lembar_pengesahan_file" type="file"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm"
                                       accept=".pdf,.jpg,.jpeg,.png" />
                                <x-input-error :messages="$errors->get('lembar_pengesahan_file')" class="mt-2" />
                            </div>

                            <button type="submit" class="inline-flex items-center px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-100">
                                Upload Laporan
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Aksi admin/dosen --}}
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <a href="{{ route('kerja-praktek.index') }}" class="inline-flex items-center px-4 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold">
                        Kembali
                    </a>

                    <div class="flex flex-wrap gap-2">
                        @if(auth()->user()->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) && $kerjaPraktek->status === 'diajukan')
                            <form action="{{ route('kerja-praktek.approve', $kerjaPraktek) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-3 rounded-xl bg-green-600 text-white font-semibold shadow hover:bg-green-700 focus:ring-4 focus:ring-green-100">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('kerja-praktek.reject', $kerjaPraktek) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="text" name="alasan_penolakan" placeholder="Alasan penolakan" required
                                       class="rounded-xl border border-gray-200 px-3 py-2 text-sm focus:ring-red-500 focus:border-red-500">
                                <button type="submit" class="inline-flex items-center px-4 py-3 rounded-xl bg-red-600 text-white font-semibold shadow hover:bg-red-700 focus:ring-4 focus:ring-red-100">
                                    Tolak
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) && $kerjaPraktek->status === 'disetujui')
                            <form action="{{ route('kerja-praktek.start', $kerjaPraktek) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-100">
                                    Mulai KP
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) && $kerjaPraktek->status === 'berlangsung')
                            <form action="{{ route('kerja-praktek.complete', $kerjaPraktek) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-3 rounded-xl bg-purple-600 text-white font-semibold shadow hover:bg-purple-700 focus:ring-4 focus:ring-purple-100">
                                    Selesaikan KP
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
