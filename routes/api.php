<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TravelUserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/travels', [TravelUserController::class, 'index']);
Route::get('/travels/category/{categoryId}', [TravelUserController::class, 'travelsByCategory']);
Route::get('/travels/search', [TravelUserController::class, 'searchTravels']);
Route::get('/travels/{id}', [TravelUserController::class, 'show']);
Route::get('/travels/{id}/review', [TravelUserController::class, 'review_average']);
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(UserMiddleware::class)->group(function () {
        Route::post('/travels/{id}/register', [TravelUserController::class, 'registerTravel']);
        Route::get('/registered-travels', [TravelUserController::class, 'registeredTravels']);
        Route::post('/travels/{travelId}/reviews', [ReviewController::class, 'store']);
        Route::get('/travels/{travelId}/reviews', [ReviewController::class, 'index']);
    });

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        Route::get('/city', [CityController::class, 'index']);
        Route::post('/city', [CityController::class, 'store']);
        Route::patch('/city/{id}', [CityController::class, 'update']);
        Route::delete('/city/{id}', [CityController::class, 'destroy']);

        Route::get('/restaurant', [RestaurantController::class, 'index']);
        Route::post('/restaurant', [RestaurantController::class, 'store']);
        Route::patch('/restaurant/{id}', [RestaurantController::class, 'update']);
        Route::delete('/restaurant/{id}', [RestaurantController::class, 'destroy']);

        Route::get('/hotel', [HotelController::class, 'index']);
        Route::post('/hotel', [HotelController::class, 'store']);
        Route::patch('/hotel/{id}', [HotelController::class, 'update']);
        Route::delete('/hotel/{id}', [HotelController::class, 'destroy']);

        Route::get('/travel', [TravelController::class, 'index']);
        Route::post('/travel', [TravelController::class, 'store']);
        Route::delete('/travel/{id}', [TravelController::class, 'destroy']);

        Route::get('/registered-users-travels', [TravelController::class, 'registeredUsers']);
    });
});
