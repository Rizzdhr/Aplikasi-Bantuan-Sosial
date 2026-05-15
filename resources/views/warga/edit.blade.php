<x-app-layout>
    <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Warga
            </h2>

            <p class="text-sm text-gray-500">
                Perbarui data warga untuk informasi yang akurat.
            </p>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200 space-y-6">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between gap-4">

                        <div class="space-y-1">

                            <h3 class="text-lg font-semibold text-gray-900">
                                Form Edit Warga
                            </h3>

                            <p class="text-sm text-gray-500">
                                Perbarui detail warga yang sudah terdaftar.
                            </p>

                        </div>

                        <a href="{{ route('warga.index') }}"
                           class="inline-flex items-center rounded-lg
                                  bg-gray-100 px-4 py-2 text-sm
                                  font-semibold text-gray-700
                                  hover:bg-gray-200">

                            ← Kembali

                        </a>

                    </div>

                    <!-- SUCCESS -->
                    @if(session('success'))

                        <div class="rounded-2xl bg-green-50
                                    border border-green-200
                                    p-4 text-sm text-green-700">

                            {{ session('success') }}

                        </div>

                    @endif

                    <!-- FORM -->
                    <form action="{{ route('warga.update', $warga->id) }}"
                          method="POST"
                          class="space-y-6">

                        @csrf
                        @method('PUT')

                        <!-- NIK -->
                        <div>

                            <label for="nik"
                                   class="block text-sm
                                          font-medium text-gray-700">

                                NIK

                            </label>

                            <input
                                id="nik"
                                name="nik"
                                type="text"
                                value="{{ old('nik', $warga->nik) }}"
                                class="mt-1 block w-full rounded-xl
                                       border border-gray-300 bg-white
                                       px-4 py-2 text-sm text-gray-900
                                       shadow-sm focus:border-blue-500
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-100">

                            @error('nik')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        <!-- NAMA -->
                        <div>

                            <label for="nama"
                                   class="block text-sm
                                          font-medium text-gray-700">

                                Nama

                            </label>

                            <input
                                id="nama"
                                name="nama"
                                type="text"
                                value="{{ old('nama', $warga->nama) }}"
                                class="mt-1 block w-full rounded-xl
                                       border border-gray-300 bg-white
                                       px-4 py-2 text-sm text-gray-900
                                       shadow-sm focus:border-blue-500
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-100">

                            @error('nama')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        <!-- ALAMAT -->
                        <div>

                            <label for="alamat"
                                   class="block text-sm
                                          font-medium text-gray-700">

                                Alamat Lengkap

                            </label>

                            <textarea
                                id="alamat"
                                name="alamat"
                                rows="3"
                                class="mt-1 block w-full rounded-xl
                                       border border-gray-300 bg-white
                                       px-4 py-2 text-sm text-gray-900
                                       shadow-sm focus:border-blue-500
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-100">{{ old('alamat', $warga->alamat) }}</textarea>

                            @error('alamat')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        <!-- KECAMATAN -->
                        <div>

                            <label for="kecamatan"
                                   class="block text-sm
                                          font-medium text-gray-700">

                                Kecamatan

                            </label>

                            <input
                                id="kecamatan"
                                name="kecamatan"
                                type="text"
                                value="{{ old('kecamatan', $warga->kecamatan) }}"
                                placeholder="cth: Cipayung"
                                class="mt-1 block w-full rounded-xl
                                       border border-gray-300 bg-white
                                       px-4 py-2 text-sm text-gray-900
                                       shadow-sm focus:border-blue-500
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-100">

                            @error('kecamatan')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        <!-- KOTA -->
                        <div>

                            <label for="kota"
                                   class="block text-sm
                                          font-medium text-gray-700">

                                Kota

                            </label>

                            <input
                                id="kota"
                                name="kota"
                                type="text"
                                value="{{ old('kota', $warga->kota) }}"
                                placeholder="cth: Depok"
                                class="mt-1 block w-full rounded-xl
                                       border border-gray-300 bg-white
                                       px-4 py-2 text-sm text-gray-900
                                       shadow-sm focus:border-blue-500
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-100">

                            @error('kota')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        <!-- STATUS VALIDASI -->
                        <p id="lokasiStatus"
                           class="mt-2 text-sm hidden">
                        </p>

                        <!-- HIDDEN -->
                        <input type="hidden"
                               name="latitude"
                               id="latitude">

                        <input type="hidden"
                               name="longitude"
                               id="longitude">

                        <!-- BUTTON -->
                        <div class="flex flex-col gap-3
                                    sm:flex-row sm:justify-end">

                            <a href="{{ route('warga.index') }}"
                               class="inline-flex items-center
                                      justify-center rounded-xl
                                      border border-gray-300
                                      bg-white px-4 py-2 text-sm
                                      font-semibold text-gray-700
                                      hover:bg-gray-50">

                                Batal

                            </a>

                            <button
                                type="submit"
                                id="submitButton"
                                class="inline-flex items-center
                                       justify-center rounded-xl
                                       bg-green-600 px-4 py-2
                                       text-sm font-semibold
                                       text-white shadow-sm
                                       hover:bg-green-700">

                                Update

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPT VALIDASI -->
    <script>

        const kecamatanInput =
            document.getElementById('kecamatan');

        const kotaInput =
            document.getElementById('kota');

        const lokasiStatus =
            document.getElementById('lokasiStatus');

        function validasiLokasi()
        {
            const kecamatan =
                kecamatanInput.value.trim();

            const kota =
                kotaInput.value.trim();

            if(!kecamatan || !kota)
            {
                lokasiStatus.classList.add('hidden');

                return;
            }

            const query =
                `${kecamatan}, ${kota}, Indonesia`;

            lokasiStatus.classList.remove(
                'hidden',
                'text-green-600',
                'text-red-600'
            );

            lokasiStatus.classList.add(
                'text-gray-500'
            );

            lokasiStatus.innerHTML =
                '⏳ Memvalidasi area lokasi...';

            fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
            )

            .then(response => response.json())

            .then(data => {

                if(data.length > 0)
                {
                    const lokasi = data[0];

                    document.getElementById('latitude').value =
                        lokasi.lat;

                    document.getElementById('longitude').value =
                        lokasi.lon;

                    lokasiStatus.classList.remove(
                        'text-gray-500',
                        'text-red-600'
                    );

                    lokasiStatus.classList.add(
                        'text-green-600'
                    );

                    lokasiStatus.innerHTML =
                        '✅ Area lokasi ditemukan';
                }
                else
                {
                    lokasiStatus.classList.remove(
                        'text-gray-500',
                        'text-green-600'
                    );

                    lokasiStatus.classList.add(
                        'text-red-600'
                    );

                    lokasiStatus.innerHTML =
                        '❌ Area lokasi tidak ditemukan';
                }

            })

            .catch(error => {

                lokasiStatus.classList.remove(
                    'text-gray-500',
                    'text-green-600'
                );

                lokasiStatus.classList.add(
                    'text-red-600'
                );

                lokasiStatus.innerHTML =
                    '❌ Gagal memvalidasi lokasi';

            });
        }

        kecamatanInput.addEventListener(
            'keyup',
            validasiLokasi
        );

        kotaInput.addEventListener(
            'keyup',
            validasiLokasi
        );

    </script>

</x-app-layout>
