<x-app-layout>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-2xl font-bold mb-1">
        Data Warga
    </h2>
    <p class="text-gray-500 mb-6">
        Informasi lengkap warga dan kode QR verifikasi.
    </p>
   <div class="mb-6 flex gap-3">
    <a
        href="{{ route('warga.pengajuan.create') }}"
        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
        Ajukan Bantuan
    </a>
    <a
        href="{{ route('warga.pengajuan.index') }}"
        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
        Status Pengajuan
    </a>
</div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- DATA WARGA --}}
        <div class="lg:col-span-2 border rounded-2xl p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-500 text-sm">NIK</p>
                    <p class="font-semibold">{{ $warga->nik }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Nama</p>
                    <p class="font-semibold">{{ $warga->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Email</p>
                    <p class="font-semibold">{{ $warga->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Usia</p>
                    <p class="font-semibold">{{ $warga->usia }} Tahun</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Pekerjaan</p>
                    <p class="font-semibold">{{ $warga->pekerjaan }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Penghasilan</p>
                    <p class="font-semibold">
                        Rp {{ number_format($warga->penghasilan,0,',','.') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jenis Kelamin</p>
                    <p class="font-semibold">{{ $warga->jenis_kelamin }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Agama</p>
                    <p class="font-semibold">{{ $warga->agama }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Status Pernikahan</p>
                    <p class="font-semibold">{{ $warga->status_pernikahan }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Golongan Darah</p>
                    <p class="font-semibold">{{ $warga->gol_darah }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm">Alamat</p>
                    <p class="font-semibold">{{ $warga->alamat }}</p>
                </div>
            </div>
        </div>
        {{-- QR CODE --}}
        <div class="border rounded-2xl p-6 text-center">
            <h3 class="text-2xl font-bold mb-4">
                QR Code
            </h3>
            <img
                src="{{ route('warga.downloadQr',$warga->id) }}"
                class="mx-auto w-52"
            >
            <p class="text-gray-500 mt-4 mb-4">
                Gunakan QR untuk verifikasi cepat.
            </p>
            <a href="{{ route('warga.downloadQr',$warga->id) }}"
               download
               class="inline-flex items-center px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Unduh QR
            </a>
        </div>
    </div>
</div>
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-2xl font-bold mb-4">
        Status Pengajuan Terakhir
    </h2>
    @if($pengajuanTerakhir)
<div class="grid md:grid-cols-3 gap-4">
    <div class="border rounded-xl p-4">
        <p class="text-gray-500">
            Status Pengajuan
        </p>
        <p class="text-2xl font-bold mt-2">
            
        @if(
            $pengajuanTerakhir->status_verifikasi == 'belum_dicek'
        )
            <span class="text-yellow-600">
                Menunggu Verifikasi Lapangan
            </span>
        @elseif(
            $pengajuanTerakhir->status_verifikasi == 'sudah_dicek'
            &&
            $pengajuanTerakhir->status == 'menunggu'
        )
            <span class="text-blue-600">
                Menunggu Keputusan Admin
            </span>
        @elseif(
            $pengajuanTerakhir->status == 'diterima'
        )
            <span class="text-green-600">
                Diterima
            </span>
        @elseif(
            $pengajuanTerakhir->status == 'ditolak'
        )
            <span class="text-red-600">
                Ditolak
            </span>
        @endif
        </p>
    </div>
    <div class="border rounded-xl p-4">
        <p class="text-gray-500">
            Skor Kelayakan AI
        </p>
        <p class="text-3xl font-bold text-blue-600 mt-2">
            {{ $pengajuanTerakhir->skor_kelayakan
                ? number_format($pengajuanTerakhir->skor_kelayakan * 100,1)
                : 0
            }}%
        </p>
    </div>
    <div class="border rounded-xl p-4">
        <p class="text-gray-500">
            Kondisi Rumah
        </p>
        <p class="text-2xl font-bold mt-2">
            {{ ucwords(str_replace('_',' ', $pengajuanTerakhir->kondisi_rumah ?? 'Belum Dinilai')) }}
        </p>
    </div>
</div>
@endif
</div>
@if($pengajuanTerakhir)
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">
        Hasil Verifikasi Lapangan
    </h2>
    <div class="border rounded-xl p-4">
        <p class="text-gray-500 mb-2">
            Status Verifikasi
        </p>
        <p class="font-bold mb-4">
            @if(
                $pengajuanTerakhir->status_verifikasi
                ==
                'belum_dicek'
            )
                Belum Diverifikasi
            @else
                Sudah Diverifikasi
            @endif
        </p>
        <p class="text-gray-500 mb-2">
            Catatan Petugas
        </p>
        <div class="bg-gray-100 rounded-lg p-4">
            @if(
                $pengajuanTerakhir->catatan_petugas
            )
                {{ $pengajuanTerakhir->catatan_petugas }}
            @else
                Belum ada catatan petugas.
            @endif
        </div>
    </div>    
    <h2 class="text-2xl font-bold mb-4">
        Informasi Bantuan Aktif
    </h2>
   @if($bantuanAktif)
<table class="w-full">
    <tr>
        <td class="font-semibold py-2">
            Nama Bantuan
        </td>
        <td>
            {{ $bantuanAktif->bantuan->nama_bantuan }}
        </td>
    </tr>
    <tr>
        <td class="font-semibold py-2">
            Status
        </td>
        <td>
            @if(
                $bantuanAktif->status
                ==
                'belum_menerima'
            )
                <span class="text-yellow-600">
                    Menunggu Penyaluran
                </span>
            @else
                <span class="text-green-600">
                    Sudah Diterima
                </span>
            @endif
        </td>
    </tr>
</table>
@else
<p class="text-gray-500">
    Belum ada bantuan yang aktif.
</p>
@endif
</div>
@endif  
</x-app-layout>