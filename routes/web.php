<?php

use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\LoginController;
use App\Models\Report;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::get('/admin/dashboard', function(){
    $totalLaporan = Report::count();
    $totalLaporanSelesai = Report::where('status', 'selesai diproses')->count();
    if ($totalLaporan == 0) {
        $totalPersenLaporanSelesai = 0;
    } else {
        $totalPersenLaporanSelesai = $totalLaporanSelesai / $totalLaporan * 100;
        $totalPersenLaporanSelesai = number_format($totalPersenLaporanSelesai, 2);
    }
    $totalLaporanDiProses = Report::where('status', 'sedang diproses')->count();
    $totalLaporanTertunda = Report::where('status', 'belum diproses')->count(); 

    return view('admin.index', [
        'totalLaporan' => $totalLaporan,
        'totalLaporanSelesai' => $totalLaporanSelesai,
        'totalLaporanDiProses' => $totalLaporanDiProses,
        'totalLaporanTertunda' => $totalLaporanTertunda,
        'totalPersenLaporanSelesai' => $totalPersenLaporanSelesai
    ]);
})-> name('admin.index');

Route::resource('/admin/laporan', \App\Http\Controllers\AdminLaporanController::class);
Route::post('/admin/laporan/{laporan}/validasi', [AdminLaporanController::class, 'validasi'])->name('laporan.validasi');
Route::post('/admin/laporan/{laporan}/selesai', [AdminLaporanController::class, 'selesai'])->name('laporan.selesai');

Route::resource('/admin/galeri', \App\Http\Controllers\AdminGaleriController::class);

Route::resource('/admin/artikel', \App\Http\Controllers\AdminArtikelController::class);

Route::get('/admin/akun', function(){
    return view('admin.akun');
})-> name('admin.akun');