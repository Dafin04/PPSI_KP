<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Nilai</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('dosen.nilai.update', $nilai) }}" class="space-y-4">@csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-800">Nilai Pembimbing</label>
                                <input name="nilai_pembimbing" type="number" step="0.01" value="{{ $nilai->nilai_pembimbing }}" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-200" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-800">Nilai Seminar</label>
                                <input name="nilai_seminar" type="number" step="0.01" value="{{ $nilai->nilai_seminar }}" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-200" />
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <a href="{{ route('dosen.nilai.index') }}" class="text-gray-600 px-4 py-2 rounded-md border border-gray-200 hover:bg-gray-50">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
