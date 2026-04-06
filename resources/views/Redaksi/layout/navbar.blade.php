  <!-- TOPBAR -->
  <header class="topbar">
      <div class="tb-left">
          <div class="tb-title" id="tbTitle">Manajemen Berita</div>
          <div class="tb-breadcrumb" id="tbCrumb">Redaksi / Manajemen Berita</div>
      </div>
      <div class="search-wrap">
          <svg width="13" height="13" fill="none" stroke="#7a7570" viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="8" stroke-width="2" />
              <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
          </svg>
          <input type="text" id="searchInput" onkeyup="filterChanged()" placeholder="Cari judul berita, penulis...">
      </div>
      <div style="position:relative;">
          <div class="tb-icon" onclick="toggleNotif()">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <div class="tb-dot"></div>
          </div>
          <div class="notif-panel" id="notifPanel">
              <div class="notif-head">Notifikasi <span style="color:var(--red);">(2)</span></div>
              <div class="notif-item">
                  <div class="notif-ico">📋</div>
                  <div>
                      <div class="notif-msg">5 artikel baru menunggu verifikasi Anda</div>
                      <div class="notif-t">15 menit lalu</div>
                  </div>
              </div>
              <div class="notif-item">
                  <div class="notif-ico">✅</div>
                  <div>
                      <div class="notif-msg">Artikel "KTT ASEAN..." berhasil diterbitkan</div>
                      <div class="notif-t">2 jam lalu</div>
                  </div>
              </div>
          </div>
      </div>
  </header>
