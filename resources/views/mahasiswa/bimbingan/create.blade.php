<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Bimbingan</h2>
    </x-slot>

@php
    $proposals = $proposals ?? collect();
    $existingDates = $existingDates ?? [];
@endphp

<div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">

            <h3 class="text-lg font-medium text-gray-700 mb-5">Form Bimbingan Lengkap</h3>
            <div class="mb-4 rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                Minimal {{ $minimumBimbingan }} bimbingan harus disetujui sebelum seminar dan unggah laporan akhir. Pastikan tanggal bimbingan tidak sama.
            </div>

            @if(session('error'))
                <div class="mb-4 text-red-600 font-medium">{{ session('error') }}</div>
            @endif

            <form id="formBimbingan" method="POST" action="{{ route('mahasiswa.bimbingan.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Judul Proposal -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Judul Proposal</label>
                    <select name="proposal_id" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Proposal --</option>
                        @foreach($proposals as $proposal)
                            <option value="{{ $proposal->id }}">{{ $proposal->judul }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Bimbingan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Bimbingan</label>
                    <input type="date" name="tanggal_bimbingan" id="tanggal_bimbingan"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>

                <!-- Topik Bimbingan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Topik Bimbingan</label>
                    <input type="text" name="topik_bimbingan"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan topik bimbingan..." required>
                </div>

                <!-- Hasil Bimbingan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Hasil Bimbingan</label>
                    <textarea name="hasil_bimbingan" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Tuliskan hasil dari bimbingan..." required></textarea>
                </div>

                <!-- Catatan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Catatan Pembahasan <span class="text-red-500">*</span></label>
                    <textarea name="catatan" rows="3" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Tuliskan hasil tindak lanjut atau arahan dosen..."></textarea>
                </div>

                <!-- Metode -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Metode Bimbingan</label>
                    <select name="metode"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="offline" selected>Offline</option>
                        <option value="online">Online</option>
                    </select>
                </div>

                <!-- Durasi -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Durasi (menit)</label>
                    <input type="number" name="durasi_menit" value="60" min="1"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- File Lampiran -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lampiran (opsional)</label>
                    <input type="file" name="file_lampiran"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Rating Kualitas -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Rating Kualitas (1–5)</label>
                    <input type="number" name="rating_kualitas" min="1" max="5"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Feedback Mahasiswa -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Feedback Mahasiswa</label>
                    <textarea name="feedback_mahasiswa" rows="2"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan umpan balik mahasiswa (opsional)..."></textarea>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="menunggu" selected>Menunggu</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('mahasiswa.bimbingan.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script validasi tanggal duplikat -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const existingDates = @json($existingDates);
        const form = document.getElementById('formBimbingan');
        const tanggalInput = document.getElementById('tanggal_bimbingan');

        form.addEventListener('submit', function (e) {
            const selectedDate = tanggalInput.value;
            if (existingDates.includes(selectedDate)) {
                e.preventDefault();
                                alert('Tanggal bimbingan ini sudah digunakan. Pilih tanggal lain.'););
            }
        });
    });
</script>
</x-app-layout>
