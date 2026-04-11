<div class="topstrip">
    <div class="ts-inner">
        <div class="ts-links">
            <a href="/" class="ts-link {{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-bolt" style="margin-right: 5px;"></i> Berita Terkini</a>
            <a href="/kategori/populer" class="ts-link {{ request()->is('kategori/populer') ? 'active' : '' }}"><i class="fas fa-fire" style="margin-right: 5px;"></i> Berita Populer</a>
        </div>
        <div class="ts-socials">
            <div class="ts-social" title="Facebook" onclick="openSocial('facebook')"><i class="fab fa-facebook-f"></i></div>
            <div class="ts-social" title="Instagram" onclick="openSocial('instagram')"><i class="fab fa-instagram"></i></div>
            <div class="ts-social" title="WhatsApp" onclick="openSocial('whatsapp')"><i class="fab fa-whatsapp"></i></div>
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
                <button class="search-btn" onclick="doSearch()"><i class="fas fa-search"></i></button>
            </div>

            <div style="margin-left: 20px; display: flex; gap: 10px; align-items: center;">

                @guest
                    <a href="/login" class="btn btn-outline" style="padding: 8px 18px; font-size: 13px;"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                    <a href="/register" class="btn btn-red" style="padding: 8px 18px; font-size: 13px;"><i class="fas fa-user-plus"></i> Daftar</a>
                @endguest

                @auth
                    <div class="user-profile-menu" style="position: relative; cursor: pointer;" onclick="toggleProfileMenu()">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                                {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
                            </div>
                            <span style="font-weight: 600; font-size: 14px; color: var(--text);">{{ Auth::user()->username ?? 'User' }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 10px; color: var(--muted);"></i>
                        </div>

                        <div id="profileDropdown" style="display: none; position: absolute; top: 120%; right: 0; background: white; border: 1px solid var(--border); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px; width: 180px; overflow: hidden; z-index: 100;">
                            <a href="/profil" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; text-decoration: none; color: var(--text); border-bottom: 1px solid var(--border);">
                                <i class="fas fa-user-edit" style="color: var(--primary);"></i> Edit Profil
                            </a>
                            <a href="/logout" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; text-decoration: none; color: #dc3545;">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                        </div>
                    </div>
                @endauth

            </div>

        </div>
    </div>

    <div class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-item" id="navHome"><i class="fas fa-home" style="margin-right: 5px;"></i> HOME</a>

            <div id="dynamicNavCategories" style="display: contents;"></div>

            <div class="nav-more" id="navMore" onclick="toggleNavMore()" style="display: none;">
                Lainnya <i class="fas fa-caret-down" style="margin-left: 3px;"></i>
                <div class="nav-more-dropdown" id="navMoreDropdown">
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleProfileMenu() {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) {
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
    }

    // Nutup dropdown kalau user klik di luar area profil
    window.addEventListener('click', function(e) {
        if (!document.querySelector('.user-profile-menu')?.contains(e.target)) {
            const dropdown = document.getElementById('profileDropdown');
            if(dropdown) dropdown.style.display = 'none';
        }
    });
</script>
