<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FNM — Fenomena News Media</title>

    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;0,900;1,400&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('viewers/css/viewers_css.css') }}">
    @yield('css')
</head>

<body>
    <div class="toast" id="toast">
        <span id="toastIco"></span>
        <span id="toastMsg"></span>
    </div>

    @include('Viewers.layout.navbar')

    @yield('konten')

    @include('Viewers.layout.footer')

    <script src="{{ asset('viewers/js/jquery.min.js') }}"></script>
    <script src="{{ asset('viewers/js/toast.js') }}"></script>
    <script src="{{ asset('viewers/js/modalManager.js') }}"></script>
    <script src="{{ asset('viewers/js/viewers_js.js') }}"></script>

    <script>
        // SETUP CSRF TOKEN GLOBAL
        const token = localStorage.getItem('auth_token');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': token ? 'Bearer ' + token : ''
            }
        });

        $(document).ready(function() {
            loadGlobalCategories();
        });

        function doLogout(e) {
            if (e) e.preventDefault();

            $.ajax({
                url: '/api/auth/logout',
                type: 'POST',
                success: function(res) {
                    // Hapus KTP Digital dari browser
                    localStorage.removeItem('auth_token');
                    Toast.show('success', 'Berhasil keluar. Sampai jumpa cuy!');

                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1000);
                },
                error: function(err) {
                    // Kalaupun error (misal token udah kadaluarsa di server), tetep paksa hapus dari browser
                    localStorage.removeItem('auth_token');
                    window.location.href = '/';
                }
            });
        }

        function loadGlobalCategories() {
            $.ajax({
                url: '/api/viewers/kategori',
                type: 'GET',
                success: function(res) {
                    if (res.status === 'success') {
                        renderNavbar(res.data);
                        renderFooter(res.data);
                    }
                },
                error: function(err) {
                    console.error("Gagal load kategori global cuy:", err);
                }
            });
        }

        function renderNavbar(categories) {
            const currentPath = window.location.pathname;
            if (currentPath === '/') $('#navHome').addClass('active');

            let mainHtml = '';
            let moreHtml = '';

            categories.forEach((cat, index) => {
                const isActive = currentPath.includes(`/kategori/${cat.slug}`) ? 'active' : '';

                if (index < 5) {
                    mainHtml += `<a href="/kategori/${cat.slug}" class="nav-item ${isActive}">${cat.nama_kategori}</a>`;
                } else {
                    moreHtml += `<a href="/kategori/${cat.slug}" class="nmd-item ${isActive}">${cat.nama_kategori}</a>`;
                }
            });

            $('#dynamicNavCategories').html(mainHtml);

            if (categories.length > 5) {
                $('#navMoreDropdown').html(moreHtml);
                $('#navMore').css('display', 'flex');
            } else {
                $('#navMore').hide();
            }
        }

        function renderFooter(categories) {
            let html = '';
            categories.slice(0, 4).forEach(cat => {
                html += `<a href="/kategori/${cat.slug}" class="ft-link">${cat.nama_kategori}</a>`;
            });
            $('#dynamicFooterCategories').html(html);
        }
    </script>

    @yield('js')
</body>

</html>
