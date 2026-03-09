<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - FNM News</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .form-container {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        input,
        select,
        button {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .btn-edit {
            background: orange;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-delete {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h2>Manajemen Pengguna (API Base)</h2>

    <div class="form-container">
        <h3 id="form-title">Tambah User Baru</h3>
        <form id="form-user">
            <input type="hidden" id="user_id">

            <input type="text" id="name" placeholder="Nama Lengkap" required>
            <input type="email" id="email" placeholder="Email" required>
            <input type="password" id="password" placeholder="Password (Kosongkan jika edit & tidak ingin ganti)">

            <select id="role">
                <option value="Viewer">Viewer</option>
                <option value="Admin">Admin</option>
            </select>

            <button type="submit" id="btn-submit" style="background: green; color: white;">Simpan Data</button>
            <button type="button" id="btn-cancel" style="display: none;">Batal Edit</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                <td colspan="5">Loading data...</td>
            </tr>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {

            // 1. FUNGSI READ (Tampil Data pake $.ajax)
            function loadData() {
                $.ajax({
                    url: '/api/dataUser',
                    type: 'GET', // Method-nya GET untuk ambil data
                    dataType: 'json', // (Opsional) Ngasih tau kalau kita ekspektasi balikan JSON
                    success: function(response) {
                        let rows = '';
                        if (response.status === 'success') {
                            $.each(response.data, function(index, user) {
                                rows += `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>
                                <button class="btn-edit" onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.role}')">Edit</button>
                                <button class="btn-delete" onclick="hapusUser(${user.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                            });
                            $('#table-body').html(rows);
                        }
                    },
                    error: function(err) {
                        console.log("Gagal ambil data:", err);
                        $('#table-body').html('<tr><td colspan="5">Gagal memuat data!</td></tr>');
                    }
                });
            }

            // Panggil fungsi read saat halaman pertama dibuka
            loadData();

            // 2. FUNGSI CREATE & UPDATE (Submit Form)
            $('#form-user').submit(function(e) {
                e.preventDefault(); // Cegah reload

                let id = $('#user_id').val();
                let url = '';
                let method = '';

                // Bikin object data yang mau dikirim
                let dataKirim = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    role: $('#role').val()
                };

                // Cek apakah ini mode Tambah atau Edit (berdasarkan ada tidaknya ID)
                if (id === '') {
                    // Mode Tambah
                    url = '/api/tambahDataUser';
                    method = 'POST';
                } else {
                    // Mode Edit
                    url = '/api/ubahDataUser/' + id;
                    method = 'PUT';
                }

                // Eksekusi AJAX
                $.ajax({
                    url: url,
                    type: method,
                    data: dataKirim,
                    success: function(response) {
                        alert(response.message);
                        resetForm();
                        loadData(); // Refresh tabel otomatis
                    },
                    error: function(err) {
                        alert("Gagal menyimpan data! Cek console.");
                        console.log(err.responseJSON);
                    }
                });
            });

            // 3. FUNGSI PERSIAPAN EDIT (Pas tombol edit diklik)
            window.editUser = function(id, name, email, role) {
                $('#form-title').text('Edit User (ID: ' + id + ')');
                $('#user_id').val(id);
                $('#name').val(name);
                $('#email').val(email);
                $('#password').val(''); // Kosongin password biar aman
                $('#role').val(role);

                $('#password').removeAttr('required'); // Password gak wajib kalau edit
                $('#btn-cancel').show();
            }

            // 4. FUNGSI DELETE (Pas tombol hapus diklik)
            window.hapusUser = function(id) {
                if (confirm('Yakin mau hapus user ini cuy?')) {
                    $.ajax({
                        url: '/api/hapusDataUser/' + id,
                        type: 'DELETE',
                        success: function(response) {
                            alert(response.message);
                            loadData(); // Refresh tabel otomatis
                        }
                    });
                }
            }

            // Fungsi tambahan buat balikin form ke mode Tambah
            function resetForm() {
                $('#form-user')[0].reset();
                $('#user_id').val('');
                $('#form-title').text('Tambah User Baru');
                $('#password').attr('required', 'required'); // Wajibin password lagi
                $('#btn-cancel').hide();
            }

            $('#btn-cancel').click(function() {
                resetForm();
            });

        });
    </script>

</body>

</html>
