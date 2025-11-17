<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Isi Kuesioner Instansi</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('lapangan.kuesioner.store') }}" class="space-y-4">@csrf
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Masukan/Feedback</label>
                            <textarea name="isi_kuesioner" rows="6" class="w-full border-gray-300 rounded-md" required>{{ old('isi_kuesioner') }}</textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('lapangan.kuesioner.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
