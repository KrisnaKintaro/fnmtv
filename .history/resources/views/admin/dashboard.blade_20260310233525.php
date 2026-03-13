@extends('layouts.master')

@section('title','Dashboard')
@section('page_title','Dashboard')

@section('content')
<div id="page-dashboard" class="page active">
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
    <div class="two-col-dash">
        <div class="chart-area">
            <div class="chart-head"><div class="chart-title">Traffic Bulanan</div></div>
            <div class="chart-bars">
                <div class="bar-col"><div class="bar-fill" style="height:70%"></div><div class="bar-lbl">Jan</div></div>
                <div class="bar-col"><div class="bar-fill" style="height:55%"></div><div class="bar-lbl">Feb</div></div>
                <div class="bar-col"><div class="bar-fill" style="height:80%"></div><div class="bar-lbl">Mar</div></div>
                <div class="bar-col"><div class="bar-fill" style="height:65%"></div><div class="bar-lbl">Apr</div></div>
            </div>
        </div>
        <div class="revenue-card">
            <div class="rc-title">Pendapatan</div>
            <div class="rc-total">Rp 12.345.000</div>
            <div class="rc-row"><div class="rc-label">Iklan</div><div class="rc-val">Rp 8.000.000</div></div>
            <div class="rc-row"><div class="rc-label">Langganan</div><div class="rc-val">Rp 4.345.000</div></div>
        </div>
    </div>
</div>
@endsection