<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function buyTicket(Request $request){
        $validation = Validator::make($request->all(),[
            'seat' => ['required'],
            'fio'=> ['required', 'regex:/^(([А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+)|([А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+))$/u'],
            'birthday'=> ['required'],
            'passport'=>['required_if:birthCertificate,null', 'numeric'],
            'birthCertificate'=>['required_if:passport,null', 'numeric'],
            'password'=>['required','min:6'],
            'agreement'=>['required'],
        ], [
            'seat.required'=>'Выберите место',
            'fio.required'=>'Это обязательное поле',
            'fio.regex'=>'Пример заполнения: Иван Иванович Иванов',
            'birthday.required'=>'Это обязательное поле',
            'passport.required_if'=>'Это обязательное поле',
            'passport.numeric'=>'Допускаются только цифры',
            'birthCertificate.required_if'=>'Это обязательное поле',
            'birthCertificate.numeric'=>'Допускаются только цифры',
            'password.min'=>'Минимальная длина пароля: 6 символов',
            'password.required'=>'Это обязательное поле',
            'agreement.required'=>'Нам нужно ваше согласие на обработку данных',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        if(Auth::user()->password != md5($request->password)){
            $validation->getMessageBag()->add('password', 'Неверный пароль');
            return response()->json($validation->errors(), 403);
        }

        $ticket = new Ticket();
        $ticket->user_id = Auth::id();
        $ticket->fio = $request->fio;
        $ticket->birthday = $request->birthday;
        
        if($request->passport){
            $ticket->passport = $request->passport;
        }

        if($request->birthCertificate){
            $ticket->certificate = $request->birthCertificate;
        }

        $ticket->flight_id = $request->flight;
        $ticket->seat = $request->seat;
        $ticket->price = $request->price;

        $ticket->save();

        return redirect()->route('myTicketsPage');
    }
}
