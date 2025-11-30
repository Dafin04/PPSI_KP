<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Nilai KP</p>
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Nilai Pembimbing</h3>
                        <p class="text-sm text-gray-500">Hanya nilai pembimbing (angka). Nilai seminar diisi melalui menu Penguji Seminar.</p>
                    </div>
                    <a href="{{ route('dosen.nilai.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700">Input Nilai</a>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Mahasiswa</th>
                                    <th class="px-5 py-3 text-center">Nilai Pembimbing</th>
                                    <th class="px-5 py-3 text-center">Dibuat</th>
                                    <th class="px-5 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($nilais as $n)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="text-gray-900 font-semibold">{{ $n->mahasiswa->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $n->mahasiswa->nim ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-center text-gray-900 font-semibold">{{ $n->nilai_pembimbing ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center text-gray-600">{{ $n->created_at?->format('d M Y') ?? '-' }}</td>
                                        <td class="px-5 py-4 text-right space-x-2">
                                            <a href="{{ route('dosen.nilai.edit', $n) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-semibold">Edit</a>
                                            <form action="{{ route('dosen.nilai.destroy', $n) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button class="inline-flex items-center px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-xs font-semibold" onclick="return confirm('Hapus nilai?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-6 text-center text-gray-500">Belum ada nilai.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
