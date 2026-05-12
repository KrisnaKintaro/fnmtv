<aside class="sidebar">
  <div class="s-brand">
    <div>
      <div class="s-logo">FNM</div>
      <div class="s-tag">Editor Panel</div>
    </div>
    <div class="s-role-badge">Editor</div>
  </div>

  <div class="s-section">
    <div class="s-label">Konten</div>
    <a href="/tulis-editor" class="s-item">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tulis Berita Baru
    </a>
    <a href="/berita-saya" class="s-item">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21" stroke-width="2" stroke-linecap="round"/></svg>
      Berita Saya
      <span class="s-badge" id="badgeEditorDitolak" style="background:var(--red);color:#fff;display:none;">0</span>
    </a>
  </div>

  <div class="s-section">
      <div class="s-label">Konten</div>
      
      <a href="/tulis-editor" class="s-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tulis Berita Baru
      </a>

      <a href="/berita-saya" class="s-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21" stroke-width="2" stroke-linecap="round"/></svg>
        Berita Saya
        <span class="s-badge" id="badgeEditorDitolak" style="background:var(--red);color:#fff;display:none;">0</span>
      </a>

      <!-- TAMBAHKAN MENU IKLAN DI SINI -->
      <a href="/iklan" class="s-item {{ Request::is('iklan') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
        </svg>
        Manajemen Iklan
      </a>
  </div>

  <div class="s-section">
    <div class="s-label">Sistem</div>
    <a href="/editor/profil" class="s-item">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      Edit Profil
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
    <div class="s-logout" onclick="doLogout(event)" title="Keluar" style="cursor:pointer;">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
    </div>
  </div>
</aside>
