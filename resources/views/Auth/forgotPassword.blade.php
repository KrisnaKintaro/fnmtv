<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan CSS yang persis sama dengan Login */
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
            line-height: 1.5;
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
            padding: 8px 16px;
            border-radius: 8px;
            background: var(--white);
            border: 1px solid var(--border);
            transition: 0.2s;
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
            z-index: 9999;
        }
    </style>
</head>

<body>

    <div class="login-wrap">
        <a href="/login" class="back-btn">⬅ Kembali ke Login</a>

        <div class="login-card">
            <div style="font-size: 40px; text-align: center; margin-bottom: 10px;">🔑</div>
            <div class="login-logo" style="font-size: 24px;">Lupa Password?</div>
            <div class="login-sub">Nggak usah panik. Masukin alamat email yang di pakai buat daftar, nanti kita kirimin link buat bikin password baru.</div>

            <form id="formForgot">
                <div class="lfield">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Masukkan email anda" required>
                </div>
                <button type="submit" class="login-btn" id="btnSubmit">Kirim Link Reset</button>
            </form>
        </div>
    </div>

    <div id="toast"><span id="toastIco"></span><span id="toastMsg"></span></div>

    <script src="/admin/js/jquery.min.js"></script>
    <script src="/admin/js/toast.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#formForgot').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#btnSubmit');
                btn.text('Mengirim...').prop('disabled', true);

                $.ajax({
                    url: '/api/auth/forgot-password',
                    type: 'POST',
                    data: {
                        email: $('#email').val()
                    },
                    success: function(res) {
                        Toast.show('success', res.message);
                        btn.text('Kirim Link Reset').prop('disabled', false);
                        $('#email').val(''); // Kosongin input
                    },
                    error: function(err) {
                        Toast.show('error', err.responseJSON?.message || 'Gagal mengirim link.');
                        btn.text('Kirim Link Reset').prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>

</html>
