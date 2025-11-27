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

        {{-- Success Message --}}
        @if (session('success'))
            <div class="glass p-4 rounded-xl shadow-lg text-green-800 border-l-4 border-green-600">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="glass p-6 rounded-2xl shadow-lg text-gray-800">
            <h1 class="text-2xl font-semibold text-blue-900">Manajemen Harga Sewa</h1>
            <p class="text-gray-700 text-sm mt-1">
                Kelola harga sewa kendaraan berdasarkan tanggal berlaku.
            </p>

            <button onclick="openCreateModal()"
                class="mt-4 px-5 py-2 rounded-xl bg-blue-700/60 text-white font-medium shadow-md hover:bg-blue-800/70 transition-all backdrop-blur-xl">
                + Tambah Harga Sewa
            </button>
        </div>

        {{-- Table --}}
        <div class="glass p-6 rounded-2xl shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-blue-900 font-semibold">
                        <th class="p-3">Kendaraan</th>
                        <th class="p-3">Merek</th>
                        <th class="p-3">Harga per Hari</th>
                        <th class="p-3">Tanggal Berlaku</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-900">
                    @forelse ($harga as $item)
                        <tr class="border-b border-white/20 hover:bg-white/10 transition">

                            {{-- KENDARAAN --}}
                            <td class="p-3">{{ $item->kendaraan->nama_kendaraan ?? '-' }}</td>

                            {{-- MEREK --}}
                            <td class="p-3">{{ $item->kendaraan->merek ?? '-' }}</td>

                            {{-- HARGA --}}
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full bg-green-600/70 text-white text-sm font-medium">
                                    Rp {{ number_format($item->harga_sewa_per_hari, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- TANGGAL BERLAKU --}}
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($item->tanggal_berlaku)->format('d M Y') }}
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
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-600">
                                Belum ada data harga sewa
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
                <h2 class="text-xl font-semibold text-blue-900 mb-4">Tambah Harga Sewa</h2>

                <form action="{{ route('admin.harga.store') }}" method="POST">
                    @csrf

                    <div class="flex flex-col gap-3">
                        {{-- DROPDOWN KENDARAAN --}}
                        <select name="id_kendaraan" class="p-3 rounded-lg bg-white/30 text-gray-900" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($kendaraan as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_kendaraan }} - {{ $k->merek }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="harga_sewa_per_hari" placeholder="Harga Sewa per Hari (Rp)"
                            class="p-3 rounded-lg bg-white/30 text-gray-900 placeholder-gray-600" required min="0"
                            step="1000">

                        <input type="date" name="tanggal_berlaku" class="p-3 rounded-lg bg-white/30 text-gray-900"
                            required>

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

                <h2 class="text-xl font-semibold text-blue-900 mb-4">Edit Harga Sewa</h2>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-3">
                        {{-- DROPDOWN KENDARAAN --}}
                        <select id="edit_kendaraan" name="id_kendaraan" class="p-3 rounded-lg bg-white/30 text-gray-900"
                            required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($kendaraan as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_kendaraan }} - {{ $k->merek }}
                                </option>
                            @endforeach
                        </select>

                        <input id="edit_harga" type="number" name="harga_sewa_per_hari"
                            placeholder="Harga Sewa per Hari (Rp)" class="p-3 rounded-lg bg-white/30 text-gray-900" required
                            min="0" step="1000">

                        <input id="edit_tanggal" type="date" name="tanggal_berlaku"
                            class="p-3 rounded-lg bg-white/30 text-gray-900" required>

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

                <h2 class="text-xl font-semibold text-blue-900 mb-3">Hapus Harga Sewa?</h2>
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

            document.getElementById('edit_kendaraan').value = data.id_kendaraan;
            document.getElementById('edit_harga').value = data.harga_sewa_per_hari;
            document.getElementById('edit_tanggal').value = data.tanggal_berlaku;

            document.getElementById('editForm').action = `/admin/harga/${data.id}`;
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

            document.getElementById('deleteForm').action = `/admin/harga/${id}`;
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
@endsection
