<x-app-layout>
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- AREA YANG MUNCUL SETELAH SCAN --}}
        <div id="pengajuanArea">
            {{-- DATA WARGA --}}
            <div class="bg-white shadow rounded-xl p-4 mb-6">
                <h3 class="font-bold text-lg mb-4">
                    Data Warga{{-- PANEL AI --}}
                </h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-gray-100 p-3 rounded">
                        <small class="text-gray-500">NIK</small>
                        <p class="font-semibold">
                            {{ $warga->nik }}
                        </p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded">
                        <small class="text-gray-500">Nama</small>
                        <p class="font-semibold">
                            {{ $warga->nama }}
                        </p>
                    </div>
                </div>
            </div>
            {{-- FORM + PANEL AI --}}
            <div class="grid lg:grid-cols-3 gap-6">
                {{-- FORM --}}
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-xl font-bold mb-4">
                            Form Pengajuan
                        </h3>
                        <form
                            method="POST"
                            action="{{ route('warga.pengajuan.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="kondisi_rumah" id="inputKondisiRumah">
                            <input type="hidden" name="skor_kelayakan" id="inputSkorKelayakan">
                            <div class="grid md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label>Penghasilan</label>
                                    <input
                                        type="text"
                                        readonly
                                        value="Rp {{ number_format($warga->penghasilan,0,',','.') }}"
                                        class="w-full border rounded p-2 bg-gray-100">
                                </div>
                                <div>
                                    <label>Usia</label>
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $warga->usia }}"
                                        class="w-full border rounded p-2 bg-gray-100">
                                </div>
                                <div>
                                    <label>Pekerjaan</label>
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $warga->pekerjaan }}"
                                        class="w-full border rounded p-2 bg-gray-100">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="font-semibold">
                                    Upload Foto Rumah
                                </label>
                                <input
                                    type="file"
                                    id="foto_rumah"
                                    name="foto_rumah"
                                    class="w-full border rounded p-3"
                                    required>
                            </div>
                            <img
                                id="previewFoto"
                                class="hidden rounded-lg border w-full mb-4">
                                <button
                                    type="button"
                                    id="btnAnalisis"
                                    class="w-full bg-blue-600 text-white py-3 rounded-lg mb-3">
                                    Analisis AI
                                </button>
                            <button
                            type="submit"
                            id="btnSubmit"
                            disabled
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold disabled:opacity-50">
                            Ajukan Bantuan
                            </button>
                        </form>
                    </div>
                </div>
                {{-- PANEL AI --}}
<div>
    <div class="bg-white shadow rounded-2xl overflow-hidden">

        <div class="border-b px-6 py-4">
            <h3 class="font-bold">
                Hasil Penilaian Kelayakan
            </h3>
        </div>
        {{-- TAMPILAN AWAL --}}
                        <div
                            id="aiKosong"
                            class="p-8 text-center">
                            <div class="text-6xl mb-4">
                                🏠
                            </div>
                            <h4 class="font-bold text-xl">
                                Belum Ada Hasil Penilaian
                            </h4>
                            <p class="text-gray-500 mt-3">
                                Upload foto rumah lalu klik Analisis AI.
                            </p>
                        </div>
                        {{-- HASIL AI --}}
                        <div
                            id="aiResult"
                            class="hidden p-6">
                            <img
                                id="fotoRumahAI"
                                class="rounded-xl w-full h-64 object-cover mb-4">
                            <p class="text-gray-500 mb-1">
                                Kategori Rumah
                            </p>
                            <h3
                                id="kategoriRumah"
                                class="text-4xl font-bold text-yellow-500 mb-6">
                                Rumah Sedang
                            </h3>
                            <div class="flex justify-between mb-2">
                                <span>
                                    Skor Kelayakan
                                </span>
                                <span
                                    id="skorAI"
                                    class="font-bold text-green-600">
                                    95%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 mb-6">
                                <div
                                    id="progressAI"
                                    class="bg-green-500 h-4 rounded-full"
                                    style="width:0%">
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-xl p-6 text-center mb-6">
                                <span
                                    id="statusAI"
                                    class="px-6 py-2 rounded-full bg-green-100 text-green-700 font-bold">
                                    Layak
                                </span>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-5">
                                <h4 class="font-bold mb-4">
                                    Alasan Skor Kelayakan
                                </h4>
                                <div id="alasanAI"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


document
.getElementById('foto_rumah')
.addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file)
    {
        const reader = new FileReader();

        reader.onload = function(event)
        {
            const preview =
            document.getElementById('previewFoto');

            preview.src =
            event.target.result;

            preview.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }

});

document
.getElementById('btnAnalisis')
.addEventListener('click', async function(){
    const file =
    document.getElementById('foto_rumah')
    .files[0];
    if(!file)
    {
        Swal.fire(
            'Error',
            'Pilih foto rumah terlebih dahulu',
            'error'
        );
        return;
    }
    const formData =
    new FormData();
    formData.append(
        'foto_rumah',
        file
    );
    formData.append(
        '_token',
        '{{ csrf_token() }}'
    );
    Swal.fire({
        title: 'Menganalisis AI...',
        text: 'Mohon tunggu',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    try
    {
        const response =
        await fetch(
            "{{ route('warga.analisisAI') }}",
            {
                method: 'POST',
                body: formData
            }
        );
        const data =
        await response.json();
        Swal.close();
        document
        .getElementById('aiKosong')
        .classList.add('hidden');
        document
        .getElementById('aiResult')
        .classList.remove('hidden');
        document
        .getElementById('fotoRumahAI')
        .src =
        document.getElementById('previewFoto')
        .src;
        document
        .getElementById('kategoriRumah')
        .innerText =
        data.kondisi_rumah;
        document.getElementById('inputKondisiRumah').value =
        data.kondisi_rumah;
        document.getElementById('inputSkorKelayakan').value =   
        data.skor;
        document
        .getElementById('skorAI')
        .innerText =
        data.skor + '%';
        document
        .getElementById('progressAI')
        .style.width =
        data.skor + '%';
        document
        .getElementById('statusAI')
        .innerText =
        data.status;
        document
        .getElementById('btnSubmit')
        .disabled = false;
        
        let html = '';
        data.alasan.forEach(item => {
            html += `
                <div class="mb-2">
                    ${item.icon}
                    ${item.teks}
                </div>
            `;
        });
        document
        .getElementById('alasanAI')
        .innerHTML =
        html;
    }
    catch(error)
    {
        console.log(error);
        Swal.fire(
            'Error',
            'Gagal mengambil hasil AI',
            'error'
        );
    }
});
function tampilkanNotif(pesan, tipe)
{
    const box =
    document.getElementById('notifBox');
    const content =
    document.getElementById('notifContent');
    content.innerText = pesan;
    if(tipe === 'success')
    {
        content.className =
        'px-6 py-4 rounded-xl shadow-xl bg-green-600 text-white font-semibold';
    }
    if(tipe === 'error')
    {
        content.className =
        'px-6 py-4 rounded-xl shadow-xl bg-red-600 text-white font-semibold';
    }
    box.classList.remove('hidden');

    setTimeout(() => {
        box.classList.add('hidden');
    }, 3000);
}

</script>
<div
    id="notifBox"
    class="hidden fixed top-5 right-5 z-50">

    <div
        id="notifContent"
        class="px-6 py-4 rounded-xl shadow-xl text-white font-semibold">
    </div>

</div>
</x-app-layout>