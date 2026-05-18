<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Verifikasi Email</title>
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
            /* Tambahan agar saat layar kecil bisa di-scroll */
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
            text-align: center;
            /* Pastikan card relatif untuk berjaga-jaga */
            position: relative;
        }

        .login-logo {
            font-family: 'Merriweather', serif;
            font-size: 32px;
            font-weight: 900;
            color: var(--red);
            margin-bottom: 2px;
        }

        .login-sub {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 24px;
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

        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
            margin-top: 12px;
        }

        .btn-outline:hover {
            background: var(--bg);
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
                align-items: flex-start;
                padding-top: 50px;
                padding-bottom: 30px;
            }

            .login-card {
                padding: 30px 24px;
                border-radius: 12px;
            }

            .login-logo {
                font-size: 24px !important;
            }

            #toast {
                bottom: 20px;
                right: 20px;
                left: 20px;
                min-width: unset;
                justify-content: center;
            }
        }

        /* Penyesuaian khusus untuk HP lipat (Fold) */
        @media screen and (max-width: 320px) {
            .login-card {
                padding: 24px 16px;
            }
            .login-sub {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrap">
        <div class="login-card">
            <div style="font-size: 60px; margin-bottom: 10px;">✉️</div>
            <div class="login-logo" style="font-size: 24px;">Cek Inbox Lu Cuy!</div>

            <div class="login-sub" style="margin-bottom: 30px; line-height: 1.6;">
                Terima kasih udah daftar di <b>FNM</b>. <br>
                Kami udah ngirim link verifikasi ke email lu.<br>
                Silakan klik link tersebut biar akun lu aktif dan bisa ikutan komentar.
            </div>

            <form id="formResend">
                <button type="submit" class="login-btn" id="btnResend">Kirim Ulang Link Verifikasi</button>
            </form>

            <button class="login-btn btn-outline" id="btnKembali">Kembali Ke Beranda</button>
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

            if (!sessionStorage.getItem('auto_verify_sent')) {
                sessionStorage.setItem('auto_verify_sent', 'true');
                setTimeout(() => {
                    $('#formResend').trigger('submit');
                }, 500);
            }

            let cekStatus = setInterval(function() {
                $.get('/api/auth/checkVerify', function(res) {
                    if (res.verified) {
                        clearInterval(cekStatus);
                        Toast.show('success', 'Verifikasi berhasil! Mengalihkan...');
                        $('.login-logo').text('Verifikasi Sukses! 🎉');
                        $('.login-sub').html('Akun anda udah aktif. <br>Bentar ya, lagi diarahkan ke beranda...');
                        $('#btnResend').hide();
                        setTimeout(() => { window.location.href = '/'; }, 2000);
                    }
                });
            }, 3000);

            $('#formResend').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#btnResend');
                const originalText = btn.text();
                btn.text('Mengirim...').prop('disabled', true);

                $.ajax({
                    url: '/api/auth/email/verification-notification',
                    type: 'POST',
                    success: function() {
                        Toast.show('success', 'Link verifikasi baru udah dikirim. Cek email anda ya!');
                        let timeLeft = 60;
                        const countdown = setInterval(function() {
                            if (timeLeft <= 0) {
                                clearInterval(countdown);
                                btn.text(originalText).prop('disabled', false);
                            } else {
                                btn.text(`Tunggu ${timeLeft} detik...`);
                                timeLeft -= 1;
                            }
                        }, 1000);
                    },
                    error: function() {
                        Toast.show('error', 'Gagal ngirim email, coba lagi nanti!');
                        btn.text(originalText).prop('disabled', false);
                    }
                });
            });

            $('#btnKembali').on('click', function() {
                const btn = $(this);
                btn.text('Keluar...').prop('disabled', true);

                $.ajax({
                    url: '/api/auth/logout',
                    type: 'POST',
                    success: function() {
                        localStorage.removeItem('auth_token');
                        window.location.href = '/';
                    },
                    error: function() {
                        localStorage.removeItem('auth_token');
                        window.location.href = '/';
                    }
                });
            });

        });
    </script>

</body>
</html>
