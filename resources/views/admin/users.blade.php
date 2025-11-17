<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Email</th>
                                    <th class="px-4 py-2 text-left">Role Saat Ini</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $user->name }}</td>
                                        <td class="px-4 py-2">{{ $user->email }}</td>
                                        <td class="px-4 py-2">
                                            @if($user->roles->count() > 0)
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                                    {{ $user->roles->first()->name }}
                                                </span>
                                            @else
                                                <span class="text-gray-500">Tidak ada role</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <button onclick="openModal({{ $user->id }}, '{{ $user->name }}')"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                                                Ubah Role
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="roleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Role untuk: <span id="userName"></span></h3>
                <form id="roleForm" method="POST">
                    @csrf
                    <input type="hidden" id="userId" name="user_id">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="role_id">
                            Pilih Role Baru:
                        </label>
                        <select name="role_id" id="role_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
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
