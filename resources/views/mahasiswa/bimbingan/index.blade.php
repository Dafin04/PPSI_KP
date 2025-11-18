<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Bimbingan</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-medium text-gray-700">Data Bimbingan</h3>
                    <a href="{{ route('mahasiswa.bimbingan.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        + Tambah Bimbingan
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 text-green-600 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4 rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                    Progres bimbingan disetujui: <strong>{{ $approvedBimbinganCount }}/{{ $minimumBimbingan }}</strong>. Minimal {{ $minimumBimbingan }} bimbingan disetujui diperlukan sebelum pengajuan seminar dan unggah laporan akhir.
                </div>

                @if($bimbingans->isEmpty())
                    <p class="text-gray-500">Belum ada data bimbingan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border-b text-left">Tanggal</th>
                                    <th class="px-4 py-2 border-b text-left">Topik</th>
                                    <th class="px-4 py-2 border-b text-left">Hasil Bimbingan</th>
                                    <th class="px-4 py-2 border-b text-left">Catatan</th>
                                    <th class="px-4 py-2 border-b text-left">Metode</th>
                                    <th class="px-4 py-2 border-b text-left">Durasi (menit)</th>
                                    <th class="px-4 py-2 border-b text-left">Status</th>
                                    <th class="px-4 py-2 border-b text-left">Lampiran</th>
                                    <th class="px-4 py-2 border-b text-left">Dosen Pembimbing</th>
                                    <th class="px-4 py-2 border-b text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bimbingans as $bimbingan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b">{{ $bimbingan->tanggal_bimbingan ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $bimbingan->topik_bimbingan ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $bimbingan->hasil_bimbingan ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">{{ $bimbingan->catatan ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b capitalize">{{ $bimbingan->metode ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b text-center">{{ $bimbingan->durasi_menit ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b">
                                            <span class="px-2 py-1 text-xs rounded
                                                {{ $bimbingan->status == 'disetujui' ? 'bg-green-100 text-green-700' :
                                                   ($bimbingan->status == 'ditolak' ? 'bg-red-100 text-red-700' :
                                                   ($bimbingan->status == 'selesai' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                                {{ ucfirst($bimbingan->status ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 border-b">
                                            @if($bimbingan->file_lampiran)
                                                <a href="{{ asset('storage/' . $bimbingan->file_lampiran) }}" target="_blank"
                                                    class="text-indigo-600 hover:underline">Lihat</a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border-b">{{ $bimbingan->dosen->nama ?? '-' }}</td>

                                        <!-- Kolom Aksi -->
                                        <td class="px-4 py-2 border-b text-center">
                                            <div class="flex items-center space-x-2">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('mahasiswa.bimbingan.edit', $bimbingan->id) }}" 
                                                    class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                                    Edit
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('mahasiswa.bimbingan.destroy', $bimbingan->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
