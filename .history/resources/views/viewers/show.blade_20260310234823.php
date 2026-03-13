@extends('layouts.master')

@section('title', isset($news) ? $news->title : 'Berita')

@section('content')
<div class="container" style="max-width:1180px;padding:20px;">
    @if(isset($news))
        <article>
            <h1>{{ $news->title }}</h1>
            <p class="text-muted">{{ $news->published_at->format('d M Y') ?? '' }}</p>
            <div>{!! $news->content ?? '' !!}</div>
        </article>
    @else
        <p>Berita tidak ditemukan.</p>
    @endif
</div>
@endsection