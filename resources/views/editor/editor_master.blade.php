<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FNM — Panel Editor</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_css.css') }}">
    @yield('css')
</head>
<body>

  @include('editor.layout.sidebar')
  <!-- ═══════════ MAIN ═══════════ -->
  <main class="main">
    @include('editor.layout.navbar')
    @yield('konten')
  </main>

  <script src="{{ asset('admin/js/admin_js.js') }}"></script>
  @yield('js')
</body>
</html>
