<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Header modern -->
            <header class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-semibold tracking-tight text-gray-900">Dashboard Mahasiswa</h2>
                        <p class="text-sm text-gray-500 mt-1">Selamat datang, <span class="font-medium text-gray-700">{{ auth()->user()->name ?? auth()->user()->nama }}</span></p>
                    </div>
                </div>
            </header>

            <!-- Statistik cards -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-stat-card color="blue" label="KP Aktif" :value="$kpAktifCount ?? 0" />
                <x-stat-card color="emerald" label="Sesi Bimbingan" :value="$bimbinganCount ?? 0" />
                <x-stat-card color="amber" label="Laporan Terunggah" :value="$laporanCount ?? 0" />
                <x-stat-card color="indigo" label="Seminar" :value="$seminarCount ?? 0" />
            </section>

            <!-- Manajemen grid -->
            <section>
                <h3 class="text-sm font-semibold text-gray-500 tracking-wide mb-3">Aksi Cepat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <x-manage-card href="{{ route('kerja-praktek.create') }}" color="indigo" title="Daftar KP Baru" desc="Ajukan/pilih instansi" />
                    <x-manage-card href="{{ route('kerja-praktek.index') }}" color="amber" title="Status KP" desc="Lihat & ubah pengajuan" />
                    <x-manage-card href="{{ route('mahasiswa.proposal.index') }}" color="blue" title="Proposal" desc="Unggah & kelola" />
                    <x-manage-card href="{{ route('mahasiswa.laporan.index') }}" color="emerald" title="Laporan Akhir" desc="Unggah & kelola" />
                </div>
            </section>
        </div>
    </div>
</x-app-layout>