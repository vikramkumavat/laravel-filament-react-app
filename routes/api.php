<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuctionController;

// -- Authentication routes
// -- These routes are for user registration and login
// -- They are not protected by authentication middleware

Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auctions', [AuctionController::class, 'index']);
    Route::get('/getAuctionNotification', [AuctionController::class, 'getAuctionNotification'])->name('get.auctionNotification');
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::middleware('auth:api')->get('/user', [AuthController::class, 'user']);
});
