<div class="topstrip">
    <div class="ts-inner">
        <div class="ts-links">
            <a href="/" class="ts-link {{ request()->is('/') ? 'active' : '' }}">Berita Terkini</a>
            <a href="/kategori/populer" class="ts-link {{ request()->is('kategori/populer') ? 'active' : '' }}">Berita Populer</a>
            <a href="/kategori/pilihan-editor" class="ts-link {{ request()->is('kategori/pilihan-editor') ? 'active' : '' }}">Pilihan Editor</a>
        </div>
        <div class="ts-socials">
            <div class="ts-social" title="Facebook" onclick="openSocial('facebook')">f</div>
            <div class="ts-social" title="Instagram" onclick="openSocial('instagram')">📷</div>
            <div class="ts-social" title="WhatsApp" onclick="openSocial('whatsapp')">📱</div>
        </div>
    </div>
</div>

<div class="header">
    <div class="header-inner">
        <a href="/" class="logo">FNM</a>
        <div class="header-tagline">Fenomena News Media<br>Delivering unbiased, in-depth reporting</div>
        <div class="header-search" id="searchWrap">
            <input class="search-input" type="text" placeholder="Cari berita, topik, penulis..." id="searchInput" onkeyup="handleSearchKey(event)" autocomplete="off">
            <button class="search-btn" onclick="doSearch()">🔍</button>
        </div>
    </div>
</div>

<div class="nav">
    <div class="nav-inner">
        <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">HOME</a>
        <a href="/kategori/politik" class="nav-item {{ request()->is('kategori/politik') ? 'active' : '' }}">Politik</a>
        <a href="/kategori/ekonomi" class="nav-item {{ request()->is('kategori/ekonomi') ? 'active' : '' }}">Ekonomi</a>
        <a href="/kategori/olahraga" class="nav-item {{ request()->is('kategori/olahraga') ? 'active' : '' }}">Olahraga</a>
        <a href="/kategori/teknologi" class="nav-item {{ request()->is('kategori/teknologi') ? 'active' : '' }}">Teknologi</a>
        <a href="/kategori/kesehatan" class="nav-item {{ request()->is('kategori/kesehatan') ? 'active' : '' }}">Kesehatan</a>

        <div class="nav-more" id="navMore" onclick="toggleNavMore()">
            Lainnya <span>▾</span>
            <div class="nav-more-dropdown" id="navMoreDropdown">
                <a href="/kategori/hukum" class="nmd-item">⚖️ Hukum</a>
                <a href="/kategori/lingkungan" class="nmd-item">🌿 Lingkungan</a>
                <a href="/kategori/budaya" class="nmd-item">🎭 Budaya</a>
            </div>
        </div>
    </div>
</div>
