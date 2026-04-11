@extends('Viewers.master_viewers')

@section('konten')
<div class="container page-anim">
    <div class="main-grid">

        <div class="main-content">

            <div class="page-header">
                <div class="ph-breadcrumb">
                    <a href="/">Home</a> / <span id="catBreadcrumb">Memuat...</span>
                </div>
                <div class="ph-title" id="catTitle">
                    Memuat Kategori...
                </div>
                <div class="ph-count" id="catCount">Menampilkan 0 artikel</div>
            </div>

            <div class="sr-filters" style="margin-bottom: 24px;">
                <div class="sr-filter-chip active" data-sort="terbaru">Terbaru</div>
                <div class="sr-filter-chip" data-sort="terpopuler">Terpopuler</div>
            </div>

            <hr class="sec-divider">

            <div class="news-list" id="categoryNewsContainer">
                <div style="text-align: center; color: var(--muted); padding: 40px;">
                    <div style="font-size: 40px; margin-bottom: 10px;">⏳</div>
                    Sedang memuat data...
                </div>
            </div>

            <div style="margin-top: 30px; display: none; justify-content: center;" id="loadMoreWrap">
                <button class="btn btn-outline" id="btnLoadMore">Lebih Banyak ➔</button>
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
    let originalData = [];
    let currentPage = 1;
    let isPopuler = false;
    let slug = '';

    $(document).ready(function() {
        // 1. Ambil kata terakhir dari URL (slug-nya)
        const pathArray = window.location.pathname.split('/');
        slug = pathArray[pathArray.length - 1];

        // 2. Cek apakah ini halaman Populer atau Kategori biasa
        isPopuler = (slug === 'populer');

        // 3. Tembak API
        loadCategoryData(currentPage);

        // 4. Event Listener buat Filter
        $('.sr-filter-chip').on('click', function() {
            $('.sr-filter-chip').removeClass('active');
            $(this).addClass('active');

            const sortType = $(this).data('sort');
            applyFilter(sortType);
        });

        // 5. Event Listener buat Tombol Lebih Banyak
        $('#btnLoadMore').on('click', function() {
            currentPage++;
            loadCategoryData(currentPage, true);
        });
    });

    function loadCategoryData(page, isAppend = false) {
        if (!isAppend) {
            $('#categoryNewsContainer').html('<div style="text-align:center;padding:40px;">⏳ Sedang memuat data...</div>');
        }

        // Tentukan URL API berdasarkan deteksi slug tadi
        let apiUrl = isPopuler
            ? `/api/viewers/berita-populer?page=${page}`
            : `/api/viewers/kategori/${slug}?page=${page}`;

        $.ajax({
            url: apiUrl,
            type: 'GET',
            success: function(res) {
                if (res.status === 'success') {
                    let beritaArray = [];
                    let totalCount = 0;
                    let catName = "Populer";

                    // Format JSON dari API Kategori dan API Populer beda (karena ada relasi), jadi kita pisah nangkep datanya
                    if (isPopuler) {
                        beritaArray = res.data.data;
                        totalCount = res.data.total;
                    } else {
                        beritaArray = res.data.berita.data;
                        totalCount = res.data.berita.total;
                        catName = res.data.kategori_info.nama_kategori;
                    }

                    // Update Teks Header (Cuma pas pertama kali load)
                    if (page === 1) {
                        $('#catBreadcrumb').text(isPopuler ? 'Berita Populer' : `Kategori ${catName}`);
                        $('#catTitle').text(isPopuler ? 'Berita Paling Populer Saat Ini' : `Berita ${catName} Terkini`);
                        $('#catCount').text(`Menampilkan ${totalCount} artikel`);

                        // Kalau populer, otomatis aktifin filter 'terpopuler'
                        if(isPopuler) {
                            $('.sr-filter-chip').removeClass('active');
                            $('.sr-filter-chip[data-sort="terpopuler"]').addClass('active');
                        }
                    }

                    // Gabungin data kalau klik "Lebih Banyak", kalau nggak ya timpa aja
                    if (isAppend) {
                        originalData = originalData.concat(beritaArray);
                    } else {
                        originalData = beritaArray;
                    }

                    // Render hasilnya pakai filter yang lagi aktif
                    const currentFilter = $('.sr-filter-chip.active').data('sort');
                    applyFilter(currentFilter);

                    // Tampil/Sembunyikan tombol "Lebih Banyak"
                    if (originalData.length < totalCount) {
                        $('#loadMoreWrap').css('display', 'flex');
                    } else {
                        $('#loadMoreWrap').hide();
                    }

                    // Update Sidebar Trending dari data yang dapet
                    renderSidebarTrending(originalData);
                }
            },
            error: function(err) {
                console.error("Gagal nyari kategori cuy:", err);
                $('#categoryNewsContainer').html('<div style="text-align:center;color:red;">Kategori tidak ditemukan atau error!</div>');
            }
        });
    }

    function applyFilter(type) {
        let filtered = [...originalData];

        if (type === 'terbaru') {
            filtered.sort((a, b) => new Date(b.waktu_publikasi) - new Date(a.waktu_publikasi));
        } else if (type === 'terpopuler') {
            filtered.sort((a, b) => b.jumlah_view - a.jumlah_view);
        }

        renderResults(filtered);
    }

    function formatWaktu(dateString) {
        if (!dateString) return '';
        return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    }

    function getCatClass(nama) {
        const catColors = { 'politik': 'cat-politik', 'ekonomi': 'cat-ekonomi', 'olahraga': 'cat-olahraga', 'teknologi': 'cat-teknologi', 'kesehatan': 'cat-kesehatan', 'hukum': 'cat-hukum', 'lingkungan': 'cat-lingkungan', 'budaya': 'cat-budaya' };
        return catColors[(nama || '').toLowerCase()] || 'cat-hukum';
    }

    function renderResults(data) {
        const container = $('#categoryNewsContainer');

        if (!data || data.length === 0) {
            container.html(`
                <div class="empty-state">
                    <div class="es-icon">📰</div>
                    <div class="es-title">Belum ada berita cuy!</div>
                    <div class="es-sub">Kategori ini masih kosong, tunggu update dari redaksi ya.</div>
                </div>
            `);
            return;
        }

        let html = '';
        data.forEach(item => {
            const cat = item.kategori ? item.kategori.nama_kategori : 'Umum';
            const penulis = item.user ? item.user.username : 'FNM Redaksi';

            let img = item.foto_thumbnail;
            if (img && !img.startsWith('http')) img = `/uploads/thumbnail/${img}`;
            const thumb = img ? `<img src="${img}" style="width:100%;height:100%;object-fit:cover;">` : `📰`;

            html += `
                <div class="news-list-item" onclick="window.location.href='/berita/${item.slug}'">
                    <div class="nli-img" style="${img ? 'padding:0; overflow:hidden;' : ''}">${thumb}</div>
                    <div>
                        <div class="nli-cat ${getCatClass(cat)}">${cat}</div>
                        <div class="nli-title">${item.judul_berita}</div>
                        <div class="nli-meta">${formatWaktu(item.waktu_publikasi)} · Oleh ${penulis} · 👁 ${item.jumlah_view} views</div>
                    </div>
                </div>
            `;
        });

        container.html(html);
    }

    // Fungsi Render Sidebar Trending (Sama persis kayak di halaman Search)
    function renderSidebarTrending(data) {
        const container = document.getElementById('trendingContainer');
        if (!container) return;

        const trendingData = [...data].sort((a, b) => b.jumlah_view - a.jumlah_view).slice(0, 5);

        if (trendingData.length === 0) {
            container.innerHTML = '<div style="font-size:12px;color:var(--muted);">Tidak ada tren.</div>';
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
