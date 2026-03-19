<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('viewers/css/viewers_css.css') }}">
    @yield('css')
</head>

<body>
    @include('Viewers.layout.navbar')
    @yield('konten')
    @include('Viewers.layout.footer')

    <script src="{{ asset('viewers/js/viewers_js.js') }}"></script>
    @yield('js')
</body>



</html>
