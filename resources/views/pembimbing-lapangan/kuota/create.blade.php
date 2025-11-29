<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Usulan Kuota</p>
                    <h3 class="text-lg font-semibold text-gray-900">Ajukan Kuota Tahun Depan</h3>
                    <p class="text-sm text-gray-500">Isi instansi dan jumlah kuota mahasiswa KP/magang yang diinginkan.</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('lapangan.kuota.store') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-800">Instansi</label>
                            <select name="instansi_id" class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                @foreach($instansis as $ins)
                                    <option value="{{ $ins->id }}">{{ $ins->nama_instansi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Tahun</label>
                                <input name="tahun" type="number" value="{{ date('Y')+1 }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Jumlah Kuota</label>
                                <input name="jumlah" type="number" value="{{ old('jumlah') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('lapangan.kuota.index') }}"
                               class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</a>
                            <button class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
