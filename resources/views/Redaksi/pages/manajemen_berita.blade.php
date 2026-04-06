@extends('Redaksi.redaksi_master')

@section('css')
@endsection

@section('konten')
<!-- ══ HALAMAN UTAMA ══ -->
<div class="page active">
    <div class="section-title">Monitoring & Validasi Berita</div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="tab-pills" id="tabPills">
            <div class="tab-p active" id="tab-all" onclick="showTab('all', this)">
                Semua <span class="tab-cnt cnt-all" id="cnt-all">9</span>
            </div>
            <div class="tab-p" id="tab-pending" onclick="showTab('pending', this)">
                Pending <span class="tab-cnt cnt-pending" id="cnt-pending">5</span>
            </div>
            <div class="tab-p" id="tab-published" onclick="showTab('published', this)">
                Terbit <span class="tab-cnt cnt-published" id="cnt-published">0</span>
            </div>
            <div class="tab-p" id="tab-rejected" onclick="showTab('rejected', this)">
                Ditolak <span class="tab-cnt cnt-rejected" id="cnt-rejected">1</span>
            </div>
        </div>
        <div style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;">
            <select class="filter-select" id="filterKategori" style="font-size:12px;padding:6px 10px;"
                onchange="filterChanged()">
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
                onchange="filterChanged()">
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
                <tr data-status="published" data-key="kebijakan" data-cat="Politik" data-author="Budi Santoso">
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
                    <td><span class="badge b-published">Disetujui</span></td>
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

                <tr data-status="published" data-key="garuda" data-cat="Olahraga" data-author="Sari Maharani">
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
                    <td><span class="badge b-published">Disetujui</span></td>
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

                <tr data-status="published" data-key="film" data-cat="Hiburan" data-author="Sari Maharani">
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
                    <td><span class="badge b-published">Disetujui</span></td>
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
            <div id="paginationControls" style="display:flex; gap:4px;">
                </div>
            <div class="pg-info" id="pagerInfo">Menampilkan 0 dari 0 artikel</div>
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
                        <button class="vbtn vbtn-publish" onclick="confirmPublishAction()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            Setujui & Publish
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
            <div id="mdResultWrap" style="display:none; margin-top:20px;">
                <div class="info-result-box" id="mdResultBox" style="display:flex; gap:12px; align-items:flex-start; padding:16px; border-radius:8px; border:1px solid #eee; background:#fafafa;">
                    <div class="ico" id="mdResultIco" style="font-size:24px; line-height:1;"></div>
                    <div class="txt" style="flex:1;">
                        <div id="mdResultTitle" style="font-weight:bold; font-size:16px; color:var(--text); margin-bottom:6px;"></div>
                        <div id="mdResultDesc" style="font-size:13.5px; color:var(--muted); line-height:1.5;"></div>
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

<div class="modal-backdrop" id="modalConfirmPublish" style="z-index: 600;">
    <div class="modal" style="max-width: 400px; text-align: center; padding: 30px;">
        <div style="font-size: 40px; margin-bottom: 10px;">🚀</div>
        <h3 style="font-family: 'Merriweather', serif; margin-bottom: 10px;">Yakin Publish Artikel?</h3>
        <p style="font-size: 13px; color: var(--muted); margin-bottom: 24px;">Artikel akan langsung tayang dan dapat dibaca oleh publik di portal berita.</p>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-outline" style="flex:1; justify-content:center;" onclick="closeConfirmPublish()">Batal</button>
            <button class="btn" style="flex:1; justify-content:center; background: var(--blue); color: white;" onclick="executePublish()">Ya, Publish</button>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
        /* ══════════════════════════════════════
           DATABASE ARTIKEL (simulasi Dummy)
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
    <p>Pemerintah melalui Kementerian Perdagangan mengumumkan kebijakan buka impor beras sebanyak 500.000 ton untuk menstabilkan pasokan dalam negeri.</p>`
        },
        bpjs: {
            title: 'BPJS Kesehatan Tanggung Biaya Operasi Jantung Terbaru',
            author: 'Arif Wibowo',
            cat: 'Kesehatan',
            date: '25 Mar 2026',
            status: 'pending',
            emoji: '🏥',
            content: `<p>BPJS Kesehatan resmi mengumumkan perluasan cakupan layanan dengan menanggung biaya prosedur operasi jantung terbaru, termasuk pemasangan ring koroner generasi terbaru dan operasi bypass arteri.</p>`
        },
        asean: {
            title: 'KTT ASEAN 2026 Bahas Krisis Pangan dan Energi Regional',
            author: 'Budi Santoso',
            cat: 'Internasional',
            date: '24 Mar 2026',
            status: 'pending',
            emoji: '🌐',
            content: `<p>Konferensi Tingkat Tinggi (KTT) ASEAN 2026 yang berlangsung di Jakarta resmi dibuka pada Senin (23/3). Para pemimpin dari 10 negara anggota ASEAN berkumpul untuk membahas isu-isu krusial.</p>`
        },
        brin: {
            title: 'Peneliti BRIN Temukan Spesies Baru di Hutan Papua',
            author: 'Dewi Puspita',
            cat: 'Sains',
            date: '23 Mar 2026',
            status: 'pending',
            emoji: '🔬',
            content: `<p>Tim peneliti dari Badan Riset dan Inovasi Nasional (BRIN) mengumumkan penemuan spesies baru amfibi di kawasan hutan hujan pegunungan Papua Tengah.</p>`
        },
        lrt: {
            title: 'Proyek LRT Jabodebek Fase 2 Mulai Konstruksi April 2026',
            author: 'Arif Wibowo',
            cat: 'Infrastruktur',
            date: '22 Mar 2026',
            status: 'pending',
            emoji: '🏙️',
            content: `<p>Kementerian Perhubungan resmi mengumumkan dimulainya konstruksi LRT Jabodebek Fase 2 yang akan memperluas jaringan ke wilayah Bogor dan Tangerang Selatan.</p>`
        },
        kebijakan: {
            title: 'Pemerintah Umumkan Kebijakan Ekonomi Baru untuk 2026',
            author: 'Budi Santoso',
            cat: 'Politik',
            date: '15 Mar 2026',
            status: 'published', // Berubah dari approved
            emoji: '🏛️',
            content: `<p>Pemerintah Indonesia secara resmi meluncurkan paket kebijakan ekonomi baru untuk tahun 2026 yang mencakup 12 langkah strategis.</p>`
        },
        garuda: {
            title: 'Timnas Garuda Menang Telak 3-0 Lawan Vietnam',
            author: 'Sari Maharani',
            cat: 'Olahraga',
            date: '14 Mar 2026',
            status: 'published', // Berubah dari approved
            emoji: '⚽',
            content: `<p>Timnas Indonesia menunjukkan performa gemilang dengan mengalahkan Vietnam 3-0 dalam laga kualifikasi Piala Dunia 2026 zona Asia di Stadion Utama Gelora Bung Karno.</p>`
        },
        film: {
            title: 'Film Indonesia Raih Penghargaan di Festival Berlin',
            author: 'Sari Maharani',
            cat: 'Hiburan',
            date: '12 Mar 2026',
            status: 'published', // Berubah dari approved
            emoji: '🎬',
            content: `<p>Film Indonesia berjudul "Tanah di Ujung Dunia" berhasil meraih penghargaan Silver Bear untuk kategori Best Director di Berlinale 2026.</p>`
        },
        hoaks: {
            title: 'Aplikasi Medsos Baru Diklaim Lebih Privat dari WhatsApp',
            author: 'Dewi Puspita',
            cat: 'Teknologi',
            date: '10 Mar 2026',
            status: 'rejected',
            emoji: '📱',
            rejectReason: 'Sumber data tidak terverifikasi dan klaim teknis dalam artikel tidak didukung oleh bukti ilmiah yang cukup.',
            content: `<p>Sebuah aplikasi media sosial baru bernama "PrivaChat" yang dikembangkan oleh startup lokal mengklaim memiliki tingkat privasi lebih tinggi dibandingkan WhatsApp.</p>`
        }
    };


    /* ── TAMBAHAN VARIABEL PAGINATION ── */
    let currentPage = 1;
    const perPage = 5;

    /* ── KONSTANTA & PENGATURAN UI ── */
    const BADGE_CLASS = {
        pending: 'b-pending',
        published: 'b-published',
        rejected: 'b-rejected'
    };
    const LABEL = {
        pending: 'Pending',
        published: 'Terbit',
        rejected: 'Ditolak'
    };
    const TITLES = {
        all: ['Manajemen Berita', 'Redaksi / Manajemen Berita'],
        pending: ['Manajemen Berita', 'Redaksi / Manajemen Berita'],
        published: ['Manajemen Berita', 'Redaksi / Manajemen Berita'],
        rejected: ['Manajemen Berita', 'Redaksi / Manajemen Berita']
    };
    const CARD_TITLES = {
        all: 'Daftar Artikel Masuk dari Editor',
        pending: 'Artikel Menunggu Keputusan',
        published: 'Artikel Telah Diterbitkan',
        rejected: 'Artikel Telah Ditolak'
    };

    let currentTab = 'all';

    /* ── TAB / FILTER TABEL ── */
    function showTab(status) {
        currentTab = status;
        const [title, crumb] = TITLES[status];
        document.getElementById('tbTitle').textContent = title;
        document.getElementById('tbCrumb').textContent = crumb;
        document.getElementById('cardTitle').textContent = CARD_TITLES[status];

        document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
        const tabEl = document.getElementById('tab-' + status);
        if (tabEl) tabEl.classList.add('active');

        currentPage = 1; // Balikin ke halaman 1 kalau ganti tab
        applyFilters();
    }

    function filterChanged() {
        currentPage = 1; // Balikin ke halaman 1 tiap kali ngetik search / ganti dropdown
        applyFilters();
    }

    function applyFilters() {
        const cat = document.getElementById('filterKategori').value;
        const author = document.getElementById('filterPenulis').value;
        const search = document.getElementById('searchInput').value.toLowerCase();

        // Ubah NodeList jadi Array biar gampang diproses
        const rows = Array.from(document.querySelectorAll('#newsBody tr'));
        let filteredRows = []; // Penampung baris yang lolos filter

        // 1. Saring Data Dulu
        rows.forEach(r => {
            let rStatus = r.dataset.status;
            if (rStatus === 'approved') rStatus = 'published';

            const matchStatus = currentTab === 'all' || rStatus === currentTab;
            const matchCat = !cat || r.dataset.cat === cat;
            const matchAuthor = !author || r.dataset.author === author;
            const titleText = r.querySelector('.tbl-title')?.textContent.toLowerCase() || '';
            const matchSearch = !search || titleText.includes(search) || r.dataset.author.toLowerCase().includes(search);

            if (matchStatus && matchCat && matchAuthor && matchSearch) {
                filteredRows.push(r);
            } else {
                r.style.display = 'none'; // Sembunyikan yang gak cocok
            }
        });

        // 2. Hitung Pagination
        const totalItems = filteredRows.length;
        const totalPages = Math.ceil(totalItems / perPage);

        // Pengaman: kalau lagi di page 2 tapi datanya sisa 1 page, balikin ke page terakhir
        if (currentPage > totalPages) currentPage = totalPages || 1;

        const startIdx = (currentPage - 1) * perPage;
        const endIdx = startIdx + perPage;

        // 3. Tampilkan/Sembunyikan berdasarkan Index Pagination
        filteredRows.forEach((r, index) => {
            if (index >= startIdx && index < endIdx) {
                r.style.display = ''; // Tampilkan karena masuk range halaman
            } else {
                r.style.display = 'none'; // Sembunyikan karena di halaman lain
            }
        });

        // 4. Update Teks & Tombol
        const startDisplay = totalItems === 0 ? 0 : startIdx + 1;
        const endDisplay = Math.min(endIdx, totalItems);

        document.getElementById('tableCount').textContent = `Menampilkan ${totalItems} artikel`;
        document.getElementById('pagerInfo').textContent = `Menampilkan ${startDisplay}-${endDisplay} dari ${totalItems} artikel`;
        document.getElementById('emptyState').style.display = totalItems === 0 ? 'block' : 'none';

        renderPaginationControls(totalPages);
    }

    function renderPaginationControls(totalPages) {
        let html = '';
        if (totalPages > 0) {
            for (let i = 1; i <= totalPages; i++) {
                html += `<div class="pg-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</div>`;
            }
        }
        document.getElementById('paginationControls').innerHTML = html;
    }

    function changePage(page) {
        currentPage = page;
        applyFilters();
    }

    function doSearch() {
        applyFilters();
    }

    /* ── MODAL DETAIL & REVIEW ── */
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

        // Reset box penolakan
        document.getElementById('mdRejectNote').classList.remove('show');
        document.getElementById('mdRejectText').value = '';

        if (a.status === 'pending') {
            vw.style.display = 'block';
            rw.style.display = 'none';
        } else {
            vw.style.display = 'none';
            rw.style.display = 'block';
            rb.className = 'info-result-box ' + a.status;

            if (a.status === 'published') {
                document.getElementById('mdResultIco').textContent = '✅';
                document.getElementById('mdResultTitle').textContent = 'Artikel Telah Diterbitkan';
                document.getElementById('mdResultDesc').innerHTML = 'Artikel ini telah disetujui dan tayang ke publik.';
            } else {
                document.getElementById('mdResultIco').textContent = '❌';
                document.getElementById('mdResultTitle').textContent = 'Artikel Ditolak';
                // Tambahin label Alasan biar rapi
                document.getElementById('mdResultDesc').innerHTML = '<strong style="color:var(--text);">Alasan:</strong> ' + (a.rejectReason || 'Ditolak oleh Redaksi.');
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

    /* ── VERDICT PUBLISH & REJECT ── */

    // 1. Popup Pengaman Publish
    function confirmPublishAction() {
        document.getElementById('modalConfirmPublish').classList.add('open');
    }

    function closeConfirmPublish() {
        document.getElementById('modalConfirmPublish').classList.remove('open');
    }

    // 2. Eksekusi Publish
    function executePublish() {
        const key = document.getElementById('modalDetail').dataset.currentKey;
        const row = document.querySelector(`tr[data-key="${key}"]`);

        applyVerdict(row, key, 'published');

        closeConfirmPublish();
        closeDetail();
        showToast('🚀', 'Artikel berhasil di-publish ke portal!');
    }

    // 3. Eksekusi Reject
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

    /* ── APPLY VERDICT KE BARIS TABEL HTML ── */
    function applyVerdict(row, key, status) {
        DB[key].status = status;
        row.dataset.status = status;

        // Update badge status di kolom tabel
        row.cells[5].innerHTML = `<span class="badge ${BADGE_CLASS[status]}">${LABEL[status]}</span>`;

        // Update meta text di bawah judul tabel
        const metaDiv = row.cells[1].querySelector('.tbl-meta');
        if (metaDiv) {
            metaDiv.textContent = status === 'published' ?
                'Disetujui dan Tayang (Published)' :
                'Ditolak · ' + (DB[key].rejectReason ? DB[key].rejectReason.substring(0, 50) + '…' : '');
        }

        updateCounts();
        applyFilters();
    }

    /* ── UPDATE COUNTER ANGKA TAB & SIDEBAR ── */
    function updateCounts() {
        const rows = document.querySelectorAll('#newsBody tr');
        let cnt = {
            pending: 0,
            published: 0,
            rejected: 0,
            all: 0
        };

        rows.forEach(r => {
            let s = r.dataset.status;
            if (s === 'approved') s = 'published'; // Auto map buat jaga-jaga HTML lama

            if (cnt[s] !== undefined) cnt[s]++;
            cnt.all++;
        });

        // Update tab counts di topbar
        document.getElementById('cnt-all').textContent = cnt.all;
        document.getElementById('cnt-pending').textContent = cnt.pending;
        document.getElementById('cnt-published').textContent = cnt.published;
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
    function doLogout() {
        if (!confirm('Yakin ingin keluar dari panel Redaksi?')) return;
        // Arahin ke route logout
        alert("Proses logout jalan...");
    }

    // Initialize on page load
    $(document).ready(function() {
        updateCounts();
    });
</script>
@endsection
