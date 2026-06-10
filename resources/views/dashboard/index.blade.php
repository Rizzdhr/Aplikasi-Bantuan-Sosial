<x-app-layout>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-2xl font-bold mb-6">
        Dashboard Pengajuan Warga
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Total Warga</p>
            <p class="text-3xl font-bold">
                {{ $totalWarga }}
            </p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Pengajuan</p>
            <p class="text-3xl font-bold">
                {{ $totalPengajuan }}
            </p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-yellow-600">
                Menunggu Verifikasi
            </p>
            <p class="text-3xl font-bold">
                {{ $menungguVerifikasi }}
            </p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-blue-600">
                Menunggu Admin
            </p>
            <p class="text-3xl font-bold">
                {{ $menungguAdmin }}
            </p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-green-600">
                Diterima
            </p>
            <p class="text-3xl font-bold">
                {{ $diterima }}
            </p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-red-600">
                Ditolak
            </p>
            <p class="text-3xl font-bold">
                {{ $ditolak }}
            </p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">
                5 Pengajuan Terbaru
            </h2>
            <a href="{{ route('pengajuan.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Lihat Semua
            </a>
        </div>
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3">Tanggal</th>
                    <th class="text-left py-3">Nama</th>
                    <th class="text-left py-3">Skor AI</th>
                    <th class="text-left py-3">Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pengajuanTerbaru as $item)
                <tr class="border-b">
                    <td class="py-3">
                        {{ $item->created_at->format('d-m-Y') }}
                    </td>
                    <td class="py-3">
                        {{ $item->warga->nama ?? '-' }}
                    </td>
                    <td class="py-3">
                        {{ number_format($item->skor_kelayakan * 100,1) }}%
                    </td>
                    <td class="py-3">
                        @if($item->status == 'diterima')
                            <span class="text-green-600">
                                Diterima
                            </span>
                        @elseif($item->status == 'ditolak')
                            <span class="text-red-600">
                                Ditolak
                            </span>
                        @else
                            <span class="text-yellow-600">
                                Menunggu
                            </span>

                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>
</x-app-layout>
