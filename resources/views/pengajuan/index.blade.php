<x-app-layout>
<div class="max-w-7xl mx-auto py-6">

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-6">
        Verifikasi Kelayakan Bantuan
    </h2>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3">Nama</th>
                <th class="p-3">Penghasilan</th>
                <th class="p-3">Kondisi Rumah</th>
                <th class="p-3">Skor AI</th>
                <th class="p-3">Catatan Petugas</th>
                <th class="p-3">Detail</th>
                <th class="p-3">Keputusan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $p)
            <tr class="border-b">
                <td class="p-3">
                    {{ $p->warga->nama }}
                </td>
                <td class="p-3">
                    Rp {{ number_format($p->penghasilan) }}
                </td>
                <td class="p-3">
                    {{ $p->kondisi_rumah }}
                </td>
                <td class="p-3">
                    {{ $p->skor_kelayakan * 100 }}%
                </td>
                <td class="p-3">
                    {{ $p->catatan_petugas ?? '-' }}
                </td>
                <td class="p-3">
                <a
                        href="{{ route('pengajuan.show',$p->id) }}"
                        class="bg-blue-600 text-white px-3 py-2 rounded">
                        Detail
                    </a>
                </td>
                <td class="p-3 flex gap-2">
                    <form
                        method="POST"
                        action="{{ route('pengajuan.setujui',$p->id) }}">
                        @csrf
                        <button
                            class="bg-green-600 text-white px-4 py-2 rounded">
                            Setujui
                        </button>
                    </form>
                    <form
                        method="POST"
                        action="{{ route('pengajuan.tolak',$p->id) }}">
                        @csrf
                        <button
                            class="bg-red-600 text-white px-4 py-2 rounded">
                            Tolak
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td
                    colspan="7"
                    class="text-center p-6">
                    Tidak ada pengajuan yang menunggu keputusan admin.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
</x-app-layout>
