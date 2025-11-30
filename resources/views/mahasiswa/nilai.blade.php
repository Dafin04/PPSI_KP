<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Hasil KP</p>
                    <h3 class="text-lg font-semibold text-gray-900">Nilai Kerja Praktek</h3>
                    <p class="text-sm text-gray-500">Rekap nilai pembimbing, lapangan, seminar, dan total.</p>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Dosen Pembimbing</th>
                                    <th class="px-5 py-3">Nilai Pembimbing</th>
                                    <th class="px-5 py-3">Nilai Lapangan</th>
                                    <th class="px-5 py-3">Nilai Seminar</th>
                                    <th class="px-5 py-3">Total</th>
                                    <th class="px-5 py-3">Huruf</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($nilais as $nilai)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 text-gray-900 font-semibold">
                                            {{ $nilai->pembimbing_nama ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            {{ $nilai->nilai_pembimbing }} ({{ $nilai->nilai_pembimbing_huruf ?? \App\Models\Nilai::konversiHuruf($nilai->nilai_pembimbing) }})
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            {{ $nilai->nilai_lapangan }} ({{ $nilai->nilai_lapangan_huruf ?? \App\Models\Nilai::konversiHuruf($nilai->nilai_lapangan) }})
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            {{ $nilai->nilai_seminar }} ({{ $nilai->nilai_seminar_huruf ?? \App\Models\Nilai::konversiHuruf($nilai->nilai_seminar) }})
                                        </td>
                                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $nilai->total_nilai }}</td>
                                        <td class="px-5 py-4 text-indigo-600 font-semibold">{{ $nilai->nilai_huruf }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-6 text-center text-gray-500">Nilai belum tersedia.</td>
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
