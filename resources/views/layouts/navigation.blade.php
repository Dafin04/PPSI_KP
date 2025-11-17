<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
                        Sistem KP
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard Admin') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                                {{ __('Kelola Pengguna') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.instansi.index')" :active="request()->routeIs('admin.instansi.*')">
                                {{ __('Kelola Instansi') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.lowongan.index')" :active="request()->routeIs('admin.lowongan.*')">
                                {{ __('Kelola Lowongan KP') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.alokasi.pembimbing')" :active="request()->routeIs('admin.alokasi.*')">
                                {{ __('Alokasi Dosen') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.monitoring')" :active="request()->routeIs('admin.monitoring')">
                                {{ __('Monitoring & Laporan') }}
                            </x-nav-link>
                        @elseif(auth()->user()->hasRole('dosen') || auth()->user()->hasRole('dosen-biasa'))
                            <x-nav-link :href="route('dosen.dashboard')" :active="request()->routeIs('dosen.dashboard')">
                                {{ __('Dashboard Dosen') }}
                            </x-nav-link>
                            <x-nav-link :href="route('dosen.proposal.index')" :active="request()->routeIs('dosen.proposal.*')">
                                {{ __('Validasi Proposal') }}
                            </x-nav-link>
                            <x-nav-link :href="route('dosen.bimbingan.index')" :active="request()->routeIs('dosen.bimbingan.*')">
                                {{ __('Riwayat Bimbingan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('dosen.nilai.index')" :active="request()->routeIs('dosen.nilai.*')">
                                {{ __('Nilai Pembimbing') }}
                            </x-nav-link>
                            <x-nav-link :href="route('dosen.seminar.index')" :active="request()->routeIs('dosen.seminar.*')">
                                {{ __('Penguji Seminar') }}
                            </x-nav-link>
                        @elseif(auth()->user()->hasRole('mahasiswa'))
                            <x-nav-link :href="route('mahasiswa.dashboard')" :active="request()->routeIs('mahasiswa.dashboard')">
                                {{ __('Dashboard Mahasiswa') }}
                            </x-nav-link>
                            <x-nav-link :href="route('kerja-praktek.create')" :active="request()->routeIs('kerja-praktek.create')">
                                {{ __('Daftar KP') }}
                            </x-nav-link>
                            <x-nav-link :href="route('kerja-praktek.index')" :active="request()->routeIs('kerja-praktek.index')">
                                {{ __('Status KP') }}
                            </x-nav-link>
                            <x-nav-link :href="route('mahasiswa.nilai')" :active="request()->routeIs('mahasiswa.nilai')">
                                {{ __('Hasil KP') }}
                            </x-nav-link>
                            <x-nav-link :href="route('mahasiswa.seminar.index')" :active="request()->routeIs('mahasiswa.seminar.*')">
                                {{ __('Seminar') }}
                            </x-nav-link>
                            <x-nav-link :href="route('mahasiswa.kuesioner.index')" :active="request()->routeIs('mahasiswa.kuesioner.*')">
                                {{ __('Kuesioner') }}
                            </x-nav-link>
                            <x-nav-link :href="route('mahasiswa.instansi.create')" :active="request()->routeIs('mahasiswa.instansi.*')">
                                {{ __('Ajukan Instansi') }}
                            </x-nav-link>
                            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                                {{ __('Profil') }}
                            </x-nav-link>
                        @elseif(auth()->user()->hasRole('pembimbing_lapangan') || auth()->user()->hasRole('pembimbing-lapangan'))
                            <x-nav-link :href="route('lapangan.dashboard')" :active="request()->routeIs('lapangan.dashboard')">
                                {{ __('Dashboard Pengawas') }}
                            </x-nav-link>
                            <x-nav-link :href="route('lapangan.nilai.index')" :active="request()->routeIs('lapangan.nilai.*')">
                                {{ __('Nilai Lapangan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('lapangan.kuesioner.index')" :active="request()->routeIs('lapangan.kuesioner.*')">
                                {{ __('Kuesioner') }}
                            </x-nav-link>
                            <x-nav-link :href="route('lapangan.kuota.index')" :active="request()->routeIs('lapangan.kuota.*')">
                                {{ __('Usulan Kuota') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                        {{ __('Kelola Pengguna') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.instansi.index')" :active="request()->routeIs('admin.instansi.*')">
                        {{ __('Kelola Instansi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.lowongan.index')" :active="request()->routeIs('admin.lowongan.*')">
                        {{ __('Kelola Lowongan KP') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.alokasi.pembimbing')" :active="request()->routeIs('admin.alokasi.*')">
                        {{ __('Alokasi Dosen') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.monitoring')" :active="request()->routeIs('admin.monitoring')">
                        {{ __('Monitoring & Laporan') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->hasRole('dosen') || auth()->user()->hasRole('dosen-biasa'))
                    <x-responsive-nav-link :href="route('dosen.dashboard')" :active="request()->routeIs('dosen.dashboard')">
                        {{ __('Dashboard Dosen') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dosen.proposal.index')" :active="request()->routeIs('dosen.proposal.*')">
                        {{ __('Validasi Proposal') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dosen.bimbingan.index')" :active="request()->routeIs('dosen.bimbingan.*')">
                        {{ __('Riwayat Bimbingan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dosen.nilai.index')" :active="request()->routeIs('dosen.nilai.*')">
                        {{ __('Nilai Pembimbing') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dosen.seminar.index')" :active="request()->routeIs('dosen.seminar.*')">
                        {{ __('Penguji Seminar') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->hasRole('mahasiswa'))
                    <x-responsive-nav-link :href="route('mahasiswa.dashboard')" :active="request()->routeIs('mahasiswa.*')">
                        {{ __('Dashboard Mahasiswa') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kerja-praktek.create')" :active="request()->routeIs('kerja-praktek.create')">
                        {{ __('Daftar KP') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kerja-praktek.index')" :active="request()->routeIs('kerja-praktek.index')">
                        {{ __('Status KP') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('mahasiswa.nilai')" :active="request()->routeIs('mahasiswa.nilai')">
                        {{ __('Hasil KP') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('mahasiswa.seminar.index')" :active="request()->routeIs('mahasiswa.seminar.*')">
                        {{ __('Seminar') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('mahasiswa.kuesioner.index')" :active="request()->routeIs('mahasiswa.kuesioner.*')">
                        {{ __('Kuesioner') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('mahasiswa.instansi.create')" :active="request()->routeIs('mahasiswa.instansi.*')">
                        {{ __('Ajukan Instansi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profil') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->hasRole('pembimbing_lapangan') || auth()->user()->hasRole('pembimbing-lapangan'))
                    <x-responsive-nav-link :href="route('lapangan.dashboard')" :active="request()->routeIs('lapangan.*')">
                        {{ __('Dashboard Pengawas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('lapangan.nilai.index')" :active="request()->routeIs('lapangan.nilai.*')">
                        {{ __('Nilai Lapangan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('lapangan.kuesioner.index')" :active="request()->routeIs('lapangan.kuesioner.*')">
                        {{ __('Kuesioner') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('lapangan.kuota.index')" :active="request()->routeIs('lapangan.kuota.*')">
                        {{ __('Usulan Kuota') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    <div class="font-medium text-xs text-gray-400">{{ Auth::user()->getRoleNameAttribute() }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                    <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
