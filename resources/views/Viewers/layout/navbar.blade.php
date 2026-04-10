<div class="topstrip">
    <div class="ts-inner">
        <div class="ts-links">
            <a href="/" class="ts-link {{ request()->is('/') ? 'active' : '' }}">Berita Terkini</a>
            <a href="/kategori/populer" class="ts-link {{ request()->is('kategori/populer') ? 'active' : '' }}">Berita Populer</a>
        </div>
        <div class="ts-socials">
            <div class="ts-social" title="Facebook" onclick="openSocial('facebook')">f</div>
            <div class="ts-social" title="Instagram" onclick="openSocial('instagram')">📷</div>
            <div class="ts-social" title="WhatsApp" onclick="openSocial('whatsapp')">📱</div>
        </div>
    </div>
</div>

<div class="sticky-header-wrap">

    <div class="header">
        <div class="header-inner">
            <a href="/" class="logo">FNM</a>
            <div class="header-tagline">Fenomena News Media<br>Delivering unbiased, in-depth reporting</div>

            <div class="header-search" id="searchWrap">
                <input class="search-input" type="text" placeholder="Cari berita, topik, penulis..." id="searchInput" onkeyup="handleSearchKey(event)" autocomplete="off">
                <button class="search-btn" onclick="doSearch()">🔍</button>
            </div>

            <div style="margin-left: 20px; display: flex; gap: 10px;">
                <a href="/login" class="btn btn-outline" style="padding: 8px 18px; font-size: 13px;">Masuk</a>
                <a href="/register" class="btn btn-red" style="padding: 8px 18px; font-size: 13px;">Daftar</a>
            </div>

        </div>
    </div>

    <div class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-item" id="navHome">HOME</a>

            <div id="dynamicNavCategories" style="display: contents;"></div>

            <div class="nav-more" id="navMore" onclick="toggleNavMore()" style="display: none;">
                Lainnya <span>▾</span>
                <div class="nav-more-dropdown" id="navMoreDropdown">
                </div>
            </div>
        </div>
    </div>

</div>
