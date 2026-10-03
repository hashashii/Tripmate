<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripPlanController;

// Home and place details
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

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