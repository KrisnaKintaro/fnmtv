<!-- TOAST VIew -->
<div class="toast" id="toast"></div>

<!-- TOP STRIP -->
<div class="topstrip">
  <div class="ts-inner">
    <div class="ts-links">
      <div class="ts-link active" id="ts-terkini" onclick="filterTopStrip('terkini', this)">Berita Terkini</div>
      <div class="ts-link" id="ts-populer" onclick="filterTopStrip('populer', this)">Berita Populer</div>
      <div class="ts-link" id="ts-editor" onclick="filterTopStrip('editor', this)">Pilihan Editor</div>
      <div class="ts-link" id="ts-artikel" onclick="filterTopStrip('artikel', this)">Artikel</div>
    </div>
    <div class="ts-socials">
      <div class="ts-social" title="Facebook" onclick="openSocial('facebook')">f</div>
      <div class="ts-social" title="Instagram" onclick="openSocial('instagram')">📷</div>
      <div class="ts-social" title="WhatsApp" onclick="openSocial('whatsapp')">📱</div>
      <div class="ts-social" title="Akun">👤</div>
    </div>
  </div>
</div>

<!-- HEADER -->
<div class="header">
  <div class="header-inner">
    <div class="logo" onclick="goHome()">FNM</div>
    <div class="header-tagline">Fenomena News Media<br>Delivering unbiased, in-depth reporting</div>
    <div class="header-search" id="searchWrap">
      <input class="search-input" type="text" placeholder="Cari berita, topik, penulis..." id="searchInput" oninput="liveSearch(this.value)" onkeydown="handleSearchKey(event)" autocomplete="off">
      <button class="search-btn" onclick="doSearch()">🔍</button>
      <div class="search-dropdown" id="searchDropdown"></div>
    </div>
  </div>
</div>

<!-- NAV (UC-09) -->
<div class="nav">
  <div class="nav-inner">
    <div class="nav-item active" data-cat="home" onclick="setNav(this,'home')">HOME</div>
    <div class="nav-item" data-cat="terkini" onclick="setNav(this,'terkini')">Terkini</div>
    <div class="nav-item" data-cat="politik" onclick="setNav(this,'politik')">Politik</div>
    <div class="nav-item" data-cat="ekonomi" onclick="setNav(this,'ekonomi')">Ekonomi</div>
    <div class="nav-item" data-cat="olahraga" onclick="setNav(this,'olahraga')">Olahraga</div>
    <div class="nav-item" data-cat="teknologi" onclick="setNav(this,'teknologi')">Teknologi</div>
    <div class="nav-item" data-cat="kesehatan" onclick="setNav(this,'kesehatan')">Kesehatan</div>
    <div class="nav-more" id="navMore" onclick="toggleNavMore()">
      Lainnya <span>▾</span>
      <div class="nav-more-dropdown" id="navMoreDropdown">
        <div class="nmd-item" onclick="setNav(null,'hukum')">⚖️ Hukum</div>
        <div class="nmd-item" onclick="setNav(null,'lingkungan')">🌿 Lingkungan</div>
        <div class="nmd-item" onclick="setNav(null,'budaya')">🎭 Budaya</div>
        <div class="nmd-item" onclick="setNav(null,'pendidikan')">🎓 Pendidikan</div>
        <div class="nmd-item" onclick="setNav(null,'bencana')">🌊 Bencana</div>
      </div>
    </div>
  </div>
</div>
