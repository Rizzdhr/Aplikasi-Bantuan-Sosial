<x-app-layout>
    <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Warga</h2>
            <p class="text-sm text-gray-500">Informasi lengkap warga dan kode QR verifikasi.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Detail Warga</h3>
                            <p class="text-sm text-gray-500">Lihat informasi detail beserta QR code warga.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('warga.index') }}" class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">← Kembali</a>
                            <a href="{{ route('warga.edit', $warga->id) }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Edit</a>
                        </div>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-3">
                        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-gray-50 p-6 space-y-5">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">NIK</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->nik }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nama</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->nama }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Usia</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->usia ?? '-' }} tahun</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Pekerjaan</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->pekerjaan }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Penghasilan</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">Rp {{ number_format($warga->penghasilan, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->tempat_lahir }}, {{ $warga->tanggal_lahir?->format('d-m-Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->jenis_kelamin }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Golongan Darah</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->gol_darah }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Agama</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->agama }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Status Pernikahan</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->status_pernikahan }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Alamat</p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $warga->alamat }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">
                            <h4 class="text-lg font-semibold text-gray-900">QR Code</h4>
                            <div class="mt-6 flex justify-center">
                                <img src="{{ $qrCode }}" alt="QR Code warga" class="h-48 w-48 object-contain" />
                            </div>
                            <p class="mt-4 text-sm text-gray-500">Gunakan QR untuk verifikasi cepat.</p>
                            <br>

                            <a href="{{ route('warga.downloadQr', $warga->id) }}" class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">Unduh QR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
