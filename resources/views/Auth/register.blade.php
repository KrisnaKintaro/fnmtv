<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS Sama persis kayak form login */
        :root {
            --red: #cc0000;
            --red-dark: #990000;
            --bg: #f5f4f0;
            --white: #ffffff;
            --border: #e0ddd6;
            --text: #1a1a1a;
            --muted: #7a7570;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        .login-wrap {
            position: fixed;
            inset: 0;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        .login-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, .1);
        }

        .login-logo {
            font-family: 'Merriweather', serif;
            font-size: 32px;
            font-weight: 900;
            color: var(--red);
            text-align: center;
            margin-bottom: 2px;
        }

        .login-sub {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 24px;
        }

        .login-role-chip {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-role-chip span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e6f4ec;
            color: #1a7a3c;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
        }

        .lfield {
            margin-bottom: 16px;
        }

        .lfield label {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 6px;
        }

        .lfield input {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            padding: 10px 13px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text);
            outline: none;
            transition: .15s;
        }

        .lfield input:focus {
            border-color: var(--red);
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'Merriweather', serif;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: .2s;
            margin-top: 6px;
        }

        .login-btn:hover {
            background: var(--red-dark);
        }

        .login-btn:disabled {
            background: var(--muted);
            cursor: not-allowed;
        }

        .login-foot {
            text-align: center;
            font-size: 12px;
            color: var(--muted);
            margin-top: 18px;
        }

        .toggle-link {
            text-decoration: none;
            color: var(--red);
            font-weight: 600;
        }

        .toggle-link:hover {
            text-decoration: underline;
        }

        .back-btn {
            position: absolute;
            top: 24px;
            left: 24px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            transition: 0.2s;
            padding: 8px 16px;
            border-radius: 8px;
            background: var(--white);
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            z-index: 1000;
        }

        .back-btn:hover {
            color: var(--red);
            border-color: var(--red);
            transform: translateY(-2px);
        }

        #toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: #1a1a1a;
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, .25);
            z-index: 9999;
            min-width: 250px;
            transition: opacity .3s;
        }
    </style>
</head>

<body>

    <div class="login-wrap">
        <a href="/" class="back-btn">⬅ Kembali ke Beranda</a>

        <div class="login-card">
            <div class="login-logo">FNM</div>
            <div class="login-sub">Fenomena News Media — Platform Berita Terpercaya</div>
            <div class="login-role-chip">
                <span>✍️ Daftar Akun Baru</span>
            </div>

            <form id="formRegister">
                <div class="lfield">
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Pilih username unik lu" required>
                </div>
                <div class="lfield">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Masukkan email" required>
                </div>
                <div class="lfield">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Masukkan password" required>
                </div>
                <div class="lfield">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" placeholder="Konfirmasi password" required>
                </div>
                <button type="submit" class="login-btn" id="btnSubmitRegister">Daftar</button>
            </form>

            <div class="login-foot">
                Sudah punya akun? <a href="/login" class="toggle-link">Masuk di sini</a>
            </div>
        </div>
    </div>

    <div id="toast">
        <span id="toastIco"></span>
        <span id="toastMsg"></span>
    </div>

    <script src="/admin/js/jquery.min.js"></script>
    <script src="/admin/js/toast.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#formRegister').on('submit', function(e) {
                e.preventDefault();

                const btn = $('#btnSubmitRegister');
                btn.text('Memproses...').prop('disabled', true);

                const payload = {
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val()
                };

                // Tembak API Register
                $.ajax({
                    url: '/api/auth/register',
                    type: 'POST',
                    data: payload,
                    success: function(res) {
                        if (res.status === 'success') {
                            Toast.show('success', 'Pendaftaran berhasil! Silakan cek email untuk verifikasi.');
                            setTimeout(() => window.location.href = '/login', 2000);
                        }
                    },
                    error: function(err) {
                        btn.text('Daftar').prop('disabled', false); // Nyalain tombol lagi

                        let msg = 'Gagal mendaftar, cek lagi data anda.';

                        // Tangkep error validasi dari Laravel (misal email udah kepake)
                        if (err.responseJSON && err.responseJSON.errors) {
                            const firstError = Object.values(err.responseJSON.errors)[0][0];
                            msg = firstError;
                        } else if (err.responseJSON && err.responseJSON.message) {
                            msg = err.responseJSON.message;
                        }

                        Toast.show('error', msg);
                    }
                });
            });
        });
    </script>

</body>

</html>
