<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteSettings['site_name'] ?? 'eyetails.co')</title>

    {{-- Favicon Dinamis --}}
    @if(isset($siteSettings['favicon_path']))
    <link rel="icon" href="{{ asset('storage/' . $siteSettings['favicon_path']) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Stack untuk CSS spesifik per halaman --}}
    @stack('styles')
</head>

<body>

    <header class="main-header">
        <div class="container header-content">
            <div class="logo">
                <a href="{{ route('home') }}">
                    eyetails.co
                </a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('catalog.index') }}">Katalog</a></li>
                    <li><a href="{{ route('promo.index') }}">Promo</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('testimoni') }}">Testimoni</a></li>
                </ul>
            </nav>
            <div class="nav-icons">
                {{-- ======================================================= --}}
                {{-- MODIFIKASI: IKON KERANJANG DENGAN BADGE --}}
                {{-- ======================================================= --}}
                <a href="{{ route('cart.index') }}" title="Keranjang Belanja" class="cart-icon-wrapper">
                    <i class="fas fa-shopping-cart"></i>
                    {{-- Badge hanya akan muncul jika ada item di keranjang --}}
                    @if(session('cart') && count(session('cart')) > 0)
                    <span class="cart-badge">{{ count(session('cart')) }}</span>
                    @endif
                </a>
                {{-- ======================================================= --}}

                @auth
                <a href="{{ route('dashboard') }}" title="Akun Saya">
                    <i class="fas fa-user"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" title="Login/Register">
                    <i class="fas fa-user"></i>
                </a>
                @endauth
            </div>
            <button class="menu-toggle" aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <div class="mobile-nav-overlay"></div>

    <main>
        @yield('content')
    </main>

    <footer class="main-footer">
        <div class="container footer-grid">
            <div class="footer-column about-us">
                <h3 class="footer-logo">EYETAILS.CO</h3>
                <p>Mendefinisikan kembali gaya urban dengan desain minimalis yang fungsional dan tahan lama.</p>
                <div class="social-icons">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-links-group">
                <div class="footer-column">
                    <h4 class="footer-heading">Jelajahi</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('catalog.index') }}">Katalog</a></li>
                        <li><a href="{{ route('promo.index') }}">Promo</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="footer-heading">Bantuan</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                        <li><a href="{{ route('testimoni') }}">Testimoni</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container sub-footer-content">
                <p class="copyright">&copy; {{ date('Y') }} eyetails.co. All Rights Reserved.</p>
                <ul class="legal-links">
                    <li><a href="{{ route('terms') }}">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('privacy') }}">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
    </footer>

    @if(isset($activePromotions) && $activePromotions->isNotEmpty())
    <x-promo-bubble />
    <x-modal name="promo-modal" maxWidth="lg">
        <x-promo-modal-content :promotions="$activePromotions" />
    </x-modal>
    @endif

    @stack('scripts')
    @stack('styles')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const mainNav = document.querySelector('.main-nav');
            const overlay = document.querySelector('.mobile-nav-overlay');
            const body = document.body;
            
            const oldHeader = mainNav.querySelector('.mobile-sidebar-header');
            if (oldHeader) oldHeader.remove();
            
            let sidebarHeader = document.createElement('div');
            sidebarHeader.className = 'mobile-sidebar-header';
            sidebarHeader.innerHTML = '<div class="mobile-sidebar-logo">EYETAILS.CO</div><button class="menu-close" aria-label="Close menu"><i class="fas fa-times"></i></button>';
            mainNav.insertBefore(sidebarHeader, mainNav.firstChild);
            
            const closeBtn = sidebarHeader.querySelector('.menu-close');
            
            const oldIcons = mainNav.querySelector('.mobile-nav-icons');
            if(oldIcons) oldIcons.remove();

            let mobileNavIcons = document.createElement('div');
            mobileNavIcons.className = 'mobile-nav-icons';
            
            // =======================================================
            // MODIFIKASI: KODE HTML UNTUK KERANJANG DI MENU MOBILE
            // =======================================================
            const cartHTML = `<a href="{{ route('cart.index') }}" class="cart-icon-wrapper-mobile"><i class="fas fa-shopping-cart"></i><span>Keranjang</span> @if(session('cart') && count(session('cart')) > 0)<span class="cart-badge-mobile">{{ count(session('cart')) }}</span>@endif</a>`;
            // =======================================================

            @auth
            const userHTML = `<a href="{{ route('dashboard') }}"><i class="fas fa-user"></i><span>Akun Saya</span></a>`;
            const logoutHTML = `<form method="POST" action="{{ route('logout') }}" style="display:inline; width: 100%;"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="sidebar-logout-btn"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button></form>`;
            mobileNavIcons.innerHTML = cartHTML + userHTML + logoutHTML;
            @else
            const loginHTML = `<a href="{{ route('login') }}"><i class="fas fa-user"></i><span>Login</span></a>`;
            mobileNavIcons.innerHTML = cartHTML + loginHTML;
            @endauth
            
            mainNav.appendChild(mobileNavIcons);
            
            function toggleMenu() {
                mainNav.classList.toggle('mobile-open');
                overlay.classList.toggle('active');
                body.style.overflow = body.style.overflow === 'hidden' ? '' : 'hidden';
            }
            
            if (menuToggle) menuToggle.addEventListener('click', toggleMenu);
            if (closeBtn) closeBtn.addEventListener('click', toggleMenu);
            if (overlay) overlay.addEventListener('click', toggleMenu);
        });
    </script>
</body>

</html>

@push('styles')
<style>
    /* === BADGE KERANJANG === */
    .cart-icon-wrapper {
        position: relative;
        display: inline-block;
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -10px;
        background-color: #dc3545;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
        border: 2px solid #fff;
    }

    .cart-icon-wrapper-mobile {
        position: relative;
    }

    /* Badge di menu mobile */
    .cart-badge-mobile {
        background-color: #dc3545;
        color: white;
        border-radius: 10px;
        padding: 0 6px;
        font-size: 0.8rem;
        font-weight: bold;
        position: absolute;
        left: 140px;
        top: 10px;
    }

    /* === FOOTER STYLES === */
    .main-footer {
        background-color: #1a1a1a;
        color: #a0aec0;
        padding: 4rem 0 0 0;
        font-size: 0.95rem;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 2.5rem;
        margin-bottom: 3rem;
        align-items: start;
    }

    .footer-links-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
    }

    .footer-column .footer-logo {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: 2px;
        color: #fff;
        margin: 0 0 1rem 0;
        text-transform: uppercase;
    }

    .footer-column.about-us p {
        line-height: 1.7;
        margin-bottom: 1.5rem;
        max-width: 350px;
    }

    .social-icons a {
        color: #a0aec0;
        font-size: 1.2rem;
        margin-right: 1.25rem;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #fff;
    }

    .footer-column .footer-heading {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        text-decoration: none;
        color: #a0aec0;
        transition: color 0.3s ease, padding-left 0.3s ease;
    }

    .footer-links a:hover {
        color: #fff;
        padding-left: 5px;
    }

    .footer-bottom {
        background-color: #000;
        padding: 1rem 0;
        font-size: 0.9rem;
    }

    .sub-footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .copyright {
        margin: 0;
    }

    .legal-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 1.5rem;
    }

    .legal-links a {
        color: #a0aec0;
        text-decoration: none;
    }

    .legal-links a:hover {
        color: #fff;
        text-decoration: underline;
    }

    @media (max-width: 992px) {

        .footer-grid,
        .footer-links-group {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .footer-column.about-us p {
            margin-left: auto;
            margin-right: auto;
        }

        .sub-footer-content {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
</style>
@endpush