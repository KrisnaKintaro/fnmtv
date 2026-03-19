@extends('Viewers.master_viewers')
@section('css')
@endsection
@section('konten')
    <!-- ════ HOME VIEW ════ -->
    <div id="homeView">
        <div class="container">

            <!-- SEARCH RESULTS (UC-10) -->
            <div class="search-results" id="searchResults">
                <div class="sr-head">
                    <div class="sr-title" id="srTitle">Hasil pencarian: "..."</div>
                    <div class="sr-sub" id="srSub">Ditemukan 0 berita</div>
                </div>
                <div id="srContent"></div>
                <hr style="margin-bottom:20px;">
            </div>

            <!-- HERO (UC-08) -->
            <div class="hero-section" id="heroSection">
                <div class="hero-grid">
                    <div class="hero-main" onclick="openArticle('berkas-epstein')">
                        <div class="hero-img">🕵️</div>
                        <div class="hero-overlay">
                            <div class="hero-cat">Pilihan Editor</div>
                            <div class="hero-title">Berkas Epstein memicu era baru teori konspirasi</div>
                            <div class="hero-meta">Budi Santoso • 10 Mar 2026 &nbsp;·&nbsp; <span class="view-counter"><span
                                        class="vc-pulse"></span>84.2K views</span></div>
                        </div>
                    </div>
                    <div class="hero-side">
                        <div class="hero-thumb" onclick="openArticle('komisi-x')">
                            <div class="ht-img">🏛️</div>
                            <div class="ht-overlay">
                                <div class="ht-cat">Politik</div>
                                <div class="ht-title">Komisi X DPR Ingatkan Alumni: "Cukup Aku yang Urus WN? LPDP Dana
                                    Publik"</div>
                            </div>
                        </div>
                        <div class="hero-thumb" onclick="openArticle('gajah-sumatera')">
                            <div class="ht-img" style="background:linear-gradient(#1a2a1a,#0a1a0a)">🐘</div>
                            <div class="ht-overlay">
                                <div class="ht-cat">Lingkungan</div>
                                <div class="ht-title">Gajah Sumatera 20 Tahun Mati Diduga Terlilit Kawat Listrik di Aceh
                                </div>
                            </div>
                        </div>
                        <div class="hero-thumb" onclick="openArticle('seskab-teddy')">
                            <div class="ht-img" style="background:linear-gradient(#2a1a2a,#1a0a2a)">👔</div>
                            <div class="ht-overlay">
                                <div class="ht-cat">Politik</div>
                                <div class="ht-title">Seskab Teddy: Tidak Benar Produk AS Masuk Indonesia Tanpa Sertifikasi
                                    Halal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN + SIDEBAR -->
            <div class="main-grid">
                <div>
                    <!-- BERITA TERKINI (UC-08) -->
                    <div class="sec-head">
                        <div class="sec-bar"></div>
                        <div class="sec-title">Berita Terkini</div>
                        <div class="sec-link">Lihat Semua →</div>
                    </div>
                    <hr class="sec-divider">
                    <div class="news-grid-3">
                        <div class="news-card" onclick="openArticle('aksi-brimob')">
                            <div class="nc-img">👮</div>
                            <div class="nc-cat cat-politik">Hukum</div>
                            <div class="nc-title">Aksi Brutal Oknum Brimob Aniaya Siswa Pakai Helm hingga Tewas di Tual
                            </div>
                            <div class="nc-meta"><span>Rina A.</span><span>·</span><span class="nc-views">👁 14.2K</span>
                            </div>
                        </div>
                        <div class="news-card" onclick="openArticle('polisi-muda')">
                            <div class="nc-img">🚔</div>
                            <div class="nc-cat cat-politik">Kriminal</div>
                            <div class="nc-title">Polisi Muda di Sulsel Tewas di Barak, Kompolnas Desak Pengusutan</div>
                            <div class="nc-meta"><span>Dewi P.</span><span>·</span><span class="nc-views">👁 9.8K</span>
                            </div>
                        </div>
                        <div class="news-card" onclick="openArticle('guru-honorer')">
                            <div class="nc-img">🎓</div>
                            <div class="nc-cat cat-teknologi">Pendidikan</div>
                            <div class="nc-title">Ketika Guru Honorer Dipecat, Rangkap Jabatan Elite Tetap Lemah</div>
                            <div class="nc-meta"><span>Sari M.</span><span>·</span><span class="nc-views">👁 7.3K</span>
                            </div>
                        </div>
                    </div>

                    <!-- AD BANNER -->
                    <div class="ad-banner">
                        <div class="ad-label">Advertisement</div>
                        <div class="ad-content">RICHARD MILLE</div>
                    </div>

                    <!-- BERITA POPULER (UC-11) -->
                    <div class="sec-head">
                        <div class="sec-bar" style="background:#1a3a7a"></div>
                        <div class="sec-title">Berita Populer & Trending</div>
                        <div class="sec-link">Lihat Semua →</div>
                    </div>
                    <hr class="sec-divider">
                    <div class="news-grid-3" style="margin-bottom:0">
                        <div class="news-card" onclick="openArticle('rupiah-as')">
                            <div class="nc-img" style="background:linear-gradient(135deg,#e8f4e8,#d0e8d0)">💵</div>
                            <div class="nc-cat cat-ekonomi">Ekonomi</div>
                            <div class="nc-title">Rupiah Dibuka Menguat Pagi Ini AS Batalkan Tarif Trump</div>
                            <div class="nc-meta"><span>Arif W.</span><span>·</span><span class="nc-views">🔥 42.1K</span>
                            </div>
                        </div>
                        <div class="news-card" onclick="openArticle('prabowo-bilateral')">
                            <div class="nc-img">🤝</div>
                            <div class="nc-cat cat-politik">Politik</div>
                            <div class="nc-title">Seskab Teddy: Prabowo Satu-satunya Kepala Negara Gelar Bilateral Bareng...
                            </div>
                            <div class="nc-meta"><span>Budi S.</span><span>·</span><span class="nc-views">🔥 38.7K</span>
                            </div>
                        </div>
                        <div class="news-card" onclick="openArticle('ucapan-imlek')">
                            <div class="nc-img" style="background:linear-gradient(135deg,#ffe4e4,#ffd0d0)">🧧</div>
                            <div class="nc-cat" style="color:#b86200">Budaya</div>
                            <div class="nc-title">100 Ucapan Imlek 2026 Penuh Harapan dan Keberuntungan</div>
                            <div class="nc-meta"><span>Sari M.</span><span>·</span><span class="nc-views">🔥 35.2K</span>
                            </div>
                        </div>
                    </div>

                    <!-- NEWS LIST SECTION -->
                    <div style="margin-top:28px;">
                        <div class="sec-head">
                            <div class="sec-bar" style="background:#1a7a3c"></div>
                            <div class="sec-title">Berita Terbaru</div>
                        </div>
                        <hr class="sec-divider">
                        <div>
                            <div class="news-list-item" onclick="openArticle('ihsg-menguat')">
                                <div class="nli-img">📈</div>
                                <div>
                                    <div class="nli-cat cat-ekonomi">Ekonomi</div>
                                    <div class="nli-title">Update Harga Emas Hartatinata Abadi 23 Februari 2026</div>
                                    <div class="nli-meta">Arif W. • 10 Mar 2026 · 👁 8.4K views</div>
                                </div>
                            </div>
                            <div class="news-list-item" onclick="openArticle('psm-dihukum')">
                                <div class="nli-img">⚽</div>
                                <div>
                                    <div class="nli-cat cat-olahraga">Olahraga</div>
                                    <div class="nli-title">Persebaya Dihantam Dua Kekalahan, Tawuran Putar Otak Hadapi PSM
                                    </div>
                                    <div class="nli-meta">Rina A. • 10 Mar 2026 · 👁 22.1K views</div>
                                </div>
                            </div>
                            <div class="news-list-item" onclick="openArticle('sulawesi-gempa')">
                                <div class="nli-img">🌊</div>
                                <div>
                                    <div class="nli-cat cat-politik">Bencana</div>
                                    <div class="nli-title">Rehabilitasi 32 Daerah Terdampak Bencana Sumatera Butuh Waktu...
                                    </div>
                                    <div class="nli-meta">Dewi P. • 9 Mar 2026 · 👁 11.3K views</div>
                                </div>
                            </div>
                            <div class="news-list-item" onclick="openArticle('teknologi-ai')">
                                <div class="nli-img">🤖</div>
                                <div>
                                    <div class="nli-cat cat-teknologi">Teknologi</div>
                                    <div class="nli-title">Peneliti Dunia Sepakati Regulasi AI Baru untuk Cegah
                                        Penyalahgunaan Data</div>
                                    <div class="nli-meta">Arif W. • 9 Mar 2026 · 👁 6.7K views</div>
                                </div>
                            </div>
                            <div class="news-list-item" onclick="openArticle('kesehatan-jantung')">
                                <div class="nli-img">❤️</div>
                                <div>
                                    <div class="nli-cat cat-kesehatan">Kesehatan</div>
                                    <div class="nli-title">Studi Terbaru: Jalan Kaki 30 Menit Sehari Turunkan Risiko
                                        Jantung 40%</div>
                                    <div class="nli-meta">Sari M. • 9 Mar 2026 · 👁 19.4K views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR -->
                <div>
                    <!-- TRENDING (UC-11) -->
                    <div class="widget">
                        <div class="wgt-title">🔥 Trending Sekarang</div>
                        <div class="trending-item" onclick="openArticle('rupiah-as')">
                            <div class="tr-rank">01</div>
                            <div>
                                <div class="tr-title">Rupiah Dibuka Menguat Pagi Ini AS Batalkan Tarif Trump</div>
                                <div class="tr-views">👁 42.1K views</div>
                            </div>
                        </div>
                        <div class="trending-item" onclick="openArticle('prabowo-bilateral')">
                            <div class="tr-rank">02</div>
                            <div>
                                <div class="tr-title">Prabowo Satu-satunya Kepala Negara Gelar Bilateral</div>
                                <div class="tr-views">👁 38.7K views</div>
                            </div>
                        </div>
                        <div class="trending-item" onclick="openArticle('ucapan-imlek')">
                            <div class="tr-rank">03</div>
                            <div>
                                <div class="tr-title">100 Ucapan Imlek 2026 Penuh Harapan dan Keberuntungan</div>
                                <div class="tr-views">👁 35.2K views</div>
                            </div>
                        </div>
                        <div class="trending-item" onclick="openArticle('berkas-epstein')">
                            <div class="tr-rank">04</div>
                            <div>
                                <div class="tr-title">Berkas Epstein memicu era baru teori konspirasi</div>
                                <div class="tr-views">👁 28.9K views</div>
                            </div>
                        </div>
                        <div class="trending-item" onclick="openArticle('psm-dihukum')">
                            <div class="tr-rank">05</div>
                            <div>
                                <div class="tr-title">Persebaya Dihantam Dua Kekalahan, Tawuran Putar Otak</div>
                                <div class="tr-views">👁 22.1K views</div>
                            </div>
                        </div>
                    </div>

                    <!-- AD SIDEBAR -->
                    <div class="ad-banner" style="margin-bottom:20px;">
                        <div class="ad-label">Advertisement</div>
                        <div class="ad-content" style="font-size:14px;">IKLAN ANDA DI SINI</div>
                        <div style="font-size:11px;opacity:.5;margin-top:4px;">300×250</div>
                    </div>

                    <!-- BERITA PILIHAN -->
                    <div class="widget">
                        <div class="wgt-title">✨ Pilihan Editor</div>
                        <div class="news-list-item" style="border:none;padding:8px 0;"
                            onclick="openArticle('berkas-epstein')">
                            <div class="nli-img" style="width:60px;height:44px;font-size:20px;">🕵️</div>
                            <div>
                                <div class="nli-title" style="font-size:12px;">Berkas Epstein memicu era baru teori
                                    konspirasi</div>
                                <div class="nli-meta">84.2K views</div>
                            </div>
                        </div>
                        <div class="news-list-item" style="border:none;padding:8px 0;"
                            onclick="openArticle('kesehatan-jantung')">
                            <div class="nli-img" style="width:60px;height:44px;font-size:20px;">❤️</div>
                            <div>
                                <div class="nli-title" style="font-size:12px;">Studi Terbaru: Jalan Kaki 30 Menit Turunkan
                                    Risiko Jantung</div>
                                <div class="nli-meta">19.4K views</div>
                            </div>
                        </div>
                        <div class="news-list-item" style="border-bottom:none;padding:8px 0;"
                            onclick="openArticle('teknologi-ai')">
                            <div class="nli-img" style="width:60px;height:44px;font-size:20px;">🤖</div>
                            <div>
                                <div class="nli-title" style="font-size:12px;">Regulasi AI Baru Disepakati Peneliti Dunia
                                </div>
                                <div class="nli-meta">6.7K views</div>
                            </div>
                        </div>
                    </div>

                    <!-- KATEGORI -->
                    <div class="widget">
                        <div class="wgt-title">📂 Jelajahi Kategori</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                            <div style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:600;transition:.15s;"
                                onclick="setNav(null,'politik')">🏛️ Politik</div>
                            <div style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:600;transition:.15s;"
                                onclick="setNav(null,'ekonomi')">💹 Ekonomi</div>
                            <div style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:600;transition:.15s;"
                                onclick="setNav(null,'olahraga')">⚽ Olahraga</div>
                            <div style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:600;transition:.15s;"
                                onclick="setNav(null,'teknologi')">💻 Teknologi</div>
                            <div style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:600;transition:.15s;"
                                onclick="setNav(null,'kesehatan')">🩺 Kesehatan</div>
                            <div
                                style="background:var(--bg);border:1px solid var(--border);border-radius:5px;padding:10px;text-align:center;cursor:pointer;font-size:13px;font-weight:600;transition:.15s;">
                                🎬 Hiburan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
