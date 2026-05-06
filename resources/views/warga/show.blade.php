@extends('layouts.main')
@section('judul', 'Detail Warga')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-700">Detail Warga</h2>

        <a href="{{ route('warga.index') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- DATA -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow space-y-4">

            <div>
                <p class="text-sm text-gray-500">NIK</p>
                <p class="font-semibold text-gray-700">{{ $warga->nik }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Nama</p>
                <p class="font-semibold text-gray-700">{{ $warga->nama }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="font-semibold text-gray-700">{{ $warga->alamat }}</p>
            </div>

        </div>

        <!-- QR -->
        <div class="bg-white p-6 rounded-2xl shadow text-center">

            <h4 class="font-semibold mb-4">QR Code</h4>

            <div class="flex justify-center">
                {!! QrCode::size(200)->generate($warga->nik) !!}
            </div>

            <p class="text-xs text-gray-500 mt-3">
                Scan untuk verifikasi warga
            </p>

        </div>

    </div>

</div>

@endsection
