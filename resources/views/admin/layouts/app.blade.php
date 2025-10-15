<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - eyetails.co</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @stack('styles')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --sidebar-width-expanded: 260px;
            --sidebar-width-collapsed: 80px;
            --admin-bg: #f8f9fa;
            --sidebar-bg: #111827;
            --sidebar-text: #9ca3af;
            --text-primary: #1f2937;
            --border-color: #e5e7eb;
            --primary-accent: #4f46e5;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
        }

        /* === SIDEBAR === */
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
            overflow: hidden;
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
        }

        .admin-nav a:hover {
            background-color: #374151;
            color: #fff;
        }

        /* Indikator Active Baru */
        .admin-nav a.active {
            background-color: rgba(79, 70, 229, 0.1);
            color: #fff;
            font-weight: 600;
        }

        .admin-nav a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 4px;
            background-color: var(--primary-accent);
            border-radius: 0 4px 4px 0;
        }

        .admin-nav i {
            width: 20px;
            margin-right: 15px;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .admin-nav span {
            transition: opacity 0.2s ease;
        }

        /* Dropdown Styling */
        .nav-dropdown-toggle {
            width: 100%;
            box-sizing: border-box;
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
            background-color: rgba(0, 0, 0, 0.1);
        }

        .nav-submenu a {
            padding: 10px 15px;
        }

        .nav-submenu a span {
            font-size: 0.9rem;
        }

        .nav-submenu a.active {
            background: none;
        }

        .nav-submenu a.active::before {
            background-color: #a5b4fc;
        }
        .notification-bubble {
        /* Warna merah cerah */
        background-color: #dc3545;
        color: white;
        border-radius: 9999px;
        padding: 2px 8px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-left: auto;
        line-height: 1.2;
        border: 2px solid #fff;
        /* Memberi outline putih agar lebih jelas */
        }
        
        /* Animasi berdenyut */
        .notification-bubble.pulsing {
        animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
        0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        
        70% {
        transform: scale(1.05);
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
        }
        
        100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
        }
        /* Warna indikator sub-menu */

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

        .admin-main-content {
            padding: 30px;
            margin-left: var(--sidebar-width-expanded);
            width: calc(100% - var(--sidebar-width-expanded) - 60px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* === LOGIKA COLLAPSE === */
        .sidebar-collapsed .admin-sidebar {
            width: var(--sidebar-width-collapsed);
        }

        .sidebar-collapsed .admin-main-content {
            margin-left: var(--sidebar-width-collapsed);
            width: calc(100% - var(--sidebar-width-collapsed) - 60px);
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
            width: 0px;
        }

        .sidebar-collapsed .admin-nav a {
            justify-content: center;
        }

        .sidebar-collapsed .admin-nav i {
            margin: 0;
        }

        .sidebar-collapsed .nav-submenu {
            display: none !important;
        }

        /* Styling Umum */
        .admin-content-header {
            margin-bottom: 30px;
        }

        .admin-widgets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .widget-card {
            background-color: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="admin-layout">
        @include('admin.layouts.sidebar')
        <main class="admin-main-content">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const body = document.querySelector('body'); 
            const sidebarState = localStorage.getItem('sidebarState');
            function applySidebarState(state) {
                if (state === 'collapsed') { body.classList.add('sidebar-collapsed'); } 
                else { body.classList.remove('sidebar-collapsed'); }
            }
            applySidebarState(sidebarState);
            toggleBtn.addEventListener('click', function() {
                body.classList.toggle('sidebar-collapsed');
                const newState = body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded';
                localStorage.setItem('sidebarState', newState);
            });
        });
    </script>
</body>

</html>