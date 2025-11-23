<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil Pembimbing Lapangan</h2>
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

                    <form method="POST" action="{{ route('lapangan.profil.update') }}" class="space-y-4">
                        @csrf @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" value="{{ $user->name }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIK/NIP</label>
                                <input name="nip" type="text" value="{{ old('nip', $pembimbing->nip) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                                <input name="jabatan" type="text" value="{{ old('jabatan', $pembimbing->jabatan) }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Instansi</label>
                            <select name="instansi_id" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Pilih Instansi</option>
                                @foreach($instansis as $instansi)
                                    <option value="{{ $instansi->id }}" @selected(old('instansi_id', $pembimbing->instansi_id) == $instansi->id)>
                                        {{ $instansi->nama_instansi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kontak</label>
                            <input name="kontak" type="text" value="{{ old('kontak', $pembimbing->kontak ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('lapangan.dashboard') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">Batal</a>
                            <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
