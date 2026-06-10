<x-app-layout>

<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">
            Detail Pengajuan
        </h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <strong>NIK:</strong>
                {{ $pengajuan->warga->nik }}
            </div>
            <div>
                <strong>Nama:</strong>
                {{ $pengajuan->warga->nama }}
            </div>
            <div>
                <strong>Usia:</strong>
                {{ $pengajuan->warga->usia }}
            </div>
            <div>
                <strong>Jenis Kelamin:</strong>
                {{ $pengajuan->warga->jenis_kelamin }}
            </div>
            <div>
                <strong>Pekerjaan:</strong>
                {{ $pengajuan->warga->pekerjaan }}
            </div>
            <div>
                <strong>Penghasilan:</strong>
                Rp {{ number_format($pengajuan->warga->penghasilan) }}
            </div>
            <div class="md:col-span-2">
                <strong>Alamat:</strong>
                {{ $pengajuan->warga->alamat }}
            </div>
        </div>
        <hr class="my-6">
        <img
            src="{{ asset('storage/'.$pengajuan->foto_rumah) }}"
            class="w-96 rounded-lg border">
        <div class="mt-6">
            <p>
                <strong>Kondisi Rumah:</strong>
                {{ $pengajuan->kondisi_rumah }}
            </p>
            <p>
                <strong>Skor AI:</strong>
                {{ $pengajuan->skor_kelayakan * 100 }}%
            </p>
            <hr class="my-4">
            <p>
               <hr class="my-6">
                <h3 class="text-xl font-bold mb-4">
                    Verifikasi Lapangan
                </h3>
                <form
                    action="{{ route('verifikasi.proses',$pengajuan->id) }}"
                    method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="font-semibold block mb-2">
                            Hasil Verifikasi Lapangan
                        </label>
                        <select
                            name="hasil_verifikasi"
                            required
                            class="w-full border rounded-lg p-3">
                            <option value="">
                                Pilih Hasil Verifikasi
                            </option>
                            <option value="layak">
                                Layak Menerima Bantuan
                            </option>
                            <option value="tidak_layak">
                                Tidak Layak Menerima Bantuan
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
                            required
                            class="w-full border rounded-lg p-3"></textarea>
                    </div>
                    <button
                        type="submit"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg">
                        Simpan Verifikasi
                    </button>
                </form>
            </p>
        </div>
    </div>
</div>
</x-app-layout>