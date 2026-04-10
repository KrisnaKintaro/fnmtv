@extends('Viewers.master_viewers')

@section('css')
    @endsection

@section('konten')
<div class="container page-anim">
    <div class="main-grid">

        <div class="main-content">

            <div class="page-header">
                <div class="ph-breadcrumb">
                    <a href="/">Home</a> / <span>Kategori Politik</span>
                </div>
                <div class="ph-title">
                    Berita Politik Terkini
                </div>
                <div class="ph-count">Menampilkan 120 artikel</div>
            </div>

            <div class="sr-filters" style="margin-bottom: 24px;">
                <div class="sr-filter-chip active">Terbaru</div>
                <div class="sr-filter-chip">Terpopuler</div>
                <div class="sr-filter-chip">Bulan Ini</div>
            </div>

            <hr class="sec-divider">

            <div class="news-list">

                <div class="news-list-item" onclick="window.location.href='#'">
                    <div class="nli-img">🏛️</div>
                    <div>
                        <div class="nli-cat cat-politik">Politik</div>
                        <div class="nli-title">RUU Pemilu Resmi Disahkan DPR dalam Rapat Paripurna Hari Ini</div>
                        <div class="nli-meta">2 Jam lalu · Oleh Budi Santoso · 👁 12.5K views</div>
                    </div>
                </div>

                <div class="news-list-item" onclick="window.location.href='#'">
                    <div class="nli-img">🗣️</div>
                    <div>
                        <div class="nli-cat cat-politik">Politik</div>
                        <div class="nli-title">Debat Terbuka Calon Gubernur DKI Jakarta Akan Digelar Minggu Depan</div>
                        <div class="nli-meta">5 Jam lalu · Oleh Rina Agustina · 👁 8K views</div>
                    </div>
                </div>

                <div class="news-list-item" onclick="window.location.href='#'">
                    <div class="nli-img">🗳️</div>
                    <div>
                        <div class="nli-cat cat-politik">Politik</div>
                        <div class="nli-title">KPU Umumkan Jadwal Resmi Pendaftaran Calon Kepala Daerah</div>
                        <div class="nli-meta">1 Hari lalu · Oleh Arif Wibowo · 👁 21K views</div>
                    </div>
                </div>

                <div class="news-list-item" onclick="window.location.href='#'">
                    <div class="nli-img">🤝</div>
                    <div>
                        <div class="nli-cat cat-politik">Politik</div>
                        <div class="nli-title">Dua Partai Besar Bentuk Koalisi Baru Hadapi Pilkada Serentak</div>
                        <div class="nli-meta">2 Hari lalu · Oleh Sari Maharani · 👁 15K views</div>
                    </div>
                </div>

            </div>

            <div style="margin-top: 30px; display: flex; justify-content: center;">
                <button class="btn btn-outline">Lebih Banyak ➔</button>
            </div>

        </div> <div class="sidebar-col">
            @include('Viewers.layout.sidebar')
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        console.log("Halaman Kategori berhasil di-load!");
    });
</script>
@endsection
