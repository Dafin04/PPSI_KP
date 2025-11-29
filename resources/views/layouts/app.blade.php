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
                        <div class="bg-[#1a246a] text-white text-center px-6 py-10">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-2xl bg-white/15 flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 object-contain">
                                </div>
                                <div class="flex flex-col items-center leading-tight gap-1">
                                    <span class="text-2xl font-bold tracking-wide">SIKP</span>
                                    <span class="text-xs uppercase tracking-widest text-white/80">Sistem Informasi Kerja Praktik</span>
                                    <span class="text-[11px] uppercase tracking-widest text-white/70">Universitas Bengkulu</span>
                                </div>
                            </div>
                        </div>

                        <nav class="flex-1 p-6 space-y-2 text-sm text-gray-800">
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Menu</div>

                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('admin.dashboard')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5" />
                                    </svg>
                                </span>
                                <span class="font-medium">Dashboard</span>
                            </a>

                            <a href="{{ route('admin.instansi.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('admin.instansi.index')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.instansi.index') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4 21V9a1 1 0 011-1h3v13m4 0V9h3a1 1 0 011 1v11m-7-6h3" />
                                    </svg>
                                </span>
                                <span class="font-medium">Data Instansi</span>
                            </a>

                            <a href="{{ route('admin.lowongan.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                                {{ request()->routeIs('admin.lowongan.index')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.lowongan.index') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <rect x="4" y="5" width="16" height="14" rx="2" ry="2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9h12M6 13h8" />
                                    </svg>
                                </span>
                                <span class="font-medium">Data Lowongan KP</span>
                            </a>

                            <a href="{{ route('admin.alokasi.pembimbing') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                                {{ request()->routeIs('admin.alokasi.pembimbing')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.alokasi.pembimbing') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20a6 6 0 1112 0H6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 8h3m-1.5-1.5v3" />
                                    </svg>
                                </span>
                                <span class="font-medium">Alokasi Dosen</span>
                            </a>

                            <a href="{{ route('admin.kuesioner.instansi') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                                {{ request()->routeIs('admin.kuesioner.instansi')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.kuesioner.instansi') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5" />
                                    </svg>
                                </span>
                                <span class="font-medium">Hasil Kuesioner</span>
                            </a>

                            <a href="{{ route('admin.periode.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('admin.periode.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.periode.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <span class="font-medium">Periode KP</span>
                            </a>

                            <div class="pt-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Akun</div>

                            <a href="{{ route('admin.users') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('admin.users')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.users') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M23 20v-2a4 4 0 00-3-3.87" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 010 7.75" />
                                    </svg>
                                </span>
                                <span class="font-medium">Kelola Pengguna</span>
                            </a>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border text-gray-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center bg-red-50 text-red-600">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3
                                              3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </span>
                                <span class="font-medium">Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </nav>

                        <div class="p-6 border-t border-gray-200 bg-gray-50/50 text-center text-xs text-gray-500">
                            <p>@2025 SIKP</p>
                            <p class="text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                        </div>
                    </aside>

                @elseif(auth()->user()->hasRole('mahasiswa'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">
                        <div class="bg-[#1a246a] text-white text-center px-6 py-10">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-2xl bg-white/15 flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo UNIB" class="w-16 h-16 object-contain">
                                </div>
                                <div class="flex flex-col items-center leading-tight gap-1">
                                    <span class="text-2xl font-bold tracking-wide">SIKP</span>
                                    <span class="text-xs uppercase tracking-widest text-white/80">Sistem Informasi Kerja Praktik</span>
                                    <span class="text-[11px] uppercase tracking-widest text-white/70">Universitas Bengkulu</span>
                                </div>
                            </div>
                        </div>

                        <nav class="flex-1 p-6 space-y-2 text-sm text-gray-800">
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Menu</div>

                            <a href="{{ route('mahasiswa.dashboard') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('mahasiswa.dashboard')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5" />
                                    </svg>
                                </span>
                                <span class="font-medium">Dashboard</span>
                            </a>

                            <a href="{{ route('kerja-praktek.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('kerja-praktek.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('kerja-praktek.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8h6M9 12h6M9 16h3" />
                                    </svg>
                                </span>
                                <span class="font-medium">Daftar KP</span>
                            </a>

                            <a href="{{ route('mahasiswa.instansi.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('mahasiswa.instansi.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.instansi.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M6 11h12M6 15h8" />
                                        <rect x="4" y="5" width="16" height="14" rx="2" ry="2" />
                                    </svg>
                                </span>
                                <span class="font-medium">Pendaftaran Mandiri</span>
                            </a>

                            <a href="{{ route('mahasiswa.bimbingan.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('mahasiswa.bimbingan.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.bimbingan.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <span class="font-medium">Bimbingan</span>
                            </a>

                            <a href="{{ route('mahasiswa.seminar.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('mahasiswa.seminar.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.seminar.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <span class="font-medium">Seminar</span>
                            </a>

                            <a href="{{ route('mahasiswa.laporan.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('mahasiswa.laporan.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.laporan.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5" />
                                    </svg>
                                </span>
                                <span class="font-medium">Laporan</span>
                            </a>

                            <a href="{{ route('mahasiswa.nilai') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('mahasiswa.nilai')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.nilai') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a3 3 0 110 6 3 3 0 010-6zm0 0v-.75m0 8.25v1.5m6.364-6.364l.53.53m-13.788-.53l-.53.53m12.02 4.72l.53.53m-9.303-.53l-.53.53" />
                                    </svg>
                                </span>
                                <span class="font-medium">Nilai</span>
                            </a>

                            <div class="pt-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Akun</div>

                            <a href="{{ route('mahasiswa.profil') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('mahasiswa.profil')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('mahasiswa.profil') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20a6 6 0 1112 0H6z"/></svg>
                                </span>
                                <span class="font-medium">Profil</span>
                            </a>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mahasiswa').submit();"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border text-gray-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center bg-red-50 text-red-600">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </span>
                                <span class="font-medium">Logout</span>
                            </a>
                        </nav>

                        <form id="logout-form-mahasiswa" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

                        <div class="p-6 border-t border-gray-200 bg-gray-50/50 text-center text-xs text-gray-500">
                            <p>@2025 SIKP</p>
                            <p class="text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                        </div>
                    </aside>

                @elseif(auth()->user()->hasRole('dosen') || auth()->user()->hasRole('dosen-biasa'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">
                        <div class="bg-[#1a246a] text-white text-center px-6 py-10">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-2xl bg-white/15 flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo UNIB" class="w-16 h-16 object-contain">
                                </div>
                                <div class="flex flex-col items-center leading-tight gap-1">
                                    <span class="text-2xl font-bold tracking-wide">SIKP</span>
                                    <span class="text-xs uppercase tracking-widest text-white/80">Sistem Informasi Kerja Praktik</span>
                                    <span class="text-[11px] uppercase tracking-widest text-white/70">Universitas Bengkulu</span>
                                </div>
                            </div>
                        </div>

                        <nav class="flex-1 p-6 space-y-2 text-sm text-gray-800">
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Menu</div>

                            <a href="{{ route('dosen.dashboard') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('dosen.dashboard')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('dosen.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5" />
                                    </svg>
                                </span>
                                <span class="font-medium">Dashboard</span>
                            </a>

                            <a href="{{ route('dosen.proposal.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('dosen.proposal.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('dosen.proposal.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5" />
                                    </svg>
                                </span>
                                <span class="font-medium">Validasi Proposal</span>
                            </a>

                            <a href="{{ route('dosen.bimbingan.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('dosen.bimbingan.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('dosen.bimbingan.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <span class="font-medium">Riwayat Bimbingan</span>
                            </a>

                            <a href="{{ route('dosen.nilai.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('dosen.nilai.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('dosen.nilai.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.75a3 3 0 110 6 3 3 0 010-6zm0 0v-.75m0 8.25v1.5m6.364-6.364l.53.53m-13.788-.53l-.53.53m12.02 4.72l.53.53m-9.303-.53l-.53.53"/></svg>
                                </span>
                                <span class="font-medium">Nilai Pembimbing</span>
                            </a>

                            <a href="{{ route('dosen.seminar.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('dosen.seminar.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('dosen.seminar.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </span>
                                <span class="font-medium">Penguji Seminar</span>
                            </a>

                            <div class="pt-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Akun</div>

                            <a href="{{ route('dosen.profil') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('dosen.profil')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('dosen.profil') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20a6 6 0 1112 0H6z"/></svg>
                                </span>
                                <span class="font-medium">Profil</span>
                            </a>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-dosen').submit();"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border text-gray-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center bg-red-50 text-red-600">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </span>
                                <span class="font-medium">Logout</span>
                            </a>
                        </nav>

                        <form id="logout-form-dosen" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

                        <div class="p-6 border-t border-gray-200 bg-gray-50/50 text-center text-xs text-gray-500">
                            <p>@2025 SIKP</p>
                            <p class="text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                        </div>
                    </aside>

                @elseif(auth()->user()->hasRole('pembimbing-lapangan') || auth()->user()->hasRole('pembimbing_lapangan'))
                    <aside class="fixed top-0 left-0 w-80 h-screen overflow-y-auto bg-white shadow-md z-50">
                        <div class="bg-[#1a246a] text-white text-center px-6 py-10">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-2xl bg-white/15 flex items-center justify-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo UNIB" class="w-16 h-16 object-contain">
                                </div>
                                <div class="flex flex-col items-center leading-tight gap-1">
                                    <span class="text-2xl font-bold tracking-wide">SIKP</span>
                                    <span class="text-xs uppercase tracking-widest text-white/80">Sistem Informasi Kerja Praktik</span>
                                    <span class="text-[11px] uppercase tracking-widest text-white/70">Universitas Bengkulu</span>
                                </div>
                            </div>
                        </div>

                        <nav class="flex-1 p-6 space-y-2 text-sm text-gray-800">
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Menu</div>

                            <a href="{{ route('lapangan.dashboard') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('lapangan.dashboard')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5"/></svg>
                                </span>
                                <span class="font-medium">Dashboard</span>
                            </a>

                            <a href="{{ route('lapangan.nilai.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('lapangan.nilai.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.nilai.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <span class="font-medium">Nilai Lapangan</span>
                            </a>

                            <a href="{{ route('lapangan.kuesioner.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('lapangan.kuesioner.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.kuesioner.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                <span class="font-medium">Kuesioner</span>
                            </a>

                            <a href="{{ route('lapangan.kuota.index') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('lapangan.kuota.*')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.kuota.*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                                </span>
                                <span class="font-medium">Usulan Kuota</span>
                            </a>

                            <div class="pt-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Akun</div>
                            <a href="{{ route('lapangan.profil') }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border transition-all duration-200
                               {{ request()->routeIs('lapangan.profil')
                                    ? 'bg-[#1a246a] text-white border-[#1a246a] shadow-md'
                                    : 'text-gray-700 border-gray-100 hover:bg-blue-50 hover:text-[#1a246a]' }}">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('lapangan.profil') ? 'bg-white/20 text-white' : 'bg-blue-50 text-[#1a246a]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20a6 6 0 1112 0H6z"/></svg>
                                </span>
                                <span class="font-medium">Profil</span>
                            </a>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-pembimbing').submit();"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 border text-gray-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                <span class="w-9 h-9 rounded-lg flex items-center justify-center bg-red-50 text-red-600">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </span>
                                <span class="font-medium">Logout</span>
                            </a>
                        </nav>

                        <form id="logout-form-pembimbing" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>

                        <div class="p-6 border-t border-gray-200 bg-gray-50/50 text-center text-xs text-gray-500">
                            <p>@2025 SIKP</p>
                            <p class="text-gray-400 mt-1">Sistem Informasi Kerja Praktek</p>
                        </div>
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
