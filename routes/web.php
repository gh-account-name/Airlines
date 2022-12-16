<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\PageController::class, 'mainPage'])->name('mainPage');

Route::get('/auth', [\App\Http\Controllers\PageController::class, 'authPage'])->name('authPage');

Route::get('/reg', [\App\Http\Controllers\PageController::class, 'regPage'])->name('regPage');
