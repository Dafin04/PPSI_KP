<x-guest-layout>
    <div class="min-h-[80vh] grid grid-cols-1 lg:grid-cols-2 gap-6 bg-gray-50 rounded-2xl overflow-hidden">
        <!-- Left brand -->
        <div class="hidden lg:flex bg-gradient-to-br from-sky-500 via-blue-600 to-indigo-600 text-white items-center justify-center p-12">
            <div class="max-w-md">
                <h1 class="text-3xl font-semibold leading-tight">Buat Akun Baru</h1>
                <p class="mt-3 text-blue-100">Daftar untuk memulai pengelolaan Kerja Praktek dengan mudah dan cepat.</p>
                <ul class="mt-6 space-y-2 text-blue-50 text-sm">
                    <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> Antarmuka modern</li>
                    <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> Responsif semua perangkat</li>
                    <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> Didukung Tailwind CSS</li>
                </ul>
            </div>
        </div>

        <!-- Right form -->
        <div class="flex items-center justify-center p-6 lg:p-10">
            <div class="w-full max-w-md">
                <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-6 sm:p-8">
                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-semibold text-gray-900">Daftar</h2>
                        <p class="text-sm text-gray-500 mt-1">Isi data berikut untuk membuat akun</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                                   class="mt-2 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                                   class="mt-2 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                   class="mt-2 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                   class="mt-2 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-lg bg-blue-600 text-white px-4 py-2.5 font-medium hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 transition">
                            Daftar
                        </button>

                        <p class="text-center text-sm text-gray-600">Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium text-blue-700 hover:underline">Masuk</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
