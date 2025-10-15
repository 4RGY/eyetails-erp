<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="admin-logo-wrapper">
            <a href="{{ route('admin.dashboard') }}" class="admin-logo">EYETAILS.CO</a>
            <span class="admin-tag">ADMIN PANEL</span>
        </div>
        {{-- Tombol ini sekarang dikendalikan oleh Alpine.js dari layout utama --}}
        <button id="sidebar-toggle">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <nav class="admin-nav">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-fw fa-chart-pie"></i> <span>Dashboard</span>
                </a>
            </li>

            {{-- GRUP 1: MANAJEMEN TOKO --}}
            <li
                x-data="{ open: {{ request()->routeIs('admin.products.*', 'admin.orders.*', 'admin.categories.*', 'admin.shipping.*', 'admin.payments.*', 'admin.returns.*') ? 'true' : 'false' }} }">
                <a href="#" @click.prevent="open = !open">
                    <i class="fa-solid fa-fw fa-store"></i> <span>Manajemen Toko</span>
                    <i class="fa-solid fa-chevron-down dropdown-icon" :class="{ 'rotate-180': open }"></i>
                </a>
                <ul x-show="open" x-transition class="nav-submenu">
                    <li><a href="{{ route('admin.products.index') }}"
                            class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><span>Produk</span></a>
                    </li>
                    <li><a href="{{ route('admin.orders.index') }}"
                            class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <span>Pesanan</span>
                            @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                            <span class="notification-bubble pulsing">{{ $pendingOrdersCount }}</span>
                            @endif
                        </a></li>
                    <li><a href="{{ route('admin.categories.index') }}"
                            class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><span>Kategori</span></a>
                    </li>
                    <li><a href="{{ route('admin.shipping.index') }}"
                            class="{{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}"><span>Pengiriman</span></a>
                    </li>
                    <li><a href="{{ route('admin.payments.index') }}"
                            class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><span>Pembayaran</span></a>
                    </li>
                    <li><a href="{{ route('admin.returns.index') }}"
                            class="{{ request()->routeIs('admin.returns.*') ? 'active' : '' }}"><span>Pengembalian</span></a>
                    </li>
                </ul>
            </li>

            {{-- GRUP 2: PENGGUNA --}}
            <li
                x-data="{ open: {{ request()->routeIs('admin.users.*', 'admin.crm.*', 'admin.chat.*') ? 'true' : 'false' }} }">
                <a href="#" @click.prevent="open = !open">
                    <i class="fa-solid fa-fw fa-users"></i> <span>Pengguna</span>
                    <i class="fa-solid fa-chevron-down dropdown-icon" :class="{ 'rotate-180': open }"></i>
                </a>
                <ul x-show="open" x-transition class="nav-submenu">
                    <li><a href="{{ route('admin.users.index') }}"
                            class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span>Daftar
                                Pengguna</span></a></li>
                    <li><a href="{{ route('admin.crm.index') }}"
                            class="{{ request()->routeIs('admin.crm.*') ? 'active' : '' }}"><span>CRM</span></a></li>
                    <li><a href="{{ route('admin.chat.index') }}"
                            class="{{ request()->routeIs('admin.chat.*') ? 'active' : '' }}"><span>Inbox
                                Pesan</span></a></li>
                </ul>
            </li>

            {{-- GRUP 3: PEMASARAN --}}
            <li
                x-data="{ open: {{ request()->routeIs('admin.posts.*', 'admin.promotions.*', 'admin.campaigns.*') ? 'true' : 'false' }} }">
                <a href="#" @click.prevent="open = !open">
                    <i class="fa-solid fa-fw fa-bullhorn"></i> <span>Pemasaran</span>
                    <i class="fa-solid fa-chevron-down dropdown-icon" :class="{ 'rotate-180': open }"></i>
                </a>
                <ul x-show="open" x-transition class="nav-submenu">
                    <li><a href="{{ route('admin.posts.index') }}"
                            class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"><span>Blog</span></a></li>
                    <li><a href="{{ route('admin.promotions.index') }}"
                            class="{{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}"><span>Promo &
                                Voucher</span></a></li>
                    <li><a href="{{ route('admin.campaigns.create') }}"
                            class="{{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}"><span>Email
                                Promo</span></a></li>
                </ul>
            </li>

            {{-- MENU TINGKAT ATAS LAINNYA --}}
            <li>
                <a href="{{ route('admin.reports.index') }}"
                    class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-fw fa-chart-line"></i> <span>Laporan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.index') }}"
                    class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-fw fa-gear"></i> <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-footer-content">
            <div class="admin-user-info">
                <span class="admin-name">{{ Auth::user()->name }}</span>
                <span class="admin-role">Administrator</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="admin-logout-btn" title="Logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

@push('styles')
<style>
    .admin-sidebar {
        width: var(--sidebar-width-expanded);
        background-color: var(--sidebar-bg);
        color: var(--sidebar-text);
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        transition: width 0.3s ease;
        z-index: 1000;
    }

    .sidebar-header {
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #374151;
        min-height: 64px;
        flex-shrink: 0;
    }

    #sidebar-toggle {
        background: none;
        border: none;
        color: var(--sidebar-text);
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.3s ease;
        padding: 10px;
    }

    .admin-logo-wrapper {
        white-space: nowrap;
        overflow: hidden;
        opacity: 1;
        transition: opacity 0.2s ease, width 0.2s ease;
    }

    .admin-logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        text-decoration: none;
    }

    .admin-tag {
        font-size: 0.7rem;
        color: var(--sidebar-text);
        display: block;
    }

    .admin-nav {
        flex-grow: 1;
        padding: 15px 10px;
        overflow-y: auto;
    }

    .admin-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .admin-nav a {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-radius: 6px;
        text-decoration: none;
        color: var(--sidebar-text);
        font-weight: 500;
        margin-bottom: 5px;
        white-space: nowrap;
        position: relative;
        transition: background-color 0.2s, color 0.2s;
    }

    .admin-nav a:hover {
        background-color: #374151;
        color: #fff;
    }

    .admin-nav a.active {
        background-color: var(--primary-accent);
        color: #fff;
        font-weight: 600;
    }

    .admin-nav i.fa-fw {
        width: 20px;
        margin-right: 15px;
        text-align: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .admin-nav span {
        transition: opacity 0.2s ease;
    }

    .dropdown-icon {
        margin-left: auto;
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .rotate-180 {
        transform: rotate(180deg);
    }

    .nav-submenu {
        list-style: none;
        padding: 5px 0 5px 25px;
        margin: 0;
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 6px;
    }

    .nav-submenu a {
        padding: 10px 15px;
        font-size: 0.9rem;
    }

    .nav-submenu a.active {
        background: none;
        color: #fff;
        font-weight: 500;
    }

    .nav-submenu a.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 1.25rem;
        width: 4px;
        background-color: #a5b4fc;
        border-radius: 0 4px 4px 0;
    }

    .notification-bubble {
        background-color: var(--red-500);
        color: white;
        border-radius: 9999px;
        padding: 2px 8px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-left: auto;
        line-height: 1.2;
        border: 2px solid var(--sidebar-bg);
    }

    .notification-bubble.pulsing {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }

        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }

    .sidebar-footer {
        padding: 15px;
        border-top: 1px solid #374151;
        flex-shrink: 0;
    }

    .sidebar-footer-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        opacity: 1;
        transition: opacity 0.2s ease;
    }

    .admin-user-info {
        overflow: hidden;
        white-space: nowrap;
    }

    .admin-name {
        font-weight: 600;
        color: #fff;
    }

    .admin-role {
        font-size: 0.8rem;
    }

    .admin-logout-btn {
        background: none;
        border: none;
        color: var(--sidebar-text);
        font-size: 1.2rem;
        cursor: pointer;
    }

    .sidebar-collapsed .admin-sidebar {
        width: var(--sidebar-width-collapsed);
    }

    .sidebar-collapsed #sidebar-toggle {
        transform: rotate(180deg);
    }

    .sidebar-collapsed .admin-logo-wrapper,
    .sidebar-collapsed .admin-nav span,
    .sidebar-collapsed .sidebar-footer-content,
    .sidebar-collapsed .dropdown-icon {
        opacity: 0;
        visibility: hidden;
        width: 0;
    }

    .sidebar-collapsed .admin-nav a {
        justify-content: center;
    }

    .sidebar-collapsed .admin-nav i.fa-fw {
        margin: 0;
    }

    .sidebar-collapsed .nav-submenu {
        display: none !important;
    }
</style>
@endpush