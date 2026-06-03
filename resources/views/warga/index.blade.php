<x-app-layout>
    {{-- <x-slot name="header">
        <div class="space-y-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Warga</h2>
            <p class="text-sm text-gray-500">Kelola data warga, lihat detail, dan lakukan edit atau hapus.</p>
        </div>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <form method="GET" action="{{ route('warga.index') }}"
                                class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari NIK / Nama..."
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 sm:w-80">
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                    Cari
                                </button>
                            </form>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <form action="{{ route('warga.import') }}" method="POST" enctype="multipart/form-data"
                                class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                @csrf
                                <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm hover:border-blue-500">
                                    <span>Pilih CSV/XLSX</span>
                                    <input type="file" name="import_file" accept=".csv,.xls,.xlsx" class="hidden">
                                </label>
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition">
                                    Import
                                </button>
                            </form>

                            <a href="{{ route('warga.create') }}"
                                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                + Tambah Warga
                            </a>
                        </div>
                    </div>

                    @if ($errors->has('import_file'))
                        <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                            {{ $errors->first('import_file') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-hidden rounded-2xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide text-xs">
                                <tr>
                                    <th class="px-4 py-3 text-left">NIK</th>
                                    <th class="px-4 py-3 text-left">Nama</th>
                                    <th class="px-4 py-3 text-left">Usia</th>
                                    <th class="px-4 py-3 text-left">Pekerjaan</th>
                                    <th class="px-4 py-3 text-left">Penghasilan</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($wargas as $w)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 font-medium text-gray-700">{{ $w->nik }}</td>
                                        <td class="px-4 py-4 text-gray-700">{{ $w->nama }}</td>
                                        <td class="px-4 py-4 text-gray-600">{{ $w->usia }}</td>
                                        <td class="px-4 py-4 text-gray-600">{{ $w->pekerjaan }}</td>
                                        <td class="px-4 py-4 text-gray-600">Rp
                                            {{ number_format($w->penghasilan, 0, ',', '.') }}</td>
                                        <td class="px-4 py-4 text-center space-x-2">
                                            <a href="{{ route('warga.show', $w->id) }}"
                                                class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-200">Detail</a>
                                            <a href="{{ route('warga.edit', $w->id) }}"
                                                class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700 hover:bg-yellow-200">Edit</a>
                                            <form action="{{ route('warga.destroy', $w->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-200">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-gray-500">Data warga belum
                                            tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $wargas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
