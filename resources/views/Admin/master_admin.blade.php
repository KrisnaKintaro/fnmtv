<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin FNM</title>
    <link rel="stylesheet" href="{{ asset('admin/css/admin_css.css') }}">
    @yield('css')
</head>

<body>
    @include('Admin.layout.sidebar')

    <div class="main">
        @include('Admin.layout.navbar')
        @yield('konten')
    </div>
    
    <script src="{{ asset('admin/js/admin_js.js') }}"></script>
     @yield('js')
</body>

</html>
