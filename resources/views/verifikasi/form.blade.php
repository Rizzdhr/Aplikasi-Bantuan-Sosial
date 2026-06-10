<x-app-layout>
<div class="max-w-6xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">
            Verifikasi Lapangan
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <img
                    src="{{ asset('storage/'.$pengajuan->foto_rumah) }}"
                    class="rounded-lg border w-full">
            </div>
            <div>
                <p>
                    <strong>Nama:</strong>
                    {{ $pengajuan->warga->nama }}
                </p>
                <p class="mt-2">
                    <strong>NIK:</strong>
                    {{ $pengajuan->warga->nik }}
                </p>
                <p class="mt-2">
                    <strong>Alamat:</strong>
                    {{ $pengajuan->warga->alamat }}
                </p>
                <p class="mt-2">
                    <strong>Kondisi AI:</strong>
                    {{ $pengajuan->kondisi_rumah }}
                </p>
                <p class="mt-2">
                    <strong>Skor AI:</strong>
                    {{ $pengajuan->skor_kelayakan * 100 }}%
                </p>
            </div>
        </div>
        <form
            method="POST"
            action="{{ route('verifikasi.simpan',$pengajuan->id) }}"
            class="mt-8">
            @csrf
            <div class="mb-4">
                <label class="font-semibold block mb-2">
                    Hasil Verifikasi Lapangan
                </label>
                <select
                    name="hasil_verifikasi"
                    class="w-full border rounded p-3">
                    <option value="sesuai">
                        Sesuai dengan hasil AI
                    </option>
                    <option value="tidak_sesuai">
                        Tidak sesuai dengan hasil AI
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="font-semibold block mb-2">
                    Catatan Petugas
                </label>
                <textarea
                    name="catatan_petugas"
                    rows="5"
                    class="w-full border rounded p-3"
                    required></textarea>
            </div>
            <button
                type="submit"
                class="bg-green-600 text-white px-5 py-2 rounded">
                Simpan Verifikasi
            </button>
        </form>
    </div>
</div>
</x-app-layout>