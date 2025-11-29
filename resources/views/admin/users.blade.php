<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Kelola akun dan role pengguna</p>
                        <h3 class="text-lg font-semibold text-gray-900">Data Pengguna</h3>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <form method="GET" action="{{ route('admin.users') }}" class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </span>
                            <input type="text" name="q" value="{{ $q ?? request('q') }}" placeholder="Cari nama/email..."
                                   class="w-full rounded-xl border border-gray-200 pl-9 pr-3 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
                        </form>
                        <a href="{{ route('admin.users.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Tambah Pengguna
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="p-6 space-y-6">
                    @foreach($roleMaps as $slug => $label)
                        @php $list = $usersByRole[$slug] ?? collect(); @endphp
                        <div class="border border-gray-100 rounded-2xl">
                            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-t-2xl">
                                <div class="text-sm font-semibold text-gray-800">{{ $label }}</div>
                                <span class="text-xs text-gray-500">Total: {{ $list->count() }}</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                            <th class="px-4 py-2.5">Nama</th>
                                            <th class="px-4 py-2.5">Email</th>
                                            <th class="px-4 py-2.5 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($list as $user)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2.5 text-gray-900 font-medium leading-tight">{{ $user->name }}</td>
                                                <td class="px-4 py-2.5 text-gray-700 leading-tight">{{ $user->email }}</td>
                                                <td class="px-4 py-2.5 text-right whitespace-nowrap">
                                                    <button onclick="openModal({{ $user->id }}, '{{ $user->name }}')" class="p-2 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-50" title="Ubah role">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                                        <span class="sr-only">Ubah role</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="px-4 py-3 text-center text-gray-500">Tidak ada pengguna.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="roleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 w-full max-w-md shadow-lg rounded-xl bg-white">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Pilih role baru</p>
                    <h3 class="text-lg font-semibold text-gray-900">Ubah Role: <span id="userName"></span></h3>
                </div>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-700">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form id="roleForm" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="userId" name="user_id">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="role_id">Role Baru</label>
                    <select name="role_id" id="role_id" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(userId, userName) {
            document.getElementById('userId').value = userId;
            document.getElementById('userName').textContent = userName;
            document.getElementById('roleForm').action = `/admin/users/${userId}/assign-role`;
            document.getElementById('roleModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('roleModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
