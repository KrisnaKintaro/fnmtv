<?php

use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanFinansialController;
use App\Http\Controllers\Admin\moderasiKomentarController;
use App\Http\Controllers\Admin\StatistikInteraksiBeritaController;
use App\Http\Controllers\Admin\TopPerformanceController;
use App\Http\Controllers\Admin\TrackingPembayaranController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


















Route::prefix('admin/manajemen_kategori')->group(function() {
    Route::get('/ambilData',[KategoriController::class, 'getDaftarKategori']);
    Route::post('/tambahData', [KategoriController::class, 'tambahKategoriBaru']);
    Route::put('/ubahData/{id_kategori}', [KategoriController::class, 'ubahDataKategori']);
    Route::delete('/hapusData/{id_kategori}', [KategoriController::class, 'hapusKategori']);
});

Route::prefix('admin/manajemen_user')->group(function() {
    Route::get('/ambilData',[UserController::class, 'getDaftarPengguna']);
    Route::post('/tambahData', [UserController::class, 'tambahPenggunaBaru']);
    Route::put('/ubahData/{id_user}', [UserController::class, 'ubahDataPengguna']);
    Route::delete('/hapusData/{id_user}', [UserController::class, 'hapusPengguna']);
});

Route::prefix('admin/manajemen_komentar')->group(function(){
    Route::get('/ambilData',[moderasiKomentarController::class, 'getDaftarKomentar']);
    Route::put('/ubahStatus/{id_komentar}',[moderasiKomentarController::class, 'ubahStatusModerasi']);
    Route::delete('/hapusKomentar/{id_komentar}', [moderasiKomentarController::class, 'hapusKomentar']);
});

Route::prefix('admin/tracking_pembayaran')->group(function () {
    Route::get('/ambilData', [TrackingPembayaranController::class, 'getDaftarPembayaran']);
    Route::put('/updatePembayaran/{berita_id}', [TrackingPembayaranController::class, 'updatePembayaran']);
});

Route::prefix('admin/laporan_finansial')->group(function() {
    Route::get('/ambilData', [LaporanFinansialController::class, 'getLaporan']);
});

Route::prefix('admin/statistik_interaksi_berita')->group(function() {
    Route::get('/ambilData', [StatistikInteraksiBeritaController::class, 'getStatistikInteraksi']);
});

Route::prefix('admin/top_performance')->group(function () {
    Route::get('/ambilData', [TopPerformanceController::class, 'getTopPerformance']);
});












































use App\Http\Controllers\Editor\BeritaController;
use App\Http\Controllers\Redaksi\VerifikasiBeritaController;


// Bagian Editor
Route::prefix('editor/manajemen_berita')->group(function() {
    Route::get('/ambilData', [BeritaController::class, 'getDaftarBerita']);
    Route::post('/tambahData', [BeritaController::class, 'tambahBeritaBaru']);
    Route::put('/ubahData/{id_berita}', [BeritaController::class, 'ubahDataBerita']);
    Route::delete('/hapusBerita/{id_berita}', [BeritaController::class, 'hapusDataBerita']);
});

// Group Redaksi
Route::prefix('redaksi')->group(function () {
    Route::get('/masuk', [VerifikasiBeritaController::class, 'index']);
    Route::patch('/verifikasi/{id}', [VerifikasiBeritaController::class, 'verifikasi']);
});

