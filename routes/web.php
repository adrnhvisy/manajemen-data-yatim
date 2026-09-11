<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kelurahan\ChildRecordController as KelurahanChildRecordController;
use App\Http\Controllers\Kelurahan\DashboardController as KelurahanDashboardController;
use App\Http\Controllers\Kelurahan\ReportController as KelurahanReportController;
use App\Http\Controllers\Kecamatan\DashboardController as KecamatanDashboardController;
use App\Http\Controllers\Kecamatan\ReportController as KecamatanReportController;
use App\Http\Controllers\Kecamatan\ReviewController as KecamatanReviewController;
use App\Http\Controllers\Kesra\DashboardController as KesraDashboardController;
use App\Http\Controllers\Kesra\ReportController as KesraReportController;
use App\Http\Controllers\Kesra\VerificationController as KesraVerificationController;

Route::get('/', DashboardController::class)->name('home');

Route::prefix('kelurahan')->name('kelurahan.')->group(function () {
    Route::get('/dashboard', KelurahanDashboardController::class)->name('dashboard');
    Route::resource('anak', KelurahanChildRecordController::class)->names('anak');
    Route::get('/laporan', [KelurahanReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [KelurahanReportController::class, 'print'])->name('laporan.print');
});

Route::prefix('kecamatan')->name('kecamatan.')->group(function () {
    Route::get('/dashboard', KecamatanDashboardController::class)->name('dashboard');
    Route::get('/anak', [KecamatanReviewController::class, 'index'])->name('anak.index');
    Route::get('/anak/{childRecord}', [KecamatanReviewController::class, 'show'])->name('anak.show');
    Route::post('/anak/{childRecord}/kembalikan', [KecamatanReviewController::class, 'return'])->name('anak.return');
    Route::post('/anak/{childRecord}/loloskan', [KecamatanReviewController::class, 'forward'])->name('anak.forward');
    Route::get('/laporan', [KecamatanReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [KecamatanReportController::class, 'print'])->name('laporan.print');
});

Route::prefix('kesra')->name('kesra.')->group(function () {
    Route::get('/dashboard', KesraDashboardController::class)->name('dashboard');
    Route::get('/anak', [KesraVerificationController::class, 'index'])->name('anak.index');
    Route::get('/anak/{childRecord}', [KesraVerificationController::class, 'show'])->name('anak.show');
    Route::post('/anak/{childRecord}/setujui', [KesraVerificationController::class, 'approve'])->name('anak.approve');
    Route::post('/anak/{childRecord}/tolak', [KesraVerificationController::class, 'reject'])->name('anak.reject');
    Route::get('/laporan', [KesraReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [KesraReportController::class, 'print'])->name('laporan.print');
});
