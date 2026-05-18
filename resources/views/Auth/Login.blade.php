<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
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
            /* Tambahan agar saat layar kecil bisa di-scroll kalau kontennya kepanjangan */
            overflow-x: hidden;
        }

        .login-wrap {
            position: fixed;
            inset: 0;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            /* Tambahan padding biar card gak nempel dinding di mobile */
            padding: 20px;
            overflow-y: auto;
        }

        .login-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, .1);
            /* Pastikan card relatif untuk berjaga-jaga */
            position: relative;
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
            background: #e6ecf4;
            color: #1a3a7a;
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

        /* =========================================
           MEDIA QUERIES (RESPONSIVITAS UNTUK HP & TABLET)
           ========================================= */
        @media screen and (max-width: 576px) {
            .login-wrap {
                /* Ubah align-items jika layar terlalu kecil agar bisa di-scroll vertikal */
                align-items: flex-start;
                padding-top: 80px; /* Beri ruang untuk tombol back di atas */
                padding-bottom: 30px;
            }

            .login-card {
                padding: 30px 24px; /* Kurangi padding dalam card agar inputan tidak terlalu sempit */
                border-radius: 12px;
            }

            .back-btn {
                top: 16px;
                left: 16px;
                font-size: 12px;
                padding: 6px 12px;
            }

            .login-logo {
                font-size: 28px; /* Perkecil logo sedikit di HP */
            }

            #toast {
                bottom: 20px;
                right: 20px;
                left: 20px; /* Buat toast full width dengan margin di HP */
                min-width: unset;
                justify-content: center;
            }
        }

        /* Penyesuaian khusus untuk HP lipat (Fold) yang layarnya sangat sempit (sekitar 280px) */
        @media screen and (max-width: 320px) {
            .login-card {
                padding: 24px 16px;
            }
            .back-btn span {
                display: none; /* Sembunyikan teks "Kembali ke Beranda", sisakan ikon panahnya saja kalau di Fold */
            }
            .back-btn::after {
                content: "Kembali"; /* Teks pengganti yang lebih pendek */
            }
        }
    </style>
</head>

<body>

    <div class="login-wrap">
        <a href="/" class="back-btn">⬅ <span>Kembali ke Beranda</span></a>

        <div class="login-card">
            <div class="login-logo" id="loginLogo">FNM</div>
            <div class="login-sub">Fenomena News Media — Platform Berita Terpercaya</div>
            <div class="login-role-chip">
                <span>🔐 Login</span>
            </div>

            <form id="formLogin">
                <div class="lfield">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Masukkan email" required>
                </div>
                <div class="lfield">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="password" style="margin-bottom: 0;">Password</label>
                        <a href="/forgot-password" style="font-size: 12px; color: var(--red); text-decoration: none; font-weight: 600;">Lupa Password?</a>
                    </div>
                    <div style="position: relative;">
                        <input type="password" id="password" placeholder="Masukkan password" required style="padding-right: 40px;">
                        <i class="fas fa-eye toggle-password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--muted);"></i>
                    </div>
                </div>
                <button type="submit" class="login-btn" id="btnSubmitLogin">Masuk</button>
            </form>

            <div class="login-foot">
                Belum punya akun? <a href="/register" class="toggle-link">Daftar di sini</a>
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

            $('#formLogin').on('submit', function(e) {
                e.preventDefault();

                const btn = $('#btnSubmitLogin');
                btn.text('Memproses...').prop('disabled', true);

                const payload = {
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                $.ajax({
                    url: '/api/auth/login',
                    type: 'POST',
                    data: payload,
                    success: function(res) {
                        if (res.status === 'success') {
                            Toast.show('success', res.message);

                            if (res.token) localStorage.setItem('auth_token', res.token);

                            setTimeout(() => {
                                window.location.href = res.redirect;
                            }, 1500);
                        }
                    },
                    error: function(err) {
                        btn.text('Masuk').prop('disabled', false);

                        let msg = 'Gagal login, cek email/password anda.';
                        if (err.responseJSON && err.responseJSON.message) {
                            msg = err.responseJSON.message;
                        }
                        Toast.show('error', msg);
                    }
                });
            });

            $(document).ready(function() {
                $.ajax({
                    url: '/api/viewers/site-info',
                    type: 'GET',
                    success: function(res) {
                        if (res.status === 'success') {
                            const data = res.data;
                            document.title = data.nama_situs + ' — Masuk';
                            if (document.getElementById('loginLogo')) {
                                document.getElementById('loginLogo').textContent = data.nama_situs;
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.toggle-password', function() {
                $(this).toggleClass('fa-eye fa-eye-slash');
                let input = $(this).siblings('input');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                } else {
                    input.attr('type', 'password');
                }
            });
        });
    </script>

</body>
</html>
