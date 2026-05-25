@extends('admin.master_admin')
@section('css')
    <style>
        /* Container Tab Pills */
        .tab-pills {
            display: flex;
            gap: 8px;
            background-color: #f1f5f9;
            padding: 4px;
            border-radius: 10px;
            width: fit-content;
            overflow-x: auto; /* Biar kalau di layar super sempit bisa digeser */
            -webkit-overflow-scrolling: touch;
        }

        /* Style dasar tombol Tab */
        .tab-p {
            border: none;
            outline: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            background-color: transparent;
            color: #64748b;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        /* Hover effect buat yang lagi ga aktif */
        .tab-p:not(.active):hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: #334155;
        }

        /* Style pas Tab lagi AKTIF (Klik) */
        .tab-p.active {
            background-color: #ffffff;
            color: #1e293b;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .tab-p.active[onclick*="'Aktif'"] {
            color: #16a34a !important;
        }

        .tab-p.active[onclick*="'Nonaktif'"] {
            color: #dc2626 !important;
        }

        /* ── FIX RESPONSIVE: Scroll Tabel Horizontal ── */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 750px; /* Paksa muncul scroll jika layar lebih sempit dari ini */
        }
    </style>
@endsection
@section('konten')
    <div id="page-users" class="page active" data-admin-id="{{ Auth::id() }}">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px; flex-wrap:wrap; gap:10px;">
            <div class="section-title" style="margin:0">Manajemen User</div>
            <button class="btn btn-red" onclick="bukaModalUser()">+ Tambah User</button>
        </div>

        <div class="card">
            <div class="card-hd" style="flex-wrap: wrap; gap: 10px;">
                <div class="card-ht">Daftar Pengguna Sistem</div>
                <div class="tab-pills">
                    <button class="tab-p active" onclick="filterUserStatus('')">Semua</button>
                    <button class="tab-p" onclick="filterUserStatus('Aktif')">Aktif</button>
                    <button class="tab-p" onclick="filterUserStatus('Nonaktif')">Nonaktif</button>
                </div>
                <div class="card-hm" id="userCount">Memuat data...</div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th style="text-align:center;">Status</th>
                            <th style="width:130px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                    </tbody>
                </table>
            </div>

            <div class="empty-state" id="emptyUser" style="display:none; padding: 40px; text-align: center;">
                <div class="ico" style="font-size: 40px; margin-bottom: 10px;">👥</div>
                <p style="color: var(--muted);">Belum ada user yang ditemukan.</p>
            </div>

            <div class="pager" style="flex-wrap:wrap;">
                <div id="userPagination" style="display:flex; gap:4px; flex-wrap:wrap;"></div>
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
                    <input type="text" id="inputUsername" placeholder="Contoh: budi_santoso" style="width:100%; box-sizing:border-box;">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" id="inputEmail" placeholder="Contoh: budi@fnm.id" style="width:100%; box-sizing:border-box;">
                </div>
                <div class="field">
                    <label id="labelPassword">Password</label>
                    <input type="password" id="inputPassword" placeholder="Minimal 6 karakter" style="width:100%; box-sizing:border-box;">
                </div>
                <div class="field">
                    <label>Role</label>
                    <select id="inputRole" style="width:100%; box-sizing:border-box; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: 7px; outline: none;">
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
            <div style="font-size:45px; margin-bottom:10px;">⚠️</div>
            <h3 style="font-family: 'Merriweather', serif; margin-bottom:10px; color: #dc2626;">Musnahkan Akun Viewer?</h3>
            <p style="font-size:13px; color:var(--muted); margin-bottom:24px; line-height: 1.5;">
                Peringatan! Akun Viewer ini beserta <strong>seluruh riwayat komentarnya</strong> akan dihapus secara
                permanen dari sistem. <br><br>Aksi ini <strong>TIDAK BISA</strong> dikembalikan!
            </p>
            <div style="display:flex; gap:10px;">
                <button class="btn btn-outline" style="flex:1; justify-content:center;"
                    onclick="ModalManager.close('modalDeleteUser')">Batal</button>
                <button class="btn btn-red"
                    style="flex:1; justify-content:center; background-color: #dc2626; border-color: #dc2626;"
                    onclick="executeDeleteUser()">Ya, Musnahkan!</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let userDB = [];
        let editUserId = null;
        let idUserYangAkanDihapus = null;
        let currentStatusFilter = '';

        // Ambil dari atribut data
        const currentAdminId = Number(document.getElementById('page-users').dataset.adminId);

        function filterUserStatus(status) {
            $('.tab-p').removeClass('active');
            $(event.currentTarget).addClass('active');

            currentStatusFilter = status;
            applyUserFilter();
        }

        function applyUserFilter() {
            // 🔥 SINKRONISASI PENCARIAN DARI NAVBAR PC DAN HP 🔥
            const desktopSearch = document.getElementById('searchInput');
            const mobileSearch = document.querySelector('.mobile-search-input');
            let keyword = '';

            if (desktopSearch && desktopSearch.value) keyword = desktopSearch.value.toLowerCase();
            else if (mobileSearch && mobileSearch.value) keyword = mobileSearch.value.toLowerCase();

            userTable.setFilterAndSearch((val) => {
                const matchStatus = currentStatusFilter === '' || val.status === currentStatusFilter;
                const matchKeyword = val.username.toLowerCase().includes(keyword) ||
                    val.email.toLowerCase().includes(keyword);
                return matchStatus && matchKeyword;
            });
        }

        $(document).ready(function() {
            $('#tbTitle').text('Manajemen User');
            $('#tbCrumb').text('Admin / Manajemen User');

            // SETUP EVENT LISTENER PENCARIAN DUA ALAM
            const searchInputs = document.querySelectorAll('#searchInput, .mobile-search-input');
            searchInputs.forEach(input => {
                if(input) {
                    input.placeholder = 'Cari data user...';
                    input.value = '';
                    input.addEventListener('keyup', function() {
                        applyUserFilter();
                    });
                }
            });

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

                const statusClass = (val.status === 'Nonaktif') ? 'badge b-reject' : 'badge b-pub';
                const statusText = val.status || 'Aktif';

                const isSelf = (val.id === currentAdminId);

                // Tombol Edit
                let editBtn =
                    `<div class="ico-btn btn-edit" onclick="editUser(${val.id})" title="Edit User">✏️</div>`;

                // Tombol Ban/Unban
                let banBtn = '';
                if (isSelf) {
                    banBtn = `<div class="ico-btn btn-disabled" title="Nggak bisa Ban diri sendiri">🛡️</div>`;
                } else if (val.status === 'Nonaktif') {
                    banBtn =
                        `<div class="ico-btn btn-unban" onclick="toggleStatus(${val.id}, '${statusText}')" title="Aktifkan">✅</div>`;
                } else {
                    banBtn =
                        `<div class="ico-btn btn-ban" onclick="toggleStatus(${val.id}, '${statusText}')" title="Ban User">🛑</div>`;
                }

                // Tombol Purge
                let purgeBtn = '';
                if (isSelf) {
                    purgeBtn =
                        `<div class="ico-btn btn-disabled" title="Nggak bisa Hapus diri sendiri">🚫</div>`;
                } else if (val.role === 'Viewer') {
                    purgeBtn =
                        `<div class="ico-btn btn-purge" onclick="confirmDeleteUser(${val.id})" title="Hapus Permanen">🗑️</div>`;
                } else {
                    purgeBtn = `<div class="ico-btn btn-disabled" title="Role ini gak bisa dihapus">🚫</div>`;
                }

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
                <td style="text-align:center;"><span class="${statusClass}">${statusText}</span></td>
                <td>
                    <div class="act-btns" style="justify-content:center; gap:8px;">
                        ${editBtn} ${banBtn} ${purgeBtn}
                    </div>
                </td>
            </tr>`;
            }
        });

        async function loadDataUserFromAPI() {
            try {
                const response = await fetch('/api/admin/manajemen_user/ambilData');
                const result = await response.json();
                if (result.status === 'success') {
                    userDB = result.data;
                    userTable.loadData(userDB);
                    $('#userCount').text(`Menampilkan ${userDB.length} user`);
                }
            } catch (error) {
                console.error(error);
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
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || "Gagal merubah status";
                    Toast.show('error', msg);
                }
            });
        }

        function closeModalUser() {
            ModalManager.close('modalUser');
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

        function bukaModalUser() {
            editUserId = null;
            $('#modalUserTitle').text('Tambah User');
            $('#inputUsername').val('');
            $('#inputEmail').val('');
            $('#inputRole').val('');
            $('#inputPassword').val('');
            $('#labelPassword').text('Password');
            ModalManager.open('modalUser');
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

            if (editUserId) payload['_method'] = 'PUT';

            const url = editUserId ? `/api/admin/manajemen_user/ubahData/${editUserId}` :
                '/api/admin/manajemen_user/tambahData';

            $.ajax({
                url: url,
                type: 'POST',
                data: payload,
                success: function(result) {
                    if (result.status === 'success') {
                        Toast.show('success', result.message);
                        ModalManager.close('modalUser');
                        loadDataUserFromAPI();
                    }
                },
                error: function(xhr) {
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
                type: 'POST',
                data: {
                    _method: 'DELETE'
                },
                success: function(result) {
                    if (result.status === 'success') {
                        Toast.show('success', result.message);
                        ModalManager.close('modalDeleteUser');
                        loadDataUserFromAPI();
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
