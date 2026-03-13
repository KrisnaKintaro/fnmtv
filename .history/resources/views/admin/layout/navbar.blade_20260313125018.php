<header class="topbar">
    <div style="flex:1">
      <div class="tb-title" id="tbTitle">Dashboard</div>
      <div class="tb-breadcrumb" id="tbCrumb">Admin / Dashboard</div>
    </div>
    <div class="search-wrap">
      <svg width="13" height="13" fill="none" stroke="#7a7570" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2"/></svg>
      <input type="text" placeholder="Cari berita, penulis...">
    </div>
    <div style="position:relative;">
      <div class="tb-icon" onclick="toggleNotif()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <div class="tb-dot"></div>
      </div>
      <div class="notif-panel" id="notifPanel">
        <div class="notif-head">Notifikasi <span style="color:var(--red);">(3)</span></div>
        <div class="notif-item"><div class="notif-ico">💬</div><div class="notif-txt"><div class="notif-msg">12 komentar baru perlu dimoderasi</div><div class="notif-t">5 menit lalu</div></div></div>
        <div class="notif-item"><div class="notif-ico">📋</div><div class="notif-txt"><div class="notif-msg">3 artikel menunggu review editor</div><div class="notif-t">1 jam lalu</div></div></div>
        <div class="notif-item"><div class="notif-ico">💰</div><div class="notif-txt"><div class="notif-msg">Tagihan baru: Rp 500.000 belum dibayar</div><div class="notif-t">2 jam lalu</div></div></div>
      </div>
    </div>
    <button class="btn btn-red" onclick="showPage('write-news', null)">
      <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tulis Berita
    </button>
  </header>