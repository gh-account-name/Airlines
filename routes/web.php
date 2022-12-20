<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
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

// Страницы

Route::get('/', [\App\Http\Controllers\PageController::class, 'mainPage'])->name('mainPage');

Route::get('/auth', [\App\Http\Controllers\PageController::class, 'authPage'])->name('authPage');

Route::get('/reg', [\App\Http\Controllers\PageController::class, 'regPage'])->name('regPage');


// Функции

Route::post('/registration', [UserController::class, 'register'])->name('register');

Route::post('/authorisation', [UserController::class, 'auth'])->name('auth');

Route::get('/logout', [UserController::class,  'logout'])->name('logout');