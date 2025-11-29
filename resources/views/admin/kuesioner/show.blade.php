@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-indigo-600 font-semibold">Kuesioner</p>
                <h2 class="text-2xl font-bold text-gray-900">Detail Kuesioner Pembimbing Lapangan</h2>
                <p class="text-sm text-gray-600">Ringkasan jawaban survei yang dikirim oleh pembimbing lapangan.</p>
            </div>
            <a href="{{ route('admin.kuesioner.instansi') }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between">
                <a href="{{ route('admin.kuesioner.instansi') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Kembali ke daftar
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Identitas Pengisi</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Nama</dt>
                        <dd class="font-semibold text-gray-900">{{ $payload['nama'] ?? ($kuesioner->pembimbingLapangan->name ?? '-') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Jabatan</dt>
                        <dd class="font-semibold text-gray-900">{{ $payload['jabatan'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Instansi</dt>
                        <dd class="font-semibold text-gray-900">{{ $payload['institusi'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Tanggal Kirim</dt>
                        <dd class="font-semibold text-gray-900">{{ optional($kuesioner->created_at)->format('d M Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Jawaban Kuesioner</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-800">
                    @php
                        $map = [
                            'manfaat' => 'Manfaat KP',
                            'kemampuan_kerja' => 'Kemampuan & Hasil Kerja',
                            'kemandirian' => 'Kemandirian',
                            'penguasaan_materi' => 'Penguasaan Materi & Bahasa Inggris',
                            'penguasaan_si' => 'Penguasaan SI & Bisnis Digital',
                            'kerjasama' => 'Kerjasama & Sikap Tim',
                            'etika' => 'Etika & Attitude',
                            'sinergi' => 'Sinergi dengan Program Instansi',
                            'lanjut' => 'Bersedia Lanjut KP/Magang',
                        ];
                    @endphp
                    @foreach($map as $key => $label)
                        <div class="border border-gray-100 rounded-xl p-3 bg-gray-50">
                            <p class="text-gray-500">{{ $label }}</p>
                            <p class="font-semibold mt-1 capitalize">{{ Str::replace('_',' ', $payload[$key] ?? '-') }}</p>
                        </div>
                    @endforeach
                    <div class="border border-gray-100 rounded-xl p-3 bg-gray-50">
                        <p class="text-gray-500">Kuota Tahun Depan</p>
                        <p class="font-semibold mt-1">{{ $payload['jumlah_mahasiswa'] ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Saran</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500">Saran Mata Kuliah</p>
                        <p class="font-semibold text-gray-900">{{ $payload['saran_matkul'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Saran Kemampuan</p>
                        <p class="font-semibold text-gray-900">{{ $payload['saran_kemampuan'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
