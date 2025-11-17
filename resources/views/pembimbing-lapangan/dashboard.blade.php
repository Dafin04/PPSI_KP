<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Header modern -->
            <header class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-semibold tracking-tight text-gray-900">Dashboard Pembimbing Lapangan</h2>
                        <p class="text-sm text-gray-500 mt-1">Selamat datang, <span class="font-medium text-gray-700">{{ auth()->user()->name ?? auth()->user()->nama }}</span></p>
                    </div>
                </div>
            </header>

            <!-- Statistik cards (gunakan default 0 jika tidak ada) -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-stat-card color="blue" label="Nilai Diberikan" :value="$nilaiCount ?? 0" />
                <x-stat-card color="emerald" label="Kuesioner" :value="$kuesionerCount ?? 0" />
                <x-stat-card color="amber" label="Usulan Kuota" :value="$kuotaCount ?? 0" />
                <x-stat-card color="indigo" label="Instansi" :value="$instansiCount ?? 0" />
            </section>

            <!-- Manajemen grid -->
            <section>
                <h3 class="text-sm font-semibold text-gray-500 tracking-wide mb-3">Aksi Cepat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <x-manage-card href="{{ route('lapangan.nilai.index') }}" color="indigo" title="Nilai Lapangan" desc="Input & perbarui" />
                    <x-manage-card href="{{ route('lapangan.kuesioner.index') }}" color="blue" title="Kuesioner" desc="Feedback & survei" />
                    <x-manage-card href="{{ route('lapangan.kuota.index') }}" color="emerald" title="Usulan Kuota" desc="Kelola kuota" />
                    <x-manage-card href="{{ route('lapangan.dashboard') }}" color="amber" title="Ringkasan" desc="Statistik harian" />
                </div>
            </section>
        </div>
    </div>
</x-app-layout>