@extends('Admin.master_admin')

@section('konten')
<div class="content-body">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 class="section-title">Manajemen Iklan</h2>
        </div>
        <button onclick="ModalManager.open('modalTambahIklan')" class="btn-primary" style="padding: 10px 20px; border-radius: 8px; background: var(--red); color: white; border: none; font-weight: 600; cursor: pointer;">
            <i class="fas fa-plus" style="margin-right: 8px;"></i> Tambah Iklan
        </button>
    </div>

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
            <tbody id="listIklan"></tbody>
        </table>
    </div>
</div>

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
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Link Tujuan (Opsional)</label>
                <input type="url" name="link_tujuan" class="form-control" placeholder="https://example.com" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border);">
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
    function labelPosisi(posisi) {
        var map = {
            'horizontal_728x90': 'Tengah Artikel (728x90)',
            'sidebar_300x250': 'Sidebar Kanan (300x250)'
        };
        return map[posisi] || posisi.replace(/_/g, ' ');
    }

    $(document).ready(function() {
        loadDataIklan();

        $('#formTambahIklan').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '/api/admin/manajemen_iklan/tambahData',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    ModalManager.close('modalTambahIklan');
                    Toast.show('✅ ' + (res.message || 'Iklan berhasil ditambahkan!'));
                    loadDataIklan();
                    $('#formTambahIklan')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error('Tambah Iklan error:', status, error, xhr.responseText);
                    Toast.show('❌ Gagal menambah iklan');
                }
            });
        });
    });

    function loadDataIklan() {
        $.ajax({
            url: '/api/admin/manajemen_iklan/ambilData',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var html = '';
                if (!data || data.length === 0) {
                    html = '<tr><td colspan="5" style="padding: 20px; text-align: center; color: var(--muted);">Belum ada iklan. Tambahkan iklan baru untuk memulai.</td></tr>';
                } else {
                    $.each(data, function(i, item) {
                        var statusIcon = item.is_active ? '🟢' : '🔴';
                        var statusText = item.is_active ? 'Aktif' : 'Nonaktif';
                        var pembuatHtml = '<div style="font-weight: 700;">' + item.judul + '</div>'
                            + '<div style="font-size: 12px; color: var(--muted);">Dibuat oleh: ' + (item.user ? item.user.username : 'System') + '</div>';
                        if (item.link_tujuan) {
                            pembuatHtml += '<div style="font-size: 12px; color: var(--muted); margin-top: 6px;">'
                                + '<a href="' + item.link_tujuan + '" target="_blank" style="color: var(--blue); text-decoration: none;">' + item.link_tujuan + '</a>'
                                + '</div>';
                        }

                        html += '<tr style="border-bottom: 1px solid #eee;">';

                        // Kolom Banner
                        html += '<td style="padding: 16px; width: 180px;">';
                        html += '<img src="/storage/' + item.gambar + '"';
                        html += ' style="height: 50px; width: 120px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;"';
                        html += ' onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';">';
                        html += '<div style="display:none; height:50px; width:120px; border-radius:8px; border:1px solid #ddd; background:#f3f4f6; align-items:center; justify-content:center; font-size:11px; color:#9ca3af;">No Image</div>';
                        html += '</td>';

                        // Kolom Info
                        html += '<td style="padding: 16px;">' + pembuatHtml + '</td>';

                        // Kolom Posisi
                        html += '<td style="padding: 16px;">';
                        html += '<span class="badge" style="background: #eef2ff; color: #4338ca; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">';
                        html += labelPosisi(item.posisi);
                        html += '</span>';
                        html += '</td>';

                        // Kolom Status
                        html += '<td style="padding: 16px;">';
                        html += '<button onclick="toggleStatus(' + item.id + ')" class="btn-status" style="border:none; background:none; cursor:pointer; padding: 6px 12px; border-radius: 6px; font-weight: 600;">';
                        html += statusIcon + ' ' + statusText;
                        html += '</button>';
                        html += '</td>';

                        // Kolom Aksi
                        html += '<td style="padding: 16px;">';
                        html += '<button onclick="hapusIklan(' + item.id + ')" style="color: var(--red); border: none; background: none; cursor: pointer;" title="Hapus">';
                        html += '🗑️';
                        html += '</button>';
                        html += '</td>';

                        html += '</tr>';
                    });
                }
                $('#listIklan').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Error loading iklan:', status, error, xhr.responseText);
                $('#listIklan').html('<tr><td colspan="5" style="padding: 20px; text-align: center; color: var(--red);">Error memuat data. Periksa console untuk detail.</td></tr>');
            }
        });
    }

    function toggleStatus(id) {
        $.ajax({
            url: '/api/admin/manajemen_iklan/ubahStatus/' + id,
            type: 'PATCH',
            success: function(res) {
                Toast.show('✅ Status diperbarui');
                loadDataIklan();
            },
            error: function(err) {
                Toast.show('❌ Gagal mengubah status');
                console.error('Error:', err);
            }
        });
    }

    function hapusIklan(id) {
        if (confirm('Yakin ingin menghapus iklan ini?')) {
            $.ajax({
                url: '/api/admin/manajemen_iklan/hapusData/' + id,
                type: 'DELETE',
                success: function(res) {
                    Toast.show('🗑️ Iklan dihapus');
                    loadDataIklan();
                },
                error: function(err) {
                    Toast.show('❌ Gagal menghapus iklan');
                    console.error('Error:', err);
                }
            });
        }
    }
</script>
@endsection