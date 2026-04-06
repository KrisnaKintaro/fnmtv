@extends('redaksi.redaksi_master') @section('css')
    <style>
        .search-box {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 6px 12px;
            gap: 8px;
        }

        .search-box input {
            border: none;
            outline: none;
            font-size: 13px;
            width: 200px;
        }

        textarea.reject-notes {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            font-size: 13px;
            min-height: 100px;
            resize: vertical;
            margin-bottom: 16px;
            outline: none;
        }

        textarea.reject-notes:focus {
            border-color: var(--blue);
        }

        /* ── STYLE BARU MODAL REVIEW (SENSITIVE) ── */
        #modalViewBerita .modal-content {
            max-width: 950px;
            /* Bikin rada lebar dikit */
            padding: 0;
            /* Hapus padding global */
            overflow: hidden;
            /* Biar background header/footer gak bocor */
            display: flex;
            flex-direction: column;
            max-height: 90vh;
            /* Jaga tinggi modal biar gak off-screen */
        }

        /* 1. Bagian Atas (Header) - Abu-abu Muda */
        .view-header-panel {
            background: #f9fafb;
            /* Warna abu abu super muda */
            padding: 30px 40px;
            border-bottom: 1px solid #eee;
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .view-thumb {
            width: 160px;
            height: 100px;
            background: #e5e7eb;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid #e0e0e0;
        }

        .view-meta-info {
            flex: 1;
        }

        .view-meta-judul {
            font-family: 'Merriweather', serif;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 10px;
            color: var(--black);
        }

        .view-meta-sub {
            font-size: 13px;
            color: var(--muted);
            display: flex;
            gap: 16px;
            align-items: center;
        }

        /* 2. Bagian Tengah (Isi Berita) - Putih Murni + Scroll */
        .view-body-panel {
            background: #ffffff;
            /* Putih bersih buat baca */
            padding: 40px;
            flex: 1;
            /* Ambil sisa space */
            overflow-y: auto;
            /* Scroll di sini */
            font-size: 15px;
            line-height: 1.8;
            color: #333;
        }

        /* Styling HTML Content di dalam body */
        .view-body-panel p {
            margin-bottom: 1.5em;
        }

        .view-body-panel h2,
        .view-body-panel h3 {
            font-family: 'Merriweather', serif;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            color: var(--black);
        }

        .view-body-panel blockquote {
            border-left: 4px solid var(--blue);
            padding-left: 20px;
            font-style: italic;
            color: #555;
            margin: 25px 0;
        }

        /* 3. Bagian Bawah (Validasi + Tombol) - Panel Terpisah */
        .view-footer-panel {
            background: #fafafa;
            border-top: 1px solid #eee;
            padding: 0;
            /* Padding diatur di child */
        }

        /* Section Poin Validasi (Biru Muda Callout) */
        .validation-callout {
            background: #eef2ff;
            /* Biru muda pucat */
            padding: 20px 40px;
            border-bottom: 1px solid #e0e7ff;
        }

        .validation-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--blue);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .validation-list {
            font-size: 13px;
            color: #444;
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* Bikin 2 kolom biar ringkas */
            gap: 8px 20px;
        }

        .validation-list li {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Section Tombol Tutup (Paling Bawah) */
        .footer-action-bar {
            padding: 15px 40px;
            display: flex;
            justify-content: flex-end;
        }
    </style>
@endsection

@section('konten')
    <div id="page-validasi-berita" class="page active">
        <div class="section-title">Monitoring & Validasi Berita</div>

        <div class="filter-bar">
            <div class="tab-pills" id="tabPills">
                <div class="tab-p active" onclick="filterTab(this,'all')">Semua <span class="badge-count">...</span></div>
                <div class="tab-p" onclick="filterTab(this,'pending')">Menunggu <span class="badge-count"
                        style="background:#e6ecf4;color:var(--blue);">...</span></div>
                <div class="tab-p" onclick="filterTab(this,'published')">Terbit <span class="badge-count"
                        style="background:#e6f4ea;color:#1e8e3e;">...</span></div>
                <div class="tab-p" onclick="filterTab(this,'rejected')">Ditolak <span class="badge-count"
                        style="background:#fde8e8;color:var(--red);">...</span></div>
            </div>

            <div style="margin-left:auto;display:flex;gap:8px;">
                <div class="search-box">
                    <svg width="14" height="14" fill="none" stroke="#7a7570" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" stroke-width="2" />
                        <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                    </svg>
                    <input type="text" id="searchInput" onkeyup="jalankanFilter()" placeholder="Cari judul berita...">
                </div>

                <select class="filter-select select-kategori-ajax" id="filterKategori" onchange="jalankanFilter()"
                    style="font-size:12px;padding:6px 10px;">
                    <option value="all">Semua Kategori</option>
                </select>
                <select id="filterUrutan" class="filter-select" onchange="jalankanFilter()"
                    style="font-size:12px;padding:6px 10px;">
                    <option value="baru">Terbaru</option>
                    <option value="lama">Terlama</option>
                </select>
            </div>
        </div>

        <div class="card">
            <div class="card-hd">
                <div class="card-ht">Daftar Antrean Berita</div>
                <div class="card-hm" id="tableCount">Menampilkan ... artikel</div>
            </div>
            <table id="newsTable">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Judul & Penulis</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi Redaksi</th>
                    </tr>
                </thead>
                <tbody id="newsBody">
                    <tr>
                        <td>
                            <div class="tbl-img">
                                <div style="width:40px;height:40px;background:#eee;border-radius:4px;"></div>
                            </div>
                        </td>
                        <td>
                            <div class="tbl-title">Timnas Menang Telak</div>
                            <div class="tbl-meta">Oleh: Budi (Editor)</div>
                        </td>
                        <td><span class="badge" style="background:#fde8e8;color:var(--red);">Olahraga</span></td>
                        <td><span class="badge b-review">Pending</span></td>
                        <td style="font-size:12px;color:var(--muted);">14 Feb 2026</td>
                        <td>
                            <div class="act-btns">
                                <div class="ico-btn" title="Review & Edit Minor" onclick="reviewBerita(1)">👁️</div>
                                <div class="ico-btn" title="Terbitkan" onclick="confirmPublish(1)" style="color:#1e8e3e;">✅
                                </div>
                                <div class="ico-btn" title="Tolak" onclick="confirmReject(1)" style="color:var(--red);">❌
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pager" id="paginationControl"></div>
        </div>
    </div>

    <div id="modalPublish"
        style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div
            style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">✅</div>
            <div
                style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">
                Terbitkan Artikel?</div>
            <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel ini akan berstatus
                "Published" dan dapat diakses oleh publik di website portal berita.</div>
            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeModal('modalPublish')">Batal</button>
                <button class="btn btn-blue" style="flex:1;" onclick="doPublish()">Ya, Terbitkan</button>
            </div>
        </div>
    </div>

    <div id="modalReject"
        style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div
            style="background:var(--white);border-radius:12px;padding:32px;max-width:450px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">❌</div>
            <div
                style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">
                Tolak Artikel</div>
            <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:16px;">Berikan catatan revisi agar
                Editor tahu apa yang perlu diperbaiki sebelum mengajukan ulang.</div>

            <textarea id="catatanPenolakan" class="reject-notes"
                placeholder="Contoh: Judul terlalu clickbait, mohon diperbaiki dan cek kembali paragraf 3..."></textarea>
            <p id="errorCatatan"
                style="color:var(--red); font-size:11px; display:none; margin-top:-10px; margin-bottom:16px;">Catatan
                penolakan wajib diisi!</p>

            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeModal('modalReject')">Batal</button>
                <button class="btn btn-red" style="flex:1;" onclick="doReject()">Kirim Penolakan</button>
            </div>
        </div>
    </div>

    <div id="modalViewBerita"
        style="position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:500;display:none;align-items:center;justify-content:center;">
        <div class="modal-content card">

            <div class="ico-btn" onclick="closeModal('modalViewBerita')"
                style="position:absolute; top:15px; right:15px; font-size:16px; z-index:10; background:rgba(255,255,255,.8); width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                ✕</div>

            <div class="view-header-panel">
                <div class="view-thumb" id="viewThumb"
                    style="display:flex; align-items:center; justify-content:center; color:#aaa; font-size:11px; font-weight:bold;">
                    THUMBNAIL
                </div>
                <div class="view-meta-info">
                    <div class="view-meta-judul" id="viewJudul">Judul Berita Sample</div>
                    <div class="view-meta-sub">
                        <span id="viewKategori" class="badge b-draft">Kategori</span>
                        <span>Oleh: <b id="viewPenulis" style="color:var(--black);">Nama Penulis</b></span>
                        <span id="viewTanggal">14 Feb 2026</span>
                    </div>
                </div>
            </div>

            <div class="view-body-panel" id="viewBodyKonten">
            </div>

            <div class="view-footer-panel">
                <div class="validation-callout">
                    <div class="validation-title">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Poin Penting Validasi Redaksi
                    </div>
                    <ul class="validation-list">
                        <li>✅ Periksa EYD & Tanda Baca</li>
                        <li>✅ Cek Kesesuaian Judul vs Isi</li>
                        <li>✅ Pastikan Tidak Ada Unsur SARA/Hoaks</li>
                        <li>✅ Verifikasi Sumber Gambar/Thumbnail</li>
                        <li>✅ Cek Format HTML (Heading, Bold)</li>
                        <li>✅ Pastikan Kategori Sudah Tepat</li>
                    </ul>
                </div>

                <div class="footer-action-bar">
                    <button class="btn btn-outline btn-sm" onclick="closeModal('modalViewBerita')">Tutup Review</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script>
        // 1. DUMMY DATA (Minimal 12 biar keliatan paginationnya)
        let dataBeritaMaster = [{
                id: 1,
                judul_berita: "Timnas Menang Telak 5-0",
                penulis: "Budi Santoso",
                slug: "timnas-menang-telak",
                kategori: "Olahraga",
                status_berita: "Pending",
                created_at: "2026-04-06T10:00:00"
            },
            {
                id: 2,
                judul_berita: "Harga Beras Turun Drastis",
                penulis: "Siti Aminah",
                slug: "harga-beras-turun",
                kategori: "Ekonomi",
                status_berita: "Pending",
                created_at: "2026-04-05T08:30:00"
            },
            {
                id: 3,
                judul_berita: "Review Gadget Terbaru 2026",
                penulis: "Andi Wijaya",
                slug: "review-gadget",
                kategori: "Teknologi",
                status_berita: "Pending",
                created_at: "2026-04-04T15:20:00"
            },
            {
                id: 4,
                judul_berita: "Pemilu Daerah Aman Terkendali",
                penulis: "Budi Santoso",
                slug: "pemilu-aman",
                kategori: "Politik",
                status_berita: "Published",
                created_at: "2026-04-03T09:10:00"
            },
            {
                id: 5,
                judul_berita: "Kasus DBD Meningkat di Jakarta",
                penulis: "Siti Aminah",
                slug: "kasus-dbd",
                kategori: "Kesehatan",
                status_berita: "Rejected",
                created_at: "2026-04-02T14:00:00"
            },
            {
                id: 6,
                judul_berita: "Festival Budaya Nusantara",
                penulis: "Andi Wijaya",
                slug: "festival-budaya",
                kategori: "Budaya",
                status_berita: "Published",
                created_at: "2026-04-01T11:45:00"
            },
            {
                id: 7,
                judul_berita: "Saham Teknologi Anjlok",
                penulis: "Budi Santoso",
                slug: "saham-anjlok",
                kategori: "Ekonomi",
                status_berita: "Pending",
                created_at: "2026-03-31T16:30:00"
            },
            {
                id: 8,
                judul_berita: "Piala Dunia 2026 Dimulai",
                penulis: "Siti Aminah",
                slug: "piala-dunia",
                kategori: "Olahraga",
                status_berita: "Published",
                created_at: "2026-03-30T19:00:00"
            },
            {
                id: 9,
                judul_berita: "Vaksin Baru Ditemukan",
                penulis: "Andi Wijaya",
                slug: "vaksin-baru",
                kategori: "Kesehatan",
                status_berita: "Pending",
                created_at: "2026-03-29T08:15:00"
            },
            {
                id: 10,
                judul_berita: "Korupsi Dana Desa Terungkap",
                penulis: "Budi Santoso",
                slug: "korupsi-dana",
                kategori: "Politik",
                status_berita: "Rejected",
                created_at: "2026-03-28T13:40:00"
            },
            {
                id: 11,
                judul_berita: "Pameran Seni Lukis Internasional",
                penulis: "Siti Aminah",
                slug: "pameran-seni",
                kategori: "Budaya",
                status_berita: "Pending",
                created_at: "2026-03-27T10:50:00"
            },
            {
                id: 12,
                judul_berita: "AI Gantikan Pekerjaan Manusia?",
                penulis: "Andi Wijaya",
                slug: "ai-gantikan",
                kategori: "Teknologi",
                status_berita: "Published",
                created_at: "2026-03-26T14:20:00"
            },
        ];

        let currentPage = 1;
        const perPage = 10;
        let statusAktif = 'all';

        // 2. INISIALISASI SAAT HALAMAN DIBUKA
        $(document).ready(function() {
            populateKategori();
            jalankanFilter(); // Render pertama kali
        });

        // Populate dropdown kategori dari data unik di master data
        function populateKategori() {
            const uniqueCategories = [...new Set(dataBeritaMaster.map(item => item.kategori))];
            let options = '<option value="all">Semua Kategori</option>';
            uniqueCategories.forEach(cat => {
                options += `<option value="${cat}">${cat}</option>`;
            });
            $('#filterKategori').html(options);
        }

        // 3. LOGIKA FILTER, SEARCH, SORT
        function filterTab(el, status) {
            document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            statusAktif = status;
            currentPage = 1; // Reset ke halaman 1
            jalankanFilter();
        }

        function jalankanFilter() {
            const keyword = $('#searchInput').val().toLowerCase();
            const kategoriDipilih = $('#filterKategori').val();
            const urutanDipilih = $('#filterUrutan').val();

            // A. Filter Data
            let dataTerfilter = dataBeritaMaster.filter(val => {
                const cocokStatus = (statusAktif === 'all' || val.status_berita.toLowerCase() === statusAktif);
                const cocokKategori = (kategoriDipilih === 'all' || val.kategori === kategoriDipilih);
                const cocokSearch = val.judul_berita.toLowerCase().includes(keyword) || val.penulis.toLowerCase()
                    .includes(keyword);

                return cocokStatus && cocokKategori && cocokSearch;
            });

            // B. Sort Data
            dataTerfilter.sort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);
                return (urutanDipilih === 'baru') ? dateB - dateA : dateA - dateB;
            });

            // C. Update Angka di Tab & Sidebar
            updateStatistik();

            // D. Render Tabel
            renderTable(dataTerfilter);
        }

        // 4. RENDER TABEL & PAGINATION
        function renderTable(data) {
            const tbody = $('#newsBody');
            const total = data.length;

            // Potong data buat pagination
            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const paginatedData = data.slice(start, end);

            let rows = '';
            $.each(paginatedData, function(key, val) {
                let badgeColor, textColor;
                if (val.status_berita === 'Pending') {
                    badgeColor = '#e6ecf4';
                    textColor = 'var(--blue)';
                } else if (val.status_berita === 'Published') {
                    badgeColor = '#e6f4ea';
                    textColor = '#1e8e3e';
                } else {
                    badgeColor = '#fde8e8';
                    textColor = 'var(--red)';
                }

                // Cuma nampilin tombol Publish/Reject kalau statusnya Pending
                let actionBtns = '';
                if (val.status_berita === 'Pending') {
                    actionBtns = `
                    <div class="ico-btn" title="Review & Edit Minor" onclick="reviewBerita(${val.id})">👁️</div>
                    <div class="ico-btn" title="Terbitkan" onclick="confirmPublish(${val.id})" style="color:#1e8e3e;">✅</div>
                    <div class="ico-btn" title="Tolak" onclick="confirmReject(${val.id})" style="color:var(--red);">❌</div>
                `;
                } else {
                    actionBtns =
                        `<div class="ico-btn" title="Lihat Berita" onclick="reviewBerita(${val.id})">👁️</div>`;
                }

                rows += `
            <tr>
                <td><div class="tbl-img"><div style="width:40px;height:40px;background:#eee;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:10px;color:#aaa;">IMG</div></div></td>
                <td>
                    <div class="tbl-title">${val.judul_berita}</div>
                    <div class="tbl-meta">Oleh: ${val.penulis}</div>
                </td>
                <td><span class="badge" style="background:#f0f0f0;color:#555;">${val.kategori}</span></td>
                <td><span class="badge" style="background:${badgeColor};color:${textColor};">${val.status_berita}</span></td>
                <td style="font-size:12px;color:var(--muted);">${new Date(val.created_at).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'})}</td>
                <td><div class="act-btns">${actionBtns}</div></td>
            </tr>`;
            });

            tbody.html(rows ||
                '<tr><td colspan="6" style="text-align:center;padding:20px;">Data tidak ditemukan.</td></tr>');

            $('#tableCount').text(`Menampilkan ${paginatedData.length} dari ${total} artikel`);
            renderPaginationControls(total);
        }

        function renderPaginationControls(totalData) {
            const totalPages = Math.ceil(totalData / perPage);
            let html = '';
            for (let i = 1; i <= totalPages; i++) {
                html += `<div class="pg-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</div>`;
            }
            $('#paginationControl').html(html);
        }

        function changePage(page) {
            currentPage = page;
            jalankanFilter();
        }

        function updateStatistik() {
            const all = dataBeritaMaster.length;
            const pending = dataBeritaMaster.filter(b => b.status_berita === 'Pending').length;
            const published = dataBeritaMaster.filter(b => b.status_berita === 'Published').length;
            const rejected = dataBeritaMaster.filter(b => b.status_berita === 'Rejected').length;

            const tabs = $('#tabPills .badge-count');
            $(tabs[0]).text(all);
            $(tabs[1]).text(pending);
            $(tabs[2]).text(published);
            $(tabs[3]).text(rejected);

            // Update Badge Sidebar
            $('#pendingCount').text(pending);
        }

        // 5. FITUR AKSI (MODALS)
        let selectedId = null;

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            selectedId = null;
            $('#catatanPenolakan').val(''); // Reset text area
            $('#errorCatatan').hide(); // Sembunyikan error
        }

        function confirmPublish(id) {
            selectedId = id;
            document.getElementById('modalPublish').style.display = 'flex';
        }

        function doPublish() {
            // Cari index data dan ubah statusnya di array dummy
            let index = dataBeritaMaster.findIndex(b => b.id === selectedId);
            if (index !== -1) {
                dataBeritaMaster[index].status_berita = 'Published';
                alert("Berita berhasil diterbitkan!");
                closeModal('modalPublish');
                jalankanFilter(); // Render ulang tabel
            }
        }

        function confirmReject(id) {
            selectedId = id;
            document.getElementById('modalReject').style.display = 'flex';
        }

        function doReject() {
            const catatan = $('#catatanPenolakan').val().trim();
            if (catatan === "") {
                $('#errorCatatan').show(); // Validasi wajib isi
                return;
            }

            let index = dataBeritaMaster.findIndex(b => b.id === selectedId);
            if (index !== -1) {
                dataBeritaMaster[index].status_berita = 'Rejected';
                // Nanti di backend lu lempar variable catatan juga
                alert("Berita berhasil ditolak dengan catatan: " + catatan);
                closeModal('modalReject');
                jalankanFilter(); // Render ulang tabel
            }
        }

        function reviewBerita(id) {
            // 1. Cari data di dummy master
            let berita = dataBeritaMaster.find(b => b.id === id);

            if (berita) {
                // 2. Suapin data Meta
                $('#viewJudul').text(berita.judul_berita);
                $('#viewKategori').text(berita.kategori);
                $('#viewPenulis').text(berita.penulis);

                const tglFormatted = new Date(berita.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                $('#viewTanggal').text(tglFormatted);

                // 3. Suapin ISI BERITA PANJANG (Biar kelihatan scroll-nya cuy)
                // Nanti di integrasi API, ganti pake: $('#viewBodyKonten').html(berita.isi_berita);
                let sampleLongContent = `
                <p>Ini adalah paragraf pembuka dari berita berjudul <b>${berita.judul_berita}</b>. Paragraf ini didesain cukup panjang untuk menguji kenyamanan membaca di panel review yang baru. Redaksi diharapkan membaca dengan teliti setiap detail yang disampaikan oleh editor.</p>

                <h2>Analisis Masalah Utama</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                <ul>
                    <li>Poin investigasi pertama mengenai narasumber.</li>
                    <li>Poin kedua mengenai validitas data statistik yang disajikan.</li>
                    <li>Poin ketiga mengenai kutipan langsung yang perlu diverifikasi ulang.</li>
                </ul>

                <blockquote>"Kutipan penting dari tokoh terkait yang harus dipastikan keasliannya oleh Redaksi sebelum Published."</blockquote>

                <h2>Kesimpulan & Rekomendasi Minor</h2>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Paragraf penutup untuk memastikan konten mengalir dengan baik dari awal hingga akhir. Periksa ejaan dan tanda baca di bagian ini.</p>
            `;
                $('#viewBodyKonten').html(sampleLongContent);

                // 4. Reset Scroll Body ke paling atas setiap buka modal baru
                $('.view-body-panel').scrollTop(0);

                // 5. Munculin Modal
                document.getElementById('modalViewBerita').style.display = 'flex';
            }
        }

        /* ── NOTIF (Bawaan) ── */
        function toggleNotif() {
            document.getElementById('notifPanel').classList.toggle('open');
        }
        document.addEventListener('click', e => {
            if (!e.target.closest('.tb-icon') && !e.target.closest('.notif-panel'))
                document.getElementById('notifPanel').classList.remove('open');
        });
    </script>
@endsection
