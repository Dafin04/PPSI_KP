<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Periode KP</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="p-6 space-y-6">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.periode.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun Ajaran <span class="text-red-500">*</span></label>
                                <input name="tahun_ajaran" type="text" value="{{ old('tahun_ajaran') }}" required class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Semester <span class="text-red-500">*</span></label>
                                <select name="semester" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="Ganjil" @selected(old('semester')==='Ganjil')>Ganjil</option>
                                    <option value="Genap" @selected(old('semester')==='Genap')>Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tgl Mulai Pendaftaran</label>
                                <input name="tgl_mulai_pendaftaran" type="date" value="{{ old('tgl_mulai_pendaftaran') }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tgl Selesai Pendaftaran</label>
                                <input name="tgl_selesai_pendaftaran" type="date" value="{{ old('tgl_selesai_pendaftaran') }}" class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                @foreach(['Aktif','Ditutup','Arsip'] as $status)
                                    <option value="{{ $status }}" @selected(old('status','Aktif')===$status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.periode.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">Batal</a>
                            <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
