@extends('layouts.master')

@section('title','Dashboard')
@section('page_title','Dashboard')

@section('content')
<div id="page-dashboard" class="page active">
    <div class="section-title">Statistik Performa</div>
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-ico">📰</div>
        <div class="stat-val">2,847</div>
        <div class="stat-lbl">Total Berita</div>
        <div class="stat-chg chg-up">▲ +14 artikel hari ini</div>
      </div>
      <div class="stat-card">
        <div class="stat-ico">👁</div>
        <div class="stat-val">184K</div>
        <div class="stat-lbl">Total Kunjungan</div>
        <div class="stat-chg chg-up">▲ +8.3% minggu ini</div>
      </div>
      <div class="stat-card">
        <div class="stat-ico">💰</div>
        <div class="stat-val">Rp 12,4M</div>
        <div class="stat-lbl">Total Pendapatan</div>
        <div class="stat-chg chg-up">▲ +Rp 1.2M bulan ini</div>
      </div>
      <div class="stat-card">
        <div class="stat-ico">💬</div>
        <div class="stat-val">1,024</div>
        <div class="stat-lbl">Total Komentar</div>
        <div class="stat-chg chg-dn">▼ 12 perlu moderasi</div>
      </div>
    </div>

    <div class="two-col-dash">
      <!-- Chart Kunjungan (UC-07) -->
      <div class="chart-area">
        <div class="chart-head">
          <div class="chart-title">Tren Kunjungan Mingguan</div>
          <select class="filter-select" style="width:auto;padding:5px 10px;font-size:12px;">
            <option>7 Hari Terakhir</option>
            <option>30 Hari Terakhir</option>
          </select>
        </div>
        <div class="chart-bars">
          <div class="bar-col"><div class="bar-val">18K</div><div class="bar-fill" style="height:60%;"></div><div class="bar-lbl">Sen</div></div>
          <div class="bar-col"><div class="bar-val">24K</div><div class="bar-fill" style="height:80%;"></div><div class="bar-lbl">Sel</div></div>
          <div class="bar-col"><div class="bar-val">19K</div><div class="bar-fill" style="height:63%;"></div><div class="bar-lbl">Rab</div></div>
          <div class="bar-col"><div class="bar-val">30K</div><div class="bar-fill" style="height:100%;"></div><div class="bar-lbl">Kam</div></div>
          <div class="bar-col"><div class="bar-val">28K</div><div class="bar-fill" style="height:93%;"></div><div class="bar-lbl">Jum</div></div>
          <div class="bar-col"><div class="bar-val">22K</div><div class="bar-fill" style="height:73%;opacity:.5"></div><div class="bar-lbl">Sab</div></div>
          <div class="bar-col"><div class="bar-val">43K</div><div class="bar-fill" style="height:100%;background:#1a3a7a"></div><div class="bar-lbl">Min</div></div>
        </div>
        <div class="legend">
          <div class="leg-item"><div class="leg-dot" style="background:var(--red)"></div>Hari Kerja</div>
          <div class="leg-item"><div class="leg-dot" style="background:var(--blue)"></div>Weekend</div>
        </div>
      </div>
      <div class="revenue-card">
        <div class="rc-title">Pendapatan</div>
        <div class="rc-total">Rp 12,4M</div>
        <div class="rc-row"><div class="rc-label">Iklan</div><div class="rc-val">Rp 8,000,000</div></div>
        <div class="rc-row"><div class="rc-label">Langganan</div><div class="rc-val">Rp 4,400,000</div></div>
      </div>
    </div>
  </div>
@endsection