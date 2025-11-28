<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[3fr_5fr] bg-gray-100">
        {{-- Kolom kiri: form --}}
        <div class="flex items-center justify-center px-6 py-10 lg:px-14 bg-white">
            <div class="w-full max-w-2xl space-y-8">
                <div class="flex items-center gap-3 justify-start">
                    <div class="h-12 w-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-700">Sistem Informasi Kerja Praktek</p>
                        <h2 class="text-lg font-bold text-gray-900">Portal Masuk</h2>
                    </div>
                </div>

                <div>
                    <h1 class="text-3xl font-semibold text-gray-900">Selamat Datang Kembali!</h1>
                    <p class="text-sm text-gray-600 mt-1">Masuk untuk mengelola pendaftaran KP, bimbingan, seminar, hingga nilai akhir.</p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6 space-y-5">
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email Kampus</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5A2.25 2.25 0 002.25 6.75m19.5 0v10.5M4.5 4.5h15M4.5 4.5a2.25 2.25 0 00-2.25 2.25m2.25-2.25h15m-15 0a2.25 2.25 0 01-2.25 2.25" /></svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                       class="block w-full rounded-xl border border-gray-200 pl-11 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="nama@kampus.ac.id" />
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m9 0h-9m9 0h-9M4.5 18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0022.5 18V6.75a2.25 2.25 0 00-2.25-2.25h-13.5A2.25 2.25 0 004.5 6.75v11.25z" /></svg>
                                </span>
                                <input id="password" name="password" type="password" required autocomplete="current-password"
                                       class="block w-full rounded-xl border border-gray-200 pl-11 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="••••••••" />
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center select-none">
                                <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-orange-600 hover:text-orange-700">Lupa password?</a>
                            @endif
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-orange-500 text-white px-6 py-3 font-semibold shadow-md hover:bg-orange-600 focus:ring-4 focus:ring-orange-100 transition">
                            Masuk Sekarang
                        </button>

                        <p class="text-center text-sm text-gray-600 pt-2">Belum punya akun?
                            <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-orange-600 hover:underline transition">Daftar</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: hero --}}
        <div class="hidden lg:flex relative">
            <div class="absolute inset-0"
                 style="background: linear-gradient(135deg, rgba(0,0,0,0.45), rgba(0,0,0,0.25)), url('{{ asset('images/unibb.png') }}'); background-size: cover; background-position: center left;">
            </div>
            <div class="relative z-10 flex flex-col justify-between p-12 lg:p-16 text-white w-full">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-xs font-semibold uppercase tracking-wide border border-white/20">
                        Portal Resmi Kerja Praktek
                    </div>
                    <h1 class="mt-6 text-4xl lg:text-5xl font-bold leading-tight">
                        Kerja Praktek Lebih <span class="text-orange-300">Teratur</span> & <span class="text-orange-300">Terverifikasi</span>.
                    </h1>
                    <p class="mt-4 text-base text-blue-100 max-w-xl">
                        Satu pintu untuk pendaftaran KP, bimbingan, seminar, revisi, hingga nilai akhir. Didesain untuk mahasiswa, dosen, dan pembimbing lapangan.
                    </p>
                </div>
                <div class="flex items-center gap-4 text-sm text-blue-100/90">
                    <div class="rounded-2xl bg-white/15 px-4 py-3 backdrop-blur-md border border-white/20 shadow">
                        <div class="font-semibold text-white">Keamanan Data</div>
                        <div class="text-blue-100 text-xs">Terenkripsi & Valid</div>
                    </div>
                    <div class="rounded-2xl bg-white/15 px-4 py-3 backdrop-blur-md border border-white/20 shadow">
                        <div class="font-semibold text-white">Akses Cepat</div>
                        <div class="text-blue-100 text-xs">Terintegrasi Akademik</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
