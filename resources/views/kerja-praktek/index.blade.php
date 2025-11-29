<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 lg:px-6">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between border-b border-gray-100 px-6 py-5">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Daftar KP</h1>
                    <p class="text-sm text-gray-500">Kelola pengajuan KP sesuai peran Anda.</p>
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <form action="{{ route('kerja-praktek.index') }}" method="GET" class="relative w-full md:w-72">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.65 5.65a7.5 7.5 0 0011 11z" />
                            </svg>
                        </span>
                        <input type="text" name="q" value="{{ $search }}"
                               class="w-full rounded-xl border-gray-200 pl-10 pr-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="Cari judul atau instansi">
                    </form>
                    @if(auth()->user()->hasRole('mahasiswa'))
                        <a href="{{ route('kerja-praktek.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#1a246a] text-white text-sm font-semibold shadow hover:bg-[#11194d]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                            </svg>
                            Daftar KP Baru
                        </a>
                    @endif
                </div>
            </div>

            <div class="px-6 py-5 space-y-4">
                @if(session('success'))
                    <div class="rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-hidden border border-gray-100 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                <th class="px-4 py-3">Judul KP</th>
                                @if(auth()->user()->hasRole('admin'))
                                    <th class="px-4 py-3">Mahasiswa</th>
                                @endif
                                <th class="px-4 py-3">Instansi</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Mulai</th>
                                <th class="px-4 py-3">Pembimbing</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kerjaPrakteks as $kp)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900">{{ Str::limit($kp->judul_kp, 60) }}</div>
                                        <p class="text-xs text-gray-500">Periode: {{ optional($kp->periode)->nama ?? '-' }}</p>
                                    </td>
                                    @if(auth()->user()->hasRole('admin'))
                                        <td class="px-4 py-3">
                                            <div class="text-gray-900 font-semibold">{{ $kp->mahasiswa->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $kp->mahasiswa->nim ?? '' }}</div>
                                        </td>
                                    @endif
                                    <td class="px-4 py-3 text-gray-900">{{ $kp->instansi->nama_instansi ?? '-' }}</td>
                                    <td class="px-4 py-3">{!! $kp->getStatusBadgeAttribute() !!}</td>
                                    <td class="px-4 py-3 text-gray-900">{{ optional($kp->tanggal_mulai)->format('d M Y') ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-900">{{ $kp->dosenPembimbing->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('kerja-praktek.show', $kp) }}"
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100"
                                               title="Lihat">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                          d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                                                    <circle cx="12" cy="12" r="2.25" />
                                                </svg>
                                            </a>
                                            @if($kp->isEditable() && $kp->mahasiswa_id === auth()->id())
                                                <a href="{{ route('kerja-praktek.edit', $kp) }}"
                                                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-amber-200 text-amber-600 hover:bg-amber-50"
                                                   title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                              d="M16.862 4.487l1.651 1.651m-1.651-1.651l-9.193 9.193a2.25 2.25 0 00-.561.96l-.53 2.12 2.12-.53a2.25 2.25 0 00.96-.561l9.193-9.193m-1.651-1.651l-1.651-1.651" />
                                                    </svg>
                                                </a>
                                                @if($kp->status === 'draft')
                                                    <form action="{{ route('kerja-praktek.submit', $kp) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-green-200 text-green-600 hover:bg-green-50"
                                                            onclick="return confirm('Ajukan pendaftaran ini?')"
                                                            title="Ajukan">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                                      d="M5 12h14m0 0l-4-4m4 4l-4 4" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->hasRole('admin') ? 7 : 6 }}" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada pendaftaran kerja praktek.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($kerjaPrakteks->hasPages())
                    <div class="pt-4">
                        {{ $kerjaPrakteks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
