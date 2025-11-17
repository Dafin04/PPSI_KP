<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Dosen Biasa') }}
            </h2>
            <div class="text-sm text-gray-600">
                Selamat datang, {{ auth()->user()->name }}!
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-bold">{{ $totalMahasiswa }}</h3>
                            <p class="text-blue-100">Total Mahasiswa</p>
                        </div>
                        <div class="text-4xl">👥</div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-bold">{{ $kpMembimbingCount }}</h3>
                            <p class="text-green-100">KP Membimbing</p>
                        </div>
                        <div class="text-4xl">📝</div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-bold">{{ $pendingApprovalsCount }}</h3>
                            <p class="text-yellow-100">Menunggu Approval</p>
                        </div>
                        <div class="text-4xl">⏳</div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-bold">{{ $completedKpCount }}</h3>
                            <p class="text-purple-100">KP Selesai</p>
                        </div>
                        <div class="text-4xl">✅</div>
                    </div>
                </div>
            </div>

            <!-- Menu Aksi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">🎓 Menu Akademik</h3>
                    <div class="space-y-3">
                        <a href="{{ route('dosen-pembimbing.jadwal') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 text-blue-800 rounded-lg transition-colors">
                            <span class="text-xl mr-3">📅</span>
                            <div>
                                <div class="font-medium">Jadwal Mengajar</div>
                                <div class="text-sm text-blue-600">Kelola jadwal perkuliahan</div>
                            </div>
                        </a>
                        <a href="{{ route('dosen-pembimbing.materi') }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg transition-colors">
                            <span class="text-xl mr-3">📚</span>
                            <div>
                                <div class="font-medium">Materi Kuliah</div>
                                <div class="text-sm text-green-600">Upload dan kelola materi</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">📋 Menu Kerja Praktek</h3>
                    <div class="space-y-3">
                        <a href="{{ route('kerja-praktek.index') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 text-purple-800 rounded-lg transition-colors">
                            <span class="text-xl mr-3">📋</span>
                            <div>
                                <div class="font-medium">Daftar KP Mahasiswa</div>
                                <div class="text-sm text-purple-600">Lihat semua pendaftaran KP</div>
                            </div>
                        </a>
                        <a href="{{ route('mahasiswa.profil') }}" class="flex items-center p-3 bg-yellow-50 hover:bg-yellow-100 text-yellow-800 rounded-lg transition-colors">
                            <span class="text-xl mr-3">👥</span>
                            <div>
                                <div class="font-medium">Data Mahasiswa</div>
                                <div class="text-sm text-yellow-600">Lihat profil mahasiswa</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa Bimbingan KP -->
            @if($kpMembimbingCount > 0)
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">👨‍🎓 Mahasiswa Bimbingan KP</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recentKpMahasiswa ?? [] as $kp)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-800">{{ $kp->mahasiswa->name ?? 'N/A' }}</h4>
                            <span class="inline-block bg-{{ $kp->status === 'disetujui' ? 'green' : ($kp->status === 'diajukan' ? 'yellow' : 'blue') }}-100 text-{{ $kp->status === 'disetujui' ? 'green' : ($kp->status === 'diajukan' ? 'yellow' : 'blue') }}-800 px-2 py-1 rounded-full text-xs">
                                {{ ucfirst($kp->status ?? 'draft') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $kp->judul_kp ?? 'Judul belum diset' }}</p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>📅 {{ $kp->created_at->format('d/m/Y') }}</span>
                            <a href="{{ route('kerja-praktek.show', $kp->id) }}" class="text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Informasi & Pengumuman -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">📢 Informasi & Pengumuman</h3>
                <div class="space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <span class="text-2xl mr-3">👋</span>
                            <div>
                                <p class="text-blue-800 font-medium">Selamat datang di dashboard Dosen!</p>
                                <p class="text-blue-600 text-sm mt-1">Gunakan menu di samping untuk mengakses fitur akademik dan KP.</p>
                                <p class="text-blue-600 text-sm">Jaga selalu kualitas pengajaran dan bimbingan kepada mahasiswa.</p>
                            </div>
                        </div>
                    </div>

                    @if($pendingApprovalsCount > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <span class="text-2xl mr-3">⚠️</span>
                            <div>
                                <p class="text-yellow-800 font-medium">Pemberitahuan Penting!</p>
                                <p class="text-yellow-700 text-sm">Terdapat {{ $pendingApprovalsCount }} pendaftaran KP yang menunggu approval Anda.</p>
                                <a href="{{ route('kerja-praktek.index') }}" class="text-yellow-800 font-medium text-sm hover:underline">Lihat sekarang →</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($kpMembimbingCount == 0)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <span class="text-2xl mr-3">📝</span>
                            <div>
                                <p class="text-green-800 font-medium">Belum ada mahasiswa bimbingan KP</p>
                                <p class="text-green-600 text-sm">Sistem akan menampilkan mahasiswa yang Anda bimbing setelah ada pendaftaran KP yang disetujui.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
