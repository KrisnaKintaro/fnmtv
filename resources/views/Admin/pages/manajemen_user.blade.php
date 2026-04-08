@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
  <!-- ══ PAGE: USERS ══ -->
  <div id="page-users" class="page active">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
      <div class="section-title" style="margin:0">Manajemen User</div>
      <button class="btn btn-red" onclick="bukaModalUser()">+ Tambah User</button>
    </div>
    <div class="card">
      <table>
        <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Artikel</th><th>Bergabung</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody id="userTableBody">
        </tbody>
      </table>
      <div class="empty-state" id="emptyUser" style="display:none;">
        <div class="ico">👥</div>
        <p>Belum ada user yang ditambahkan.</p>
      </div>
    </div>
  </div>

  <!-- MODAL USER -->
  <div class="modal-backdrop" id="modalUser" style="display:none;">
    <div class="modal" style="max-width:450px;">
      <div class="modal-hd" style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 15px; border-bottom: 1px solid #eee;">
        <div class="modal-title" id="modalUserTitle" style="margin: 0; font-size: 18px; font-weight: 700;">Tambah User</div>
        <div class="modal-close" onclick="closeModalUser()" style="cursor: pointer; font-size: 22px; color: #999;">✕</div>
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
          <label>Password</label>
          <input type="password" id="inputPassword" placeholder="Minimal 6 karakter">
        </div>
        <div class="field">
          <label>Role</label>
          <select id="inputRole">
            <option value="">Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="redaksi">Redaksi</option>
            <option value="editor">Editor</option>
            <option value="viewer">Viewer</option>
          </select>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:16px;">
          <button class="btn btn-outline" onclick="closeModalUser()">Batal</button>
          <button class="btn btn-red" onclick="simpanUser()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
  let userList = [];
  let editUserId = null;

  $(document).ready(function() {
    loadDataUserFromAPI();
  });

  async function loadDataUserFromAPI() {
    try {
      const response = await fetch('/api/admin/manajemen_user/ambilData');
      const result = await response.json();
      
      if (result.status === 'success') {
        userList = result.data;
        renderUserTable();
      } else {
        Toast.show('error', 'Gagal memuat data user');
      }
    } catch (error) {
      console.error('Error loading users:', error);
      Toast.show('error', 'Terjadi kesalahan saat memuat data');
    }
  }

  function getRoleBadge(role) {
    const roleMap = {
      'admin': 'b-cat',
      'redaksi': 'b-review',
      'editor': 'b-review',
      'viewer': 'b-pub'
    };
    const roleLabel = {
      'admin': 'Admin',
      'redaksi': 'Redaksi',
      'editor': 'Editor',
      'viewer': 'Viewer'
    };
    return `<span class="badge ${roleMap[role] || 'b-pub'}">${roleLabel[role] || role}</span>`;
  }

  function renderUserTable() {
    const tbody = document.getElementById('userTableBody');
    const emptyState = document.getElementById('emptyUser');

    if (!userList || userList.length === 0) {
      tbody.innerHTML = '';
      emptyState.style.display = 'block';
      return;
    }

    emptyState.style.display = 'none';

    tbody.innerHTML = userList.map(user => {
      const bgColors = ['#cc0000', '#1a3a7a', '#1a7a3c', '#b86200'];
      const initials = user.name ? user.name[0].toUpperCase() : user.username[0].toUpperCase();
      const bgColor = bgColors[Math.floor(Math.random() * bgColors.length)];
      
      const joinDate = new Date(user.created_at).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'short', year: 'numeric'
      });

      const isAdmin = user.role === 'admin';
      
      return `
        <tr>
          <td>
            <div class="user-row">
              <div class="u-av" style="background:${bgColor}">${initials}</div>
              <b>${user.name || user.username}</b>
            </div>
          </td>
          <td style="font-size:12px;color:var(--muted)">${user.email}</td>
          <td>${getRoleBadge(user.role)}</td>
          <td>—</td>
          <td style="font-size:12px;color:var(--muted)">${joinDate}</td>
          <td><span class="badge b-pub">Aktif</span></td>
          <td>
            <div class="act-btns">
              <div class="ico-btn" onclick="editUser(${user.id})" title="Edit">✏️</div>
              ${!isAdmin ? `<div class="ico-btn" onclick="hapusUser(${user.id})" title="Hapus">🗑</div>` : ''}
            </div>
          </td>
        </tr>
      `;
    }).join('');
  }

  function bukaModalUser() {
    editUserId = null;
    document.getElementById('modalUserTitle').textContent = 'Tambah User';
    document.getElementById('inputUsername').value = '';
    document.getElementById('inputEmail').value = '';
    document.getElementById('inputPassword').value = '';
    document.getElementById('inputPassword').style.display = 'block';
    document.getElementById('inputRole').value = '';
    document.getElementById('inputPassword').parentElement.querySelector('label').textContent = 'Password';
    ModalManager.open('modalUser');
  }

  function closeModalUser() {
    ModalManager.close('modalUser');
  }

  function editUser(id) {
    const user = userList.find(u => u.id === id);
    if (user) {
      editUserId = id;
      document.getElementById('modalUserTitle').textContent = 'Edit User';
      document.getElementById('inputUsername').value = user.name || user.username;
      document.getElementById('inputEmail').value = user.email;
      document.getElementById('inputPassword').value = '';
      document.getElementById('inputPassword').style.display = 'none';
      document.getElementById('inputPassword').parentElement.querySelector('label').textContent = 'Password (Kosongkan jika tidak ingin mengubah)';
      document.getElementById('inputRole').value = user.role;
      ModalManager.open('modalUser');
    }
  }

  async function simpanUser() {
    const username = document.getElementById('inputUsername').value.trim();
    const email = document.getElementById('inputEmail').value.trim();
    const password = document.getElementById('inputPassword').value;
    const role = document.getElementById('inputRole').value;

    if (!username || !email || !role) {
      Toast.show('error', 'Semua field harus diisi!');
      return;
    }

    if (!editUserId && !password) {
      Toast.show('error', 'Password harus diisi untuk user baru!');
      return;
    }

    try {
      let url, method, payload;

      if (editUserId) {
        url = `/api/admin/manajemen_user/ubahData/${editUserId}`;
        method = 'PUT';
        payload = {
          username: username,
          email: email,
          role: role
        };
        if (password) payload.password = password;
      } else {
        url = '/api/admin/manajemen_user/tambahData';
        method = 'POST';
        payload = {
          username: username,
          email: email,
          password: password,
          role: role
        };
      }

      const response = await fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(payload)
      });

      const result = await response.json();

      if (result.status === 'success') {
        Toast.show('success', result.message);
        closeModalUser();
        loadDataUserFromAPI();
      } else {
        Toast.show('error', result.message || 'Gagal menyimpan user');
      }
    } catch (error) {
      console.error('Error:', error);
      Toast.show('error', 'Terjadi kesalahan saat menyimpan');
    }
  }

  async function hapusUser(id) {
    if (confirm('Yakin ingin menghapus user ini?')) {
      try {
        const response = await fetch(`/api/admin/manajemen_user/hapusData/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          }
        });

        const result = await response.json();

        if (result.status === 'success') {
          Toast.show('success', result.message);
          loadDataUserFromAPI();
        } else {
          Toast.show('error', result.message || 'Gagal menghapus user');
        }
      } catch (error) {
        console.error('Error:', error);
        Toast.show('error', 'Terjadi kesalahan saat menghapus');
      }
    }
  }
</script>
@endsection
