@extends('editor.editor_master')

@section('title', 'Berita Saya')
@section('breadcrumb', 'Editor / Berita Saya')

<<<<<<< Updated upstream
=======
@section('css')
<style>
    /* ── FIX RESPONSIVE: Filter Bar & Tab Pills ── */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        margin-bottom: 20px;
        justify-content: space-between;
    }

    .tab-pills {
        display: flex;
        gap: 4px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px;
        max-width: 100%;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* ── FIX RESPONSIVE: Tabel Horizontal Scroll ── */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-responsive table {
        min-width: 800px;
    }

    @media screen and (max-width: 768px) {
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-actions {
            width: 100%;
            justify-content: space-between;
        }
        .filter-actions .filter-select {
            flex: 1;
        }
    }
</style>
@endsection

>>>>>>> Stashed changes
@section('konten')
    <div id="page-my-news" class="page active">
        <div class="section-title">Berita Saya</div>

        <div class="filter-bar">
            <div class="tab-pills" id="tabPills">
                <div class="tab-p active" onclick="filterTab(this,'all')">Semua <span
                        style="margin-left:4px;background:#ddd;color:#555;font-size:10px;padding:1px 6px;border-radius:8px;">0</span>
                </div>
                <div class="tab-p" onclick="filterTab(this,'draft')">Draft <span
                        style="margin-left:4px;background:#ddd;color:#555;font-size:10px;padding:1px 6px;border-radius:8px;">0</span>
                </div>
                <div class="tab-p" onclick="filterTab(this,'pending')">Pending <span
                        style="margin-left:4px;background:#e6ecf4;color:var(--blue);font-size:10px;padding:1px 6px;border-radius:8px;">0</span>
                </div>
<<<<<<< Updated upstream
=======
                <div class="tab-p" onclick="filterTab(this,'published')"> Dipublikasikan
                    <span style="margin-left:4px;background:#e6f4f0;color:var(--success);font-size:10px;padding:1px 6px;border-radius:8px;">0</span>
                </div>
>>>>>>> Stashed changes
                <div class="tab-p" onclick="filterTab(this,'rejected')">Ditolak <span
                        style="margin-left:4px;background:#fde8e8;color:var(--red);font-size:10px;padding:1px 6px;border-radius:8px;">0</span>
                </div>
            </div>
            <div style="margin-left:auto;display:flex;gap:8px;">
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
                <div class="card-ht">Daftar Berita</div>
                <div class="card-hm" id="tableCount"></div>
            </div>
            <table id="newsTable">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Judul &amp; Informasi</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="newsBody">
                </tbody>
            </table>

            <div class="pager">
                <div id="paginationControls" style="display:flex; gap:4px;">
                </div>
                <div class="pg-info" id="pagerInfo">Menampilkan 0 dari 0 artikel</div>
            </div>
        </div>
    </div>

<<<<<<< Updated upstream
    <div id="modalDelete"
        style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div
            style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">🗑</div>
            <div
                style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">
                Hapus Artikel?</div>
            <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel yang dihapus tidak
                dapat dipulihkan. Pastikan Anda yakin sebelum melanjutkan.</div>
=======
    {{-- Modal Hapus --}}
    <div id="modalDelete" class="modal-backdrop" style="display:none;">
        <div class="modal" style="max-width:380px; text-align:center; padding:32px 20px;">
            <div style="font-size:40px; margin-bottom:12px;">🗑</div>
            <div style="font-family:'Merriweather',serif;font-size:18px;font-weight:700;margin-bottom:8px;">Hapus Artikel?</div>
            <div style="font-size:13px;color:var(--muted);margin-bottom:24px;line-height:1.5;">Artikel yang dihapus tidak dapat dipulihkan. Pastikan Anda yakin sebelum melanjutkan.</div>
>>>>>>> Stashed changes
            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeDelete()">Batal</button>
                <button class="btn btn-red" style="flex:1;" onclick="doDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>

<<<<<<< Updated upstream
    <div id="modalAlasanTolak"
        style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div
            style="background:var(--white);border-radius:12px;padding:32px;max-width:400px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">❌</div>
            <div
                style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">
                Artikel Ditolak</div>
            <div
                style="font-size:13px;color:var(--text);background:#fde8e8;padding:12px;border-radius:8px;border:1px solid #f5b8b8;margin-bottom:24px;line-height:1.5;">
                <strong>Catatan Redaksi:</strong><br>
=======
    {{-- Modal Alasan Tolak --}}
    <div id="modalAlasanTolak" class="modal-backdrop" style="display:none;">
        <div class="modal" style="max-width:400px; text-align:center; padding:32px 20px;">
            <div style="font-size:40px; margin-bottom:12px;">❌</div>
            <div style="font-family:'Merriweather',serif;font-size:18px;font-weight:700;margin-bottom:8px;">Artikel Ditolak</div>
            <div style="font-size:13px;color:var(--text);background:#fde8e8;padding:16px;border-radius:8px;border:1px solid #f5b8b8;margin-bottom:24px;line-height:1.6;text-align:left;">
                <strong style="color:var(--red);">Catatan Redaksi:</strong><br>
>>>>>>> Stashed changes
                <span id="teksAlasanTolak"></span>
            </div>
            <div style="display:flex;justify-content:center;">
                <button class="btn btn-outline" onclick="ModalManager.close('modalAlasanTolak')">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        /* ════════════════════════════════════════════════════════════
         *  HELPER GLOBAL — updateSidebarBadge()
         *  Fungsi terpusat untuk update badge di sidebar "Berita Saya".
         *  Dipanggil dari: SmartNotif.onDataLoaded & loadDaftarBerita()
         * ════════════════════════════════════════════════════════════ */
        function updateSidebarBadge(count) {
            const badge = document.getElementById('badgeEditorDitolak');
            if (!badge) return;

            if (count > 0) {
                // Batasi tampilan max 99+ agar badge tidak meluap
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'inline-flex';
            } else {
                badge.style.display = 'none';
            }
        }

        /* ════════════════════════════════════════════════════════════
         *  DOCUMENT READY
         * ════════════════════════════════════════════════════════════ */
        $(document).ready(function () {

            loadKategori();
            loadDaftarBerita();

<<<<<<< Updated upstream
            // INIT NOTIFIKASI KHUSUS EDITOR
=======
            // Setup event listener pencarian (PC & HP)
            const searchInputs = document.querySelectorAll('#searchInput, .mobile-search-input');
            searchInputs.forEach(input => {
                if (input) {
                    input.addEventListener('keyup', function () {
                        jalankanFilter();
                    });
                }
            });

            /* ── SmartNotif: notifikasi dropdown + sinkronisasi badge sidebar ── */
>>>>>>> Stashed changes
            SmartNotif.init({
                apiUrl: '/api/editor/manajemen_berita/ambilNotifikasi',

                renderItemHTML: function (item) {
                    const isRejected = item.type === 'rejected';
                    const bgStyle    = isRejected ? 'background:#fff5f5;' : 'background:#f6fff9;';
                    const actionClick = isRejected ? `onclick="editBerita(${item.id})"` : '';

                    return `
                        <div class="notif-item" ${actionClick}
                             style="cursor:pointer;padding:12px;border-bottom:1px solid #eee;display:flex;gap:12px;${bgStyle}">
                            <div style="font-size:20px;">${item.icon}</div>
                            <div class="notif-txt">
                                <div style="font-weight:700;font-size:13px;color:var(--text);">${item.title}</div>
                                <div style="font-size:12px;color:#555;line-height:1.4;">${item.message}</div>
                                <div style="font-size:10px;color:#999;margin-top:4px;">${item.time}</div>
                            </div>
                        </div>
                    `;
                },

                /**
                 * onDataLoaded — dipanggil SmartNotif setiap kali data notifikasi selesai dimuat.
                 * Sinkronisasi jumlah notifikasi → badge sidebar via updateSidebarBadge().
                 */
                onDataLoaded: function (items) {
                    // Filter hanya yang rejected sebelum update badge
                    const rejectedOnly = Array.isArray(items)
                        ? items.filter(item => item.type === 'rejected')
                        : [];

                    updateSidebarBadge(rejectedOnly.length);
                }
            });
        });

        /* ════════════════════════════════════════════════════════════
         *  DATA TABLE ENGINE
         * ════════════════════════════════════════════════════════════ */
        const beritaTable = new DataTableEngine({
            tableBody:           '#newsBody',
            paginationWrapper:   '#paginationControls',
            infoWrapper:         '#pagerInfo',
            emptyState:          '#emptyState',
            perPage:             5,

            renderRowHTML: function (val) {
                let badgeClass = val.status_berita.toLowerCase() === 'draft'   ? 'b-draft'  :
                                 val.status_berita.toLowerCase() === 'pending' ? 'b-review' : 'b-reject';

                let btnInfoTolak = '';
                if (val.status_berita === 'Rejected') {
                    let alasan = val.catatan_penolakan
                        ? val.catatan_penolakan.replace(/'/g, "\\'")
                        : 'Tidak ada catatan';
                    btnInfoTolak = `<div class="ico-btn" title="Lihat Alasan Tolak" onclick="lihatAlasanTolak('${alasan}')">💬</div>`;
                }

                return `
                <tr data-key="${val.id}">
<<<<<<< Updated upstream
                    <td><div class="tbl-img"><img src="/uploads/thumbnail/${val.foto_thumbnail}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;"></div></td>
=======
                    <td>
                        <div class="tbl-img">
                            <img src="/uploads/thumbnail/${val.foto_thumbnail}" loading="lazy"
                                 style="width:56px;height:40px;object-fit:cover;border-radius:4px;">
                        </div>
                    </td>
>>>>>>> Stashed changes
                    <td>
                        <div class="tbl-title">${val.judul_berita}</div>
                        <div class="tbl-meta">Slug: ${val.slug}</div>
                    </td>
                    <td>
                        <span class="badge" style="background:#fde8e8;color:var(--red);">
                            ${val.kategori ? val.kategori.nama_kategori : 'Uncategorized'}
                        </span>
                    </td>
                    <td><span class="badge ${badgeClass}">${val.status_berita}</span></td>
                    <td style="font-size:12px;color:var(--muted);">
                        ${new Date(val.created_at).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'})}
                    </td>
                    <td>
                        <div class="act-btns">
                            ${btnInfoTolak}
<<<<<<< Updated upstream
                            ${val.status_berita !== 'Pending' ? `<div class="ico-btn" onclick="editBerita(${val.id})">✏️</div>` : `<div class="ico-btn" style="opacity:.4;cursor:not-allowed;">✏️</div>`}
                            ${val.status_berita !== 'Pending' ? `<div class="ico-btn" onclick="confirmDelete(${val.id})">🗑</div>` : `<div class="ico-btn" style="opacity:.4;cursor:not-allowed;">🗑</div>`}
=======
                            ${val.status_berita !== 'Pending'
                                ? `<div class="ico-btn btn-edit" onclick="editBerita(${val.id})">✏️</div>`
                                : `<div class="ico-btn btn-disabled" title="Sedang direview">✏️</div>`}
                            ${val.status_berita !== 'Pending'
                                ? `<div class="ico-btn btn-purge" onclick="confirmDelete(${val.id})">🗑</div>`
                                : `<div class="ico-btn btn-disabled" title="Sedang direview">🗑</div>`}
>>>>>>> Stashed changes
                        </div>
                    </td>
                </tr>`;
            }
        });

        /* ════════════════════════════════════════════════════════════
         *  LOAD KATEGORI
         * ════════════════════════════════════════════════════════════ */
        function loadKategori() {
            // PERBAIKAN: Menggunakan API Viewer yang tidak butuh Role Admin
            $.ajax({
<<<<<<< Updated upstream
                url: '/api/viewers/kategori', // ← GANTI INI
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Sesuaikan karena struktur response viewers berbeda
=======
                url:      '/api/viewers/kategori',
                type:     'GET',
                dataType: 'json',
                success: function (response) {
>>>>>>> Stashed changes
                    let data = [];
                    if (response.status === 'success' && Array.isArray(response.data)) {
                        data = response.data;
                    } else if (Array.isArray(response)) {
                        data = response;
                    }

                    let optionsForm   = '<option value="">-- Pilih Kategori --</option>';
                    let optionsFilter = '<option value="all">Semua Kategori</option>';

                    data.forEach(function (val) {
                        optionsForm   += `<option value="${val.id}">${val.nama_kategori}</option>`;
                        optionsFilter += `<option value="${val.nama_kategori}">${val.nama_kategori}</option>`;
                    });

                    const filterEl    = $('#filterKategori');
                    let currentFilter = filterEl.val();
                    filterEl.html(optionsFilter);
                    filterEl.val(currentFilter ? currentFilter : 'all');

                    const formEl    = $('select[name="kategori_id"]');
                    let currentForm = formEl.val();
                    formEl.html(optionsForm);
                    formEl.val(currentForm);

                    jalankanFilter();
                },
                error: function (xhr) {
                    console.error("Gagal memuat kategori:", xhr.status, xhr.responseText);
                }
            });
        }

        /* ════════════════════════════════════════════════════════════
         *  LOAD DAFTAR BERITA
         *  — setelah data berhasil dimuat, hitung jumlah rejected
         *    dan sinkronkan badge sidebar via updateSidebarBadge()
         * ════════════════════════════════════════════════════════════ */
        function loadDaftarBerita(isSilent = false) {
            $.ajax({
                url:      '/api/editor/manajemen_berita/ambilData',
                type:     'GET',
                dataType: 'json',
                success: function (response) {
                    beritaTable.loadData(response);
                    jalankanFilter();

                    if (response && Array.isArray(response)) {
<<<<<<< Updated upstream
                        const all = response.length;
                        const draft = response.filter(b => b.status_berita === 'Draft').length;
                        const pending = response.filter(b => b.status_berita === 'Pending').length;
                        const rejected = response.filter(b => b.status_berita === 'Rejected').length;
=======
                        const all       = response.length;
                        const draft     = response.filter(b => b.status_berita === 'Draft').length;
                        const pending   = response.filter(b => b.status_berita === 'Pending').length;
                        const rejected  = response.filter(b => b.status_berita === 'Rejected').length;
                        const published = response.filter(b => b.status_berita === 'Published').length;
>>>>>>> Stashed changes

                        // Update counter di tab pills
                        const tabs = $('#tabPills .tab-p span');
                        if (tabs.length >= 5) {
                            $(tabs[0]).text(all);
                            $(tabs[1]).text(draft);
                            $(tabs[2]).text(pending);
<<<<<<< Updated upstream
                            $(tabs[3]).text(rejected);
=======
                            $(tabs[3]).text(published);
                            $(tabs[4]).text(rejected);
>>>>>>> Stashed changes
                        }

                        /*
                         * SINKRONISASI BADGE SIDEBAR
                         * Badge merah muncul jika ada artikel berstatus Rejected.
                         * Menggunakan helper updateSidebarBadge() agar konsisten
                         * dengan sumber notifikasi dari SmartNotif.onDataLoaded.
                         *
                         * CATATAN: Jika ingin badge menampilkan total notifikasi
                         * dari SmartNotif (bukan hanya rejected), hapus baris ini
                         * dan biarkan SmartNotif yang menjadi sumber tunggal.
                         */
                        updateSidebarBadge(rejected);
                    }
                },
                error: function (xhr) {
                    if (!isSilent) console.error("Gagal mengambil daftar berita.");
                }
            });
        }

<<<<<<< Updated upstream
        // --- NAVIGASI KE HALAMAN EDIT ---
=======
        /* ════════════════════════════════════════════════════════════
         *  EDIT BERITA
         * ════════════════════════════════════════════════════════════ */
>>>>>>> Stashed changes
        function editBerita(id) {
            // Redirect ke form tulis berita dengan membawa parameter ID
            window.location.href = `/tulis-editor?id=${id}`;
        }

<<<<<<< Updated upstream
        // --- FUNGSI HAPUS ---
=======
        /* ════════════════════════════════════════════════════════════
         *  DELETE BERITA
         * ════════════════════════════════════════════════════════════ */
>>>>>>> Stashed changes
        let idBeritaYangAkanDihapus = null;

        function confirmDelete(id) {
            idBeritaYangAkanDihapus = id;
            ModalManager.open('modalDelete');
        }

        function closeDelete() {
            ModalManager.close('modalDelete');
            idBeritaYangAkanDihapus = null;
        }

        function doDelete() {
            if (!idBeritaYangAkanDihapus) return;

            const btnHapus     = document.querySelector('#modalDelete .btn-red');
            const originalText = btnHapus.innerHTML;
            btnHapus.innerHTML = "Menghapus...";
            btnHapus.disabled  = true;

            $.ajax({
                url:  `/api/editor/manajemen_berita/hapusBerita/${idBeritaYangAkanDihapus}`,
                type: 'DELETE',
                success: function (response) {
                    Toast.show('success', response.message || 'Berita dihapus!');
                    closeDelete();
                    // loadDaftarBerita() otomatis memanggil updateSidebarBadge() di dalamnya
                    loadDaftarBerita();
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled  = false;
                },
                error: function (xhr) {
                    Toast.show('error', "Gagal menghapus: " + (xhr.responseJSON?.message || "Terjadi kesalahan server"));
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled  = false;
                    closeDelete();
                }
            });
        }

        /* ════════════════════════════════════════════════════════════
         *  MODAL ALASAN TOLAK
         * ════════════════════════════════════════════════════════════ */
        function lihatAlasanTolak(alasan) {
            document.getElementById('teksAlasanTolak').textContent = alasan || 'Tidak ada catatan dari Redaksi.';
            ModalManager.open('modalAlasanTolak');
        }

        /* ════════════════════════════════════════════════════════════
         *  FILTER TABS & SEARCH LOGIC
         * ════════════════════════════════════════════════════════════ */
        let statusAktif = 'all';

        function filterTab(el, status) {
            document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            statusAktif = status;
            jalankanFilter();
        }

        function jalankanFilter() {
            let kategoriDipilih = document.getElementById('filterKategori').value;
            const urutanDipilih = document.getElementById('filterUrutan').value;
<<<<<<< Updated upstream
            const keyword = (document.getElementById('searchInput')?.value || '').toLowerCase();
=======

            // Sinkronisasi pencarian dari navbar PC dan HP
            const desktopSearch = document.getElementById('searchInput');
            const mobileSearch  = document.querySelector('.mobile-search-input');
            let keyword = '';

            if (desktopSearch && desktopSearch.value)     keyword = desktopSearch.value.toLowerCase();
            else if (mobileSearch && mobileSearch.value)  keyword = mobileSearch.value.toLowerCase();
>>>>>>> Stashed changes

            if (!kategoriDipilih || kategoriDipilih === '') {
                kategoriDipilih = 'all';
                document.getElementById('filterKategori').value = 'all';
            }

            beritaTable.setFilterAndSearch((val) => {
                const cocokStatus   = (statusAktif === 'all' || (val.status_berita || '').toLowerCase() === statusAktif);
                const kategoriBaris = val.kategori ? val.kategori.nama_kategori : 'Uncategorized';
                const cocokKategori = (kategoriDipilih === 'all' || kategoriBaris === kategoriDipilih);
                const cocokSearch   = !keyword ||
                                      (val.judul_berita || '').toLowerCase().includes(keyword) ||
                                      (val.slug && val.slug.toLowerCase().includes(keyword));

                return cocokStatus && cocokKategori && cocokSearch;
            });

            beritaTable.setSort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);
                return (urutanDipilih === 'baru') ? dateB - dateA : dateA - dateB;
            });
        }

    </script>
@endsection