<div class="sidebar-wrapper">
    <div class="widget">
        <div class="wgt-title">📈 Sedang Tren</div>
        <div id="trendingContainer">
            </div>
    </div>

    <div style="margin-bottom: 20px;">
        @include('Viewers.layout.ad_banner', [
            'type' => 'box',
            'text' => 'SPACE IKLAN 300x250'
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
    // Pake Vanilla JS biar aman dieksekusi sebelum jQuery keload di bawah
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/api/viewers/kategori')
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success') {
                    const container = document.getElementById('sidebarCategoryContainer');
                    if (!container) return;

                    let html = '';
                    res.data.forEach(cat => {
                        // Emoji dihapus, cuma nampilin nama kategorinya aja
                        html += `
                            <div class="cat-box" onclick="window.location.href='/kategori/${cat.slug}'">
                                ${cat.nama_kategori}
                            </div>
                        `;
                    });

                    container.innerHTML = html;
                }
            })
            .catch(err => console.error("Gagal load kategori sidebar:", err));
    });
</script>
