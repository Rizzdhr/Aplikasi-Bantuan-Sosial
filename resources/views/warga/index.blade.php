@extends('layouts.main')
@section('judul', 'Data Warga')

@section('content')

<div class="space-y-4">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-700">Data Warga</h2>


        <a href="{{ route('warga.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            + Tambah Warga
        </a>
    </div>

    <form method="GET" action="{{ route('warga.index') }}" class="flex gap-2">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari NIK / Nama..."
            class="border p-2 rounded-lg w-64"
        >

        <button class="bg-blue-500 text-white px-4 rounded-lg">
            Cari
        </button>
    </form>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full text-sm text-left">



            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-4">NIK</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Alamat</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($wargas as $w)
                <tr class="hover:bg-gray-50">

                    <td class="p-4 font-medium text-gray-700">
                        {{ $w->nik }}
                    </td>

                    <td class="p-4">
                        {{ $w->nama }}
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ $w->alamat }}
                    </td>

                    <td class="p-4 text-center space-x-1">

                        <a href="{{ route('warga.show', $w->id) }}"
                           class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-xs">
                            Detail
                        </a>

                        <a href="{{ route('warga.edit', $w->id) }}"
                           class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-lg text-xs">
                            Edit
                        </a>

                        <form action="{{ route('warga.destroy', $w->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs">
                                Hapus
                            </button>
                        </form>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center p-6 text-gray-500">
                        Data warga belum tersedia
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
