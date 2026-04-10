@extends('Viewers.master_viewers')

@section('css')
<style>
    /* FIX 1: Bikin tinggi banner fix 400px biar ga raksasa */
    .hero-grid {
        background-color: var(--border);
        gap: 2px;
        border: 2px solid var(--border);
        height: 400px; /* Tinggi fix */
    }
    .hero-main {
        height: 100%;
        min-height: auto;
    }
    .hero-side {
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .hero-thumb {
        flex: 1; /* Biar 3 gambar samping bagi rata tingginya */
        min-height: auto;
    }
</style>
@endsection

@section('konten')
<div class="container page-anim">

    <div class="hero-section" style="margin-bottom: 30px;">
        <div class="hero-grid" id="heroContainer">
            <div style="padding: 40px; text-align: center; width: 100%; grid-column: span 2; color: var(--muted);">
                Memuat Headline...
            </div>
        </div>
    </div>

    <div class="main-grid">

        <div class="main-content">

            <div class="sec-head">
                <div class="sec-bar"></div>
                <div class="sec-title">Berita Terkini</div>
                <a href="/search?q=" class="sec-link">Lihat Semua ➔</a>
            </div>
            <hr class="sec-divider">

            <div class="news-grid-2" id="terkiniGrid"></div>

            <div style="margin: 30px 0;">
                @include('Viewers.layout.ad_banner', [
                    'type' => 'horizontal',
                    'text' => 'SPACE IKLAN 728x90'
                ])
            </div>

            <div class="sec-head">
                <div class="sec-bar"></div>
                <div class="sec-title">Baru Saja Rilis</div>
            </div>

            <hr class="sec-divider">

            <div class="news-list" id="latestNewsContainer">
                <div style="text-align: center; color: var(--muted); padding: 20px;">
                    Memuat berita terbaru...
                </div>
            </div>

        </div> <div class="sidebar-col">
            @include('Viewers.layout.sidebar')
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        loadHomeData();
    });

    function loadHomeData() {
        $.ajax({
            url: '/api/viewers/berita',
            type: 'GET',
            success: function(res) {
                if (res.status === 'success') {
                    renderHeadline(res.data.headline);
                    renderTerbaru(res.data.terbaru);
                    renderTrending(res.data.trending);
                }
            },
            error: function(err) {
                console.error("Gagal load data home:", err);
                Toast.show('error', 'Gagal memuat data berita terbaru!');
            }
        });
    }

    function formatWaktu(dateString) {
        if (!dateString) return '';
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    const catColors = {
        'politik': 'cat-politik',
        'ekonomi': 'cat-ekonomi',
        'olahraga': 'cat-olahraga',
        'teknologi': 'cat-teknologi',
        'kesehatan': 'cat-kesehatan',
        'hukum': 'cat-hukum',
        'lingkungan': 'cat-lingkungan',
        'budaya': 'cat-budaya'
    };

    function getCatClass(nama) {
        const key = (nama || '').toLowerCase();
        return catColors[key] || 'cat-hukum';
    }

    function renderHeadline(data) {
        const container = document.getElementById('heroContainer');
        if (!data || data.length === 0) {
            container.innerHTML = '<div style="padding:40px;text-align:center;">Belum ada headline cuy.</div>';
            return;
        }

        let html = '';

        // 1. Gambar Utama
        const main = data[0];
        const mainCat = main.kategori ? main.kategori.nama_kategori : 'Umum';
        const mainPenulis = main.user ? main.user.username : 'FNM Redaksi';

        let imgMain = main.foto_thumbnail;
        if (imgMain && !imgMain.startsWith('http')) imgMain = `/uploads/thumbnail/${imgMain}`;

        // FIX 2: Gambar dibungkus tag .hero-img biar jadi background melayang (absolute)
        const thumbMain = imgMain ? `<div class="hero-img" style="opacity: 1;"><img src="${imgMain}" style="width:100%;height:100%;object-fit:cover;"></div>` : `<div class="hero-img">📰</div>`;

        html += `
            <div class="hero-main" onclick="window.location.href='/berita/${main.slug}'">
                ${thumbMain}
                <div class="hero-overlay">
                    <div class="hero-cat">${mainCat}</div>
                    <div class="hero-title">${main.judul_berita}</div>
                    <div class="hero-meta">Oleh <b>${mainPenulis}</b> · ${formatWaktu(main.waktu_publikasi)}</div>
                </div>
            </div>
        `;

        // 2. Gambar Samping
        html += `<div class="hero-side">`;
        for (let i = 1; i <= 3; i++) {
            if (data[i]) {
                const side = data[i];
                const sideCat = side.kategori ? side.kategori.nama_kategori : 'Umum';

                let imgSide = side.foto_thumbnail;
                if (imgSide && !imgSide.startsWith('http')) imgSide = `/uploads/thumbnail/${imgSide}`;

                // FIX 2: Gambar dibungkus tag .ht-img
                const thumbSide = imgSide ? `<div class="ht-img" style="opacity: 1;"><img src="${imgSide}" style="width:100%;height:100%;object-fit:cover;"></div>` : `<div class="ht-img" style="font-size:40px;opacity:0.2;">📰</div>`;

                html += `
                    <div class="hero-thumb" onclick="window.location.href='/berita/${side.slug}'">
                        ${thumbSide}
                        <div class="ht-overlay">
                            <div class="ht-cat">${sideCat}</div>
                            <div class="ht-title">${side.judul_berita}</div>
                        </div>
                    </div>
                `;
            }
        }
        html += `</div>`;
        container.innerHTML = html;
    }

    function renderTerbaru(data) {
        const gridContainer = document.getElementById('terkiniGrid');
        const listContainer = document.getElementById('latestNewsContainer');

        if (!data || data.length === 0) {
            gridContainer.innerHTML = '';
            listContainer.innerHTML = '<div style="padding:20px;text-align:center;">Belum ada berita rilis.</div>';
            return;
        }

        let gridHtml = '';
        let listHtml = '';

        data.forEach((item, index) => {
            const cat = item.kategori ? item.kategori.nama_kategori : 'Umum';
            const penulis = item.user ? item.user.username : 'FNM Redaksi';

            let img = item.foto_thumbnail;
            if (img && !img.startsWith('http')) img = `/uploads/thumbnail/${img}`;

            if (index < 2) {
                const thumb = img ? `<img src="${img}" style="width:100%;height:100%;object-fit:cover;">` : `📰`;
                gridHtml += `
                    <div class="news-card" onclick="window.location.href='/berita/${item.slug}'">
                        <div class="nc-img" style="${img ? 'padding:0;' : ''}">${thumb}</div>
                        <div class="nc-cat ${getCatClass(cat)}">${cat}</div>
                        <div class="nc-title">${item.judul_berita}</div>
                        <div class="nc-meta">${formatWaktu(item.waktu_publikasi)} · 👁 ${fmtNum(item.jumlah_view)} views</div>
                    </div>
                `;
            } else {
                const thumb = img ? `<img src="${img}" style="width:100%;height:100%;object-fit:cover;">` : `📰`;
                listHtml += `
                    <div class="news-list-item" onclick="window.location.href='/berita/${item.slug}'">
                        <div class="nli-img" style="${img ? 'padding:0; overflow:hidden;' : ''}">${thumb}</div>
                        <div>
                            <div class="nli-cat ${getCatClass(cat)}">${cat}</div>
                            <div class="nli-title">${item.judul_berita}</div>
                            <div class="nli-meta">${formatWaktu(item.waktu_publikasi)} · Oleh ${penulis}</div>
                        </div>
                    </div>
                `;
            }
        });

        gridContainer.innerHTML = gridHtml;
        listContainer.innerHTML = listHtml;
    }

    function renderTrending(data) {
        const container = document.getElementById('trendingContainer');
        if (!container) return;

        if (!data || data.length === 0) {
            container.innerHTML = '<div style="padding:10px 0; color:var(--muted); font-size:13px;">Belum ada trending.</div>';
            return;
        }

        let html = '';
        const colors = ['gold', 'silver', 'bronze', '', ''];

        data.forEach((item, index) => {
            const rankClass = colors[index] || '';
            const isHot = index === 0 ? '<span class="tr-badge hot">HOT</span>' : (index === 1 ? '<span class="tr-badge up">NAIK</span>' : '');

            html += `
                <a href="/berita/${item.slug}" class="trending-item">
                    <div class="tr-rank ${rankClass}" ${index > 2 ? 'style="color:var(--muted)"' : ''}>${index + 1}</div>
                    <div>
                        <div class="tr-title">${item.judul_berita}</div>
                        <div class="tr-views">👁 ${fmtNum(item.jumlah_view)} ${isHot}</div>
                    </div>
                </a>
            `;
        });

        container.innerHTML = html;
    }
</script>
@endsection
