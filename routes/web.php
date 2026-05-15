<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Markom\HomeController;
use App\Http\Controllers\Admin\Markom\ArticleController;
use App\Http\Controllers\Admin\Markom\NewsController;
use App\Http\Controllers\Admin\Markom\ProgramController;
use App\Http\Controllers\Admin\Markom\CareerController;
use App\Http\Controllers\Admin\Markom\VolunteerController;
use App\Http\Controllers\Admin\Markom\FaqController;
use App\Http\Controllers\Admin\Markom\MitraController;
use App\Http\Controllers\Admin\Operasional\DonaturController;
use App\Http\Controllers\Admin\Operasional\KonfirmasiDonasiController;
use App\Http\Controllers\Admin\Operasional\BantuanController;
use App\Http\Controllers\Admin\Operasional\KemitraanController;
use App\Http\Controllers\Admin\Operasional\KarirController;
use App\Http\Controllers\Admin\SuperAdmin\UserController;

// Auth
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Protected routes
    Route::middleware('auth')->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Markom
        Route::prefix('markom')->name('markom.')->group(function () {
            Route::resource('home', HomeController::class);
            Route::resource('article', ArticleController::class);
            Route::resource('news', NewsController::class);
            Route::resource('program', ProgramController::class);
            Route::resource('career', CareerController::class);
            Route::resource('volunteer', VolunteerController::class);
            Route::resource('faq', FaqController::class);
            Route::resource('mitra', MitraController::class);
        });

        // Operasional
        Route::prefix('operasional')->name('operasional.')->group(function () {
            Route::resource('donatur', DonaturController::class);
            Route::resource('konfirmasi-donasi', KonfirmasiDonasiController::class);
            Route::resource('bantuan', BantuanController::class);
            Route::resource('kemitraan', KemitraanController::class);
            Route::resource('karir', KarirController::class);
        });

        // Super Admin
        Route::middleware('role:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
            Route::resource('user', UserController::class);
        });

    });

});
