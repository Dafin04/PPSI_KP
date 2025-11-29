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
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Data Kuesioner</h3>
                        <p class="text-sm text-gray-500">Daftar kuesioner yang sudah diisi</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-semibold">
                        Total: {{ $kuesioners->count() }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                <th class="px-6 py-3">Pembimbing</th>
                                <th class="px-6 py-3">Instansi</th>
                                <th class="px-6 py-3">Manfaat</th>
                                <th class="px-6 py-3">Kemampuan</th>
                                <th class="px-6 py-3">Tgl Kirim</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kuesioners as $k)
                                @php
                                    $payload = json_decode($k->isi_kuesioner ?? '{}', true) ?? [];
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $payload['nama'] ?? ($k->pembimbingLapangan->name ?? '-') }}</div>
                                        <div class="text-xs text-gray-500">{{ $payload['jabatan'] ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $payload['institusi'] ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 capitalize">
                                            {{ $payload['manfaat'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 capitalize">
                                        {{ Str::replace('_',' ', $payload['kemampuan_kerja'] ?? '-') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ optional($k->created_at)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.kuesioner.show.admin', $k) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-6 text-center text-gray-500">Belum ada kuesioner.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
