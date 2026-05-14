<x-app-layout>
    <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Warga</h2>
            <p class="text-sm text-gray-500">Tambahkan data warga baru ke sistem.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <div class="flex items-center justify-between gap-4">
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-gray-900">Form Tambah Warga</h3>
                            <p class="text-sm text-gray-500">Isi semua field untuk menyimpan data warga baru.</p>
                        </div>
                        <a href="{{ route('warga.index') }}" class="inline-flex items-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                            ← Kembali
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('warga.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input id="nik" name="nik" type="text" value="{{ old('nik') }}" placeholder="Masukkan NIK" class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" autofocus>
                            @error('nik') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Masukkan nama" class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            @error('nama') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="4" placeholder="cth: Cipayung, Depok" class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('alamat') }}</textarea>
                            <p id="alamatStatus" class="mt-2 text-sm text-gray-500 hidden"></p>
                            @error('alamat') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('warga.index') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const alamatInput = document.getElementById('alamat');
        const alamatStatus = document.getElementById('alamatStatus');
        const submitButton = document.querySelector('button[type="submit"]');

        if (alamatInput) {
            alamatInput.addEventListener('change', function () {
                const alamat = this.value;
                alamatStatus.classList.remove('hidden', 'text-green-600', 'text-red-600');

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(alamat)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            const lokasi = data[0];
                            document.getElementById('latitude').value = lokasi.lat;
                            document.getElementById('longitude').value = lokasi.lon;
                            alamatStatus.textContent = '✅ Alamat ditemukan';
                            alamatStatus.classList.add('text-green-600');
                            submitButton.disabled = false;
                        } else {
                            document.getElementById('latitude').value = '';
                            document.getElementById('longitude').value = '';
                            alamatStatus.textContent = '❌ Alamat tidak ditemukan';
                            alamatStatus.classList.add('text-red-600');
                            submitButton.disabled = true;
                        }
                    });
            });
        }
    </script>
</x-app-layout>
