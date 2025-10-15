@extends('layouts.app')

@section('title', 'Dashboard Akun | eyetails.co')

@section('content')

<section class="user-dashboard-page container">
    <div class="dashboard-layout">

        <aside class="dashboard-sidebar">
            <div class="user-info-sidebar">
                <h3>Halo, {{ Auth::user()->name }}!</h3>
                <p class="user-tier">
                    Tier: <span class="tier-badge tier-{{ strtolower(Auth::user()->tier) }}">{{ Auth::user()->tier
                        }}</span>
                </p>
                <div class="loyalty-points-sidebar">
                    <i class="fas fa-medal"></i>
                    <span>{{ number_format(Auth::user()->loyalty_points, 0, ',', '.') }} Poin</span>
                </div>
            </div>

            <nav class="account-nav">
                <ul>
                    {{-- ======================================================= --}}
                    {{-- LINK KHUSUS ADMIN DITAMBAHKAN DI SINI --}}
                    {{-- ======================================================= --}}
                    @if (Auth::user()->is_admin)
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="admin-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <i class="fas fa-user-shield fa-fw"></i> <span>Admin Panel</span>
                        </a>
                    </li>
                    <hr class="nav-divider">
                    @endif
                    {{-- ======================================================= --}}

                    <li><a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i
                                class="fas fa-tachometer-alt fa-fw"></i> <span>Dashboard</span></a></li>
                    <li><a href="{{ route('profile.edit') }}"
                            class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i
                                class="fas fa-user-circle fa-fw"></i> <span>Pengaturan Profil</span></a></li>
                    <li><a href="{{ route('order.history') }}"
                            class="{{ request()->routeIs('order.history') || request()->routeIs('order.tracking') ? 'active' : '' }}"><i
                                class="fas fa-history fa-fw"></i> <span>Riwayat Pesanan</span></a></li>
                    <li><a href="{{ route('wishlist.index') }}"
                            class="{{ request()->routeIs('wishlist.index') ? 'active' : '' }}"><i
                                class="far fa-heart fa-fw"></i> <span>Wishlist</span></a></li>
                    <li><a href="{{ route('chat.index') }}"
                            class="{{ request()->routeIs('chat.*') ? 'active' : '' }}"><i
                                class="far fa-comments fa-fw"></i> <span>Pesan Saya</span></a></li>
                    <li><a href="/syarat-loyalitas"><i class="fas fa-medal fa-fw"></i> <span>Loyalitas & Tier</span></a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-logout-btn">
                                <i class="fas fa-sign-out-alt fa-fw"></i> <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="dashboard-content">
            @yield('account-content')
        </main>
    </div>
</section>

{{-- CSS LENGKAP DENGAN PENYESUAIAN RESPONSIVE --}}
<style>
    /* ... (CSS Anda yang sudah ada sebelumnya) ... */
    .user-dashboard-page {
        padding-top: 2rem;
        padding-bottom: 4rem;
    }

    .dashboard-layout {
        display: flex;
        flex-direction: row;
        gap: 2rem;
        align-items: flex-start;
    }

    .dashboard-sidebar {
        flex: 0 0 280px;
        background-color: #1a1a1a;
        color: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        position: sticky;
        top: 100px;
    }

    .user-info-sidebar {
        text-align: center;
        border-bottom: 1px solid #333;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .user-info-sidebar h3 {
        margin: 0 0 0.5rem;
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
        text-transform: none;
    }

    .user-tier {
        margin: 0;
        color: #ccc;
    }

    .loyalty-points-sidebar {
        margin-top: 10px;
        background-color: rgba(255, 255, 255, 0.1);
        padding: 8px 12px;
        border-radius: 4px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .tier-badge {
        font-weight: bold;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.9em;
    }

    .tier-bronze {
        background-color: #cd7f32;
        color: white;
    }

    .tier-silver {
        background-color: #c0c0c0;
        color: #333;
    }

    .tier-gold {
        background-color: #ffd700;
        color: #333;
    }

    .account-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .account-nav a,
    .sidebar-logout-btn {
        display: flex;
        align-items: center;
        padding: 0.9rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        color: #ccc;
        font-weight: 500;
        margin-bottom: 0.25rem;
        transition: background-color 0.2s, color 0.2s;
        width: 100%;
        background: none;
        border: none;
        font-size: 1rem;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
    }

    .account-nav i {
        width: 20px;
        margin-right: 1rem;
        text-align: center;
    }

    .account-nav a:hover,
    .sidebar-logout-btn:hover {
        background-color: #333;
        color: #fff;
    }

    .account-nav a.active {
        background-color: var(--primary-accent, #4f46e5);
        color: #fff;
        font-weight: 600;
    }

    .sidebar-logout-btn {
        color: #ff8a8a;
    }

    .sidebar-logout-btn:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .dashboard-content {
        flex: 1;
        min-width: 0;
    }

    /* === CSS BARU UNTUK LINK ADMIN === */
    .nav-divider {
        border: none;
        border-top: 1px solid #444;
        /* Garis pemisah yang lebih soft */
        margin: 0.75rem 0;
    }

    .account-nav a.admin-link {
        color: #facc15;
        /* Warna kuning emas agar menonjol */
        font-weight: 600;
    }

    .account-nav a.admin-link:hover {
        background-color: rgba(250, 204, 21, 0.1);
        color: #fff;
    }

    .account-nav a.admin-link.active {
        background-color: #facc15;
        color: #1a1a1a;
        /* Teks gelap di atas background terang */
    }

    /* ==================================== */

    @media (max-width: 992px) {
        .dashboard-layout {
            flex-direction: column;
            gap: 1.5rem;
        }

        .dashboard-sidebar {
            width: 100%;
            position: static;
            flex: 0 0 auto;
        }

        .user-info-sidebar {
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info-sidebar h3 {
            margin-bottom: 0;
        }

        .account-nav ul {
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 10px;
        }

        .account-nav li {
            flex-shrink: 0;
        }

        .account-nav a,
        .sidebar-logout-btn {
            padding: 0.75rem 1rem;
        }

        .nav-divider {
            display: none;
        }

        /* Sembunyikan garis di mobile */
    }

    @media (max-width: 768px) {
        .user-info-sidebar {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .account-nav span {
            display: none;
        }

        .account-nav a,
        .sidebar-logout-btn {
            justify-content: center;
            width: auto;
        }

        .account-nav i {
            margin-right: 0;
            font-size: 1.2rem;
        }
    }
</style>

@endsection