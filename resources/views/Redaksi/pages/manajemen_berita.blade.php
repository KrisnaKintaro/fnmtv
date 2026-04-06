@extends('Redaksi.redaksi_master')

@section('css')
@endsection

@section('konten')
    <!-- ══ HALAMAN UTAMA ══ -->
    <div class="page active">
        <div class="section-title">Manajemen Berita</div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="tab-pills" id="tabPills">
                <div class="tab-p active" id="tab-all" onclick="showTab('all', this)">
                    Semua <span class="tab-cnt cnt-all" id="cnt-all">9</span>
                </div>
                <div class="tab-p" id="tab-pending" onclick="showTab('pending', this)">
                    Pending <span class="tab-cnt cnt-pending" id="cnt-pending">5</span>
                </div>
                <div class="tab-p" id="tab-approved" onclick="showTab('approved', this)">
                    Disetujui <span class="tab-cnt cnt-approved" id="cnt-approved">3</span>
                </div>
                <div class="tab-p" id="tab-rejected" onclick="showTab('rejected', this)">
                    Ditolak <span class="tab-cnt cnt-rejected" id="cnt-rejected">1</span>
                </div>
            </div>
            <div style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;">
                <select class="filter-select" id="filterKategori" style="font-size:12px;padding:6px 10px;"
                    onchange="applyFilters()">
                    <option value="">Semua Kategori</option>
                    <option>Politik</option>
                    <option>Ekonomi</option>
                    <option>Teknologi</option>
                    <option>Olahraga</option>
                    <option>Kesehatan</option>
                    <option>Internasional</option>
                    <option>Sains</option>
                    <option>Infrastruktur</option>
                    <option>Hiburan</option>
                </select>
                <select class="filter-select" id="filterPenulis" style="font-size:12px;padding:6px 10px;"
                    onchange="applyFilters()">
                    <option value="">Semua Penulis</option>
                    <option>Budi Santoso</option>
                    <option>Arif Wibowo</option>
                    <option>Dewi Puspita</option>
                    <option>Sari Maharani</option>
                </select>
            </div>
        </div>

        <!-- ══ TABEL ══ -->
        <div class="card">
            <div class="card-hd">
                <div class="card-ht" id="cardTitle">Daftar Artikel Masuk dari Editor</div>
                <div class="card-hm" id="tableCount">Menampilkan 9 artikel</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width:70px;">Thumbnail</th>
                        <th>Judul &amp; Informasi</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal Kirim</th>
                        <th>Status</th>
                        <th style="width:80px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="newsBody">

                    <!-- ═══ PENDING ═══ -->
                    <tr data-status="pending" data-key="beras" data-cat="Ekonomi" data-author="Budi Santoso">
                        <td>
                            <div class="tbl-img">🌾</div>
                        </td>
                        <td>
                            <div class="tbl-title">Harga Beras Naik Jelang Lebaran, Pemerintah Buka Impor</div>
                            <div class="tbl-meta">Menunggu keputusan Redaksi</div>
                        </td>
                        <td><span class="badge b-cat">Ekonomi</span></td>
                        <td style="font-size:12px;color:var(--muted);">Budi Santoso</td>
                        <td style="font-size:12px;color:var(--muted);">26 Mar 2026</td>
                        <td><span class="badge b-pending">Pending</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat &amp; Validasi" onclick="openModal('beras')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr data-status="pending" data-key="bpjs" data-cat="Kesehatan" data-author="Arif Wibowo">
                        <td>
                            <div class="tbl-img">🏥</div>
                        </td>
                        <td>
                            <div class="tbl-title">BPJS Kesehatan Tanggung Biaya Operasi Jantung Terbaru</div>
                            <div class="tbl-meta">Menunggu keputusan Redaksi</div>
                        </td>
                        <td><span class="badge b-cat">Kesehatan</span></td>
                        <td style="font-size:12px;color:var(--muted);">Arif Wibowo</td>
                        <td style="font-size:12px;color:var(--muted);">25 Mar 2026</td>
                        <td><span class="badge b-pending">Pending</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat &amp; Validasi" onclick="openModal('bpjs')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr data-status="pending" data-key="asean" data-cat="Internasional" data-author="Budi Santoso">
                        <td>
                            <div class="tbl-img">🌐</div>
                        </td>
                        <td>
                            <div class="tbl-title">KTT ASEAN 2026 Bahas Krisis Pangan dan Energi Regional</div>
                            <div class="tbl-meta">Menunggu keputusan Redaksi</div>
                        </td>
                        <td><span class="badge b-cat">Internasional</span></td>
                        <td style="font-size:12px;color:var(--muted);">Budi Santoso</td>
                        <td style="font-size:12px;color:var(--muted);">24 Mar 2026</td>
                        <td><span class="badge b-pending">Pending</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat &amp; Validasi" onclick="openModal('asean')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr data-status="pending" data-key="brin" data-cat="Sains" data-author="Dewi Puspita">
                        <td>
                            <div class="tbl-img">🔬</div>
                        </td>
                        <td>
                            <div class="tbl-title">Peneliti BRIN Temukan Spesies Baru di Hutan Papua</div>
                            <div class="tbl-meta">Menunggu keputusan Redaksi</div>
                        </td>
                        <td><span class="badge b-cat">Sains</span></td>
                        <td style="font-size:12px;color:var(--muted);">Dewi Puspita</td>
                        <td style="font-size:12px;color:var(--muted);">23 Mar 2026</td>
                        <td><span class="badge b-pending">Pending</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat &amp; Validasi" onclick="openModal('brin')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr data-status="pending" data-key="lrt" data-cat="Infrastruktur" data-author="Arif Wibowo">
                        <td>
                            <div class="tbl-img">🏙️</div>
                        </td>
                        <td>
                            <div class="tbl-title">Proyek LRT Jabodebek Fase 2 Mulai Konstruksi April 2026</div>
                            <div class="tbl-meta">Menunggu keputusan Redaksi</div>
                        </td>
                        <td><span class="badge b-cat">Infrastruktur</span></td>
                        <td style="font-size:12px;color:var(--muted);">Arif Wibowo</td>
                        <td style="font-size:12px;color:var(--muted);">22 Mar 2026</td>
                        <td><span class="badge b-pending">Pending</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat &amp; Validasi" onclick="openModal('lrt')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- ═══ DISETUJUI ═══ -->
                    <tr data-status="approved" data-key="kebijakan" data-cat="Politik" data-author="Budi Santoso">
                        <td>
                            <div class="tbl-img">🏛️</div>
                        </td>
                        <td>
                            <div class="tbl-title">Pemerintah Umumkan Kebijakan Ekonomi Baru untuk 2026</div>
                            <div class="tbl-meta">Disetujui oleh Redaksi · 15 Mar 2026</div>
                        </td>
                        <td><span class="badge b-cat">Politik</span></td>
                        <td style="font-size:12px;color:var(--muted);">Budi Santoso</td>
                        <td style="font-size:12px;color:var(--muted);">15 Mar 2026</td>
                        <td><span class="badge b-approved">Disetujui</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat Detail" onclick="openModal('kebijakan')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr data-status="approved" data-key="garuda" data-cat="Olahraga" data-author="Sari Maharani">
                        <td>
                            <div class="tbl-img">⚽</div>
                        </td>
                        <td>
                            <div class="tbl-title">Timnas Garuda Menang Telak 3-0 Lawan Vietnam</div>
                            <div class="tbl-meta">Disetujui oleh Redaksi · 14 Mar 2026</div>
                        </td>
                        <td><span class="badge b-cat">Olahraga</span></td>
                        <td style="font-size:12px;color:var(--muted);">Sari Maharani</td>
                        <td style="font-size:12px;color:var(--muted);">14 Mar 2026</td>
                        <td><span class="badge b-approved">Disetujui</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat Detail" onclick="openModal('garuda')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr data-status="approved" data-key="film" data-cat="Hiburan" data-author="Sari Maharani">
                        <td>
                            <div class="tbl-img">🎬</div>
                        </td>
                        <td>
                            <div class="tbl-title">Film Indonesia Raih Penghargaan di Festival Berlin</div>
                            <div class="tbl-meta">Disetujui oleh Redaksi · 12 Mar 2026</div>
                        </td>
                        <td><span class="badge b-cat">Hiburan</span></td>
                        <td style="font-size:12px;color:var(--muted);">Sari Maharani</td>
                        <td style="font-size:12px;color:var(--muted);">12 Mar 2026</td>
                        <td><span class="badge b-approved">Disetujui</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat Detail" onclick="openModal('film')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- ═══ DITOLAK ═══ -->
                    <tr data-status="rejected" data-key="hoaks" data-cat="Teknologi" data-author="Dewi Puspita">
                        <td>
                            <div class="tbl-img">📱</div>
                        </td>
                        <td>
                            <div class="tbl-title">Aplikasi Medsos Baru Diklaim Lebih Privat dari WhatsApp</div>
                            <div class="tbl-meta">Ditolak · Sumber tidak terverifikasi</div>
                        </td>
                        <td><span class="badge b-cat">Teknologi</span></td>
                        <td style="font-size:12px;color:var(--muted);">Dewi Puspita</td>
                        <td style="font-size:12px;color:var(--muted);">10 Mar 2026</td>
                        <td><span class="badge b-rejected">✕ Ditolak</span></td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Lihat Detail" onclick="openModal('hoaks')">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>

            <!-- empty state -->
            <div class="empty-state" id="emptyState" style="display:none;">
                <div class="ico">📭</div>
                <p>Tidak ada artikel ditemukan pada kategori ini.</p>
            </div>

            <div class="pager">
                <div class="pg-btn active">1</div>
                <div class="pg-btn">2</div>
                <div class="pg-btn">›</div>
                <div class="pg-info" id="pagerInfo">Menampilkan 9 dari 9 artikel</div>
            </div>
        </div>
    </div><!-- /page -->

    <!-- ══════════════════════════════════════
             MODAL DETAIL ARTIKEL + VALIDASI
        ══════════════════════════════════════ -->
    <div class="modal-backdrop" id="modalDetail" onclick="handleBackdropClick(event)">
        <div class="modal">
            <div class="modal-hd">
                <div class="modal-hd-text">
                    <div class="modal-title" id="mdTitle">—</div>
                    <div class="modal-sub" id="mdSub">—</div>
                </div>
                <div class="modal-close" onclick="closeDetail()">✕</div>
            </div>
            <div class="modal-body">
                <div class="modal-thumb" id="mdThumb">📰</div>
                <div class="modal-chips" id="mdChips">
                    <div class="chip">Penulis: <b id="md-author">—</b></div>
                    <div class="chip">Kategori: <b id="md-cat">—</b></div>
                    <div class="chip">Dikirim: <b id="md-date">—</b></div>
                    <div class="chip">Status: <b id="md-status">—</b></div>
                </div>
                <div class="modal-sec">Isi Artikel</div>
                <div class="modal-article-body" id="mdContent"></div>
                <div class="modal-divider"></div>

                <!-- KOTAK VALIDASI — hanya muncul jika status pending -->
                <div id="mdVerdictWrap" style="display:none;">
                    <div class="verdict-box">
                        <div class="verdict-title">Keputusan Redaksi</div>
                        <div class="verdict-desc">Periksa artikel dengan saksama sebelum memberikan keputusan. Keputusan
                            akan langsung diteruskan ke Editor yang bersangkutan.</div>
                        <div class="verdict-actions">
                            <button class="vbtn vbtn-approve" onclick="verdictApprove()">
                                <svg width="14" height="14" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Setujui Artikel
                            </button>
                            <button class="vbtn vbtn-reject" onclick="verdictReject()">
                                <svg width="14" height="14" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tolak Artikel
                            </button>
                        </div>
                        <!-- Form alasan penolakan -->
                        <div class="reject-note" id="mdRejectNote">
                            <label>Alasan Penolakan (wajib diisi)</label>
                            <textarea id="mdRejectText"
                                placeholder="Tuliskan alasan penolakan yang jelas untuk Editor, misalnya: sumber tidak terverifikasi, konten tidak sesuai standar editorial, dll."></textarea>
                            <div class="reject-note-btns">
                                <button class="btn btn-outline btn-sm" onclick="closeRejectNote()">Batal</button>
                                <button class="btn btn-red btn-sm" onclick="submitRejectFromDetail()">
                                    <svg width="12" height="12" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Kirim Penolakan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STATUS INFO — muncul jika sudah disetujui atau ditolak -->
                <div id="mdResultWrap" style="display:none;">
                    <div class="info-result-box" id="mdResultBox">
                        <div class="ico" id="mdResultIco"></div>
                        <div class="txt">
                            <strong id="mdResultTitle"></strong>
                            <span id="mdResultDesc"></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ── TOAST ── -->
    <div id="toast" style="display:none;opacity:1;">
        <span id="toastIco"></span>
        <span id="toastMsg"></span>
    </div>
@endsection
@section('js')
    <script>
        /* ══════════════════════════════════════
       DATABASE ARTIKEL (simulasi)
    ══════════════════════════════════════ */
        const DB = {
            beras: {
                title: 'Harga Beras Naik Jelang Lebaran, Pemerintah Buka Impor',
                author: 'Budi Santoso',
                cat: 'Ekonomi',
                date: '26 Mar 2026',
                status: 'pending',
                emoji: '🌾',
                content: `<p>Harga beras di berbagai pasar tradisional Indonesia mengalami kenaikan signifikan menjelang Hari Raya Idul Fitri 2026. Berdasarkan data dari Badan Pangan Nasional, harga beras medium kini menyentuh Rp16.500 per kilogram, naik sekitar 12% dari bulan sebelumnya.</p>
    <p>Pemerintah melalui Kementerian Perdagangan mengumumkan kebijakan buka impor beras sebanyak 500.000 ton untuk menstabilkan pasokan dalam negeri. Langkah ini diambil setelah stok Bulog di beberapa daerah mulai menipis akibat tingginya permintaan menjelang lebaran.</p>
    <p>Menteri Pertanian dalam konferensi pers menyatakan bahwa kebijakan impor ini bersifat sementara dan tidak akan mengganggu petani lokal. "Kami memastikan harga di tingkat petani tetap terjaga," ujarnya.</p>`
            },
            bpjs: {
                title: 'BPJS Kesehatan Tanggung Biaya Operasi Jantung Terbaru',
                author: 'Arif Wibowo',
                cat: 'Kesehatan',
                date: '25 Mar 2026',
                status: 'pending',
                emoji: '🏥',
                content: `<p>BPJS Kesehatan resmi mengumumkan perluasan cakupan layanan dengan menanggung biaya prosedur operasi jantung terbaru, termasuk pemasangan ring koroner generasi terbaru dan operasi bypass arteri. Kebijakan ini berlaku mulai 1 April 2026.</p>
    <p>Direktur Utama BPJS Kesehatan menjelaskan bahwa perluasan manfaat ini merupakan bagian dari komitmen pemerintah untuk memberikan akses layanan kesehatan berkualitas bagi seluruh masyarakat Indonesia tanpa terkecuali.</p>
    <p>Peserta BPJS Kesehatan yang membutuhkan layanan ini cukup mendapatkan rujukan dari fasilitas kesehatan tingkat pertama (FKTP) dan mengikuti prosedur yang berlaku.</p>`
            },
            asean: {
                title: 'KTT ASEAN 2026 Bahas Krisis Pangan dan Energi Regional',
                author: 'Budi Santoso',
                cat: 'Internasional',
                date: '24 Mar 2026',
                status: 'pending',
                emoji: '🌐',
                content: `<p>Konferensi Tingkat Tinggi (KTT) ASEAN 2026 yang berlangsung di Jakarta resmi dibuka pada Senin (23/3). Para pemimpin dari 10 negara anggota ASEAN berkumpul untuk membahas isu-isu krusial, terutama krisis pangan dan energi yang melanda kawasan Asia Tenggara.</p>
    <p>Indonesia selaku tuan rumah mengusulkan pembentukan cadangan pangan bersama ASEAN (ASEAN Food Reserve) sebagai langkah konkret menghadapi ancaman ketahanan pangan regional. Presiden menegaskan pentingnya solidaritas kawasan dalam menghadapi tantangan global.</p>
    <p>Isu transisi energi juga menjadi agenda utama, dengan beberapa negara anggota mendorong percepatan pengembangan energi terbarukan dan kerja sama dalam jaringan transmisi listrik regional.</p>`
            },
            brin: {
                title: 'Peneliti BRIN Temukan Spesies Baru di Hutan Papua',
                author: 'Dewi Puspita',
                cat: 'Sains',
                date: '23 Mar 2026',
                status: 'pending',
                emoji: '🔬',
                content: `<p>Tim peneliti dari Badan Riset dan Inovasi Nasional (BRIN) mengumumkan penemuan spesies baru amfibi di kawasan hutan hujan pegunungan Papua Tengah. Spesies katak yang diberi nama ilmiah <em>Litoria papuaensis fnm</em> ini ditemukan pada ketinggian sekitar 1.800 meter di atas permukaan laut.</p>
    <p>Dr. Ratna Dewi selaku ketua tim riset menjelaskan bahwa spesies ini memiliki pola warna unik bercak emas di punggungnya yang belum pernah ditemukan sebelumnya. "Penemuan ini membuktikan Papua masih menyimpan kekayaan biodiversitas yang luar biasa," ungkapnya.</p>
    <p>Penelitian ini dilakukan selama 18 bulan dan merupakan bagian dari program pemetaan keanekaragaman hayati Indonesia yang diinisiasi oleh BRIN bekerja sama dengan berbagai lembaga internasional.</p>`
            },
            lrt: {
                title: 'Proyek LRT Jabodebek Fase 2 Mulai Konstruksi April 2026',
                author: 'Arif Wibowo',
                cat: 'Infrastruktur',
                date: '22 Mar 2026',
                status: 'pending',
                emoji: '🏙️',
                content: `<p>Kementerian Perhubungan resmi mengumumkan dimulainya konstruksi LRT Jabodebek Fase 2 yang akan memperluas jaringan ke wilayah Bogor dan Tangerang Selatan. Peletakan batu pertama dijadwalkan pada awal April 2026 dan ditargetkan beroperasi penuh pada 2029.</p>
    <p>Proyek senilai Rp 42 triliun ini akan menambah 3 jalur baru sepanjang total 47 kilometer dengan 28 stasiun baru. Kapasitas angkut diperkirakan mencapai 1,2 juta penumpang per hari, jauh meningkat dari kapasitas fase 1.</p>
    <p>Menteri Perhubungan optimistis proyek ini akan mengurangi kemacetan di koridor Jabodetabek secara signifikan dan mendorong masyarakat beralih dari kendaraan pribadi ke transportasi publik.</p>`
            },
            kebijakan: {
                title: 'Pemerintah Umumkan Kebijakan Ekonomi Baru untuk 2026',
                author: 'Budi Santoso',
                cat: 'Politik',
                date: '15 Mar 2026',
                status: 'approved',
                emoji: '🏛️',
                content: `<p>Pemerintah Indonesia secara resmi meluncurkan paket kebijakan ekonomi baru untuk tahun 2026 yang mencakup 12 langkah strategis. Kebijakan ini dirancang untuk mendorong pertumbuhan ekonomi, menciptakan lapangan kerja, dan memperkuat ketahanan fiskal nasional.</p>
    <p>Beberapa poin utama kebijakan meliputi pemotongan pajak bagi UMKM hingga 50%, insentif investasi di sektor manufaktur berbasis teknologi tinggi, serta program hilirisasi sumber daya alam yang diperluas ke 14 komoditas strategis.</p>
    <p>Para ekonom menilai paket kebijakan ini cukup komprehensif dan diharapkan mampu menjaga laju pertumbuhan ekonomi di kisaran 5,2–5,5% sepanjang 2026.</p>`
            },
            garuda: {
                title: 'Timnas Garuda Menang Telak 3-0 Lawan Vietnam',
                author: 'Sari Maharani',
                cat: 'Olahraga',
                date: '14 Mar 2026',
                status: 'approved',
                emoji: '⚽',
                content: `<p>Timnas Indonesia menunjukkan performa gemilang dengan mengalahkan Vietnam 3-0 dalam laga kualifikasi Piala Dunia 2026 zona Asia di Stadion Utama Gelora Bung Karno, Jakarta. Tiga gol kemenangan dicetak oleh Marselino Ferdinan (menit 23), Egy Maulana Vikri (menit 51), dan Rafael Struick (menit 78).</p>
    <p>Pelatih Shin Tae-yong menyebut kemenangan ini sebagai buah dari kerja keras para pemain dan keyakinan penuh terhadap proses yang dibangun bersama. "Kami masih fokus ke pertandingan berikutnya," ujarnya usai laga.</p>
    <p>Dengan kemenangan ini, Indonesia kini memimpin klasemen Grup C dengan 13 poin dari 6 pertandingan dan berpeluang besar melaju ke babak berikutnya.</p>`
            },
            film: {
                title: 'Film Indonesia Raih Penghargaan di Festival Berlin',
                author: 'Sari Maharani',
                cat: 'Hiburan',
                date: '12 Mar 2026',
                status: 'approved',
                emoji: '🎬',
                content: `<p>Film Indonesia berjudul "Tanah di Ujung Dunia" berhasil meraih penghargaan Silver Bear untuk kategori Best Director di Berlinale 2026. Sutradara Kamila Andini menjadi perempuan Indonesia pertama yang meraih penghargaan bergengsi tersebut.</p>
    <p>Film yang mengangkat kisah komunitas nelayan di pesisir timur Indonesia ini mendapat sambutan luar biasa dari penonton dan kritikus internasional. Kamila menyebut penghargaan ini adalah milik seluruh insan perfilman Indonesia.</p>
    <p>Keberhasilan ini diharapkan membuka lebih banyak pintu bagi film-film Indonesia untuk bersaing di kancah festival internasional dan mendorong pertumbuhan industri perfilman tanah air.</p>`
            },
            hoaks: {
                title: 'Aplikasi Medsos Baru Diklaim Lebih Privat dari WhatsApp',
                author: 'Dewi Puspita',
                cat: 'Teknologi',
                date: '10 Mar 2026',
                status: 'rejected',
                emoji: '📱',
                rejectReason: 'Sumber data tidak terverifikasi dan klaim teknis dalam artikel tidak didukung oleh bukti ilmiah yang cukup. Mohon perbaiki dengan melampirkan sumber resmi dan hasil audit keamanan independen sebelum dikirim ulang.',
                content: `<p>Sebuah aplikasi media sosial baru bernama "PrivaChat" yang dikembangkan oleh startup lokal mengklaim memiliki tingkat privasi lebih tinggi dibandingkan WhatsApp dan platform sejenis. Aplikasi ini diklaim menggunakan enkripsi quantum yang tidak dapat ditembus.</p>
    <p>Pengembang aplikasi menyatakan bahwa data pengguna tidak pernah meninggalkan perangkat pengguna dan tidak ada server terpusat yang menyimpan percakapan. Namun demikian, klaim ini belum diverifikasi oleh pihak independen.</p>
    <p>Sejak diluncurkan dua minggu lalu, aplikasi ini diklaim telah diunduh lebih dari 500.000 kali meskipun verifikasi angka tersebut belum dapat dikonfirmasi.</p>`
            }
        };

        const BADGE_CLASS = {
            pending: 'b-pending',
            approved: 'b-approved',
            rejected: 'b-rejected'
        };
        const LABEL = {
            pending: 'Pending',
            approved: 'Disetujui',
            rejected: 'Ditolak'
        };
        const TITLES = {
            all: ['Manajeman Berita', 'Redaksi / Manajemen Berita'],
            pending: ['Manajeman Berita', 'Redaksi / Manajemen Berita'],
            approved: ['Manajeman Berita', 'Redaksi / Manajemen Berita'],
            rejected: ['Manajeman Berita', 'Redaksi / Manajemen Berita']
        };
        const CARD_TITLES = {
            all: 'Daftar Artikel Masuk dari Editor',
            pending: 'Artikel Menunggu Keputusan',
            approved: 'Artikel Telah Disetujui',
            rejected: 'Artikel Telah Ditolak'
        };

        let currentTab = 'all';

        /* ── TAB / FILTER ── */
        function showTab(status) {
            currentTab = status;

            // Update topbar
            const [title, crumb] = TITLES[status];
            document.getElementById('tbTitle').textContent = title;
            document.getElementById('tbCrumb').textContent = crumb;
            document.getElementById('cardTitle').textContent = CARD_TITLES[status];

            // Update tab pills (topbar)
            document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
            const tabEl = document.getElementById('tab-' + status);
            if (tabEl) tabEl.classList.add('active');

            applyFilters();
        }

        function applyFilters() {
            const cat = document.getElementById('filterKategori').value;
            const author = document.getElementById('filterPenulis').value;
            const search = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#newsBody tr');
            let visible = 0;

            rows.forEach(r => {
                const matchStatus = currentTab === 'all' || r.dataset.status === currentTab;
                const matchCat = !cat || r.dataset.cat === cat;
                const matchAuthor = !author || r.dataset.author === author;
                const titleText = r.querySelector('.tbl-title')?.textContent.toLowerCase() || '';
                const matchSearch = !search || titleText.includes(search) || r.dataset.author.toLowerCase()
                    .includes(search);
                const show = matchStatus && matchCat && matchAuthor && matchSearch;
                r.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            document.getElementById('tableCount').textContent = `Menampilkan ${visible} artikel`;
            document.getElementById('pagerInfo').textContent = `Menampilkan ${visible} dari 9 artikel`;
            document.getElementById('emptyState').style.display = visible === 0 ? 'block' : 'none';
        }

        function doSearch() {
            applyFilters();
        }

        /* ── MODAL DETAIL ── */
        function openModal(key) {
            const a = DB[key];
            document.getElementById('mdTitle').textContent = a.title;
            document.getElementById('mdSub').textContent = `${a.author} · ${a.cat} · ${a.date}`;
            document.getElementById('mdThumb').textContent = a.emoji;
            document.getElementById('md-author').textContent = a.author;
            document.getElementById('md-cat').textContent = a.cat;
            document.getElementById('md-date').textContent = a.date;
            document.getElementById('md-status').textContent = LABEL[a.status] || a.status;
            document.getElementById('mdContent').innerHTML = a.content;

            const vw = document.getElementById('mdVerdictWrap');
            const rw = document.getElementById('mdResultWrap');
            const rb = document.getElementById('mdResultBox');

            if (a.status === 'pending') {
                vw.style.display = 'block';
                rw.style.display = 'none';
                document.getElementById('mdRejectNote').classList.remove('show');
                document.getElementById('mdRejectText').value = '';
            } else {
                vw.style.display = 'none';
                rw.style.display = 'block';
                rb.className = 'info-result-box ' + a.status;
                if (a.status === 'approved') {
                    document.getElementById('mdResultIco').textContent = '✅';
                    document.getElementById('mdResultTitle').textContent = 'Artikel Telah Disetujui';
                    document.getElementById('mdResultDesc').textContent =
                        'Artikel ini sudah disetujui oleh Redaksi dan siap untuk diterbitkan.';
                } else {
                    document.getElementById('mdResultIco').textContent = '❌';
                    document.getElementById('mdResultTitle').textContent = 'Artikel Ditolak';
                    document.getElementById('mdResultDesc').textContent = a.rejectReason ||
                        'Artikel ini telah ditolak oleh Redaksi.';
                }
            }

            document.getElementById('modalDetail').dataset.currentKey = key;
            document.getElementById('modalDetail').classList.add('open');
        }

        function closeDetail() {
            document.getElementById('modalDetail').classList.remove('open');
        }

        function handleBackdropClick(e) {
            if (e.target === document.getElementById('modalDetail')) closeDetail();
        }

        /* ── VERDICT (dari modal) ── */
        function verdictApprove() {
            const key = document.getElementById('modalDetail').dataset.currentKey;
            const row = document.querySelector(`tr[data-key="${key}"]`);
            applyVerdict(row, key, 'approved');
            closeDetail();
            showToast('✅', 'Artikel berhasil disetujui!');
        }

        function verdictReject() {
            document.getElementById('mdRejectNote').classList.add('show');
        }

        function closeRejectNote() {
            document.getElementById('mdRejectNote').classList.remove('show');
            document.getElementById('mdRejectText').value = '';
        }

        function submitRejectFromDetail() {
            const note = document.getElementById('mdRejectText').value.trim();
            if (!note) {
                alert('Harap isi alasan penolakan untuk Editor.');
                return;
            }
            const key = document.getElementById('modalDetail').dataset.currentKey;
            const row = document.querySelector(`tr[data-key="${key}"]`);
            DB[key].rejectReason = note;
            applyVerdict(row, key, 'rejected');
            closeDetail();
            showToast('↩️', 'Artikel ditolak & alasan dikirim ke Editor.');
        }

        /* ── APPLY VERDICT KE BARIS TABEL ── */
        function applyVerdict(row, key, status) {
            DB[key].status = status;
            row.dataset.status = status;

            // Update badge status (td ke-6)
            row.cells[5].innerHTML = `<span class="badge ${BADGE_CLASS[status]}">${LABEL[status]}</span>`;

            // Update meta text (td ke-2)
            const metaDiv = row.cells[1].querySelector('.tbl-meta');
            if (metaDiv) {
                metaDiv.textContent = status === 'approved' ?
                    'Disetujui oleh Redaksi' :
                    'Ditolak · ' + (DB[key].rejectReason ? DB[key].rejectReason.substring(0, 50) + '…' : '');
            }

            updateCounts();
            applyFilters();
        }

        /* ── UPDATE COUNTER ── */
        function updateCounts() {
            const rows = document.querySelectorAll('#newsBody tr');
            let cnt = {
                pending: 0,
                approved: 0,
                rejected: 0,
                all: 0
            };
            rows.forEach(r => {
                cnt[r.dataset.status]++;
                cnt.all++;
            });

            // Update tab counts di topbar
            document.getElementById('cnt-all').textContent = cnt.all;
            document.getElementById('cnt-pending').textContent = cnt.pending;
            document.getElementById('cnt-approved').textContent = cnt.approved;
            document.getElementById('cnt-rejected').textContent = cnt.rejected;

            // Update sidebar count
            document.getElementById('pendingCount').textContent = cnt.pending;
        }

        /* ── NOTIF ── */
        function toggleNotif() {
            document.getElementById('notifPanel').classList.toggle('open');
        }
        document.addEventListener('click', e => {
            if (!e.target.closest('.tb-icon') && !e.target.closest('.notif-panel'))
                document.getElementById('notifPanel').classList.remove('open');
        });

        /* ── TOAST ── */
        let toastTimer;

        function showToast(ico, msg) {
            clearTimeout(toastTimer);
            const t = document.getElementById('toast');
            document.getElementById('toastIco').textContent = ico;
            document.getElementById('toastMsg').textContent = msg;
            t.style.display = 'flex';
            t.style.opacity = '1';
            toastTimer = setTimeout(() => {
                t.style.opacity = '0';
                setTimeout(() => {
                    t.style.display = 'none';
                }, 300);
            }, 3000);
        }

        /* ── LOGIN / LOGOUT ── */
        function doLogin() {
            const e = document.getElementById('loginEmail').value;
            const p = document.getElementById('loginPass').value;
            if (!e || !p) {
                alert('Masukkan email dan password!');
                return;
            }
            const lv = document.getElementById('loginView');
            lv.style.transition = 'opacity .4s';
            lv.style.opacity = '0';
            setTimeout(() => {
                lv.style.display = 'none';
            }, 400);
        }

        function doLogout() {
            if (!confirm('Yakin ingin keluar dari panel Redaksi?')) return;
            const lv = document.getElementById('loginView');
            lv.style.display = 'flex';
            lv.style.opacity = '0';
            setTimeout(() => {
                lv.style.transition = 'opacity .4s';
                lv.style.opacity = '1';
            }, 10);
        }

        // Initialize on page load
        updateCounts();
    </script>
@endsection
