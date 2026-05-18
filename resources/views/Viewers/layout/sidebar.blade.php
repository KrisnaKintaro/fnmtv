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
