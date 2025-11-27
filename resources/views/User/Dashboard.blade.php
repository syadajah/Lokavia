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

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .badge-tersedia {
            background: rgba(34, 197, 94, 0.7);
        }

        .badge-tidak-tersedia {
            background: rgba(239, 68, 68, 0.7);
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- Header Section --}}
        <div class="glass p-6 rounded-2xl shadow-lg text-gray-800">
            <h1 class="text-2xl font-semibold text-blue-900">Katalog Kendaraan</h1>
            <p class="text-gray-700 text-sm mt-1">
                Temukan kendaraan yang sesuai dengan kebutuhan Anda
            </p>
        </div>

        {{-- Search & Filter Section --}}
        <div class="glass p-6 rounded-2xl shadow-lg">
            <div class="flex flex-col lg:flex-row gap-4">

                {{-- Search Bar --}}
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari kendaraan berdasarkan nama atau merek..."
                            class="w-full p-3 pl-10 rounded-lg bg-white/30 text-gray-900 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Filter Kategori --}}
                <div class="w-full lg:w-64">
                    <select id="filterKategori"
                        class="w-full p-3 rounded-lg bg-white/30 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div class="w-full lg:w-48">
                    <select id="filterStatus"
                        class="w-full p-3 rounded-lg bg-white/30 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak_tersedia">Tidak Tersedia</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                <button onclick="resetFilters()"
                    class="px-5 py-3 rounded-lg bg-gray-600/60 text-white font-medium hover:bg-gray-700/70 transition-all">
                    Reset
                </button>
            </div>

            {{-- Result Count --}}
            <div class="mt-4">
                <p class="text-sm text-gray-700">
                    Menampilkan <span id="resultCount" class="font-semibold text-blue-900">0</span> kendaraan
                </p>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div id="kendaraanGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @forelse($kendaraan as $item)
                <div class="kendaraan-card glass rounded-2xl shadow-lg overflow-hidden card-hover"
                    data-nama="{{ strtolower($item->nama_kendaraan) }}" data-merek="{{ strtolower($item->merek) }}"
                    data-kategori="{{ strtolower($item->kategori->nama_kategori ?? '') }}"
                    data-status="{{ $item->status }}">

                    {{-- Image --}}
                    <div class="relative h-48 bg-gray-800/20 overflow-hidden">
                        @if ($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_kendaraan }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif

                        {{-- Status Badge --}}
                        <div class="absolute top-3 right-3">
                            <span
                                class="px-3 py-1 rounded-full text-white text-xs font-medium {{ $item->status == 'tersedia' ? 'badge-tersedia' : 'badge-tidak-tersedia' }}">
                                {{ $item->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5">
                        {{-- Category --}}
                        <div class="mb-2">
                            <span class="px-2 py-1 rounded-md bg-blue-600/50 text-white text-xs font-medium">
                                {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </span>
                        </div>

                        {{-- Name --}}
                        <h3 class="text-lg font-semibold text-blue-900 mb-1">
                            {{ $item->nama_kendaraan }}
                        </h3>

                        {{-- Brand --}}
                        <p class="text-sm text-gray-700 mb-3">
                            {{ $item->merek }}
                        </p>

                        {{-- Description --}}
                        @if ($item->deskripsi)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $item->deskripsi }}
                            </p>
                        @endif

                        {{-- Price (if available) --}}
                        @if ($item->harga_terbaru)
                            <div class="mb-4">
                                <p class="text-xs text-gray-600">Harga Sewa per Hari</p>
                                <p class="text-xl font-bold text-green-700">
                                    Rp {{ number_format($item->harga_terbaru->harga_sewa_per_hari, 0, ',', '.') }}
                                </p>
                            </div>
                        @endif

                        {{-- Action Button --}}
                        <button onclick="openDetailModal(@json($item))"
                            class="w-full px-4 py-2 rounded-lg {{ $item->status == 'tersedia' ? 'bg-blue-700/60 hover:bg-blue-800/70' : 'bg-gray-500/40 cursor-not-allowed' }} text-white font-medium transition-all">
                            {{ $item->status == 'tersedia' ? 'Lihat Detail' : 'Tidak Tersedia' }}
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="glass p-12 rounded-2xl text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <h3 class="text-xl font-semibold text-blue-900 mb-2">Belum Ada Kendaraan</h3>
                        <p class="text-gray-700">Kendaraan akan segera tersedia</p>
                    </div>
                </div>
            @endforelse

        </div>

        {{-- No Results Message --}}
        <div id="noResults" class="hidden">
            <div class="glass p-12 rounded-2xl text-center">
                <svg class="w-16 h-16 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-blue-900 mb-2">Tidak Ada Hasil</h3>
                <p class="text-gray-700">Coba ubah kata kunci atau filter pencarian Anda</p>
            </div>
        </div>

        {{-- ============================= --}}
        {{--      MODAL DETAIL KENDARAAN  --}}
        {{-- ============================= --}}
        <div id="detailModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50 p-4">
            <div class="glass w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden">

                {{-- Header --}}
                <div class="p-6 border-b border-white/20 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-blue-900">Detail Kendaraan</h2>
                    <button onclick="closeDetailModal()" class="text-gray-600 hover:text-gray-900 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Content --}}
                <div class="p-6 max-h-[70vh] overflow-y-auto">
                    <div class="flex flex-col md:flex-row gap-6">

                        {{-- Image --}}
                        <div class="md:w-1/2">
                            <div id="modalImage" class="rounded-xl overflow-hidden bg-gray-800/20 h-64"></div>
                        </div>

                        {{-- Info --}}
                        <div class="md:w-1/2 flex flex-col gap-4">
                            <div>
                                <span id="modalKategori"
                                    class="px-3 py-1 rounded-md bg-blue-600/50 text-white text-xs font-medium"></span>
                            </div>

                            <div>
                                <h3 id="modalNama" class="text-2xl font-bold text-blue-900"></h3>
                                <p id="modalMerek" class="text-gray-700 mt-1"></p>
                            </div>

                            <div id="modalStatusContainer"></div>

                            <div id="modalHargaContainer"></div>

                            <div>
                                <h4 class="font-semibold text-blue-900 mb-2">Deskripsi</h4>
                                <p id="modalDeskripsi" class="text-gray-700 text-sm"></p>
                            </div>

                            <button id="modalRentButton" onclick="handleRentClick()"
                                class="w-full px-6 py-3 rounded-lg bg-blue-700/60 hover:bg-blue-800/70 text-white font-medium transition-all mt-4">
                                Sewa Sekarang
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        let currentKendaraan = null;

        // Search and Filter Functionality
        function filterKendaraan() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const kategoriFilter = document.getElementById('filterKategori').value.toLowerCase();
            const statusFilter = document.getElementById('filterStatus').value;

            const cards = document.querySelectorAll('.kendaraan-card');
            const noResults = document.getElementById('noResults');
            let visibleCount = 0;

            cards.forEach(card => {
                const nama = card.getAttribute('data-nama');
                const merek = card.getAttribute('data-merek');
                const kategori = card.getAttribute('data-kategori');
                const status = card.getAttribute('data-status');

                const matchSearch = nama.includes(searchTerm) || merek.includes(searchTerm);
                const matchKategori = !kategoriFilter || kategori === kategoriFilter;
                const matchStatus = !statusFilter || status === statusFilter;

                if (matchSearch && matchKategori && matchStatus) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update result count
            document.getElementById('resultCount').textContent = visibleCount;

            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Reset Filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterKategori').value = '';
            document.getElementById('filterStatus').value = '';
            filterKendaraan();
        }

        // Event Listeners for filters
        document.getElementById('searchInput').addEventListener('input', filterKendaraan);
        document.getElementById('filterKategori').addEventListener('change', filterKendaraan);
        document.getElementById('filterStatus').addEventListener('change', filterKendaraan);

        // Initialize result count on page load
        document.addEventListener('DOMContentLoaded', function() {
            filterKendaraan();
        });

        // Open Detail Modal
        function openDetailModal(data) {
            currentKendaraan = data;
            const modal = document.getElementById('detailModal');

            // Set image
            const imageContainer = document.getElementById('modalImage');
            if (data.foto) {
                imageContainer.innerHTML =
                    `<img src="/storage/${data.foto}" alt="${data.nama_kendaraan}" class="w-full h-full object-cover">`;
            } else {
                imageContainer.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                `;
            }

            // Set info
            document.getElementById('modalKategori').textContent = data.kategori?.nama_kategori || 'Tanpa Kategori';
            document.getElementById('modalNama').textContent = data.nama_kendaraan;
            document.getElementById('modalMerek').textContent = data.merek;
            document.getElementById('modalDeskripsi').textContent = data.deskripsi || 'Tidak ada deskripsi tersedia.';

            // Set status
            const statusContainer = document.getElementById('modalStatusContainer');
            const statusClass = data.status === 'tersedia' ? 'badge-tersedia' : 'badge-tidak-tersedia';
            const statusText = data.status === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia';
            statusContainer.innerHTML = `
                <div>
                    <span class="px-3 py-1 rounded-full text-white text-sm font-medium ${statusClass}">
                        ${statusText}
                    </span>
                </div>
            `;

            // Set price
            const hargaContainer = document.getElementById('modalHargaContainer');
            if (data.harga_terbaru) {
                hargaContainer.innerHTML = `
                    <div class="glass p-4 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Harga Sewa per Hari</p>
                        <p class="text-2xl font-bold text-green-700">
                            Rp ${Number(data.harga_terbaru.harga_sewa_per_hari).toLocaleString('id-ID')}
                        </p>
                    </div>
                `;
            } else {
                hargaContainer.innerHTML = `
                    <div class="glass p-4 rounded-xl">
                        <p class="text-sm text-gray-600">Harga belum tersedia</p>
                    </div>
                `;
            }

            // Set button state
            const rentButton = document.getElementById('modalRentButton');
            if (data.status !== 'tersedia') {
                rentButton.disabled = true;
                rentButton.classList.remove('bg-blue-700/60', 'hover:bg-blue-800/70');
                rentButton.classList.add('bg-gray-500/40', 'cursor-not-allowed');
                rentButton.textContent = 'Tidak Tersedia';
            } else {
                rentButton.disabled = false;
                rentButton.classList.remove('bg-gray-500/40', 'cursor-not-allowed');
                rentButton.classList.add('bg-blue-700/60', 'hover:bg-blue-800/70');
                rentButton.textContent = 'Sewa Sekarang';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Close Detail Modal
        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            currentKendaraan = null;
        }

        // Handle Rent Click
        function handleRentClick() {
            if (currentKendaraan && currentKendaraan.status === 'tersedia') {
                // TODO: Implement rent functionality
                alert(`Fitur sewa untuk ${currentKendaraan.nama_kendaraan} akan segera tersedia!`);
                // Redirect to booking page or open booking modal
                // window.location.href = `/user/booking/${currentKendaraan.id}`;
            }
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    </script>
@endsection
