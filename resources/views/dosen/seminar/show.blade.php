<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 space-y-1">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Detail Seminar</p>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $seminar->judul_seminar ?? 'Seminar KP' }}</h3>
                    <p class="text-sm text-gray-500">Mahasiswa: {{ optional($seminar->mahasiswa)->name ?? '-' }} | Jadwal: {{ optional($seminar->tanggal_seminar)->format('d M Y') ?? '-' }} {{ $seminar->waktu_mulai ? '('.$seminar->waktu_mulai.' - '.$seminar->waktu_selesai.')' : '' }}</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-gray-500">Metode/Tempat</p>
                            <p class="font-semibold text-gray-900">{{ $seminar->metode ?? '-' }} | {{ $seminar->tempat ?? $seminar->link_online ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status Revisi</p>
                            <p class="font-semibold text-gray-900">{{ str_replace('_',' ', $seminar->status_revisi ?? '-') }}</p>
                            @if($seminar->catatan_revisi)
                                <p class="text-xs text-gray-600 mt-1">{{ $seminar->catatan_revisi }}</p>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('dosen.seminar.update', $seminar) }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Ketua Penguji</label>
                                <input name="nilai_ketua_penguji" type="number" step="0.01" value="{{ $seminar->nilai_ketua_penguji }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Anggota 1</label>
                                <input name="nilai_anggota_1" type="number" step="0.01" value="{{ $seminar->nilai_anggota_1 }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Anggota 2</label>
                                <input name="nilai_anggota_2" type="number" step="0.01" value="{{ $seminar->nilai_anggota_2 }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Pembimbing</label>
                                <input name="nilai_pembimbing" type="number" step="0.01" value="{{ $seminar->nilai_pembimbing }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Nilai Penguji (Final)</label>
                                <input name="nilai_penguji_angka" type="number" step="0.01" value="{{ $seminar->nilai_penguji_angka }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Huruf (opsional)</label>
                                <select name="nilai_penguji_huruf" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100">
                                    <option value="">--</option>
                                    @foreach(['A','B','C','D'] as $h)
                                        <option value="{{ $h }}" @selected($seminar->nilai_penguji_huruf === $h)>{{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-800">Catatan Penilaian</label>
                                <input name="catatan_penilaian" type="text" value="{{ $seminar->catatan_penilaian }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-100" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <a href="{{ route('dosen.seminar.index') }}" class="px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">Kembali</a>
                            <button class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">Simpan Nilai</button>
                        </div>
                    </form>

                    <div class="border-t pt-4 space-y-3">
                        <h4 class="text-sm font-semibold text-gray-800">Revisi Seminar</h4>
                        <form method="POST" action="{{ route('dosen.seminar.revisi', $seminar) }}" class="flex flex-col md:flex-row gap-3 items-start">
                            @csrf
                            <input name="catatan_revisi" type="text" class="w-full rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-100" placeholder="Catatan revisi" required>
                            <button class="px-4 py-2 rounded-lg border border-amber-200 text-amber-700 bg-amber-50 text-sm font-semibold hover:bg-amber-100">Minta Revisi</button>
                        </form>
                        @if($seminar->status_revisi === 'menunggu_persetujuan')
                            <form method="POST" action="{{ route('dosen.seminar.revisi.approve', $seminar) }}" class="flex justify-start">
                                @csrf
                                <button class="px-4 py-2 rounded-lg border border-emerald-200 text-emerald-700 bg-emerald-50 text-sm font-semibold hover:bg-emerald-100">Setujui Revisi</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
