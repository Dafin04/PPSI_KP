<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Profil</p>
                    <h3 class="text-lg font-semibold text-gray-900">Profil Mahasiswa</h3>
                    <p class="text-sm text-gray-500">Lengkapi data dasar dan perbarui kata sandi akun Anda.</p>
                </div>

                <div class="p-6 space-y-6 text-gray-900">
                    @if(session('success'))
                        <div class="rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.profil.update') }}" class="space-y-5">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">NIM <span class="text-red-500">*</span></label>
                                <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Angkatan</label>
                                <input type="number" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Program Studi</label>
                                <input type="text" name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('mahasiswa.dashboard') }}"
                               class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700">
                                Simpan Profil
                            </button>
                        </div>
                    </form>

                    <div class="border-t border-gray-100 pt-4 mt-4 space-y-3">
                        <h4 class="text-sm font-semibold text-gray-900">Ganti Kata Sandi</h4>
                        <p class="text-sm text-gray-500">Masukkan kata sandi lama dan kata sandi baru Anda.</p>
                        <form method="POST" action="{{ route('mahasiswa.profil.password') }}" class="space-y-4">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-800">Kata Sandi Lama</label>
                                    <input type="password" name="current_password" required
                                           class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    @error('current_password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-800">Kata Sandi Baru</label>
                                    <input type="password" name="password" required
                                           class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-800">Ulangi Kata Sandi Baru</label>
                                    <input type="password" name="password_confirmation" required
                                           class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 rounded-xl bg-orange-500 text-white text-sm font-semibold shadow hover:bg-orange-600">
                                    Update Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
