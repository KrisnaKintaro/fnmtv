<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Fenomena News Media</title>

    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;0,900;1,400&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('viewers/css/viewers_css.css') }}">
    @yield('css')
</head>
<body>
    <div class="toast" id="toast"></div>

    @include('Viewers.layout.navbar')

    @yield('konten')

    @include('Viewers.layout.footer')

    <script src="{{ asset('viewers/js/viewers_js.js') }}"></script>
    @yield('js')
</body>
</html>
