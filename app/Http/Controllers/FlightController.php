<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    public function getFlights(){
        $flights = Flight::all();
        return response()->json(['flights'=>$flights], 200);
    }

    public function addFlight(Request $request){
        $validation = Validator::make($request->all(),[
            'from_city'=>['required'],
            'to_city'=>['required'], 
            'dateFrom'=>['required'], 
            'dateTo'=>['required'], 
            'timeFrom'=>['required'], 
            'timeTo'=>['required'],
            'timeWay'=>['required'], 
            'percentPrice'=>['required', 'numeric', 'regex:/^\d*$|^\d*\.\d{1,2}$/'], 
            'airplane'=>['required'], 
            'from_airport'=>['required'], 
            'to_airport'=>['required'], 
        ],[
            'from_city.required' => 'Обязательное поле для заполнения',
            'to_city.required' => 'Обязательное поле для заполнения',
            'dateFrom.required' => 'Обязательное поле для заполнения',
            'dateTo.required' => 'Обязательное поле для заполнения',
            'timeFrom.required' => 'Обязательное поле для заполнения',
            'timeTo.required' => 'Обязательное поле для заполнения',
            'timeWay.required' => 'Обязательное поле для заполнения',
            'percentPrice.required' => 'Обязательное поле для заполнения',
            'percentPrice.numeric' => 'Допускаются только цифры',
            'percentPrice.regex' => 'Укажите процент',
            'airplane.required' => 'Обязательное поле для заполнения',
            'from_airport.required' => 'Обязательное поле для заполнения',
            'to_airport.required' => 'Обязательное поле для заполнения',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        $flight = new Flight();
        $flight->from_city_id = $request->from_city;
        $flight->to_city_id = $request->to_city;
        $flight->dateFrom = $request->dateFrom;
        $flight->dateTo = $request->dateTo;
        $flight->timeFrom = $request->timeFrom;
        $flight->timeTo = $request->timeTo;
        $flight->timeWay = $request->timeWay;
        $flight->percentPrice = $request->percentPrice;
        $flight->airplane_id = $request->airplane;
        $flight->from_airport_id = $request->from_airport;
        $flight->to_airport_id = $request->to_airport;
        $flight->save();
        return response()->json('Рейс №' . $flight->id . ' ' . City::find($flight->from_city_id)->title . ' -> ' . City::find($flight->to_city_id)->title . ' добавлен', 200);
    }

    public function editFlight(Request $request, Flight $flight){
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'city'=>['required'], 
        ],[
            'title.required' => 'Обязательное поле для заполнения',
            'city.required' => 'Обязательное поле для заполнения',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        $flight->title = $request->title;
        $flight->city_id = $request->city;
        $flight->update();

        return response()->json('Рейс ' . $flight->title . ' обновлён', 200);
    }

    public function deleteFlight(Flight $flight){
        $flight->delete();
        return response()->json('Рейс ' . $flight->title . ' удалён', 200);
    }
}
