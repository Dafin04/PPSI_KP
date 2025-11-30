<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Penilaian Lapangan</p>
                    <h3 class="text-lg font-semibold text-gray-900">Edit Nilai Lapangan</h3>
                    <p class="text-sm text-gray-500">Perbarui nilai mahasiswa di lapangan.</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('lapangan.nilai.update', $nilai) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Mahasiswa</label>
                                <select class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" disabled>
                                    @foreach($mahasiswaList as $m)
                                        <option value="{{ $m->user_id }}" @selected($nilai->mahasiswa_id == $m->user_id)>
                                            {{ $m->user->name ?? $m->nama }} ({{ $m->nim ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Lapangan (0-100)</label>
                                <input name="nilai_lapangan" type="number" step="0.01" value="{{ old('nilai_lapangan', $nilai->nilai_lapangan) }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('lapangan.nilai.index') }}"
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
