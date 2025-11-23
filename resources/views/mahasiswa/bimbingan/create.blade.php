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

            <h3 class="text-lg font-medium text-gray-700 mb-5">Form Bimbingan</h3>
            <div class="mb-4 rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                Minimal {{ $minimumBimbingan }} bimbingan harus disetujui sebelum seminar dan unggah laporan akhir.
                Tidak boleh tanggal mundur dan maksimal 1 bimbingan per hari.
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

                <!-- Tanggal & Waktu Bimbingan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Tanggal & Waktu Bimbingan</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <input type="date" name="tanggal_bimbingan" id="tanggal_bimbingan"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        <input type="time" name="waktu_bimbingan" id="waktu_bimbingan"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Maksimal 1 bimbingan per hari, tidak boleh tanggal mundur.</p>
                </div>

                <!-- Topik Bimbingan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Topik Bimbingan</label>
                    <input type="text" name="topik_bimbingan"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan topik bimbingan..." required>
                </div>

                <!-- Catatan / Pertanyaan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Catatan / Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea name="catatan" rows="3" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Tuliskan pertanyaan atau bahasan yang ingin dibimbing..."></textarea>
                </div>

                <!-- Lampiran -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lampiran (opsional)</label>
                    <input type="file" name="file_lampiran"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
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
            if (!selectedDate) return;

            const today = new Date().toISOString().split('T')[0];
            if (selectedDate < today) {
                e.preventDefault();
                alert('Tanggal bimbingan tidak boleh mundur.');
                return;
            }

            if (existingDates.includes(selectedDate)) {
                e.preventDefault();
                alert('Tanggal bimbingan ini sudah digunakan. Maksimal 1 bimbingan per hari.');
            }
        });
    });
</script>
</x-app-layout>
