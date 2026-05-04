@extends('Viewers.master_viewers')
@section('css')
<style>
    @keyframes modalPop {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
@endsection
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

                    @guest
                    <button class="reaction-btn" onclick="cekLoginDulu(event)">👍 <span class="rb-count" id="count-suka">0</span></button>
                    <button class="reaction-btn" onclick="cekLoginDulu(event)">❤️ <span class="rb-count" id="count-cinta">0</span></button>
                    <button class="reaction-btn" onclick="cekLoginDulu(event)">🤯 <span class="rb-count" id="count-kaget">0</span></button>
                    <button class="reaction-btn" onclick="cekLoginDulu(event)">😢 <span class="rb-count" id="count-sedih">0</span></button>
                    <button class="reaction-btn" onclick="cekLoginDulu(event)">😡 <span class="rb-count" id="count-marah">0</span></button>
                    @else
                    <button class="reaction-btn" onclick="kirimReaksi('suka')">👍 <span class="rb-count" id="count-suka">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('cinta')">❤️ <span class="rb-count" id="count-cinta">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('kaget')">🤯 <span class="rb-count" id="count-kaget">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('sedih')">😢 <span class="rb-count" id="count-sedih">0</span></button>
                    <button class="reaction-btn" onclick="kirimReaksi('marah')">😡 <span class="rb-count" id="count-marah">0</span></button>
                    @endguest

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
                    <textarea class="cf-input" id="inputKomentar" placeholder="Tulis komentar Anda..." @guest onfocus="cekLoginDulu(event)" @endguest></textarea>
                    <div class="cf-foot">
                        @guest
                        <p style="font-size: 13px; color: var(--muted);">Silakan <a href="/login" style="color:var(--primary);">Login</a> buat ikutan komentar cuy.</p>
                        @endguest

                        @auth
                        <div class="cf-name-info">Berkomentar sebagai: <b>{{ Auth::user()->username }}</b></div>
                        <button class="cf-submit" id="btnKirimKomentar" onclick="kirimKomentar()">Kirim Komentar</button>
                        @endauth
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

<div id="modalAuthSuggest" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; width: 90%; max-width: 400px; text-align: center; padding: 40px 30px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); position: relative; animation: modalPop 0.3s ease-out forwards;">

        <div style="font-size: 56px; margin-bottom: 20px; line-height: 1;">🔐</div>

        <h2 style="font-family: 'Merriweather', serif; font-size: 24px; margin-bottom: 12px; color: #1a1a1a;">Eitss, Login Dulu Cuy!</h2>

        <p style="font-size: 15px; color: #666; margin-bottom: 30px; line-height: 1.6;">
            Biar interaksi lu makin asik, lu harus masuk ke akun FNM dulu buat ngasih komentar atau reaksi. Cuma butuh semenit kok!
        </p>

        <div style="display: flex; gap: 12px;">
            <button onclick="tutupModalLogin()" style="flex:1; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: white; color: #555; font-weight: 600; cursor: pointer; transition: 0.2s;">Nanti Aja</button>

            <a href="/login" style="flex:1; padding: 12px; border-radius: 8px; background: #cc0000; color: white; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center; transition: 0.2s;">Gas Login!</a>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let currentSlug = '';
    let currentBeritaId = null;

    $(document).ready(function() {
        const pathArray = window.location.pathname.split('/');
        currentSlug = pathArray[pathArray.length - 1];

        if (currentSlug) {
            loadBeritaDetail(currentSlug);
            loadSidebarTrending();
        }
    });

    // --- FUNGSI CEGAT LOGIN ---
    function cekLoginDulu(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
            if(e.target) e.target.blur();
        }

        console.log("Memanggil modal login...");
        $('#modalAuthSuggest').fadeIn(200).css('display', 'flex');
        return false;
    }

    function tutupModalLogin() {
        $('#modalAuthSuggest').fadeOut(200);
    }

    function loadBeritaDetail(slug) {
        $.ajax({
            url: `/api/viewers/berita/${slug}`,
            type: 'GET',
            success: function(res) {
                try {
                    if (res.status === 'success') {
                        const b = res.data.berita || res.data;
                        currentBeritaId = b.id;
                        renderDetailBerita(b);
                        const dataKomentar = b.komentar || [];
                        renderKomentar(dataKomentar);
                        if (b.reaksi_rekap) renderReaksi(b.reaksi_rekap);
                    }
                } catch (e) {
                    console.error("JS Error:", e);
                }
            }
        });
    }

    function renderDetailBerita(b) {
        const cat = b.kategori ? b.kategori.nama_kategori : 'Umum';
        const catSlug = b.kategori ? b.kategori.slug : '';
        const penulis = b.user ? b.user.username : 'FNM Redaksi';
        const waktu = new Date(b.waktu_publikasi).toLocaleString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        $('#bcCatName').text(cat);
        $('#bcCatLink').attr('href', `/kategori/${catSlug}`);
        $('#bcTitle').text(b.judul_berita.substring(0, 30) + '...');
        $('#artCat').text(`Nasional · ${cat}`);
        $('#artJudul').text(b.judul_berita);
        $('#artAvatar').text(penulis.charAt(0).toUpperCase());
        $('#artPenulis').text(penulis);
        $('#artWaktu').text(`${waktu} WIB`);
        $('#artViews').text(`👁️ ${b.jumlah_view} Kali Dibaca`);

        let img = b.foto_thumbnail;
        if (img && !img.startsWith('http')) img = `/uploads/thumbnail/${img}`;
        $('#artThumbnail').html(img ? `<img src="${img}" style="width:100%; height:100%; object-fit:cover;">` : `<div style="font-size: 50px; color: var(--muted);">📰</div>`);
        $('#artBody').html(b.isi_berita);
        document.title = `${b.judul_berita} - FNM`;
    }

    function renderKomentar(komentarData) {
        $('#artKomenCount').text(`💬 ${komentarData.length} Komentar`);
        $('#csTitleCount').text(`Komentar Pembaca (${komentarData.length})`);
        let html = '';
        if (komentarData.length === 0) {
            html = '<div style="text-align: center; color: var(--muted); padding: 20px;">Belum ada komentar. Jadilah yang pertama!</div>';
        } else {
            komentarData.forEach(k => {
                // Sesuai revisi Krisna, ambil dari relasi user.username
                const nama = k.user;
                const initial = nama.charAt(0).toUpperCase();

                const namaAman = $('<div>').text(nama).html();
                const komentarAman = $('<div>').text(k.isi_komentar).html();
                html += `
                    <div class="comment-item">
                        <div class="ci-avatar">${initial}</div>
                        <div class="ci-body">
                            <div class="ci-user">${namaAman}</div>
                            <div class="ci-time">${new Date(k.created_at).toLocaleDateString('id-ID')}</div>
                            <div class="ci-text">${komentarAman}</div>
                        </div>
                    </div>`;
            });
        }
        $('#komentarList').html(html);
    }

    function kirimKomentar() {
        const isi = $('#inputKomentar').val().trim();
        if (!isi) {
            Toast.show('error', 'Komentar nggak boleh kosong cuy!');
            return;
        }
        $('#btnKirimKomentar').text('Mengirim...').prop('disabled', true);
        $.ajax({
            url: '/api/viewers/tambahKomentar',
            type: 'POST',
            data: {
                berita_id: currentBeritaId,
                isi_komentar: isi
            },
            success: function(res) {
                Toast.show('success', 'Komentar terkirim! Menunggu moderasi redaksi.');
                $('#inputKomentar').val('');
                $('#btnKirimKomentar').text('Kirim Komentar').prop('disabled', false);
            },
            error: function() {
                Toast.show('error', 'Gagal kirim komentar.');
                $('#btnKirimKomentar').text('Kirim Komentar').prop('disabled', false);
            }
        });
    }

    function renderReaksi(reaksiData) {
        $('.rb-count').text('0');
        for (let jenis in reaksiData) {
            $(`#count-${jenis}`).text(reaksiData[jenis]);
        }
    }

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
            success: function() {
                loadBeritaDetail(currentSlug);
            },
            error: function() {
                btnCount.text(originalText);
                Toast.show('error', 'Gagal reaksi.');
            }
        });
    }

    function loadSidebarTrending() {
        $.ajax({
            url: '/api/viewers/berita',
            type: 'GET',
            success: function(res) {
                if (res.status === 'success') renderSidebar(res.data.trending);
            }
        });
    }

    function renderSidebar(trendingData) {
        const container = document.getElementById('trendingContainer');
        if (!container) return;
        let html = '';
        trendingData.forEach((item, index) => {
            html += `
                <a href="/berita/${item.slug}" class="trending-item">
                    <div class="tr-rank">${index + 1}</div>
                    <div>
                        <div class="tr-title">${item.judul_berita}</div>
                        <div class="tr-views">👁 ${item.jumlah_view} views</div>
                    </div>
                </a>`;
        });
        container.innerHTML = html;
    }

    function shareSocial(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent($('#artJudul').text());
        let shareUrl = '';
        if (platform === 'facebook') shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
        if (platform === 'twitter') shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
        if (platform === 'whatsapp') shareUrl = `https://api.whatsapp.com/send?text=${title} - ${url}`;
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            Toast.show('success', 'Link berhasil disalin cuy!');
        });
    }
</script>
@endsection
