<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">
                    Data Bantuan Sosial
                </h1>
                <a href="{{ route('bantuan.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    + Tambah Bantuan
                </a>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                @forelse($bantuans as $bantuan)
                    <div class="border-b py-3">
                        <h2 class="font-semibold">
                        {{ $bantuan->nama_bantuan }}
                        </h2>
                        <p class="text-sm text-gray-500">
                        {{ $bantuan->deskripsi }}
                    </p>
                    <div class="mt-3">
                  <div class="mt-3 flex gap-2">
                        <a href="{{ route('bantuan.showQr', $bantuan->id) }}"
                            target="_blank"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                            Lihat QR
                        </a>
                        <a href="{{ route('bantuan.downloadQr', $bantuan->id) }}"
                            download
                            class="bg-indigo-600 text-white px-4 py-2 rounded">
                            Download QR
                        </a>
                        <form
                            action="{{ route('bantuan.distribusi', $bantuan->id) }}"
                            method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded">
                                Distribusikan Bantuan
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                    <p class="text-gray-500">
                        Belum ada data bantuan sosial.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>