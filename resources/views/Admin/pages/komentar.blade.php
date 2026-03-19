@extends('Admin.master_admin')
@section('css')
@endsection
@section('konten')
<!-- ══ PAGE: COMMENTS (UC-06) ══ -->
<div id="page-comments" class="page active">
    <div class="section-title">Moderasi Komentar</div>
    <div class="warn-box">⚠️ Terdapat <b>12 komentar</b> yang perlu ditinjau. Periksa komentar yang berpotensi spam atau
        melanggar aturan komunitas.</div>
    <div class="filter-bar">
        <div class="tab-pills">
            <div class="tab-p active">Semua (348)</div>
            <div class="tab-p">Perlu Review (12)</div>
            <div class="tab-p">Terindikasi Spam (5)</div>
            <div class="tab-p">Disetujui</div>
        </div>
    </div>
    <div class="card">
        <div class="cmt-item">
            <div class="cmt-avatar">R</div>
            <div class="cmt-body">
                <div class="cmt-user">Rizky Pratama <span class="badge b-ok" style="margin-left:6px;">✓ OK</span></div>
                <div class="cmt-article">Pada: "Timnas Garuda Menang Telak 3-0 Lawan Vietnam"</div>
                <div class="cmt-text">Mantap banget timnas kali ini! Semoga bisa terus menang sampai final. Saya bangga
                    sebagai orang Indonesia.</div>
                <div class="cmt-time">10 Mar 2026, 10:30</div>
                <div class="cmt-acts"><button class="btn btn-ghost btn-sm">✓ Setujui</button><button class="btn btn-sm"
                        style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;">🗑
                        Hapus</button></div>
            </div>
        </div>
        <div class="cmt-item" style="background:#fef9f9;">
            <div class="cmt-avatar" style="background:#fde8e8;color:var(--red);">S</div>
            <div class="cmt-body">
                <div class="cmt-user">SpamBot123 <span class="badge b-spam" style="margin-left:6px;">⚠ Spam</span></div>
                <div class="cmt-article">Pada: "Pemerintah Umumkan Kebijakan Ekonomi Baru"</div>
                <div class="cmt-text">Klik disini untuk dapat uang cepat!!! bit.ly/scam123 dapatkan 1 juta rupiah sehari
                    tanpa modal...</div>
                <div class="cmt-time">10 Mar 2026, 09:15</div>
                <div class="cmt-acts"><button class="btn btn-sm"
                        style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;font-weight:600;">🗑
                        Hapus Sekarang</button><button class="btn btn-ghost btn-sm">🚫 Blokir User</button></div>
            </div>
        </div>
        <div class="cmt-item">
            <div class="cmt-avatar" style="background:#1a3a7a;">D</div>
            <div class="cmt-body">
                <div class="cmt-user">Dewi Kartika <span class="badge b-ok" style="margin-left:6px;">✓ OK</span></div>
                <div class="cmt-article">Pada: "IHSG Menguat Tipis di Sesi Pagi"</div>
                <div class="cmt-text">Analisis yang bagus! Tolong dibahas juga pengaruh nilai tukar rupiah terhadap
                    sektor ekspor di artikel berikutnya.</div>
                <div class="cmt-time">10 Mar 2026, 08:44</div>
                <div class="cmt-acts"><button class="btn btn-ghost btn-sm">✓ Setujui</button><button class="btn btn-sm"
                        style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;">🗑
                        Hapus</button></div>
            </div>
        </div>
        <div class="cmt-item" style="background:#fef9f9;">
            <div class="cmt-avatar" style="background:#fde8e8;color:var(--red);">A</div>
            <div class="cmt-body">
                <div class="cmt-user">Anonim User <span class="badge b-spam" style="margin-left:6px;">⚠
                        Terindikasi</span></div>
                <div class="cmt-article">Pada: "Peneliti BRIN Temukan Spesies Baru di Papua"</div>
                <div class="cmt-text">Berita hoaks!!! Ini semua rekayasa pemerintah untuk mengalihkan isu. Jangan
                    percaya media mainstream!!!</div>
                <div class="cmt-time">9 Mar 2026, 22:10</div>
                <div class="cmt-acts"><button class="btn btn-sm"
                        style="background:#fde8e8;color:var(--red);border:none;border-radius:5px;padding:5px 10px;cursor:pointer;font-size:12px;font-weight:600;">🗑
                        Hapus</button><button class="btn btn-ghost btn-sm">🚫 Blokir IP</button></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
