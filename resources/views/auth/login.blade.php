<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-[90vh] grid grid-cols-1 lg:grid-cols-2 gap-0 bg-white shadow-2xl rounded-2xl overflow-hidden max-w-6xl mx-auto my-10">
        <div class="hidden lg:flex flex-col bg-gradient-to-br from-blue-600 via-blue-700 to-orange-500 text-white items-center justify-center p-12 relative">

            <div class="absolute inset-0 bg-pattern opacity-10"></div>

            <div class="max-w-md text-center relative z-10">
                <div class="flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.09-1.09 2-2.25 2h-12c-1.16 0-2.25-1-2.25-2v-4.25m18 0V9.8c0-1.09-1.09-2-2.25-2h-12c-1.16 0-2.25 1-2.25 2v4.35m18 0h-18" />
                    </svg>
                </div>

                <h1 class="text-4xl font-extrabold tracking-tight">SIKP UNIB</h1>
                <p class="mt-4 text-blue-100 text-lg">
                    Sistem terpusat dan modern untuk mengelola seluruh proses Kerja Praktek (KP) Anda.
                </p>

                <div class="mt-10 grid grid-cols-2 gap-3 text-sm">
                    <div class="bg-white/15 border border-white/20 rounded-lg px-4 py-3 backdrop-blur-sm shadow-md transition-all hover:scale-[1.02]">
                        <span class="font-semibold text-orange-200">Akses Cepat</span> ke data
                    </div>
                    <div class="bg-white/15 border border-white/20 rounded-lg px-4 py-3 backdrop-blur-sm shadow-md transition-all hover:scale-[1.02]">
                        <span class="font-semibold text-orange-200">Keamanan</span> Terjamin
                    </div>
                    <div class="bg-white/15 border border-white/20 rounded-lg px-4 py-3 backdrop-blur-sm shadow-md transition-all hover:scale-[1.02]">
                        <span class="font-semibold text-orange-200">Antarmuka</span> Responsif
                    </div>
                    <div class="bg-white/15 border border-white/20 rounded-lg px-4 py-3 backdrop-blur-sm shadow-md transition-all hover:scale-[1.02]">
                        Didukung <span class="font-semibold text-orange-200">Laravel</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center p-8 lg:p-12 bg-gray-50">
            <div class="w-full max-w-md">
                <div class="bg-white border border-gray-200 shadow-xl rounded-2xl p-6 sm:p-10">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-extrabold text-gray-900">Masuk ke Akun Anda</h2>
                        <p class="text-base text-gray-600 mt-2">Gunakan akun UNIB Anda untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5A2.25 2.25 0 002.25 6.75m19.5 0v10.5M4.5 4.5h15M4.5 4.5a2.25 2.25 0 00-2.25 2.25m2.25-2.25h15m-15 0a2.25 2.25 0 01-2.25 2.25m2.25-2.25h15m-15 0a2.25 2.25 0 00-2.25-2.25m2.25 2.25m0 0a2.25 2.25 0 00-2.25 2.25m2.25-2.25m0 0a2.25 2.25 0 01-2.25 2.25" />
                                    </svg>
                                    Email
                                </span>
                            </label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150" placeholder="contoh@unib.ac.id" />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m9 0h-9m9 0h-9M4.5 18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0022.5 18V6.75a2.25 2.25 0 00-2.25-2.25h-13.5A2.25 2.25 0 004.5 6.75v11.25z" />
                                        </svg>
                                        Password
                                    </span>
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700 hover:underline transition duration-150">Lupa password?</a>
                                @endif
                            </div>
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150" placeholder="••••••••" />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center select-none">
                                <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                            </label>

                            <button type="submit" class="inline-flex justify-center items-center rounded-xl bg-blue-600 text-white px-6 py-3 font-semibold shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 transition w-full mt-4">
                                Masuk
                                <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>


                        <p class="text-center text-sm text-gray-600 pt-2">Belum punya akun?
                            <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-orange-600 hover:underline transition duration-150">Daftar Akun Baru</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
