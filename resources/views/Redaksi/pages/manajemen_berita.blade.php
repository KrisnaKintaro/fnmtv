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
            </tbody>
        </table>

        <!-- empty state -->
        <div class="empty-state" id="emptyState" style="display:none;">
            <div class="ico">📭</div>
            <p>Tidak ada artikel / Berita ditemukan pada kategori ini.</p>
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
<div class="modal-backdrop" id="modalDetail" style="display:none;">
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

            <!-- KOTAK VALIDASI — hanya muncul jika status pending -->
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

<!-- ── TOAST ── -->
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
        loadDataTabel(); // Load pertama (muncul tulisan memuat)
        pollData(); // Mulai polling data berkala
        updateCounts();
        SmartNotif.init({});
    });

    function pollData() {
        loadDataTabel(true); // Panggil fungsi loadDataTabel yang silent tadi

        // Tunggu 5 detik baru panggil lagi diri sendiri
        setTimeout(pollData, 5000);
    }

    let DB = {};

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

    function filterChanged() {
        currentPage = 1; // Balikin ke halaman 1 tiap kali ngetik search / ganti dropdown
        jalankanFilter();
    }

    /* ── SETUP DATATABLE ENGINE ── */
    const beritaTable = new DataTableEngine({
        tableBody: '#newsBody',
        paginationWrapper: '#paginationControls',
        infoWrapper: '#pagerInfo',
        emptyState: '#emptyState',
        perPage: 5,
        renderRowHTML: function(val) {
            // Mapping penyesuaian (karena ini ntar dari API)
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

            // ── LOGIKA GAMBAR KHUSUS TABEL (Biar sama kayak modal) ──
            let imgUrl = val.foto_thumbnail;
            if (imgUrl && !imgUrl.startsWith('http')) {
                imgUrl = `/uploads/thumbnail/${imgUrl}`; // Path folder asli lu
            }
            const thumbHTML = imgUrl ?
                `<img src="${imgUrl}" style="width:100%;height:100%;object-fit:cover;border-radius:4px;">` :
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

    /* ── TAB & FILTER LOGIC (Versi Bersih) ── */
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
        const searchInput = document.getElementById('searchInput');
        const search = searchInput ? searchInput.value.toLowerCase() : '';

        beritaTable.setFilterAndSearch((val) => {
            // MAPPING FORMAT BARU BIAR GAK UNDEFINED ERROR
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
        // 1. Normalisasi status biar sinkron sama LABEL & BADGE_CLASS
        const capitalizedStatus = status.charAt(0).toUpperCase() + status.slice(1);
        const lowerStatus = status.toLowerCase();

        // 2. Update data di memori lokal (DB)
        if (DB[key]) {
            DB[key].status_berita = capitalizedStatus;
            DB[key].status = lowerStatus; // Jaga-jaga buat logic filter
        }

        // 3. KUNCI UTAMA: Paksa DataTableEngine buat render ulang data yang udah diupdate
        // Kita ambil semua nilai dari DB yang udah berubah tadi
        const dataTerupdate = Object.values(DB);
        beritaTable.loadData(dataTerupdate);

        // 4. Jalankan filter (biar kalau lagi di tab 'Pending', artikelnya langsung ilang pindah tab)
        jalankanFilter();

        // 5. Update angka counter di atas (Semua, Pending, Terbit, Ditolak)
        updateCounts();
    }

    // Fungsi buat ngubah Dummy Object 'DB' jadi Array biar bisa dibaca DataEngine
    function loadDataTabel(isSilent = false) {
        // Cuma tampilin "Memuat" kalau BUKAN update otomatis (isSilent = false)
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

                    // Update dropdown cuma kalau dipanggil pertama kali (biar pilihan user gak keganti pas ngetik)
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

    // Pisahin fungsi render filter biar rapi
    function renderFilterOptions(kategoriSet, penulisSet) {
        let htmlKategori = '<option value="">Semua Kategori</option>';
        kategoriSet.forEach(k => htmlKategori += `<option value="${k}">${k}</option>`);
        document.getElementById('filterKategori').innerHTML = htmlKategori;

        let htmlPenulis = '<option value="">Semua Penulis</option>';
        penulisSet.forEach(p => htmlPenulis += `<option value="${p}">${p}</option>`);
        document.getElementById('filterPenulis').innerHTML = htmlPenulis;
    }

    /* ── FUNGSI MODAL DETAIL & REVIEW (UPDATE API) ── */
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
        const alasanTolak = a.catatan_penolakan || null; // Ambil catatan asli dari API

        document.getElementById('mdTitle').textContent = judul;
        document.getElementById('mdSub').textContent = `${penulis} · ${kategori} · ${tgl}`;

        // ── [BARU] LOGIKA TAMPILKAN CATATAN PENOLAKAN SEBELUMNYA ──
        // Hapus elemen lama kalau ada biar gak duplikat saat pindah-pindah modal
        const oldAlert = document.getElementById('mdPrevRejectAlert');
        if (oldAlert) oldAlert.remove();

        if (alasanTolak) {
            // Buat elemen alert box baru
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
            // Sisipkan di bawah Header (mdSub) dan di atas Gambar (mdThumb)
            document.getElementById('mdThumb').before(alertBox);
        }

        // LOGIKA EMOJI & GAMBAR MODAL
        let imgUrl = a.foto_thumbnail;
        if (imgUrl && !imgUrl.startsWith('http')) {
            imgUrl = `/uploads/thumbnail/${imgUrl}`;
        }

        // Kalau gambar ada, render gambar. Kalau gada, besarin emojinya
        document.getElementById('mdThumb').innerHTML = imgUrl ?
            `<img src="${imgUrl}" style="width:100%;height:100%;object-fit:cover;border-radius:4px;">` :
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

    /* ── FUNGSI: BUKA MODAL BATAL PUBLISH ── */
    function cancelPublish() {
        ModalManager.open('modalConfirmUnpublish');
    }

    /* ── FUNGSI BARU: EKSEKUSI BATAL PUBLISH ── */
    function executeUnpublish() {
        const key = document.getElementById('modalDetail').dataset.currentKey;
        const row = document.querySelector(`tr[data-key="${key}"]`);

        // Ubah status jadi pending
        applyVerdict(row, key, 'pending');

        // Tutup semua modalnya
        ModalManager.close('modalConfirmUnpublish');
        ModalManager.close('modalDetail');

        Toast.show('warning', 'Publikasi ditarik. Artikel kembali ke status Pending.');
    }

    function cancelPublish() {
        // Kita panggil modal custom kita, bukan confirm() web lagi
        ModalManager.open('modalConfirmUnpublish');
    }

    /* ── FUNGSI BARU: EKSEKUSI BATAL PUBLISH ── */
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
                applyVerdict(row, key, 'pending');

                ModalManager.close('modalConfirmUnpublish');
                ModalManager.close('modalDetail');
                Toast.show('warning', 'Publikasi ditarik. Artikel kembali ke status Pending.');
            },
            error: function(xhr) {
                handleApiError(xhr);
            }
        });
    }

    // Fungsi Helper buat nangkep Error API (Biar ga duplikat kodenya)
    function handleApiError(xhr) {
        if (xhr.status === 403) {
            // Error khusus: Berita sudah dibayar Admin
            Toast.show('error', xhr.responseJSON.message || "Aksi ditolak oleh sistem.");
        } else {
            Toast.show('error', "Gagal memperbarui status berita. Cek koneksi!");
        }
        console.error("API Error:", xhr.responseText);
    }

    // 2. Eksekusi Publish
    function executePublish() {
        const key = document.getElementById('modalDetail').dataset.currentKey;
        const row = document.querySelector(`tr[data-key="${key}"]`);

        $.ajax({
            url: `/api/redaksi/verifikasiBerita/${key}`,
            type: 'PATCH', // Sesuai spek lu pakai PATCH
            data: {
                status_berita: 'Published'
            },
            success: function(response) {
                // Update UI lokal
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
            Toast.show('warning', 'Harap isi alasan penolakan untuk Editor.');
            return;
        }

        const key = document.getElementById('modalDetail').dataset.currentKey;
        const row = document.querySelector(`tr[data-key="${key}"]`);

        // ── PROSES TEMBAK API PATCH ──
        $.ajax({
            url: `/api/redaksi/verifikasiBerita/${key}`,
            type: 'PATCH',
            data: {
                status_berita: 'Rejected',
                catatan_penolakan: note
            },
            success: function(response) {
                // Update state di memori JS biar tabel & counter langsung berubah
                DB[key].catatan_penolakan = note;
                applyVerdict(row, key, 'rejected');

                ModalManager.close('modalDetail');
                Toast.show('error', 'Artikel ditolak & alasan dikirim ke Editor.');
            },
            error: function(xhr) {
                // Nangkep error 403 (sudah lunas) atau error lainnya
                handleApiError(xhr);
            }
        });
    }

    /* ── UPDATE COUNTER ANGKA TAB & SIDEBAR ── */
    function updateCounts() {
        let cnt = {
            pending: 0,
            published: 0,
            rejected: 0,
            all: 0
        };

        // Hitung langsung dari object DB, MAPPING KE FORMAT BARU
        Object.values(DB).forEach(val => {
            let s = (val.status_berita || val.status || '').toLowerCase();
            if (s === 'approved') s = 'published'; // Auto map

            if (cnt[s] !== undefined) cnt[s]++;
            cnt.all++;
        });

        // Update tab counts di topbar
        if (document.getElementById('cnt-all')) document.getElementById('cnt-all').textContent = cnt.all;
        if (document.getElementById('cnt-pending')) document.getElementById('cnt-pending').textContent = cnt.pending;
        if (document.getElementById('cnt-published')) document.getElementById('cnt-published').textContent = cnt.published;
        if (document.getElementById('cnt-rejected')) document.getElementById('cnt-rejected').textContent = cnt.rejected;

        // Update sidebar count
        if (document.getElementById('pendingCount')) document.getElementById('pendingCount').textContent = cnt.pending;
    }

    /* ── LOGIN / LOGOUT ── */
    function doLogout() {
        if (!confirm('Yakin ingin keluar dari panel Redaksi?')) return;
        // Arahin ke route logout
        alert("Proses logout jalan...");
    }
</script>
@endsection
