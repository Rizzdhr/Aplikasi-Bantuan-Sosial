<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <div class="flex items-center justify-between gap-4">
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-gray-900">Form Tambah Warga</h3>
                            <p class="text-sm text-gray-500">Isi semua field untuk menyimpan data warga baru.</p>
                        </div>
                        <a href="{{ route('warga.index') }}"
                            class="inline-flex items-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                            ← Kembali
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('warga.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <input id="provinsi" name="provinsi" type="text" value="{{ old('provinsi') }}" placeholder="cth: Aceh"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('provinsi')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input id="nik" name="nik" type="text" value="{{ old('nik') }}" placeholder="Masukkan NIK"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('nik')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Masukkan nama"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('nama')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input id="tempat_lahir" name="tempat_lahir" type="text" value="{{ old('tempat_lahir') }}" placeholder="cth: Banda Aceh"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('tempat_lahir')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('tanggal_lahir')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <input id="jenis_kelamin" name="jenis_kelamin" type="text" value="{{ old('jenis_kelamin') }}" placeholder="cth: Laki-laki"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('jenis_kelamin')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gol_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                <input id="gol_darah" name="gol_darah" type="text" value="{{ old('gol_darah') }}" placeholder="cth: O"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('gol_darah')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="penghasilan" class="block text-sm font-medium text-gray-700">Penghasilan</label>
                                <input id="penghasilan" name="penghasilan" type="number" min="0" value="{{ old('penghasilan') }}" placeholder="cth: 500000"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('penghasilan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="3" placeholder="cth: Jl. Merdeka No.1"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kel_desa" class="block text-sm font-medium text-gray-700">Kel/Desa</label>
                                <input id="kel_desa" name="kel_desa" type="text" value="{{ old('kel_desa') }}" placeholder="cth: Merdeka"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('kel_desa')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                <input id="kecamatan" name="kecamatan" type="text" value="{{ old('kecamatan') }}" placeholder="cth: Kuta Alam"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('kecamatan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                                <input id="agama" name="agama" type="text" value="{{ old('agama') }}" placeholder="cth: Islam"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('agama')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status_pernikahan" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                                <input id="status_pernikahan" name="status_pernikahan" type="text" value="{{ old('status_pernikahan') }}" placeholder="cth: Menikah"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('status_pernikahan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <input id="pekerjaan" name="pekerjaan" type="text" value="{{ old('pekerjaan') }}" placeholder="cth: PETANI/PEKEBUN"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('pekerjaan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kewarganegaraan" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                <input id="kewarganegaraan" name="kewarganegaraan" type="text" value="{{ old('kewarganegaraan', 'WNI') }}" placeholder="cth: WNI"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('kewarganegaraan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('warga.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
