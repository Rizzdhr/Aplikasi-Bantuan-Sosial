<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200 space-y-5">

                    {{-- Header --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-gray-900">Form Tambah Warga</h3>
                            <p class="text-sm text-gray-500">Isi semua field untuk menyimpan data warga baru.</p>
                        </div>
                        <a href="{{ route('warga.index') }}"
                            class="shrink-0 inline-flex items-center rounded-lg bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                            ← Kembali
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('warga.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <input id="provinsi" name="provinsi" type="text" value="{{ old('provinsi') }}"
                                    placeholder="cth: Aceh"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('provinsi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input id="nik" name="nik" type="text" value="{{ old('nik') }}"
                                    placeholder="Masukkan NIK (16 digit angka)"
                                    maxlength="16"
                                    inputmode="numeric"
                                    pattern="[0-9]{16}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('nik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input id="nama" name="nama" type="text" value="{{ old('nama') }}"
                                    placeholder="Masukkan nama"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input id="tempat_lahir" name="tempat_lahir" type="text"
                                    value="{{ old('tempat_lahir') }}" placeholder="cth: Banda Aceh"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('tempat_lahir')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input id="tanggal_lahir" name="tanggal_lahir" type="date"
                                    value="{{ old('tanggal_lahir') }}"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('tanggal_lahir')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <input id="jenis_kelamin" name="jenis_kelamin" type="text"
                                    value="{{ old('jenis_kelamin') }}" placeholder="cth: Laki-laki"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('jenis_kelamin')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="gol_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                <input id="gol_darah" name="gol_darah" type="text" value="{{ old('gol_darah') }}"
                                    placeholder="cth: O"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('gol_darah')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="penghasilan" class="block text-sm font-medium text-gray-700">Penghasilan</label>
                                <input id="penghasilan" name="penghasilan" type="number" min="0"
                                    value="{{ old('penghasilan') }}" placeholder="cth: 500000"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('penghasilan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="3" placeholder="cth: Jl. Merdeka No.1"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('alamat') }}</textarea>
                                @error('alamat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="kel_desa" class="block text-sm font-medium text-gray-700">Kel/Desa</label>
                                <input id="kel_desa" name="kel_desa" type="text" value="{{ old('kel_desa') }}"
                                    placeholder="cth: Merdeka"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('kel_desa')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                <input id="kecamatan" name="kecamatan" type="text"
                                    value="{{ old('kecamatan') }}" placeholder="cth: Kuta Alam"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('kecamatan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                                <input id="agama" name="agama" type="text" value="{{ old('agama') }}"
                                    placeholder="cth: Islam"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('agama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="status_pernikahan" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                                <input id="status_pernikahan" name="status_pernikahan" type="text"
                                    value="{{ old('status_pernikahan') }}" placeholder="cth: Menikah"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('status_pernikahan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <select id="pekerjaan" name="pekerjaan"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <optgroup label="Tidak/Belum Bekerja">
                                        <option value="BELUM/TIDAK BEKERJA" {{ old('pekerjaan') == 'BELUM/TIDAK BEKERJA' ? 'selected' : '' }}>Belum/Tidak Bekerja</option>
                                        <option value="PELAJAR/MAHASISWA" {{ old('pekerjaan') == 'PELAJAR/MAHASISWA' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                                        <option value="IBU RUMAH TANGGA" {{ old('pekerjaan') == 'IBU RUMAH TANGGA' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                        <option value="PENSIUNAN" {{ old('pekerjaan') == 'PENSIUNAN' ? 'selected' : '' }}>Pensiunan</option>
                                    </optgroup>
                                    <optgroup label="Buruh / Pekerja Harian">
                                        <option value="BURUH HARIAN LEPAS" {{ old('pekerjaan') == 'BURUH HARIAN LEPAS' ? 'selected' : '' }}>Buruh Harian Lepas</option>
                                        <option value="BURUH TANI/PERKEBUNAN" {{ old('pekerjaan') == 'BURUH TANI/PERKEBUNAN' ? 'selected' : '' }}>Buruh Tani/Perkebunan</option>
                                        <option value="BURUH NELAYAN/PERIKANAN" {{ old('pekerjaan') == 'BURUH NELAYAN/PERIKANAN' ? 'selected' : '' }}>Buruh Nelayan/Perikanan</option>
                                        <option value="PETANI/PEKEBUN" {{ old('pekerjaan') == 'PETANI/PEKEBUN' ? 'selected' : '' }}>Petani/Pekebun</option>
                                        <option value="NELAYAN/PERIKANAN" {{ old('pekerjaan') == 'NELAYAN/PERIKANAN' ? 'selected' : '' }}>Nelayan/Perikanan</option>
                                        <option value="PETERNAK" {{ old('pekerjaan') == 'PETERNAK' ? 'selected' : '' }}>Peternak</option>
                                        <option value="TUKANG BATU" {{ old('pekerjaan') == 'TUKANG BATU' ? 'selected' : '' }}>Tukang Batu</option>
                                        <option value="TUKANG KAYU" {{ old('pekerjaan') == 'TUKANG KAYU' ? 'selected' : '' }}>Tukang Kayu</option>
                                        <option value="TUKANG OJEK" {{ old('pekerjaan') == 'TUKANG OJEK' ? 'selected' : '' }}>Tukang Ojek</option>
                                        <option value="TUKANG LISTRIK" {{ old('pekerjaan') == 'TUKANG LISTRIK' ? 'selected' : '' }}>Tukang Listrik</option>
                                        <option value="TUKANG JAHIT" {{ old('pekerjaan') == 'TUKANG JAHIT' ? 'selected' : '' }}>Tukang Jahit</option>
                                        <option value="TUKANG LAS/PANDAI BESI" {{ old('pekerjaan') == 'TUKANG LAS/PANDAI BESI' ? 'selected' : '' }}>Tukang Las/Pandai Besi</option>
                                        <option value="TUKANG CUKUR" {{ old('pekerjaan') == 'TUKANG CUKUR' ? 'selected' : '' }}>Tukang Cukur</option>
                                        <option value="TUKANG GIGI" {{ old('pekerjaan') == 'TUKANG GIGI' ? 'selected' : '' }}>Tukang Gigi</option>
                                        <option value="MEKANIK" {{ old('pekerjaan') == 'MEKANIK' ? 'selected' : '' }}>Mekanik</option>
                                        <option value="PEMBANTU RUMAH TANGGA" {{ old('pekerjaan') == 'PEMBANTU RUMAH TANGGA' ? 'selected' : '' }}>Pembantu Rumah Tangga</option>
                                    </optgroup>
                                    <optgroup label="Pegawai / Karyawan">
                                        <option value="KARYAWAN SWASTA" {{ old('pekerjaan') == 'KARYAWAN SWASTA' ? 'selected' : '' }}>Karyawan Swasta</option>
                                        <option value="KARYAWAN BUMN" {{ old('pekerjaan') == 'KARYAWAN BUMN' ? 'selected' : '' }}>Karyawan BUMN</option>
                                        <option value="KARYAWAN BUMD" {{ old('pekerjaan') == 'KARYAWAN BUMD' ? 'selected' : '' }}>Karyawan BUMD</option>
                                        <option value="KARYAWAN HONORER" {{ old('pekerjaan') == 'KARYAWAN HONORER' ? 'selected' : '' }}>Karyawan Honorer</option>
                                        <option value="PEGAWAI NEGERI" {{ old('pekerjaan') == 'PEGAWAI NEGERI' ? 'selected' : '' }}>Pegawai Negeri</option>
                                        <option value="PEGAWAI SWASTA" {{ old('pekerjaan') == 'PEGAWAI SWASTA' ? 'selected' : '' }}>Pegawai Swasta</option>
                                        <option value="TENTARA NASIONAL INDONESIA" {{ old('pekerjaan') == 'TENTARA NASIONAL INDONESIA' ? 'selected' : '' }}>Tentara Nasional Indonesia</option>
                                        <option value="KEPOLISIAN RI" {{ old('pekerjaan') == 'KEPOLISIAN RI' ? 'selected' : '' }}>Kepolisian RI</option>
                                        <option value="WIRASWASTA" {{ old('pekerjaan') == 'WIRASWASTA' ? 'selected' : '' }}>Wiraswasta</option>
                                        <option value="PERDAGANGAN" {{ old('pekerjaan') == 'PERDAGANGAN' ? 'selected' : '' }}>Perdagangan</option>
                                        <option value="TRANSPORTASI" {{ old('pekerjaan') == 'TRANSPORTASI' ? 'selected' : '' }}>Transportasi</option>
                                        <option value="INDUSTRI" {{ old('pekerjaan') == 'INDUSTRI' ? 'selected' : '' }}>Industri</option>
                                        <option value="KONSTRUKSI" {{ old('pekerjaan') == 'KONSTRUKSI' ? 'selected' : '' }}>Konstruksi</option>
                                        <option value="LAINNYA" {{ old('pekerjaan') == 'LAINNYA' ? 'selected' : '' }}>Lainnya</option>
                                    </optgroup>
                                    <optgroup label="Profesional / Tenaga Ahli">
                                        <option value="DOKTER" {{ old('pekerjaan') == 'DOKTER' ? 'selected' : '' }}>Dokter</option>
                                        <option value="DOKTER GIGI" {{ old('pekerjaan') == 'DOKTER GIGI' ? 'selected' : '' }}>Dokter Gigi</option>
                                        <option value="BIDAN" {{ old('pekerjaan') == 'BIDAN' ? 'selected' : '' }}>Bidan</option>
                                        <option value="PERAWAT" {{ old('pekerjaan') == 'PERAWAT' ? 'selected' : '' }}>Perawat</option>
                                        <option value="APOTEKER" {{ old('pekerjaan') == 'APOTEKER' ? 'selected' : '' }}>Apoteker</option>
                                        <option value="PSIKIATER/PSIKOLOG" {{ old('pekerjaan') == 'PSIKIATER/PSIKOLOG' ? 'selected' : '' }}>Psikiater/Psikolog</option>
                                        <option value="GURU/DOSEN" {{ old('pekerjaan') == 'GURU/DOSEN' ? 'selected' : '' }}>Guru/Dosen</option>
                                        <option value="PENGACARA" {{ old('pekerjaan') == 'PENGACARA' ? 'selected' : '' }}>Pengacara</option>
                                        <option value="NOTARIS" {{ old('pekerjaan') == 'NOTARIS' ? 'selected' : '' }}>Notaris</option>
                                        <option value="AKUNTAN" {{ old('pekerjaan') == 'AKUNTAN' ? 'selected' : '' }}>Akuntan</option>
                                        <option value="KONSULTAN" {{ old('pekerjaan') == 'KONSULTAN' ? 'selected' : '' }}>Konsultan</option>
                                        <option value="WARTAWAN" {{ old('pekerjaan') == 'WARTAWAN' ? 'selected' : '' }}>Wartawan</option>
                                        <option value="SENIMAN" {{ old('pekerjaan') == 'SENIMAN' ? 'selected' : '' }}>Seniman</option>
                                        <option value="USTADZ/MUBALIGH" {{ old('pekerjaan') == 'USTADZ/MUBALIGH' ? 'selected' : '' }}>Ustadz/Mubaligh</option>
                                        <option value="PASTOR" {{ old('pekerjaan') == 'PASTOR' ? 'selected' : '' }}>Pastor</option>
                                        <option value="PENDETA" {{ old('pekerjaan') == 'PENDETA' ? 'selected' : '' }}>Pendeta</option>
                                        <option value="POLITIKUS" {{ old('pekerjaan') == 'POLITIKUS' ? 'selected' : '' }}>Politikus</option>
                                        <option value="ANGGOTA DPR-RI" {{ old('pekerjaan') == 'ANGGOTA DPR-RI' ? 'selected' : '' }}>Anggota DPR-RI</option>
                                        <option value="ANGGOTA DPRD" {{ old('pekerjaan') == 'ANGGOTA DPRD' ? 'selected' : '' }}>Anggota DPRD</option>
                                        <option value="KEPALA DESA" {{ old('pekerjaan') == 'KEPALA DESA' ? 'selected' : '' }}>Kepala Desa</option>
                                        <option value="PERANGKAT DESA" {{ old('pekerjaan') == 'PERANGKAT DESA' ? 'selected' : '' }}>Perangkat Desa</option>
                                        <option value="PELAUT" {{ old('pekerjaan') == 'PELAUT' ? 'selected' : '' }}>Pelaut</option>
                                        <option value="PILOT" {{ old('pekerjaan') == 'PILOT' ? 'selected' : '' }}>Pilot</option>
                                    </optgroup>
                                    <optgroup label="Pengusaha / Pejabat Tinggi">
                                        <option value="PENELITI" {{ old('pekerjaan') == 'PENELITI' ? 'selected' : '' }}>Peneliti</option>
                                        <option value="PEJABAT NEGARA" {{ old('pekerjaan') == 'PEJABAT NEGARA' ? 'selected' : '' }}>Pejabat Negara</option>
                                        <option value="ANGGOTA BPK" {{ old('pekerjaan') == 'ANGGOTA BPK' ? 'selected' : '' }}>Anggota BPK</option>
                                        <option value="DUTA BESAR" {{ old('pekerjaan') == 'DUTA BESAR' ? 'selected' : '' }}>Duta Besar</option>
                                        <option value="GUBERNUR" {{ old('pekerjaan') == 'GUBERNUR' ? 'selected' : '' }}>Gubernur</option>
                                        <option value="BUPATI/WALIKOTA" {{ old('pekerjaan') == 'BUPATI/WALIKOTA' ? 'selected' : '' }}>Bupati/Walikota</option>
                                    </optgroup>
                                </select>
                                @error('pekerjaan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="kewarganegaraan" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                <input id="kewarganegaraan" name="kewarganegaraan" type="text"
                                    value="{{ old('kewarganegaraan', 'WNI') }}" placeholder="cth: WNI"
                                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('kewarganegaraan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                            <a href="{{ route('warga.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                Batal
                            </a>
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
