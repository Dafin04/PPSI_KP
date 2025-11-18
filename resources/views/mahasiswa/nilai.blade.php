<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nilai KP') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm rounded-xl border border-gray-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Pembimbing Lapangan</th>
                                    <th class="px-4 py-2 text-left">Nilai Pembimbing</th>
                                    <th class="px-4 py-2 text-left">Nilai Lapangan</th>
                                    <th class="px-4 py-2 text-left">Nilai Seminar</th>
                                    <th class="px-4 py-2 text-left">Total</th>
                                    <th class="px-4 py-2 text-left">Huruf</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($nilais as $nilai)
                                    <tr>
                                        <td class="px-4 py-2">{{ $nilai->pembimbingLapangan->name ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $nilai->nilai_pembimbing }} ({{ $nilai->nilai_pembimbing_huruf ?? \App\Models\Nilai::konversiHuruf($nilai->nilai_pembimbing) }})</td>
                                        <td class="px-4 py-2">{{ $nilai->nilai_lapangan }} ({{ $nilai->nilai_lapangan_huruf ?? \App\Models\Nilai::konversiHuruf($nilai->nilai_lapangan) }})</td>
                                        <td class="px-4 py-2">{{ $nilai->nilai_seminar }} ({{ $nilai->nilai_seminar_huruf ?? \App\Models\Nilai::konversiHuruf($nilai->nilai_seminar) }})</td>
                                        <td class="px-4 py-2 font-semibold">{{ $nilai->total_nilai }}</td>
                                        <td class="px-4 py-2 font-semibold text-indigo-600">{{ $nilai->nilai_huruf }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Nilai belum tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
