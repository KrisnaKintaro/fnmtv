@extends('editor.editor_master')
@section('css')
    <style>
        .rte-btn.active {
            background: #eef2ff;
            /* Warna biru muda pudar */
            color: var(--blue);
            border: 1px solid var(--blue);
            border-radius: 4px;
        }

        /* ── EFEK DRAG AND DROP ── */
        .thumb-upload {
            transition: all 0.3s ease;
        }

        .thumb-upload.drag-over {
            border-color: var(--blue);
            background-color: #eef2ff;
            border-style: solid;
        }
    </style>
@endsection
@section('konten')
    <!-- ══ PAGE: TULIS BERITA BARU ══ -->
    <div id="page-write-news" class="page">
        <div class="page-header">
            <div id="backButtonContainer" class="back-button" style="display:none;">
                <button class="btn btn-ghost btn-sm btn-pill"
                    onclick="resetFormBerita(); showPage('my-news', document.querySelectorAll('.s-item')[1])"
                    style="gap:6px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </button>
            </div>
            <div class="section-title" id="sectionTitle">Tulis Berita Baru</div>
        </div>
        <div class="form-grid">

            <!-- LEFT: Main Form -->
            <div>
                <div class="form-card" style="margin-bottom:16px;">
                    <div class="form-title">Informasi Artikel</div>
                    <div id="alertRejectBox"
                        style="display:none; background:#fde8e8; border:1px solid #f5b8b8; padding:16px; border-radius:8px; margin-bottom:16px;">
                        <div style="font-weight:700; color:var(--red); margin-bottom:4px;">⚠️ Artikel ini dikembalikan oleh
                            Redaksi</div>
                        <div style="font-size:13px; color:var(--text);"><strong>Alasan:</strong> <span
                                id="alertRejectText"></span></div>
                    </div>
                    <div class="field">
                        <label>Judul Berita *</label>
                        <input type="text" id="inputJudul" name="judul_berita"
                            placeholder="Masukkan judul berita yang menarik..." required>
                    </div>
                    <div class="field">
                        <label>Slug URL</label>
                        <input type="text" id="inputSlug" name="slug" placeholder="judul-berita-menarik"
                            style="font-family:'JetBrains Mono',monospace;font-size:13px;">
                    </div>
                    <div class="field">
                        <label>Konten Berita *</label>
                        <div class="rte-mock">
                            <div class="rte-toolbar">
                                <button type="button" class="rte-btn rte-btn-bold" onclick="RTE.exec('bold')"
                                    title="Tebal"><b>B</b></button>
                                <button type="button" class="rte-btn rte-btn-italic" onclick="RTE.exec('italic')"
                                    title="Miring"><i>I</i></button>
                                <button type="button" class="rte-btn rte-btn-underline" onclick="RTE.exec('underline')"
                                    title="Garis Bawah"><u>U</u></button>

                                <div class="rte-sep"></div>

                                <button type="button" class="rte-btn rte-btn-h1" onclick="RTE.exec('formatBlock', 'h1')"
                                    title="Heading 1">H1</button>
                                <button type="button" class="rte-btn rte-btn-h2" onclick="RTE.exec('formatBlock', 'h2')"
                                    title="Heading 2">H2</button>
                                <button type="button" class="rte-btn rte-btn-h3" onclick="RTE.exec('formatBlock', 'h3')"
                                    title="Heading 3">H3</button>

                                <div class="rte-sep"></div>

                                <button type="button" class="rte-btn" onclick="RTE.exec('justifyLeft')"
                                    title="Rata Kiri">≡</button>
                                <button type="button" class="rte-btn" onclick="RTE.exec('justifyCenter')"
                                    title="Rata Tengah">≣</button>
                                <button type="button" class="rte-btn" onclick="RTE.insertLink()"
                                    title="Tambah Link">🔗</button>
                            </div>
                            <div class="rte-body" id="inputKonten" contenteditable="true" required></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Sidebar Controls -->
            <div>
                <!-- Category -->
                <div class="form-card" style="margin-bottom:16px;">
                    <div class="form-title">Kategori</div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Pilih Kategori *</label>
                        <select class="select-kategori-ajax" name="kategori_id" style="font-size:12px;padding:6px 10px;">
                            <option value="">-- Memuat Kategori... --</option>
                        </select>
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="form-card" style="margin-bottom:16px;">
                    <div class="form-title">Thumbnail Berita</div>
                    <input type="file" id="inputFoto" name="foto_thumbnail" style="display:none;">

                    <div class="thumb-upload" onclick="document.getElementById('inputFoto').click()"
                        style="cursor:pointer;">
                        <div class="ico">🖼</div>
                        <p id="labelFoto"><span>Pilih file</span> atau seret ke sini</p>
                        <img id="imgPreview"
                            style="display:none; width:100%; height:100%; object-fit:cover; border-radius:8px;">
                    </div>
                    <p style="font-size:11px;margin-top:4px;">JPG, PNG, JPEG · Maks. 2 MB</p>
                </div>

                <!-- Publish Box -->
                <div class="form-card">
                    <div class="form-title">Status Pengiriman</div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Kirim sebagai</label>
                        <div class="toggle-group">
                            <div class="tgl-opt sel-draft" id="tglDraft" onclick="confirmStatus('draft')">Draft</div>
                            <div class="tgl-opt" id="tglPending" onclick="confirmStatus('pending')">Kirim ke Redaksi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ PAGE: BERITA SAYA ══ -->
    <div id="page-my-news" class="page active">
        <div class="section-title">Berita Saya</div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="tab-pills" id="tabPills">
                <div class="tab-p active" onclick="filterTab(this,'all')">Semua <span
                        style="margin-left:4px;background:#ddd;color:#555;font-size:10px;padding:1px 6px;border-radius:8px;">9</span>
                </div>
                <div class="tab-p" onclick="filterTab(this,'draft')">Draft <span
                        style="margin-left:4px;background:#ddd;color:#555;font-size:10px;padding:1px 6px;border-radius:8px;">4</span>
                </div>
                <div class="tab-p" onclick="filterTab(this,'pending')">Pending <span
                        style="margin-left:4px;background:#e6ecf4;color:var(--blue);font-size:10px;padding:1px 6px;border-radius:8px;">3</span>
                </div>
                <div class="tab-p" onclick="filterTab(this,'rejected')">Ditolak <span
                        style="margin-left:4px;background:#fde8e8;color:var(--red);font-size:10px;padding:1px 6px;border-radius:8px;">2</span>
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

        <!-- Table -->
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

            <!-- Pagination -->
            <div class="pager">
                <div id="paginationControls" style="display:flex; gap:4px;">
                </div>
                <div class="pg-info" id="pagerInfo">Menampilkan 0 dari 0 artikel</div>
            </div>
        </div>
    </div>

    </main>

    <!-- ══ MODAL: Konfirmasi Statusnya Draft ══ -->
    <div id="modalDraft"
        style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div
            style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">📝</div>
            <div
                style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">
                Simpan sebagai Draft?</div>
            <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan disimpan
                sebagai draft dan hanya terlihat oleh Anda. Anda bisa mengedit dan mengirimnya kapan saja.</div>
            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('draft')">Batal</button>
                <button class="btn btn-ghost" style="flex:1;" onclick="applyStatus('draft')">Ya, Simpan Draft</button>
            </div>
        </div>
    </div>

    <!-- ══ MODAL: Konfirmasi Kirim ke Redaksi ══ -->
    <div id="modalPending"
        style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div
            style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">📨</div>
            <div
                style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">
                Kirim ke Redaksi?</div>
            <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan dikirim ke
                Redaksi untuk diverifikasi dan diterbitkan. Pastikan artikel sudah siap sebelum melanjutkan.</div>
            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('pending')">Batal</button>
                <button class="btn btn-ghost" style="flex:1;" onclick="applyStatus('pending')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Ya, Kirim
                </button>
            </div>
        </div>
    </div>

    <!-- ══ MODAL: Konfirmasi Hapus ══ -->
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
    <div id="toast"
        style="position:fixed; bottom:28px; right:28px; background:#1a1a1a; color:#fff; padding:14px 20px; border-radius:8px; font-size:13px; font-weight:600; display:none; align-items:center; gap:12px; box-shadow:0 8px 30px rgba(0,0,0,.3); z-index:9999; min-width:280px; max-width:400px; transition:opacity .3s; opacity:0;">
        <span id="toastIco" style="font-size:20px;">✅</span>
        <span id="toastMsg" style="line-height:1.4;">Pesan notifikasi di sini...</span>
    </div>
@endsection
@section('js')
    <script>
        let isEditingFromTable = false;

        $(document).ready(function() {
            // Jalankan fungsi saat halaman pertama kali dimuat
            loadKategori();
            loadDaftarBerita();

            // Polling buat update tabel & notif setiap 10 detik
            // setInterval(function() {
            //     // Kita panggil loadData secara silent (tanpa ngerusak ketikan user)
            //     loadDaftarBerita(true);
            // }, 5000);

            // INIT NOTIFIKASI KHUSUS EDITOR
            SmartNotif.init({
                apiUrl: '/api/editor/manajemen_berita/ambilNotifikasi',
                renderItemHTML: function(item) {
                    // Logika tampilan khusus Editor
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

        // Panggil DropZone Helper
        new ImageDropZone({
            dropZoneSelector: '.thumb-upload', // Area kotak putus-putus
            inputSelector: '#inputFoto', // Input type file-nya
            previewSelector: '#imgPreview', // Target tag <img id="imgPreview">
            uiToHideSelector: '.thumb-upload .ico, .thumb-upload p' // Teks yang diilangin pas gambar muncul
        });

        const beritaTable = new DataTableEngine({
            tableBody: '#newsBody',
            paginationWrapper: '#paginationControls', // Target container tombol
            infoWrapper: '#pagerInfo',
            emptyState: '#emptyState',
            perPage: 5,

            // Ini template HTML khusus untuk tabel berita
            renderRowHTML: function(val) {
                let badgeClass = val.status_berita.toLowerCase() === 'draft' ? 'b-draft' :
                    val.status_berita.toLowerCase() === 'pending' ? 'b-review' : 'b-reject';

                let btnInfoTolak = '';
                if (val.status_berita === 'Rejected') {
                    let alasan = val.catatan_penolakan ? val.catatan_penolakan.replace(/'/g, "\\'") :
                        'Tidak ada catatan';
                    btnInfoTolak =
                        `<div class="ico-btn" title="Lihat Alasan Tolak" onclick="lihatAlasanTolak('${alasan}')">💬</div>`;
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
            $.ajax({
                url: '/api/admin/manajemen_kategori/ambilData',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        let optionsForm = '<option value="">-- Pilih Kategori --</option>';
                        let optionsFilter = '<option value="all">Semua Kategori</option>';

                        $.each(response.data, function(key, val) {
                            optionsForm += `<option value="${val.id}">${val.nama_kategori}</option>`;
                            optionsFilter += `<option value="${val.nama_kategori}">${val.nama_kategori}</option>`;
                        });

                        // Update Filter Kategori (Aman dari blank)
                        const filterEl = $('#filterKategori');
                        let currentFilter = filterEl.val(); // Simpan pilihan lama
                        filterEl.html(optionsFilter);
                        // Paksa pilih 'all' kalau sebelumnya kosong/blank gara-gara glitch browser
                        filterEl.val(currentFilter ? currentFilter : 'all');

                        // Update Form Kategori
                        const formEl = $('select[name="kategori_id"]');
                        let currentForm = formEl.val();
                        formEl.html(optionsForm);
                        formEl.val(currentForm);

                        // KUNCI: Senggol tabel buat refresh setelah kategori siap!
                        jalankanFilter();
                    }
                },
                error: function(xhr) {
                    console.error("Gagal memuat kategori cuy!");
                }
            });
        }

        // Fungsi Super: Sekali narik data, tabel & statistik langsung update!
        function loadDaftarBerita(isSilent = false) {
            $.ajax({
                // Tambahin "?t=" + waktu sekarang biar browser kapok nge-cache
                url: '/api/editor/manajemen_berita/ambilData',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // 1. Masukin data ke engine tabel
                    beritaTable.loadData(response);

                    // 2. Render ulang (Trigger UI)
                    jalankanFilter();

                    // 3. Update Statistik LANGSUNG di sini (Gak usah 2x AJAX!)
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
                    if(!isSilent) console.error("Gagal mengambil daftar berita cuy!");
                }
            });
        }

        function simpanBerita(statusTujuan) {
            // 1. Inisialisasi FormData (Wajib buat upload file)
            let formData = new FormData();

            // 2. Ambil data dari inputan
            formData.append('judul_berita', $('#inputJudul').val());
            formData.append('slug', $('#inputSlug').val());
            formData.append('kategori_id', $('.select-kategori-ajax').val()); // Ambil dari dropdown kategori
            formData.append('isi_berita', $('#inputKonten').html()); // Ambil isi dari contenteditable
            formData.append('status_berita', statusTujuan); // 'Draft' atau 'Pending'

            // Ambil file foto
            let foto = $('#inputFoto')[0].files[0];
            if (foto) {
                formData.append('foto_thumbnail', foto);
            }

            // Masukkan ini di dalam fungsi simpanBerita setelah semua append selesai
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // 3. Eksekusi AJAX POST
            $.ajax({
                url: '/api/editor/manajemen_berita/tambahData',
                type: 'POST',
                data: formData,
                contentType: false, // Wajib false kalau pake FormData
                processData: false, // Wajib false kalau pake FormData
                success: function(response) {
                    if (response.status === 'success') {
                        Toast.show('success', response.message);

                        // ── KUNCI UTAMA DI SINI ──
                        resetFormBerita();
                        showPage('my-news', document.querySelectorAll('.s-item')[1]);

                        // Tarik ulang SEMUA data berita dari server biar tabel penuh lagi
                        loadDaftarBerita(true);
                    }
                },
                error: function(xhr) {
                    console.log(formData)
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        // Kita loop semua errornya biar muncul semua di alert
                        let errorMessage = "";
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + "\n";
                        });
                        Toast.show('warning', errorMessage.trim());
                    } else if (xhr.status === 419) {
                        Toast.show('error', "CSRF Token ilang cuy, coba refresh halaman!");
                    } else {
                        // Nangkep pesan error detail dari Laravel
                        let errorDetail = xhr.responseJSON?.message || xhr.responseText;
                        Toast.show('error', "Error 500: Cek Console cuy!");
                        console.error("INI ERROR ASLINYA:", errorDetail);
                    }
                }
            });
        }

        let currentEditId = null; // Variabel global buat nyimpen ID yang lagi diedit

        function editBerita(id) {
            currentEditId = id;
            $.ajax({
                url: `/api/editor/manajemen_berita/ambilData`,
                type: 'GET',
                success: function(response) {
                    const berita = response.find(b => b.id === id);
                    if (berita) {
                        $('#inputJudul').val(berita.judul_berita);
                        $('#inputSlug').val(berita.slug);
                        $('#inputKonten').html(berita.isi_berita);
                        $('.select-kategori-ajax').val(berita.kategori_id);

                        if (berita.foto_thumbnail) {
                            $('#imgPreview').attr('src', `/uploads/thumbnail/${berita.foto_thumbnail}`).show();
                            $('.thumb-upload .ico, .thumb-upload p').hide();
                        }

                        // LOGIKA BARU: Jika status Rejected, munculin alert & matikan Draft
                        if (berita.status_berita === 'Rejected') {
                            $('#alertRejectBox').show();
                            $('#alertRejectText').text(berita.catatan_penolakan || 'Tidak ada catatan.');

                            $('#tglDraft').hide(); // Sembunyikan tombol draft
                            $('#tglPending').addClass('sel-pending'); // Paksa pilih "Kirim ke Redaksi"
                        } else {
                            $('#alertRejectBox').hide();
                            $('#tglDraft').show(); // Munculin lagi
                        }

                        document.getElementById('sectionTitle').textContent = 'Edit Berita';
                        document.getElementById('backButtonContainer').style.display = 'block';

                        // 1. Pindah halaman dulu (ini bakal ngeset title default "Tulis Berita")
                        showPage('write-news', null);

                        // ── 2. [BARU] OVERRIDE NAVBAR SESUAI JUDUL BERITA ──
                        document.getElementById('tbTitle').textContent = `Edit Berita - ${berita.judul_berita}`;
                        document.getElementById('tbCrumb').textContent = `Editor / Berita Saya / Edit Berita / ${berita.judul_berita}`;
                    }
                }
            });
        }

        function updateBerita(statusTujuan) {
            let formData = new FormData();
            formData.append('judul_berita', $('#inputJudul').val());
            formData.append('slug', $('#inputSlug').val());
            formData.append('kategori_id', $('.select-kategori-ajax').val());
            formData.append('isi_berita', $('#inputKonten').html());
            formData.append('status_berita', statusTujuan);

            // Thumbnail opsional saat update
            let foto = $('#inputFoto')[0].files[0];
            if (foto) {
                formData.append('foto_thumbnail', foto);
            }

            // Tambahkan method spoofing karena API lu pake POST tapi logikanya UPDATE
            // (Opsional, tergantung settingan Laravel lu, tapi biasanya aman dipasang)
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/api/editor/manajemen_berita/ubahData/${currentEditId}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Toast.show('success', "Data berita berhasil diperbarui.");

                    // ── KUNCI UTAMA DI SINI ──
                    resetFormBerita();
                    showPage('my-news', document.querySelectorAll('.s-item')[1]);

                    // Tarik ulang SEMUA data berita biar statusnya ter-update di tabel
                    loadDaftarBerita(true);
                },
                error: function(xhr) {
                    // Sekarang lu bisa baca errornya di sini
                    let err = xhr.responseJSON;
                    Toast.show('error', "Gagal: " + (err?.message || "Terjadi kesalahan server"));
                    console.log(err);
                }
            });
        }

        let idBeritaYangAkanDihapus = null; // Variabel global penampung ID

        function confirmDelete(id) {
            idBeritaYangAkanDihapus = id; // Simpan ID yang mau dihapus
            ModalManager.open('modalDelete');
        }

        function closeDelete() {
            ModalManager.close('modalDelete');
            idBeritaYangAkanDihapus = null;
        }

        function doDelete() {
            if (!idBeritaYangAkanDihapus) return;

            // Ubah teks tombol biar ada feedback loading
            const btnHapus = document.querySelector('#modalDelete .btn-red');
            const originalText = btnHapus.innerHTML;
            btnHapus.innerHTML = "Menghapus...";
            btnHapus.disabled = true;

            $.ajax({
                url: `/api/editor/manajemen_berita/hapusBerita/${idBeritaYangAkanDihapus}`,
                type: 'DELETE',
                success: function(response) {
                    Toast.show('success', response.message);
                    closeDelete(); // Tetep panggil ini buat reset ID-nya
                    loadDaftarBerita();
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled = false;
                },
                error: function(xhr) {
                    Toast.show('error', "Gagal menghapus: " + (xhr.responseJSON?.message ||
                        "Terjadi kesalahan server"));
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled = false;
                    closeDelete();
                }
            });
        }

        /* ── PAGE NAV ── */
        const pageTitles = {
            'write-news': ['Tulis Berita Baru', 'Editor / Tulis Berita Baru'],
            'my-news': ['Berita Saya', 'Editor / Berita Saya'],
        };

        function lihatAlasanTolak(alasan) {
            document.getElementById('teksAlasanTolak').textContent = alasan || 'Tidak ada catatan dari Redaksi.';
            ModalManager.open('modalAlasanTolak');
        }

        function showPage(id, el) {
            // 1. CEK: Kalau mau buka halaman tulis, tapi sedang mode EDIT
            if (id === 'write-news' && currentEditId !== null) {
                // Jika diklik dari SIDEBAR atau NAVtopbar (bukan dari tombol edit tabel)
                if (el !== null) {
                    Toast.show('warning', "Selesaikan atau batalkan editan berita lu dulu cuy!");
                    return; // Stop, jangan pindah halaman
                }
            }

            // 2. LOGIKA PINDAH HALAMAN SEPERTI BIASA
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            document.getElementById('page-' + id).classList.add('active');

            if (el) {
                document.querySelectorAll('.s-item').forEach(i => i.classList.remove('active'));
                el.classList.add('active');
            }

            // 3. UPDATE TITLE & BREADCRUMB
            const [title, crumb] = pageTitles[id] || ['—', '—'];
            document.getElementById('tbTitle').textContent = title;
            document.getElementById('tbCrumb').textContent = crumb;
        }

        function resetFormBerita() {
            currentEditId = null;
            $('#inputJudul').val('');
            $('#inputSlug').val('');
            $('#inputKonten').html('');

            // ── INI KUNCI FIX-NYA ──
            // Ganti $('.select-kategori-ajax') pakai atribut name biar spesifik ke form aja
            $('select[name="kategori_id"]').val('');

            $('#inputFoto').val('');
            $('#imgPreview').hide().attr('src', '');
            $('.thumb-upload .ico, .thumb-upload p').show();

            // KEMBALIKAN UI SEPERTI SEMULA
            $('#alertRejectBox').hide();
            $('#tglDraft').show();
            document.getElementById('sectionTitle').textContent = 'Tulis Berita Baru';
            document.getElementById('backButtonContainer').style.display = 'none';
            document.getElementById('tglDraft').className = 'tgl-opt sel-draft';
            document.getElementById('tglPending').className = 'tgl-opt';
        }

        /* ── STATUS TOGGLE (Write page) ── */
        function confirmStatus(v) {
            const d = document.getElementById('tglDraft');
            const p = document.getElementById('tglPending');

            if (v === 'draft') {
                d.className = 'tgl-opt sel-draft';
                p.className = 'tgl-opt';
                ModalManager.open('modalDraft');
            } else {
                d.className = 'tgl-opt';
                p.className = 'tgl-opt sel-pending';
                ModalManager.open('modalPending');
            }
        }

        function closeStatusModal(v) {
            const d = document.getElementById('tglDraft');
            const p = document.getElementById('tglPending');

            if (v === 'draft') {
                ModalManager.close('modalDraft');
                d.className = 'tgl-opt';
                p.className = 'tgl-opt sel-pending';
            } else {
                ModalManager.close('modalPending');
                d.className = 'tgl-opt sel-draft';
                p.className = 'tgl-opt';
            }
        }

        function applyStatus(v) {
            const status = (v === 'draft') ? 'Draft' : 'Pending';
            const modalId = (v === 'draft') ? 'modalDraft' : 'modalPending';

            // Tutup modal pakai manager
            ModalManager.close(modalId);

            if (currentEditId) {
                updateBerita(status);
            } else {
                simpanBerita(status);
            }
        }

        /* ── FILTER TABS & SEARCH LOGIC ── */
        let statusAktif = 'all'; // Cukup tulis 1 kali aja cuy

        function filterTab(el, status) {
            // Update visual tombol tab
            document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
            el.classList.add('active');

            statusAktif = status;
            jalankanFilter(); // Panggil fungsi utama
        }

        // Fungsi ini yang bakal ngasih instruksi ke DataEngine (Gue balikin namanya jadi jalankanFilter biar HTML lu ga error)
        function jalankanFilter() {
            let kategoriDipilih = document.getElementById('filterKategori').value;
            const urutanDipilih = document.getElementById('filterUrutan').value;
            const keyword = (document.getElementById('searchInput')?.value || '').toLowerCase();

            // KUNCI UTAMA: Kalau browser nge-glitch dan value-nya kosong, kita amankan ke 'all'
            if (!kategoriDipilih || kategoriDipilih === "") {
                kategoriDipilih = 'all';
                document.getElementById('filterKategori').value = 'all'; // Paksa UI balik normal
            }

            // Kasih tau engine cara nge-filter
            beritaTable.setFilterAndSearch((val) => {
                const cocokStatus = (statusAktif === 'all' || (val.status_berita || '').toLowerCase() === statusAktif);
                const kategoriBaris = val.kategori ? val.kategori.nama_kategori : 'Uncategorized';
                const cocokKategori = (kategoriDipilih === 'all' || kategoriBaris === kategoriDipilih);

                // Tambah pengaman buat val.judul_berita biar ga error undefined
                const cocokSearch = !keyword ||
                                    (val.judul_berita || '').toLowerCase().includes(keyword) ||
                                    (val.slug && val.slug.toLowerCase().includes(keyword));

                return cocokStatus && cocokKategori && cocokSearch;
            });

            // Kasih tau engine cara nge-sort
            beritaTable.setSort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);
                return (urutanDipilih === 'baru') ? dateB - dateA : dateA - dateB;
            });
        }
    </script>
@endsection
