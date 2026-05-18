@extends('Redaksi.redaksi_master')

@section('css')
<style>
    /* ── FIX RESPONSIVE: Scroll Tabel Horizontal ── */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-responsive table {
        min-width: 850px; /* Paksa muncul scroll horizontal di layar sempit */
    }

    /* ── FIX RESPONSIVE: Filter Bar ── */
    .filter-actions {
        margin-left: auto;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    @media screen and (max-width: 768px) {
        .filter-actions {
            margin-left: 0;
            width: 100%;
            justify-content: space-between;
            margin-top: 10px;
        }
        .filter-actions .filter-select {
            flex: 1; /* Biar dropdown penuhi layar di HP dan gampang di-tap */
        }
    }
</style>
@endsection

@section('konten')
<div class="page active">
    <div class="section-title">Monitoring & Validasi Berita</div>

    <div class="filter-bar">
        <div class="tab-pills" id="tabPills">
            <div class="tab-p active" id="tab-all" onclick="showTab('all', this)">
                Semua <span class="tab-cnt cnt-all" id="cnt-all">0</span>
            </div>
            <div class="tab-p" id="tab-pending" onclick="showTab('pending', this)">
                Pending <span class="tab-cnt cnt-pending" id="cnt-pending">0</span>
            </div>
            <div class="tab-p" id="tab-published" onclick="showTab('published', this)">
                Terbit <span class="tab-cnt cnt-published" id="cnt-published">0</span>
            </div>
            <div class="tab-p" id="tab-rejected" onclick="showTab('rejected', this)">
                Ditolak <span class="tab-cnt cnt-rejected" id="cnt-rejected">0</span>
            </div>
        </div>

        <div class="filter-actions">
            <select class="filter-select" id="filterKategori" style="font-size:12px;padding:6px 10px;" onchange="filterChanged()">
                <option value="">Semua Kategori</option>
            </select>
            <select class="filter-select" id="filterPenulis" style="font-size:12px;padding:6px 10px;" onchange="filterChanged()">
                <option value="">Semua Penulis</option>
            </select>
        </div>
    </div>

    <div class="card">
        <div class="card-hd">
            <div class="card-ht" id="cardTitle">Daftar Artikel Masuk dari Editor</div>
            <div class="card-hm" id="tableCount">Memuat data...</div>
        </div>

        <div class="table-responsive">
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
                </tbody>
            </table>
        </div>

        <div class="empty-state" id="emptyState" style="display:none; padding: 40px; text-align: center;">
            <div class="ico" style="font-size: 40px; margin-bottom: 10px;">📭</div>
            <p style="color: var(--muted);">Tidak ada artikel / Berita ditemukan pada kategori ini.</p>
        </div>

        <div class="pager" style="flex-wrap: wrap;">
            <div id="paginationControls" style="display:flex; gap:4px; flex-wrap: wrap;"></div>
            <div class="pg-info" id="pagerInfo">Menampilkan 0 dari 0 artikel</div>
        </div>
    </div>
</div><div class="modal-backdrop" id="modalDetail" style="display:none;">
    <div class="modal">
        <div class="modal-hd">
            <div class="modal-hd-text">
                <div class="modal-title" id="mdTitle">—</div>
                <div class="modal-sub" id="mdSub">—</div>
            </div>
            <div class="modal-close" onclick="ModalManager.close('modalDetail')">✕</div>
        </div>
        <div class="modal-body">
            <div class="modal-thumb" id="mdThumb">📰</div>
            <div class="modal-chips" id="mdChips" style="flex-wrap: wrap;">
                <div class="chip">Penulis: <b id="md-author">—</b></div>
                <div class="chip">Kategori: <b id="md-cat">—</b></div>
                <div class="chip">Dikirim: <b id="md-date">—</b></div>
                <div class="chip">Status: <b id="md-status">—</b></div>
                <div class="chip" style="width: 100%; margin-top:4px;">
                    Slug: <b id="md-slug" style="font-family:'JetBrains Mono',monospace; color:var(--blue);">—</b>
                </div>
            </div>
            <div class="modal-sec">Isi Artikel</div>
            <div class="modal-article-body" id="mdContent"></div>
            <div class="modal-divider"></div>

            <div id="mdVerdictWrap" style="display:none;">
                <div class="verdict-box">
                    <div class="verdict-title">Keputusan Redaksi</div>
                    <div class="verdict-desc">Periksa artikel dengan saksama sebelum memberikan keputusan. Keputusan
                        akan langsung diteruskan ke Editor yang bersangkutan.</div>
                    <div class="verdict-actions">
                        <button class="vbtn vbtn-publish" onclick="ModalManager.open('modalConfirmPublish')">
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

            <div id="mdResultWrap" style="display:none; margin-top:20px;">
                <div class="info-result-box" id="mdResultBox" style="display:flex; gap:12px; align-items:flex-start; padding:16px; border-radius:8px; border:1px solid #eee; background:#fafafa;">
                    <div class="ico" id="mdResultIco" style="font-size:24px; line-height:1;"></div>
                    <div class="txt" style="flex:1;">
                        <div id="mdResultTitle" style="font-weight:bold; font-size:16px; color:var(--text); margin-bottom:6px;"></div>
                        <div id="mdResultDesc" style="font-size:13.5px; color:var(--muted); line-height:1.5;"></div>

                        <button id="btnUnpublish" class="btn btn-outline btn-sm" style="margin-top:12px; display:none;" onclick="cancelPublish()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Batalkan Publish
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="modalConfirmUnpublish" style="display:none; z-index: 600;">
    <div class="modal" style="max-width: 400px; text-align: center; padding: 30px; position: relative;">
        <div style="font-size: 40px; margin-bottom: 10px;">⚠️</div>
        <h3 style="font-family: 'Merriweather', serif; margin-bottom: 10px;">Batalkan Publikasi?</h3>
        <p style="font-size: 13px; color: var(--muted); margin-bottom: 24px;">
            Artikel ini akan ditarik dari portal publik dan dikembalikan ke status <b>Pending</b>. Yakin ingin melanjutkan?
        </p>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-outline" style="flex:1; justify-content:center;" onclick="ModalManager.close('modalConfirmUnpublish')">Kembali</button>
            <button class="btn btn-red" style="flex:1; justify-content:center;" onclick="executeUnpublish()">Ya, Tarik Artikel</button>
        </div>
    </div>
</div>

<div id="toast" style="display:none;opacity:1;">
    <span id="toastIco"></span>
    <span id="toastMsg"></span>
</div>

<div class="modal-backdrop" id="modalConfirmPublish" style="display:none; z-index: 600;">
    <div class="modal" style="max-width: 400px; text-align: center; padding: 30px;">
        <div style="font-size: 40px; margin-bottom: 10px;">🚀</div>
        <h3 style="font-family: 'Merriweather', serif; margin-bottom: 10px;">Yakin Publish Artikel?</h3>
        <p style="font-size: 13px; color: var(--muted); margin-bottom: 24px;">Artikel akan langsung tayang dan dapat dibaca oleh publik di portal berita.</p>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-outline" style="flex:1; justify-content:center;" onclick="ModalManager.close('modalConfirmPublish')">Batal</button>
            <button class="btn" style="flex:1; justify-content:center; background: var(--blue); color: white;" onclick="executePublish()">Ya, Publish</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        loadDataTabel();
        pollData();
        updateCounts();

        SmartNotif.init({
            apiUrl: '/api/redaksi/getNotifikasi',
            renderItemHTML: function(item) {
                return `
                    <div class="notif-item" onclick="bukaNotifReview(${item.id})" style="cursor:pointer; padding:12px; border-bottom:1px solid #eee; display:flex; gap:12px; background: #fffaf0; transition: background 0.2s;">
                        <div style="font-size:20px;">${item.icon}</div>
                        <div class="notif-txt">
                            <div style="font-weight:700; font-size:13px; color:var(--text);">${item.title}</div>
                            <div style="font-size:12px; color:#555; line-height:1.4;">${item.message}</div>
                            <div style="font-size:10px; color:#999; margin-top:4px;">${item.time}</div>
                        </div>
                    </div>
                `;
            }
        });
    });

    function bukaNotifReview(id) {
        if (DB[id]) {
            openModal(id);
        } else {
            Toast.show('info', 'Sedang memuat data artikel, tunggu sebentar...');
            loadDataTabel(true);
            setTimeout(() => {
                if(DB[id]) openModal(id);
            }, 1000);
        }
    }

    // Reload data tiap 5 detik
    // function pollData() {
    //     loadDataTabel(true);
    //     setTimeout(pollData, 5000);
    // }

    let DB = {};

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

    function filterChanged() {
        currentPage = 1;
        jalankanFilter();
    }

    const beritaTable = new DataTableEngine({
        tableBody: '#newsBody',
        paginationWrapper: '#paginationControls',
        infoWrapper: '#pagerInfo',
        emptyState: '#emptyState',
        perPage: 5,
        renderRowHTML: function(val) {
            const status = (val.status_berita || val.status).toLowerCase();
            const judul = val.judul_berita || val.title;
            const penulis = val.user ? val.user.username : (val.author || 'Unknown');
            const kategori = val.kategori ? val.kategori.nama_kategori : (val.cat || 'Uncategorized');
            const rawDate = val.created_at || val.date || '';
            const tanggal = rawDate ? new Date(rawDate).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            }) : '-';
            const alasanTolak = val.catatan_penolakan || val.rejectReason;

            let metaText = '';
            if (status === 'pending') metaText = 'Menunggu keputusan Redaksi';
            else if (status === 'published') metaText = `Disetujui oleh Redaksi · ${tanggal}`;
            else metaText = `Ditolak · ${alasanTolak ? alasanTolak.substring(0, 50) + '…' : 'Sumber tidak terverifikasi'}`;

            // 🔥 SUNTIK LAZY LOADING DI SINI 🔥
            let imgUrl = val.foto_thumbnail;
            if (imgUrl && !imgUrl.startsWith('http')) {
                imgUrl = `/uploads/thumbnail/${imgUrl}`;
            }
            const thumbHTML = imgUrl ?
                `<img src="${imgUrl}" loading="lazy" onerror="this.onerror=null;this.src='https://placehold.co/100x100/eeeeee/999999?text=No+Image';" style="width:100%;height:100%;object-fit:cover;border-radius:4px;">` :
                `<div style="font-size:24px; display:flex; align-items:center; justify-content:center; width:100%; height:100%;">${val.emoji || '📰'}</div>`;

            return `
            <tr data-key="${val.key || val.id}">
                <td><div class="tbl-img">${thumbHTML}</div></td>
                <td>
                    <div class="tbl-title">${judul}</div>
                    <div class="tbl-meta">${metaText}</div>
                </td>
                <td><span class="badge b-cat">${kategori}</span></td>
                <td style="font-size:12px;color:var(--muted);">${penulis}</td>
                <td style="font-size:12px;color:var(--muted);">${tanggal}</td>
                <td><span class="badge ${BADGE_CLASS[status]}">${LABEL[status] || status}</span></td>
                <td>
                    <div class="act-btns">
                        <div class="ico-btn" title="${status === 'pending' ? 'Lihat & Validasi' : 'Lihat Detail'}" onclick="openModal('${val.key || val.id}')">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                </td>
            </tr>`;
        }
    });

    function showTab(status, el) {
        currentTab = status;
        const [title, crumb] = TITLES[status];
        document.getElementById('tbTitle').textContent = title;
        document.getElementById('tbCrumb').textContent = crumb;
        document.getElementById('cardTitle').textContent = CARD_TITLES[status];

        document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
        if (el) el.classList.add('active');

        jalankanFilter();
    }

    function jalankanFilter() {
        const cat = document.getElementById('filterKategori').value;
        const author = document.getElementById('filterPenulis').value;

        // Cek input dari Search Desktop maupun Mobile
        const desktopSearch = document.getElementById('searchInput');
        const mobileSearch = document.querySelector('.mobile-search-input');
        let search = '';
        if (desktopSearch && desktopSearch.value) search = desktopSearch.value.toLowerCase();
        else if (mobileSearch && mobileSearch.value) search = mobileSearch.value.toLowerCase();

        beritaTable.setFilterAndSearch((val) => {
            const statusBaris = (val.status_berita || val.status || '').toLowerCase();
            const kategoriBaris = val.kategori ? val.kategori.nama_kategori : (val.cat || '');
            const penulisBaris = val.user ? val.user.username : (val.author || '');
            const judulBaris = (val.judul_berita || val.title || '').toLowerCase();

            const matchStatus = currentTab === 'all' || statusBaris === currentTab;
            const matchCat = !cat || kategoriBaris === cat;
            const matchAuthor = !author || penulisBaris === author;
            const matchSearch = !search || judulBaris.includes(search) || penulisBaris.toLowerCase().includes(search);

            return matchStatus && matchCat && matchAuthor && matchSearch;
        });
    }

    function applyVerdict(row, key, status) {
        const capitalizedStatus = status.charAt(0).toUpperCase() + status.slice(1);
        const lowerStatus = status.toLowerCase();

        if (DB[key]) {
            DB[key].status_berita = capitalizedStatus;
            DB[key].status = lowerStatus;
        }

        const dataTerupdate = Object.values(DB);
        beritaTable.loadData(dataTerupdate);
        jalankanFilter();
        updateCounts();
    }

    function loadDataTabel(isSilent = false) {
        if (!isSilent) {
            document.getElementById('newsBody').innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 20px;">Memuat data dari server...</td></tr>';
        }

        $.ajax({
            url: '/api/redaksi/getBeritaMasuk',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    DB = {};
                    let dataArray = [];
                    let listKategori = new Set();
                    let listPenulis = new Set();

                    response.data.forEach(item => {
                        DB[item.id] = item;
                        dataArray.push(item);
                        if (item.kategori && item.kategori.nama_kategori) listKategori.add(item.kategori.nama_kategori);
                        if (item.user && item.user.username) listPenulis.add(item.user.username);
                    });

                    if (!isSilent) {
                        renderFilterOptions(listKategori, listPenulis);
                    }

                    beritaTable.loadData(dataArray);
                    jalankanFilter();
                    updateCounts();
                }
            },
            error: function(xhr) {
                if (!isSilent) Toast.show('error', 'Gagal sinkronisasi data.');
            }
        });
    }

    function renderFilterOptions(kategoriSet, penulisSet) {
        let htmlKategori = '<option value="">Semua Kategori</option>';
        kategoriSet.forEach(k => htmlKategori += `<option value="${k}">${k}</option>`);
        document.getElementById('filterKategori').innerHTML = htmlKategori;

        let htmlPenulis = '<option value="">Semua Penulis</option>';
        penulisSet.forEach(p => htmlPenulis += `<option value="${p}">${p}</option>`);
        document.getElementById('filterPenulis').innerHTML = htmlPenulis;
    }

    function openModal(key) {
        const a = DB[key];

        const judul = a.judul_berita;
        const penulis = a.user ? a.user.username : 'Unknown';
        const kategori = a.kategori ? a.kategori.nama_kategori : 'Uncategorized';
        const slug = a.slug;
        const konten = a.isi_berita;
        const status = (a.status_berita || a.status).toLowerCase();
        const rawTgl = a.created_at || a.date || '';
        const tgl = rawTgl ? new Date(rawTgl).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        }) : 'Baru Saja';
        const alasanTolak = a.catatan_penolakan || null;

        document.getElementById('mdTitle').textContent = judul;
        document.getElementById('mdSub').textContent = `${penulis} · ${kategori} · ${tgl}`;

        const oldAlert = document.getElementById('mdPrevRejectAlert');
        if (oldAlert) oldAlert.remove();

        if (alasanTolak) {
            const alertBox = document.createElement('div');
            alertBox.id = 'mdPrevRejectAlert';
            alertBox.style = `
                background: #fff5f5;
                border: 1px solid #feb2b2;
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-size: 13px;
                color: #c53030;
                display: flex;
                gap: 12px;
                align-items: flex-start;
            `;
            alertBox.innerHTML = `
                <div style="font-size: 18px;">⚠️</div>
                <div>
                    <strong style="display:block; margin-bottom:2px;">Catatan Penolakan Sebelumnya:</strong>
                    <span style="color: var(--text); line-height: 1.5;">${alasanTolak}</span>
                </div>
            `;
            document.getElementById('mdThumb').before(alertBox);
        }

        let imgUrl = a.foto_thumbnail;
        if (imgUrl && !imgUrl.startsWith('http')) {
            imgUrl = `/uploads/thumbnail/${imgUrl}`;
        }

        // 🔥 LAZY LOADING UNTUK GAMBAR DI MODAL JUGA 🔥
        document.getElementById('mdThumb').innerHTML = imgUrl ?
            `<img src="${imgUrl}" loading="lazy" style="width:100%;height:100%;object-fit:cover;border-radius:4px;">` :
            `<div style="font-size:36px; display:flex; align-items:center; justify-content:center; height:100%; width:100%;">${a.emoji || '📰'}</div>`;

        document.getElementById('md-author').textContent = penulis;
        document.getElementById('md-cat').textContent = kategori;
        document.getElementById('md-date').textContent = tgl;
        document.getElementById('md-slug').textContent = slug;
        document.getElementById('md-status').textContent = LABEL[status] || status;
        document.getElementById('mdContent').innerHTML = konten;

        const vw = document.getElementById('mdVerdictWrap');
        const rw = document.getElementById('mdResultWrap');
        const rb = document.getElementById('mdResultBox');
        const btnUnpublish = document.getElementById('btnUnpublish');

        document.getElementById('mdRejectNote').classList.remove('show');
        document.getElementById('mdRejectText').value = '';

        if (status === 'pending') {
            vw.style.display = 'block';
            rw.style.display = 'none';
        } else {
            vw.style.display = 'none';
            rw.style.display = 'block';
            rb.className = 'info-result-box ' + status;

            if (status === 'published') {
                document.getElementById('mdResultIco').textContent = '✅';
                document.getElementById('mdResultTitle').textContent = 'Artikel Telah Diterbitkan';
                document.getElementById('mdResultDesc').innerHTML = 'Artikel ini telah disetujui dan tayang ke publik.';
                btnUnpublish.style.display = 'inline-flex';
            } else {
                document.getElementById('mdResultIco').textContent = '❌';
                document.getElementById('mdResultTitle').textContent = 'Artikel Ditolak';
                document.getElementById('mdResultDesc').innerHTML = '<strong style="color:var(--text);">Alasan:</strong> ' + (alasanTolak || 'Ditolak oleh Redaksi.');
                btnUnpublish.style.display = 'none';
            }
        }

        document.getElementById('modalDetail').dataset.currentKey = key;
        ModalManager.open('modalDetail');
    }

    function cancelPublish() {
        ModalManager.open('modalConfirmUnpublish');
    }

    function executeUnpublish() {
        const key = document.getElementById('modalDetail').dataset.currentKey;
        const row = document.querySelector(`tr[data-key="${key}"]`);

        $.ajax({
            url: `/api/redaksi/verifikasiBerita/${key}`,
            type: 'PATCH',
            data: {
                status_berita: 'Pending'
            },
            success: function(response) {
                applyVerdict(row, key, 'Pending');
                ModalManager.close('modalConfirmUnpublish');
                ModalManager.close('modalDetail');
                Toast.show('warning', 'Publikasi ditarik. Artikel kembali ke status Pending.');
            },
            error: function(xhr) {
                handleApiError(xhr);
            }
        });
    }

    function handleApiError(xhr) {
        if (xhr.status === 403) {
            Toast.show('error', xhr.responseJSON.message || "Aksi ditolak oleh sistem.");
        } else {
            Toast.show('error', "Gagal memperbarui status berita. Cek koneksi!");
        }
        console.error("API Error:", xhr.responseText);
    }

    function executePublish() {
        const key = document.getElementById('modalDetail').dataset.currentKey;
        const row = document.querySelector(`tr[data-key="${key}"]`);

        $.ajax({
            url: `/api/redaksi/verifikasiBerita/${key}`,
            type: 'PATCH',
            data: {
                status_berita: 'Published'
            },
            success: function(response) {
                applyVerdict(row, key, 'published');
                ModalManager.close('modalConfirmPublish');
                ModalManager.close('modalDetail');
                Toast.show('success', response.message || 'Artikel berhasil diterbitkan!');
            },
            error: function(xhr) {
                handleApiError(xhr);
            }
        });
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
            Toast.show('warning', 'Harap isi alasan penolakan untuk Editor.');
            return;
        }

        const key = document.getElementById('modalDetail').dataset.currentKey;
        const row = document.querySelector(`tr[data-key="${key}"]`);

        $.ajax({
            url: `/api/redaksi/verifikasiBerita/${key}`,
            type: 'PATCH',
            data: {
                status_berita: 'Rejected',
                catatan_penolakan: note
            },
            success: function(response) {
                DB[key].catatan_penolakan = note;
                applyVerdict(row, key, 'rejected');

                ModalManager.close('modalDetail');
                Toast.show('error', 'Artikel ditolak & alasan dikirim ke Editor.');
            },
            error: function(xhr) {
                handleApiError(xhr);
            }
        });
    }

    function updateCounts() {
        let cnt = {
            pending: 0,
            published: 0,
            rejected: 0,
            all: 0
        };

        Object.values(DB).forEach(val => {
            let s = (val.status_berita || val.status || '').toLowerCase();
            if (s === 'approved') s = 'published';

            if (cnt[s] !== undefined) cnt[s]++;
            cnt.all++;
        });

        if (document.getElementById('cnt-all')) document.getElementById('cnt-all').textContent = cnt.all;
        if (document.getElementById('cnt-pending')) document.getElementById('cnt-pending').textContent = cnt.pending;
        if (document.getElementById('cnt-published')) document.getElementById('cnt-published').textContent = cnt.published;
        if (document.getElementById('cnt-rejected')) document.getElementById('cnt-rejected').textContent = cnt.rejected;

        if (document.getElementById('pendingCount')) document.getElementById('pendingCount').textContent = cnt.pending;
    }
</script>
@endsection
