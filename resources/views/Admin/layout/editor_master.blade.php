<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FNM — Panel Editor</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_css.css') }}">
    @yield('css')
</head>
<body>
  <!-- ═══════════ SIDEBAR ═══════════ -->
  <aside class="sidebar">
    <div class="s-brand">
      <div>
        <div class="s-logo">FNM</div>
        <div class="s-tag">Editor Panel</div>
      </div>
      <div class="s-editor-badge">Editor</div>
    </div>

    <div class="s-section">
      <div class="s-label">Konten</div>
      <a class="s-item" onclick="showPage('write-news', this)">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tulis Berita Baru
      </a>
      <a class="s-item active" onclick="showPage('my-news', this)">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21" stroke-width="2" stroke-linecap="round"/></svg>
        Berita Saya
        <span class="s-badge">9</span>
      </a>
    </div>

    <div class="s-footer">
      <div class="s-avatar">B</div>
      <div>
        <div class="s-uname">Budi Santoso</div>
        <div class="s-urole">Editor</div>
      </div>
      <div class="s-logout" onclick="doLogout()" title="Keluar">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
      </div>
    </div>
  </aside>

  <!-- ═══════════ MAIN ═══════════ -->
  <main class="main">
    <!-- TOPBAR -->
    <header class="topbar">
      <div style="flex:1">
        <div class="tb-title" id="tbTitle">Berita Saya</div>
        <div class="tb-breadcrumb" id="tbCrumb">Editor / Berita Saya</div>
      </div>
      <div class="search-wrap">
        <svg width="13" height="13" fill="none" stroke="#7a7570" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2"/></svg>
        <input type="text" placeholder="Cari berita saya...">
      </div>
      <div style="position:relative;">
        <div class="tb-icon" onclick="toggleNotif()">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
          <div class="tb-dot"></div>
        </div>
        <div class="notif-panel" id="notifPanel">
          <div class="notif-head">Notifikasi <span style="color:var(--red);">(2)</span></div>
          <div class="notif-item"><div class="notif-ico">❌</div><div class="notif-txt"><div class="notif-msg">1 artikel Anda ditolak oleh Redaksi</div><div class="notif-t">30 menit lalu</div></div></div>
          <div class="notif-item"><div class="notif-ico">✅</div><div class="notif-txt"><div class="notif-msg">Artikel "Timnas Garuda..." telah diterbitkan</div><div class="notif-t">2 jam lalu</div></div></div>
        </div>
      </div>
      <button class="btn btn-red" onclick="showPage('write-news', document.querySelector('.s-item'))">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tulis Berita
      </button>
    </header>

    @yield('konten')
  </main>

  <script src="{{ asset('admin/js/admin_js.js') }}"></script>
  @yield('js')
</body>
</html>
