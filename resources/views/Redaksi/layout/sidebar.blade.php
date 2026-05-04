<aside class="sidebar">
    <div class="s-brand">
        <div>
            <div class="s-logo">FNM</div>
            <div class="s-tag">Redaksi Panel</div>
        </div>
        <div class="s-role-badge">Redaksi</div>
    </div>

    <div class="s-section">
        <div class="s-label">Konten</div>
        <a href="/redaksi-manajemen-berita" class="s-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z" />
                <polyline points="17 21 17 13 7 13 7 21" stroke-width="2" stroke-linecap="round" />
            </svg>
            Manajemen Berita
            <span class="s-badge" id="pendingCount">5</span>
        </a>
    </div>

    <div class="s-footer">
        @auth
        <div class="s-avatar">
            {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
        </div>
        <div>
            <div class="s-uname"> {{ Auth::user()->username ?? 'User' }} </div>
            <div class="s-urole"> {{ Auth::user()->role ?? 'User' }} </div>
        </div>
        @endauth
        <div class="s-logout" onclick="doLogout(event)" title="Keluar">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </div>
    </div>
</aside>
