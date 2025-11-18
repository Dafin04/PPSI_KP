<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Unggah Laporan Kerja Praktek
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-200">
                <form method="POST" action="{{ route('mahasiswa.laporan.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf

                    <p class="text-sm text-gray-600 bg-blue-50 border border-blue-200 rounded-md px-3 py-2">
                        Pastikan seluruh revisi seminar telah disetujui dan file laporan telah ditandatangani sebelum diunggah.
                    </p>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">File Laporan (PDF/DOC)</label>
                        <input type="file" name="file_laporan" accept=".pdf,.doc,.docx" class="w-full border-gray-300 rounded-lg" required>
                        <p class="text-xs text-gray-500 mt-1">Ukuran maksimal 2MB.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('file_laporan')" />
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg">
                            <option value="diajukan">Diajukan</option>
                            <option value="draft">Draft</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('mahasiswa.laporan.index') }}" class="text-gray-600">Batal</a>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-indigo-700">Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
