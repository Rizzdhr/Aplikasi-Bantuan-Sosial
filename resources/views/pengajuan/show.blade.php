<x-app-layout>

<div class="max-w-7xl mx-auto py-6">
    {{-- HEADER --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-2xl font-bold">
            Detail Pengajuan Bantuan Sosial
        </h2>
        <p class="text-gray-500 mt-2">
            Detail warga, hasil AI, dan hasil verifikasi lapangan.
        </p>
    </div>
    {{-- DATA WARGA --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">
            Data Warga
        </h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <strong>NIK :</strong>
                {{ $pengajuan->warga->nik }}
            </div>
            <div>
                <strong>Nama :</strong>
                {{ $pengajuan->warga->nama }}
            </div>
            <div>
                <strong>Usia :</strong>
                {{ $pengajuan->warga->usia }}
            </div>
            <div>
                <strong>Jenis Kelamin :</strong>
                {{ $pengajuan->warga->jenis_kelamin }}
            </div>
            <div>
                <strong>Pekerjaan :</strong>
                {{ $pengajuan->warga->pekerjaan }}
            </div>
            <div>
                <strong>Penghasilan :</strong>
                Rp {{ number_format($pengajuan->warga->penghasilan,0,',','.') }}
            </div>
            <div>
                <strong>Agama :</strong>
                {{ $pengajuan->warga->agama }}
            </div>
            <div>
                <strong>Status Pernikahan :</strong>
                {{ $pengajuan->warga->status_pernikahan }}
            </div>
            <div class="md:col-span-2">
                <strong>Alamat :</strong>
                {{ $pengajuan->warga->alamat }}
            </div>
        </div>
    </div>
    {{-- FOTO RUMAH --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">
            Foto Rumah
        </h3>
        <img
            src="{{ asset('storage/'.$pengajuan->foto_rumah) }}"
            class="w-full max-w-3xl rounded-lg border">
    </div>
    {{-- HASIL AI --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">
            Hasil Analisis AI
        </h3>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="border rounded-lg p-4">
                <p class="text-gray-500">
                    Kondisi Rumah
                </p>
                <p class="text-xl font-bold mt-2">
                    {{ ucwords(str_replace('_',' ',$pengajuan->kondisi_rumah)) }}
                </p>
            </div>
            <div class="border rounded-lg p-4">
                <p class="text-gray-500">
                    Skor AI
                </p>
                <p class="text-xl font-bold text-blue-600 mt-2">
                    {{ number_format($pengajuan->skor_kelayakan * 100,1) }}%
                </p>
            </div>
            <div class="border rounded-lg p-4">
                <p class="text-gray-500">
                    Status Saat Ini
                </p>
                <p class="text-xl font-bold mt-2">
                    {{ strtoupper($pengajuan->status) }}
                </p>
            <div>
        </div>
    </div>
    {{-- HASIL VERIFIKASI PETUGAS --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">
            Hasil Verifikasi Lapangan
        </h3>
        <div class="border rounded-lg p-4">
            <p class="mb-2">
                <strong>Status Verifikasi :</strong>
                {{ $pengajuan->status_verifikasi }}
            </p>
            <p>
                <strong>Catatan Petugas :</strong>
            </p>
            <div class="bg-gray-100 rounded p-4 mt-2">
                @if($pengajuan->catatan_petugas)
                    {{ $pengajuan->catatan_petugas }}
                @else
                    Belum ada catatan petugas.
                @endif
            </div>
        </div>
    </div>
    {{-- KEPUTUSAN ADMIN --}}
    @if(
        $pengajuan->status_verifikasi == 'sudah_dicek'
        &&
        $pengajuan->status == 'menunggu'
    )
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-bold mb-4">
            Keputusan Admin
        </h3>
        <div class="flex gap-3">
            <form
                method="POST"
                action="{{ route('pengajuan.setujui',$pengajuan->id) }}">
                @csrf
                <button
                    type="submit"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg">
                    Setujui Bantuan
                </button>
            </form>
            <form
                method="POST"
                action="{{ route('pengajuan.tolak',$pengajuan->id) }}">
                @csrf
                <button
                    type="submit"
                    class="bg-red-600 text-white px-6 py-3 rounded-lg">
                    Tolak Bantuan
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
</x-app-layout>