<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Validasi Proposal</p>
                        <h3 class="text-lg font-semibold text-gray-900">Judul / Proposal KP</h3>
                        <p class="text-sm text-gray-500">Setujui atau beri catatan revisi pada proposal mahasiswa bimbingan Anda.</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    <th class="px-5 py-3">Mahasiswa</th>
                                    <th class="px-5 py-3">Judul</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($proposals as $p)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="text-gray-900 font-semibold">{{ optional(optional($p->mahasiswa)->user)->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $p->mahasiswa->nim ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-gray-900">{{ $p->judul }}</td>
                                        <td class="px-5 py-4 capitalize text-gray-700">{{ $p->status }}</td>
                                        <td class="px-5 py-4">
                                            @php $hasCatatan = Schema::hasColumn('proposals','catatan_validasi'); @endphp
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-center gap-3">
                                                <form method="POST" action="{{ route('dosen.proposal.approve', $p) }}" class="flex flex-col sm:flex-row sm:items-center gap-2">
                                                    @csrf
                                                    @if($hasCatatan)
                                                        <input type="text" name="catatan_validasi" placeholder="Catatan (opsional)"
                                                               class="w-44 rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-100">
                                                    @endif
                                                    <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-green-200 text-green-700 bg-green-50 px-3 py-1.5 text-xs font-semibold hover:bg-green-100">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                        Setujui
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('dosen.proposal.reject', $p) }}" class="flex flex-col sm:flex-row sm:items-center gap-2">
                                                    @csrf
                                                    @if($hasCatatan)
                                                        <input type="text" name="catatan_validasi" placeholder="Alasan (opsional)"
                                                               class="w-44 rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-100">
                                                    @endif
                                                    <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-200 text-red-700 bg-red-50 px-3 py-1.5 text-xs font-semibold hover:bg-red-100">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">Belum ada proposal.</td>
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
