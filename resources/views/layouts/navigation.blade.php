<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Menu -->
            <div class="flex">
                @auth
                    {{-- ADMIN --}}
                    @if(Auth::user()->isAdmin())
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link
                                :href="route('dashboard.analitik')"
                                :active="request()->routeIs('dashboard.analitik')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link
                                :href="route('warga.index')"
                                :active="request()->routeIs('warga.*')">
                                Data Warga
                            </x-nav-link>
                            <x-nav-link
                                :href="route('pengajuan.index')"
                                :active="request()->routeIs('pengajuan.*')">
                                Verifikasi Kelayakan
                            </x-nav-link>
                            <x-nav-link
                                :href="route('penerima-bantuan.index')"
                                :active="request()->routeIs('penerima-bantuan.*')">
                                Penerima Bantuan
                            </x-nav-link>
                            <x-nav-link
                                :href="route('bantuan.index')"
                                :active="request()->routeIs('bantuan.*')">
                                Bantuan Sosial
                            </x-nav-link>
                        </div>
                    {{-- PETUGAS --}}
                    @elseif(Auth::user()->isPetugas())
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link
                                :href="route('verifikasi.index')"
                                :active="request()->routeIs('verifikasi.*')">
                                Verifikasi Lapangan
                            </x-nav-link>
                            <x-nav-link
                                :href="route('penyaluran.index')"
                                :active="request()->routeIs('penyaluran.*')">
                                Penyaluran Bantuan
                            </x-nav-link>
                        </div>
                    {{-- WARGA --}}
                    @elseif(Auth::user()->isWarga())
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link
                                :href="route('warga.dashboard')"
                                :active="request()->routeIs('warga.dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link
                                :href="route('warga.bantuan')"
                                :active="request()->routeIs('warga.bantuan')">
                                Pengambilan Bantuan Sosial 
                            </x-nav-link>
                        </div>
                    @endif
                @endauth
            </div>
            <!-- Dropdown User -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            <div>
                                {{ Auth::user()->name ?? 'User' }}
                            </div>
                            <div class="ms-1">
                                <svg
                                    class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24">
                        <path
                            :class="{'hidden': open, 'inline-flex': !open}"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                        <path
                            :class="{'hidden': !open, 'inline-flex': open}"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>