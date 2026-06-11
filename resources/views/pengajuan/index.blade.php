<style>
    #reader { padding: 12px; }
    #reader__scan_region {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 220px;
    }
    #reader__scan_region img { margin: 0 auto !important; display: block !important; }

    /* Paksa semua elemen bawaan html5-qrcode masuk ke dalam box */
    #reader__dashboard { width: 100%; overflow: hidden; }
    #reader__dashboard_section { width: 100%; }
    #reader__dashboard_section_csr { width: 100%; }
    #reader__dashboard_section_swaplink { width: 100%; }

    #reader select {
        display: block;
        width: 100%;
        max-width: 100%;
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        margin: 4px 0;
        box-sizing: border-box;
        font-size: 14px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #reader button {
        display: block;
        width: 100%;
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        margin: 4px 0;
        cursor: pointer;
        box-sizing: border-box;
        font-size: 14px;
    }

    #reader a {
        display: inline-block;
        margin-top: 10px;
        font-size: 13px;
        word-break: break-all;
    }

    /* Bungkus video/canvas agar tidak overflow */
    #reader__scan_region > video,
    #reader__scan_region > canvas {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 12px;
    }
</style>

<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Alerts --}}
            @if (session('success') || session('error'))
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm space-y-3">
                    @if (session('success'))
                        <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            @endif

            <div class="grid gap-5 xl:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">

                {{-- LEFT COLUMN --}}
                <div class="space-y-5 min-w-0">

                    {{-- Scanner --}}
                    <div id="scannerBox" class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm overflow-hidden">
                        <h3 class="text-lg font-semibold text-gray-900">Scan QR Warga</h3>
                        <p class="text-sm text-gray-500">Arahkan kamera untuk memuat data warga.</p>
                        <div id="reader" class="mt-4 w-full rounded-2xl border border-dashed border-gray-200 bg-gray-50 overflow-hidden"></div>
                    </div>

                    {{-- Warga Card --}}
                    <div id="wargaCard" class="hidden rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm overflow-hidden min-w-0">
                        <h3 class="text-lg font-semibold text-gray-900">Data Warga</h3>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs text-gray-500">NIK</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 break-all" id="nik"></p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs text-gray-500">Nama</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900" id="nama"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Form Pengajuan --}}
                    <form id="formPengajuan" action="{{ route('pengajuan.store') }}" method="POST"
                        enctype="multipart/form-data"
                        class="hidden space-y-5 rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm overflow-hidden min-w-0">
                        @csrf
                        <input type="hidden" name="warga_id" id="warga_id">
                        <input type="hidden" name="latitude_pengajuan" id="latitude_pengajuan">
                        <input type="hidden" name="longitude_pengajuan" id="longitude_pengajuan">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Form Pengajuan</h3>
                            <p class="text-sm text-gray-500">Lengkapi data dan unggah foto rumah.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penghasilan</label>
                                <input type="text" name="penghasilan" id="penghasilan" readonly
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-2 text-sm text-gray-900 shadow-sm focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Usia</label>
                                <input type="number" name="usia" id="usia" readonly
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-2 text-sm text-gray-900 shadow-sm focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan" readonly
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-2 text-sm text-gray-900 shadow-sm focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Upload Foto Rumah</h3>
                        </div>

                        <div id="dropArea"
                            class="relative overflow-hidden rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 transition hover:border-green-400 hover:bg-green-50">
                            <input type="file" name="foto_rumah" id="foto_rumah"
                                class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0">
                            <div id="uploadContent" class="flex flex-col items-center justify-center px-6 py-10 sm:py-16 text-center">
                                <div class="text-4xl sm:text-5xl mb-3">📷</div>
                                <p class="text-base font-semibold text-gray-700">Drag & Drop foto rumah di sini</p>
                                <p class="mt-1 text-sm text-gray-500">atau klik untuk memilih file</p>
                                <p id="fileName" class="mt-3 text-sm font-semibold text-green-600"></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                        <img id="preview" class="hidden w-full rounded-xl border border-gray-200 object-cover block" alt="Preview Foto Rumah" style="max-width:100%;">
                            <button id="btnAjukan" type="submit" disabled
                                class="w-full inline-flex items-center justify-center rounded-2xl bg-green-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                Ajukan Bantuan
                            </button>
                        </div>

                        @if (session('error'))
                            <div class="rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>

                {{-- RIGHT COLUMN: Hasil Penilaian Kelayakan --}}
                <aside>
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 px-4 sm:px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-900">Hasil Penilaian Kelayakan</h3>
                            <p class="mt-1 text-sm text-gray-500">Hasil analisis berdasarkan data warga dan klasifikasi kondisi rumah.</p>
                        </div>

                        @if (session('foto_rumah'))
                            <div class="space-y-4 p-4 sm:p-5">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Pemohon</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ session('nama') ?? '-' }}</p>
                                    </div>
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Penghasilan</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-900">Rp {{ number_format(session('penghasilan') ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Usia</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ session('usia') ?? '-' }}</p>
                                    </div>
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Pekerjaan</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ session('pekerjaan') ?? '-' }}</p>
                                    </div>
                                </div>

                                <img src="{{ asset('storage/' . session('foto_rumah')) }}" alt="Foto Rumah"
                                    class="h-48 sm:h-60 w-full rounded-2xl border border-gray-200 object-cover">
                                <div>
                                    <p class="text-sm text-gray-500">Kategori Rumah</p>
                                    <h2 class="mt-1 text-2xl sm:text-3xl font-bold
                                        @if (session('kondisi_rumah') == 'rumah_buruk') text-red-500
                                        @elseif (session('kondisi_rumah') == 'rumah_sedang') text-yellow-500
                                        @elseif (session('kondisi_rumah') == 'rumah_baik') text-green-500
                                        @else text-gray-400 @endif">

                                        @if (session('kondisi_rumah') == 'bukan_rumah' || !session('kondisi_rumah'))
                                            Bukan Rumah
                                        @else
                                            {{ ucwords(str_replace('_', ' ', session('kondisi_rumah'))) }}
                                        @endif
                                    </h2>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-500">Skor Kelayakan</p>
                                        <p class="text-lg font-bold
                                            @if ((session('skor_kelayakan') ?? 0) * 100 < 50) text-red-600
                                            @else text-green-600 @endif">
                                            {{ number_format((session('skor_kelayakan') ?? 0) * 100, 1) }}%
                                        </p>
                                    </div>
                                    <div class="mt-2 h-3 overflow-hidden rounded-full bg-gray-100">
                                        <div class="h-full rounded-full
                                            @if ((session('skor_kelayakan') ?? 0) * 100 < 50) bg-red-500
                                            @else bg-green-500 @endif"
                                            style="width: {{ (session('skor_kelayakan') ?? 0) * 100 }}%">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-center rounded-xl bg-gray-50 p-3">
                                    <span class="rounded-full px-4 py-2 text-sm font-semibold
                                        @if (session('status') == 'ditolak') bg-red-100 text-red-700
                                        @elseif(session('status') == 'dipertimbangkan') bg-yellow-100 text-yellow-700
                                        @else bg-green-100 text-green-700 @endif">
                                        {{ ucwords(str_replace('_', ' ', session('status'))) }}
                                    </span>
                                </div>

                                @if (session('alasan') && count(session('alasan')) > 0)
                                    <div class="rounded-xl bg-gray-50 p-4 space-y-2">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Alasan Skor Kelayakan</p>
                                        @foreach (session('alasan') as $item)
                                            <div class="flex items-start gap-2 text-sm">
                                                @if ($item['positif'] === true)
                                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs font-bold">✓</span>
                                                    <span class="text-green-700">{{ $item['teks'] }}</span>
                                                @elseif ($item['positif'] === false)
                                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-500 text-xs font-bold">✗</span>
                                                    <span class="text-red-600">{{ $item['teks'] }}</span>
                                                @else
                                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-yellow-100 text-yellow-600 text-xs font-bold">~</span>
                                                    <span class="text-yellow-700">{{ $item['teks'] }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="border-t border-gray-100 pt-3">
                                    <p class="text-xs text-gray-400">
                                        Penilaian dilakukan pada: {{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y - H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="p-8 sm:p-10 text-center">
                                <div class="text-5xl">🏠</div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-800">Belum Ada Hasil Penilaian</h3>
                                <p class="mt-2 text-sm text-gray-500">Scan QR warga dan unggah foto rumah untuk melakukan penilaian kelayakan bantuan sosial.</p>
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
            fetch('/api/scan/' + decodedText)
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        const w = res.data;
                        document.getElementById('wargaCard')?.classList.remove('hidden');
                        document.getElementById('formPengajuan')?.classList.remove('hidden');
                        document.getElementById('nik').innerText = w.nik;
                        document.getElementById('nama').innerText = w.nama;
                        document.getElementById('penghasilan').value = 'Rp ' + Number(w.penghasilan).toLocaleString('id-ID');
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
            qrbox: { width: Math.min(250, window.innerWidth - 80), height: Math.min(250, window.innerWidth - 80) }
        });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
    <script>
        const input = document.getElementById('foto_rumah');
        const preview = document.getElementById('preview');
        const fileName = document.getElementById('fileName');
        const dropArea = document.getElementById('dropArea');
        const btnAjukan = document.getElementById('btnAjukan');

        function handleFile(file) {
            if (!file) return;
            fileName.textContent = file.name;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            btnAjukan.disabled = false;
        }

        input.addEventListener('change', e => handleFile(e.target.files[0]));

        ['dragenter', 'dragover'].forEach(ev => {
            dropArea.addEventListener(ev, e => {
                e.preventDefault();
                dropArea.classList.add('border-green-500', 'bg-green-50');
            });
        });

        ['dragleave', 'drop'].forEach(ev => {
            dropArea.addEventListener(ev, e => {
                e.preventDefault();
                dropArea.classList.remove('border-green-500', 'bg-green-50');
            });
        });

        dropArea.addEventListener('drop', e => {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length) { input.files = files; handleFile(files[0]); }
        });
    </script>
</x-app-layout>
