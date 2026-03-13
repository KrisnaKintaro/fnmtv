{{-- navigation bar for viewers --}}
<nav class="nav">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Berita Terbaru</a>
        <a href="{{ route('trending') }}" class="nav-item {{ request()->routeIs('trending') ? 'active' : '' }}">Trending</a>
        <!-- categories could be injected if controller passes $categories -->
        @if(isset($categories))
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->slug) }}" class="nav-item {{ request()->is('kategori/'.$cat->slug) ? 'active' : '' }}">{{ $cat->name }}</a>
            @endforeach
        @endif
    </div>
</nav>