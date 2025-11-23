<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900 space-y-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.profil.update') }}" class="space-y-4">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIM <span class="text-red-500">*</span></label>
                                <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Angkatan</label>
                                <input type="number" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                                <input type="text" name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">IPK</label>
                                <input type="number" step="0.01" name="ipk" value="{{ old('ipk', $mahasiswa->ipk) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prestasi Akademik</label>
                            <textarea name="prestasi_akademik" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('prestasi_akademik', $mahasiswa->prestasi_akademik) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prestasi Non-Akademik</label>
                            <textarea name="prestasi_non_akademik" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('prestasi_non_akademik', $mahasiswa->prestasi_non_akademik) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pengalaman Bidang SI</label>
                            <textarea name="pengalaman_si" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('pengalaman_si', $mahasiswa->pengalaman_si) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">Batal</a>
                            <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
