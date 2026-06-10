<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200 space-y-5">

                    {{-- TOP BAR: Search + Actions --}}
                    <div class="flex flex-col gap-3">

                        {{-- Search --}}
                        <form method="GET" action="{{ route('warga.index') }}"
                            class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari NIK / Nama..."
                                class="flex-1 min-w-0 rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <button type="submit"
                                class="shrink-0 inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                Cari
                            </button>
                        </form>

                        {{-- Import + Tambah --}}
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('warga.import') }}" method="POST"
                                    enctype="multipart/form-data"
                                    class="flex gap-2 flex-1 min-w-0">
                                    @csrf
                                   <input
                                        type="file"
                                        name="import_file"
                                        accept=".csv,.xls,.xlsx"
                                        class="border p-2">
                                    <button type="submit"
                                        class="shrink-0 inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition">
                                        Import
                                    </button>
                                </form>

                                <a href="{{ route('warga.create') }}"
                                    class="shrink-0 inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                    + Tambah Warga
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Alerts --}}
                    @if ($errors->has('import_file'))
                        <div class="rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                            {{ $errors->first('import_file') }}
                        </div>
                    @endif
                    @if (session('import_errors'))
                        <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-4 text-sm text-yellow-800">
                            <p class="font-semibold mb-2">Beberapa baris dilewati:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach (session('import_errors') as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- TABLE: desktop only --}}
                   <div class="overflow-hidden rounded-2xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide text-xs">
                                <tr>
                                    <th class="px-4 py-3 text-left">NIK</th>
                                    <th class="px-4 py-3 text-left">Nama</th>
                                    <th class="px-4 py-3 text-left">Email</th>
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
                                        <td class="px-4 py-4 text-gray-600">{{ $w->email ?? '-' }}</td>
                                        <td class="px-4 py-4 text-gray-600">{{ $w->usia }}</td>
                                        <td class="px-4 py-4 text-gray-600">{{ $w->pekerjaan }}</td>
                                        <td class="px-4 py-4 text-gray-600">Rp {{ number_format($w->penghasilan, 0, ',', '.') }}</td>
                                        <td class="px-4 py-4 text-center space-x-2">
                                            <a href="{{ route('warga.show', $w->id) }}"
                                                class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-200">Detail</a>
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('warga.edit', $w->id) }}"
                                                    class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700 hover:bg-yellow-200">Edit</a>
                                                <form action="{{ route('warga.destroy', $w->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-200">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-gray-500">Data warga belum tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- CARD LIST: mobile only --}}
                    <div class="hidden space-y-3">
                        @forelse($wargas as $w)
                            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm space-y-3">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="text-base font-semibold text-gray-800">{{ $w->nama }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">NIK: {{ $w->nik }}</p>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600">
                                        {{ $w->usia }} thn
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                                    <div>
                                        <p class="text-xs text-gray-400">Pekerjaan</p>
                                        <p class="text-gray-700">{{ $w->pekerjaan }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Penghasilan</p>
                                        <p class="text-gray-700">Rp {{ number_format($w->penghasilan, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="flex gap-2 pt-1 border-t border-gray-100">
                                    <a href="{{ route('warga.show', $w->id) }}"
                                        class="flex-1 text-center rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100">Detail</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('warga.edit', $w->id) }}"
                                            class="flex-1 text-center rounded-lg bg-yellow-50 px-3 py-1.5 text-xs font-semibold text-yellow-700 hover:bg-yellow-100">Edit</a>
                                        <form action="{{ route('warga.destroy', $w->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-gray-200 bg-white p-10 text-center text-sm text-gray-500">
                                Data warga belum tersedia
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $wargas->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
