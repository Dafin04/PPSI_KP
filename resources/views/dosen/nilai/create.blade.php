<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Penilaian KP</p>
                    <h3 class="text-lg font-semibold text-gray-900">Input Nilai Pembimbing</h3>
                    <p class="text-sm text-gray-500">Isi nilai pembimbing (angka 0-100). Nilai seminar hanya di menu Penguji Seminar.</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('dosen.nilai.store') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Mahasiswa</label>
                                <select name="mahasiswa_id" class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach($mahasiswaList as $m)
                                        <option value="{{ $m->id }}" @selected(old('mahasiswa_id')==$m->id)>{{ $m->user->name ?? $m->nama }} ({{ $m->nim ?? '-' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Pembimbing</label>
                                <input name="nilai_pembimbing" type="number" step="0.01" value="{{ old('nilai_pembimbing') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('dosen.nilai.index') }}"
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
