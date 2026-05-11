@extends('editor.editor_master')

@section('title', 'Berita Saya')
@section('breadcrumb', 'Editor / Berita Saya')

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
            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeDelete()">Batal</button>
                <button class="btn btn-red" style="flex:1;" onclick="doDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>

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
        $(document).ready(function() {
            // Panggil API publik viewer agar tidak kena 403
            loadKategori();
            loadDaftarBerita();

            // INIT NOTIFIKASI KHUSUS EDITOR
            SmartNotif.init({
                apiUrl: '/api/editor/manajemen_berita/ambilNotifikasi',
                renderItemHTML: function(item) {
                    const isRejected = item.type === 'rejected';
                    const bgStyle = isRejected ? 'background: #fff5f5;' : 'background: #f6fff9;';
                    const actionClick = isRejected ? `onclick="editBerita(${item.id})"` : '';

                    return `
                        <div class="notif-item" ${actionClick} style="cursor:pointer; padding:12px; border-bottom:1px solid #eee; display:flex; gap:12px; ${bgStyle}">
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

        const beritaTable = new DataTableEngine({
            tableBody: '#newsBody',
            paginationWrapper: '#paginationControls',
            infoWrapper: '#pagerInfo',
            emptyState: '#emptyState',
            perPage: 5,

            renderRowHTML: function(val) {
                let badgeClass = val.status_berita.toLowerCase() === 'draft' ? 'b-draft' :
                    val.status_berita.toLowerCase() === 'pending' ? 'b-review' : 'b-reject';

                let btnInfoTolak = '';
                if (val.status_berita === 'Rejected') {
                    let alasan = val.catatan_penolakan ? val.catatan_penolakan.replace(/'/g, "\\'") : 'Tidak ada catatan';
                    btnInfoTolak = `<div class="ico-btn" title="Lihat Alasan Tolak" onclick="lihatAlasanTolak('${alasan}')">💬</div>`;
                }

                return `
                <tr data-key="${val.id}">
                    <td><div class="tbl-img"><img src="/uploads/thumbnail/${val.foto_thumbnail}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;"></div></td>
                    <td>
                        <div class="tbl-title">${val.judul_berita}</div>
                        <div class="tbl-meta">Slug: ${val.slug}</div>
                    </td>
                    <td><span class="badge" style="background:#fde8e8;color:var(--red);">${val.kategori ? val.kategori.nama_kategori : 'Uncategorized'}</span></td>
                    <td><span class="badge ${badgeClass}">${val.status_berita}</span></td>
                    <td style="font-size:12px;color:var(--muted);">${new Date(val.created_at).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'})}</td>
                    <td>
                        <div class="act-btns">
                            ${btnInfoTolak}
                            ${val.status_berita !== 'Pending' ? `<div class="ico-btn" onclick="editBerita(${val.id})">✏️</div>` : `<div class="ico-btn" style="opacity:.4;cursor:not-allowed;">✏️</div>`}
                            ${val.status_berita !== 'Pending' ? `<div class="ico-btn" onclick="confirmDelete(${val.id})">🗑</div>` : `<div class="ico-btn" style="opacity:.4;cursor:not-allowed;">🗑</div>`}
                        </div>
                    </td>
                </tr>`;
            }
        });

        function loadKategori() {
            // PERBAIKAN: Menggunakan API Viewer yang tidak butuh Role Admin
            $.ajax({
                url: '/api/viewers/kategori',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        let optionsFilter = '<option value="all">Semua Kategori</option>';

                        $.each(response.data, function(key, val) {
                            optionsFilter += `<option value="${val.nama_kategori}">${val.nama_kategori}</option>`;
                        });

                        const filterEl = $('#filterKategori');
                        let currentFilter = filterEl.val();
                        filterEl.html(optionsFilter);
                        filterEl.val(currentFilter ? currentFilter : 'all');

                        jalankanFilter();
                    }
                }
            });
        }

        function loadDaftarBerita(isSilent = false) {
            $.ajax({
                url: '/api/editor/manajemen_berita/ambilData',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    beritaTable.loadData(response);
                    jalankanFilter();

                    if (response && Array.isArray(response)) {
                        const all = response.length;
                        const draft = response.filter(b => b.status_berita === 'Draft').length;
                        const pending = response.filter(b => b.status_berita === 'Pending').length;
                        const rejected = response.filter(b => b.status_berita === 'Rejected').length;

                        $('#editorSidebarBadge').text(all);
                        const tabs = $('#tabPills .tab-p span');
                        if (tabs.length >= 4) {
                            $(tabs[0]).text(all);
                            $(tabs[1]).text(draft);
                            $(tabs[2]).text(pending);
                            $(tabs[3]).text(rejected);
                        }
                    }
                },
                error: function(xhr) {
                    if(!isSilent) console.error("Gagal mengambil daftar berita.");
                }
            });
        }

        // --- NAVIGASI KE HALAMAN EDIT ---
        function editBerita(id) {
            // Redirect ke form tulis berita dengan membawa parameter ID
            window.location.href = `/tulis-editor?id=${id}`;
        }

        // --- FUNGSI HAPUS ---
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

            const btnHapus = document.querySelector('#modalDelete .btn-red');
            const originalText = btnHapus.innerHTML;
            btnHapus.innerHTML = "Menghapus...";
            btnHapus.disabled = true;

            $.ajax({
                url: `/api/editor/manajemen_berita/hapusBerita/${idBeritaYangAkanDihapus}`,
                type: 'DELETE',
                success: function(response) {
                    Toast.show('success', response.message || 'Berita dihapus!');
                    closeDelete();
                    loadDaftarBerita();
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled = false;
                },
                error: function(xhr) {
                    Toast.show('error', "Gagal menghapus: " + (xhr.responseJSON?.message || "Terjadi kesalahan server"));
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled = false;
                    closeDelete();
                }
            });
        }

        function lihatAlasanTolak(alasan) {
            document.getElementById('teksAlasanTolak').textContent = alasan || 'Tidak ada catatan dari Redaksi.';
            ModalManager.open('modalAlasanTolak');
        }

        /* ── FILTER TABS & SEARCH LOGIC ── */
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
            const keyword = (document.getElementById('searchInput')?.value || '').toLowerCase();

            if (!kategoriDipilih || kategoriDipilih === "") {
                kategoriDipilih = 'all';
                document.getElementById('filterKategori').value = 'all';
            }

            beritaTable.setFilterAndSearch((val) => {
                const cocokStatus = (statusAktif === 'all' || (val.status_berita || '').toLowerCase() === statusAktif);
                const kategoriBaris = val.kategori ? val.kategori.nama_kategori : 'Uncategorized';
                const cocokKategori = (kategoriDipilih === 'all' || kategoriBaris === kategoriDipilih);
                const cocokSearch = !keyword ||
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