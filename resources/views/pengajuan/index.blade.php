<style>
    #reader {
        padding: 20px;
    }

    #reader__scan_region {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 250px;
    }

    #reader__scan_region img {
        margin: 0 auto !important;
        display: block !important;
    }

    #reader select,
    #reader button {
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        margin: 4px;
    }

    #reader button {
        cursor: pointer;
    }

    #reader a {
        display: inline-block;
        margin-top: 10px;
    }
</style>

<x-app-layout>
    {{-- <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengajuan Bantuan</h2>
            <p class="text-sm text-gray-500">Scan QR warga dan kirim pengajuan bantuan sosial.</p>
        </div>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
                <div class="space-y-6">
                    @if (session('success') || session('error'))
                        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                            @if (session('success'))
                                <div class="rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
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
                        <div id="reader"
                            class="mt-6 min-h-[260px] rounded-3xl border border-dashed border-gray-200 bg-gray-50">
                        </div>
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
                            {{-- <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-sm text-gray-500">Alamat</p>
                                <p class="mt-1 font-semibold text-gray-900" id="alamat"></p>
                            </div> --}}
                            {{-- <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-sm text-gray-500">Kecamatan</p>
                                <p class="mt-1 font-semibold text-gray-900" id="kecamatan"></p>
                            </div> --}}
                            {{-- <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-sm text-gray-500">Tanggal Lahir</p>
                                <p class="mt-1 font-semibold text-gray-900" id="tanggal_lahir"></p>
                            </div> --}}
                        </div>
                    </div>

                    <form id="formPengajuan" action="{{ route('pengajuan.store') }}" method="POST"
                        enctype="multipart/form-data"
                        class="hidden space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
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

                        {{-- <button type="button" onclick="ambilLokasi()" id="btnLokasi" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span id="textLokasi">Verifikasi Lokasi</span>
                        </button> --}}

                        <div class="grid gap-4 md:grid-cols-2">
                            {{-- <div>
                                <label class="block text-sm font-medium text-gray-700">Program Bantuan</label>
                                <select name="program_bantuan" class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                    <option value="jkn">Bantuan Iuran JKN (kesehatan)</option>
                                    <option value="bpnt">Bantuan Pangan Non-Tunai (BPNT) (pangan)</option>
                                    <option value="blt">Bantuan Langsung Tunai (BLT) (tunai)</option>
                                </select>
                            </div> --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Penghasilan
                                </label>

                                <input type="text" name="penghasilan" id="penghasilan"
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:bg-gray-100"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Usia</label>
                                <input type="number" name="usia" id="usia"
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan"
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                    readonly>
                                {{-- <select name="pekerjaan"
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                    <option value="tidak_bekerja">Tidak Bekerja</option>
                                    <option value="buruh_harian">Buruh Harian</option>
                                    <option value="pegawai/karyawan">Pegawai</option>
                                </select> --}}
                            </div>
                        </div>

                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700">Foto Rumah</label>
                            <input type="file" name="foto_rumah"
                                class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        </div> --}}

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Upload Foto Rumah
                            </h3>
                        </div>

                        <div>
                            <div id="dropArea"
                                class="relative overflow-hidden rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 transition hover:border-green-400 hover:bg-green-50">

                                <input type="file" name="foto_rumah" id="foto_rumah"
                                    class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0">

                                <div id="uploadContent"
                                    class="flex flex-col items-center justify-center px-6 py-16 text-center">

                                    <div class="text-5xl mb-4">📷</div>

                                    <p class="text-lg font-semibold text-gray-700">
                                        Drag & Drop foto rumah di sini
                                    </p>

                                    <p class="mt-2 text-sm text-gray-500">
                                        atau klik untuk memilih file
                                    </p>

                                    <p id="fileName" class="mt-4 text-sm font-semibold text-green-600">
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <img id="preview" class="hidden w-40 rounded-xl border border-gray-200"
                                alt="Preview Foto Rumah">
                            <button id="btnAjukan" type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition"
                                disabled>
                                Ajukan Bantuan
                            </button>
                        </div>

                        @if (session('error'))
                            <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>

                    {{-- <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
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
                                            <td class="px-4 py-4 text-gray-700">{{ $pengajuan->warga->nama ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 text-gray-700">{{ $pengajuan->program_bantuan }}</td>
                                            <td class="px-4 py-4">
                                                @if ($pengajuan->status === 'diterima')
                                                    <span
                                                        class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Diterima</span>
                                                @elseif($pengajuan->status === 'ditolak')
                                                    <span
                                                        class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                                                @else
                                                    <span
                                                        class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">Menunggu</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <a href="{{ route('pengajuan.show', $pengajuan->id) }}"
                                                    class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-200">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">Belum ada
                                                pengajuan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                </div>

                <aside class="space-y-6">

                    <!-- HASIL -->
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Hasil Prediksi
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Hasil klasifikasi kondisi rumah berdasarkan foto yang diunggah.
                            </p>
                        </div>
                        @if (session('foto_rumah'))
                            <div class="space-y-4 p-5">

                                <div class="grid grid-cols-2 gap-4">

                                    <div class="rounded-2xl bg-gray-50 p-4">
                                        <p class="text-sm text-gray-500">Pemohon</p>

                                        <p class="mt-1 font-semibold text-gray-900">
                                            {{ session('nama') ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-gray-50 p-4">
                                        <p class="text-sm text-gray-500">Penghasilan</p>

                                        <p class="mt-1 font-semibold text-gray-900">
                                            Rp {{ number_format(session('penghasilan') ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-gray-50 p-4">
                                        <p class="text-sm text-gray-500">Usia</p>

                                        <p class="mt-1 font-semibold text-gray-900">
                                            {{ session('usia') ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-2xl bg-gray-50 p-4">
                                        <p class="text-sm text-gray-500">Pekerjaan</p>

                                        <p class="mt-1 font-semibold text-gray-900">
                                            {{ session('pekerjaan') ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <img src="{{ asset('storage/' . session('foto_rumah')) }}" alt="Foto Rumah"
                                    class="h-60 w-full rounded-2xl border border-gray-200 object-cover">

                                <div class="flex items-start justify-between gap-4">

                                    <div>
                                        <p class="text-sm text-gray-500">
                                            Kategori Rumah
                                        </p>

                                        <h2
                                            class="mt-1 text-3xl font-bold
                            @if (session('kondisi_rumah') == 'rumah_buruk') text-red-500
                            @elseif(session('kondisi_rumah') == 'rumah_sedang')
                                text-yellow-500
                            @else
                                text-green-500 @endif">

                                            {{ ucwords(str_replace('_', ' ', session('kondisi_rumah'))) }}
                                        </h2>
                                    </div>


                                </div>

                                <div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-500">
                                            Skor Kelayakan
                                        </p>

                                        <p
                                            class="text-lg font-bold
                                            @if ((session('skor_kelayakan') ?? 0) * 100 < 50) text-red-600
                                            @else
                                                text-green-600 @endif
                                        ">
                                            {{ number_format((session('skor_kelayakan') ?? 0) * 100, 1) }}%
                                        </p>
                                    </div>

                                    <div class="mt-3 h-3 overflow-hidden rounded-full bg-gray-100">
                                        <div class="h-full rounded-full
                                            @if ((session('skor_kelayakan') ?? 0) * 100 < 50) bg-red-500
                                            @else
                                                bg-green-500 @endif
                                        "
                                            style="width: {{ (session('skor_kelayakan') ?? 0) * 100 }}%">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-center rounded-2xl bg-gray-50 p-4">
                                    {{-- <p class="text-sm leading-relaxed text-gray-600">
                                        Kondisi rumah terdeteksi sebagai
                                        <span class="font-semibold text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', session('kondisi_rumah'))) }}
                                        </span>
                                        berdasarkan hasil klasifikasi foto rumah.
                                    </p> --}}
                                    <span
                                        class="rounded-full px-4 py-2 text-sm font-semibold
                        @if (session('status') == 'ditolak') bg-red-100 text-red-700
                        @elseif(session('status') == 'dipertimbangkan')
                            bg-yellow-100 text-yellow-700
                        @else
                            bg-green-100 text-green-700 @endif">

                                        {{ ucwords(str_replace('_', ' ', session('status'))) }}
                                    </span>
                                </div>

                                {{-- Alasan Skor Kelayakan --}}
                                @if (session('alasan') && count(session('alasan')) > 0)
                                    <div class="rounded-2xl bg-gray-50 p-4 space-y-2">
                                        <p class="text-sm font-semibold text-gray-700 mb-3">
                                            Alasan Skor Kelayakan
                                        </p>
                                        @foreach (session('alasan') as $item)
                                            <div class="flex items-center gap-2 text-sm">
                                                @if ($item['positif'] === true)
                                                    <span
                                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs font-bold flex-shrink-0">✓</span>
                                                    <span class="text-green-700">{{ $item['teks'] }}</span>
                                                @elseif ($item['positif'] === false)
                                                    <span
                                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-red-100 text-red-500 text-xs font-bold flex-shrink-0">✗</span>
                                                    <span class="text-red-600">{{ $item['teks'] }}</span>
                                                @else
                                                    <span
                                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-yellow-100 text-yellow-600 text-xs font-bold flex-shrink-0">~</span>
                                                    <span class="text-yellow-700">{{ $item['teks'] }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif


                                <div class="border-t border-gray-100 pt-3">
                                    <p class="text-xs text-gray-400">
                                        Diprediksi pada:
                                        {{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y - H:i') }} WIB
                                    </p>
                                </div>

                            </div>
                        @else
                            <div class="p-10 text-center">
                                <div class="text-5xl">🏠</div>

                                <h3 class="mt-4 text-lg font-semibold text-gray-800">
                                    Belum Ada Prediksi
                                </h3>

                                <p class="mt-2 text-sm text-gray-500">
                                    Upload dan proses foto rumah untuk melihat hasil prediksi AI.
                                </p>
                            </div>
                        @endif

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
                        // document.getElementById('alamat').innerText = w.alamat;
                        // document.getElementById('kecamatan').innerText = w.kecamatan;
                        // document.getElementById('tanggal_lahir').innerText = w.tanggal_lahir;
                        document.getElementById('penghasilan').value =
                            'Rp ' + Number(w.penghasilan).toLocaleString('id-ID');
                        document.getElementById('usia').value = w.usia;
                        document.getElementById('pekerjaan').value = w.pekerjaan;
                        document.getElementById('warga_id').value = w.id;
                    } else {
                        alert('Warga tidak ditemukan');
                    }
                });
        }
        const html5QrcodeScanner = new Html5QrcodeScanner('reader', {
            fps: 10,
            qrbox: 250
        });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
    <script>
        document.querySelector('input[name="foto_rumah"]')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');
            if (!file || !preview) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });
    </script>
    <script>
        const input = document.getElementById('foto_rumah');
        const preview = document.getElementById('preview');
        const fileName = document.getElementById('fileName');
        const dropArea = document.getElementById('dropArea');
        const btnAjukan = document.getElementById('btnAjukan');

        function handleFile(file) {
            if (!file) return;

            // tampil nama file
            fileName.textContent = file.name;

            // preview gambar
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');

            // aktifkan tombol submit
            btnAjukan.disabled = false;
        }

        // pilih file manual
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            handleFile(file);
        });

        // drag over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, e => {
                e.preventDefault();

                dropArea.classList.add(
                    'border-green-500',
                    'bg-green-50'
                );
            });
        });

        // drag leave
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, e => {
                e.preventDefault();

                dropArea.classList.remove(
                    'border-green-500',
                    'bg-green-50'
                );
            });
        });

        // drop file
        dropArea.addEventListener('drop', e => {
            e.preventDefault();

            const files = e.dataTransfer.files;

            if (files.length) {
                input.files = files;

                handleFile(files[0]);
            }
        });
    </script>
    {{-- <script>
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
    </script> --}}
</x-app-layout>
