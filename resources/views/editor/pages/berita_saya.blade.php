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
                                <button class="rte-btn" onclick="execCmd('bold')" title="Tebal (Ctrl+B)"><b>B</b></button>
                                <button class="rte-btn" onclick="execCmd('italic')"
                                    title="Miring (Ctrl+I)"><i>I</i></button>
                                <button class="rte-btn" onclick="execCmd('underline')"
                                    title="Garis Bawah (Ctrl+U)"><u>U</u></button>
                                <div class="rte-sep"></div>
                                <button class="rte-btn" onclick="execCmd('formatBlock', 'h1')" title="Heading 1">H1</button>
                                <button class="rte-btn" onclick="execCmd('formatBlock', 'h2')" title="Heading 2">H2</button>
                                <button class="rte-btn" onclick="execCmd('formatBlock', 'h3')" title="Heading 3">H3</button>
                                <div class="rte-sep"></div>
                                <button class="rte-btn" onclick="execCmd('justifyLeft')" title="Rata Kiri">≡</button>
                                <button class="rte-btn" onclick="execCmd('justifyCenter')" title="Rata Tengah">≣</button>
                                <button class="rte-btn" onclick="execCmd('insertUnorderedList')"
                                    title="Daftar Simbol">⊶</button>
                                <div class="rte-sep"></div>
                                <button class="rte-btn" onclick="execLink()" title="Tambah Link">🔗</button>
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
                    <input type="file" id="inputFoto" name="foto_thumbnail" style="display:none;"
                        onchange="previewFoto(this)">

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
                <div class="card-hm" id="tableCount">Menampilkan 9 artikel</div>
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
                <div class="pg-btn active">1</div>
                <div class="pg-info">Menampilkan 9 dari 9 artikel</div>
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
@endsection
@section('js')
    <script>
        let isEditingFromTable = false;

        $(document).ready(function() {
            // Jalankan fungsi saat halaman pertama kali dimuat
            loadKategori();
            loadDaftarBerita();
            loadStatistik();
        });

        let dataBeritaMaster = []; // Penampung semua data dari API
        let currentPage = 1;
        const perPage = 10; // Sesuai request lu: 10 berita per halaman

        function loadKategori() {
            $.ajax({
                url: '/api/admin/manajemen_kategori/ambilData', // URL sesuai API lu
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Cek apakah status dari Controller bernilai 'success'
                    if (response.status === 'success') {
                        let optionsForm = '<option value="">-- Pilih Kategori --</option>';
                        let optionsFilter = '<option value="all">Semua Kategori</option>';

                        // Alur Looping: Mengubah Array Data menjadi tag <option>
                        $.each(response.data, function(key, val) {
                            // val.id_kategori dan val.nama_kategori diambil dari respons API
                            optionsForm +=
                                `<option value="${val.id}">${val.nama_kategori}</option>`;
                            optionsFilter +=
                                `<option value="${val.nama_kategori}">${val.nama_kategori}</option>`;
                        });

                        // Masukkan hasil looping ke semua elemen dengan class tersebut
                        $('.select-kategori-ajax').each(function() {
                            // Jika elemen ini adalah filter, kasih optionsFilter (ada pilihan 'all')
                            if ($(this).attr('id') === 'filterKategori') {
                                $(this).html(optionsFilter);
                            } else {
                                // Jika untuk form tulis, kasih optionsForm
                                $(this).html(optionsForm);
                            }
                        });
                    }
                },
                error: function(xhr) {
                    console.error("Gagal memuat kategori cuy!");
                }
            });
        }

        function loadStatistik() {
            $.ajax({
                url: '/api/editor/manajemen_berita/ambilData',
                type: 'GET',
                success: function(response) {
                    const all = response.length;
                    const draft = response.filter(b => b.status_berita === 'Draft').length;
                    const pending = response.filter(b => b.status_berita === 'Pending').length;
                    const rejected = response.filter(b => b.status_berita === 'Rejected').length;

                    $('.s-badge').text(all);
                    // Targetkan span di dalam tab-pills
                    const tabs = $('#tabPills .tab-p span');
                    $(tabs[0]).text(all);
                    $(tabs[1]).text(draft);
                    $(tabs[2]).text(pending);
                    $(tabs[3]).text(rejected);
                }
            });
        }

        function loadDaftarBerita() {
            $.ajax({
                url: '/api/editor/manajemen_berita/ambilData',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    dataBeritaMaster = response; // Simpan data asli dari server
                    jalankanFilter(); // Langsung filter & render
                    loadStatistik(); // Update angka-angka di tab & sidebar
                },
                error: function() {
                    console.error("Gagal mengambil daftar berita cuy!");
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
                        alert(response.message);
                        location.reload(); // Refresh buat liat hasil di tabel
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
                        alert(errorMessage);
                    } else if (xhr.status === 419) {
                        alert("CSRF Token ilang cuy, coba refresh halaman!");
                    } else {
                        alert("Error " + xhr.status + ": Ada masalah di server!");
                    }
                }
            });
        }

        let currentEditId = null; // Variabel global buat nyimpen ID yang lagi diedit

        function editBerita(id) {
            currentEditId = id; // Simpan ID berita

            $.ajax({
                url: `/api/editor/manajemen_berita/ambilData`, // Kita pake API ambil data yang udah ada
                type: 'GET',
                success: function(response) {
                    // Cari data berita yang ID-nya cocok
                    const berita = response.find(b => b.id === id);

                    if (berita) {
                        // 1. Masukkan data ke inputan form
                        $('#inputJudul').val(berita.judul_berita);
                        $('#inputSlug').val(berita.slug);
                        $('#inputKonten').html(berita.isi_berita);
                        $('.select-kategori-ajax').val(berita.kategori_id);

                        // 2. Tampilkan preview foto lama
                        if (berita.foto_thumbnail) {
                            $('#imgPreview').attr('src', `/uploads/thumbnail/${berita.foto_thumbnail}`).show();
                            $('.thumb-upload .ico, .thumb-upload p').hide();
                        }

                        // 3. Ubah UI jadi mode Edit
                        document.getElementById('sectionTitle').textContent = 'Edit Berita';
                        document.getElementById('backButtonContainer').style.display = 'block';

                        // 4. Pindah ke halaman tulis
                        showPage('write-news', null);
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
                    alert("Data berita berhasil diperbarui.");
                    location.reload();
                },
                error: function(xhr) {
                    // Sekarang lu bisa baca errornya di sini
                    let err = xhr.responseJSON;
                    alert("Gagal: " + (err.message || "Terjadi kesalahan"));
                    console.log(err);
                }
            });
        }

        let idBeritaYangAkanDihapus = null; // Variabel global penampung ID

        function confirmDelete(id) {
            idBeritaYangAkanDihapus = id; // Simpan ID yang mau dihapus
            document.getElementById('modalDelete').style.display = 'flex';
        }

        function closeDelete() {
            document.getElementById('modalDelete').style.display = 'none';
            idBeritaYangAkanDihapus = null; // Reset ID
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
                    alert(response.message);
                    closeDelete();
                    loadDaftarBerita(); // Refresh tabel biar data hilang
                    // Reset state tombol
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled = false;
                },
                error: function(xhr) {
                    alert("Gagal menghapus: " + (xhr.responseJSON.message || "Terjadi kesalahan server"));
                    btnHapus.innerHTML = originalText;
                    btnHapus.disabled = false;
                    closeDelete();
                }
            });
        }

        // Fungsi utama eksekusi
        function execCmd(command, value = null) {
            document.execCommand(command, false, value);
            document.getElementById('inputKonten').focus();
            updateToolbarState(); // Cek status tombol setelah klik
        }

        // Fungsi memantau status tombol (Bold, Italic, Underline)
        function updateToolbarState() {
            const commands = ['bold', 'italic', 'underline'];
            const buttons = document.querySelectorAll('.rte-btn');

            commands.forEach((cmd, index) => {
                // queryCommandState mengecek apakah format aktif di posisi kursor
                if (document.queryCommandState(cmd)) {
                    buttons[index].classList.add('active');
                } else {
                    buttons[index].classList.remove('active');
                }
            });
        }

        // Jalankan updateToolbarState saat user klik atau ketik di area konten
        document.getElementById('inputKonten').addEventListener('keyup', updateToolbarState);
        document.getElementById('inputKonten').addEventListener('mouseup', updateToolbarState);
        document.getElementById('inputKonten').addEventListener('click', updateToolbarState);

        // Fungsi Link tetap sama
        function execLink() {
            const url = prompt("Masukkan URL link:", "https://");
            if (url) {
                document.execCommand('createLink', false, url);
                updateToolbarState();
            }
        }

        // Opsional: Biar pas di-paste teksnya gak bawa format aneh dari luar (Keep Text Only)
        document.getElementById('inputKonten').addEventListener('paste', function(e) {
            e.preventDefault();
            const text = e.clipboardData.getData('text/plain');
            document.execCommand('insertText', false, text);
        });

        /* ── PAGE NAV ── */
        const pageTitles = {
            'write-news': ['Tulis Berita Baru', 'Editor / Berita / Tulis'],
            'my-news': ['Berita Saya', 'Editor / Berita Saya'],
        };

        function showPage(id, el) {
            // 1. CEK: Kalau mau buka halaman tulis, tapi sedang mode EDIT
            if (id === 'write-news' && currentEditId !== null) {
                // Jika diklik dari SIDEBAR atau NAVtopbar (bukan dari tombol edit tabel)
                if (el !== null) {
                    alert("Selesaikan atau batalkan editan berita lu dulu cuy!");
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
            currentEditId = null; // Penting: Balikin ke mode Tambah Baru

            // Reset semua inputan teks
            $('#inputJudul').val('');
            $('#inputSlug').val('');
            $('#inputKonten').html('');
            $('.select-kategori-ajax').val('');

            // Reset Preview Foto
            $('#inputFoto').val(''); // Kosongkan file input
            $('#imgPreview').hide().attr('src', '');
            $('.thumb-upload .ico, .thumb-upload p').show();

            // Reset UI Header
            document.getElementById('sectionTitle').textContent = 'Tulis Berita Baru';
            document.getElementById('backButtonContainer').style.display = 'none';

            // Balikin toggle ke Draft sebagai default
            document.getElementById('tglDraft').className = 'tgl-opt sel-draft';
            document.getElementById('tglPending').className = 'tgl-opt';
        }

        function previewFoto(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview').attr('src', e.target.result).show();
                    $('.thumb-upload .ico, .thumb-upload p').hide();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        /* ── STATUS TOGGLE (Write page) ── */
        function confirmStatus(v) {
            const d = document.getElementById('tglDraft');
            const p = document.getElementById('tglPending');
            // Ubah warna tombol langsung dulu
            if (v === 'draft') {
                d.className = 'tgl-opt sel-draft';
                p.className = 'tgl-opt';
                document.getElementById('modalDraft').style.display = 'flex';
            } else {
                d.className = 'tgl-opt';
                p.className = 'tgl-opt sel-pending';
                document.getElementById('modalPending').style.display = 'flex';
            }
        }

        function closeStatusModal(v) {
            const d = document.getElementById('tglDraft');
            const p = document.getElementById('tglPending');
            // Batal: kembalikan visual ke posisi sebelumnya
            if (v === 'draft') {
                document.getElementById('modalDraft').style.display = 'none';
                d.className = 'tgl-opt';
                p.className = 'tgl-opt sel-pending';
            } else {
                document.getElementById('modalPending').style.display = 'none';
                d.className = 'tgl-opt sel-draft';
                p.className = 'tgl-opt';
            }
        }

        function applyStatus(v) {
            const status = (v === 'draft') ? 'Draft' : 'Pending';
            const modalId = (v === 'draft') ? 'modalDraft' : 'modalPending';

            // Tutup modalnya dulu
            document.getElementById(modalId).style.display = 'none';

            // CEK DISINI: Kalau currentEditId ada isinya, berarti lagi mode EDIT
            if (currentEditId) {
                updateBerita(status);
            } else {
                // Kalau kosong, berarti lagi mode TULIS BARU
                simpanBerita(status);
            }
        }

        /* ── FILTER TABS ── */
        let statusAktif = 'all'; // Variabel global buat nyimpen status tab

        function filterTab(el, status) {
            // Update visual tombol tab
            document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
            el.classList.add('active');

            // Simpan status yang diklik ke variabel global
            statusAktif = status;

            // Jalankan filter gabungan
            jalankanFilter();
        }

        function jalankanFilter() {
            const kategoriDipilih = document.getElementById('filterKategori').value;
            const urutanDipilih = document.getElementById('filterUrutan').value;

            // 1. FILTERING DATA
            let dataTerfilter = dataBeritaMaster.filter(val => {
                const cocokStatus = (statusAktif === 'all' || val.status_berita.toLowerCase() === statusAktif);
                const kategoriBaris = val.kategori ? val.kategori.nama_kategori : 'Uncategorized';
                const cocokKategori = (kategoriDipilih === 'all' || kategoriBaris === kategoriDipilih);
                return cocokStatus && cocokKategori;
            });

            // 2. SORTING DATA
            dataTerfilter.sort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);
                return (urutanDipilih === 'baru') ? dateB - dateA : dateA - dateB;
            });

            // 3. RENDER TABEL & PAGINATION
            renderTable(dataTerfilter);
        }

        function renderTable(data) {
            const tbody = $('#newsBody');
            const total = data.length;

            // Potong data buat halaman saat ini (Client-side Pagination)
            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const paginatedData = data.slice(start, end);

            let rows = '';
            $.each(paginatedData, function(key, val) {
                let badgeClass = val.status_berita.toLowerCase() === 'draft' ? 'b-draft' :
                    val.status_berita.toLowerCase() === 'pending' ? 'b-review' : 'b-reject';

                rows += `
        <tr>
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
                    ${val.status_berita !== 'Pending' ? `<div class="ico-btn" onclick="editBerita(${val.id})">✏️</div>` : `<div class="ico-btn" style="opacity:.4;cursor:not-allowed;">✏️</div>`}
                    ${val.status_berita !== 'Pending' ? `<div class="ico-btn" onclick="confirmDelete(${val.id})">🗑</div>` : `<div class="ico-btn" style="opacity:.4;cursor:not-allowed;">🗑</div>`}
                </div>
            </td>
        </tr>`;
            });

            tbody.html(rows ||
                '<tr><td colspan="6" style="text-align:center;padding:20px;">Data tidak ditemukan cuy.</td></tr>');

            // Update Info & Tombol Pagination
            document.getElementById('tableCount').textContent = `Menampilkan ${paginatedData.length} dari ${total} artikel`;
            renderPaginationControls(total);
        }

        function renderPaginationControls(totalData) {
            const totalPages = Math.ceil(totalData / perPage);
            let html = '';

            for (let i = 1; i <= totalPages; i++) {
                html += `<div class="pg-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</div>`;
            }

            $('.pager').html(html || '');
        }

        function changePage(page) {
            currentPage = page;
            jalankanFilter(); // Render ulang setelah ganti halaman
        }

        function filterTab(el, status) {
            document.querySelectorAll('#tabPills .tab-p').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            statusAktif = status;

            currentPage = 1; // RESET KE HALAMAN 1
            jalankanFilter();
        }

        /* ── NOTIF ── */
        function toggleNotif() {
            document.getElementById('notifPanel').classList.toggle('open');
        }
        document.addEventListener('click', e => {
            if (!e.target.closest('.tb-icon') && !e.target.closest('.notif-panel'))
                document.getElementById('notifPanel').classList.remove('open');
        });
    </script>
@endsection
