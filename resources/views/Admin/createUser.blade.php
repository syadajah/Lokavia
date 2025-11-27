@extends('layouts.app')

@section('content')
    <style>
        /* Glassmorphism utilities */
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-bg {
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="glass p-4 rounded-xl shadow-lg text-green-800 border-l-4 border-green-600">
                <div class="flex items-center gap-2">
                    <iconify-icon icon="mdi:check-circle" width="20"></iconify-icon>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="glass p-6 rounded-2xl shadow-lg text-gray-800">
            <div class="flex items-center gap-3 mb-2">
                <iconify-icon icon="mdi:account-group" width="32" class="text-blue-900"></iconify-icon>
                <h1 class="text-2xl font-semibold text-blue-900">Manajemen Pengguna</h1>
            </div>
            <p class="text-gray-700 text-sm mt-1">
                Kelola data pengguna, admin, dan owner dalam satu halaman.
            </p>

            <button onclick="openCreateModal()"
                class="mt-4 px-5 py-2 rounded-xl bg-blue-700/60 text-white font-medium shadow-md hover:bg-blue-800/70 transition-all backdrop-blur-xl inline-flex items-center gap-2">
                <iconify-icon icon="mdi:account-plus" width="20"></iconify-icon>
                Tambah Admin/Owner
            </button>
        </div>

        {{-- Statistik Ringkas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="glass p-4 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-blue-600/60 flex items-center justify-center">
                        <iconify-icon icon="mdi:account" width="24" class="text-white"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs">Total User</p>
                        <h3 class="text-2xl font-bold text-blue-900">{{ $users->where('role', 'user')->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="glass p-4 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-green-600/60 flex items-center justify-center">
                        <iconify-icon icon="mdi:shield-account" width="24" class="text-white"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs">Total Admin</p>
                        <h3 class="text-2xl font-bold text-green-700">{{ $users->where('role', 'admin')->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="glass p-4 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-purple-600/60 flex items-center justify-center">
                        <iconify-icon icon="mdi:crown" width="24" class="text-white"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs">Total Owner</p>
                        <h3 class="text-2xl font-bold text-purple-700">{{ $users->where('role', 'owner')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="glass p-6 rounded-2xl shadow-lg overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-blue-900 font-semibold">
                        <th class="p-3">Foto</th>
                        <th class="p-3">Username</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Terdaftar</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-900">
                    @forelse ($users as $user)
                        <tr class="border-b border-white/20 hover:bg-white/10 transition">

                            {{-- FOTO --}}
                            <td class="p-3">
                                @if ($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}"
                                        class="w-12 h-12 object-cover rounded-full shadow border-2 border-white/30">
                                @else
                                    <div class="w-12 h-12 bg-blue-600/30 rounded-full flex items-center justify-center">
                                        <iconify-icon icon="mdi:account" width="24"
                                            class="text-blue-900"></iconify-icon>
                                    </div>
                                @endif
                            </td>

                            {{-- USERNAME --}}
                            <td class="p-3">
                                <div class="font-medium">{{ $user->username }}</div>
                            </td>

                            {{-- EMAIL --}}
                            <td class="p-3">
                                <div class="flex items-center gap-2 text-sm text-gray-700">
                                    <iconify-icon icon="mdi:email" width="16"></iconify-icon>
                                    {{ $user->email }}
                                </div>
                            </td>

                            {{-- ROLE --}}
                            <td class="p-3">
                                @if ($user->role == 'owner')
                                    <span class="role-badge px-3 py-1 rounded-full bg-purple-600/70 text-white text-xs">
                                        <iconify-icon icon="mdi:crown" width="14"></iconify-icon>
                                        Owner
                                    </span>
                                @elseif($user->role == 'admin')
                                    <span class="role-badge px-3 py-1 rounded-full bg-green-600/70 text-white text-xs">
                                        <iconify-icon icon="mdi:shield-account" width="14"></iconify-icon>
                                        Admin
                                    </span>
                                @else
                                    <span class="role-badge px-3 py-1 rounded-full bg-blue-600/70 text-white text-xs">
                                        <iconify-icon icon="mdi:account" width="14"></iconify-icon>
                                        User
                                    </span>
                                @endif
                            </td>

                            {{-- TANGGAL DAFTAR --}}
                            <td class="p-3">
                                <div class="text-sm text-gray-700">{{ $user->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- AKSI --}}
                            <td class="p-3">
                                <div class="flex justify-center gap-2">
                                    <button onclick='openEditModal(@json($user))'
                                        class="px-3 py-1 bg-yellow-600/70 text-white rounded-lg hover:bg-yellow-700/80 transition inline-flex items-center gap-1">
                                        <iconify-icon icon="mdi:pencil" width="16"></iconify-icon>
                                        Edit
                                    </button>

                                    <button onclick="openDeleteModal({{ $user->id }})"
                                        class="px-3 py-1 bg-red-600/70 text-white rounded-lg hover:bg-red-700/80 transition inline-flex items-center gap-1">
                                        <iconify-icon icon="mdi:delete" width="16"></iconify-icon>
                                        Hapus
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-600">
                                <iconify-icon icon="mdi:account-off" width="48" class="mx-auto mb-2"></iconify-icon>
                                <p>Belum ada data pengguna</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{-- ============================= --}}
        {{--      MODAL TAMBAH DATA       --}}
        {{-- ============================= --}}
        <div id="createModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[500px] p-6 rounded-2xl shadow-2xl">
                <h2 class="text-xl font-semibold text-blue-900 mb-1 flex items-center gap-2">
                    <iconify-icon icon="mdi:account-plus" width="24"></iconify-icon>
                    Tambah Admin/Owner
                </h2>
                <p class="text-sm text-gray-600 mb-4">User biasa terdaftar melalui registrasi</p>

                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="flex flex-col gap-3">
                        <input type="text" name="username" placeholder="Username"
                            class="p-3 rounded-lg bg-white/30 text-gray-900 placeholder-gray-600" required>

                        <input type="email" name="email" placeholder="Email"
                            class="p-3 rounded-lg bg-white/30 text-gray-900 placeholder-gray-600" required>

                        <input type="password" name="password" placeholder="Password (min. 8 karakter)"
                            class="p-3 rounded-lg bg-white/30 text-gray-900 placeholder-gray-600" required>

                        {{-- DROPDOWN ROLE (hanya admin & owner) --}}
                        <select name="role" class="p-3 rounded-lg bg-white/30 text-gray-900" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>

                        <div>
                            <label class="block text-sm text-gray-700 mb-2">Foto Profil (Opsional)</label>
                            <input type="file" name="foto" accept="image/*"
                                class="p-3 rounded-lg bg-white/30 text-gray-900 w-full">
                        </div>

                        <div class="flex justify-end gap-3 mt-2">
                            <button type="button" onclick="closeCreateModal()"
                                class="px-4 py-2 rounded-lg bg-gray-500/50 text-white">Batal</button>

                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-700/70 text-white hover:bg-blue-800/80 transition inline-flex items-center gap-2">
                                <iconify-icon icon="mdi:content-save" width="18"></iconify-icon>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================= --}}
        {{--         MODAL EDIT           --}}
        {{-- ============================= --}}
        <div id="editModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[500px] p-6 rounded-2xl shadow-2xl">

                <h2 class="text-xl font-semibold text-blue-900 mb-4 flex items-center gap-2">
                    <iconify-icon icon="mdi:account-edit" width="24"></iconify-icon>
                    Edit Pengguna
                </h2>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-3">
                        <input id="edit_username" type="text" name="username" placeholder="Username"
                            class="p-3 rounded-lg bg-white/30 text-gray-900" required>

                        <input id="edit_email" type="email" name="email" placeholder="Email"
                            class="p-3 rounded-lg bg-white/30 text-gray-900" required>

                        <input type="password" name="password" placeholder="Password baru (kosongkan jika tidak diubah)"
                            class="p-3 rounded-lg bg-white/30 text-gray-900 placeholder-gray-600">

                        <select id="edit_role" name="role" class="p-3 rounded-lg bg-white/30 text-gray-900" required>
                            <option value="">Pilih Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>

                        <div>
                            <label class="block text-sm text-gray-700 mb-2">Foto Profil</label>
                            <input type="file" name="foto" accept="image/*"
                                class="p-3 rounded-lg bg-white/30 text-gray-900 w-full">
                            <p class="text-xs text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 rounded-lg bg-gray-500/50 text-white">Batal</button>

                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-700/70 text-white hover:bg-blue-800/80 transition inline-flex items-center gap-2">
                                <iconify-icon icon="mdi:update" width="18"></iconify-icon>
                                Update
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        {{-- ============================= --}}
        {{--         MODAL DELETE         --}}
        {{-- ============================= --}}
        <div id="deleteModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[400px] p-6 rounded-2xl shadow-xl text-center">

                <div class="w-16 h-16 bg-red-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <iconify-icon icon="mdi:alert-circle" width="32" class="text-red-600"></iconify-icon>
                </div>

                <h2 class="text-xl font-semibold text-blue-900 mb-3">Hapus Pengguna?</h2>
                <p class="text-gray-800 mb-4">Data tidak dapat dipulihkan setelah dihapus.</p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 rounded-lg bg-gray-500/40 text-white">Batal</button>

                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-600/70 text-white hover:bg-red-700/80 inline-flex items-center gap-2">
                            <iconify-icon icon="mdi:delete" width="18"></iconify-icon>
                            Hapus
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        // OPEN & CLOSE MODALS
        function openCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openEditModal(data) {
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('edit_username').value = data.username;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_role').value = data.role;

            document.getElementById('editForm').action = `/admin/users/${data.id}`;
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('deleteForm').action = `/admin/users/${id}`;
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>

    {{-- Iconify Script --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
@endsection
