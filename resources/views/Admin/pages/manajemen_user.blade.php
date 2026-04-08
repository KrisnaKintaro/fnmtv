@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
<div id="page-users" class="page active">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div class="section-title" style="margin:0">Manajemen User</div>
        <button class="btn btn-red" onclick="bukaModalUser()">+ Tambah User</button>
    </div>

    <div class="card">
        <div class="card-hd">
            <div class="card-ht">Daftar Pengguna Sistem</div>
            <div class="card-hm" id="userCount">Memuat data...</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th style="text-align:center;">Status</th>
                    <th style="width:100px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
            </tbody>
        </table>

        <div class="empty-state" id="emptyUser" style="display:none;">
            <div class="ico">👥</div>
            <p>Belum ada user yang ditemukan.</p>
        </div>

        <div class="pager">
            <div id="userPagination" style="display:flex; gap:4px;"></div>
            <div class="pg-info" id="userInfo">Menampilkan 0 dari 0 user</div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="modalUser" style="display:none;">
    <div class="modal" style="max-width:450px;">
        <div class="modal-hd">
            <div class="modal-title" id="modalUserTitle">Tambah User</div>
        </div>
        <div class="modal-body">
            <div class="field">
                <label>Username</label>
                <input type="text" id="inputUsername" placeholder="Contoh: budi_santoso">
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" id="inputEmail" placeholder="Contoh: budi@fnm.id">
            </div>
            <div class="field">
                <label id="labelPassword">Password</label>
                <input type="password" id="inputPassword" placeholder="Minimal 6 karakter">
            </div>
            <div class="field">
                <label>Role</label>
                <select id="inputRole">
                    <option value="">Pilih Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Redaksi">Redaksi</option>
                    <option value="Editor">Editor</option>
                    <option value="Viewer">Viewer</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:16px;">
                <button class="btn btn-outline" onclick="closeModalUser()">Batal</button>
                <button class="btn btn-red" onclick="simpanUser()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="modalDeleteUser" style="display:none;">
    <div class="modal" style="max-width:380px; text-align:center; padding:30px;">
        <div style="font-size:40px; margin-bottom:10px;">🗑️</div>
        <h3 style="font-family: 'Merriweather', serif; margin-bottom:10px;">Hapus Akun Pengguna?</h3>
        <p style="font-size:13px; color:var(--muted); margin-bottom:24px;">Akun yang dihapus tidak bisa dikembalikan. Data berita milik user ini akan tetap ada namun tanpa pemilik.</p>
        <div style="display:flex; gap:10px;">
            <button class="btn btn-outline" style="flex:1; justify-content:center;" onclick="ModalManager.close('modalDeleteUser')">Batal</button>
            <button class="btn btn-red" style="flex:1; justify-content:center;" onclick="executeDeleteUser()">Ya, Hapus</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let userDB = [];
    let editUserId = null;
    let idUserYangAkanDihapus = null;

    $(document).ready(function() {
        // 1. Manipulasi Teks di Navbar (Topbar)
        $('#tbTitle').text('Manajemen User');
        $('#tbCrumb').text('Admin / Manajemen User');

        // 2. Manipulasi Placeholder Search di Navbar
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.placeholder = 'Cari data user...';
            searchInput.value = ''; // Kosongin dulu pas pindah page

            // Re-bind fungsi search biar sinkron sama userTable
            searchInput.onkeyup = function() {
                userTable.setFilterAndSearch((val) => {
                    return val.username.toLowerCase().includes(this.value.toLowerCase()) ||
                        val.email.toLowerCase().includes(this.value.toLowerCase());
                });
            };
        }

        loadDataUserFromAPI();
    });

    // 1. Inisialisasi DataTableEngine khusus User
    const userTable = new DataTableEngine({
        tableBody: '#userTableBody',
        paginationWrapper: '#userPagination',
        infoWrapper: '#userInfo',
        emptyState: '#emptyUser',
        perPage: 5,
        renderRowHTML: function(val) {
            // Inisial avatar dengan warna acak/berdasarkan ID
            const colors = ['#1a3a7a', '#cc0000', '#1a7a3c', '#b86200', '#6b46c1'];
            const initials = (val.username || 'U')[0].toUpperCase();
            const color = colors[val.id % colors.length];

            const roleMap = {
                'Admin': 'b-cat',
                'Redaksi': 'b-review',
                'Editor': 'b-review',
                'Viewer': 'b-pub'
            };
            const joinDate = new Date(val.created_at).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

            // Status Badge (Aktif/Nonaktif sesuai API baru nanti)
            const statusClass = (val.status === 'Nonaktif') ? 'badge b-reject' : 'badge b-pub';
            const statusText = val.status || 'Aktif';

            return `
            <tr data-key="${val.id}">
                <td>
                    <div class="user-row" style="display:flex; align-items:center; gap:12px;">
                        <div class="u-av" style="background:${color}; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; font-size:14px;">${initials}</div>
                        <b style="color:var(--text);">${val.username}</b>
                    </div>
                </td>
                <td style="font-size:12px; color:var(--muted);">${val.email}</td>
                <td><span class="badge ${roleMap[val.role] || 'b-pub'}">${val.role}</span></td>
                <td style="font-size:12px; color:var(--muted);">${joinDate}</td>
                <td style="text-align:center;"><span class="${statusClass}" style="cursor:pointer;" onclick="toggleStatus(${val.id}, '${statusText}')">${statusText}</span></td>
                <td>
                    <div class="act-btns" style="justify-content:center;">
                        <div class="ico-btn" onclick="editUser(${val.id})" title="Edit Data">✏️</div>
                        <div class="ico-btn" onclick="confirmDeleteUser(${val.id})" title="Hapus Permanen">🗑</div>
                    </div>
                </td>
            </tr>`;
        }
    });

    $(document).ready(function() {
        loadDataUserFromAPI();
    });

    // --- FUNGSI NAVIGASI MODAL ---
    function bukaModalUser() {
        editUserId = null;
        $('#modalUserTitle').text('Tambah User Baru');
        $('#inputUsername, #inputEmail, #inputPassword').val('');
        $('#inputRole').val('');
        $('#labelPassword').text('Password');
        ModalManager.open('modalUser');
    }

    function closeModalUser() { // INI TADI YANG ILANG CUY!
        ModalManager.close('modalUser');
    }

    // --- FUNGSI CRUD ---
    async function loadDataUserFromAPI() {
        try {
            const response = await fetch('/api/admin/manajemen_user/ambilData');
            const result = await response.json();
            if (result.status === 'success') {
                userDB = result.data;
                userTable.loadData(userDB);
                document.getElementById('userCount').textContent = `Menampilkan ${userDB.length} user`;
            }
        } catch (error) {
            Toast.show('error', 'Gagal memuat data pengguna');
        }
    }

    function toggleStatus(id, currentStatus) {
        const newStatus = (currentStatus === 'Aktif') ? 'Nonaktif' : 'Aktif';

        $.ajax({
            url: `/api/admin/manajemen_user/ubahStatus/${id}`,
            type: 'POST',
            data: {
                _method: 'PATCH',
                status: newStatus
            },
            success: function(result) {
                if (result.status === 'success') {
                    Toast.show('success', result.message);
                    loadDataUserFromAPI();
                } else {
                    Toast.show('error', result.message);
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || "Gagal merubah status";
                Toast.show('error', msg);
            }
        });
    }

    function editUser(id) {
        const user = userDB.find(u => u.id === id);
        if (user) {
            editUserId = id;
            $('#modalUserTitle').text('Edit Data Pengguna');
            $('#inputUsername').val(user.username);
            $('#inputEmail').val(user.email);
            $('#inputRole').val(user.role);
            $('#inputPassword').val('');
            $('#labelPassword').text('Password (Kosongkan jika tidak diubah)');
            ModalManager.open('modalUser');
        }
    }

    async function simpanUser() {
        const payload = {
            username: $('#inputUsername').val().trim(),
            email: $('#inputEmail').val().trim(),
            role: $('#inputRole').val(),
            password: $('#inputPassword').val()
        };

        if (!payload.username || !payload.email || !payload.role) {
            Toast.show('warning', 'Data belum lengkap cuy!');
            return;
        }

        // Kalau sedang EDIT, tambahkan _method PUT buat Laravel Spoofing
        if (editUserId) {
            payload['_method'] = 'PUT';
        }

        const url = editUserId ?
            `/api/admin/manajemen_user/ubahData/${editUserId}` :
            '/api/admin/manajemen_user/tambahData';

        $.ajax({
            url: url,
            type: 'POST', // Kirim sebagai POST semua biar aman
            data: payload, // Kirim payload langsung (jangan di-stringify)
            success: function(result) {
                if (result.status === 'success') {
                    Toast.show('success', result.message);
                    closeModalUser();
                    loadDataUserFromAPI();
                } else {
                    Toast.show('error', result.message);
                }
            },
            error: function(xhr) {
                // Nangkep error validasi (email duplikat, dll)
                const msg = xhr.responseJSON?.message || "Terjadi kesalahan sistem!";
                Toast.show('error', msg);
            }
        });
    }

    function confirmDeleteUser(id) {
        idUserYangAkanDihapus = id;
        ModalManager.open('modalDeleteUser');
    }

    async function executeDeleteUser() {
        if (!idUserYangAkanDihapus) return;

        $.ajax({
            url: `/api/admin/manajemen_user/hapusData/${idUserYangAkanDihapus}`,
            type: 'POST', // Pake POST + Spoofing DELETE biar konsisten
            data: {
                _method: 'DELETE'
            },
            success: function(result) {
                if (result.status === 'success') {
                    Toast.show('success', result.message);
                    ModalManager.close('modalDeleteUser');
                    loadDataUserFromAPI();
                } else {
                    Toast.show('error', result.message);
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || "Gagal hapus data!";
                Toast.show('error', msg);
            }
        });
    }
</script>
@endsection
