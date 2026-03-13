{{-- main header containing logo, tagline, search box --}}
<header class="header">
    <div class="header-inner">
        <a href="{{ route('home') }}" class="logo">FNM</a>
        <div class="header-tagline">Fenomena News Media</div>
        <form action="{{ route('search') }}" method="get" class="header-search">
            <input type="text" name="q" class="search-input" placeholder="Cari berita..." value="{{ request('q') }}">
            <button type="submit" class="search-btn">Cari</button>
        </form>
    </div>
</header>