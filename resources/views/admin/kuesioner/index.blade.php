@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-indigo-600 font-semibold">Kuesioner</p>
            <h2 class="text-2xl font-bold text-gray-900">Hasil Kuesioner Pembimbing Lapangan</h2>
            <p class="text-sm text-gray-600">Ringkasan jawaban survey instansi mitra.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Kuesioner</h3>
                    <span class="text-sm text-gray-500">Total: {{ $kuesioners->count() }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-t border-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Pembimbing</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Instansi</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Manfaat</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Kemampuan Kerja</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Tgl Kirim</th>
                                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kuesioners as $k)
                                @php
                                    $payload = json_decode($k->isi_kuesioner ?? '{}', true) ?? [];
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">
                                        <div class="font-semibold text-gray-900">{{ $payload['nama'] ?? ($k->pembimbingLapangan->name ?? '-') }}</div>
                                        <div class="text-xs text-gray-500">{{ $payload['jabatan'] ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="text-gray-900">{{ $payload['institusi'] ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-2 capitalize">
                                        {{ $payload['manfaat'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 capitalize">
                                        {{ Str::replace('_',' ', $payload['kemampuan_kerja'] ?? '-') }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-700">{{ optional($k->created_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-2">
                                        <details class="group">
                                            <summary class="cursor-pointer text-indigo-600 hover:underline text-sm">Lihat</summary>
                                            <div class="mt-2 space-y-2 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg p-3">
                                                <div><span class="font-semibold">Kemandirian:</span> {{ Str::replace('_',' ', $payload['kemandirian'] ?? '-') }}</div>
                                                <div><span class="font-semibold">Penguasaan Materi & Inggris:</span> {{ Str::replace('_',' ', $payload['penguasaan_materi'] ?? '-') }}</div>
                                                <div><span class="font-semibold">Penguasaan SI & Bisnis Digital:</span> {{ Str::replace('_',' ', $payload['penguasaan_si'] ?? '-') }}</div>
                                                <div><span class="font-semibold">Kerjasama:</span> {{ Str::replace('_',' ', $payload['kerjasama'] ?? '-') }}</div>
                                                <div><span class="font-semibold">Etika:</span> {{ Str::replace('_',' ', $payload['etika'] ?? '-') }}</div>
                                                <div><span class="font-semibold">Sinergi Program:</span> {{ $payload['sinergi'] ?? '-' }}</div>
                                                <div><span class="font-semibold">Bersedia Tindak Lanjut:</span> {{ ($payload['lanjut'] ?? '') === 'ya' ? 'Ya' : 'Tidak' }}</div>
                                                <div><span class="font-semibold">Kuota tahun depan:</span> {{ $payload['jumlah_mahasiswa'] ?? '-' }}</div>
                                                <div><span class="font-semibold">Saran Mata Kuliah:</span> {{ $payload['saran_matkul'] ?? '-' }}</div>
                                                <div><span class="font-semibold">Saran Kemampuan:</span> {{ $payload['saran_kemampuan'] ?? '-' }}</div>
                                            </div>
                                        </details>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada kuesioner.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
