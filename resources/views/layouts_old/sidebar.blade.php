<div class="h-full flex flex-col">

    <!-- Logo / Title -->
    <div class="p-6 border-b">
        <h2 class="text-2xl font-bold text-blue-600">
            Smart Bansos
        </h2>
        <p class="text-sm text-gray-500">Sistem Bantuan Sosial</p>
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-4 space-y-2">

        <!-- Dashboard -->
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-6v-6H10v6H4a1 1 0 01-1-1z"/>
            </svg>
            Dashboard
        </a>

        <!-- Data Warga -->
        <a href="{{ route('warga.index') }}" class="flex items-center gap-3 p-3 rounded-lg transition
        {{ request()->routeIs('warga.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-3-3.87"/>
                <path d="M7 21v-2a4 4 0 013-3.87"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Data Warga
        </a>

        <!-- Pengajuan -->
        <a href="{{ route('pengajuan.index') }}" class="flex items-center gap-3 p-3 rounded-lg transition
        {{ request()->routeIs('pengajuan.*') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12h6"/>
                <path d="M12 9v6"/>
                <path d="M21 16V8a2 2 0 00-2-2h-4l-2-2H9L7 6H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2z"/>
            </svg>
            Pengajuan
        </a>

        <!-- Hasil Kelayakan -->
        {{-- <a href="#" class="flex items-center gap-3 p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 13l4 4L19 7"/>
            </svg>
            Hasil Kelayakan
        </a> --}}

    </nav>

</div>
