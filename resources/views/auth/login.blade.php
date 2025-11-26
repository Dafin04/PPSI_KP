<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen flex items-stretch bg-gray-100">
        {{-- Panel kiri form --}}
        <div class="w-full lg:w-[38%] xl:w-[35%] bg-gradient-to-b from-white via-white to-gray-50 flex items-center justify-center px-4 py-10 lg:px-12">
            <div class="w-full max-w-[20rem] sm:max-w-sm space-y-6">
                <div class="text-center space-y-2">
                    <div class="mx-auto mb-3 h-16 w-16 rounded-full bg-orange-100 flex items-center justify-center shadow-lg shadow-orange-100/60">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Portal Mahasiswa</h2>
                    <p class="text-sm text-gray-600">Masuk untuk ajukan KP, catat bimbingan, dan pantau progres.</p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white/90 shadow-xl shadow-gray-200/40 p-5 space-y-4">
                    <button type="button" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm hover:border-orange-300 hover:text-orange-600 transition">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#fbc02d" d="M43.6 20.5H42V20H24v8h11.3C33.7 31.6 29.3 34 24 34c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l5.7-5.7C34.6 2.8 29.6 1 24 1 11.8 1 2 10.8 2 23s9.8 22 22 22c11 0 21-8 21-22 0-1.2-.1-2.3-.4-3.5z"/><path fill="#e53935" d="M6.3 14.7l6.6 4.8C14.4 15.1 18.8 12 24 12c3.1 0 5.9 1.1 8.1 2.9l5.7-5.7C34.6 2.8 29.6 1 24 1 15 1 7.2 6.6 6.3 14.7z"/><path fill="#4caf50" d="M24 45c5.2 0 10-1.7 13.8-4.7l-6.4-5c-2.1 1.6-4.9 2.6-7.9 2.6-5.2 0-9.6-3.3-11.2-7.9l-6.6 5.1C7.5 40.9 15.1 45 24 45z"/><path fill="#1565c0" d="M43.6 20.5H42V20H24v8h11.3c-1.4 3.6-5.8 6-11.3 6-2.7 0-5.2-.7-7.3-2l-6.6 5.1C12.7 39.9 18 42 24 42c11 0 21-8 21-22 0-1.2-.1-2.3-.4-3.5z"/></svg>
                        Masuk dengan Akun Kampus
                    </button>

                    <div class="flex items-center gap-3">
                        <span class="h-px flex-1 bg-gray-200"></span>
                        <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">atau email</span>
                        <span class="h-px flex-1 bg-gray-200"></span>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email Kampus</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5A2.25 2.25 0 002.25 6.75m19.5 0v10.5M4.5 4.5h15M4.5 4.5a2.25 2.25 0 00-2.25 2.25m2.25-2.25h15m-15 0a2.25 2.25 0 01-2.25 2.25" /></svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                       class="block w-full rounded-xl border border-gray-200 pl-11 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
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
                                       class="block w-full rounded-xl border border-gray-200 pl-11 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="••••••••" />
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center select-none">
                                <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
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

        {{-- Panel kanan hero --}}
        <div class="hidden lg:flex lg:w-[62%] xl:w-[65%] relative">
            <div class="absolute inset-0"
                 style="background-image: linear-gradient(120deg, rgba(19,39,96,0.88), rgba(16,94,160,0.75), rgba(255,115,29,0.55)), url('{{ asset('images/unibb.jpg') }}'); background-size: cover; background-position: center;">
            </div>
            <div class="relative z-10 flex flex-col justify-between p-12 lg:p-16 text-white">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/90 text-xs font-semibold uppercase tracking-wide">
                        Portal Resmi KP
                    </div>
                    <h1 class="mt-6 text-4xl lg:text-5xl font-black leading-tight">
                        Kelola Kerja Praktek dengan <span class="text-orange-300">tertib & terverifikasi</span>.
                    </h1>
                    <p class="mt-4 text-base text-blue-100 max-w-xl">
                        Sistem terintegrasi untuk pendaftaran KP, bimbingan, seminar, revisi, hingga nilai akhir dalam satu portal.
                    </p>
                </div>
                <div class="flex items-center gap-3 text-sm text-blue-100/90">
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
