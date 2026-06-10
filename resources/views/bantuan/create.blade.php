<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Tambah Bantuan Sosial
                </h1>

                <form action="{{ route('bantuan.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Bantuan
                        </label>

                        <input
                            type="text"
                            name="nama_bantuan"
                            class="w-full border rounded-lg p-3"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            rows="4"
                            class="w-full border rounded-lg p-3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nominal Bantuan
                        </label>

                        <input
                            type="number"
                            name="nominal"
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="block mb-2 font-medium">
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                name="tanggal_mulai"
                                class="w-full border rounded-lg p-3"
                                required>
                        </div>

                        <div>
                            <label class="block mb-2 font-medium">
                                Tanggal Selesai
                            </label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                class="w-full border rounded-lg p-3"
                                required>
                        </div>

                    </div>

                    <div class="mt-6">
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-5 py-3 rounded-lg">

                            Simpan Bantuan
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>