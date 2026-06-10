<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-4">
            Tambah Penerima Bantuan
        </h1>

        <form action="{{ route('penerima-bantuan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">
                    Pilih Bantuan
                </label>

                <select
                    name="bantuan_id"
                    class="border rounded w-full p-2"
                >
                    @foreach($bantuans as $bantuan)
                        <option value="{{ $bantuan->id }}">
                            {{ $bantuan->nama_bantuan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">
                    Pilih Warga
                </label>

                <select
                    name="warga_id"
                    class="border rounded w-full p-2"
                >
                    @foreach($wargas as $warga)
                        <option value="{{ $warga->id }}">
                            {{ $warga->nik }} - {{ $warga->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded"
            >
                Simpan
            </button>

        </form>

    </div>
</x-app-layout>
