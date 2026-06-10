<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- KIRI --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-2xl font-bold mb-6">
                            Bantuan Aktif
                        </h2>
                        @forelse($bantuans as $bantuan)
                            <div class="border rounded-lg p-5 mb-4">
                                <h3 class="text-xl font-semibold">
                                    {{ $bantuan->nama_bantuan }}
                                </h3>
                                <p class="text-gray-500 mt-2">
                                    {{ $bantuan->deskripsi }}
                                </p>
                                <p class="mt-2 font-bold text-green-600">
                                    Rp {{ number_format($bantuan->nominal,0,',','.') }}
                                </p>
                                <div class="mt-4">
                                    <a
                                        href="{{ route('bantuan.showQr',$bantuan->id) }}"
                                        target="_blank"
                                        class="bg-blue-600 text-white px-4 py-2 rounded">
                                        Tampilkan QR Distribusi
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-500">
                                Belum ada bantuan aktif.
                            </div>
                        @endforelse
                    </div>
                </div>
                {{-- KANAN --}}
                <div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="text-2xl font-bold mb-4">
                            Penyaluran Bantuan
                        </h3>
                        <p class="text-gray-500">
                            Tampilkan QR kepada warga untuk
                            melakukan pengambilan bantuan sosial.
                        </p>
                        <div class="text-center mt-10">
                            <div class="text-7xl">
                                📦
                            </div>
                            <p class="mt-4 text-gray-500">
                                Warga dapat langsung scan QR
                                menggunakan menu
                                "Pengambilan Bantuan Sosial".
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>