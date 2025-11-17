<x-app-layout>
    <style>
        :root {
            --primary-blue: #1a246a; /* SIKP Blue */
            --accent-orange: #f97316; /* UNIB Orange */
            --light-bg: #f9fafb;
        }

        /* Menyesuaikan warna hover menu admin */
        .menu-link-blue:hover {
            border-color: var(--primary-blue) !important;
            background-color: rgba(26, 36, 106, 0.05) !important; /* light shade of primary-blue */
        }
        .menu-link-blue:hover p {
            color: var(--primary-blue) !important;
        }

        /* Menyesuaikan warna statistik card */
        .stat-card-blue {
            background-color: #e8ecfb; /* Lighter shade of Primary Blue */
            border-color: #c7d2fe;
        }
        .stat-text-blue {
            color: var(--primary-blue);
        }
        .stat-card-orange {
            background-color: #fff7ed; /* Lighter shade of Accent Orange */
            border-color: #fed7aa;
        }
        .stat-text-orange {
            color: var(--accent-orange);
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-[var(--primary-blue)]">
                    <span class="text-[var(--primary-blue)]">Dashboard</span> Admin
                </h2>
                <p class="mt-1 text-base text-gray-600">Kelola fitur sistem kerja praktek secara terpusat.</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-[var(--light-bg)] min-h-screen pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

            <section aria-labelledby="statistik-heading">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                    <div class="flex items-center justify-between p-6 rounded-2xl stat-card-blue border shadow-md">
                        <div>
                            <p class="text-base font-medium text-gray-600">Total Pengguna</p>
                            <p class="text-3xl font-extrabold stat-text-blue mt-1">
                                {{ \App\Models\User::count() }}
                            </p>
                        </div>
                        <div class="stat-text-blue">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-6 rounded-2xl stat-card-orange border shadow-md">
                        <div>
                            <p class="text-base font-medium text-gray-600">Total Instansi</p>
                            <p class="text-3xl font-extrabold stat-text-orange mt-1">
                                {{ \App\Models\Instansi::count() }}
                            </p>
                        </div>
                        <div class="stat-text-orange">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-6 rounded-2xl stat-card-blue border shadow-md">
                        <div>
                            <p class="text-base font-medium text-gray-600">KP Aktif</p>
                            <p class="text-3xl font-extrabold stat-text-blue mt-1">
                                {{ \App\Models\KerjaPraktek::where('status', 'aktif')->count() }}
                            </p>
                        </div>
                        <div class="stat-text-blue">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>

            <hr class="border-gray-300">

            <section aria-labelledby="menu-heading">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Akses Cepat Admin</h3>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xl">
                        <div class="mb-4">
                            <h4 class="text-xl font-bold text-[var(--primary-blue)]">Administrasi Sistem</h4>
                        </div>

                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('admin.users') }}"
                                    class="group block rounded-xl border border-gray-200 p-4 transition menu-link-blue
                                            focus:outline-none focus-visible:ring focus-visible:ring-blue-400">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 group-hover:text-[var(--primary-blue)]">
                                                Manajemen Users
                                            </p>
                                            <p class="text-sm text-gray-500">Kelola akun dan peran pengguna sistem</p>
                                        </div>
                                        <div class="mt-1 text-[var(--primary-blue)]">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.instansi.index') }}"
                                    class="group block rounded-xl border border-gray-200 p-4 transition menu-link-blue
                                            focus:outline-none focus-visible:ring focus-visible:ring-blue-400">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 group-hover:text-[var(--primary-blue)]">
                                                Manajemen Instansi
                                            </p>
                                            <p class="text-sm text-gray-500">Kelola data instansi tujuan kerja praktek</p>
                                        </div>
                                        <div class="mt-1 text-[var(--primary-blue)]">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.lowongan.index') }}"
                                    class="group block rounded-xl border border-gray-200 p-4 transition menu-link-blue
                                            focus:outline-none focus-visible:ring focus-visible:ring-blue-400">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 group-hover:text-[var(--primary-blue)]">
                                                Manajemen Lowongan KP
                                            </p>
                                            <p class="text-sm text-gray-500">Kelola daftar lowongan kerja praktek</p>
                                        </div>
                                        <div class="mt-1 text-[var(--primary-blue)]">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xl">
                        <div class="mb-4">
                            <h4 class="text-xl font-bold text-[var(--accent-orange)]">Proses & Alokasi</h4>
                        </div>

                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('admin.monitoring') }}"
                                    class="group block rounded-xl border border-gray-200 p-4 transition menu-link-blue
                                            focus:outline-none focus-visible:ring focus-visible:ring-blue-400">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 group-hover:text-[var(--primary-blue)]">
                                                Monitoring KP
                                            </p>
                                            <p class="text-sm text-gray-500">Pantau status dan progres kerja praktek</p>
                                        </div>
                                        <div class="mt-1 text-[var(--primary-blue)]">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.alokasi.pembimbing') }}"
                                    class="group block rounded-xl border border-gray-200 p-4 transition menu-link-blue
                                            focus:outline-none focus-visible:ring focus-visible:ring-blue-400">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 group-hover:text-[var(--primary-blue)]">
                                                Alokasi Dosen Pembimbing & Penguji
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Atur penugasan dosen pembimbing dan penguji
                                            </p>
                                        </div>
                                        <div class="mt-1 text-[var(--primary-blue)]">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.kuota.index') }}"
                                    class="group block rounded-xl border border-gray-200 p-4 transition menu-link-blue
                                            focus:outline-none focus-visible:ring focus-visible:ring-blue-400">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 group-hover:text-[var(--primary-blue)]">
                                                Manajemen Kuota
                                            </p>
                                            <p class="text-sm text-gray-500">Kelola kuota pendaftaran kerja praktek</p>
                                        </div>
                                        <div class="mt-1 text-[var(--primary-blue)]">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-xl lg:col-span-1">
                        <div class="mb-4">
                            <h4 class="text-xl font-bold text-gray-900">Papan Informasi</h4>
                        </div>

                        <div class="space-y-4">
                            <div class="rounded-xl p-4 stat-card-blue border">
                                <p class="font-semibold text-base stat-text-blue">Selamat datang di Dashboard Admin!</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    Gunakan menu di atas untuk mengakses fitur-fitur sistem kerja praktek.
                                </p>
                            </div>

                            <div class="rounded-xl p-4 stat-card-orange border">
                                <p class="font-semibold text-base stat-text-orange">Perhatian: Pembaruan Data!</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    Pastikan data instansi, lowongan, dan kuota selalu diperbarui secara berkala.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>
</x-app-layout>
