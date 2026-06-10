<x-app-layout>
    <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Warga</h2>
            <p class="text-sm text-gray-500">Informasi lengkap warga dan kode QR verifikasi.</p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200 space-y-5">

                    {{-- Header + Actions --}}
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Detail Warga</h3>
                            <p class="text-sm text-gray-500">Lihat informasi detail beserta QR code warga.</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('warga.index') }}"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                                ← Kembali
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('warga.edit', $warga->id) }}"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- QR Card (mobile: top, desktop: right column) --}}
                    <div class="grid gap-5 lg:grid-cols-3">

                        {{-- QR: tampil di atas di mobile --}}
                        <div class="lg:hidden rounded-2xl border border-gray-200 bg-white p-5">
                            <div class="flex items-center gap-5">
                                <img src="{{ $qrCode }}" alt="QR Code warga"
                                    class="h-24 w-24 shrink-0 object-contain rounded-xl border border-gray-100" />
                                <div class="space-y-1">
                                    <h4 class="text-base font-semibold text-gray-900">QR Code</h4>
                                    <p class="text-xs text-gray-500">Gunakan QR untuk verifikasi cepat.</p>
                                    <a href="{{ route('warga.downloadQr', $warga->id) }}"
                                        class="mt-2 inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-green-700">
                                        Unduh QR
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Info Grid --}}
                        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-gray-50 p-4 sm:p-6">
                            <div class="grid grid-cols-2 gap-x-4 gap-y-5 sm:gap-x-6">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">NIK</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900 break-all">{{ $warga->nik }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Nama</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->nama }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Usia</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->usia ?? '-' }} tahun</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Pekerjaan</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->pekerjaan }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Penghasilan</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">Rp {{ number_format($warga->penghasilan, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tempat, Tanggal Lahir</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->tempat_lahir }}, {{ $warga->tanggal_lahir?->format('d-m-Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Jenis Kelamin</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->jenis_kelamin }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Golongan Darah</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->gol_darah }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Agama</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->agama }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Status Pernikahan</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->status_pernikahan }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs font-medium text-gray-500">Alamat</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $warga->alamat }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- QR: tampil di kanan di desktop --}}
                        <div class="hidden lg:flex rounded-2xl border border-gray-200 bg-white p-6 flex-col items-center justify-center text-center gap-4">
                            <h4 class="text-lg font-semibold text-gray-900">QR Code</h4>
                            <img src="{{ $qrCode }}" alt="QR Code warga"
                                class="h-48 w-48 object-contain" />
                            <p class="text-sm text-gray-500">Gunakan QR untuk verifikasi cepat.</p>
                            <a href="{{ route('warga.downloadQr', $warga->id) }}"
                                class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                Unduh QR
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
