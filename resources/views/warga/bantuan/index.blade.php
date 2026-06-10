<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- KIRI --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- BANTUAN AKTIF --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-2xl font-bold mb-6">
                            Pengambilan Bantuan Sosial
                        </h2>
                        @forelse($data as $item)
                            <div class="bg-gray-50 rounded-lg p-5 border">
                                <h3 class="text-xl font-semibold">
                                    {{ $item->bantuan->nama_bantuan }}
                                </h3>
                                <p class="text-gray-600 mt-2">
                                    {{ $item->bantuan->deskripsi }}
                                </p>
                                <div class="mt-4">
                                    @if($item->status == 'sudah_menerima')
                                        <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded">
                                            Sudah Menerima Bantuan
                                        </span>
                                    @else
                                        <span class="inline-block bg-yellow-100 text-yellow-700 px-4 py-2 rounded">
                                            Menunggu Pengambilan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-500">
                                Belum ada bantuan yang tersedia.
                            </div>
                        @endforelse
                    </div>
                    {{-- SCANNER QR --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="text-2xl font-bold">
                            Scan QR Bantuan
                        </h3>
                        <p class="text-gray-500 mt-2 mb-6">
                            Arahkan kamera ke QR Code yang ditampilkan petugas.
                        </p>
                        <div
                            id="reader"
                            style="width:100%; min-height:350px;">
                        </div>                   
                    </div>
                </div>
                {{-- KANAN --}}
                <div>
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-6 border-b">
                            <h3 class="text-2xl font-bold">
                                Status Bantuan
                            </h3>
                            <p class="text-gray-500 mt-2">
                                Informasi bantuan sosial Anda.
                            </p>
                        </div>
                        <div class="p-8 text-center">
                            @php
                                $bantuanAktif = $data->first();
                            @endphp
                            @if($bantuanAktif)
                                @if($bantuanAktif->status == 'sudah_menerima')
                                    <div class="text-6xl mb-4">
                                        ✅
                                    </div>
                                    <h4 class="text-xl font-bold text-green-600">
                                        Bantuan Sudah Diterima
                                    </h4>
                                    <p class="text-gray-500 mt-2">
                                        Terima kasih telah melakukan pengambilan bantuan.
                                    </p>
                                @else
                                    <div class="text-6xl mb-4">
                                        📦
                                    </div>
                                    <h4 class="text-xl font-bold text-yellow-600">
                                        Menunggu Pengambilan
                                    </h4>
                                    <p class="text-gray-500 mt-2">
                                        Silakan scan QR dari petugas untuk menerima bantuan.
                                    </p>
                                @endif
                            @else
                                <div class="text-6xl mb-4">
                                    📦
                                </div>
                                <h4 class="text-xl font-bold">
                                    Belum Ada Bantuan
                                </h4>
                                <p class="text-gray-500 mt-2">
                                    Anda belum terdaftar sebagai penerima bantuan.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- QR Scanner --}}
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
function onScanSuccess(decodedText)
{
    fetch(
        "{{ route('warga.bantuan.scan') }}",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                token: decodedText
            })
        }
    )
    .then(res => res.json())
    .then(data => {

        if(data.success){

            Swal.fire({
                icon: 'success',
                title: 'Bantuan Berhasil Diterima',
                html: `
                    <b>${data.bantuan}</b><br>
                    ${data.tanggal}
                `,
                confirmButtonText: 'OK'
            }).then(() => {

                location.reload();

            });

        }else{

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message
            });

        }

    })
    .catch(error => {

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan sistem'
        });

        console.log(error);

    });
}
const scanner = new Html5QrcodeScanner(
    "reader",
    {
        fps: 10,
        qrbox: 250
    }
);
scanner.render(onScanSuccess);
</script>
</x-app-layout>