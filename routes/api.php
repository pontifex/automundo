<?php

use App\Http\Controllers\Commands\AddBrandController;
use App\Http\Controllers\Commands\AddModelController;
use App\Http\Controllers\Commands\AddProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Queries\ListBrandsController;
use App\Http\Controllers\Queries\ListProductsController;
use App\Http\Controllers\Queries\ShowBrandController;
use App\Http\Controllers\Queries\ShowProductController;
use App\Http\Controllers\RefreshTokenController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post(
    'register',
    [
        RegisterController::class,
        'index',
    ]
)->name('register');

Route::post(
    'login',
    [
        LoginController::class,
        'index',
    ]
)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        'profile',
        [
            ProfileController::class,
            'index',
        ]
    )->name('profile');

    Route::middleware('auth:sanctum')->get(
        'refresh-token',
        [
            RefreshTokenController::class,
            'index',
        ]
    )->name('refresh-token');

    Route::middleware('auth:sanctum')->get(
        'logout',
        [
            LogoutController::class,
            'index',
        ]
    )->name('logout');

    // brands
    Route::middleware('auth:sanctum')->post(
        '/brands',
        [
            AddBrandController::class,
            'index',
        ]
    );

    Route::middleware('auth:sanctum')->get(
        '/brands/{id}',
        [
            ShowBrandController::class,
            'index',
        ]
    );

    Route::middleware('auth:sanctum')->get(
        '/brands',
        [
            ListBrandsController::class,
            'index',
        ]
    );

    //models
    Route::middleware('auth:sanctum')->post(
        '/models',
        [
            AddModelController::class,
            'index',
        ]
    );

    //products
    Route::middleware('auth:sanctum')->post(
        '/products',
        [
            AddProductController::class,
            'index',
        ]
    );

    Route::middleware('auth:sanctum')->get(
        '/products/{id}',
        [
            ShowProductController::class,
            'index',
        ]
    );

    Route::middleware('auth:sanctum')->get(
        '/products',
        [
            ListProductsController::class,
            'index',
        ]
    );
});
