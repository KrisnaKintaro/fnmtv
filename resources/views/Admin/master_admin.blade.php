<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </div>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>

    <script src="{{ asset('admin/js/toast.js') }}"></script>
    <script src="{{ asset('admin/js/modalManager.js') }}"></script>
    <script src="{{ asset('admin/js/smartDataNotifikasi.js') }}"></script>
    <script src="{{ asset('admin/js/dataTable_engine.js') }}"></script>

    <script src="{{ asset('admin/js/admin_js.js') }}"></script>
    @yield('js')
</body>

</html>
