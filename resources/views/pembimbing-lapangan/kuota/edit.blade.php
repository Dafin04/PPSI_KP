<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kuota</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('lapangan.kuota.update', $kuota) }}" class="space-y-4">@csrf @method('PUT')
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Instansi</label>
                            <select name="instansi_id" class="w-full border-gray-300 rounded-md">
                                @foreach($instansis as $ins)
                                    <option value="{{ $ins->id }}" @selected($kuota->instansi_id==$ins->id)>{{ $ins->nama_instansi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm">Tahun</label><input name="tahun" type="number" value="{{ $kuota->tahun }}" class="w-full border-gray-300 rounded-md" /></div>
                            <div><label class="block text-sm">Jumlah</label><input name="jumlah" type="number" value="{{ $kuota->jumlah }}" class="w-full border-gray-300 rounded-md" /></div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('lapangan.kuota.index') }}" class="text-gray-600">Batal</a>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
