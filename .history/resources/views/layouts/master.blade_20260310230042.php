{{-- resources/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — @yield('title', 'Fenomena News Media')</title>

    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- CSS kondisional: admin atau viewer --}}
    @if(request()->is('admin*'))
        <link rel="stylesheet" href="{{ asset('admin/css/fnm-admin.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('viewer/css/fnm-viewer.css') }}">
    @endif

    {{-- CSS tambahan per halaman --}}
    @stack('styles')
</head>
<body>

    {{-- Layout beda antara admin dan viewer --}}
    @if(request()->is('admin*'))

        {{-- ===== LAYOUT ADMIN ===== --}}
        @include('layouts.partials.admin-sidebar')
        <main class="main">
            @include('layouts.partials.admin-topbar')
            <div class="content">
                @yield('content')
            </div>
        </main>

    @else

        {{-- ===== LAYOUT VIEWER ===== --}}
        @include('layouts.partials.viewer-topstrip')
        @include('layouts.partials.viewer-header')
        @include('layouts.partials.viewer-navbar')
        <main>
            @yield('content')
        </main>
        @include('layouts.partials.viewer-footer')

    @endif

    {{-- JS kondisional --}}
    @if(request()->is('admin*'))
        <script src="{{ asset('admin/js/fnm-admin.js') }}"></script>
    @else
        <script src="{{ asset('viewer/js/fnm-viewer.js') }}"></script>
    @endif

    {{-- JS tambahan per halaman --}}
    @stack('scripts')

</body>
</html>