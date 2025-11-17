<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kerja Praktek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ $kerjaPraktek->judul_kp }}</h3>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Status:</span>
                            {!! $kerjaPraktek->getStatusBadgeAttribute() !!}
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Informasi Mahasiswa</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nama:</span> {{ $kerjaPraktek->mahasiswa->name }}</p>
                                <p><span class="font-medium">NIM:</span> {{ $kerjaPraktek->mahasiswa->nim }}</p>
                                <p><span class="font-medium">Jurusan:</span> {{ $kerjaPraktek->mahasiswa->jurusan }}</p>
                                <p><span class="font-medium">Angkatan:</span> {{ $kerjaPraktek->mahasiswa->angkatan }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3">Informasi KP</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Instansi:</span> {{ $kerjaPraktek->instansi->nama_instansi }}</p>
                                <p><span class="font-medium">Dosen Pembimbing:</span> {{ $kerjaPraktek->dosenPembimbing->name ?? '-' }}</p>
                                <p><span class="font-medium">Pengawas Lapangan:</span> {{ $kerjaPraktek->pengawasLapangan->name ?? '-' }}</p>
                                <p><span class="font-medium">Durasi:</span> {{ $kerjaPraktek->durasi_minggu }} minggu</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-700 mb-3">Periode KP</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p><span class="font-medium">Tanggal Mulai:</span> {{ $kerjaPraktek->tanggal_mulai->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p><span class="font-medium">Tanggal Selesai:</span> {{ $kerjaPraktek->tanggal_selesai->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-700 mb-3">Pilihan Tempat KP</h4>
                        <div class="space-y-2">
                            <p><span class="font-medium">Pilihan 1:</span> {{ $kerjaPraktek->pilihan_1 }}</p>
                            @if($kerjaPraktek->pilihan_2)
                                <p><span class="font-medium">Pilihan 2:</span> {{ $kerjaPraktek->pilihan_2 }}</p>
                            @endif
                            @if($kerjaPraktek->pilihan_3)
                                <p><span class="font-medium">Pilihan 3:</span> {{ $kerjaPraktek->pilihan_3 }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-700 mb-3">Deskripsi</h4>
                        <div class="bg-gray-50 p-4 rounded">
                            <p>{{ $kerjaPraktek->deskripsi_kp }}</p>
                        </div>
                    </div>

                    @if($kerjaPraktek->proposal_file)
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-700 mb-3">File Proposal</h4>
                            <a href="{{ route('kerja-praktek.download', ['type' => 'proposal', 'kerjaPraktek' => $kerjaPraktek]) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Download Proposal
                            </a>
                        </div>
                    @endif

                    @if($kerjaPraktek->laporan_akhir_file)
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-700 mb-3">Laporan Akhir</h4>
                            <a href="{{ route('kerja-praktek.download', ['type' => 'laporan_akhir', 'kerjaPraktek' => $kerjaPraktek]) }}"
                               class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Download Laporan Akhir
                            </a>
                        </div>
                    @endif

                    @if($kerjaPraktek->lembar_pengesahan_file)
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-700 mb-3">Lembar Pengesahan</h4>
                            <a href="{{ route('kerja-praktek.download', ['type' => 'lembar_pengesahan', 'kerjaPraktek' => $kerjaPraktek]) }}"
                               class="inline-flex items-center px-4 py-2 bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Download Lembar Pengesahan
                            </a>
                        </div>
                    @endif

                    @if($kerjaPraktek->canUploadLaporan() && $kerjaPraktek->mahasiswa_id === auth()->id())
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-700 mb-3">Upload Laporan</h4>
                            <form action="{{ route('kerja-praktek.upload-laporan', $kerjaPraktek) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="laporan_akhir_file" value="Laporan Akhir (PDF/DOC/DOCX, Max 5MB)" />
                                    <input id="laporan_akhir_file" name="laporan_akhir_file" type="file"
                                           class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                           accept=".pdf,.doc,.docx" />
                                    <x-input-error :messages="$errors->get('laporan_akhir_file')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="lembar_pengesahan_file" value="Lembar Pengesahan (PDF/JPG/JPEG/PNG, Max 2MB)" />
                                    <input id="lembar_pengesahan_file" name="lembar_pengesahan_file" type="file"
                                           class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                           accept=".pdf,.jpg,.jpeg,.png" />
                                    <x-input-error :messages="$errors->get('lembar_pengesahan_file')" class="mt-2" />
                                </div>

                                <x-primary-button>
                                    Upload Laporan
                                </x-primary-button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('kerja-praktek.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>

                        @if(auth()->user()->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) && $kerjaPraktek->status === 'diajukan')
                            <div class="space-x-2">
                                <form action="{{ route('kerja-praktek.approve', $kerjaPraktek) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('kerja-praktek.reject', $kerjaPraktek) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="text" name="alasan_penolakan" placeholder="Alasan penolakan" required>
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if(auth()->user()->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) && $kerjaPraktek->status === 'disetujui')
                            <div class="space-x-2">
                                <form action="{{ route('kerja-praktek.start', $kerjaPraktek) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Mulai KP
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if(auth()->user()->hasAnyRole(['admin', 'dosen', 'dosen-biasa']) && $kerjaPraktek->status === 'berlangsung')
                            <div class="space-x-2">
                                <form action="{{ route('kerja-praktek.complete', $kerjaPraktek) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                        Selesaikan KP
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
