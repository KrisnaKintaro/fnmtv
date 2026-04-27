<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin FNM</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_css.css') }}">
    <style>
        /* PAKSA SEMUA ELEMEN PAKAI SOURCE SANS 3 */
        *,
        body,
        html,
        p,
        div,
        span,
        table,
        td,
        th,
        input,
        select,
        textarea,
        button {
            font-family: 'Source Sans 3', sans-serif !important;
        }

        /* KHUSUS JUDUL PAKAI MERRIWEATHER */
        h1,
        h2,
        h3,
        .section-title,
        .modal-title,
        .card-ht,
        .s-logo {
            font-family: 'Merriweather', serif !important;
        }

        /* KHUSUS KODE/SLUG PAKAI JETBRAINS MONO */
        code,
        .slug-text,
        #inputSlugKategori,
        [style*="JetBrains Mono"] {
            font-family: 'JetBrains Mono', monospace !important;
        }
    </style>
    @yield('css')
</head>

<body>
    @include('Admin.layout.sidebar')

    <div class="main">
        @include('Admin.layout.navbar')
        @yield('konten')
        <div id="toast"
            style="position:fixed; bottom:28px; right:28px; background:#1a1a1a; color:#fff; padding:14px 20px; border-radius:8px; font-size:13px; font-weight:600; display:none; align-items:center; gap:12px; box-shadow:0 8px 30px rgba(0,0,0,.3); z-index:9999; min-width:280px; max-width:400px; transition:opacity .3s; opacity:0;">
            <span id="toastIco" style="font-size:20px;">✅</span>
            <span id="toastMsg" style="line-height:1.4;">Pesan notifikasi di sini...</span>
        </div>
    </div>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>

    <script src="{{ asset('admin/js/toast.js') }}"></script>
    <script src="{{ asset('admin/js/modalManager.js') }}"></script>
    <script src="{{ asset('admin/js/smartDataNotifikasi.js') }}"></script>
    <script src="{{ asset('admin/js/dataTable_engine.js') }}"></script>

    <script src="{{ asset('admin/js/admin_js.js') }}"></script>    
    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false
        });
    
        function doLogout(e) {
            if (e) e.preventDefault();
    
            if (!confirm('Yakin ingin keluar dari panel?')) {
                return;
            }
    
            $.ajax({
                url: '/api/auth/logout',
                type: 'POST',
                success: function () {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                },
                error: function () {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                }
            });
        }
    </script>
    @yield('js')
</body>

</html>
