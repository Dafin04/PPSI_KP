<x-app-layout>
    <!-- Header -->
    <header class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Dashboard Dosen</h2>
            <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->nama }} 👋</p>
        </div>
    </header>

    <!-- Statistik -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-bar-chart-fill text-blue-600"></i> Statistik Sistem
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm">Total Mahasiswa</span>
                    <i class="bi bi-people-fill text-2xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $totalMahasiswa ?? 0 }}</p>
            </div>

            <div class="p-6 bg-gradient-to-r from-green-400 to-emerald-500 text-white rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm">KP Membimbing</span>
                    <i class="bi bi-book text-2xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $kpMembimbingCount ?? 0 }}</p>
            </div>

            <div class="p-6 bg-gradient-to-r from-yellow-400 to-amber-500 text-gray-900 rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium">Menunggu Approval</span>
                    <i class="bi bi-clock text-2xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $pendingApprovalsCount ?? 0 }}</p>
            </div>

            <div class="p-6 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm">KP Selesai</span>
                    <i class="bi bi-check-circle-fill text-2xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2">{{ $completedKpCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Manajemen -->
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-gear-fill text-indigo-600"></i> Manajemen
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('dosen.proposal.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-lg border border-gray-100 transition transform hover:-translate-y-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="bi bi-file-earmark-text text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Validasi Proposal</h4>
                </div>
                <p class="text-gray-500 text-sm">Review & setujui proposal mahasiswa</p>
            </a>

            <a href="{{ route('dosen.bimbingan.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-lg border border-gray-100 transition transform hover:-translate-y-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-3 bg-green-100 text-green-600 rounded-xl group-hover:bg-green-600 group-hover:text-white transition">
                        <i class="bi bi-chat-dots text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Riwayat Bimbingan</h4>
                </div>
                <p class="text-gray-500 text-sm">Catatan pertemuan bimbingan</p>
            </a>

            <a href="{{ route('dosen.nilai.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-lg border border-gray-100 transition transform hover:-translate-y-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-xl group-hover:bg-yellow-500 group-hover:text-white transition">
                        <i class="bi bi-star-fill text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Nilai Pembimbing</h4>
                </div>
                <p class="text-gray-500 text-sm">Input & perbarui nilai mahasiswa</p>
            </a>

            <a href="{{ route('dosen.seminar.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-lg border border-gray-100 transition transform hover:-translate-y-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition">
                        <i class="bi bi-mic-fill text-xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Penguji Seminar</h4>
                </div>
                <p class="text-gray-500 text-sm">Penilaian seminar mahasiswa</p>
            </a>
        </div>
    </div>
</x-app-layout>
