<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Panel Editor</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_css.css') }}">
    <style>
        .s-role-badge {
            background: #1a7a3c;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 3px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-left: auto;
            flex-shrink: 0;
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear,
        input[type="password"]::-webkit-textfield-decoration-container,
        input[type="password"]::-webkit-credentials-auto-fill-button {
            display: none !important;
        }
    </style>
    @yield('css')
</head>

<body>

    @include('editor.layout.sidebar')
    <!-- ═══════════ MAIN ═══════════ -->
    <main class="main">
        @include('editor.layout.navbar')
        @yield('konten')
    </main>

    <div id="toast"
        style="position:fixed; bottom:28px; right:28px; background:#1a1a1a; color:#fff; padding:14px 20px; border-radius:8px; font-size:13px; font-weight:600; display:none; align-items:center; gap:12px; box-shadow:0 8px 30px rgba(0,0,0,.3); z-index:9999; min-width:280px; max-width:400px; transition:opacity .3s; opacity:0;">
        <span id="toastIco" style="font-size:20px;"></span>
        <span id="toastMsg" style="line-height:1.4;"></span>
    </div>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/admin_js.js') }}"></script>
    <script src="{{ asset('admin/js/dataTable_engine.js') }}"></script>
    <script src="{{ asset('admin/js/imageInputAndDropZone.js') }}"></script>
    <script src="{{ asset('admin/js/toast.js') }}"></script>
    <script src="{{ asset('admin/js/modalManager.js') }}"></script>
    <script src="{{ asset('admin/js/richTextEditor.js') }}"></script>
    <script src="{{ asset('admin/js/smartDataNotifikasi.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="modalLogoutConfirm" class="modal-backdrop">
        <div class="modal" style="max-width:420px; padding:28px; text-align:center;">
            <div style="font-size:20px; font-weight:800; color:var(--text); margin-bottom:12px;">Yakin ingin keluar dari
                panel Editor?</div>
            <div style="font-size:14px; color:var(--muted); line-height:1.7; margin-bottom:24px;">
                Kamu akan keluar dari panel dan dialihkan ke halaman login. Pastikan semua aktivitas sudah selesai.
            </div>
            <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
                <button onclick="ModalManager.close('modalLogoutConfirm')"
                    style="flex:1; min-width:120px; padding:12px 16px; border-radius:12px; border:1px solid var(--border); background:var(--white); color:var(--text); font-weight:700; cursor:pointer;">Batal</button>
                <button onclick="performLogout()"
                    style="flex:1; min-width:120px; padding:12px 16px; border-radius:12px; border:none; background:var(--red); color:var(--white); font-weight:700; cursor:pointer;">Keluar</button>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false
        });

        function doLogout(e) {
            if (e) e.preventDefault();
            ModalManager.open('modalLogoutConfirm');
        }

        function performLogout() {
            ModalManager.close('modalLogoutConfirm');

            $.ajax({
                url: '/api/auth/logout',
                type: 'POST',
                success: function() {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                },
                error: function() {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                }
            });
        }
    </script>


    <!-- Ganti script yang sudah ada di master -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false
        });

        // ✅ SATU showPage terpusat, pakai class bukan inline style
        const pageTitles = {
            'write-news': ['Tulis Berita Baru', 'Editor / Tulis Berita Baru'],
            'my-news': ['Berita Saya', 'Editor / Berita Saya'],
            'profile': ['Edit Profil', 'Editor / Edit Profil'],
        };

        function showPage(id, el) {
            // Hapus active dari semua halaman — TANPA .hide() / .show()
            $('.page').removeClass('active');

            const target = document.getElementById('page-' + id);
            if (!target) {
                console.error("Elemen page-" + id + " tidak ditemukan.");
                return;
            }
            $(target).addClass('active');

            // Update sidebar active
            if (el) {
                $('.s-item').removeClass('active');
                $(el).addClass('active');
            }

            // Update topbar
            const titles = pageTitles[id] || ['Editor', 'Panel Editor'];
            $('#tbTitle').text(titles[0]);
            $('#tbCrumb').text(titles[1]);
        }

        function doLogout(e) {
            if (e) e.preventDefault();
            ModalManager.open('modalLogoutConfirm');
        }

        function performLogout() {
            ModalManager.close('modalLogoutConfirm');
            $.ajax({
                url: '/api/auth/logout',
                type: 'POST',
                success: function() {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                },
                error: function() {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                }
            });
        }
    </script>
    @yield('js')
</body>

</html>
