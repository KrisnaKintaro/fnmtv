<div class="sidebar-wrapper">
    <div class="widget">
        <div class="wgt-title">📈 Sedang Tren</div>
        <div id="trendingContainer"></div>
    </div>

    <div style="margin-bottom: 20px;">
        @include('Viewers.layout.ad_banner', [
            'id' => 'sidebarAdSpace',
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

        loadSidebarAd();
    });

    function loadSidebarAd() {
        const wrapper = document.getElementById('sidebarAdSpace');
        if (!wrapper) return;

        fetch('/api/viewers/iklan')
            .then(response => response.json())
            .then(res => {
                if (res.status !== 'success') return;

                const ads = res.data.sidebar_300x250 || [];
                const ad = ads.length ? ads[0] : null;

                // Kalau tidak ada iklan, wrapper tetap tersembunyi
                if (!ad) {
                    wrapper.style.display = 'none';
                    return;
                }

                // Kalau ada iklan, tampilkan wrapper dan isi kontennya
                wrapper.style.display = '';
                const content = wrapper.querySelector('.ad-content');
                if (!content) return;

                let html = '';
                if (ad.link_tujuan) {
                    html += '<a href="' + ad.link_tujuan + '" target="_blank" rel="noopener noreferrer" style="display:block; width:100%;">'
                        + '<img src="/storage/' + ad.gambar + '" alt="' + ad.judul + '" style="width:100%; height:auto; border-radius: 8px; object-fit:contain;">'
                        + '</a>';
                } else {
                    html += '<img src="/storage/' + ad.gambar + '" alt="' + ad.judul + '" style="width:100%; height:auto; border-radius: 8px; object-fit:contain;">';
                }
                if (ad.judul) {
                    html += '<div style="margin-top: 10px; font-size: 14px; font-weight: 700;">' + ad.judul + '</div>';
                }
                content.innerHTML = html;
            })
            .catch(err => console.error('Gagal load iklan sidebar:', err));
    }
</script>