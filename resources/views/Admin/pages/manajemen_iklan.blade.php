@extends('Admin.master_admin')

@section('css')
<style>
    .partnership-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .partnership-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    .partnership-table th,
    .partnership-table td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    .partnership-table thead tr {
        text-align: left;
        background: #f9f9f9;
        border-bottom: 1px solid var(--border);
    }

    .partnership-table tbody tr {
        border-bottom: 1px solid #eee;
    }

    .highlight-thumb {
        width: 15%;
        min-width: 100px;
    }

    .highlight-thumb img {
        width: 100%;
        max-width: 120px;
        height: auto;
        aspect-ratio: 16/9;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        display: block;
    }

    .highlight-thumb .no-preview {
        display: none;
        width: 100%;
        max-width: 120px;
        aspect-ratio: 16/9;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #f3f4f6;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #9ca3af;
    }

    .upload-area {
        cursor: pointer;
        width: 100%;
        min-height: 130px;
        border: 1px dashed #d6d3d1;
        border-radius: 16px;
        background: #fbfaf8;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px 16px;
        color: #6b7280;
        box-sizing: border-box;
        transition: border-color .2s ease, background .2s ease;
    }

    .upload-area-content {
        width: 100%;
        pointer-events: none;
    }

    .special-announcement-modal {
        width: 90%;
        max-width: 600px;
        padding: 28px;
        max-height: calc(100vh - 80px);
        overflow-y: auto;
        box-sizing: border-box;
    }

    .placement-badge {
        background: #eef2ff;
        color: #4338ca;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .visibility-toggle {
        border: none;
        background: none;
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
    }

    .remove-entry {
        color: var(--red);
        border: none;
        background: none;
        cursor: pointer;
        font-size: 16px;
        padding: 4px 8px;
    }

    @media (max-width: 768px) {
        .partnership-table th,
        .partnership-table td {
            padding: 10px 12px;
            font-size: 13px;
        }

        .highlight-thumb img,
        .highlight-thumb .no-preview {
            max-width: 90px;
        }

        .special-announcement-modal {
            width: 95%;
            padding: 20px;
        }

        .placement-badge {
            font-size: 11px;
            padding: 4px 8px;
        }
    }

    @media (max-width: 480px) {
        .partnership-table th,
        .partnership-table td {
            padding: 8px 10px;
            font-size: 12px;
        }

        .highlight-thumb {
            min-width: 70px;
        }

        .highlight-thumb img,
        .highlight-thumb .no-preview {
            max-width: 70px;
        }

        .special-announcement-modal {
            width: 100%;
            padding: 16px;
            border-radius: 12px 12px 0 0;
        }

        .placement-badge {
            font-size: 10px;
            padding: 3px 6px;
        }

        .visibility-toggle {
            font-size: 12px;
            padding: 4px 6px;
        }
    }
</style>
@endsection

@section('konten')
<div class="content-body">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 class="section-title">Manajemen Iklan</h2>
        </div>
        <button onclick="ModalManager.open('modalContentModule')" class="btn-primary" style="padding: 10px 20px; border-radius: 8px; background: var(--red); color: white; border: none; font-weight: 600; cursor: pointer;">
            <i class="fas fa-plus" style="margin-right: 8px;"></i> Tambah Iklan
        </button>
    </div>

    <div class="card" style="background: white; border-radius: 12px; border: 1px solid var(--border); overflow: hidden;">
        <div class="partnership-wrap">
            <table class="partnership-table" id="contentModuleTable">
                <thead>
                    <tr>
                        <th>Pratinjau</th>
                        <th>Informasi</th>
                        <th>Penempatan</th>
                        <th>Visibilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="contentModuleList"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div id="modalContentModule" class="modal-backdrop">
    <div class="modal special-announcement-modal">
        <h3 class="modal-title" style="margin-bottom: 20px;" id="modalTitle">Tambah Konten Baru</h3>
        <form id="formContentModule" enctype="multipart/form-data">
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul</label>
                <input type="text" name="judul" class="form-control" placeholder="Contoh: Promo Ramadhan" required
                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border); box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Pilih Penempatan</label>
                <select name="posisi" class="form-control" required
                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border); box-sizing: border-box;">
                    <option value="horizontal_728x90">Tengah Artikel (728x90 px)</option>
                    <option value="sidebar_300x250">Sidebar Kanan (300x250 px)</option>
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tanggal Mulai Tayang <span style="color: var(--red);">*</span></label>
                <input type="date" name="tanggal_mulai" class="form-control" required
                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border); box-sizing: border-box;">
                <small style="color: var(--muted);">Tanggal wajib diisi.</small>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tanggal Berhenti Tayang <span style="color: var(--red);">*</span></label>
                <input type="date" name="tanggal_selesai" class="form-control" required
                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border); box-sizing: border-box;">
                <small style="color: var(--muted);">Harus lebih besar atau sama dengan tanggal mulai.</small>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Unggah Gambar <span id="gambarRequired" style="color: var(--red);">*</span></label>
                <input type="file" id="moduleImageInput" name="gambar" accept="image/png, image/jpeg, image/jpg" style="display:none;">
                <div id="moduleUploadArea" class="upload-area">
                    <div id="moduleUploadContent" class="upload-area-content">
                        <div style="font-size: 28px; margin-bottom: 10px;">📁</div>
                        <div style="font-weight: 600; font-size: 15px;">Klik atau seret file ke sini</div>
                        <div style="margin-top: 8px; font-size: 13px; color: #6b7280;">Format: JPG, PNG. Maks 2MB.</div>
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tautan Tujuan (Opsional)</label>
                <input type="url" name="link_tujuan" class="form-control" placeholder="https://example.com"
                    style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border); box-sizing: border-box;">
            </div>
            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="button" onclick="ModalManager.close('modalContentModule'); resetFormModule();" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--border); background: white;">Batal</button>
                <button type="submit" style="flex: 1; padding: 12px; border-radius: 8px; background: var(--red); color: white; border: none; font-weight: 600;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal-backdrop" id="modalRemoveConfirm" style="display:none;">
    <div class="modal" style="max-width:380px; text-align:center; padding:30px;">
        <div style="font-size:40px; margin-bottom:10px;">🗑️</div>
        <h3 style="font-family: 'Merriweather', serif; margin-bottom:10px;">Hapus Konten?</h3>
        <p style="font-size:13px; color:var(--muted); margin-bottom:24px;">Konten yang dihapus tidak bisa dikembalikan.</p>
        <div style="display:flex; gap:10px;">
            <button class="btn btn-outline" style="flex:1; justify-content:center;" onclick="ModalManager.close('modalRemoveConfirm')">Batal</button>
            <button class="btn btn-red" style="flex:1; justify-content:center;" onclick="executeRemoveEntry()">Ya, Hapus</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function labelPenempatan(posisi) {
        var map = {
            'horizontal_728x90': 'Tengah Artikel (728x90)',
            'sidebar_300x250': 'Sidebar Kanan (300x250)'
        };
        return map[posisi] || posisi.replace(/_/g, ' ');
    }

    function formatTanggal(dateString) {
        if (!dateString) return '-';
        var date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    var pendingRemoveId = null;
    var editingEntryId = null;

    // Define functions outside of document.ready for global accessibility
    function resetFormModule() {
        $('#formContentModule')[0].reset();
        resetUploadArea();
        $('#moduleImageInput').val('');
        $('#modalTitle').text('Tambah Konten Baru');
        editingEntryId = null;
    }

    function resetUploadArea() {
        $('#moduleUploadContent').html(
            '<div style="font-size: 28px; margin-bottom: 10px;">📁</div>' +
            '<div style="font-weight: 600; font-size: 15px;">Klik atau seret file ke sini</div>' +
            '<div style="margin-top: 8px; font-size: 13px; color: #6b7280;">Format: JPG, PNG. Maks 2MB.</div>'
        );
    }

    $(document).ready(function() {
        setTopbarTitle();
        loadContentModule();

        $('#formContentModule').on('submit', function(e) {
            e.preventDefault();
            
            // Validasi gambar (wajib untuk tambah, opsional untuk edit)
            if (!editingEntryId && $('#moduleImageInput')[0].files.length === 0) {
                Toast.show('error', '❌ Gambar wajib diupload untuk konten baru');
                return;
            }
            
            // Validasi tanggal
            var tanggalMulai = new Date($('input[name="tanggal_mulai"]').val());
            var tanggalSelesai = new Date($('input[name="tanggal_selesai"]').val());
            
            if (tanggalMulai > tanggalSelesai) {
                Toast.show('error', '❌ Tanggal berhenti tidak boleh kurang dari tanggal mulai');
                return;
            }
            
            var formData = new FormData(this);
            var url = editingEntryId 
                ? '/api/admin/manajemen_iklan/ubahData/' + editingEntryId
                : '/api/admin/manajemen_iklan/tambahData';
            var method = editingEntryId ? 'POST' : 'POST';
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    ModalManager.close('modalContentModule');
                    Toast.show('success', res.message || 'Berhasil disimpan!');
                    loadContentModule();
                    resetFormModule();
                    editingEntryId = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error, xhr.responseText);
                    var errMsg = 'Gagal menyimpan data';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Toast.show('error', errMsg);
                }
            });
        });

        var uploadArea = $('#moduleUploadArea');
        var fileInput = $('#moduleImageInput');

        uploadArea.on('click', function() {
            fileInput.trigger('click');
        });

        uploadArea.on('dragenter dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.css({ borderColor: '#9ca3af', background: '#f4f4f5' });
        });

        uploadArea.on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.css({ borderColor: '#d6d3d1', background: '#fbfaf8' });
        });

        uploadArea.on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.css({ borderColor: '#d6d3d1', background: '#fbfaf8' });
            var files = e.originalEvent.dataTransfer.files;
            if (files && files.length) {
                var dt = new DataTransfer();
                for (var i = 0; i < files.length; i++) {
                    dt.items.add(files[i]);
                }
                fileInput[0].files = dt.files;
                updateUploadAreaText();
            }
        });

        fileInput.on('change', updateUploadAreaText);
    });

    function updateUploadAreaText() {
        var file = $('#moduleImageInput')[0].files[0];
        if (file) {
            $('#moduleUploadContent').html(
                '<div style="font-size: 28px; margin-bottom: 10px;">✅</div>' +
                '<div style="font-weight: 600; font-size: 15px;">' + file.name + '</div>' +
                '<div style="margin-top: 8px; font-size: 13px; color: #6b7280;">Klik untuk mengganti file</div>'
            );
        } else {
            resetUploadArea();
        }
    }

    function setTopbarTitle() {
        var titleElement = document.getElementById('tbTitle');
        var crumbElement = document.getElementById('tbCrumb');
        if (titleElement) titleElement.textContent = 'Manajemen Iklan';
        if (crumbElement) crumbElement.textContent = 'Admin / Manajemen Iklan';
    }

    function loadContentModule() {
        $.ajax({
            url: '/api/admin/manajemen_iklan/ambilData',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var html = '';
                if (!data || data.length === 0) {
                    html = '<tr><td colspan="5" style="padding: 20px; text-align: center; color: var(--muted);">Belum ada konten. Tambahkan konten baru untuk memulai.</td></tr>';
                } else {
                    $.each(data, function(i, item) {
                        var visIcon = item.is_active ? '🟢' : '🔴';
                        var visText = item.is_active ? 'Aktif' : 'Nonaktif';

                        var infoHtml = '<div style="font-weight: 700;">' + item.judul + '</div>'
                            + '<div style="font-size: 12px; color: var(--muted);">Oleh: ' + (item.user ? item.user.username : 'System') + '</div>';
                        if (item.link_tujuan) {
                            infoHtml += '<div style="font-size: 12px; margin-top: 4px;">'
                                + '<a href="' + item.link_tujuan + '" target="_blank" style="color: var(--blue); text-decoration: none;">' + item.link_tujuan + '</a>'
                                + '</div>';
                        }
                        if (item.tanggal_mulai) {
                            infoHtml += '<div style="font-size: 12px; color: var(--muted); margin-top: 4px;">Mulai: ' + formatTanggal(item.tanggal_mulai) + '</div>';
                        }
                        if (item.tanggal_selesai) {
                            infoHtml += '<div style="font-size: 12px; color: var(--muted); margin-top: 4px;">Habis: ' + formatTanggal(item.tanggal_selesai) + '</div>';
                        }

                        html += '<tr>';

                        html += '<td class="highlight-thumb">';
                        html += '<img src="/storage/' + item.gambar + '"'
                            + ' onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';">';
                        html += '<div class="no-preview">No Image</div>';
                        html += '</td>';

                        html += '<td style="padding: 14px 16px;">' + infoHtml + '</td>';

                        html += '<td style="padding: 14px 16px;">';
                        html += '<span class="placement-badge">' + labelPenempatan(item.posisi) + '</span>';
                        html += '</td>';

                        html += '<td style="padding: 14px 16px;">';
                        html += '<button onclick="toggleVisibility(' + item.id + ')" class="visibility-toggle">';
                        html += visIcon + ' ' + visText;
                        html += '</button>';
                        html += '</td>';

                        html += '<td style="padding: 14px 16px;">';                       
                        html += '<button onclick="editEntry(' + item.id + ')" class="remove-entry" title="Edit" style="color: var(--text);">✏️</button>';
                        html += '<button onclick="removeEntry(' + item.id + ')" class="remove-entry" title="Hapus">🗑️</button>';
                        html += '</td>';

                        html += '</tr>';
                    });
                }
                $('#contentModuleList').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error, xhr.responseText);
                $('#contentModuleList').html('<tr><td colspan="5" style="padding: 20px; text-align: center; color: var(--red);">Gagal memuat data.</td></tr>');
            }
        });
    }

    function toggleVisibility(id) {
        $.ajax({
            url: '/api/admin/manajemen_iklan/ubahStatus/' + id,
            type: 'PATCH',
            success: function(res) {
                Toast.show('success', 'Status diperbarui');
                loadContentModule();
            },
            error: function(err) {
                Toast.show('error', 'Gagal mengubah status');
                console.error('Error:', err);
            }
        });
    }

    function editEntry(id) {
        $.ajax({
            url: '/api/admin/manajemen_iklan/ambilData',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var item = data.find(d => d.id == id);
                if (item) {
                    editingEntryId = id;
                    $('#modalTitle').text('Edit Konten');
                    $('input[name="judul"]').val(item.judul);
                    $('select[name="posisi"]').val(item.posisi);
                    function toInputDate(val) {
                        if (!val) return '';
                        return val.split('T')[0].split(' ')[0];
                    }

                    $('input[name="tanggal_mulai"]').val(toInputDate(item.tanggal_mulai));
                    $('input[name="tanggal_selesai"]').val(toInputDate(item.tanggal_selesai));
                    $('input[name="link_tujuan"]').val(item.link_tujuan || '');
                    
                    // Tampilkan gambar lama
                    $('#moduleUploadContent').html(
                        '<div style="font-size: 28px; margin-bottom: 10px;">📷</div>' +
                        '<div style="font-weight: 600; font-size: 15px;">Gambar sudah ada</div>' +
                        '<div style="margin-top: 8px; font-size: 13px; color: #6b7280;">Upload gambar baru untuk mengganti (opsional)</div>'
                    );
                    
                    ModalManager.open('modalContentModule');
                }
            },
            error: function(err) {
                Toast.show('error', 'Gagal memuat data');
                console.error('Error:', err);
            }
        });
    }

    function removeEntry(id) {
        pendingRemoveId = id;
        ModalManager.open('modalRemoveConfirm');
    }

    function executeRemoveEntry() {
        if (!pendingRemoveId) return;
        $.ajax({
            url: '/api/admin/manajemen_iklan/hapusData/' + pendingRemoveId,
            type: 'DELETE',
            success: function(res) {
                ModalManager.close('modalRemoveConfirm');
                Toast.show('success', '🗑️ Konten dihapus');
                loadContentModule();
                pendingRemoveId = null;
            },
            error: function(err) {
                ModalManager.close('modalRemoveConfirm');
                Toast.show('error', '❌ Gagal menghapus');
                console.error('Error:', err);
            }
        });
    }
</script>
@endsection