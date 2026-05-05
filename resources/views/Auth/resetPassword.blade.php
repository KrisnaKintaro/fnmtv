<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Reset Password</title>
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
        <div class="login-card">
            <div style="font-size: 40px; text-align: center; margin-bottom: 10px;">🛡️</div>
            <div class="login-logo" style="font-size: 24px;">Bikin Password Baru</div>
            <div class="login-sub">Silakan buat password baru untuk akun <b>{{ request()->query('email') }}</b>. Pastiin gampang diinget tapi susah ditebak ya.</div>

            <form id="formReset">
                <input type="hidden" id="token" value="{{ $token }}">
                <input type="hidden" id="email" value="{{ request()->query('email') }}">

                <div class="lfield">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" placeholder="Minimal 8 karakter" required>
                </div>
                <div class="lfield">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" placeholder="Ulangi password baru" required>
                </div>
                <button type="submit" class="login-btn" id="btnSubmit">Simpan & Login</button>
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

            $('#formReset').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#btnSubmit');
                btn.text('Menyimpan...').prop('disabled', true);

                $.ajax({
                    url: '/api/auth/reset-password',
                    type: 'POST',
                    data: {
                        token: $('#token').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        password_confirmation: $('#password_confirmation').val()
                    },
                    success: function(res) {
                        Toast.show('success', res.message);
                        setTimeout(() => window.location.href = '/login', 2000);
                    },
                    error: function(err) {
                        Toast.show('error', err.responseJSON?.message || 'Gagal reset password.');
                        btn.text('Simpan & Login').prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>

</html>
