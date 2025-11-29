<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Penilaian KP</p>
                    <h3 class="text-lg font-semibold text-gray-900">Input Nilai Pembimbing</h3>
                    <p class="text-sm text-gray-500">Isi nilai pembimbing, lapangan, seminar, dan huruf mutu.</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('dosen.nilai.store') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Mahasiswa ID</label>
                                <input name="mahasiswa_id" value="{{ old('mahasiswa_id') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Pembimbing Lapangan (User ID)</label>
                                <input name="pembimbing_lapangan_id" value="{{ old('pembimbing_lapangan_id') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Pembimbing</label>
                                <input name="nilai_pembimbing" type="number" step="0.01" value="{{ old('nilai_pembimbing') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Lapangan</label>
                                <input name="nilai_lapangan" type="number" step="0.01" value="{{ old('nilai_lapangan') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Seminar</label>
                                <input name="nilai_seminar" type="number" step="0.01" value="{{ old('nilai_seminar') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Total Nilai</label>
                                <input name="total_nilai" type="number" step="0.01" value="{{ old('total_nilai') }}"
                                       class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Huruf Pembimbing</label>
                                <select name="nilai_pembimbing_huruf"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}" @selected(old('nilai_pembimbing_huruf')==$huruf)>{{ $huruf }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Huruf Lapangan</label>
                                <select name="nilai_lapangan_huruf"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}" @selected(old('nilai_lapangan_huruf')==$huruf)>{{ $huruf }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Huruf Seminar</label>
                                <select name="nilai_seminar_huruf"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}" @selected(old('nilai_seminar_huruf')==$huruf)>{{ $huruf }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Huruf Total</label>
                                <select name="nilai_mutu"
                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $huruf)
                                        <option value="{{ $huruf }}" @selected(old('nilai_mutu')==$huruf)>{{ $huruf }}</option>
                                    @endforeach
                                </select>
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
