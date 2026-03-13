{{-- Admin sidebar menu --}}
<aside class="sidebar" id="sidebar">
  <div class="s-brand">
    <div>
      <div class="s-logo">FNM</div>
      <div class="s-tag">Admin Panel</div>
    </div>
    <div class="s-admin-badge">Admin</div>
  </div>

  <div class="s-section">
    <div class="s-label">Utama</div>
    <a href="{{ route('admin.dashboard') }}" onclick="showPage('dashboard',this)" class="s-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
      Dashboard
    </a>
  </div>

  <div class="s-section">
    <div class="s-label">Konten</div>
    <a href="{{ route('admin.news.index') }}" onclick="showPage('news-list',this)" class="s-item {{ request()->routeIs('admin.news*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21" stroke-width="2" stroke-linecap="round"/></svg>
      Manajemen Berita
      <span class="s-badge">247</span>
    </a>
    <a href="" onclick="showPage('write-news',this)" class="s-item">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tulis Berita Baru
    </a>
    <a href="{{ route('admin.categories.index') }}" onclick="showPage('categories',this)" class="s-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5l7 7-7 7-5-5V3z"/></svg>
      Manajemen Kategori
    </a>
    <a href="{{ route('admin.comments.index') }}" onclick="showPage('comments',this)" class="s-item {{ request()->routeIs('admin.comments*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/></svg>
      Moderasi Komentar
      <span class="s-badge" style="background:var(--red);color:#fff;">12</span>
    </a>
  </div>

  <div class="s-section">
    <div class="s-label">Finansial</div>
    <a href="{{ route('admin.finance.index') }}" onclick="showPage('finance',this)" class="s-item {{ request()->routeIs('admin.finance*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4-1.343 4-3-1.79-3-4-3zM12 2v2m0 16v2m10-10h-2M4 12H2"/></svg>
      Administrasi Finansial
    </a>
  </div>

  <div class="s-section">
    <div class="s-label">Sistem</div>
    <a href="{{ route('admin.users.index') }}" onclick="showPage('users',this)" class="s-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      Manajemen User
    </a>
    <a href="" onclick="showPage('settings',this)" class="s-item">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.310.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.310-2.37 2.370a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.310-.826-2.370-2.370a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.310 2.370-2.370.996.608 2.296.070 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
      Pengaturan
    </a>
  </div>

  <div class="s-footer">
    <div class="s-avatar">A</div>
    <div>
      <div class="s-uname">Admin FNM</div>
      <div class="s-urole">Super Admin</div>
    </div>
    <div class="s-logout" onclick="doLogout()" title="Keluar">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
    </div>
  </div>
</aside>