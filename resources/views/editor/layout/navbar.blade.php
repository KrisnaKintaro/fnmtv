<style>
    .burger-menu-btn {
        display: inline-flex;
        background: none;
        border: none;
        color: var(--text, #1a1a1a);
        font-size: 18px;
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 6px;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
        flex-shrink: 0;
        margin-right: 6px;
    }
    .burger-menu-btn:hover {
        background: var(--surface2, #f0eeea);
    }
</style>

<header class="topbar">
    <button class="burger-menu-btn" onclick="toggleSidebar()" title="Toggle Menu">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div style="flex:1; min-width: 0;">
        <div class="tb-title" id="tbTitle">@yield('title', 'Editor Panel')</div>
        <div class="tb-breadcrumb" id="tbCrumb">@yield('breadcrumb', 'Editor')</div>
    </div>

    @if(Request::is('berita-saya') || Request::is('editor'))
    <div class="search-wrap">
        <svg width="13" height="13" fill="none" stroke="#7a7570" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8" stroke-width="2" />
            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
        </svg>
        <input type="text" id="searchInput" onkeyup="if(typeof jalankanFilter === 'function') jalankanFilter()" placeholder="Cari berita saya...">
    </div>
    @endif

    <div style="position:relative; flex-shrink: 0;">
        <div class="tb-icon" style="overflow: visible;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="tb-dot" style="display:none; position:absolute; top:-6px; right:-6px; background:var(--red); color:white; font-size:10px; font-weight:bold; height:16px; min-width:16px; border-radius:50px; align-items:center; justify-content:center; padding:0 4px; border: 2px solid white;">0</span>
        </div>
        <div class="notif-panel" id="notifPanel"></div>
    </div>

    <a href="{{ url('/tulis-editor') }}" class="btn btn-red" style="text-decoration:none;">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tulis Berita
    </a>
</header>

@if(Request::is('berita-saya') || Request::is('editor'))
<div class="mobile-search-wrap">
    <div class="search-box">
        <svg width="13" height="13" fill="none" stroke="#7a7570" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8" stroke-width="2"/>
            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2"/>
        </svg>
        <input type="text" class="mobile-search-input" onkeyup="if(typeof jalankanFilter === 'function') jalankanFilter()" placeholder="Cari berita saya...">
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var desktopSearch = document.getElementById('searchInput');
        var mobileSearch = document.querySelector('.mobile-search-input');

        if (desktopSearch && mobileSearch) {
            mobileSearch.addEventListener('input', function() {
                desktopSearch.value = this.value;
            });
            desktopSearch.addEventListener('input', function() {
                mobileSearch.value = this.value;
            });
        }
    });
</script>
@endif
