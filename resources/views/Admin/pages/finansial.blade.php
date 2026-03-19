@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
  <!-- ══ PAGE: FINANCE (UC-05) ══ -->
  <div id="page-finance" class="page active">
    <div class="section-title">Administrasi Finansial</div>
    <div class="finance-grid">
      <div class="fin-card"><div class="fin-ico">💰</div><div class="fin-val fin-green">Rp 12,4M</div><div class="fin-lbl">Total Pendapatan</div></div>
      <div class="fin-card"><div class="fin-ico">✅</div><div class="fin-val fin-green">Rp 9,2M</div><div class="fin-lbl">Sudah Dibayar</div></div>
      <div class="fin-card"><div class="fin-ico">⏳</div><div class="fin-val fin-orange">Rp 3,2M</div><div class="fin-lbl">Belum Dibayar</div></div>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
      <div class="filter-bar" style="margin:0">
        <select class="filter-select"><option>Semua Status</option><option>Paid</option><option>Unpaid</option></select>
        <select class="filter-select"><option>Bulan Ini</option><option>Bulan Lalu</option><option>3 Bulan Terakhir</option></select>
      </div>
      <button class="btn btn-red btn-sm" onclick="document.getElementById('modalFinance').classList.add('open')">+ Input Pendapatan</button>
    </div>
    <div class="card">
      <table>
        <thead><tr><th>Judul Artikel</th><th>Penulis</th><th>Nominal</th><th>Status Bayar</th><th>Tgl Input</th><th>Aksi</th></tr></thead>
        <tbody>
          <tr><td><div class="tbl-title">Pemerintah Umumkan Kebijakan Baru...</div></td><td style="font-size:12px;color:var(--muted)">Budi S.</td><td style="font-family:'JetBrains Mono';font-size:13px;font-weight:600;">Rp 750.000</td><td><span class="badge b-paid">✓ Paid</span></td><td style="font-size:12px;color:var(--muted)">10 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🔄</div></div></td></tr>
          <tr><td><div class="tbl-title">Timnas Garuda Menang Telak 3-0</div></td><td style="font-size:12px;color:var(--muted)">Rina A.</td><td style="font-family:'JetBrains Mono';font-size:13px;font-weight:600;">Rp 500.000</td><td><span class="badge b-unpaid">⏳ Unpaid</span></td><td style="font-size:12px;color:var(--muted)">10 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🔄</div></div></td></tr>
          <tr><td><div class="tbl-title">Film Indonesia Raih Penghargaan Berlin</div></td><td style="font-size:12px;color:var(--muted)">Sari M.</td><td style="font-family:'JetBrains Mono';font-size:13px;font-weight:600;">Rp 400.000</td><td><span class="badge b-paid">✓ Paid</span></td><td style="font-size:12px;color:var(--muted)">9 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🔄</div></div></td></tr>
          <tr><td><div class="tbl-title">Rupiah Menguat Terhadap Dolar AS</div></td><td style="font-size:12px;color:var(--muted)">Arif W.</td><td style="font-family:'JetBrains Mono';font-size:13px;font-weight:600;">Rp 600.000</td><td><span class="badge b-unpaid">⏳ Unpaid</span></td><td style="font-size:12px;color:var(--muted)">8 Mar 2026</td><td><div class="act-btns"><div class="ico-btn">✏️</div><div class="ico-btn">🔄</div></div></td></tr>
        </tbody>
      </table>
      <div class="pager"><div class="pg-btn">‹</div><div class="pg-btn active">1</div><div class="pg-btn">2</div><div class="pg-btn">›</div><div class="pg-info">1–4 dari 38 transaksi</div></div>
    </div>
  </div>
@endsection
@section('js')
@endsection
