<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Pengawasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('pembimbing-lapangan.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            ← Kembali ke Dashboard
                        </a>
                    </div>

                    <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-6">
                        <div class="flex">
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    <strong>Fitur Jadwal Pengawasan</strong><br>
                                    Halaman ini akan menampilkan jadwal pengawasan lapangan. Fitur ini sedang dalam pengembangan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center py-12">
                        <h3 class="text-lg font-semibold mb-4">Jadwal Pengawasan</h3>
                        <p class="text-gray-600">Jadwal pengawasan akan ditampilkan di sini setelah sistem selesai dikembangkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
