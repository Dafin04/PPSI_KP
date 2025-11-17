<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajukan Instansi Baru</h2></x-slot>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <form method="POST" action="{{ route('mahasiswa.instansi.store') }}" class="space-y-5 p-6">@csrf
                    <div>
                        <label class="mb-1 block text-sm text-gray-700">Nama Instansi</label>
                        <input name="nama_instansi" type="text" class="w-full rounded-lg border-gray-300" required />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm text-gray-700">Alamat</label>
                        <textarea name="alamat" rows="3" class="w-full rounded-lg border-gray-300" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label class="mb-1 block text-sm text-gray-700">Kontak</label>
                            <input name="kontak" type="text" class="w-full rounded-lg border-gray-300" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm text-gray-700">Email</label>
                            <input name="email" type="email" class="w-full rounded-lg border-gray-300" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm text-gray-700">Website</label>
                            <input name="website" type="url" class="w-full rounded-lg border-gray-300" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ url()->previous() }}" class="text-gray-600">Batal</a>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">Kirim Usulan</button>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Usulan Anda akan diperiksa oleh Admin. Status: pending → disetujui/ditolak.</p>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

