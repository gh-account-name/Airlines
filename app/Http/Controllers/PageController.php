<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function mainPage(){
        return view('main');
    }

    public function authPage(){
        return view('user.auth');
    }

    public function regPage(){
        return view('user.reg');
    }

    public function citiesPage(){
        return view('admin.cities');
    }

    public function airplanesPage(){
        return view('admin.airplanes');
    }

    public function usersPage(){
        return view('admin.users');
    }

    public function airportsPage(){
        return view('admin.airports');
    }
}
