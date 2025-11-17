@extends('layouts.app')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Lowongan KP') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h1 class="text-2xl font-bold mb-4">Tambah Lowongan KP</h1>

    <form action="{{ route('admin.lowongan.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="instansi_id" class="block text-gray-700 font-bold mb-2">Instansi</label>
            <select name="instansi_id" id="instansi_id" class="w-full px-3 py-2 border border-gray-300 rounded" required>
                <option value="">Pilih Instansi</option>
                @foreach($instansis as $instansi)
                    <option value="{{ $instansi->id }}">{{ $instansi->nama_instansi }}</option>
                @endforeach
            </select>
            @error('instansi_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="judul_lowongan" class="block text-gray-700 font-bold mb-2">Judul Lowongan</label>
            <input type="text" name="judul_lowongan" id="judul_lowongan" class="w-full px-3 py-2 border border-gray-300 rounded" value="{{ old('judul_lowongan') }}" required>
            @error('judul_lowongan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="w-full px-3 py-2 border border-gray-300 rounded" rows="4" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="kebutuhan_keahlian" class="block text-gray-700 font-bold mb-2">Kebutuhan Keahlian</label>
            <textarea name="kebutuhan_keahlian" id="kebutuhan_keahlian" class="w-full px-3 py-2 border border-gray-300 rounded" rows="3">{{ old('kebutuhan_keahlian') }}</textarea>
            @error('kebutuhan_keahlian')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="jumlah_kuota" class="block text-gray-700 font-bold mb-2">Jumlah Kuota</label>
            <input type="number" name="jumlah_kuota" id="jumlah_kuota" class="w-full px-3 py-2 border border-gray-300 rounded" value="{{ old('jumlah_kuota', 1) }}" min="1" required>
            @error('jumlah_kuota')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal_mulai" class="block text-gray-700 font-bold mb-2">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full px-3 py-2 border border-gray-300 rounded" value="{{ old('tanggal_mulai') }}" required>
            @error('tanggal_mulai')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal_selesai" class="block text-gray-700 font-bold mb-2">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full px-3 py-2 border border-gray-300 rounded" value="{{ old('tanggal_selesai') }}" required>
            @error('tanggal_selesai')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">
                <input type="checkbox" name="status_aktif" value="1" {{ old('status_aktif', true) ? 'checked' : '' }}>
                Status Aktif
            </label>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.lowongan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Simpan
            </button>
        </div>
    </form>
    </div>
    </div>
    </div>
    </div>
</x-app-layout>
