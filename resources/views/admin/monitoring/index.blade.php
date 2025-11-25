<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-xs font-semibold text-indigo-700 uppercase tracking-[0.2em]">Dashboard Admin</p>
            <h2 class="font-semibold text-3xl text-gray-900 leading-tight">Monitoring Kerja Praktek</h2>
            <p class="text-sm text-gray-600">Pantau alur KP: pendaftaran, bimbingan, seminar, hingga kelulusan.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Monitoring KP</h3>
                <p class="text-sm text-gray-600">Ringkasan periode dan status terbaru.</p>
            </div>

            @include('admin.monitoring._content')
        </div>
    </div>
</x-app-layout>
