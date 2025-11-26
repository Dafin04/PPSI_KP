<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">

            <!-- Sidebar Navigation -->
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">
                        <div class="p-8 bg-blue-700 text-white">
                            <div class="flex flex-col items-center text-center gap-3 mb-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-white/70">SIKP</p>
                                    <h1 class="text-2xl font-bold">Dashboard Admin</h1>
                                </div>
                            </div>
                            <div class="text-center text-sm text-white/80">
                                <span>Masuk sebagai</span>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <nav class="flex-1 p-6">
                            <div class="space-y-2">
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('admin.dashboard')
                                        ? 'bg-blue-600 text-white border-blue-500 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25
                                                  2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75" />
                                        </svg>
                                    </span>
                                    <span>Dashboard</span>
                                </a>

                                <a href="{{ route('admin.users') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('admin.users')
                                        ? 'bg-orange-500 text-white border-orange-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.users') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 19.5L12 21.75 9 19.5m6-4.5L12 17.25 9 14.25M12 21.75V12" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Kelola Pengguna</span>
                                </a>

                                <a href="{{ route('admin.instansi.index') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('admin.instansi.index')
                                        ? 'bg-orange-500 text-white border-orange-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.instansi.index') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M20.25 14.15v4.25c0 1.09-1.09 2-2.25 2h-12c-1.16 0-2.25-1-2.25-2v-4.25" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Data Instansi</span>
                                </a>

                                <a href="{{ route('admin.lowongan.index') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('admin.lowongan.index')
                                        ? 'bg-blue-500 text-white border-blue-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.lowongan.index') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 14.25v-4.5m-9 4.5v-4.5m-3 4.5v-4.5M6 21h12a3 3 0 003-3V6a3 3 0 00-3-3H6a3 3 0 00-3 3v12a3 3 0 003 3z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Data Lowongan KP</span>
                                </a>

                                <a href="{{ route('admin.alokasi.pembimbing') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('admin.alokasi.pembimbing')
                                        ? 'bg-orange-500 text-white border-orange-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.alokasi.pembimbing') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Alokasi Dosen</span>
                                </a>

                                <a href="{{ route('admin.kuesioner.instansi') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('admin.kuesioner.instansi')
                                        ? 'bg-orange-500 text-white border-orange-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.kuesioner.instansi') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 6.75a3 3 0 110 6 3 3 0 010-6zm0 0v-.75m0 8.25v1.5m6.364-6.364l.53.53m-13.788-.53l-.53.53m12.02 4.72l.53.53m-9.303-.53l-.53.53" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Hasil Kuesioner</span>
                                </a>

                                <a href="{{ route('admin.periode.index') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('admin.periode.*')
                                        ? 'bg-blue-600 text-white border-blue-500 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.periode.*') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Periode KP</span>
                                </a>

                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center bg-red-100 text-red-600">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3
                                                  3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            </div>
                        </nav>

                        <div class="p-6 border-t border-gray-200 bg-gray-50/50 text-center text-xs text-gray-500">
                            <p>Ac 2024 SIKP</p>
                            <p class="text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                        </div>
                    </aside>

                @elseif(auth()->user()->hasRole('dosen') || auth()->user()->hasRole('dosen-biasa'))
                    {{-- ... existing dosen sidebar ... --}}

                @elseif(auth()->user()->hasRole('pembimbing-lapangan') || auth()->user()->hasRole('pembimbing_lapangan'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex flex-col items-center text-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo UNIB" class="w-14 h-14 object-contain">
                                </div>
                                <span class="text-sm uppercase tracking-[0.3em] text-blue-700 font-semibold">SIKP</span>
                            </div>
                        </div>

                        <nav class="flex-1 p-6 space-y-1 text-sm">
                            <a href="{{ route('lapangan.dashboard') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs('lapangan.dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.dashboard') ? 'bg-white shadow text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5"/></svg>
                                </span>
                                <span>Dashboard</span>
                            </a>

                            <a href="{{ route('lapangan.nilai.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs('lapangan.nilai.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.nilai.*') ? 'bg-white shadow text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <span>Nilai Lapangan</span>
                            </a>

                            <a href="{{ route('lapangan.kuesioner.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs('lapangan.kuesioner.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.kuesioner.*') ? 'bg-white shadow text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                <span>Kuesioner</span>
                            </a>

                            <a href="{{ route('lapangan.kuota.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs('lapangan.kuota.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.kuota.*') ? 'bg-white shadow text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                                </span>
                                <span>Usulan Kuota</span>
                            </a>

                            <div class="pt-4">
                                <span class="text-xs uppercase tracking-wide text-gray-400">Akun</span>
                            </div>
                            <a href="{{ route('lapangan.profil') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs('lapangan.profil') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.profil') ? 'bg-white shadow text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20a6 6 0 1112 0H6z"/></svg>
                                </span>
                                <span>Profil</span>
                            </a>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-pembimbing').submit();"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-700 transition">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-red-50 text-red-600">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </span>
                                <span class="font-medium">Logout</span>
                            </a>
                        </nav>

                        <form id="logout-form-pembimbing" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
                    </aside>

                @endif
            @endauth

            <main class="flex-1 ml-80 p-6 overflow-y-auto">
                @auth
                    {{-- Top profile bar mahasiswa/dosen/pembimbing handled in previous sections if needed --}}
                @endauth

                {{ $slot ?? '' }}
            </main>
        </div>
    </body>
</html>
