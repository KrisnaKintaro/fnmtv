@extends('layouts.master')

@section('title', isset($category) ? $category->name : 'Kategori')

@section('content')
<div class="container" style="max-width:1180px;padding:20px;">
    <h1>{{ $category->name ?? 'Kategori' }}</h1>
    @if(isset($news) && $news->count())
        @foreach($news as $item)
            <article class="mb-4">
                <a href="{{ route('news.show',$item->slug) }}" class="nav-item">
                    <h2>{{ $item->title }}</h2>
                    <p>{{ Str::limit($item->excerpt ?? '', 150) }}</p>
                </a>
            </article>
        @endforeach
        {{ $news->links() }}
    @else
        <p>Tidak ada berita di kategori ini.</p>
    @endif
</div>
@endsection