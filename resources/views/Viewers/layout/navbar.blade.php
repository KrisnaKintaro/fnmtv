<!-- TOP STRIP -->
<div class="topstrip">
  <div class="ts-inner">
    <div class="ts-links">
      <div class="ts-link active" id="tsBeritaTerkini" onclick="filterTop('terkini')">Berita Terkini</div>
      <div class="ts-link" id="tsBeritaPopuler" onclick="filterTop('populer')">Berita Populer</div>
      <div class="ts-link" id="tsPilihanEditor" onclick="filterTop('editor')">Pilihan Editor</div>
      <div class="ts-link" id="tsArtikel" onclick="filterTop('artikel')">Artikel</div>
    </div>
    <div class="ts-socials">
      <div class="ts-social" title="Facebook">f</div>
      <div class="ts-social" title="Instagram">📷</div>
      <div class="ts-social" title="WhatsApp">📱</div>
      <div class="ts-social" title="Account">👤</div>
    </div>
  </div>
</div>

<!-- HEADER -->
<div class="header">
  <div class="header-inner">
    <div class="logo" onclick="goHome()">FNM</div>
    <div class="header-tagline">Fenomena News Media<br>Delivering unbiased, in-depth reporting</div>
    <div class="header-search">
      <input class="search-input" type="text" placeholder="Cari berita..." id="searchInput" onkeydown="if(event.key==='Enter')doSearch()">
      <button class="search-btn" onclick="doSearch()">🔍</button>
    </div>
  </div>
</div>

<!-- NAV (UC-09) -->
<div class="nav">
  <div class="nav-inner">
    <div class="nav-item active" onclick="setNav(this,'home')">HOME</div>
    <div class="nav-item" onclick="setNav(this,'terkini')">Terkini</div>
    <div class="nav-item" onclick="setNav(this,'politik')">Politik</div>
    <div class="nav-item" onclick="setNav(this,'kesehatan')">Kesehatan</div>
    <div class="nav-item" onclick="setNav(this,'ekonomi')">Ekonomi</div>
    <div class="nav-item" onclick="setNav(this,'olahraga')">Olahraga</div>
    <div class="nav-item" onclick="setNav(this,'teknologi')">Teknologi</div>
    <div class="nav-more" onclick="alert('Lihat semua kategori')">
      Kategori Lainnya <span>▾</span>
    </div>
  </div>
</div>