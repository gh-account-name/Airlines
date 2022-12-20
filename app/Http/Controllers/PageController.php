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
}
