@extends('Admin.master_admin')

@section('konten')
<div class="content-body">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 class="section-title">Manajemen Iklan</h2>
            <p style="color: var(--muted); font-size: 14px;">Kelola banner promosi yang tampil di halaman utama.</p>
        </div>
        <button onclick="ModalManager.open('modalTambahIklan')" class="btn-primary" style="padding: 10px 20px; border-radius: 8px; background: var(--red); color: white; border: none; font-weight: 600; cursor: pointer;">
            <i class="fas fa-plus" style="margin-right: 8px;"></i> Tambah Iklan
        </button>
    </div>

    <!-- Tabel Iklan -->
    <div class="card" style="background: white; border-radius: 12px; border: 1px solid var(--border); overflow: hidden;">
        <table class="table" id="tableIklan" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9f9f9; border-bottom: 1px solid var(--border);">
                    <th style="padding: 16px;">Banner</th>
                    <th style="padding: 16px;">Info Iklan</th>
                    <th style="padding: 16px;">Posisi</th>
                    <th style="padding: 16px;">Status</th>
                    <th style="padding: 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="listIklan">
                <!-- Data akan dimuat via AJAX melalui dataTable_engine.js -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Iklan -->
<div id="modalTambahIklan" class="modal-backdrop">
    <div class="modal" style="max-width: 600px; padding: 28px;">
        <h3 class="modal-title" style="margin-bottom: 20px;">Tambah Banner Iklan Baru</h3>
        <form id="formTambahIklan" enctype="multipart/form-data">
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Judul Iklan</label>
                <input type="text" name="judul" class="form-control" placeholder="Contoh: Promo Ramadhan" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border);">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Pilih Space Iklan</label>
                <select name="posisi" class="form-control" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border);">
                    <option value="horizontal_728x90">Tengah Artikel (728x90 px)</option>
                    <option value="sidebar_300x250">Sidebar Kanan (300x250 px)</option>
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Upload Gambar</label>
                <input type="file" name="gambar" accept="image/*" required style="width: 100%;">
                <small style="color: var(--muted);">Format: JPG, PNG. Maks 2MB.</small>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="button" onclick="ModalManager.close('modalTambahIklan')" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--border); background: white;">Batal</button>
                <button type="submit" style="flex: 1; padding: 12px; border-radius: 8px; background: var(--red); color: white; border: none; font-weight: 600;">Simpan Iklan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        loadDataIklan();

        // Handle Submit Tambah Iklan
        $('#formTambahIklan').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: '/api/admin/manajemen_iklan/tambahData',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    ModalManager.close('modalTambahIklan');
                    Toast.show('✅ ' + res.message);
                    loadDataIklan();
                    $('#formTambahIklan')[0].reset();
                },
                error: function(err) {
                    Toast.show('❌ Gagal menambah iklan');
                }
            });
        });
    });

    function loadDataIklan() {
        $.get('/api/admin/manajemen_iklan/ambilData', function(data) {
            let html = '';
            data.forEach(item => {
                html += `
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 16px;">
                        <img src="/storage/${item.gambar}" style="height: 50px; border-radius: 4px; object-fit: cover; border: 1px solid #ddd;">
                    </td>
                    <td style="padding: 16px;">
                        <div style="font-weight: 700;">${item.judul}</div>
                        <div style="font-size: 12px; color: var(--muted);">Dibuat oleh: ${item.admin ? item.admin.username : 'System'}</div>
                    </td>
                    <td style="padding: 16px;">
                        <span class="badge" style="background: #eef2ff; color: #4338ca; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                            ${item.posisi.replace('_', ' ')}
                        </span>
                    </td>
                    <td style="padding: 16px;">
                        <button onclick="toggleStatus(${item.id_iklan})" class="btn-status" style="border:none; background:none; cursor:pointer;">
                            ${item.status === 'aktif' ? '🟢 Aktif' : '🔴 Nonaktif'}
                        </button>
                    </td>
                    <td style="padding: 16px;">
                        <button onclick="hapusIklan(${item.id_iklan})" style="color: var(--red); border: none; background: none; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
            $('#listIklan').html(html);
        });
    }

    function toggleStatus(id) {
        $.ajax({
            url: `/api/admin/manajemen_iklan/ubahStatus/${id}`,
            type: 'PATCH',
            success: function(res) {
                Toast.show('✅ Status diperbarui');
                loadDataIklan();
            }
        });
    }

    function hapusIklan(id) {
        if(confirm('Yakin ingin menghapus iklan ini?')) {
            $.ajax({
                url: `/api/admin/manajemen_iklan/hapusData/${id}`,
                type: 'DELETE',
                success: function(res) {
                    Toast.show('🗑️ Iklan dihapus');
                    loadDataIklan();
                }
            });
        }
    }
</script>
@endsection