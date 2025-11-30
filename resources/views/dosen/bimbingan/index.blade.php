<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Bimbingan KP</p>
                    <h3 class="text-lg font-semibold text-gray-900">Riwayat Bimbingan</h3>
                    <p class="text-sm text-gray-500">Verifikasi atau beri umpan balik bimbingan mahasiswa.</p>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Tanggal</th>
                                    <th class="px-5 py-3">Mahasiswa</th>
                                    <th class="px-5 py-3">Topik / Catatan</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Komentar & Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($bimbingans as $b)
                                    @php
                                        $status = $b->status ?? 'menunggu';
                                        $statusColor = match($status) {
                                            'disetujui' => 'bg-green-100 text-green-700',
                                            'ditolak' => 'bg-red-100 text-red-700',
                                            default => 'bg-yellow-100 text-yellow-700'
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-gray-900 font-semibold">{{ ($b->tanggal_bimbingan ?? $b->tanggal ?? $b->created_at)->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $b->waktu_bimbingan ? \Carbon\Carbon::createFromFormat('H:i:s', $b->waktu_bimbingan)->format('H:i') : '-' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-gray-900 font-semibold">{{ $b->mahasiswa->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $b->mahasiswa->nim ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-gray-900 font-semibold">{{ $b->topik_bimbingan ?? '-' }}</div>
                                            <div class="text-xs text-gray-600">{{ $b->catatan ?? $b->hasil_bimbingan ?? '-' }}</div>
                                            <div class="text-xs text-gray-500 mt-1">Metode: {{ $b->metode ?? '-' }} • Durasi: {{ $b->durasi_menit ?? '-' }} menit</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-xs text-gray-600 mb-2">Komentar saat ini: {{ $b->feedback_dosen ?? '-' }}</div>
                                            <form method="POST" action="{{ route('dosen.bimbingan.update', $b) }}" class="flex flex-col gap-2 md:flex-row md:items-center">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-100">
                                                    @foreach(['menunggu','disetujui','ditolak'] as $s)
                                                        <option value="{{ $s }}" @selected(($b->status ?? 'menunggu') === $s)>{{ ucfirst($s) }}</option>
                                                    @endforeach
                                                </select>
                                                <input name="feedback_dosen" type="text" value="{{ old('feedback_dosen') }}" placeholder="Tulis komentar"
                                                       class="flex-1 rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-100" />
                                                <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-blue-200 text-blue-700 bg-blue-50 px-3 py-1.5 text-xs font-semibold hover:bg-blue-100">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    Simpan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">Belum ada bimbingan.</td>
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
