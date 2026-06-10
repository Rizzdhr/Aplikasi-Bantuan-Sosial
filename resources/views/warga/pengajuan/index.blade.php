<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Riwayat Pengajuan Bantuan
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
            {{-- TOMBOL AJUKAN --}}
            @if($pengajuans->count() == 0)
            <div class="mb-4">
                <a
                    href="{{ route('warga.pengajuan.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg">
                    Ajukan Bantuan
                </a>
            </div>
            @else
            <div class="mb-4">
                <span
                    class="bg-blue-100 text-blue-700 px-5 py-3 rounded-lg inline-block">
                    Anda Sudah Mengajukan Bantuan
                </span>
            </div>
            @endif
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">
                                Tanggal
                            </th>
                            <th class="p-3 text-left">
                                Status Pengajuan
                            </th>
                            <th class="p-3 text-left">
                                Status Verifikasi
                            </th>
                            <th class="p-3 text-left">
                                Kondisi Rumah
                            </th>
                            <th class="p-3 text-left">
                                Skor AI
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuans as $item)
                        <tr class="border-t">
                            <td class="p-3">
                                {{ $item->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td class="p-3">
                                @if($item->status == 'menunggu')
                                    <span class="text-yellow-600 font-semibold">
                                        Menunggu
                                    </span>
                                @elseif($item->status == 'diterima')
                                    <span class="text-green-600 font-semibold">
                                        Diterima
                                    </span>
                                @else
                                    <span class="text-red-600 font-semibold">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="p-3">
                                @if($item->status_verifikasi == 'belum_dicek')
                                    Belum Dicek
                                @else
                                    Sudah Dicek
                                @endif
                            </td>
                            <td class="p-3">
                                {{ ucwords(str_replace('_',' ',$item->kondisi_rumah)) }}
                            </td>
                            <td class="p-3">
                                {{ number_format($item->skor_kelayakan * 100,1) }}%
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td
                                colspan="5"
                                class="text-center p-5 text-gray-500">
                                Belum ada pengajuan bantuan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Pengajuan Berhasil',
    text: '{{ session("success") }}',
    confirmButtonText: 'Lihat Status'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session("error") }}'
});
</script>
@endif
</x-app-layout>