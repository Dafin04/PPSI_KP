<aside class="block">
    <nav class="sticky top-20 w-full md:w-64">
        <div class="rounded-2xl shadow-sm overflow-hidden bg-gradient-to-b from-blue-700 to-indigo-600 text-white">
            <div class="px-4 py-3 text-sm font-semibold tracking-wide border-b border-blue-500">
                Dashboard<br>Admin
                <div class="text-xs font-normal opacity-80">SIKP - Sistem Informasi KP</div>
            </div>

            <ul class="p-3 space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all 
                       {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white shadow-sm' : 'hover:bg-blue-600/70 text-white/90' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Kelola Pengguna -->
                <li>
                    <a href="{{ route('admin.users') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all 
                       {{ request()->routeIs('admin.users*') ? 'bg-blue-500 text-white shadow-sm' : 'hover:bg-blue-600/70 text-white/90' }}">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                </li>

                <!-- Monitor KP -->
                <li>
                    <a href="{{ route('admin.monitoring') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all 
                       {{ request()->routeIs('admin.monitoring*') ? 'bg-blue-500 text-white shadow-sm' : 'hover:bg-blue-600/70 text-white/90' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Monitor KP</span>
                    </a>
                </li>

                <!-- Data Instansi -->
                <li>
                    <a href="{{ route('admin.instansi.index') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all 
                       {{ request()->routeIs('admin.instansi.*') ? 'bg-blue-500 text-white shadow-sm' : 'hover:bg-blue-600/70 text-white/90' }}">
                        <i class="fa-solid fa-building"></i>
                        <span>Data Instansi</span>
                    </a>
                </li>

                <!-- Data Lowongan KP -->
                <li>
                    <a href="{{ route('admin.lowongan.index') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all 
                       {{ request()->routeIs('admin.lowongan.*') ? 'bg-blue-500 text-white shadow-sm' : 'hover:bg-blue-600/70 text-white/90' }}">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>Data Lowongan KP</span>
                    </a>
                </li>

                <!-- Alokasi Dosen -->
                <li>
                    <a href="{{ route('admin.alokasi.pembimbing') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all 
                       {{ request()->routeIs('admin.alokasi.*') ? 'bg-blue-500 text-white shadow-sm' : 'hover:bg-blue-600/70 text-white/90' }}">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Alokasi Dosen</span>
                    </a>
                </li>

                <!-- Logout -->
                <li class="pt-3 border-t border-blue-500 mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 rounded-lg px-3 py-2 transition-all text-red-200 hover:bg-red-500/20">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>

            <div class="px-4 py-3 border-t border-blue-500 text-xs text-blue-100 text-center">
                © {{ date('Y') }} SIKP
            </div>
        </div>
    </nav>
</aside>
