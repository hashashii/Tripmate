<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PlaceController as AdminPlaceController;
use App\Http\Controllers\Admin\TripPlanController as AdminTripPlanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripPlanController;

// Home and place details
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// routes/web.php
Route::view('/about', 'about')
    ->name('about');    

Route::get('/place/{id}', [HomeController::class, 'show'])
    ->name('places.show');

// Trip plans
Route::get('/trip-plans', [TripPlanController::class, 'index'])
    ->name('trip-plans.index');

Route::get('/trip-plans/create', [TripPlanController::class, 'create'])
    ->name('trip-plans.create');

Route::post('/trip-plans', [TripPlanController::class, 'store'])
    ->name('trip-plans.store');

Route::get('/trip-plans/{tripPlan}', [TripPlanController::class, 'show'])
    ->name('trip-plans.show');

Route::delete('/trip-plans/{tripPlan}', [TripPlanController::class, 'destroy'])
    ->name('trip-plans.destroy');

// Admin panel

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('places', AdminPlaceController::class)->except('show');
        Route::resource('categories', AdminCategoryController::class)
            ->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('trip-plans', AdminTripPlanController::class)
            ->only(['index', 'show', 'destroy'])
            ->parameters(['trip-plans' => 'tripPlan']);
    });
});
