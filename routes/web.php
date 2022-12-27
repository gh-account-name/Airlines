<?php

use App\Http\Controllers\AirplaneController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TicketController;
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

Route::get('/', [PageController::class, 'mainPage'])->name('mainPage');

Route::get('/auth', [PageController::class, 'authPage'])->name('authPage');

Route::get('/reg', [PageController::class, 'regPage'])->name('regPage');

Route::get('/search/flights', [PageController::class, 'flightsSearchResultPage'])->name('flightsSearchResultPage');

Route::get('/flight/{flight?}', [PageController::class, 'flightDetailsPage'])->name('flightDetailsPage');

Route::get('/tickets', [PageController::class, 'myTicketsPage'])->name('myTicketsPage');

Route::get('/cabinet', [PageController::class, 'cabinetPage'])->name('cabinetPage');


// Функции

Route::post('/registration', [UserController::class, 'register'])->name('register');

Route::post('/authorisation', [UserController::class, 'auth'])->name('auth');

Route::get('/logout', [UserController::class,  'logout'])->name('logout');

Route::get('/get/flights', [FlightController::class, 'getFlights'])->name('getFlights');

Route::post('/flight/buyTicket', [TicketController::class, 'buyTicket'])->name('buyTicket');

Route::post('/delete/ticket/{ticket?}', [TicketController::class, 'deleteTicket'])->name('deleteTicket');

Route::post('/editUser/{user?}', [UserController::class, 'editUserData'])->name('editUserData');


// Миддлвар

Route::group(['middleware'=>['auth', 'admin'], 'prefix'=>'admin'], function(){

    // Страницы

    Route::get('/cities', [PageController::class, 'citiesPage'])->name('citiesPage');

    Route::get('/airplanes', [PageController::class, 'airplanesPage'])->name('airplanesPage');

    Route::get('/users', [PageController::class, 'usersPage'])->name('usersPage');

    Route::get('/airports', [PageController::class, 'airportsPage'])->name('airportsPage');

    Route::get('/flights', [PageController::class, 'flightsPage'])->name('flightsPage');

    Route::get('/tickets', [PageController::class, 'ticketsPage'])->name('ticketsPage');


    // Функции

    Route::get('/get/cities', [CityController::class, 'getCities'])->name('getCities');

    Route::post('/add/city', [CityController::class, 'addCity'])->name('addCity');

    Route::post('/edit/city/{city?}', [CityController::class, 'editCity'])->name('editCity');

    Route::post('/delete/city/{city?}', [CityController::class, 'deleteCity'])->name('deleteCity');

    Route::get('/get/airplanes', [AirplaneController::class, 'getAirplanes'])->name('getAirplanes');
    
    Route::post('/add/airplane', [AirplaneController::class, 'addAirplane'])->name('addAirplane');

    Route::post('/edit/airplane/{airplane?}', [AirplaneController::class, 'editAirplane'])->name('editAirplane');

    Route::post('/delete/airplane/{airplane?}', [AirplaneController::class, 'deleteAirplane'])->name('deleteAirplane');

    Route::get('/get/users', [UserController::class, 'getUsers'])->name('getUsers');

    Route::post('/edit/user/{user?}', [UserController::class, 'editUser'])->name('editUser');

    Route::post('/delete/user/{user?}', [UserController::class, 'deleteUser'])->name('deleteUser');
    
    Route::get('/get/airports', [AirportController::class, 'getAirports'])->name('getAirports');

    Route::post('/add/airport', [AirportController::class, 'addAirport'])->name('addAirport');

    Route::post('/edit/airport/{airport?}', [AirportController::class, 'editAirport'])->name('editAirport');

    Route::post('/delete/airport/{airport?}', [AirportController::class, 'deleteAirport'])->name('deleteAirport');

    Route::post('/add/flight', [FlightController::class, 'addFlight'])->name('addFlight');

    Route::post('/edit/flight/{flight?}', [FlightController::class, 'editFlight'])->name('editFlight');

    Route::post('/delete/flight/{flight?}', [FlightController::class, 'deleteFlight'])->name('deleteFlight');

});