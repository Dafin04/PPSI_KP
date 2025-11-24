<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">

            <!-- Sidebar Navigation -->
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">

                        <!-- Header Section in Sidebar -->
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

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
    <div class="space-y-2">

        {{-- Dashboard --}}
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

        {{-- Kelola Pengguna --}}
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

        {{-- Monitor KP --}}
        <a href="{{ route('admin.monitoring') }}"
           class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
           {{ request()->routeIs('admin.monitoring')
                ? 'bg-blue-500 text-white border-blue-400 shadow-md'
                : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.monitoring') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 13.5V6a2.25 2.25 0 012.25-2.25h8.25m-6 2.25L10.5 7.5m2.25 2.25L10.5 7.5m2.25 2.25V12" />
                </svg>
            </span>
            <span class="font-medium">Monitor KP</span>
        </a>

        {{-- Data Instansi --}}
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

        {{-- Data Lowongan --}}
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

        {{-- Alokasi Dosen --}}
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

        {{-- Logout --}}
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

                        <!-- Footer Info -->
                        <div class="p-6 border-t border-gray-200 bg-gray-50/50">
                            <div class="text-center">
                                <p class="text-xs text-gray-500">© 2024 SIKP</p>
                                <p class="text-xs text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                            </div>
                        </div>
                    </aside>
                @elseif(auth()->user()->hasRole('dosen') || auth()->user()->hasRole('dosen-biasa'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">

                        <!-- Header Section in Sidebar -->
                        <div class="p-8 bg-blue-700 text-white">
                            <div class="flex flex-col items-center text-center gap-3 mb-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-white/70">SIKP</p>
                                    <h1 class="text-2xl font-bold">Dashboard Dosen</h1>
                                </div>
                            </div>
                            <div class="text-center text-sm opacity-90">
                                <span class="text-white/70">Masuk sebagai</span>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
    <div class="space-y-2">

        {{-- Dashboard --}}
        <a href="{{ route('dosen.dashboard') }}"
           class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
           {{ request()->routeIs('dosen.dashboard')
               ? 'bg-blue-600 text-white border-blue-500 shadow-md'
               : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center
                {{ request()->routeIs('dosen.dashboard') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25 2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75"/>
                </svg>
            </span>
            <span class="font-medium">Dashboard</span>
        </a>

        {{-- Validasi Proposal --}}
        <a href="{{ route('dosen.proposal.index') }}"
           class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
           {{ request()->routeIs('dosen.proposal.*')
               ? 'bg-orange-500 text-white border-orange-400 shadow-md'
               : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center
                {{ request()->routeIs('dosen.proposal.*') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </span>
            <span class="font-medium">Validasi Proposal</span>
        </a>

        {{-- Riwayat Bimbingan --}}
        <a href="{{ route('dosen.bimbingan.index') }}"
           class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
           {{ request()->routeIs('dosen.bimbingan.*')
               ? 'bg-blue-500 text-white border-blue-400 shadow-md'
               : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center
                {{ request()->routeIs('dosen.bimbingan.*') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </span>
            <span class="font-medium">Riwayat Bimbingan</span>
        </a>

        {{-- Nilai Pembimbing --}}
        <a href="{{ route('dosen.nilai.index') }}"
           class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
           {{ request()->routeIs('dosen.nilai.*')
               ? 'bg-orange-500 text-white border-orange-400 shadow-md'
               : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center
                {{ request()->routeIs('dosen.nilai.*') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <span class="font-medium">Nilai Pembimbing</span>
        </a>

        {{-- Penguji Seminar --}}
        <a href="{{ route('dosen.seminar.index') }}"
           class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
           {{ request()->routeIs('dosen.seminar.*')
               ? 'bg-blue-500 text-white border-blue-400 shadow-md'
               : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center
                {{ request()->routeIs('dosen.seminar.*') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </span>
            <span class="font-medium">Penguji Seminar</span>
        </a>

        {{-- Logout --}}
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="flex items-center gap-4 rounded-xl px-4 py-3 border text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
            <span class="w-10 h-10 rounded-lg flex items-center justify-center bg-red-100 text-red-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </span>
            <span class="font-medium">Logout</span>
        </a>

    </div>
</nav>


                        <!-- Footer Info -->
                        <div class="p-6 border-t border-gray-200 bg-gray-50/50">
                            <div class="text-center">
                                <p class="text-xs text-gray-500">© 2024 SIKP</p>
                                <p class="text-xs text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                            </div>
                        </div>

                        <!-- Hidden Logout Form -->
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                    </aside>
                @elseif(auth()->user()->hasRole('mahasiswa'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">

                        <!-- Header Section in Sidebar -->
                        <div class="p-8 bg-gradient-to-r from-blue-700 to-indigo-600 text-white">
                            <div class="flex flex-col items-center text-center gap-3 mb-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-white/70">SIKP</p>
                                    <h1 class="text-2xl font-bold">Dashboard Mahasiswa</h1>
                                </div>
                            </div>
                            <div class="text-center text-sm opacity-90">
                                <span class="text-white/70">Masuk sebagai</span>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
                            <div class="space-y-2">

                                <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-blue-600 text-white border-blue-500 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25 2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Dashboard</span>
                                </a>

                                @php $instansiActive = request()->routeIs('mahasiswa.instansi.*'); @endphp
                                <a href="{{ route('mahasiswa.instansi.index') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ $instansiActive ? 'bg-orange-500 text-white border-orange-400 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ $instansiActive ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 11h14M7 15h10M9 19h6" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Pendaftaran Mandiri</span>
                                </a>

                                @php $kpActive = request()->routeIs('kerja-praktek.*'); @endphp
                                <a href="{{ route('kerja-praktek.index') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ $kpActive ? 'bg-blue-500 text-white border-blue-400 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ $kpActive ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m7-9H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Pendaftaran & Status KP</span>
                                </a>

                                @php $bimbinganActive = request()->routeIs('mahasiswa.bimbingan.*'); @endphp
                                <a href="{{ route('mahasiswa.bimbingan.index') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ $bimbinganActive ? 'bg-orange-500 text-white border-orange-400 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ $bimbinganActive ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Riwayat Bimbingan</span>
                                </a>

                                @php $seminarActive = request()->routeIs('mahasiswa.seminar.*'); @endphp
                                <a href="{{ route('mahasiswa.seminar.index') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ $seminarActive ? 'bg-blue-500 text-white border-blue-400 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ $seminarActive ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Seminar KP</span>
                                </a>

                                @php $laporanActive = request()->routeIs('mahasiswa.laporan.*'); @endphp
                                <a href="{{ route('mahasiswa.laporan.index') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ $laporanActive ? 'bg-orange-500 text-white border-orange-400 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ $laporanActive ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Laporan Akhir</span>
                                </a>

                                @php $nilaiActive = request()->routeIs('mahasiswa.nilai'); @endphp
                                <a href="{{ route('mahasiswa.nilai') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ $nilaiActive ? 'bg-blue-500 text-white border-blue-400 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ $nilaiActive ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-6 4h6M7 9h10m2 10H5a2 2 0 01-2-2V7a2 2 0 012-2h6.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V17a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Nilai Akhir</span>
                                </a>

                                @php $kuesionerActive = request()->routeIs('mahasiswa.kuesioner.*'); @endphp
                                <a href="{{ route('mahasiswa.kuesioner.index') }}" class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200 {{ $kuesionerActive ? 'bg-orange-500 text-white border-orange-400 shadow-md' : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ $kuesionerActive ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7m-7 13H5a2 2 0 01-2-2V6a2 2 0 012-2h7" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Kuesioner & Feedback</span>
                                </a>

                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mahasiswa').submit();" class="flex items-center gap-4 rounded-xl px-4 py-3 border text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center bg-red-100 text-red-600">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Logout</span>
                                </a>

                            </div>
                        </nav>

                        <!-- Footer Info -->
                        <div class="p-6 border-t border-gray-200 bg-gray-50/50">
                            <div class="text-center">
                                <p class="text-xs text-gray-500">© 2024 SIKP</p>
                                <p class="text-xs text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                            </div>
                        </div>

                        <!-- Hidden Logout Form -->
                        <form id="logout-form-mahasiswa" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                    </aside>
                @elseif(auth()->user()->hasRole('pembimbing-lapangan') || auth()->user()->hasRole('pembimbing_lapangan'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">

                        <!-- Header Section in Sidebar -->
                        <div class="p-8 bg-blue-700 text-white">
                            <div class="flex flex-col items-center text-center gap-3 mb-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-white/70">SIKP</p>
                                    <h1 class="text-2xl font-bold">Dashboard Pembimbing</h1>
                                </div>
                            </div>
                            <div class="text-center text-sm opacity-90">
                                <span class="text-white/70">Masuk sebagai</span>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
                            <div class="space-y-2">

                                <a href="{{ route('lapangan.dashboard') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('lapangan.dashboard')
                                        ? 'bg-blue-600 text-white border-blue-500 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.dashboard') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25 2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Dashboard</span>
                                </a>

                                <a href="{{ route('lapangan.nilai.index') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('lapangan.nilai.*')
                                        ? 'bg-orange-500 text-white border-orange-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.nilai.*') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.5L12 21.75 9 19.5m6-4.5L12 17.25 9 14.25M12 21.75V12" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Nilai Lapangan</span>
                                </a>

                                <a href="{{ route('lapangan.kuesioner.index') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('lapangan.kuesioner.*')
                                        ? 'bg-blue-500 text-white border-blue-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-blue-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.kuesioner.*') ? 'bg-white/20' : 'bg-blue-100 text-blue-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Kuesioner</span>
                                </a>

                                <a href="{{ route('lapangan.kuota.index') }}"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border transition-all duration-200
                                   {{ request()->routeIs('lapangan.kuota.*')
                                        ? 'bg-orange-500 text-white border-orange-400 shadow-md'
                                        : 'text-gray-700 border-gray-100 hover:bg-orange-50 hover:text-orange-700' }}">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.kuota.*') ? 'bg-white/20' : 'bg-orange-100 text-orange-600' }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Usulan Kuota</span>
                                </a>

                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-pembimbing').submit();"
                                   class="flex items-center gap-4 rounded-xl px-4 py-3 border text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                    <span class="w-10 h-10 rounded-lg flex items-center justify-center bg-red-100 text-red-600">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </span>
                                    <span class="font-medium">Logout</span>
                                </a>

                            </div>
                        </nav>

                        <!-- Footer Info -->
                        <div class="p-6 border-t border-gray-200 bg-gray-50/50">
                            <div class="text-center">
                                <p class="text-xs text-gray-500">© 2024 SIKP</p>
                                <p class="text-xs text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                            </div>
                        </div>

                        <!-- Hidden Logout Form -->
                        <form id="logout-form-pembimbing" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                    </aside>
                @endif
            @endauth

            <!-- Page Content -->
            <main class="flex-1 ml-80 p-6 overflow-y-auto">
                @auth
                    @if(auth()->user()->hasRole('mahasiswa') && request()->routeIs('mahasiswa.dashboard'))
                        <div class="flex justify-end mb-4">
                            <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <div class="flex items-center gap-2 text-sm">
                                    <a href="{{ route('mahasiswa.profil') }}" class="text-blue-600 hover:underline">Profil Saya</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="#" class="text-red-600 hover:underline"
                                       onclick="event.preventDefault(); document.getElementById('logout-form-mahasiswa').submit();">
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    @elseif((auth()->user()->hasRole('dosen') || auth()->user()->hasRole('dosen-biasa')) && request()->routeIs('dosen.dashboard'))
                        <div class="flex justify-end mb-4">
                            <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <div class="flex items-center gap-2 text-sm">
                                    <a href="{{ route('dosen.profil') }}" class="text-blue-600 hover:underline">Profil Saya</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="#" class="text-red-600 hover:underline"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    @elseif((auth()->user()->hasRole('pembimbing-lapangan') || auth()->user()->hasRole('pembimbing_lapangan')) && request()->routeIs('lapangan.dashboard'))
                        <div class="flex justify-end mb-4">
                            <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <div class="flex items-center gap-2 text-sm">
                                    <a href="{{ route('lapangan.profil') }}" class="text-blue-600 hover:underline">Profil Saya</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="#" class="text-red-600 hover:underline"
                                       onclick="event.preventDefault(); document.getElementById('logout-form-pembimbing').submit();">
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                {{ $slot ?? '' }}
            </main>
        </div>
    </body>
</html>


