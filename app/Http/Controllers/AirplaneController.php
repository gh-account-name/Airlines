<?php

namespace App\Http\Controllers;

use App\Models\Airplane;
use App\Http\Controllers\Controller;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AirplaneController extends Controller
{
    public function getAirplanes(){
        $airplanes = Airplane::all();
        return response()->json(['airplanes'=>$airplanes], 200);
    }

    public function addAirplane(Request $request){
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'count_seats'=>['required', 'numeric'],
            'price' => ['required', 'numeric', 'regex:/^\d*$|^\d*\.\d{1,2}$/'],
        ],[
            'title.required' => 'Обязательное поле для заполнения',
            'count_seats.required' => 'Обязательное поле для заполнения',
            'count_seats.numeric' => 'Допускаются только цифры',
            'price.required' => 'Обязательное поле для заполнения',
            'price.numeric' => 'Допускаются только цифры',
            'price.regex' => 'Укажите цену в рублях',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        $airplane = new Airplane();
        $airplane->title = $request->title;
        $airplane->count_seats = $request->count_seats;
        $airplane->price = $request->price;
        $airplane->save();

        for($i=1; $i<=$request->count_seats; $i++){
            $seat = new Seat();
            $seat->airplane_id = $airplane->id;
            $seat->seat = $i;
            $seat->save();
        }

        return response()->json('Самолёт ' . $request->title . ' добавлен', 200);
    }

    public function editAirplane(Request $request, Airplane $airplane){
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'count_seats'=>['required', 'numeric', 'not_regex:/^0+$/'],
            'price' => ['required', 'numeric', 'regex:/^\d*$|^\d*\.\d{1,2}$/'],
        ],[
            'title.required' => 'Обязательное поле для заполнения',
            'count_seats.required' => 'Обязательное поле для заполнения',
            'count_seats.numeric' => 'Допускаются только цифры',
            'count_seats.not_regex' => 'Мест должно быть больше чем ноль',
            'price.required' => 'Обязательное поле для заполнения',
            'price.numeric' => 'Допускаются только цифры',
            'price.regex' => 'Укажите цену в рублях',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        if($request->count_seats != $airplane->count_seats){
            $seats = Seat::query()->where('airplane_id', $airplane->id)->get();
            foreach($seats as $seat){
                $seat->delete();
            }

            for($i=1; $i<=$request->count_seats; $i++){
                $seat = new Seat();
                $seat->airplane_id = $airplane->id;
                $seat->seat = $i;
                $seat->save();
            }
        }

        $airplane->title = $request->title;
        $airplane->count_seats = $request->count_seats;
        $airplane->price = $request->price;
        $airplane->update();

        return response()->json('Самолёт ' . $airplane->title . ' обновлён', 200);
    }

    public function deleteAirplane(Airplane $airplane){
        $seats = Seat::query()->where('airplane_id', $airplane->id)->get();
        foreach($seats as $seat){
            $seat->delete();
        }
        $airplane->delete();
        return response()->json('Самолёт ' . $airplane->title . ' удалён', 200);
    }
}
