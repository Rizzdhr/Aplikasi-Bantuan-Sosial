<x-app-layout>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">
            Daftar Penerima Bantuan
        </h1>
        <p class="text-gray-500">
            Warga yang telah disetujui menerima bantuan sosial.
        </p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <table class="w-full border">
            <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">NIK</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Jenis Bantuan</th>
                <th class="border p-2">Skor AI</th>
                <th class="border p-2">Detail</th>
            </tr>
            </thead>
            <tbody>
            @forelse($data as $item)
            @php
                $pengajuan = $item->warga->pengajuans->last();
            @endphp
            <tr>
                <td class="border p-2">
                    {{ $item->warga->nik }}
                </td>
                <td class="border p-2">
                    {{ $item->warga->nama }}
                </td>
                <td class="border p-2">
                    {{ $item->bantuan->nama_bantuan ?? '-' }}
                </td>
                <td class="border p-2">
                    {{ $pengajuan ? number_format($pengajuan->skor_kelayakan * 100,1) : 0 }}%
                </td>
                <td class="border p-2 text-center">
                    <a
                        href="{{ route('penerima-bantuan.show',$item->id) }}"
                        class="bg-blue-500 text-white px-3 py-2 rounded">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center p-4">
                    Belum ada penerima bantuan.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>