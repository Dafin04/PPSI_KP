<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Nilai Lapangan</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('lapangan.nilai.update', $nilai) }}" class="space-y-4">@csrf @method('PUT')
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Nilai Lapangan</label>
                            <input name="nilai_lapangan" type="number" step="0.01" value="{{ $nilai->nilai_lapangan }}" class="w-full border-gray-300 rounded-md" />
                        </div>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('lapangan.nilai.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

