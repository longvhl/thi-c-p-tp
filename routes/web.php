<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/station', function () {
    $wards = \App\Models\Ward::has('stations')->orderBy('name')->get();
    return view('frontend.station', compact('wards'));
})->name('station');
Route::get('/review/more', [\App\Http\Controllers\ReviewController::class, 'getMore'])->name('review.more');

// User Auth Views (Breeze POST logic remains linked implicitly)
Route::get('/login', function () { return view('frontend.login'); })->name('login');
Route::get('/register', function () { return view('frontend.register'); })->name('register');

// Protected Routes (Require Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/rental', [RentalController::class, 'create'])->name('rental');
    Route::post('/rental/store', [RentalController::class, 'store'])->name('rental.store');
    
    Route::get('/payment', [RentalController::class, 'paymentForm'])->name('payment');
    Route::post('/payment/return', [RentalController::class, 'returnBike'])->name('payment.return');

    Route::get('/api/stations/{id}/bikes', [RentalController::class, 'getAvailableBikes']);

    Route::get('/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');
    Route::get('/active', [FrontendController::class, 'active'])->name('active');
    Route::get('/history', [FrontendController::class, 'history'])->name('history');

    Route::post('/review/store', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [\App\Http\Controllers\AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin'])->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Bike Management
        Route::get('/bikes', [\App\Http\Controllers\AdminBikeController::class, 'index'])->name('admin.bikes.index');
        Route::get('/bikes/create', [\App\Http\Controllers\AdminBikeController::class, 'create'])->name('admin.bikes.create');
        Route::post('/bikes/store', [\App\Http\Controllers\AdminBikeController::class, 'store'])->name('admin.bikes.store');
        Route::get('/bikes/{id}', [\App\Http\Controllers\AdminBikeController::class, 'show'])->name('admin.bikes.show');
        Route::get('/bikes/{id}/edit', [\App\Http\Controllers\AdminBikeController::class, 'edit'])->name('admin.bikes.edit');
        Route::put('/bikes/{id}', [\App\Http\Controllers\AdminBikeController::class, 'update'])->name('admin.bikes.update');
        Route::delete('/bikes/{id}', [\App\Http\Controllers\AdminBikeController::class, 'destroy'])->name('admin.bikes.destroy');
        Route::get('/bikes/bin/trash', [\App\Http\Controllers\AdminBikeController::class, 'bin'])->name('admin.bikes.bin');
        Route::post('/bikes/bin/bulk-destroy', [\App\Http\Controllers\AdminBikeController::class, 'bulkDestroy'])->name('admin.bikes.bulkDestroy');
        Route::post('/bikes/bin/bulk-restore', [\App\Http\Controllers\AdminBikeController::class, 'bulkRestore'])->name('admin.bikes.bulkRestore');
        Route::post('/bikes/{id}/restore', [\App\Http\Controllers\AdminBikeController::class, 'restore'])->name('admin.bikes.restore');

        // Station Management
        Route::get('/stations', [\App\Http\Controllers\AdminStationController::class, 'index'])->name('admin.stations.index');
        Route::get('/stations/create', [\App\Http\Controllers\AdminStationController::class, 'create'])->name('admin.stations.create');
        Route::post('/stations/store', [\App\Http\Controllers\AdminStationController::class, 'store'])->name('admin.stations.store');
        Route::get('/stations/{id}/edit', [\App\Http\Controllers\AdminStationController::class, 'edit'])->name('admin.stations.edit');
        Route::put('/stations/{id}', [\App\Http\Controllers\AdminStationController::class, 'update'])->name('admin.stations.update');
        Route::delete('/stations/{id}', [\App\Http\Controllers\AdminStationController::class, 'destroy'])->name('admin.stations.destroy');
    });
});

require __DIR__.'/auth.php';
