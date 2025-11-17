<aside class="block">
    <nav class="sticky top-20 w-full md:w-64">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="px-4 py-3 text-sm font-semibold tracking-wide text-slate-700 border-b border-slate-100">
                Menu Dosen
            </div>
            <ul class="p-2">
                <li>
                    <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dosen.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M11.47 3.84a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1-.53 1.28H4.5a.75.75 0 0 1-.53-1.28l7.5-7.5Z"/><path d="M3.75 13.5h16.5v6A2.25 2.25 0 0 1 18 21.75H6A2.25 2.25 0 0 1 3.75 19.5v-6Z"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.proposal.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dosen.proposal.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75h18M3 12h18M3 17.25h18"/></svg>
                        <span>Validasi Proposal</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.bimbingan.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dosen.bimbingan.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M19.5 14.25v-2.86a2.25 2.25 0 0 0-1.07-1.92l-4.5-2.7a2.25 2.25 0 0 0-2.36 0l-4.5 2.7a2.25 2.25 0 0 0-1.07 1.92v5.22A2.25 2.25 0 0 0 6.75 18h5.69"/><path d="M16.5 18.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"/></svg>
                        <span>Riwayat Bimbingan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.nilai.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dosen.nilai.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75S6.615 21.75 12 21.75 21.75 17.385 21.75 12 17.385 2.25 12 2.25Zm.75 5.25a.75.75 0 0 0-1.5 0v4.19l-2.22 2.22a.75.75 0 1 0 1.06 1.06l2.41-2.41a1.5 1.5 0 0 0 .44-1.06V7.5Z"/></svg>
                        <span>Nilai Pembimbing</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen.seminar.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dosen.seminar.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12 6a9 9 0 1 0 9 9h-1.5A7.5 7.5 0 1 1 12 7.5V6Z"/><path d="M12 2.25a.75.75 0 0 1 .75.75V6a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75Z"/></svg>
                        <span>Penguji Seminar</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
