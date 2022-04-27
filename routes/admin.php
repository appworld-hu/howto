<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::prefix('admin')->as('admin.')->group(function () {

        Route::get('/', [DashboardController::class, 'show']);

        Route::resource('users', UsersController::class);

        Route::resource('products', ProductsController::class);
    });
});
