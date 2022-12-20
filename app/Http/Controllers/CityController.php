<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function getCities(){
        $cities = City::all();
        return response()->json(['cities'=>$cities], 200);
    }

    public function addCity(Request $request){
        $validation = Validator::make($request->all(),[
            'title'=>['required', 'regex:/^\D+$/u'],
            'img'=>['required', 'mimes:png,jpg,jpeg,bmp', 'max:1024'], 
        ],[
            'title.required' => 'Обязательное поле для заполнения',
            'title.regex' => 'Цифры не допускаются',
            'img.required' => 'Обязательное поле для заполнения',
            'img.mimes' => 'Допустимое разрешение: png, jpg, jpeg',
            'img.max' => 'Размер файла не должен превышать 1Мб',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        $path_img = '';
        if($request->file('img')){
            $path_img = $request->file('img')->store('img');
        }

        $city = new City();
        $city->title = $request->title;
        $city->img = '/storage/' . $path_img;
        $city->save();

        return response()->json('Город ' . $request->title . ' добавлен', 200);
    }

    public function editCity(Request $request, City $city){
        $validation = Validator::make($request->all(),[
            'title'=>['required', 'regex:/^\D+$/u'],
            'img'=>['mimes:png,jpg,jpeg,bmp', 'max:1024'], 
        ],[
            'title.required' => 'Обязательное поле для заполнения',
            'title.regex' => 'Цифры не допускаются',
            'img.mimes' => 'Допустимое разрешение: png, jpg, jpeg',
            'img.max' => 'Размер файла не должен превышать 1Мб',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        if($request->file('img')){
            Storage::delete(substr($city->img, 9));
            $path_img = $request->file('img')->store('img');
            $city->img = '/storage/' . $path_img;
        }

        $city->title = $request->title;
        $city->update();

        return response()->json('Город ' . $city->title . ' обновлён', 200);
    }

    public function deleteCity(City $city){
        Storage::delete(substr($city->img, 9));
        $city->delete();
        return response()->json('Город ' . $city->title . ' удалён', 200);
    }
}
