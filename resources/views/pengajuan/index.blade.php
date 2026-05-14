<x-app-layout>
    <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengajuan Bantuan</h2>
            <p class="text-sm text-gray-500">Scan QR warga dan kirim pengajuan bantuan sosial.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
                <div class="space-y-6">
                    @if(session('success') || session('error'))
                        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                            @if(session('success'))
                                <div class="rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="mt-3 rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    @endif

                    <div id="scannerBox" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Scan QR Warga</h3>
                                <p class="text-sm text-gray-500">Arahkan kamera untuk memuat data warga.</p>
                            </div>
                        </div>
                        <div id="reader" class="mt-6 min-h-[260px] rounded-3xl border border-dashed border-gray-200 bg-gray-50"></div>
                    </div>

                    <div id="wargaCard" class="hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900">Data Warga</h3>
                        <div class="mt-5 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-sm text-gray-500">NIK</p>
                                <p class="mt-1 font-semibold text-gray-900" id="nik"></p>
                            </div>
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-sm text-gray-500">Nama</p>
                                <p class="mt-1 font-semibold text-gray-900" id="nama"></p>
                            </div>
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-sm text-gray-500">Alamat</p>
                                <p class="mt-1 font-semibold text-gray-900" id="alamat"></p>
                            </div>
                        </div>
                    </div>

                    <form id="formPengajuan" action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="hidden space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        @csrf
                        <input type="hidden" name="warga_id" id="warga_id">
                        <input type="hidden" name="latitude_pengajuan" id="latitude_pengajuan">
                        <input type="hidden" name="longitude_pengajuan" id="longitude_pengajuan">

                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Form Pengajuan</h3>
                                    <p class="text-sm text-gray-500">Lengkapi data dan unggah foto rumah.</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="ambilLokasi()" id="btnLokasi" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span id="textLokasi">Verifikasi Lokasi</span>
                        </button>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Program Bantuan</label>
                                <select name="program_bantuan" class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                    <option value="jkn">Bantuan Iuran JKN (kesehatan)</option>
                                    <option value="bpnt">Bantuan Pangan Non-Tunai (BPNT) (pangan)</option>
                                    <option value="blt">Bantuan Langsung Tunai (BLT) (tunai)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penghasilan</label>
                                <input type="number" name="penghasilan" class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Usia</label>
                                <input type="number" name="usia" class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <select name="pekerjaan" class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                    <option value="tidak_bekerja">Tidak Bekerja</option>
                                    <option value="buruh_harian">Buruh Harian</option>
                                    <option value="pegawai/karyawan">Pegawai</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Foto Rumah</label>
                            <input type="file" name="foto_rumah" class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        </div>

                        <div class="flex flex-col gap-4">
                            <img id="preview" class="hidden w-40 rounded-xl border border-gray-200" alt="Preview Foto Rumah">
                            <button id="btnAjukan" type="submit" class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition disabled:cursor-not-allowed disabled:bg-green-300" disabled>
                                Ajukan Bantuan
                            </button>
                        </div>

                        @if(session('error'))
                            <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Riwayat Pengajuan</h3>
                                <p class="text-sm text-gray-500">Lihat daftar pengajuan terbaru.</p>
                            </div>
                        </div>
                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide text-xs">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Warga</th>
                                        <th class="px-4 py-3 text-left">Program</th>
                                        <th class="px-4 py-3 text-left">Status</th>
                                        <th class="px-4 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($pengajuans as $pengajuan)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-4 text-gray-700">{{ $pengajuan->warga->nama ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 text-gray-700">{{ $pengajuan->program_bantuan }}</td>
                                            <td class="px-4 py-4">
                                                @if($pengajuan->status === 'diterima')
                                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Diterima</span>
                                                @elseif($pengajuan->status === 'ditolak')
                                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                                                @else
                                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">Menunggu</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-200">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">Belum ada pengajuan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900">Hasil Pengajuan</h3>
                        <div class="mt-5 space-y-4 text-sm text-gray-700">
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-gray-500">Pemohon</p>
                                <p class="mt-1 font-semibold text-gray-900">{{ session('nama') ?? '-' }}</p>
                            </div>
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-gray-500">Program</p>
                                <p class="mt-1 font-semibold text-gray-900">{{ session('program') ?? '-' }}</p>
                            </div>
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-gray-500">Status</p>
                                <p class="mt-2">
                                    @if(session('status') == 'diterima')
                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Diterima</span>
                                    @elseif(session('status') == 'ditolak')
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900">Skor Penilaian</h3>
                        <div class="mt-5 grid gap-4 md:grid-cols-3 text-center">
                            <div class="rounded-2xl bg-blue-50 p-4">
                                <p class="text-sm text-gray-500">Status Lokasi</p>
                                <p class="mt-3 text-lg font-semibold text-gray-900">
                                    @if(session('status_lokasi') == 'sesuai_area')
                                        <span class="text-green-600">Sesuai Area</span>
                                    @elseif(session('status_lokasi') == 'area_dekat')
                                        <span class="text-yellow-600">Area Dekat</span>
                                    @elseif(session('status_lokasi') == 'di_luar_area')
                                        <span class="text-red-600">Di luar Area</span>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="rounded-2xl bg-yellow-50 p-4">
                                <p class="text-sm text-gray-500">Kondisi Rumah</p>
                                <p class="mt-3 text-lg font-semibold text-gray-900">
                                    @if(session('kondisi_rumah') == 'rumah_buruk')
                                        <span class="text-green-600">Buruk</span>
                                    @elseif(session('kondisi_rumah') == 'rumah_sedang')
                                        <span class="text-yellow-600">Sedang</span>
                                    @elseif(session('kondisi_rumah') == 'rumah_baik')
                                        <span class="text-red-600">Baik</span>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="rounded-2xl bg-green-50 p-4">
                                <p class="text-sm text-gray-500">Kelayakan</p>
                                <p class="mt-3 text-2xl font-bold text-green-700">{{ session('skor_kelayakan') ?? '0.0' }}</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText) {
            html5QrcodeScanner.clear();
            document.getElementById('scannerBox')?.remove();
            fetch('/scan/' + decodedText)
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        const w = res.data;
                        document.getElementById('wargaCard')?.classList.remove('hidden');
                        document.getElementById('formPengajuan')?.classList.remove('hidden');
                        document.getElementById('nik').innerText = w.nik;
                        document.getElementById('nama').innerText = w.nama;
                        document.getElementById('alamat').innerText = w.alamat;
                        document.getElementById('warga_id').value = w.id;
                    } else {
                        alert('Warga tidak ditemukan');
                    }
                });
        }
        const html5QrcodeScanner = new Html5QrcodeScanner('reader', { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
    <script>
        document.querySelector('input[name="foto_rumah"]')?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');
            if (!file || !preview) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });
    </script>
    <script>
        function ambilLokasi() {
            const btn = document.getElementById('btnLokasi');
            const text = document.getElementById('textLokasi');
            if (!btn || !text) return;
            btn.disabled = true;
            text.innerHTML = 'Mengambil lokasi...';
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        document.getElementById('latitude_pengajuan').value = position.coords.latitude;
                        document.getElementById('longitude_pengajuan').value = position.coords.longitude;
                        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        btn.classList.add('bg-green-600');
                        text.innerHTML = 'Lokasi Berhasil Diverifikasi';
                        alert('Lokasi berhasil diambil');
                        document.getElementById('btnAjukan').disabled = false;
                    },
                    function () {
                        btn.disabled = false;
                        text.innerHTML = 'Verifikasi Lokasi';
                        alert('Gagal mengambil lokasi');
                    }
                );
            }
        }
    </script>
</x-app-layout>
