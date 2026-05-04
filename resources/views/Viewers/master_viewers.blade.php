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

    <div id="modalLogoutConfirm" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; padding:24px; backdrop-filter:blur(2px);">
        <div style="background:#fff; width:100%; max-width:420px; border-radius:24px; box-shadow:0 24px 80px rgba(0,0,0,0.16); padding:28px; position:relative; overflow:hidden;">
            <div style="font-size:20px; font-weight:800; color:#111; margin-bottom:12px;">Yakin ingin keluar?</div>
            <div style="font-size:14px; color:#5f6368; line-height:1.7; margin-bottom:24px;">
                Kamu akan keluar dari akun dan dialihkan ke beranda. Pastikan semua aktivitas sudah selesai sebelum keluar.
            </div>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <button onclick="ModalManager.close('modalLogoutConfirm')" style="flex:1; min-width:120px; padding:12px 16px; border-radius:12px; border:1px solid #d2d2d2; background:#fff; color:#333; font-weight:700; cursor:pointer;">Batal</button>
                <button onclick="performLogout()" style="flex:1; min-width:120px; padding:12px 16px; border-radius:12px; border:none; background:#cc0000; color:#fff; font-weight:700; cursor:pointer;">Keluar</button>
            </div>
        </div>
    </div>

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
            loadSiteInfo();
            loadGlobalCategories();
        });

        function confirmLogout(e) {
            if (e) e.preventDefault();
            ModalManager.open('modalLogoutConfirm');
        }

        function performLogout() {
            ModalManager.close('modalLogoutConfirm');
            Toast.show('info', 'Sedang keluar... tunggu sebentar.');

            $.ajax({
                url: '/api/auth/logout',
                type: 'POST',
                success: function(res) {
                    localStorage.removeItem('auth_token');
                    Toast.show('success', 'Berhasil keluar. Sampai jumpa cuy!');

                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1000);
                },
                error: function(err) {
                    localStorage.removeItem('auth_token');
                    Toast.show('error', 'Gagal logout. Kamu tetap diarahkan ke beranda.');

                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1200);
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

        // LOAD SITE INFO DARI DATABASE
        function loadSiteInfo() {
            $.ajax({
                url: '/api/viewers/site-info',
                type: 'GET',
                success: function(res) {
                    if (res.status === 'success') {
                        const data = res.data;
                        const taglineEl = document.getElementById('siteTagline');
                        if (taglineEl) {
                            taglineEl.innerHTML = `${data.nama_situs}<br>${data.tagline}`;
                        }
                    }
                },
                error: function(err) {
                    console.error("Gagal load site info:", err);
                }
            });
        }

        // LOAD SITE INFO UNTUK FOOTER
        function loadSiteInfoFooter() {
            $.ajax({
                url: '/api/viewers/site-info',
                type: 'GET',
                success: function(res) {
                    if (res.status === 'success') {
                        const data = res.data;
                        const footerDesc = document.getElementById('footerDesc');
                        if (footerDesc) {
                            footerDesc.innerHTML = `${data.nama_situs}<br>${data.tagline}`;
                        }
                    }
                },
                error: function(err) {
                    console.error("Gagal load site info footer:", err);
                }
            });
        }
        
        loadSiteInfoFooter();
    </script>

    @yield('js')
</body>

</html>
