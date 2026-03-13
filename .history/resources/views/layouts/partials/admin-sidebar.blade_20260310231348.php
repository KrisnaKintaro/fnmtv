{{-- Admin sidebar menu --}}
<aside class="sidebar">
    <div class="s-brand">
        <span class="s-logo">FNM</span>
        <span class="s-tag">Admin</span>
    </div>
    <div class="s-section">
        <div class="s-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="s-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="s-icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('admin.news.index') }}" class="s-item {{ request()->routeIs('admin.news*') ? 'active' : '' }}">
            <span class="s-icon">📰</span> Berita
        </a>
        <a href="{{ route('admin.categories.index') }}" class="s-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <span class="s-icon">📂</span> Kategori
        </a>
        <a href="{{ route('admin.comments.index') }}" class="s-item {{ request()->routeIs('admin.comments*') ? 'active' : '' }}">
            <span class="s-icon">💬</span> Komentar
        </a>
        <a href="{{ route('admin.finance.index') }}" class="s-item {{ request()->routeIs('admin.finance*') ? 'active' : '' }}">
            <span class="s-icon">💰</span> Finansial
        </a>
        <a href="{{ route('admin.users.index') }}" class="s-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <span class="s-icon">👥</span> Pengguna
        </a>
    </div>
    <div class="s-footer">
        <div class="s-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A',0,1)) }}</div>
        <div>
            <div class="s-uname">{{ Auth::user()->name ?? 'Admin' }}</div>
            <div class="s-urole">{{ Auth::user()->role ?? 'Admin' }}</div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="s-logout">Logout</button>
        </form>
    </div>
</aside>