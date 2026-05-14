<x-app-layout>
    <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pengajuan</h2>
            <p class="text-sm text-gray-500">Lihat detail hasil pengajuan bantuan sosial.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Detail Pengajuan</h3>
                            <p class="text-sm text-gray-500">Detail informasi pengajuan dan kondisi rumah.</p>
                        </div>
                        <a href="{{ route('pengajuan.index') }}" class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">← Kembali</a>
                    </div>

                    @php
                        $programNames = [
                            'jkn' => 'Bantuan Iuran JKN (kesehatan)',
                            'bpnt' => 'Bantuan Pangan Non-Tunai (BPNT) (pangan)',
                            'blt' => 'Bantuan Langsung Tunai (BLT) (tunai)',
                        ];
                    @endphp

                    <div class="grid gap-6 lg:grid-cols-3">
                        <div class="lg:col-span-2 space-y-6">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Warga</h4>
                                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <p class="text-sm text-gray-500">NIK</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $pengajuan->warga->nik ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Nama</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $pengajuan->warga->nama ?? '-' }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-gray-500">Alamat</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $pengajuan->warga->alamat ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-white p-6">
                                <h4 class="text-lg font-semibold text-gray-900">Detail Pengajuan</h4>
                                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <p class="text-sm text-gray-500">Program Bantuan</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $programNames[$pengajuan->program_bantuan] ?? $pengajuan->program_bantuan }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Penghasilan</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ number_format($pengajuan->penghasilan, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Usia</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $pengajuan->usia }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Pekerjaan</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ ucwords(str_replace(['_', '/'], [' ', ' / '], $pengajuan->pekerjaan)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status Lokasi</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $pengajuan->status_lokasi)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Kondisi Rumah</p>
                                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $pengajuan->kondisi_rumah)) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-white p-6">
                                <h4 class="text-lg font-semibold text-gray-900">Hasil Penilaian</h4>
                                <div class="mt-5 grid gap-4 sm:grid-cols-3">
                                    <div class="rounded-2xl bg-blue-50 p-4 text-center">
                                        <p class="text-sm text-gray-500">Status</p>
                                        <p class="mt-3 text-lg font-semibold text-gray-900">{{ ucfirst($pengajuan->status) }}</p>
                                    </div>
                                    <div class="rounded-2xl bg-yellow-50 p-4 text-center">
                                        <p class="text-sm text-gray-500">Skor Kelayakan</p>
                                        <p class="mt-3 text-lg font-semibold text-gray-900">{{ $pengajuan->skor_kelayakan ?? '0.0' }}</p>
                                    </div>
                                    <div class="rounded-2xl bg-green-50 p-4 text-center">
                                        <p class="text-sm text-gray-500">Jarak Lokasi</p>
                                        <p class="mt-3 text-lg font-semibold text-gray-900">{{ number_format($pengajuan->jarak_lokasi, 2, ',', '.') }} km</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">
                            <h4 class="text-lg font-semibold text-gray-900">Foto Rumah</h4>
                            <div class="mt-6">
                                <img src="{{ $pengajuan->foto_rumah ? asset('storage/' . $pengajuan->foto_rumah) : 'https://via.placeholder.com/400x300?text=No+Image' }}" alt="Foto Rumah" class="mx-auto h-56 w-full max-w-full rounded-2xl object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
