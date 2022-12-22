<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    public function getAirports(){
        $airports = Airport::with('city')->get();
        return response()->json(['airports'=>$airports], 200);
    }

    public function addAirport(Request $request){
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

        $airport = new Airport();
        $airport->title = $request->title;
        $airport->city_id = $request->city;
        $airport->save();

        return response()->json('Аэропорт ' . $request->title . ' добавлен', 200);
    }

    public function editAirport(Request $request, Airport $airport){
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

        $airport->title = $request->title;
        $airport->city_id = $request->city;
        $airport->update();

        return response()->json('Аэропорт ' . $airport->title . ' обновлён', 200);
    }

    public function deleteAirport(Airport $airport){
        $airport->delete();
        return response()->json('Аэропорт ' . $airport->title . ' удалён', 200);
    }
}
