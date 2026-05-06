@extends('layouts.main')
@section('judul', 'Tambah Warga')

@section('content')

<div class="max-w-xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-700">Tambah Warga</h2>

        <a href="{{ route('warga.index') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- FORM -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <form action="{{ route('warga.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- NIK -->
            <div>
                <label class="text-sm text-gray-600">NIK</label>
                <input type="text" name="nik"
                       value="{{ old('nik') }}"
                       placeholder="Masukkan NIK"
                       class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-blue-200" autofocus>

                @error('nik')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <label class="text-sm text-gray-600">Nama</label>
                <input type="text" name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Masukkan nama"
                       class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-blue-200">

                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div>
                <label class="text-sm text-gray-600">Alamat</label>
                <textarea name="alamat"
                          placeholder="Masukkan alamat"
                          class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-blue-200">{{ old('alamat') }}</textarea>

                @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('warga.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Batal
                </a>

                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
