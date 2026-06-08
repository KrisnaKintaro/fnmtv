<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Panel Editor</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_css.css') }}">
    <style>
        *, body, html, p, div, span, table, td, th, input, select, textarea, button {
            font-family: 'Source Sans 3', sans-serif !important;
        }

        .fas, .far, .fab, .fa {
            font-family: "Font Awesome 6 Free" !important;
        }

        h1, h2, h3, .section-title, .modal-title, .card-ht, .s-logo {
            font-family: 'Merriweather', serif !important;
        }

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

    {{-- ── Sidebar toggle state ── --}}
    <script>
        (function () {
            if (localStorage.getItem('sidebarClosed') === '1') {
                document.documentElement.classList.add('sidebar-toggled-pre');
            }
        })();

        // Gunakan logika class yang sama dengan panel Admin
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-toggled');
            if (document.body.classList.contains('sidebar-toggled')) {
                localStorage.setItem('sidebarClosed', '1');
            } else {
                localStorage.removeItem('sidebarClosed');
            }
        }
    </script>
</head>

<body>
    <div class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    @include('editor.layout.sidebar')

    <main class="main">
        @include('editor.layout.navbar')
        @yield('konten')
    </main>

    <div id="toast"
        style="position:fixed; bottom:28px; right:28px; background:#1a1a1a; color:#fff; padding:14px 20px; border-radius:8px; font-size:13px; font-weight:600; display:none; align-items:center; gap:12px; box-shadow:0 8px 30px rgba(0,0,0,.3); z-index:9999; min-width:280px; max-width:400px; transition:opacity .3s; opacity:0;">
        <span id="toastIco" style="font-size:20px;">✅</span>
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

    <div id="modalLogoutConfirm" class="modal-backdrop">
        <div class="modal" style="max-width:420px; padding:28px; text-align:center;">
            <div style="font-size:20px; font-weight:800; color:var(--text); margin-bottom:12px;">Yakin ingin keluar dari panel Editor?</div>
            <div style="font-size:14px; color:var(--muted); line-height:1.7; margin-bottom:24px;">
                Kamu akan keluar dari panel dan dialihkan ke halaman login. Pastikan semua aktivitas sudah selesai.
            </div>
            <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
                <button onclick="ModalManager.close('modalLogoutConfirm')" style="flex:1; min-width:120px; padding:12px 16px; border-radius:12px; border:1px solid var(--border); background:var(--white); color:var(--text); font-weight:700; cursor:pointer;">Batal</button>
                <button onclick="performLogout()" style="flex:1; min-width:120px; padding:12px 16px; border-radius:12px; border:none; background:var(--red); color:var(--white); font-weight:700; cursor:pointer;">Keluar</button>
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

        function showPage(id, el) {
            $('.page').removeClass('active');
            const target = document.getElementById('page-' + id);
            if (!target) return;

            $(target).addClass('active');

            if (el) {
                $('.s-item').removeClass('active');
                $(el).addClass('active');
            }

            const titles = typeof pageTitles !== 'undefined' && pageTitles[id] ? pageTitles[id] : ['Editor', 'Panel Editor'];
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

        /* ── RESTORE STATE SIDEBAR ── */
        (function () {
            if (localStorage.getItem('sidebarClosed') === '1') {
                document.body.classList.add('sidebar-toggled');
            }
        })();
    </script>
    @yield('js')
</body>
</html>
