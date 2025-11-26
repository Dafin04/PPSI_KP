<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen flex items-stretch bg-gray-100">
        {{-- Panel kiri hero --}}
        <div class="hidden lg:flex lg:w-1/2 relative">
            <div class="absolute inset-0"
                 style="background-image: linear-gradient(120deg, rgba(19,39,96,0.88), rgba(16,94,160,0.75), rgba(255,115,29,0.55)), url('{{ asset('images/unibb.jpg\\') }}'); background-size: cover; background-position: center;">
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

        {{-- Panel kanan form --}}
        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center px-6 py-10 lg:px-16">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-orange-100 flex items-center justify-center shadow">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Portal Mahasiswa</h2>
                    <p class="text-sm text-gray-600 mt-2">Masuk untuk ajukan KP, catat bimbingan, dan pantau progres.</p>
                </div>
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email Kampus</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5A2.25 2.25 0 002.25 6.75m19.5 0v10.5M4.5 4.5h15M4.5 4.5a2.25 2.25 0 00-2.25 2.25m2.25-2.25h15m-15 0a2.25 2.25 0 01-2.25 2.25" /></svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                       class="block w-full rounded-xl border-gray-300 pl-11 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="nama@kampus.ac.id" />
                                </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m9 0h-9m9 0h-9M4.5 18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0022.5 18V6.75a2.25 2.25 0 00-2.25-2.25h-13.5A2.25 2.25 0 004.5 6.75v11.25z" /></svg>
                                </span>
                                <input id="password" name="password" type="password" required autocomplete="current-password"
                                       class="block w-full rounded-xl border-gray-300 pl-11 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="••••••••" />
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
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
    </div>
</x-guest-layout>
