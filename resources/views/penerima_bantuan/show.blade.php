<x-app-layout>
<div class="p-6">
    <div class="bg-white p-6 rounded shadow mb-4">
        <h2 class="text-xl font-bold">
            Detail Penerima Bantuan
        </h2>
        <p class="text-gray-500">
            Detail warga, hasil AI, dan status bantuan.
        </p>
    </div>
    <div class="bg-white p-6 rounded shadow mb-4">
        <h3 class="font-bold mb-4">
            Data Warga
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <b>NIK :</b>
                {{ $penerima->warga->nik }}
            </div>
            <div>
                <b>Nama :</b>
                {{ $penerima->warga->nama }}
            </div>
            <div>
                <b>Jenis Kelamin :</b>
                {{ $penerima->warga->jenis_kelamin }}
            </div>
            <div>
                <b>Penghasilan :</b>
                Rp {{ number_format($penerima->warga->penghasilan,0,',','.') }}
            </div>
            <div>
                <b>Pekerjaan :</b>
                {{ $penerima->warga->pekerjaan }}
            </div>
            <div>
                <b>Agama :</b>
                {{ $penerima->warga->agama }}
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded shadow mb-4">
        <h3 class="font-bold mb-4">
            Foto Rumah
        </h3>
        <img
            src="{{ asset('storage/'.$pengajuan->foto_rumah) }}"
            class="w-96 rounded">
    </div>
    <div class="bg-white p-6 rounded shadow mb-4">
        <h3 class="font-bold mb-4">
            Hasil Analisis AI
        </h3>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <b>Kondisi Rumah</b>
                <br>
                {{ $pengajuan->kondisi_rumah }}
            </div>
            <div>
                <b>Skor AI</b>
                <br>
                {{ round($pengajuan->skor_kelayakan * 100,2) }}%
            </div>
            <div>
                <b>Status Pengajuan</b>
                <br>
                {{ strtoupper($pengajuan->status) }}
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded shadow mb-4">
    <h3 class="font-bold mb-4">
        Hasil Verifikasi Lapangan
    </h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <b>Status Verifikasi</b>
            <br>
            @if($pengajuan->status_verifikasi == 'sudah_dicek')
                <span class="text-green-600 font-bold">
                    SUDAH DICEK
                </span>
            @else
                <span class="text-yellow-600 font-bold">
                    BELUM DICEK
                </span>
            @endif
        </div>
        <div>
            <b>Catatan Petugas</b>
            <div class="mt-2 p-3 bg-gray-100 rounded">
                {{ $pengajuan->catatan_petugas ?? 'Tidak ada catatan.' }}
            </div>
        </div>
    </div>
</div>
</div>
</x-app-layout>