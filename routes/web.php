<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\UMKMController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\KonsultanController;
use App\Http\Controllers\Admin\KepalaUPTDController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Auth\RegisterUmkmController;
use App\Http\Controllers\Umkm\DashboardUmkmController;
use App\Http\Controllers\Umkm\UmkmPembinaanController;
use App\Http\Controllers\Umkm\UmkmKonsultasiController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JenisPembinaanController;
use App\Http\Controllers\Admin\TopikPembinaanController;
use App\Http\Controllers\Admin\JadwalPembinaanController;
use App\Http\Controllers\Admin\RiwayatKegiatanController;
use App\Http\Controllers\Admin\TopikKonsultasiController;
use App\Http\Controllers\Admin\JadwalKonsultasiController;
use App\Http\Middleware\RedirectIfAuthenticatedToDashboard;
use App\Http\Controllers\Konsultan\DashboardKonsultanController;
use App\Http\Controllers\Konsultan\KonsultanKonsultasiController;
use App\Http\Controllers\KepalaUPTD\DashboardKepalaUPTDController;

Route::middleware([RedirectIfAuthenticatedToDashboard::class])->group(function () {
    // Route::get('/', function () { return view('landing.beranda'); });
    Route::get('/', [LandingController::class, 'index']);
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register/umkm', [RegisterUmkmController::class, 'showForm'])->name('register.umkm.form');
    Route::post('/register/umkm', [RegisterUmkmController::class, 'register'])->name('register.umkm');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // ROLE ADMIN
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->name('dashboard.admin');

        // kelola umkm
        Route::get('/dashboard/admin/masterdata', [MasterDataController::class, 'MasterDataIndex'])->name('admin.masterdata.index');
        Route::post('/dashboard/admin/umkm/{id}/delete', [UMKMController::class, 'destroy'])->name('admin.umkm.destroy');

        // kelola konsultan
        Route::get('/dashboard/admin/konsultan/create', [KonsultanController::class, 'create'])->name('admin.konsultan.create');
        Route::post('/admin/konsultan/store', [KonsultanController::class, 'store'])->name('admin.konsultan.store');
        Route::get('/dashboard/admin/konsultan/{id}/edit', [KonsultanController::class, 'edit'])->name('admin.konsultan.edit');
        Route::post('/dashboard/admin/konsultan/{id}/update', [KonsultanController::class, 'update'])->name('admin.konsultan.update');
        Route::post('/admin/konsultan/{id}/delete', [KonsultanController::class, 'destroy'])->name('admin.konsultan.destroy');

        // kelola kepala uptd
        Route::get('/dashboard/admin/kepala-uptd/create', [KepalaUPTDController::class, 'create'])->name('admin.kepalauptd.create');
        Route::post('/admin/kepala-uptd/store', [KepalaUPTDController::class, 'store'])->name('admin.kepalauptd.store');
        Route::get('/dashboard/admin/kepala-uptd/{id}/edit', [KepalaUPTDController::class, 'edit'])->name('admin.kepalauptd.edit');
        Route::post('/dashboard/admin/kepala-uptd/{id}/update', [KepalaUPTDController::class, 'update'])->name('admin.kepalauptd.update');
        Route::post('/admin/kepala-uptd/{id}/delete', [KepalaUPTDController::class, 'destroy'])->name('admin.kepalauptd.destroy');

        // kelola topik konsultan
        Route::get('/dashboard/admin/topik-konsultasi', [TopikKonsultasiController::class, 'Index'])->name('admin.topik-konsultasi.index');
        Route::get('/dashboard/admin/topik-konsultasi/create', [TopikKonsultasiController::class, 'create'])->name('admin.topik-konsultasi.create');
        Route::post('/dashboard/admin/topik-konsultasi/store', [TopikKonsultasiController::class, 'store'])->name('admin.topik-konsultasi.store');
        Route::get('/dashboard/admin/topik-konsultasi/{id}/edit', [TopikKonsultasiController::class, 'edit'])->name('admin.topik-konsultasi.edit');
        Route::put('/dashboard/admin/topik-konsultasi/{id}/update', [TopikKonsultasiController::class, 'update'])->name('admin.topik-konsultasi.update');
        Route::delete('/dashboard/admin/topik-konsultasi/{id}/delete', [TopikKonsultasiController::class, 'destroy'])->name('admin.topik-konsultasi.destroy');

        // kelola permintaan & jadwal konsultasi
        Route::get('/dashboard/admin/jadwal-konsultasi', [JadwalKonsultasiController::class, 'Index'])->name('dashboard.admin.jadwalkonsultasi.index');
        Route::put('/dashboard/admin/update-permintaan/{id}/status', [JadwalKonsultasiController::class, 'UpdateStatusPermintaan']);
        Route::put('/dashboard/admin/permintaan-konsultasi/{id}/penjadwalan', [JadwalKonsultasiController::class, 'PenjadwalanKonsultasi']);
        Route::get('/dashboard/admin/jadwal/{id}/edit', [JadwalKonsultasiController::class, 'EditJadwal'])
            ->name('dashboard.admin.jadwalkonsultasi.edit');
        Route::put('/dashboard/admin/jadwal/{id}', [JadwalKonsultasiController::class, 'UpdateJadwal'])
            ->name('dashboard.admin.jadwalkonsultasi.update');

        // kelola pembinaan
        Route::get('/dashboard/admin/jenis-pembinaan', [JenisPembinaanController::class, 'Index'])->name('admin.jenis-pembinaan.index');
        Route::get('/dashboard/admin/jenis-pembinaan/create', [JenisPembinaanController::class, 'create'])->name('admin.jenis-pembinaan.create');
        Route::post('/dashboard/admin/jenis-pembinaan/store', [JenisPembinaanController::class, 'store'])->name('admin.jenis-pembinaan.store');
        Route::get('/dashboard/admin/jenis-pembinaan/{id}/edit', [JenisPembinaanController::class, 'edit'])->name('admin.jenis-pembinaan.edit');
        Route::put('/dashboard/admin/jenis-pembinaan/{id}/update', [JenisPembinaanController::class, 'update'])->name('admin.jenis-pembinaan.update');
        Route::delete('/dashboard/admin/jenis-pembinaan/{id}/delete', [JenisPembinaanController::class, 'destroy'])->name('admin.jenis-pembinaan.destroy');

        // topik pembinaan
        Route::get('/dashboard/admin/topik-pembinaan', [TopikPembinaanController::class, 'Index'])->name('admin.topik-pembinaan.index');
        Route::get('/dashboard/admin/topik-pembinaan/create', [TopikPembinaanController::class, 'create'])->name('admin.topik-pembinaan.create');
        Route::post('/dashboard/admin/topik-pembinaan/store', [TopikPembinaanController::class, 'store'])->name('admin.topik-pembinaan.store');
        Route::get('/dashboard/admin/topik-pembinaan/{id}/edit', [TopikPembinaanController::class, 'edit'])->name('admin.topik-pembinaan.edit');
        Route::put('/dashboard/admin/topik-pembinaan/{id}/update', [TopikPembinaanController::class, 'update'])->name('admin.topik-pembinaan.update');
        Route::delete('/dashboard/admin/topik-pembinaan/{id}/delete', [TopikPembinaanController::class, 'destroy'])->name('admin.topik-pembinaan.destroy');

        // jadwal pembinaan
        Route::get('/dashboard/admin/jadwal-pembinaan', [JadwalPembinaanController::class, 'Index'])->name('admin.jadwal-pembinaan.index');
        Route::get('/dashboard/admin/jadwal-pembinaan/create', [JadwalPembinaanController::class, 'create'])->name('admin.jadwal-pembinaan.create');
        Route::post('/dashboard/admin/jadwal-pembinaan/store', [JadwalPembinaanController::class, 'store'])->name('admin.jadwal-pembinaan.store');
        Route::get('/dashboard/admin/jadwal-pembinaan/{id}/edit', [JadwalPembinaanController::class, 'edit'])->name('admin.jadwal-pembinaan.edit');
        Route::put('/dashboard/admin/jadwal-pembinaan/{id}/update', [JadwalPembinaanController::class, 'update'])->name('admin.jadwal-pembinaan.update');
        Route::delete('/dashboard/admin/jadwal-pembinaan/{id}/delete', [JadwalPembinaanController::class, 'destroy'])->name('admin.jadwal-pembinaan.destroy');

        Route::get('/dashboard/admin/jadwal-pembinaan/{id}/peserta', [JadwalPembinaanController::class, 'peserta'])->name('admin.jadwal-pembinaan.peserta');

        // riwayat kegiatan
        Route::get('/dashboard/admin/riwayat-kegiatan-konsultasi', [RiwayatKegiatanController::class, 'IndexRiwayatKonsultasi'])->name('admin.riwayat-kegiatan.konsultasi');
        Route::get('/dashboard/admin/riwayat-kegiatan-pembinaan', [RiwayatKegiatanController::class, 'IndexRiwayatPembinaan'])->name('admin.riwayat-kegiatan.pembinaan');

    });


    // ROLE UMKM
    Route::middleware(['auth', 'role:umkm'])->group(function () {
        Route::get('/dashboard/umkm', [DashboardUmkmController::class, 'index'])->name('dashboard.umkm.index');
        Route::get('/dashboard/umkm/profil', [DashboardUmkmController::class, 'profil'])->name('dashboard.umkm.profil');
        Route::get('/dashboard/umkm/{id}/edit', [DashboardUmkmController::class, 'edit'])->name('dashboard.umkm.edit');
        Route::put('/dashboard/admin/umkm/{id}/update', [DashboardUmkmController::class, 'update'])->name('dashboard.umkm.update');

        Route::get('/dashboard/umkm/konsultasi', [UmkmKonsultasiController::class, 'index'])->name('dashboard.umkm.konsultasi.index');
        Route::get('/dashboard/umkm/konsultasi/create', [UmkmKonsultasiController::class, 'create'])->name('dashboard.umkm.konsultasi.create');
        Route::post('/dashboard/umkm/konsultasi/store', [UmkmKonsultasiController::class, 'store'])->name('dashboard.umkm.konsultasi.store');
        Route::delete('/dashboard/admin/konsultasi/{id}/delete', [UmkmKonsultasiController::class, 'destroy'])->name('dashboard.umkm.konsultasi.cancel');
        Route::prefix('dashboard/umkm/konsultasi')->name('dashboard.umkm.konsultasi.')->group(function () {
            // Halaman feedback (form)
            Route::get('/{id}/feedback', [UmkmKonsultasiController::class, 'feedbackForm'])
                ->name('feedback');

            // Submit feedback
            Route::post('/{id}/feedback', [UmkmKonsultasiController::class, 'feedbackStore'])
                ->name('feedback.store');
        });
        
        Route::get('/dashboard/umkm/pembinaan', [UmkmPembinaanController::class, 'index'])->name('dashboard.umkm.pembinaan.index');
        Route::post('/dashboard/umkm/pembinaan/apply/{id}', [UmkmPembinaanController::class, 'apply'])->name('dashboard.umkm.pembinaan.apply');
        Route::get('/dashboard/umkm/pembinaan/list-kegiatan-pembinaan', [UmkmPembinaanController::class, 'listPembinaan'])->name('dashboard.umkm.pembinaan.listpembinaan');
        Route::post('/dashboard/umkm/pembinaan/absen/{id}', [UmkmPembinaanController::class, 'absen'])->name('dashboard.umkm.pembinaan.absen');
        Route::prefix('dashboard/umkm/pembinaan')->name('dashboard.umkm.pembinaan.')->middleware(['auth'])->group(function () {
            // Feedback Pembinaan
            Route::get('/{id}/feedback', [UmkmPembinaanController::class, 'feedbackForm'])->name('feedback');
            Route::post('/{id}/feedback', [UmkmPembinaanController::class, 'feedbackStore'])->name('feedback.store');
        });

    });


    // ROLE KONSULTAN
    Route::middleware(['auth', 'role:konsultan'])->group(function () {
        Route::get('/dashboard/konsultan', [DashboardKonsultanController::class, 'index'])->name('dashboard.konsultan.index');
        Route::get('/dashboard/konsultan/profil', [DashboardKonsultanController::class, 'profil'])->name('dashboard.konsultan.profil');
        Route::get('/dashboard/konsultan/{id}/edit', [DashboardKonsultanController::class, 'edit'])->name('dashboard.konsultan.edit');
        Route::put('/dashboard/konsultan/{id}', [DashboardKonsultanController::class, 'update'])->name('dashboard.konsultan.update');

        Route::get('/dashboard/konsultan/konsultasi', [KonsultanKonsultasiController::class, 'index'])->name('dashboard.konsultan.konsultasi.index');
        Route::get('/hasil-konsultasi/{jadwalId}', [KonsultanKonsultasiController::class, 'isiHasilKonsultasi'])->name('konsultan.hasil-konsultasi.form');
        Route::post('/hasil-konsultasi/{jadwalId}', [KonsultanKonsultasiController::class, 'simpanHasilKonsultasi'])->name('konsultan.hasil-konsultasi.simpan');
    });

    // ROLE KEPALA UPTD
    Route::middleware(['auth', 'role:kepala_uptd'])->group(function () {
        Route::get('/dashboard/kepala-uptd', [DashboardKepalaUPTDController::class, 'index'])->name('dashboard.kepalauptd.index');
        Route::get('/dashboard/kepala-uptd/profil', [DashboardKepalaUPTDController::class, 'profil'])->name('dashboard.kepalauptd.profil');
        Route::get('/dashboard/kepala-uptd/{id}/edit', [DashboardKepalaUPTDController::class, 'edit'])->name('dashboard.kepalauptd.edit');
        Route::put('/dashboard/kepala-uptd/{id}', [DashboardKepalaUPTDController::class, 'update'])->name('dashboard.kepalauptd.update');

        Route::get('/dashboard/kepala-uptd/laporan', [DashboardKepalaUPTDController::class, 'laporanpembinaan'])->name('dashboard.kepalauptd.laporan');
        Route::get('/dashboard/kepala-uptd/laporan-kegiatan-konsultasi', [DashboardKepalaUPTDController::class, 'laporankonsultasi'])->name('dashboard.kepalauptd.laporankonsultasi');

        Route::get('/laporan/export/pembinaan', [DashboardKepalaUPTDController::class, 'exportPembinaan'])
            ->name('laporan.export.pembinaan');
        Route::get('/laporan/export/konsultasi', [DashboardKepalaUPTDController::class, 'exportKonsultasi'])
            ->name('laporan.export.konsultasi');
    });
});
