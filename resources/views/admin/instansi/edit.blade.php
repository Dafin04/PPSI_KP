<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Instansi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.instansi.update', $instansi) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="nama_instansi" :value="__('Nama Instansi')" />
                                <x-text-input id="nama_instansi" name="nama_instansi" type="text" class="mt-1 block w-full" :value="old('nama_instansi', $instansi->nama_instansi)" required />
                                <x-input-error :messages="$errors->get('nama_instansi')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('alamat', $instansi->alamat) }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="kontak" :value="__('Kontak')" />
                                <x-text-input id="kontak" name="kontak" type="text" class="mt-1 block w-full" :value="old('kontak', $instansi->kontak)" />
                                <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                            </div>

                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="status" value="1" {{ old('status', $instansi->status) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">Aktif</span>
                                </label>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.instansi.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

