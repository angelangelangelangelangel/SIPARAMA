<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TentangP2MController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestUrineController;
use App\Http\Controllers\PesertaTestUrineController;
use App\Http\Controllers\PenyuluhanController;
use App\Http\Controllers\PenggiatController;
use App\Http\Controllers\DesaBersinarController;
use App\Http\Controllers\DokumentasiController;


// AUTH
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }

    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])
    ->name('forgot.password');


// DASHBOARD (ADMIN + PEGAWAI + KEPALA BIDANG)
Route::middleware(['auth', 'role:Admin,Pegawai,Kepala Bidang P2M'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [DashboardController::class, 'analytics']);
   Route::get('/tentang-p2m', [TentangP2MController::class, 'index'])->name('tentang.p2m');

});


// USERS (ADMIN ONLY)
    Route::middleware(['auth', 'role:Admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])
    ->name('users.toggleStatus');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});


// OPERASIONAL (ADMIN + PEGAWAI)
    Route::middleware(['auth', 'role:Admin,Pegawai'])->group(function () {


// TEST URINE
    Route::resource('test-urine', TestUrineController::class)->except(['show']);

    Route::get('/test-urine/{slug}',[TestUrineController::class, 'detail']);

    Route::post('/peserta/store', [PesertaTestUrineController::class, 'storeGlobal']);
    Route::put('/peserta/{id}', [PesertaTestUrineController::class, 'update']);
    Route::delete('/peserta/{id}', [PesertaTestUrineController::class, 'destroy']);

    Route::post('/test-urine/{id}/dokumentasi/store', [DokumentasiController::class, 'store']);


// PENYULUHAN
    Route::resource('penyuluhan', PenyuluhanController::class) ->except(['create', 'edit', 'show']);

    Route::get('/penyuluhan/{slug}',[PenyuluhanController::class, 'detail']);

    Route::post('/penyuluhan/{id}/detail', [PenyuluhanController::class, 'storeDetail']);
    Route::put('/detail-penyuluhan/{id}', [PenyuluhanController::class, 'updateDetail']);
    Route::delete('/detail-penyuluhan/{id}', [PenyuluhanController::class, 'destroyDetail']);


// PENGGIAT
    Route::resource('penggiat', PenggiatController::class);


// DESA BERSINAR
    Route::resource('desa-bersinar', DesaBersinarController::class)->except(['create','edit','show']);

    Route::get('/desa-bersinar/{slug}', [DesaBersinarController::class, 'detail']);
    Route::post('/desa-bersinar/{id}/kegiatan',[DesaBersinarController::class, 'storeKegiatan']);

    Route::put('/detail-desa-bersinar/{id}',[DesaBersinarController::class, 'updateKegiatan']);
    Route::delete('/detail-desa-bersinar/{id}',[DesaBersinarController::class, 'destroyKegiatan']);
    });


// DOKUMENTASI (SEMUA ROLE LOGIN)
    Route::redirect(
        '/dokumentasi',
        '/dokumentasi/test-urine');
    Route::middleware(['auth', 'role:Admin,Pegawai,Kepala Bidang P2M'])->group(function () {

    Route::get('/dokumentasi/test-urine', [DokumentasiController::class, 'testUrine']);
    Route::get('/dokumentasi/penyuluhan', [DokumentasiController::class, 'penyuluhan']);
    Route::get('/dokumentasi/desa-bersinar', [DokumentasiController::class, 'desaBersinar']);
    Route::get('/dokumentasi/desa-bersinar/{id}', [DokumentasiController::class, 'detailDesaBersinar']);
    Route::get('/dokumentasi/search-kegiatan', [DokumentasiController::class, 'searchKegiatan']);

    Route::post('/dokumentasi/store', [DokumentasiController::class, 'store']);
    Route::put('/dokumentasi/{id}', [DokumentasiController::class, 'update']);
    Route::delete('/dokumentasi/{id}', [DokumentasiController::class, 'destroy']);

});


// LAPORAN (ADMIN ONLY)
Route::middleware(['auth', 'role:Admin'])->group(function () {

// TEST URINE
    Route::get('/laporan/test-urine', [TestUrineController::class, 'laporan']);
    Route::get('/laporan/test-urine/print', [TestUrineController::class, 'print']);
    Route::get('/laporan/test-urine/excel', [TestUrineController::class, 'exportExcel']);
    Route::get('/laporan/test-urine/pdf', [TestUrineController::class, 'exportPdf']);


// PENYULUHAN
    Route::get('/laporan/penyuluhan', [PenyuluhanController::class, 'laporan']);
    Route::get('/laporan/penyuluhan/print', [PenyuluhanController::class, 'print']);
    Route::get('/laporan/penyuluhan/excel', [PenyuluhanController::class, 'exportExcel']);
    Route::get('/laporan/penyuluhan/pdf', [PenyuluhanController::class, 'exportPdf']);


// DESA BERSINAR
    Route::get('/laporan/desa-bersinar', [DesaBersinarController::class, 'laporan']);
    Route::get('/laporan/desa-bersinar/print', [DesaBersinarController::class, 'print']);
    Route::get('/laporan/desa-bersinar/excel', [DesaBersinarController::class, 'exportExcel']);
    Route::get('/laporan/desa-bersinar/pdf', [DesaBersinarController::class, 'exportPdf']);


// PENGGIAT
    Route::get('/laporan/penggiat', [PenggiatController::class, 'laporan']);
    Route::get('/laporan/penggiat/print', [PenggiatController::class, 'print']);
    Route::get('/laporan/penggiat/excel', [PenggiatController::class, 'exportExcel']);
    Route::get('/laporan/penggiat/pdf', [PenggiatController::class, 'exportPdf']);

});
    