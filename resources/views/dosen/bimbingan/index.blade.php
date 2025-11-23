<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Bimbingan</h2></x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Jam</th>
                                <th class="px-4 py-2 text-left">Mahasiswa</th>
                                <th class="px-4 py-2 text-left">Topik/Catatan</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Komentar Dosen</th>
                            </tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($bimbingans as $b)
                                <tr>
                                    <td class="px-4 py-2">{{ ($b->tanggal_bimbingan ?? $b->tanggal ?? $b->created_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ $b->waktu_bimbingan ? \Carbon\Carbon::createFromFormat('H:i:s',$b->waktu_bimbingan)->format('H:i') : '-' }}</td>
                                    <td class="px-4 py-2">{{ $b->mahasiswa->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $b->topik_bimbingan ?? $b->catatan ?? '-' }}</td>
                                    <td class="px-4 py-2 space-y-1">
                                        <div class="capitalize">{{ $b->status ?? 'menunggu' }}</div>
                                        @if(($b->status ?? '') === 'disetujui')
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700">Terverifikasi</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-yellow-100 text-yellow-700">Belum selesai</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="text-xs text-gray-600 mb-2">{{ $b->feedback_dosen ?? '-' }}</div>
                                        <form method="POST" action="{{ route('dosen.bimbingan.update', $b) }}" class="flex flex-col gap-2 md:flex-row md:items-center">@csrf @method('PUT')
                                            <select name="status" class="border-gray-300 rounded-md text-sm">
                                                @foreach(['menunggu','disetujui','ditolak'] as $status)
                                                    <option value="{{ $status }}" @selected(($b->status ?? 'menunggu') === $status)>{{ ucfirst($status) }}</option>
                                                @endforeach
                                            </select>
                                            <input name="feedback_dosen" type="text" value="{{ old('feedback_dosen') }}" placeholder="Tulis komentar" class="border-gray-300 rounded-md text-sm flex-1" />
                                            <button class="text-indigo-600 hover:underline text-sm whitespace-nowrap">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="px-4 py-3 text-gray-500" colspan="5">Belum ada bimbingan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
