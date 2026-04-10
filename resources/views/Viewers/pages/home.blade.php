@extends('Viewers.master_viewers')

@section('css')
    @endsection

@section('konten')
<div class="container page-anim">
    <div class="main-grid">

        <div class="main-content">

            <div class="hero-section">
                <div class="hero-grid">
                    <div class="hero-main" onclick="window.location.href='#'">
                        <div class="hero-img">🏙️</div>
                        <div class="hero-overlay">
                            <div class="hero-cat cat-politik">Nasional</div>
                            <div class="hero-title">Presiden Resmikan Pembangunan Infrastruktur Tahap 3 di Ibu Kota Baru</div>
                            <div class="hero-meta">Oleh <b>Budi Santoso</b> · 2 Jam Lalu</div>
                        </div>
                    </div>
                    <div class="hero-side">
                        <div class="hero-thumb" onclick="window.location.href='#'">
                            <div class="ht-img">📈</div>
                            <div class="ht-overlay">
                                <div class="ht-cat cat-ekonomi" style="background:var(--blue)">Ekonomi</div>
                                <div class="ht-title">IHSG Menguat Tipis di Penutupan Sesi Pertama</div>
                            </div>
                        </div>
                        <div class="hero-thumb" onclick="window.location.href='#'">
                            <div class="ht-img">⚽</div>
                            <div class="ht-overlay">
                                <div class="ht-cat cat-olahraga" style="background:var(--green)">Olahraga</div>
                                <div class="ht-title">Persiapan Timnas Jelang Laga Kualifikasi Piala Dunia</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sec-head">
                <div class="sec-bar"></div>
                <div class="sec-title">Berita Terkini</div>
                <a href="/kategori/terkini" class="sec-link">Lihat Semua ➔</a>
            </div>
            <div class="news-grid-2">
                <div class="news-card">
                    <div class="nc-img">🤖</div>
                    <div class="nc-cat cat-teknologi">Teknologi</div>
                    <div class="nc-title">Perkembangan AI Generatif di Tahun 2026: Ancaman atau Peluang?</div>
                    <div class="nc-meta">10 Mar 2026 · 👁 12K views</div>
                </div>
                <div class="news-card">
                    <div class="nc-img">🏥</div>
                    <div class="nc-cat cat-kesehatan">Kesehatan</div>
                    <div class="nc-title">Varian Virus Baru Ditemukan, Kemenkes Himbau Masyarakat Waspada</div>
                    <div class="nc-meta">10 Mar 2026 · 👁 8.5K views</div>
                </div>
            </div>

            <hr class="sec-divider">

            <div class="sec-head">
                <div class="sec-bar"></div>
                <div class="sec-title">Baru Saja Rilis</div>
            </div>
            <div class="news-list" id="latestNewsContainer">
                <div class="news-list-item">
                    <div class="nli-img">🌿</div>
                    <div>
                        <div class="nli-cat cat-lingkungan">Lingkungan</div>
                        <div class="nli-title">Program Tanam 1 Juta Pohon Sukses Dilaksanakan di Kalimantan</div>
                        <div class="nli-meta">5 Menit lalu · Rina Agustina</div>
                    </div>
                </div>
                <div class="news-list-item">
                    <div class="nli-img">⚖️</div>
                    <div>
                        <div class="nli-cat cat-hukum">Hukum</div>
                        <div class="nli-title">Sidang Kasus Korupsi Dana Bansos Dilanjutkan Hari Ini</div>
                        <div class="nli-meta">15 Menit lalu · Arif Wibowo</div>
                    </div>
                </div>
                <div class="news-list-item">
                    <div class="nli-img">🎭</div>
                    <div>
                        <div class="nli-cat cat-budaya">Budaya</div>
                        <div class="nli-title">Festival Seni Tradisional Bawa Pesan Perdamaian Antar Suku</div>
                        <div class="nli-meta">40 Menit lalu · Sari Maharani</div>
                    </div>
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
        // Nanti di sini kita taruh AJAX buat narik data beneran dari API Laravel
        // Buat sekarang, biarin pake dummy HTML di atas dulu biar lu bisa liat bentuknya.
        console.log("Halaman Home berhasil di-load!");
    });
</script>
@endsection
