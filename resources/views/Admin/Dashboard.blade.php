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

        .glass-hover {
            transition: all 0.3s ease;
        }

        .glass-hover:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #9a3412 0%, #ea580c 50%, #f97316 100%);
        }

        .gradient-purple {
            background: linear-gradient(135deg, #581c87 0%, #7c3aed 50%, #a78bfa 100%);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
        }
    </style>

    <div class="flex flex-col gap-6">

        {{-- Header --}}
        <div class="glass p-6 rounded-2xl shadow-lg text-gray-800">
            <h1 class="text-3xl font-bold text-blue-900">Dashboard Admin</h1>
            <p class="text-gray-700 text-sm mt-1">
                Selamat datang di panel admin Lokavia Rental Kendaraan
            </p>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Total Kendaraan --}}
            <div class="glass glass-hover p-6 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Kendaraan</p>
                        <h2 class="text-4xl font-bold text-blue-900 mt-2">{{ $totalKendaraan }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Semua kendaraan</p>
                    </div>
                    <div class="stat-icon gradient-blue text-white">
                        <iconify-icon icon="mdi:car-multiple" width="32"></iconify-icon>
                    </div>
                </div>
            </div>

            {{-- Kendaraan Tersedia --}}
            <div class="glass glass-hover p-6 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Tersedia</p>
                        <h2 class="text-4xl font-bold text-green-700 mt-2">{{ $kendaraanTersedia }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Siap disewa</p>
                    </div>
                    <div class="stat-icon gradient-green text-white">
                        <iconify-icon icon="mdi:check-circle" width="32"></iconify-icon>
                    </div>
                </div>
            </div>

            {{-- Kendaraan Disewa --}}
            <div class="glass glass-hover p-6 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Sedang Disewa</p>
                        <h2 class="text-4xl font-bold text-orange-700 mt-2">{{ $kendaraanDisewa }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Tidak tersedia</p>
                    </div>
                    <div class="stat-icon gradient-orange text-white">
                        <iconify-icon icon="mdi:car-clock" width="32"></iconify-icon>
                    </div>
                </div>
            </div>

            {{-- Total User --}}
            <div class="glass glass-hover p-6 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Pengguna</p>
                        <h2 class="text-4xl font-bold text-purple-700 mt-2">{{ $totalUser }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Terdaftar</p>
                    </div>
                    <div class="stat-icon gradient-purple text-white">
                        <iconify-icon icon="mdi:account-group" width="32"></iconify-icon>
                    </div>
                </div>
            </div>

        </div>

        {{-- Grid Layout: Info & Kendaraan Terbaru --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Info Tambahan --}}
            <div class="lg:col-span-1 flex flex-col gap-6">

                {{-- Total Kategori --}}
                <div class="glass p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-blue-600/70 text-white">
                            <iconify-icon icon="mdi:folder-multiple" width="28"></iconify-icon>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Total Kategori</p>
                            <h3 class="text-3xl font-bold text-blue-900">{{ $totalKategori }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Rata-rata Harga --}}
                <div class="glass p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-green-600/70 text-white">
                            <iconify-icon icon="mdi:cash-multiple" width="28"></iconify-icon>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Rata-rata Harga</p>
                            <h3 class="text-2xl font-bold text-green-700">
                                Rp {{ number_format($rataRataHarga, 0, ',', '.') }}
                            </h3>
                            <p class="text-gray-500 text-xs">per hari</p>
                        </div>
                    </div>
                </div>

                {{-- Kendaraan per Kategori --}}
                <div class="glass p-6 rounded-2xl shadow-lg">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                        <iconify-icon icon="mdi:chart-pie" width="20"></iconify-icon>
                        Kendaraan per Kategori
                    </h3>
                    <div class="space-y-3">
                        @foreach ($kendaraanPerKategori as $item)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 text-sm flex items-center gap-2">
                                    <iconify-icon icon="mdi:tag" width="16" class="text-blue-600"></iconify-icon>
                                    {{ $item->kategori->nama_kategori ?? 'Tidak ada' }}
                                </span>
                                <span class="px-3 py-1 rounded-full bg-blue-600/60 text-white text-xs font-medium">
                                    {{ $item->total }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Kendaraan Terbaru --}}
            <div class="lg:col-span-2 glass p-6 rounded-2xl shadow-lg">
                <h3 class="text-xl font-semibold text-blue-900 mb-4 flex items-center gap-2">
                    <iconify-icon icon="mdi:clock-outline" width="24"></iconify-icon>
                    Kendaraan Terbaru
                </h3>

                <div class="space-y-4">
                    @forelse ($kendaraanTerbaru as $kendaraan)
                        <div class="glass p-4 rounded-xl flex items-center gap-4 hover:bg-white/20 transition">

                            {{-- Foto --}}
                            <div class="flex-shrink-0">
                                @if ($kendaraan->foto)
                                    <img src="{{ asset('storage/' . $kendaraan->foto) }}"
                                        class="w-24 h-20 object-cover rounded-lg shadow">
                                @else
                                    <div class="w-24 h-20 bg-gray-400/30 rounded-lg flex items-center justify-center">
                                        <iconify-icon icon="mdi:car" width="32" class="text-gray-600"></iconify-icon>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1">
                                <h4 class="font-semibold text-blue-900">{{ $kendaraan->nama_kendaraan }}</h4>
                                <p class="text-sm text-gray-600 flex items-center gap-1">
                                    <iconify-icon icon="mdi:car-info" width="16"></iconify-icon>
                                    {{ $kendaraan->merek }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500 flex items-center gap-1">
                                        <iconify-icon icon="mdi:tag" width="14"></iconify-icon>
                                        {{ $kendaraan->kategori->nama_kategori ?? '-' }}
                                    </span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span
                                        class="px-2 py-0.5 rounded-full text-white text-xs flex items-center gap-1
                                        {{ $kendaraan->status == 'tersedia' ? 'bg-green-600/70' : 'bg-red-600/70' }}">
                                        <iconify-icon
                                            icon="{{ $kendaraan->status == 'tersedia' ? 'mdi:check-circle' : 'mdi:close-circle' }}"
                                            width="12"></iconify-icon>
                                        {{ $kendaraan->status }}
                                    </span>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="text-right">
                                <p class="text-xs text-gray-500 flex items-center gap-1 justify-end">
                                    <iconify-icon icon="mdi:calendar-plus" width="14"></iconify-icon>
                                    Ditambahkan
                                </p>
                                <p class="text-sm font-medium text-gray-700">
                                    {{ $kendaraan->created_at->diffForHumans() }}
                                </p>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <iconify-icon icon="mdi:car-off" width="48" class="mx-auto mb-2"></iconify-icon>
                            <p>Belum ada kendaraan terbaru</p>
                        </div>
                    @endforelse
                </div>

                {{-- Link ke Halaman Kendaraan --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.kendaraan.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-2 rounded-xl bg-blue-700/60 text-white font-medium shadow-md hover:bg-blue-800/70 transition-all">
                        <iconify-icon icon="mdi:arrow-right-circle" width="20"></iconify-icon>
                        Lihat Semua Kendaraan
                    </a>
                </div>

            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="glass p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-semibold text-blue-900 mb-4 flex items-center gap-2">
                <iconify-icon icon="mdi:lightning-bolt" width="24"></iconify-icon>
                Aksi Cepat
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <a href="{{ route('admin.kendaraan.index') }}"
                    class="glass glass-hover p-4 rounded-xl flex items-center gap-4 text-gray-800 hover:text-blue-900 transition">
                    <div class="stat-icon bg-blue-600/60 text-white">
                        <iconify-icon icon="mdi:car-cog" width="28"></iconify-icon>
                    </div>
                    <div>
                        <h4 class="font-semibold">Kelola Kendaraan</h4>
                        <p class="text-xs text-gray-600">Tambah, edit, hapus kendaraan</p>
                    </div>
                </a>

                <a href="{{ route('admin.harga.index') }}"
                    class="glass glass-hover p-4 rounded-xl flex items-center gap-4 text-gray-800 hover:text-blue-900 transition">
                    <div class="stat-icon bg-green-600/60 text-white">
                        <iconify-icon icon="mdi:currency-usd" width="28"></iconify-icon>
                    </div>
                    <div>
                        <h4 class="font-semibold">Kelola Harga</h4>
                        <p class="text-xs text-gray-600">Atur harga sewa kendaraan</p>
                    </div>
                </a>

                <a href="#"
                    class="glass glass-hover p-4 rounded-xl flex items-center gap-4 text-gray-800 hover:text-blue-900 transition">
                    <div class="stat-icon bg-purple-600/60 text-white">
                        <iconify-icon icon="mdi:account-settings" width="28"></iconify-icon>
                    </div>
                    <div>
                        <h4 class="font-semibold">Kelola Pengguna</h4>
                        <p class="text-xs text-gray-600">Lihat data pengguna</p>
                    </div>
                </a>

            </div>
        </div>

    </div>

    {{-- Iconify Script --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
@endsection
