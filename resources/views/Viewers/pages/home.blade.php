@extends('Viewers.master_viewers')

@section('css')
<style>
    .hero-grid {
        background-color: var(--border);
        gap: 2px;
        border: 2px solid var(--border);
        height: 400px;
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
        flex: 1;
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

            <div style="margin: 30px 0;" id="space-promo-tengah">
                @include('Viewers.layout.promo_banner', [
                    'id' => 'homePromoSpace',
                    'type' => 'horizontal'
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

        </div>

        <div class="sidebar-col">
            @include('Viewers.layout.sidebar')
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        loadHomeData();
        loadViewerPromos();
    });

    function loadViewerPromos() {
        $.ajax({
            url: '/api/viewers/iklan',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status !== 'success') return;

                var desktopPromo = res.data.horizontal_728x90 && res.data.horizontal_728x90.length
                    ? res.data.horizontal_728x90[0] : null;
                var sidebarPromo = res.data.sidebar_300x250 && res.data.sidebar_300x250.length
                    ? res.data.sidebar_300x250[0] : null;

                renderPromoSlot('homePromoSpace', desktopPromo);
                renderPromoSlot('sidebarPromoSpace', sidebarPromo);
            },
            error: function(err) {
                console.error('Gagal load promo viewer:', err);
            }
        });
    }

    function renderPromoSlot(elementId, promo) {
        var wrapper = document.getElementById(elementId);
        if (!wrapper) return;

        if (!promo) return; // tidak ada promo, biarkan placeholder tampil

        var content = wrapper.querySelector('.promo-content');
        if (!content) return;

        var html = '';
        if (promo.link_tujuan) {
            html += '<a href="' + promo.link_tujuan + '" target="_blank" rel="noopener noreferrer" style="display:block; width:100%;">'
                + '<img src="/storage/' + promo.gambar + '" alt="' + promo.judul + '" style="width:100%; height:auto; border-radius: 8px; object-fit:contain;">'
                + '</a>';
        } else {
            html += '<img src="/storage/' + promo.gambar + '" alt="' + promo.judul + '" style="width:100%; height:auto; border-radius: 8px; object-fit:contain;">';
        }
        if (promo.judul) {
            html += '<div style="margin-top: 10px; font-size: 14px; font-weight: 700;">' + promo.judul + '</div>';
        }
        content.innerHTML = html;
    }

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
            }
        });
    }

    function formatWaktu(dateString) {
        if (!dateString) return '';
        var options = { day: 'numeric', month: 'short', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    var catColors = {
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
        var key = (nama || '').toLowerCase();
        return catColors[key] || 'cat-hukum';
    }

    function renderHeadline(data) {
        var container = document.getElementById('heroContainer');
        if (!data || data.length === 0) {
            container.innerHTML = '<div style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; background: var(--white); border-radius: 8px;">'
                + '<div style="font-size: 56px; margin-bottom: 16px;">📰</div>'
                + '<h2 style="margin-bottom: 8px; color: var(--text);">Belum Ada Headline Utama</h2>'
                + '<p style="color: var(--muted); font-size: 15px;">Tim redaksi sedang menyiapkan berita panas untuk Anda hari ini.</p>'
                + '</div>';
            return;
        }

        var html = '';
        var main = data[0];
        var mainCat = main.kategori ? main.kategori.nama_kategori : 'Umum';
        var mainPenulis = main.user ? main.user.username : 'FNM Redaksi';
        var imgMain = main.foto_thumbnail;
        if (imgMain && !imgMain.startsWith('http')) imgMain = '/uploads/thumbnail/' + imgMain;

        var thumbMain = imgMain
            ? '<div class="hero-img" style="opacity: 1;"><img src="' + imgMain + '" style="width:100%;height:100%;object-fit:cover;"></div>'
            : '<div class="hero-img">📰</div>';

        html += '<div class="hero-main" onclick="window.location.href=\'/berita/' + main.slug + '\'">'
            + thumbMain
            + '<div class="hero-overlay">'
            + '<div class="hero-cat">' + mainCat + '</div>'
            + '<div class="hero-title">' + main.judul_berita + '</div>'
            + '<div class="hero-meta">Oleh <b>' + mainPenulis + '</b> · ' + formatWaktu(main.waktu_publikasi) + '</div>'
            + '</div>'
            + '</div>';

        html += '<div class="hero-side">';
        for (var i = 1; i <= 3; i++) {
            if (data[i]) {
                var side = data[i];
                var sideCat = side.kategori ? side.kategori.nama_kategori : 'Umum';
                var imgSide = side.foto_thumbnail;
                if (imgSide && !imgSide.startsWith('http')) imgSide = '/uploads/thumbnail/' + imgSide;

                var thumbSide = imgSide
                    ? '<div class="ht-img" style="opacity: 1;"><img src="' + imgSide + '" style="width:100%;height:100%;object-fit:cover;"></div>'
                    : '<div class="ht-img" style="font-size:40px;opacity:0.2;">📰</div>';

                html += '<div class="hero-thumb" onclick="window.location.href=\'/berita/' + side.slug + '\'">'
                    + thumbSide
                    + '<div class="ht-overlay">'
                    + '<div class="ht-cat">' + sideCat + '</div>'
                    + '<div class="ht-title">' + side.judul_berita + '</div>'
                    + '</div>'
                    + '</div>';
            }
        }
        html += '</div>';
        container.innerHTML = html;
    }

    function renderTerbaru(data) {
        var gridContainer = document.getElementById('terkiniGrid');
        var listContainer = document.getElementById('latestNewsContainer');

        if (!data || data.length === 0) {
            gridContainer.innerHTML = '<div style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 20px; background: var(--white); border-radius: 12px; border: 2px dashed var(--border); text-align: center;">'
                + '<div style="font-size: 48px; margin-bottom: 16px;">🕵️‍♂️</div>'
                + '<div style="font-size: 20px; font-weight: 700; color: var(--text); margin-bottom: 8px;">Wah, Berita Terkini Masih Kosong!</div>'
                + '<div style="font-size: 14px; color: var(--muted);">Jadilah yang pertama tahu saat ada update berita terbaru nanti.</div>'
                + '</div>';
            listContainer.innerHTML = '';
            return;
        }

        var gridHtml = '';
        var listHtml = '';

        data.forEach(function(item, index) {
            var cat = item.kategori ? item.kategori.nama_kategori : 'Umum';
            var penulis = item.user ? item.user.username : 'FNM Redaksi';
            var img = item.foto_thumbnail;
            if (img && !img.startsWith('http')) img = '/uploads/thumbnail/' + img;

            if (index < 2) {
                var thumb = img ? '<img src="' + img + '" style="width:100%;height:100%;object-fit:cover;">' : '📰';
                gridHtml += '<div class="news-card" onclick="window.location.href=\'/berita/' + item.slug + '\'">'
                    + '<div class="nc-img" style="' + (img ? 'padding:0;' : '') + '">' + thumb + '</div>'
                    + '<div class="nc-cat ' + getCatClass(cat) + '">' + cat + '</div>'
                    + '<div class="nc-title">' + item.judul_berita + '</div>'
                    + '<div class="nc-meta">' + formatWaktu(item.waktu_publikasi) + ' · 👁 ' + fmtNum(item.jumlah_view) + ' views</div>'
                    + '</div>';
            } else {
                var thumb = img ? '<img src="' + img + '" style="width:100%;height:100%;object-fit:cover;">' : '📰';
                listHtml += '<div class="news-list-item" onclick="window.location.href=\'/berita/' + item.slug + '\'">'
                    + '<div class="nli-img" style="' + (img ? 'padding:0; overflow:hidden;' : '') + '">' + thumb + '</div>'
                    + '<div>'
                    + '<div class="nli-cat ' + getCatClass(cat) + '">' + cat + '</div>'
                    + '<div class="nli-title">' + item.judul_berita + '</div>'
                    + '<div class="nli-meta">' + formatWaktu(item.waktu_publikasi) + ' · Oleh ' + penulis + '</div>'
                    + '</div>'
                    + '</div>';
            }
        });

        gridContainer.innerHTML = gridHtml;
        listContainer.innerHTML = listHtml;
    }

    function renderTrending(data) {
        var container = document.getElementById('trendingContainer');
        if (!container) return;

        if (!data || data.length === 0) {
            container.innerHTML = '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 10px; text-align: center; background: #f9f9f9; border-radius: 8px; border: 1px solid var(--border);">'
                + '<div style="font-size: 36px; margin-bottom: 12px;">📉</div>'
                + '<div style="font-size: 15px; font-weight: 700; color: var(--text);">Belum Ada Tren</div>'
                + '<div style="font-size: 13px; color: var(--muted); margin-top: 6px; line-height: 1.4;">Belum ada berita yang cukup viral untuk masuk ke daftar ini.</div>'
                + '</div>';
            return;
        }

        var html = '';
        var colors = ['gold', 'silver', 'bronze', '', ''];

        data.forEach(function(item, index) {
            var rankClass = colors[index] || '';
            var isHot = index === 0
                ? '<span class="tr-badge hot">HOT</span>'
                : (index === 1 ? '<span class="tr-badge up">NAIK</span>' : '');

            html += '<a href="/berita/' + item.slug + '" class="trending-item">'
                + '<div class="tr-rank ' + rankClass + '" ' + (index > 2 ? 'style="color:var(--muted)"' : '') + '>' + (index + 1) + '</div>'
                + '<div>'
                + '<div class="tr-title">' + item.judul_berita + '</div>'
                + '<div class="tr-views">👁 ' + fmtNum(item.jumlah_view) + ' ' + isHot + '</div>'
                + '</div>'
                + '</a>';
        });

        container.innerHTML = html;
    }
</script>
@endsection