<style>
    .header-auth-wrap {
        margin-left: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .auth-btn {
        padding: 8px 18px;
        font-size: 13px;
    }

    /* Di HP, sembunyikan teks tombol auth/profil agar tidak nabrak search bar */
    @media screen and (max-width: 576px) {
        .header-auth-wrap {
            margin-left: 10px;
            gap: 6px;
        }
        .auth-text {
            display: none !important;
        }
        .auth-btn {
            padding: 8px 12px !important;
        }
    }

    /* FIX: Munculkan kembali menu Berita Terkini & Populer di HP */
    @media screen and (max-width: 768px) {
        .ts-links {
            display: flex !important; /* Paksa muncul numpa aturan dari viewers_css.css */
            align-items: center;
        }
        .ts-link {
            font-size: 10.5px; /* Dikecilin dikit biar gak nabrak sosmed */
            padding-right: 8px;
            margin-right: 8px;
        }
        .ts-inner {
            padding: 7px 10px; /* Kurangi padding samping biar lega */
        }
    }

    /* Untuk HP layar super kecil (Fold), sembunyikan teksnya sisakan ikonnya saja */
    @media screen and (max-width: 320px) {
        .ts-link span {
            display: none;
        }
    }

    /* ════════════════════════════════════════════════════════════
       🔥 FIX: STYLING DROPDOWN KATEGORI 'LAINNYA' BIAR MUNCUL 🔥
       ════════════════════════════════════════════════════════════ */
    .nav-more {
        position: relative;
        cursor: pointer;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .nav-more-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: #ffffff;
        border: 1px solid var(--border, #e0ddd6);
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        min-width: 180px;
        z-index: 999999 !important; /* Z-index dewa biar selalu paling atas */
        flex-direction: column;
        padding: 5px 0;
        margin-top: 5px;
    }

    /* Class .open ini yang ditrigger oleh JS lu */
    .nav-more-dropdown.open {
        display: flex !important;
    }

    .nmd-item {
        padding: 10px 20px;
        color: var(--text, #1a1a1a);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: background 0.2s;
        border-bottom: 1px solid #f5f5f5;
    }

    .nmd-item:last-child {
        border-bottom: none;
    }

    .nmd-item:hover, .nmd-item.active {
        background: var(--surface2, #f0eeea);
        color: var(--red, #cc0000);
    }

    /* Mencegah Dropdown Terpotong oleh aturan overflow-x (scroll horizontal) di layar kecil/iPad */
    @media screen and (max-width: 768px) {
        .nav-inner {
            overflow: visible !important;
            flex-wrap: wrap !important;
        }
        .nav {
            overflow: visible !important;
        }
    }
</style>

<div class="toast" id="toast"></div>

<div class="topstrip">
    <div class="ts-inner">
        <div class="ts-links">
            <a href="/" class="ts-link {{ request()->is('/') ? 'active' : '' }}">
                <i class="fas fa-bolt" style="margin-right: 3px;"></i> <span>Berita Terkini</span>
            </a>
            <a href="/kategori/populer" class="ts-link {{ request()->is('kategori/populer') ? 'active' : '' }}">
                <i class="fas fa-fire" style="margin-right: 3px;"></i> <span>Berita Populer</span>
            </a>

            <a href="/tentang-kami" class="ts-link {{ request()->is('tentang-kami') ? 'active' : '' }}">
                <i class="fas fa-info-circle" style="margin-right: 3px;"></i><span>About Us</span>
            </a>

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
            <div class="header-tagline" id="siteTagline">Fenomena News Media<br>Delivering unbiased, in-depth reporting</div>

            <div class="header-search" id="searchWrap">
                <input class="search-input" type="text" placeholder="Cari berita, topik, penulis..." id="searchInput" onkeyup="handleSearchKey(event)" autocomplete="off">
                <button class="search-btn" onclick="doSearch()"><i class="fas fa-search"></i></button>
            </div>

            <div class="header-auth-wrap">

                @guest
                <a href="/login" class="btn btn-outline auth-btn"><i class="fas fa-sign-in-alt"></i> <span class="auth-text">Masuk</span></a>
                <a href="/register" class="btn btn-red auth-btn"><i class="fas fa-user-plus"></i> <span class="auth-text">Daftar</span></a>
                @endguest

                @auth
                <div class="user-profile-menu" style="position: relative; cursor: pointer;" onclick="toggleProfileMenu()">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                            {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
                        </div>
                        <span class="auth-text" style="font-weight: 600; font-size: 14px; color: var(--text);">{{ Auth::user()->username ?? 'User' }}</span>
                        <i class="fas fa-chevron-down auth-text" style="font-size: 10px; color: var(--muted);"></i>
                    </div>

                    <div id="profileDropdown" style="display: none; position: absolute; top: 120%; right: 0; background: white; border: 1px solid var(--border); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px; width: 180px; overflow: hidden; z-index: 999999;">
                        <a href="/profil" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; text-decoration: none; color: var(--text); border-bottom: 1px solid var(--border);">
                            <i class="fas fa-user-edit" style="color: var(--red);"></i> Edit Profil
                        </a>
                        <a href="/logout" onclick="confirmLogout(event)" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; text-decoration: none; color: #dc3545;">
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

    window.addEventListener('click', function(e) {
        if (!document.querySelector('.user-profile-menu')?.contains(e.target)) {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) dropdown.style.display = 'none';
        }
    });
</script>
