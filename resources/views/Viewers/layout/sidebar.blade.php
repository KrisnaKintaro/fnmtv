<div class="sidebar-wrapper">
    <div class="widget">
        <div class="wgt-title">📈 Sedang Tren</div>
        <div id="trendingContainer"></div>
    </div>

    <div style="margin-bottom: 20px;">
        @include('Viewers.layout.promo_banner', [
            'id' => 'sidebarPromoSpace',
            'type' => 'box'
        ])
    </div>

    <div class="widget">
        <div class="wgt-title">📁 Jelajahi Kategori</div>
        <div class="cat-grid" id="sidebarCategoryContainer">
            <div style="grid-column: span 2; text-align: center; color: var(--muted); font-size: 12px; padding: 10px;">
                Memuat Kategori...
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/api/viewers/kategori')
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success') {
                    const container = document.getElementById('sidebarCategoryContainer');
                    if (!container) return;

                    let html = '';
                    res.data.forEach(cat => {
                        html += '<div class="cat-box" onclick="window.location.href=\'/kategori/' + cat.slug + '\'">'
                            + cat.nama_kategori
                            + '</div>';
                    });

                    container.innerHTML = html;
                }
            })
            .catch(err => console.error("Gagal load kategori sidebar:", err));

        loadSidebarPromo();
        loadSidebarTrending();
    });

    function loadSidebarTrending() {
        fetch('/api/viewers/berita')
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' && res.data && Array.isArray(res.data.trending)) {
                    renderSidebarTrending(res.data.trending);
                }
            })
            .catch(err => console.error('Gagal load trending sidebar:', err));
    }

    function renderSidebarTrending(trendingData) {
        const container = document.getElementById('trendingContainer');
        if (!container) return;

        if (!trendingData || trendingData.length === 0) {
            container.innerHTML = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px 12px;background:#f9f9f9;border-radius:12px;border:1px solid var(--border);text-align:center;color:var(--muted);">'
                + '<div style="font-size:28px;margin-bottom:10px;">📉</div>'
                + '<div style="font-size:14px;font-weight:700;">Belum ada berita trending</div>'
                + '<div style="font-size:12px;line-height:1.5;margin-top:8px;">Cek kembali nanti untuk berita yang lebih ramai dibaca.</div>'
                + '</div>';
            return;
        }

        let html = '';
        trendingData.slice(0, 5).forEach((item, index) => {
            const views = item.jumlah_view ? item.jumlah_view.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '0';
            html += '<a href="/berita/' + item.slug + '" class="trending-item" style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);text-decoration:none;color:inherit;">'
                + '<div class="tr-rank" style="min-width:28px;font-weight:700;color:var(--red);">' + (index + 1) + '</div>'
                + '<div style="flex:1;">'
                    + '<div class="tr-title" style="font-size:13px;font-weight:700;line-height:1.3;">' + item.judul_berita + '</div>'
                    + '<div class="tr-views" style="font-size:12px;color:var(--muted);margin-top:6px;">👁 ' + views + ' views</div>'
                + '</div>'
                + '</a>';
        });

        container.innerHTML = html;
    }

    function loadSidebarPromo() {
        var wrapper = document.getElementById('sidebarPromoSpace'); // ← definisikan wrapper dulu

        loadSidebarPromo();
    });

    function loadSidebarPromo() {
        var wrapper = document.getElementById('sidebarPromoSpace'); // ← definisikan wrapper dulu

        if (!wrapper) return;

        fetch('/api/viewers/iklan')
            .then(response => response.json())
            .then(res => {
                if (res.status !== 'success') return; // tidak ada promo, biarkan placeholder tampil

                const promos = res.data.sidebar_300x250 || [];
                const promo = promos.length ? promos[0] : null;

                if (!promo) return; // tidak ada promo, biarkan placeholder tampil

                // Ada promo — timpa placeholder dengan konten promo
                const content = wrapper.querySelector('.promo-content');
                if (!content) return;

                let html = '';
                if (promo.link_tujuan) {
                    html += '<a href="' + promo.link_tujuan + '" target="_blank" rel="noopener noreferrer" style="display:block; width:100%;">'
                        // DI SINI KITA TAMBAHIN loading="lazy" BIAR HEMAT KUOTA
                        + '<img src="/storage/' + promo.gambar + '" alt="' + promo.judul + '" loading="lazy" style="width:100%; height:auto; border-radius: 8px; object-fit:contain;">'
                        + '</a>';
                } else {
                    // DI SINI JUGA
                    html += '<img src="/storage/' + promo.gambar + '" alt="' + promo.judul + '" loading="lazy" style="width:100%; height:auto; border-radius: 8px; object-fit:contain;">';
                }
                if (promo.judul) {
                    html += '<div style="margin-top: 10px; font-size: 14px; font-weight: 700;">' + promo.judul + '</div>';
                }
                content.innerHTML = html;
            })
            .catch(err => console.error('Gagal load promo sidebar:', err));
    }
</script>
