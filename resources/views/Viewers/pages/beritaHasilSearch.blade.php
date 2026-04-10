@extends('Viewers.master_viewers')

@section('konten')
<div class="container page-anim">
    <div class="main-grid">

        <div class="main-content">

            <div class="sr-head">
                <div class="sr-title" id="searchTitle">Mencari berita...</div>
                <div class="sr-sub" id="searchCount">Menunggu hasil pencarian</div>
            </div>

            <div class="sr-filters" style="margin-bottom: 24px;">
                <div class="sr-filter-chip active">Terkait</div>
                <div class="sr-filter-chip">Terbaru</div>
                <div class="sr-filter-chip">Terpopuler</div>
            </div>

            <hr class="sec-divider">

            <div class="news-list" id="searchResultsContainer">
                <div style="text-align: center; color: var(--muted); padding: 40px;">
                    <div style="font-size: 40px; margin-bottom: 10px;">⏳</div>
                    Sedang memuat data...
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
  let originalData = []; // Buat nyimpen data asli dari API

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('q');

        if (query) {
            $('#searchTitle').text(`Hasil Pencarian untuk: "${query}"`);
            $('#searchInput').val(query);
            loadSearchResults(query);
        }

        // Event Listener buat Filter Chip
        $('.sr-filter-chip').on('click', function() {
            $('.sr-filter-chip').removeClass('active');
            $(this).addClass('active');

            const filterType = $(this).text().trim().toLowerCase();
            applyFilter(filterType);
        });
    });

    function loadSearchResults(keyword) {
        $.ajax({
            url: `/api/viewers/search?q=${encodeURIComponent(keyword)}`,
            type: 'GET',
            success: function(res) {
                if (res.status === 'success') {
                    originalData = res.data.data; // Simpan data beritanya
                    renderResults(originalData, res.data.total);
                    renderSidebarTrending(originalData); // Update Sidebar pake data ini
                }
            }
        });
    }

    function applyFilter(type) {
        let filtered = [...originalData]; // Copy data asli

        if (type === 'terbaru') {
            // Urutin berdasarkan waktu_publikasi (terbaru ke lama)
            filtered.sort((a, b) => new Date(b.waktu_publikasi) - new Date(a.waktu_publikasi));
        } else if (type === 'terpopuler') {
            // Urutin berdasarkan jumlah_view terbanyak
            filtered.sort((a, b) => b.jumlah_view - a.jumlah_view);
        }
        // Kalau 'terkait', biarin aja pake urutan asli dari API

        renderResults(filtered, originalData.length);
    }

    function renderResults(berita, totalCount) {
        const container = $('#searchResultsContainer');
        $('#searchCount').text(`Menemukan ${totalCount} artikel`);

        if (!berita || berita.length === 0) {
            container.html(`<div style="text-align:center;padding:40px;">Nggak ada data cuy!</div>`);
            return;
        }

        let html = '';
        berita.forEach(item => {
            const cat = item.kategori ? item.kategori.nama_kategori : 'Umum';
            let img = item.foto_thumbnail;
            if (img && !img.startsWith('http')) img = `/uploads/thumbnail/${img}`;
            const thumb = img ? `<img src="${img}" style="width:100%;height:100%;object-fit:cover;">` : `📰`;

            html += `
                <div class="news-list-item" onclick="window.location.href='/berita/${item.slug}'">
                    <div class="nli-img" style="${img ? 'padding:0; overflow:hidden;' : ''}">${thumb}</div>
                    <div>
                        <div class="nli-cat ${getCatClass(cat)}">${cat}</div>
                        <div class="nli-title">${item.judul_berita}</div>
                        <div class="nli-meta">${new Date(item.waktu_publikasi).toLocaleDateString('id-ID')} · 👁 ${item.jumlah_view} views</div>
                    </div>
                </div>
            `;
        });
        container.html(html);
    }

    function getCatClass(nama) {
        const colors = { 'politik': 'cat-politik', 'ekonomi': 'cat-ekonomi', 'olahraga': 'cat-olahraga', 'teknologi': 'cat-teknologi' };
        return colors[(nama || '').toLowerCase()] || 'cat-hukum';
    }

    function renderSidebarTrending(data) {
        const container = document.getElementById('trendingContainer');
        if (!container) return;

        // Ambil data, urutin berdasarkan view, terus ambil 5 teratas
        const trendingData = [...data]
            .sort((a, b) => b.jumlah_view - a.jumlah_view)
            .slice(0, 5);

        if (trendingData.length === 0) {
            container.innerHTML = '<div style="font-size:12px;color:var(--muted);">Tidak ada tren pencarian.</div>';
            return;
        }

        let html = '';
        const colors = ['gold', 'silver', 'bronze', '', ''];

        trendingData.forEach((item, index) => {
            const rankClass = colors[index] || '';
            html += `
                <a href="/berita/${item.slug}" class="trending-item">
                    <div class="tr-rank ${rankClass}">${index + 1}</div>
                    <div>
                        <div class="tr-title">${item.judul_berita}</div>
                        <div class="tr-views">👁 ${item.jumlah_view} views</div>
                    </div>
                </a>
            `;
        });

        container.innerHTML = html;
    }
</script>
@endsection
