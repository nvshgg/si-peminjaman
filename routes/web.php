<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemReturnController;
use App\Http\Controllers\ItemLoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');


Route::get('/test', [HomeController::class, 'index']);

Route::resource('/item', (ItemController::class));
Route::resource('/item-loan', (ItemLoanController::class));
Route::resource('/item-return', (ItemReturnController::class));


