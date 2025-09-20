<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\Auth\LoginController;
use App\Http\Controllers\api\Auth\UserControllerApi;
use App\Http\Controllers\api\PartControllerApi;
use App\Http\Controllers\api\adminControllerApi;
use App\Http\Controllers\api\OrderControllerApi;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// User login
Route::post('/login/user', [LoginController::class, 'loginUser'])->name('api.login.user');
// Admin login
Route::post('/login/admin', [LoginController::class, 'loginAdmin'])->name('api.login.admin');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');

Route::middleware(['auth:sanctum', 'check.admin'])->prefix('parts')->group(function () {
    // route api part
    Route::get('/', [PartControllerApi::class, 'index'])->name('parts.index');
    Route::post('/', [PartControllerApi::class, 'store'])->name('parts.store');
    Route::post('/{id}', [PartControllerApi::class, 'update'])->name('parts.update');
    Route::delete('/{id}', [PartControllerApi::class, 'destroy'])->name('parts.destroy');
});

// delivery
Route::middleware(['auth:sanctum'])->prefix('packing')->group(function () {
    Route::get('/prepared', [adminControllerApi::class, 'index']);
    Route::get('/deliveries', [adminControllerApi::class, 'delivery']);
});

// order
Route::middleware(['auth:sanctum'])->prefix('order')->group(function () {
    Route::get('/admin', [OrderControllerApi::class, 'index']); // API untuk menampilkan semua data Order
});

// user 
Route::middleware(['auth:sanctum'])->prefix('user')->group(function () {
    Route::get('/', [UserControllerApi::class, 'index']); // Menampilkan semua user
    Route::post('/store', [UserControllerApi::class, 'store']); // Menyimpan user baru
    Route::delete('/{id}', [UserControllerApi::class, 'destroy']); // Menghapus user berdasarkan ID
});