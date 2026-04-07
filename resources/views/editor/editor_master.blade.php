<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FNM — Panel Editor</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_css.css') }}">
    <style>
        .s-role-badge{background:#1a7a3c;color:#fff;font-size:10px;font-weight:700;padding:2px 7px;border-radius:3px;letter-spacing:1px;text-transform:uppercase;margin-left:auto;flex-shrink:0;}
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

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/admin_js.js') }}"></script>
    <script src="{{ asset('admin/js/dataTable_engine.js') }}"></script>
    <script src="{{ asset('admin/js/imageInputAndDropZone.js') }}"></script>
    <script src="{{ asset('admin/js/toast.js') }}"></script>
    <script src="{{ asset('admin/js/modalManager.js') }}"></script>
    <script src="{{ asset('admin/js/richTextEditor.js') }}"></script>
    <script src="{{ asset('admin/js/smartDataNotifikasi.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('js')
</body>

</html>
