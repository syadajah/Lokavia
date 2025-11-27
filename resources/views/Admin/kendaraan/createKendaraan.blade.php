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
    </style>

    <div class="flex flex-col gap-6">

        {{-- Header --}}
        <div class="glass p-6 rounded-2xl shadow-lg text-gray-800">
            <h1 class="text-2xl font-semibold text-blue-900">Manajemen Kendaraan</h1>
            <p class="text-gray-700 text-sm mt-1">
                Kelola data kendaraan Lokavia dalam satu halaman.
            </p>

            <button onclick="openCreateModal()"
                class="mt-4 px-5 py-2 rounded-xl bg-blue-700/60 text-white font-medium shadow-md hover:bg-blue-800/70 transition-all backdrop-blur-xl">
                + Tambah Kendaraan
            </button>
        </div>

        {{-- Table --}}
        <div class="glass p-6 rounded-2xl shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-blue-900 font-semibold">
                        <th class="p-3">Nama</th>
                        <th class="p-3">Merek</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Foto</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-900">

                    @foreach ($kendaraan as $item)
                        <tr class="border-b border-white/20 hover:bg-white/10 transition">

                            {{-- NAMA --}}
                            <td class="p-3">{{ $item->nama_kendaraan }}</td>

                            {{-- MEREK --}}
                            <td class="p-3">{{ $item->merek }}</td>

                            {{-- KATEGORI --}}
                            <td class="p-3">
                                {{ $item->kategori->nama_kategori ?? '-' }} - {{ $item->kategori->jenis ?? '' }}
                            </td>

                            {{-- STATUS --}}
                            <td class="p-3">
                                <span
                                    class="px-3 py-1 rounded-full text-white text-xs 
                            {{ $item->status == 'tersedia' ? 'bg-green-600/70' : 'bg-red-600/70' }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            {{-- FOTO --}}
                            <td class="p-3">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                        class="w-20 h-14 object-cover rounded-lg shadow">
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="p-3">
                                <div class="flex justify-center gap-3">
                                    <button onclick='openEditModal(@json($item))'
                                        class="px-3 py-1 bg-yellow-600/70 text-white rounded-lg hover:bg-yellow-700/80 transition">
                                        Edit
                                    </button>

                                    <button onclick="openDeleteModal({{ $item->id }})"
                                        class="px-3 py-1 bg-red-600/70 text-white rounded-lg hover:bg-red-700/80 transition">
                                        Hapus
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


        {{-- ============================= --}}
        {{--      MODAL TAMBAH DATA       --}}
        {{-- ============================= --}}
        <div id="createModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[500px] p-6 rounded-2xl shadow-2xl">
                <h2 class="text-xl font-semibold text-blue-900 mb-4">Tambah Kendaraan</h2>

                <form action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="flex flex-col gap-3">
                        <input type="text" name="merek" placeholder="Merek"
                            class="p-3 rounded-lg bg-white/30 text-gray-900 placeholder-gray-600">

                        <input type="text" name="nama_kendaraan" placeholder="Nama Kendaraan"
                            class="p-3 rounded-lg bg-white/30 text-gray-900">

                        {{-- DROPDOWN KATEGORI --}}
                        <select id="create_kategori" name="nama_kategori" class="p-3 rounded-lg bg-white/30 text-gray-900"
                            onchange="loadJenisCreate(this.value)">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoriList as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>

                        {{-- DROPDOWN JENIS (dinamis) --}}
                        <select id="create_jenis" name="id_kategori" class="p-3 rounded-lg bg-white/30 text-gray-900"
                            disabled>
                            <option value="">Pilih Jenis</option>
                        </select>

                        <select name="status" class="p-3 rounded-lg bg-white/30 text-gray-900">
                            <option value="tersedia">Tersedia</option>
                            <option value="tidak_tersedia">Tidak Tersedia</option>
                        </select>

                        <textarea name="deskripsi" placeholder="Deskripsi" class="p-3 rounded-lg bg-white/30 text-gray-900"></textarea>

                        <input type="file" name="foto" class="p-3 rounded-lg bg-white/30 text-gray-900">

                        <div class="flex justify-end gap-3 mt-2">
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
        {{--         MODAL EDIT           --}}
        {{-- ============================= --}}
        <div id="editModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[500px] p-6 rounded-2xl shadow-2xl">

                <h2 class="text-xl font-semibold text-blue-900 mb-4">Edit Kendaraan</h2>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-3">
                        <input id="edit_merek" type="text" name="merek" class="p-3 rounded-lg bg-white/30">
                        <input id="edit_nama" type="text" name="nama_kendaraan" class="p-3 rounded-lg bg-white/30">

                        {{-- DROPDOWN KATEGORI --}}
                        <select id="edit_kategori" name="nama_kategori" class="p-3 rounded-lg bg-white/30"
                            onchange="loadJenisEdit(this.value)">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoriList as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>

                        {{-- DROPDOWN JENIS (dinamis) --}}
                        <select id="edit_jenis" name="id_kategori" class="p-3 rounded-lg bg-white/30">
                            <option value="">Pilih Jenis</option>
                        </select>

                        <select id="edit_status" name="status" class="p-3 rounded-lg bg-white/30">
                            <option value="tersedia">Tersedia</option>
                            <option value="tidak_tersedia">Tidak Tersedia</option>
                        </select>

                        <textarea id="edit_deskripsi" name="deskripsi" class="p-3 rounded-lg bg-white/30"></textarea>

                        <input type="file" name="foto" class="p-3 rounded-lg bg-white/30">

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
        {{--         MODAL DELETE         --}}
        {{-- ============================= --}}
        <div id="deleteModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
            <div class="glass w-[400px] p-6 rounded-2xl shadow-xl text-center">

                <h2 class="text-xl font-semibold text-blue-900 mb-3">Hapus Kendaraan?</h2>
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

        <script>
            // OPEN & CLOSE MODALS
            function openCreateModal() {
                const modal = document.getElementById('createModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Reset form
                document.getElementById('create_kategori').value = '';
                document.getElementById('create_jenis').innerHTML = '<option value="">Pilih Jenis</option>';
                document.getElementById('create_jenis').disabled = true;
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

                document.getElementById('edit_merek').value = data.merek;
                document.getElementById('edit_nama').value = data.nama_kendaraan;
                document.getElementById('edit_deskripsi').value = data.deskripsi || '';
                document.getElementById('edit_status').value = data.status;

                // Set kategori dan load jenis
                if (data.kategori) {
                    document.getElementById('edit_kategori').value = data.kategori.nama_kategori;
                    loadJenisEdit(data.kategori.nama_kategori, data.id_kategori);
                }

                document.getElementById('editForm').action = `/admin/kendaraan/${data.id}`;
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

                document.getElementById('deleteForm').action = `/admin/kendaraan/${id}`;
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }

            // LOAD JENIS BY KATEGORI (Create Modal)
            function loadJenisCreate(namaKategori) {
                const jenisSelect = document.getElementById('create_jenis');

                if (!namaKategori) {
                    jenisSelect.innerHTML = '<option value="">Pilih Jenis</option>';
                    jenisSelect.disabled = true;
                    return;
                }

                jenisSelect.disabled = true;
                jenisSelect.innerHTML = '<option value="">Loading...</option>';

                fetch(`/admin/kategori/get-jenis?nama_kategori=${encodeURIComponent(namaKategori)}`)
                    .then(response => response.json())
                    .then(data => {
                        jenisSelect.innerHTML = '<option value="">Pilih Jenis</option>';

                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.jenis;
                            jenisSelect.appendChild(option);
                        });

                        jenisSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        jenisSelect.innerHTML = '<option value="">Error loading data</option>';
                    });
            }

            // LOAD JENIS BY KATEGORI (Edit Modal)
            function loadJenisEdit(namaKategori, selectedId = null) {
                const jenisSelect = document.getElementById('edit_jenis');

                if (!namaKategori) {
                    jenisSelect.innerHTML = '<option value="">Pilih Jenis</option>';
                    return;
                }

                jenisSelect.innerHTML = '<option value="">Loading...</option>';

                fetch(`/admin/kategori/get-jenis?nama_kategori=${encodeURIComponent(namaKategori)}`)
                    .then(response => response.json())
                    .then(data => {
                        jenisSelect.innerHTML = '<option value="">Pilih Jenis</option>';

                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.jenis;

                            if (selectedId && item.id == selectedId) {
                                option.selected = true;
                            }

                            jenisSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        jenisSelect.innerHTML = '<option value="">Error loading data</option>';
                    });
            }
        </script>
    @endsection
