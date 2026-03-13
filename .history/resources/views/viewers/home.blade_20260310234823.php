@extends('layouts.master')

@section('title','Berita Terbaru')

@section('content')
<div class="container" style="max-width:1180px;padding:20px;">
    <h1>Berita Terbaru</h1>
    @if(isset($news) && $news->count())
        <div class="news-list">
            @foreach($news as $item)
                <article class="mb-4">
                    <a href="{{ route('news.show',$item->slug) }}" class="nav-item">
                        <h2>{{ $item->title }}</h2>
                        <p>{{ Str::limit($item->excerpt ?? '', 150) }}</p>
                    </a>
                </article>
            @endforeach
        </div>
        {{ $news->links() }}
    @else
        <p>Tidak ada berita tersedia.</p>
    @endif
</div>
@endsection