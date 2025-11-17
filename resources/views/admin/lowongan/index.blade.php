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
        <h1 class="text-2xl font-bold mb-4">Daftar Lowongan KP</h1>

    <a href="{{ route('admin.lowongan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
        Tambah Lowongan Baru
    </a>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Instansi</th>
                <th class="py-2 px-4 border-b">Judul Lowongan</th>
                <th class="py-2 px-4 border-b">Deskripsi</th>
                <th class="py-2 px-4 border-b">Kuota</th>
                <th class="py-2 px-4 border-b">Tanggal Mulai</th>
                <th class="py-2 px-4 border-b">Tanggal Selesai</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowongans as $lowongan)
            <tr>
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
                    <a href="{{ route('admin.lowongan.edit', $lowongan) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('admin.lowongan.destroy', $lowongan) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
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
