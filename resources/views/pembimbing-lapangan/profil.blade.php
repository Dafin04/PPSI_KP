<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Profil</p>
                    <h3 class="text-lg font-semibold text-gray-900">Profil Pembimbing Lapangan</h3>
                    <p class="text-sm text-gray-500">Perbarui identitas, instansi, dan kontak Anda.</p>
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

                    <form method="POST" action="{{ route('lapangan.profil.update') }}" class="space-y-5">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nama</label>
                                <input type="text" value="{{ $user->name }}" disabled
                                       class="w-full rounded-xl border-gray-200 bg-gray-100 text-gray-600">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">NIK/NIP</label>
                                <input name="nip" type="text" value="{{ old('nip', $pembimbing->nip) }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Jabatan</label>
                                <input name="jabatan" type="text" value="{{ old('jabatan', $pembimbing->jabatan) }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Instansi</label>
                                <select name="instansi_id"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">Pilih Instansi</option>
                                    @foreach($instansis as $instansi)
                                        <option value="{{ $instansi->id }}" @selected(old('instansi_id', $pembimbing->instansi_id) == $instansi->id)>
                                            {{ $instansi->nama_instansi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Kontak</label>
                                <input name="kontak" type="text" value="{{ old('kontak', $pembimbing->kontak ?? '') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('lapangan.dashboard') }}"
                               class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
