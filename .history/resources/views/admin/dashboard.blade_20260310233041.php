@extends('layouts.master')

@section('title','Dashboard')
@section('page_title','Dashboard')

@section('content')
<div class="page active">
    <h1>Dashboard statistik</h1>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-ico">📰</div>
            <div class="stat-val">128</div>
            <div class="stat-lbl">Berita</div>
        </div>
        <div class="stat-card">
            <div class="stat-ico">📂</div>
            <div class="stat-val">24</div>
            <div class="stat-lbl">Kategori</div>
        </div>
        <div class="stat-card">
            <div class="stat-ico">💬</div>
            <div class="stat-val">512</div>
            <div class="stat-lbl">Komentar</div>
        </div>
        <div class="stat-card">
            <div class="stat-ico">👥</div>
            <div class="stat-val">8</div>
            <div class="stat-lbl">Pengguna</div>
        </div>
    </div>
</div>
@endsection