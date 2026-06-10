<x-app-layout>
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">
            Verifikasi Pengajuan
        </h2>
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3">Nama</th>
                    <th class="p-3">Penghasilan</th>
                    <th class="p-3">Rumah</th>
                    <th class="p-3">Skor AI</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuans as $p)
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
                        {{ $p->status_verifikasi }}
                    </td>
                        {{-- KOLOM AKSI --}}    
                        <td class="p-3">
                            <a
                                href="{{ route('verifikasi.show',$p->id) }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded">
                                Aksi
                            </a>
                        </td>                    
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>