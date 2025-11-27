<aside
    style="
    width: 250px;
    background-color: #1e3a8a;
    color: white;
    display: flex;
    flex-direction: column;
    padding: 16px;
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
">
    {{-- Logo dan Nama Website --}}
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 32px;">
        <img src="{{ asset('images/Logo-Lokavia.png') }}" alt="Logo" style="width: 60px; height: auto;">
        <h2 style="font-size: 20px; font-weight: bold;">Lokavia</h2>
    </div>

    {{-- Menu Sidebar untuk Admin --}}
    @if (Auth::check() && Auth::user()->role === 'admin')
        <nav style="display: flex; flex-direction: column; gap: 8px; flex: 1;">
            <a href="{{ route('admin.dashboard') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:home-variant" width="32" height="32"></iconify-icon>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.kendaraan.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:car" width="32" height="32"></iconify-icon>
                <span>Manajemen Kendaraan</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:shape" width="32" height="32"></iconify-icon>
                <span>Manajemen Kategori</span>
            </a>

            <a href="{{ route('admin.harga.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:currency-usd" width="32" height="32"></iconify-icon>
                <span>Manajemen Harga</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:account-multiple" width="32" height="32"></iconify-icon>
                <span>Manajemen User</span>
            </a>
        </nav>
    @endif

    {{-- Menu Sidebar untuk Owner --}}
    @if (Auth::check() && Auth::user()->role === 'owner')
        <nav style="display: flex; flex-direction: column; gap: 8px; flex: 1;">
            <a href="{{ route('owner.activity-logs') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:history" width="32" height="32"></iconify-icon>
                <span>Log Aktivitas</span>
            </a>

            <a href="{{ route('owner.sales-data') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:chart-line" width="32" height="32"></iconify-icon>
                <span>Data Penjualan</span>
            </a>

            <a href="{{ route('owner.cashier-data') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 6px; text-decoration: none; color: white;"
                onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor=''">
                <iconify-icon icon="mdi:account-cash" width="32" height="32"></iconify-icon>
                <span>Data Kasir</span>
            </a>
        </nav>
    @endif

    {{-- Menu Sidebar untuk Kasir --}}
    @if (Auth::check() && Auth::user()->role === 'kasir')
        <nav style="display: flex; flex-direction: column; gap: 8px; flex: 1;">
            {{-- Dashboard / Katalog Buku --}}
            <a href="{{ route('kasir.dashboard') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 6px; text-decoration: none; color: white; {{ request()->routeIs('kasir.dashboard') ? 'background-color: #1d4ed8;' : '' }}"
                onmouseover="this.style.backgroundColor='#1d4ed8'"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('kasir.dashboard') ? '#1d4ed8' : 'transparent' }}'">
                <iconify-icon icon="mdi:book-open-page-variant" width="24" height="24"></iconify-icon>
                <span>Katalog Buku</span>
            </a>

            {{-- Keranjang --}}
            <a href="{{ route('kasir.cart') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 6px; text-decoration: none; color: white; position: relative; {{ request()->routeIs('kasir.cart') ? 'background-color: #1d4ed8;' : '' }}"
                onmouseover="this.style.backgroundColor='#1d4ed8'"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('kasir.cart') ? '#1d4ed8' : 'transparent' }}'">
                <iconify-icon icon="mdi:cart" width="24" height="24"></iconify-icon>
                <span>Keranjang</span>
                @if (session('cart') && count(session('cart')) > 0)
                    <span
                        style="position: absolute; right: 10px; background-color: #ef4444; color: white; font-size: 11px; font-weight: bold; padding: 2px 6px; border-radius: 9999px; min-width: 20px; text-align: center;">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>

            {{-- Riwayat Transaksi --}}
            <a href="{{ route('kasir.history') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 6px; text-decoration: none; color: white; {{ request()->routeIs('kasir.history') || request()->routeIs('kasir.transaction.*') ? 'background-color: #1d4ed8;' : '' }}"
                onmouseover="this.style.backgroundColor='#1d4ed8'"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('kasir.history') || request()->routeIs('kasir.transaction.*') ? '#1d4ed8' : 'transparent' }}'">
                <iconify-icon icon="mdi:history" width="24" height="24"></iconify-icon>
                <span>Riwayat Transaksi</span>
            </a>

            {{-- Divider --}}
            <hr style="border-color: rgba(255,255,255,0.2); margin: 8px 0;">

            {{-- Info Card --}}
            <div style="background-color: rgba(255,255,255,0.1); border-radius: 8px; padding: 12px; margin-top: 8px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <iconify-icon icon="mdi:information" width="20" height="20"
                        style="color: #60a5fa;"></iconify-icon>
                    <span style="font-size: 13px; font-weight: 600;">Tips Cepat</span>
                </div>
                <ul style="font-size: 11px; line-height: 1.6; margin: 0; padding-left: 20px; opacity: 0.9;">
                    <li>Cari Kendaraan dengan kata kunci</li>
                    <li>Cek pesanan sebelum pembayaran</li>
                    <li>Transaksi hari ini bisa diedit</li>
                </ul>
            </div>
        </nav>
    @endif

    {{-- Spacer untuk mendorong logout ke bawah --}}
    <div style="flex: 1;"></div>

    {{-- User Info --}}
    <div style="padding: 12px; background-color: rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 16px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <iconify-icon icon="mdi:account-circle" width="40" height="40"></iconify-icon>
            <div>
                <p style="font-size: 14px; font-weight: 600; margin: 0;">{{ Auth::user()->username ?? 'User' }}</p>
                <p style="font-size: 12px; opacity: 0.8; margin: 0; text-transform: capitalize;">
                    {{ Auth::user()->role ?? 'User' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Tombol Logout dengan Konfirmasi --}}
    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
        @csrf
        <button type="button" onclick="confirmLogout()"
            style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 6px; background-color: transparent; color: white; border: none; cursor: pointer; font-size: 15px;"
            onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='transparent'">
            <iconify-icon icon="mdi:logout" width="24" height="24"></iconify-icon>
            <span>Logout</span>
        </button>
    </form>
</aside>

<script src="https://code.iconify.design/iconify-icon/2.0.0/iconify-icon.min.js"></script>

<script>
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
            document.getElementById('logoutForm').submit();
        }
    }
</script>
