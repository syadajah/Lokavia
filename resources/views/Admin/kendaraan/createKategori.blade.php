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

        /* Nested table styles */
        .nested-row {
            background: rgba(255, 255, 255, 0.05);
        }

        .rotate-90 {
            transform: rotate(90deg);
            transition: transform 0.3s;
        }

        .rotate-0 {
            transform: rotate(0deg);
            transition: transform 0.3s;
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- Header --}}
        <div class="glass p-6 rounded-2xl shadow-lg text-gray-800">
            <h1 class="text-2xl font-semibold text-blue-900">Manajemen Kategori</h1>
            <p class="text-gray-700 text-sm mt-1">
                Kelola data kategori kendaraan Lokavia.
            </p>

            <button onclick="openCreateModal()"
                class="mt-4 px-5 py-2 rounded-xl bg-blue-700/60 text-white font-medium shadow-md hover:bg-blue-800/70 transition-all backdrop-blur-xl">
                + Tambah Kategori / Jenis
            </button>
        </div>

        {{-- Table with Nested Rows --}}
        <div class="glass p-6 rounded-2xl shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-blue-900 font-semibold">
                        <th class="p-3 w-16"></th>
                        <th class="p-3">Nama Kategori</th>
                        <th class="p-3">Jumlah Jenis</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-900">
                    @php
                        $groupedKategori = $kategori->groupBy('nama_kategori');
                    @endphp

                    @foreach ($groupedKategori as $namaKategori => $items)
                        {{-- Main Category Row --}}
                        <tr class="border-b border-white/20 hover:bg-white/10 transition">
                            <td class="p-3 text-center cursor-pointer" onclick="toggleSubRows({{ $loop->index }})">
                                <svg id="arrow-{{ $loop->index }}" class="w-5 h-5 text-blue-900 rotate-0 inline-block"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </td>
                            <td class="p-3 font-semibold cursor-pointer" onclick="toggleSubRows({{ $loop->index }})">
                                {{ $namaKategori }}
                            </td>
                            <td class="p-3 cursor-pointer" onclick="toggleSubRows({{ $loop->index }})">
                                {{ $items->count() }} jenis
                            </td>
                            <td class="p-3">
                                <div class="flex justify-center gap-3">
                                    <button onclick="openAddJenisModal('{{ addslashes($namaKategori) }}')"
                                        class="px-3 py-1 bg-blue-600/70 text-white rounded-lg hover:bg-blue-700/80 transition text-xs">
                                        + Jenis Baru
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Sub Rows (Jenis) --}}
                        @foreach ($items as $item)
                            <tr class="nested-row border-b border-white/10 hidden sub-row-{{ $loop->parent->index }}">
                                <td class="p-3"></td>
                                <td class="p-3 pl-12 text-sm">↳ {{ $item->jenis }}</td>
                                <td class="p-3"></td>
                                <td class="p-3">
                                    <div class="flex justify-center gap-3">
                                        <button onclick='openEditModal(@json($item))'
                                            class="px-3 py-1 bg-yellow-600/70 text-white rounded-lg hover:bg-yellow-700/80 transition text-xs">
                                            Edit
                                        </button>

                                        <button onclick="openDeleteModal({{ $item->id }})"
                                            class="px-3 py-1 bg-red-600/70 text-white rounded-lg hover:bg-red-700/80 transition text-xs">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    @if ($kategori->count() == 0)
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-700">Belum ada kategori.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>


        {{-- ============================= --}}
        {{--      MODAL TAMBAH DATA        --}}
        {{-- ============================= --}}
        <div id="createModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[450px] p-6 rounded-2xl shadow-2xl">

                <h2 class="text-xl font-semibold text-blue-900 mb-4">Tambah Kategori / Jenis</h2>

                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf

                    <div class="flex flex-col gap-3">

                        {{-- Dropdown untuk pilih kategori existing atau input baru --}}
                        <div>
                            <label class="text-sm text-gray-800 mb-1 block">Kategori</label>
                            <select id="create_kategori_select" onchange="handleKategoriChange()"
                                class="p-3 rounded-lg bg-white/30 text-gray-900 w-full">
                                <option value="">-- Pilih Kategori yang Ada --</option>
                                @php
                                    $uniqueKategori = $kategori->pluck('nama_kategori')->unique();
                                @endphp
                                @foreach ($uniqueKategori as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                                <option value="__new__">+ Buat Kategori Baru</option>
                            </select>
                        </div>

                        {{-- Input manual (muncul kalau pilih "Buat Baru") --}}
                        <input id="create_kategori_input" type="text" name="nama_kategori"
                            placeholder="Nama Kategori Baru" class="p-3 rounded-lg bg-white/30 text-gray-900 hidden">

                        <input type="text" name="jenis" placeholder="Jenis"
                            class="p-3 rounded-lg bg-white/30 text-gray-900" required>

                        <div class="flex justify-end gap-3 mt-3">
                            <button type="button" onclick="closeCreateModal()"
                                class="px-4 py-2 rounded-lg bg-gray-500/50 text-white">Batal</button>

                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-700/70 text-white hover:bg-blue-800/80 transition">
                                Simpan
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- ============================= --}}
        {{--   MODAL TAMBAH JENIS BARU     --}}
        {{-- ============================= --}}
        <div id="addJenisModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[450px] p-6 rounded-2xl shadow-2xl">

                <h2 class="text-xl font-semibold text-blue-900 mb-4">Tambah Jenis untuk <span
                        id="modal_kategori_name"></span></h2>

                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf

                    <input type="hidden" id="add_jenis_kategori" name="nama_kategori">

                    <div class="flex flex-col gap-3">

                        <input type="text" name="jenis" placeholder="Nama Jenis Baru"
                            class="p-3 rounded-lg bg-white/30 text-gray-900" required>

                        <div class="flex justify-end gap-3 mt-3">
                            <button type="button" onclick="closeAddJenisModal()"
                                class="px-4 py-2 rounded-lg bg-gray-500/50 text-white">Batal</button>

                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-700/70 text-white hover:bg-blue-800/80 transition">
                                Simpan
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- ============================= --}}
        {{--          MODAL EDIT          --}}
        {{-- ============================= --}}
        <div id="editModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[450px] p-6 rounded-2xl shadow-2xl">

                <h2 class="text-xl font-semibold text-blue-900 mb-4">Edit Kategori/Jenis</h2>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-3">

                        <div>
                            <label class="text-sm text-gray-800 mb-1 block">Nama Kategori</label>
                            <input id="edit_nama" type="text" name="nama_kategori"
                                class="p-3 rounded-lg bg-white/30 text-gray-900" required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-800 mb-1 block">Jenis</label>
                            <input id="edit_jenis" type="text" name="jenis"
                                class="p-3 rounded-lg bg-white/30 text-gray-900" required>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 rounded-lg bg-gray-500/50 text-white">Batal</button>

                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-700/70 text-white hover:bg-blue-800/80 transition">
                                Update
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- ============================= --}}
        {{--        MODAL DELETE          --}}
        {{-- ============================= --}}
        <div id="deleteModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[400px] p-6 rounded-2xl shadow-xl text-center">

                <h2 class="text-xl font-semibold text-blue-900 mb-3">Hapus Jenis?</h2>
                <p class="text-gray-800 mb-4">Data tidak dapat dipulihkan setelah dihapus.</p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 rounded-lg bg-gray-500/40 text-white">Batal</button>

                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-600/70 text-white hover:bg-red-700/80">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================= --}}
        {{--        JAVASCRIPT            --}}
        {{-- ============================= --}}
        <script>
            // Toggle sub-rows (expand/collapse)
            function toggleSubRows(index) {
                const subRows = document.querySelectorAll(`.sub-row-${index}`);
                const arrow = document.getElementById(`arrow-${index}`);

                subRows.forEach(row => {
                    row.classList.toggle('hidden');
                });

                arrow.classList.toggle('rotate-90');
                arrow.classList.toggle('rotate-0');
            }

            // Handle kategori dropdown change
            function handleKategoriChange() {
                const select = document.getElementById('create_kategori_select');
                const input = document.getElementById('create_kategori_input');

                if (select.value === '__new__') {
                    input.classList.remove('hidden');
                    input.required = true;
                    input.value = '';
                } else {
                    input.classList.add('hidden');
                    input.required = false;
                    input.value = select.value;
                }
            }

            // MODAL: Create
            function openCreateModal() {
                const modal = document.getElementById('createModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Reset form
                document.getElementById('create_kategori_select').value = '';
                document.getElementById('create_kategori_input').classList.add('hidden');
                document.getElementById('create_kategori_input').value = '';
            }

            function closeCreateModal() {
                const modal = document.getElementById('createModal');
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }

            // MODAL: Add Jenis to Existing Kategori
            function openAddJenisModal(namaKategori) {
                const modal = document.getElementById('addJenisModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                document.getElementById('modal_kategori_name').textContent = namaKategori;
                document.getElementById('add_jenis_kategori').value = namaKategori;
            }

            function closeAddJenisModal() {
                const modal = document.getElementById('addJenisModal');
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }

            // MODAL: Edit
            function openEditModal(data) {
                const modal = document.getElementById('editModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                document.getElementById('edit_nama').value = data.nama_kategori;
                document.getElementById('edit_jenis').value = data.jenis;

                document.getElementById('editForm').action = `/admin/kategori/${data.id}`;
            }

            function closeEditModal() {
                const modal = document.getElementById('editModal');
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }

            // MODAL: Delete
            function openDeleteModal(id) {
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                document.getElementById('deleteForm').action = `/admin/kategori/${id}`;
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        </script>
    @endsection
