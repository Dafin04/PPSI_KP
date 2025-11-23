<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil Dosen</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-200">
                <div class="p-6 space-y-6">
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

                    <form method="POST" action="{{ route('dosen.profil.update') }}" class="space-y-4">
                        @csrf @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" value="{{ $user->name }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIP/NIDN <span class="text-red-500">*</span></label>
                                <input name="nip" type="text" value="{{ old('nip', $dosen->nip) }}" required class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                                <input name="jabatan" type="text" value="{{ old('jabatan', $dosen->jabatan) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                                <input name="prodi" type="text" value="{{ old('prodi', $dosen->prodi) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Keahlian</label>
                                <input name="keahlian" type="text" value="{{ old('keahlian', $dosen->keahlian) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <input id="status_aktif" name="status_aktif" type="checkbox" value="1" {{ old('status_aktif', $dosen->status_aktif) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="status_aktif" class="text-sm text-gray-700">Aktif</label>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('dosen.dashboard') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">Batal</a>
                            <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
