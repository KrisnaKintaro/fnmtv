@extends('editor.editor_master')

@section('title', request()->has('id') ? 'Edit Berita' : 'Tambah Berita Baru')
@section('breadcrumb', request()->has('id') ? 'Editor / Edit Berita' : 'Editor / Tambah Berita Baru')

@section('css')
    <style>
        .rte-btn.active {
            background: #eef2ff;
            color: var(--blue);
            border: 1px solid var(--blue);
            border-radius: 4px;
        }
        .thumb-upload {
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }
        .thumb-upload.drag-over {
            border-color: var(--blue);
            background-color: #eef2ff;
            border-style: solid;
        }
    </style>
@endsection

@section('konten')
    <div id="page-write-news" class="page active">
        
        <div class="page-header" style="display: block; margin-bottom: 24px;">
            <div style="margin-bottom: 8px;">
                <a href="{{ url('/berita-saya') }}" class="btn btn-ghost btn-sm" style="text-decoration:none; padding-left:0; color:var(--text);">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align:middle; margin-right:4px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
            <div class="section-title" id="sectionTitle" style="margin: 0; font-size: 24px;">
                {{ request()->has('id') ? 'Edit Berita' : 'Tambah Berita Baru' }}
            </div>
        </div>

        <div class="form-grid">
            <div>
                <div class="form-card" style="margin-bottom:16px;">
                    <div class="form-title">Informasi Artikel</div>
                    
                    <div id="alertRejectBox" style="display:none; background:#fde8e8; border:1px solid #f5b8b8; padding:16px; border-radius:8px; margin-bottom:16px;">
                        <div style="font-weight:700; color:var(--red); margin-bottom:4px;">⚠️ Artikel ini dikembalikan oleh Redaksi</div>
                        <div style="font-size:13px; color:var(--text);"><strong>Alasan:</strong> <span id="alertRejectText"></span></div>
                    </div>

                    <div class="field">
                        <label>Judul Berita *</label>
                        <input type="text" id="inputJudul" name="judul_berita" placeholder="Masukkan judul berita yang menarik..." required>
                    </div>
                    <div class="field">
                        <label>Slug URL (Opsional)</label>
                        <input type="text" id="inputSlug" name="slug" placeholder="Otomatis dibuat jika dikosongkan" style="font-family:'JetBrains Mono',monospace;font-size:13px;">
                    </div>
                    <div class="field">
                        <label>Konten Berita *</label>
                        <div class="rte-mock">
                            <div class="rte-toolbar">
                                <button type="button" class="rte-btn rte-btn-bold" onclick="document.execCommand('bold', false, null)" title="Tebal"><b>B</b></button>
                                <button type="button" class="rte-btn rte-btn-italic" onclick="document.execCommand('italic', false, null)" title="Miring"><i>I</i></button>
                                <button type="button" class="rte-btn rte-btn-underline" onclick="document.execCommand('underline', false, null)" title="Garis Bawah"><u>U</u></button>
                                <div class="rte-sep"></div>
                                <button type="button" class="rte-btn rte-btn-h1" onclick="document.execCommand('formatBlock', false, 'H1')" title="Heading 1">H1</button>
                                <button type="button" class="rte-btn rte-btn-h2" onclick="document.execCommand('formatBlock', false, 'H2')" title="Heading 2">H2</button>
                                <button type="button" class="rte-btn rte-btn-h3" onclick="document.execCommand('formatBlock', false, 'H3')" title="Heading 3">H3</button>
                                <div class="rte-sep"></div>
                                <button type="button" class="rte-btn" onclick="document.execCommand('justifyLeft', false, null)" title="Rata Kiri">≡</button>
                                <button type="button" class="rte-btn" onclick="document.execCommand('justifyCenter', false, null)" title="Rata Tengah">≣</button>
                                <div class="rte-sep"></div>
                                <button type="button" class="rte-btn" onclick="let url = prompt('Masukkan Link URL:'); if(url) document.execCommand('createLink', false, url);" title="Tambah Link">🔗</button>
                            </div>
                            <div class="rte-body" id="inputKonten" contenteditable="true" required style="min-height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="form-card" style="margin-bottom:16px;">
                    <div class="form-title">Kategori</div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Pilih Kategori *</label>
                        <select id="select-kategori" name="kategori_id" style="font-size:12px;padding:6px 10px;">
                            <option value="">-- Memuat Kategori... --</option>
                        </select>
                    </div>
                </div>

                <div class="form-card" style="margin-bottom:16px;">
                    <div class="form-title">Thumbnail Berita</div>
                    <input type="file" id="inputFoto" name="foto_thumbnail" style="display:none;" accept="image/png, image/jpeg, image/jpg">

                    <div class="thumb-upload" onclick="document.getElementById('inputFoto').click()">
                        <div class="ico">🖼</div>
                        <p id="labelFoto"><span>Pilih file</span> atau seret ke sini</p>
                        <img id="imgPreview" style="display:none; width:100%; height:100%; object-fit:cover; border-radius:8px;">
                    </div>
                    <p style="font-size:11px;margin-top:4px;color:var(--muted);">JPG, PNG, JPEG · Maks. 2 MB</p>
                </div>

                <div class="form-card">
                    <div class="form-title">Status Pengiriman</div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Kirim sebagai</label>
                        <div class="toggle-group">
                            <div class="tgl-opt sel-draft" id="tglDraft" onclick="confirmStatus('draft')">Draft</div>
                            <div class="tgl-opt" id="tglPending" onclick="confirmStatus('pending')">Kirim ke Redaksi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalDraft" style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">📝</div>
            <div style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">Simpan sebagai Draft?</div>
            <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan disimpan sebagai draft dan hanya terlihat oleh Anda. Anda bisa mengedit dan mengirimnya kapan saja.</div>
            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('draft')">Batal</button>
                <button class="btn btn-ghost" style="flex:1;" onclick="applyStatus('draft')">Ya, Simpan</button>
            </div>
        </div>
    </div>

    <div id="modalPending" style="position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;display:none;align-items:center;justify-content:center;">
        <div style="background:var(--white);border-radius:12px;padding:32px;max-width:380px;width:90%;box-shadow:0 12px 40px rgba(0,0,0,.2);">
            <div style="font-size:32px;text-align:center;margin-bottom:12px;">📨</div>
            <div style="font-family:'Merriweather',serif;font-size:16px;font-weight:700;text-align:center;margin-bottom:8px;">Kirim ke Redaksi?</div>
            <div style="font-size:13px;color:var(--muted);text-align:center;margin-bottom:24px;">Artikel akan dikirim ke Redaksi untuk diverifikasi dan diterbitkan. Pastikan artikel sudah siap sebelum melanjutkan.</div>
            <div style="display:flex;gap:10px;">
                <button class="btn btn-outline" style="flex:1;" onclick="closeStatusModal('pending')">Batal</button>
                <button class="btn btn-blue" style="flex:1;" onclick="applyStatus('pending')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Ya, Kirim
                </button>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    let currentEditId = null; 

    $(document).ready(function() {
        // 1. Inisialisasi Kategori (Pakai API Publik Viewer)
        loadKategori();

        // 2. CEK MODE EDIT DARI URL (?id=...)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('id')) {
            currentEditId = urlParams.get('id');
            loadDataEdit(currentEditId);
        }

        // 3. Logika Preview Foto Thumbnail
        $('#inputFoto').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview').attr('src', e.target.result).show();
                    $('.thumb-upload .ico, .thumb-upload p').hide();
                }
                reader.readAsDataURL(file);
            }
        });

        // 4. Aktifkan Fitur DropZone Helper (Jika ada class/scriptnya)
        if(typeof ImageDropZone !== 'undefined') {
            new ImageDropZone({
                dropZoneSelector: '.thumb-upload',
                inputSelector: '#inputFoto',
                previewSelector: '#imgPreview',
                uiToHideSelector: '.thumb-upload .ico, .thumb-upload p'
            });
        }
    });

    // ── FUNGSI LOAD DATA KATEGORI ──
    function loadKategori() {
        // PERBAIKAN: Gunakan API Viewer agar bebas dari 403 Forbidden Editor
        $.ajax({
            url: '/api/viewers/kategori',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let options = '<option value="">-- Pilih Kategori --</option>';
                    $.each(response.data, function(key, val) {
                        options += `<option value="${val.id}">${val.nama_kategori}</option>`;
                    });
                    $('#select-kategori').html(options);
                }
            },
            error: function() {
                console.error('Gagal memuat kategori.');
                $('#select-kategori').html('<option value="">Gagal memuat data</option>');
            }
        });
    }

    // ── FUNGSI LOAD DATA EDIT (Jika Mode Edit) ──
    function loadDataEdit(id) {
        $.ajax({
            url: `/api/editor/manajemen_berita/ambilData`,
            type: 'GET',
            success: function(response) {
                const berita = response.find(b => b.id == id);
                if (berita) {
                    $('#inputJudul').val(berita.judul_berita);
                    $('#inputSlug').val(berita.slug);
                    $('#inputKonten').html(berita.isi_berita);
                    
                    // Delay dikit supaya nunggu dropdown kategori kelar di-render
                    setTimeout(() => { $('#select-kategori').val(berita.kategori_id); }, 500);

                    // Set Foto (Jika ada)
                    if (berita.foto_thumbnail) {
                        $('#imgPreview').attr('src', `/uploads/thumbnail/${berita.foto_thumbnail}`).show();
                        $('.thumb-upload .ico, .thumb-upload p').hide();
                    }

                    // Tampilkan pesan alasan ditolak (jika statusnya rejected)
                    if (berita.status_berita === 'Rejected') {
                        $('#alertRejectBox').show();
                        $('#alertRejectText').text(berita.catatan_penolakan || 'Tidak ada catatan.');
                        
                        $('#tglDraft').hide(); // Sembunyikan tombol draft biar fokus disuruh kirim ulang ke Redaksi
                        $('#tglPending').addClass('sel-pending');
                    }
                } else {
                    Toast.show('error', 'Data berita tidak ditemukan cuy!');
                }
            }
        });
    }

    // ── FUNGSI SIMPAN BARU ATAU UPDATE ──
    function applyStatus(v) {
        const statusTujuan = (v === 'draft') ? 'Draft' : 'Pending';
        closeStatusModal(v);

        // Validasi Manual Ringan
        if(!$('#inputJudul').val() || !$('#select-kategori').val() || !$('#inputKonten').html().trim()) {
            Toast.show('warning', 'Judul, Kategori, dan Konten wajib diisi!');
            return;
        }

        let formData = new FormData();
        formData.append('judul_berita', $('#inputJudul').val());
        formData.append('slug', $('#inputSlug').val());
        formData.append('kategori_id', $('#select-kategori').val());
        formData.append('isi_berita', $('#inputKonten').html());
        formData.append('status_berita', statusTujuan);

        let foto = $('#inputFoto')[0].files[0];
        if (foto) formData.append('foto_thumbnail', foto);

        // Penentuan API Endpoint: Kondisional Tambah Baru atau Update
        let apiUrl = '/api/editor/manajemen_berita/tambahData';
        if (currentEditId) {
            apiUrl = `/api/editor/manajemen_berita/ubahData/${currentEditId}`;
            formData.append('_method', 'PUT'); // Trick Spoofing Laravel untuk file upload PUT
        }

        $.ajax({
            url: apiUrl,
            type: 'POST', // Walau Update, tetap pakai POST tapi ditumpangi _method PUT
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Toast.show('success', "Berita berhasil " + (currentEditId ? "diperbarui!" : "disimpan!"));
                
                // Lempar kembali ke halaman list berita-saya
                setTimeout(() => {
                    window.location.href = '/berita-saya';
                }, 1000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "";
                    $.each(errors, function(key, value) { errorMessage += value[0] + "\n"; });
                    Toast.show('warning', errorMessage.trim());
                } else {
                    Toast.show('error', "Gagal memproses data: " + (xhr.responseJSON?.message || "Error 500"));
                }
            }
        });
    }

    // ── MODAL TOGGLE & UI STATUS ──
    function confirmStatus(v) {
        const draftBtn = document.getElementById('tglDraft');
        const pendingBtn = document.getElementById('tglPending');

        if (v === 'draft') {
            draftBtn.classList.add('sel-draft');
            pendingBtn.classList.remove('sel-pending');
            ModalManager.open('modalDraft');
        } else {
            pendingBtn.classList.add('sel-pending');
            draftBtn.classList.remove('sel-draft');
            ModalManager.open('modalPending');
        }
    }

    function closeStatusModal(v) {
        if (v === 'draft') {
            ModalManager.close('modalDraft');
            document.getElementById('tglDraft').classList.remove('sel-draft');
            if(!$('#alertRejectBox').is(':visible')) document.getElementById('tglPending').classList.add('sel-pending');
        } else {
            ModalManager.close('modalPending');
            if(!$('#alertRejectBox').is(':visible')) document.getElementById('tglDraft').classList.add('sel-draft');
            document.getElementById('tglPending').classList.remove('sel-pending');
        }
    }
</script>
@endsection