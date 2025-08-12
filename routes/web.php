<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\BobotKriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Registrasi
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Semua route yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Hasil
    Route::get('/hasil/get-data', [HasilController::class, 'getData'])->name('hasil.getData');
    Route::resource('/hasil', HasilController::class)->names('hasil');

    // Route detail hotel untuk semua user
    Route::get('/hotel/{id}', [HotelController::class, 'show'])->name('hotel.show');

    // Profil user
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /**
     * Untuk ADMIN
     */
    Route::middleware('checkRole:admin')->group(function () {

        // Manajemen user
        Route::get('/data-pengguna/get-data', [ManajemenUserController::class, 'getData'])->name('data-pengguna.get-data');
        Route::resource('/data-pengguna', ManajemenUserController::class);
        Route::get('/users/get-data', [ManajemenUserController::class, 'getData']);
        Route::resource('/users', ManajemenUserController::class);

        // Hotel CRUD (tanpa show karena sudah di luar)
        Route::get('/hotels/get-data', [HotelController::class, 'getData'])->name('hotel.getData');
        Route::delete('/hotel/image/{id}', [HotelController::class, 'deleteImage'])->name('hotel.image.delete');
        Route::get('/hotel/getHotelData/{id}', [App\Http\Controllers\HotelController::class, 'getHotelData'])->name('hotel.getHotelData');
        Route::delete('/hotel/{id}', [HotelController::class, 'destroy'])->name('hotel.destroy');
        Route::resource('hotels', HotelController::class)->except(['show'])->names('hotel');

        // Kriteria
        Route::get('/kriteria/get-data', [KriteriaController::class, 'getData'])->name('kriteria.getData');
        Route::resource('kriteria', KriteriaController::class)->names('kriteria');

        // Bobot Kriteria
        Route::get('/bobot-kriteria/get-data', [BobotKriteriaController::class, 'getData'])->name('bobot.getData');
        Route::resource('/bobot-kriteria', BobotKriteriaController::class)
            ->names('bobot')
            ->parameters(['bobot-kriteria' => 'bobot']);

        // Penilaian
        Route::get('/penilaian/get-data', [PenilaianController::class, 'getData'])->name('penilaian.getData');
        Route::resource('/penilaian', PenilaianController::class)->names('penilaian');

        // Perhitungan
        Route::get('/perhitungan/get-data', [PerhitunganController::class, 'getData'])->name('perhitungan.getData');
        Route::resource('/perhitungan', PerhitunganController::class);
    });

    /**
     * Untuk USER biasa
     */
    Route::middleware('checkRole:user')->group(function () {
        // Kalau nanti ada route khusus user, taruh di sini
    });
});

// Auth routes bawaan Laravel Breeze/Fortify
require __DIR__.'/auth.php';

// Redirect kalau route tidak ditemukan
Route::fallback(function () {
    return redirect()->route('login');
});
