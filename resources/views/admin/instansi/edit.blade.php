<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Instansi') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Data Instansi</h3>
                    <p class="text-sm text-gray-500">Formulir perubahan instansi</p>
                </div>
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.instansi.update', $instansi) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="nama_instansi" :value="__('Nama Instansi')" />
                                <x-text-input id="nama_instansi" name="nama_instansi" type="text" class="mt-1 block w-full rounded-xl border-gray-200" :value="old('nama_instansi', $instansi->nama_instansi)" required />
                                <x-input-error :messages="$errors->get('nama_instansi')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>{{ old('alamat', $instansi->alamat) }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="kontak" :value="__('Kontak')" />
                                <x-text-input id="kontak" name="kontak" type="text" class="mt-1 block w-full rounded-xl border-gray-200" :value="old('kontak', $instansi->kontak)" />
                                <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                            </div>

                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="status" value="1" {{ old('status', $instansi->status) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">Aktif</span>
                                </label>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pembimbing Lapangan (opsional)</label>
                                <div class="max-h-52 overflow-y-auto border rounded-xl divide-y divide-gray-100">
                                    @foreach($pembimbingLapangans as $pl)
                                        <label class="flex items-center gap-3 px-3 py-2 text-sm">
                                            <input type="checkbox" name="pembimbing_lapangan_ids[]" value="{{ $pl->id }}"
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                @checked(collect(old('pembimbing_lapangan_ids', $selectedPembimbingIds ?? []))->contains($pl->id))>
                                            <span>
                                                <span class="font-medium text-gray-800">{{ $pl->user->name ?? 'PL #'.$pl->id }}</span>
                                                <span class="text-gray-500 text-xs"> {{ $pl->instansi ? ' (Instansi: '.$pl->instansi.')' : '' }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Centang PL yang akan terikat pada instansi ini.</p>
                                <x-input-error :messages="$errors->get('pembimbing_lapangan_ids')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-2 gap-3">
                            <a href="{{ route('admin.instansi.index') }}" class="text-gray-600 hover:text-gray-900 font-semibold">Batal</a>
                            <button type="submit" class="inline-flex items-center px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-100">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
