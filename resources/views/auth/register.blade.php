<x-guest-layout>
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
                        <h2 class="text-lg font-bold text-gray-900">Buat Akun</h2>
                    </div>
                </div>

                <div>
                    <h1 class="text-3xl font-semibold text-gray-900">Mulai Kelola KP</h1>
                    <p class="text-sm text-gray-600 mt-1">Daftarkan akun untuk pendaftaran KP, bimbingan, seminar, hingga nilai akhir.</p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6 space-y-5">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div class="space-y-1">
                            <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                                   class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email Kampus</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                                   class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                   class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi Kata Sandi</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                   class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-orange-500 text-white px-6 py-3 font-semibold shadow-md hover:bg-orange-600 focus:ring-4 focus:ring-orange-100 transition">
                            Daftar Sekarang
                        </button>

                        <p class="text-center text-sm text-gray-600 pt-2">Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:text-orange-600 hover:underline transition">Masuk</a>
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
                        Bangun Profil KP dan Mulai Kolaborasi.
                    </h1>
                    <p class="mt-4 text-base text-blue-100 max-w-xl">
                        Satu portal untuk pendaftaran, bimbingan, seminar, revisi, hingga nilai akhir. Mudahkan koordinasi mahasiswa, dosen, dan pembimbing lapangan.
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
