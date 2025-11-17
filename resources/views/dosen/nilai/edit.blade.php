<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Nilai</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('dosen.nilai.update', $nilai) }}" class="space-y-4">@csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm">Nilai Pembimbing</label><input name="nilai_pembimbing" type="number" step="0.01" value="{{ $nilai->nilai_pembimbing }}" class="w-full border-gray-300 rounded-md" /></div>
                            <div><label class="block text-sm">Nilai Lapangan</label><input name="nilai_lapangan" type="number" step="0.01" value="{{ $nilai->nilai_lapangan }}" class="w-full border-gray-300 rounded-md" /></div>
                            <div><label class="block text-sm">Nilai Seminar</label><input name="nilai_seminar" type="number" step="0.01" value="{{ $nilai->nilai_seminar }}" class="w-full border-gray-300 rounded-md" /></div>
                            <div><label class="block text-sm">Total Nilai</label><input name="total_nilai" type="number" step="0.01" value="{{ $nilai->total_nilai }}" class="w-full border-gray-300 rounded-md" /></div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('dosen.nilai.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

