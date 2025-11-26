@extends('layouts.app')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Lowongan KP') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Daftar Lowongan KP</h1>
            <a href="{{ route('admin.lowongan.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                Tambah Lowongan Baru
            </a>
        </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b text-left">Instansi</th>
                <th class="py-2 px-4 border-b text-left">Judul Lowongan</th>
                <th class="py-2 px-4 border-b text-left">Deskripsi</th>
                <th class="py-2 px-4 border-b text-left">Kuota</th>
                <th class="py-2 px-4 border-b text-left">Tanggal Mulai</th>
                <th class="py-2 px-4 border-b text-left">Tanggal Selesai</th>
                <th class="py-2 px-4 border-b text-left">Status</th>
                <th class="py-2 px-4 border-b text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($lowongans as $lowongan)
            <tr class="hover:bg-gray-50">
                <td class="py-2 px-4 border-b">{{ $lowongan->instansi->nama_instansi }}</td>
                <td class="py-2 px-4 border-b">{{ $lowongan->judul_lowongan }}</td>
                <td class="py-2 px-4 border-b">{{ Str::limit($lowongan->deskripsi, 50) }}</td>
                <td class="py-2 px-4 border-b">{{ $lowongan->jumlah_kuota }}</td>
                <td class="py-2 px-4 border-b">{{ $lowongan->tanggal_mulai->format('d-m-Y') }}</td>
                <td class="py-2 px-4 border-b">{{ $lowongan->tanggal_selesai->format('d-m-Y') }}</td>
                <td class="py-2 px-4 border-b">
                    @if($lowongan->status_aktif)
                        <span class="text-green-600 font-semibold">Aktif</span>
                    @else
                        <span class="text-red-600 font-semibold">Tidak Aktif</span>
                    @endif
                </td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.lowongan.edit', $lowongan) }}" class="inline-flex items-center px-3 py-1 rounded-md border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-medium mr-2">Edit</a>
                    <form action="{{ route('admin.lowongan.destroy', $lowongan) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md border border-red-200 text-red-700 hover:bg-red-50 text-xs font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $lowongans->links() }}
    </div>
    </div>
    </div>
    </div>
    </div>
</x-app-layout>
