@extends('Viewers.master_viewers')

@section('konten')
<div class="container page-anim">
    <div class="main-grid">

        <div class="main-content">

            <div class="ph-breadcrumb">
                <a href="/">Home</a> /
                <a href="#" id="bcCatLink"><span id="bcCatName">Memuat...</span></a> /
                <span style="color:var(--text);" id="bcTitle">Memuat...</span>
            </div>

            <div class="article-cat" id="artCat">Kategori</div>
            <h1 class="article-title" id="artJudul">Sedang memuat judul artikel...</h1>

            <div class="article-byline">
                <div class="a-avatar" id="artAvatar">?</div>
                <div>
                    <div class="a-author" id="artPenulis">Memuat Penulis</div>
                    <div class="a-date" id="artWaktu">Memuat Waktu</div>
                </div>
                <div class="a-stats">
                    <div class="a-stat" id="artViews">👁️ 0 Kali Dibaca</div>
                    <div class="a-stat" id="artKomenCount">💬 0 Komentar</div>
                </div>
            </div>

            <div class="article-hero" id="artThumbnail" style="padding: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #eee;">
                ⏳
            </div>

            <div class="article-body" id="artBody">
                <p style="text-align: center; color: var(--muted);">Sedang mengambil isi berita...</p>
            </div>

            <div class="reaction-bar">
                <div class="rb-label">Bagaimana tanggapan Anda?</div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;" id="reactionContainer">
                    <button class="reaction-btn" onclick="kirimReaksi('suka')">👍 <span class="rb-count" id="count-suka">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('cinta')">❤️ <span class="rb-count" id="count-cinta">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('kaget')">🤯 <span class="rb-count" id="count-kaget">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('sedih')">😢 <span class="rb-count" id="count-sedih">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('marah')">😡 <span class="rb-count" id="count-marah">0</span></button>
                </div>
            </div>

            <div class="share-bar">
                <div class="share-label">Bagikan artikel ini:</div>
                <button class="share-btn sb-fb" onclick="shareSocial('facebook')">Facebook</button>
                <button class="share-btn sb-tw" onclick="shareSocial('twitter')">Twitter / X</button>
                <button class="share-btn sb-wa" onclick="shareSocial('whatsapp')">WhatsApp</button>
                <button class="share-btn sb-copy" onclick="copyLink()">🔗 Salin Link</button>
            </div>

            <div class="comments-section">
                <div class="cs-title" id="csTitleCount">Komentar Pembaca (0)</div>

                <div class="comment-form">
                    <textarea class="cf-input" id="inputKomentar" placeholder="Tulis komentar Anda di sini... Minta tolong gunakan bahasa yang sopan ya cuy!"></textarea>
                    <div class="cf-foot">
                        <input type="text" class="cf-name" id="inputNama" placeholder="Nama Anda (Opsional)">
                        <button class="cf-submit" id="btnKirimKomentar" onclick="kirimKomentar()">Kirim Komentar</button>
                    </div>
                </div>

                <div class="comment-list" id="komentarList">
                    <div style="text-align: center; color: var(--muted); padding: 20px;">Memuat komentar...</div>
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
    let currentSlug = '';
    let currentBeritaId = null;

    $(document).ready(function() {
        // 1. Ambil slug dari URL (contoh: /berita/judul-berita -> ambil "judul-berita")
        const pathArray = window.location.pathname.split('/');
        currentSlug = pathArray[pathArray.length - 1];

        // 2. Load Data Artikel
        if(currentSlug) {
            loadBeritaDetail(currentSlug);
            loadSidebarTrending(); // Biar sidebarnya ga kosong
        }
    });

    // --- FUNGSI LOAD DATA BERITA ---
    function loadBeritaDetail(slug) {
        $.ajax({
            url: `/api/viewers/berita/${slug}`,
            type: 'GET',
            success: function(res) {
                try {
                    if (res.status === 'success') {
                        const b = res.data.berita || res.data;
                        currentBeritaId = b.id;

                        renderDetailBerita(b); // Render isi

                        const dataKomentar = b.komentar || [];
                        renderKomentar(dataKomentar); // Render komentar

                        // Render reaksi (baca dari reaksi_rekap yang kita bikin di Step 2)
                        if(b.reaksi_rekap) renderReaksi(b.reaksi_rekap);
                    } else {
                        $('#artJudul').text('Gagal memuat berita!');
                        $('#artBody').html(`<p style="text-align:center; color:red;">${res.message || 'Error dari server'}</p>`);
                    }
                } catch (e) {
                    console.error("JS Error saat nge-render cuy:", e);
                    $('#artJudul').text('Waduh, terjadi kesalahan sistem!');
                    $('#artBody').html('<p style="text-align:center; color:red;">Gagal memproses data artikel dari database.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("API Error cuy:", xhr.responseText);
                $('#artJudul').text('Server Error atau Berita Hilang!');
                $('#artBody').html('<p style="text-align:center; color:red;">Hubungi admin untuk menindak lanjuti masalah ini</p>');
            }
        });
    }

    // --- FUNGSI RENDER TAMPILAN BERITA ---
    function renderDetailBerita(b) {
        const cat = b.kategori ? b.kategori.nama_kategori : 'Umum';
        const catSlug = b.kategori ? b.kategori.slug : '';
        const penulis = b.user ? b.user.username : 'FNM Redaksi';
        const waktu = new Date(b.waktu_publikasi).toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });

        // Update Breadcrumb
        $('#bcCatName').text(cat);
        $('#bcCatLink').attr('href', `/kategori/${catSlug}`);
        $('#bcTitle').text(b.judul_berita.substring(0, 30) + '...');

        // Update Header Info
        $('#artCat').text(`Nasional · ${cat}`);
        $('#artJudul').text(b.judul_berita);
        $('#artAvatar').text(penulis.charAt(0).toUpperCase());
        $('#artPenulis').text(penulis);
        $('#artWaktu').text(`${waktu} WIB`);
        $('#artViews').text(`👁️ ${b.jumlah_view} Kali Dibaca`);

        // Update Gambar
        let img = b.foto_thumbnail;
        if (img && !img.startsWith('http')) img = `/uploads/thumbnail/${img}`;
        if (img) {
            $('#artThumbnail').html(`<img src="${img}" style="width:100%; height:100%; object-fit:cover;">`);
        } else {
            $('#artThumbnail').html(`<div style="font-size: 50px; color: var(--muted);">📰</div>`);
        }

        // Update Isi Teks (HTML murni dari Quill/RichText)
        $('#artBody').html(b.isi_berita);

        // Update Judul Halaman di Browser Tab
        document.title = `${b.judul_berita} - FNM`;
    }

    // --- FUNGSI RENDER KOMENTAR ---
    function renderKomentar(komentarData) {
        $('#artKomenCount').text(`💬 ${komentarData.length} Komentar`);
        $('#csTitleCount').text(`Komentar Pembaca (${komentarData.length})`);

        let html = '';
        if(komentarData.length === 0) {
            html = '<div style="text-align: center; color: var(--muted); padding: 20px;">Belum ada komentar. Jadilah yang pertama!</div>';
        } else {
            komentarData.forEach(k => {
                const initial = k.nama_pengirim ? k.nama_pengirim.charAt(0).toUpperCase() : 'A';
                const nama = k.nama_pengirim || 'Anonim';
                const waktu = new Date(k.created_at).toLocaleDateString('id-ID');

                html += `
                    <div class="comment-item">
                        <div class="ci-avatar">${initial}</div>
                        <div class="ci-body">
                            <div class="ci-user">${nama}</div>
                            <div class="ci-time">${waktu}</div>
                            <div class="ci-text">${k.isi_komentar}</div>
                        </div>
                    </div>
                `;
            });
        }
        $('#komentarList').html(html);
    }

    // --- FUNGSI KIRIM KOMENTAR ---
    function kirimKomentar() {
        const isi = $('#inputKomentar').val().trim();
        const nama = $('#inputNama').val().trim();

        if(!isi) {
            Toast.show('error', 'Komentar nggak boleh kosong cuy!');
            return;
        }

        $('#btnKirimKomentar').text('Mengirim...').prop('disabled', true);

        $.ajax({
            url: '/api/viewers/tambahKomentar', // Sesuai route lu
            type: 'POST',
            data: {
                berita_id: currentBeritaId,
                isi_komentar: isi,
                nama_pengirim: nama || 'Anonim'
            },
            success: function(res) {
                Toast.show('success', 'Komentar berhasil dikirim dan menunggu moderasi!');
                $('#inputKomentar').val('');
                $('#btnKirimKomentar').text('Kirim Komentar').prop('disabled', false);
            },
            error: function(err) {
                Toast.show('error', 'Gagal mengirim komentar.');
                $('#btnKirimKomentar').text('Kirim Komentar').prop('disabled', false);
            }
        });
    }

    // --- FUNGSI RENDER REAKSI (Pas pertama kali halaman dibuka) ---
    function renderReaksi(reaksiData) {
        // Reset angka jadi 0 dulu
        $('.rb-count').text('0');

        // Deteksi format data dari backend
        if (Array.isArray(reaksiData)) {
            // Kalau API ngirim array: [{jenis_reaksi: 'like', total: 5}, ...]
            reaksiData.forEach(r => {
                // Sesuain 'jenis_reaksi' sama 'total' dengan nama kolom database lu ya
                $(`#count-${r.jenis_reaksi}`).text(r.total || r.jumlah || 1);
            });
        } else if (typeof reaksiData === 'object') {
            // Kalau API ngirim object: { like: 5, love: 2 }
            for (let jenis in reaksiData) {
                $(`#count-${jenis}`).text(reaksiData[jenis]);
            }
        }
    }

    // --- FUNGSI KIRIM/TOGGLE REAKSI KETIKA DIKLIK ---
    function kirimReaksi(jenis) {
        if (!currentBeritaId) return;

        const btnCount = $(`#count-${jenis}`);
        const originalText = btnCount.text();
        btnCount.text('...');

        $.ajax({
            url: '/api/viewers/toggleReaksi',
            type: 'POST',
            data: {
                berita_id: currentBeritaId,
                jenis_reaksi: jenis
            },
            success: function(res) {
                if (res.status === 'success') {
                    loadBeritaDetail(currentSlug);
                }
            },
            error: function(err) {
                btnCount.text(originalText); // Balikin angka kalau error

                // Kalau API lu nolak gara-gara belum login (kode 401)
                if (err.status === 401 || err.status === 403) {
                    Toast.show('error', 'Masuk/Login dulu cuy buat ngasih reaksi!');
                } else {
                    Toast.show('error', 'Gagal mengirim reaksi, coba lagi nanti.');
                }
            }
        });
    }

    // --- FUNGSI SIDEBAR TRENDING ---
    function loadSidebarTrending() {
        $.ajax({
            url: '/api/viewers/berita', // Ambil data dari endpoint Home
            type: 'GET',
            success: function(res) {
                if (res.status === 'success' && res.data.trending) {
                    renderSidebar(res.data.trending);
                }
            }
        });
    }

    function renderSidebar(trendingData) {
        const container = document.getElementById('trendingContainer');
        if (!container) return;
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

    // --- FUNGSI SHARE SOSIAL MEDIA ---
    function shareSocial(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent($('#artJudul').text());
        let shareUrl = '';

        if(platform === 'facebook') shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
        if(platform === 'twitter') shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
        if(platform === 'whatsapp') shareUrl = `https://api.whatsapp.com/send?text=${title} - ${url}`;

        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            Toast.show('success', 'Link berhasil disalin cuy!');
        });
    }
</script>
@endsection
