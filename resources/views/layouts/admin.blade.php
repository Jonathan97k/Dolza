
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Dolza')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span class="brand-icon">D</span>
            <span class="brand-text">Dolza Admin</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Main Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-simple"></i> Dashboard
            </a>

            <div class="nav-label">Content</div>
            <a href="{{ route('admin.properties.index') }}" class="{{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Properties
            </a>
            <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Team
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Testimonials
            </a>

            <div class="nav-label">Messages</div>
            <a href="{{ route('admin.inquiries.index') }}" class="{{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Inquiries
            </a>

            <div class="nav-label">System</div>
            <a href="{{ route('admin.content') }}" class="{{ request()->routeIs('admin.content*') ? 'active' : '' }}">
                <i class="fas fa-edit"></i> Content
            </a>
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fas fa-gear"></i> Settings
            </a>
            <a href="{{ route('admin.images') }}" class="{{ request()->routeIs('admin.images') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Media
            </a>
        </nav>
        <div class="sidebar-footer">
            <span class="admin-email">{{ Auth::user()->email ?? 'admin@dolza.com' }}</span>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn"><i class="fas fa-right-from-bracket"></i></button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-header">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="hamburger-menu" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h2>@yield('title', 'Dashboard')</h2>
            </div>
        </header>
        <div class="admin-content">
            @yield('content')
        </div>
    </div>

    <div class="toast-container">
        @if(session('success'))
            <div class="toast toast-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="toast toast-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
        @endif
    </div>

    @stack('scripts')
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        document.querySelectorAll('.toast').forEach(function(t) {
            setTimeout(function() {
                t.style.opacity = '0';
                t.style.transform = 'translateX(100%)';
                t.style.transition = 'all 0.3s ease';
                setTimeout(function() { t.remove(); }, 300);
            }, 3500);
        });
    </script>
</body>
</html>
