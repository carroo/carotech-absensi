<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::middleware(['checkrole:admin'])->group(function () {
        Route::get('kelas', [KelasController::class, 'index'])->name('kelas');
        Route::post('kelas', [KelasController::class, 'tambah'])->name('kelas.tambah');
        Route::post('kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
        Route::get('kelas_del/{id}', [KelasController::class, 'hapus'])->name('kelas.hapus');

        Route::get('guru', [UserController::class, 'guru'])->name('guru');
        Route::get('administrasi', [UserController::class, 'administrasi'])->name('administrasi');
        Route::get('siswa', [UserController::class, 'siswa'])->name('siswa');


        Route::post('user/{role}', [UserController::class, 'tambah'])->name('user.tambah');
        Route::get('user_del/{id}', [UserController::class, 'hapus'])->name('user.hapus');

        Route::get('laporan', [AbsensiController::class, 'laporan'])->name('laporan');
        // Rute-rute yang hanya dapat diakses oleh admin
    });

    Route::middleware(['checkrole:guru'])->group(function () {
        Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi');
        Route::post('absensi', [AbsensiController::class, 'simpan'])->name('absensi.simpan');
    });
    Route::post('user_update/{id}', [UserController::class, 'update'])->name('user.update');
    // Rute-rute yang hanya dapat diakses oleh admin
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
});
