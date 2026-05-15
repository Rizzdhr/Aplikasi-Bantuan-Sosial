<div class="bg-white rounded-2xl shadow px-6 py-4 flex justify-between items-center">

    <!-- LEFT: Judul Halaman -->
    <h1 class="text-lg font-semibold text-gray-700">
        @yield('judul')
    </h1>

    <!-- RIGHT: User -->
    <div class="flex items-center gap-3">

        <!-- Notifikasi (optional) -->
        <button class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor">
                <path stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5"/>
            </svg>
        </button>

        <!-- User Profile -->
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                A
            </div>
            <div class="text-sm">
                <p class="font-semibold text-gray-700">Admin</p>
                <p class="text-gray-500 text-xs">Administrator</p>
            </div>
        </div>

    </div>
</div>
