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
                        <div class="p-8 bg-gradient-to-r from-blue-600 to-orange-600 text-white">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6A7.5 7.5 0 003 13.5M19.5 6A7.5 7.5 0 0012 13.5M3 13.5A7.5 7.5 0 0010.5 21M19.5 13.5A7.5 7.5 0 0012 21" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold">Dashboard Admin</h1>
                                    <p class="text-blue-100 text-sm">SIKP - Sistem Informasi KP</p>
                                </div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <p class="text-sm">Selamat datang,</p>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
    <div class="space-y-3">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-300 transform hover:scale-105
           {{ request()->routeIs('admin.dashboard') 
                ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg' 
                : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 hover:text-blue-800' }}">
            <div class="p-2 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25 
                          2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75" />
                </svg>
            </div>
            <span>Dashboard</span>
        </a>

        {{-- Kelola Pengguna --}}
        <a href="{{ route('admin.users') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-300
           {{ request()->routeIs('admin.users') 
                ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg'
                : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-100 hover:to-orange-200 hover:text-orange-800' }}">
            <div class="p-2 rounded-xl {{ request()->routeIs('admin.users') ? 'bg-white/20' : 'bg-orange-100 text-orange-600 group-hover:bg-orange-200' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 19.5L12 21.75 9 19.5m6-4.5L12 17.25 9 14.25M12 21.75V12" />
                </svg>
            </div>
            <span class="font-medium">Kelola Pengguna</span>
        </a>

        {{-- Monitor KP --}}
        <a href="{{ route('admin.monitoring') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-300
           {{ request()->routeIs('admin.monitoring') 
                ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg' 
                : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 hover:text-blue-800' }}">
            <div class="p-2 rounded-xl {{ request()->routeIs('admin.monitoring') ? 'bg-white/20' : 'bg-blue-100 text-blue-600 group-hover:bg-blue-200' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 13.5V6a2.25 2.25 0 012.25-2.25h8.25m-6 2.25L10.5 7.5m2.25 2.25L10.5 7.5m2.25 2.25V12" />
                </svg>
            </div>
            <span class="font-medium">Monitor KP</span>
        </a>

        {{-- Data Instansi --}}
        <a href="{{ route('admin.instansi.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-300
           {{ request()->routeIs('admin.instansi.index') 
                ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg'
                : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-100 hover:to-orange-200 hover:text-orange-800' }}">
            <div class="p-2 rounded-xl {{ request()->routeIs('admin.instansi.index') ? 'bg-white/20' : 'bg-orange-100 text-orange-600 group-hover:bg-orange-200' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20.25 14.15v4.25c0 1.09-1.09 2-2.25 2h-12c-1.16 0-2.25-1-2.25-2v-4.25" />
                </svg>
            </div>
            <span class="font-medium">Data Instansi</span>
        </a>

        {{-- Data Lowongan --}}
        <a href="{{ route('admin.lowongan.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-300
           {{ request()->routeIs('admin.lowongan.index') 
                ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg' 
                : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 hover:text-blue-800' }}">
            <div class="p-2 rounded-xl {{ request()->routeIs('admin.lowongan.index') ? 'bg-white/20' : 'bg-blue-100 text-blue-600 group-hover:bg-blue-200' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19.5 14.25v-4.5m-9 4.5v-4.5m-3 4.5v-4.5M6 21h12a3 3 0 003-3V6a3 3 0 00-3-3H6a3 3 0 00-3 3v12a3 3 0 003 3z" />
                </svg>
            </div>
            <span class="font-medium">Data Lowongan KP</span>
        </a>

        {{-- Alokasi Dosen --}}
        <a href="{{ route('admin.alokasi.pembimbing') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-300
           {{ request()->routeIs('admin.alokasi.pembimbing') 
                ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg'
                : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-100 hover:to-orange-200 hover:text-orange-800' }}">
            <div class="p-2 rounded-xl {{ request()->routeIs('admin.alokasi.pembimbing') ? 'bg-white/20' : 'bg-orange-100 text-orange-600 group-hover:bg-orange-200' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <span class="font-medium">Alokasi Dosen</span>
        </a>

        {{-- Logout --}}
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-red-100 hover:to-red-200 hover:text-red-800 transition-all duration-300 group">
            <div class="p-2 bg-red-100 text-red-600 rounded-xl group-hover:bg-red-200 transition-colors">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 
                          3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
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
                        <div class="p-8 bg-gradient-to-r from-blue-600 to-orange-600 text-white">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold">Dashboard Dosen</h1>
                                    <p class="text-blue-100 text-sm">SIKP - Sistem Informasi KP</p>
                                </div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <p class="text-sm">Selamat datang,</p>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
    <div class="space-y-3">

        {{-- Dashboard --}}
        <a href="{{ route('dosen.dashboard') }}"
           class="flex items-center gap-4 p-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105
           {{ request()->routeIs('dosen.dashboard') 
               ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' 
               : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 hover:text-blue-800' }}">
            <div class="p-2 rounded-xl 
                {{ request()->routeIs('dosen.dashboard') ? 'bg-white/20' : 'bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25 2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75"/>
                </svg>
            </div>
            <span>Dashboard</span>
        </a>

        {{-- Validasi Proposal --}}
        <a href="{{ route('dosen.proposal.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl font-medium transition-all duration-300
           {{ request()->routeIs('dosen.proposal.*')
               ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg'
               : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-100 hover:to-orange-200 hover:text-orange-800' }}">
            <div class="p-2 rounded-xl 
                {{ request()->routeIs('dosen.proposal.*') ? 'bg-white/20' : 'bg-orange-100 text-orange-600 group-hover:bg-orange-200 transition-colors' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span>Validasi Proposal</span>
        </a>

        {{-- Riwayat Bimbingan --}}
        <a href="{{ route('dosen.bimbingan.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl font-medium transition-all duration-300
           {{ request()->routeIs('dosen.bimbingan.*')
               ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg'
               : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 hover:text-blue-800' }}">
            <div class="p-2 rounded-xl 
                {{ request()->routeIs('dosen.bimbingan.*') ? 'bg-white/20' : 'bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <span>Riwayat Bimbingan</span>
        </a>

        {{-- Nilai Pembimbing --}}
        <a href="{{ route('dosen.nilai.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl font-medium transition-all duration-300
           {{ request()->routeIs('dosen.nilai.*')
               ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg'
               : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-100 hover:to-orange-200 hover:text-orange-800' }}">
            <div class="p-2 rounded-xl 
                {{ request()->routeIs('dosen.nilai.*') ? 'bg-white/20' : 'bg-orange-100 text-orange-600 group-hover:bg-orange-200 transition-colors' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span>Nilai Pembimbing</span>
        </a>

        {{-- Penguji Seminar --}}
        <a href="{{ route('dosen.seminar.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl font-medium transition-all duration-300
           {{ request()->routeIs('dosen.seminar.*')
               ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg'
               : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 hover:text-blue-800' }}">
            <div class="p-2 rounded-xl 
                {{ request()->routeIs('dosen.seminar.*') ? 'bg-white/20' : 'bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors' }}">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <span>Penguji Seminar</span>
        </a>

        {{-- Logout --}}
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-red-100 hover:to-red-200 hover:text-red-800 transition-all duration-300 group">
            <div class="p-2 bg-red-100 text-red-600 rounded-xl group-hover:bg-red-200 transition-colors">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
            <span>Logout</span>
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
                        <div class="p-8 bg-gradient-to-r from-green-600 to-emerald-600 text-white">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold">Dashboard Mahasiswa</h1>
                                    <p class="text-green-100 text-sm">SIKP - Sistem Informasi KP</p>
                                </div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <p class="text-sm">Selamat datang,</p>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
                            <div class="space-y-3">

                                <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <div class="p-2 bg-white/20 rounded-xl">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25 2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75" />
                                        </svg>
                                    </div>
                                    <span>Dashboard</span>
                                </a>

                                <a href="{{ route('mahasiswa.proposal.index') }}" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-pink-100 hover:to-pink-200 hover:text-pink-800 transition-all duration-300 group">
                                    <div class="p-2 bg-pink-100 text-pink-600 rounded-xl group-hover:bg-pink-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Pengajuan Proposal</span>
                                </a>

                                <a href="{{ route('mahasiswa.bimbingan.index') }}" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-100 hover:to-purple-200 hover:text-purple-800 transition-all duration-300 group">
                                    <div class="p-2 bg-purple-100 text-purple-600 rounded-xl group-hover:bg-purple-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Riwayat Bimbingan</span>
                                </a>

                                <a href="{{ route('mahasiswa.seminar.index') }}" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-pink-100 hover:to-pink-200 hover:text-pink-800 transition-all duration-300 group">
                                    <div class="p-2 bg-pink-100 text-pink-600 rounded-xl group-hover:bg-pink-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Seminar KP</span>
                                </a>

                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mahasiswa').submit();" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-red-100 hover:to-red-200 hover:text-red-800 transition-all duration-300 group">
                                    <div class="p-2 bg-red-100 text-red-600 rounded-xl group-hover:bg-red-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </div>
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
                        <div class="p-8 bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold">Dashboard Pembimbing</h1>
                                    <p class="text-teal-100 text-sm">SIKP - Sistem Informasi KP</p>
                                </div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <p class="text-sm">Selamat datang,</p>
                                <p class="font-semibold text-lg">{{ auth()->user()->nama }}</p>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="flex-1 p-6">
                            <div class="space-y-3">

                                <a href="{{ route('lapangan.dashboard') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-teal-500 to-cyan-500 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <div class="p-2 rounded-xl">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.955-7.51a1 1 0 011.23 0L21.75 12M3.75 11.25V18a2.25 2.25 0 002.25 2.25h12A2.25 2.25 0 0020.25 18v-6.75" />
                                        </svg>
                                    </div>
                                    <span>Dashboard</span>
                                </a>

                                <a href="{{ route('lapangan.nilai.index') }}" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-cyan-100 hover:to-cyan-200 hover:text-cyan-800 transition-all duration-300 group">
                                    <div class="p-2 bg-cyan-100 text-cyan-600 rounded-xl group-hover:bg-cyan-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.5L12 21.75 9 19.5m6-4.5L12 17.25 9 14.25M12 21.75V12" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Nilai Lapangan</span>
                                </a>

                                <a href="{{ route('lapangan.kuesioner.index') }}" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-teal-100 hover:to-teal-200 hover:text-teal-800 transition-all duration-300 group">
                                    <div class="p-2 bg-teal-100 text-teal-600 rounded-xl group-hover:bg-teal-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Kuesioner</span>
                                </a>

                                <a href="{{ route('lapangan.kuota.index') }}" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-emerald-100 hover:to-emerald-200 hover:text-emerald-800 transition-all duration-300 group">
                                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl group-hover:bg-emerald-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Usulan Kuota</span>
                                </a>

                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-pembimbing').submit();" class="flex items-center gap-4 p-4 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-red-100 hover:to-red-200 hover:text-red-800 transition-all duration-300 group">
                                    <div class="p-2 bg-red-100 text-red-600 rounded-xl group-hover:bg-red-200 transition-colors">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </div>
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
                {{ $slot ?? '' }}
            </main>
        </div>
    </body>
</html>
