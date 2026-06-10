<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded shadow">
                        <h2 class="text-2xl font-bold mb-2">
                            {{ $penerima->bantuan->nama_bantuan }}
                        </h2>
                        <p class="text-gray-600 mb-6">
                            Arahkan kamera ke QR Code yang ditampilkan petugas.
                        </p>
                        <div id="reader"></div>
                    </div>
                </div>
                <div>
                    <div class="bg-white p-6 rounded shadow">
                        <h3 class="font-bold text-lg mb-4">
                            Status Bantuan
                        </h3>
                        <p>
                            {{ $penerima->status }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            (decodedText) => {
                alert("QR berhasil dibaca : " + decodedText);
            }
        );
    </script>
</x-app-layout>