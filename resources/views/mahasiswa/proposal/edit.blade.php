<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Proposal</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <form method="POST" action="{{ route('mahasiswa.proposal.update', $proposal) }}" 
                      enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Judul -->
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Judul</label>
                        <input name="judul" type="text" class="w-full border-gray-300 rounded-lg" 
                               value="{{ $proposal->judul }}" required />
                    </div>

                    <!-- Ganti File -->
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Ganti File (opsional)</label>
                        <input name="file_proposal" type="file" class="w-full border-gray-300 rounded-lg" />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                        <input type="text" name="status" 
                               class="w-full border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" 
                               value="{{ ucfirst($proposal->status) }}" readonly>
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('mahasiswa.proposal.index') }}" class="text-gray-600">Batal</a>
                        <button type="submit" 
                                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-indigo-700">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
