<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        $validation = Validator::make($request->all(), [
            'fio'=> ['required', 'regex:/^(([А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+)|([А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+))$/u'],
            'birthday'=> ['required'],
            'passport'=>['required', 'numeric', 'unique:users'],
            'login'=>['required', 'unique:users', 'regex:/^[A-Za-z0-9-]+$/u'],
            'phone'=>['required', 'numeric', 'unique:users'],
            'email'=>['required', 'email:frc', 'unique:users'],
            'password'=>['required', 'min:6', 'confirmed'],
            'agreement'=>['required'],
        ], [
            'fio.required'=>'Это обязательное поле',
            'fio.regex'=>'Разрешенные символы: кириллица, пробел и тире',
            'birthday.required'=>'Это обязательное поле',
            'passport.required'=>'Это обязательное поле',
            'passport.numeric'=>'Допускаются только цифры',
            'passport.unique'=>'Неверный номер документа',
            'login.required'=>'Это обязательное поле',
            'login.unique'=>'Данный логин уже занят',
            'login.regex'=>'Разрешенные символы: латиница, цифры и тире',
            'phone.required'=>'Это обязательное поле',
            'phone.numeric'=>'Допускаются только цифры',
            'phone.unique'=>'Неверный номер телефона',
            'email.required'=>'Это обязательное поле',
            'email.email'=>'Пример заполнения: example@email.com',
            'email.unique'=>'Неверный адрес электронной почты',
            'password.required'=>'Это обязательное поле',
            'password.min'=>'Минимальная длина пароля: 6 символов',
            'password.confirmed'=>'Пароли не совпадают',
            'agreement.required'=>'Нам нужно ваше согласие на обработку данных',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 400);
        }

        $user = new User();
        $user->fio = $request->fio;
        $user->birthday = $request->birthday;
        $user->passport = $request->passport;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->login = $request->login;
        $user->password = md5($request->password);
        $user->save();

        return redirect()->route('authPage')->with('success', 'Вы успешно зарегистрировались');
    }

    public function auth(Request $request){
        $request->validate([
            'login'=>['required', 'regex:/^[A-Za-z0-9-]+$/u'],
            'password'=>['required', 'min:6'],
        ], [
            'login.required'=>'Это обязательное поле',
            'login.regex'=>'Разрешенные символы: латиница, цифры и тире',
            'password.required'=>'Это обязательное поле',
            'password.min'=>'Минимальная длина пароля: 6 символов',
        ]);

        $user = User::query()->where('login', $request->login)->where('password',md5($request->password))->first();

        if($user){
            Auth::login($user);
            if ($user->role === 'admin'){
                return redirect()->route('mainPage');
            } else {
                return redirect()->route('mainPage');
            }
        } else {
            return redirect()->back()->with('error', 'Неверный логин или пароль');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('mainPage');
    }

    public function getUsers(){
        $users = User::all();
        return response()->json(['users'=>$users], 200);
    }

    public function editUser(Request $request, User $user){
        $validation = Validator::make($request->all(),[
            'fio'=> ['required', 'regex:/^(([А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+)|([А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+[-\s][А-ЯЁ][а-яё]+))$/u'],
            'birthday'=> ['required'],
            'passport'=>['required', 'numeric'],
            'login'=>['required', 'regex:/^[A-Za-z0-9-]+$/u'],
            'phone'=>['required', 'numeric'],
            'email'=>['required', 'email:frc'],
            'password'=>['min:6', 'nullable'],
        ], [
            'fio.required'=>'Это обязательное поле',
            'fio.regex'=>'Разрешенные символы: кириллица, пробел и тире',
            'birthday.required'=>'Это обязательное поле',
            'passport.required'=>'Это обязательное поле',
            'passport.numeric'=>'Допускаются только цифры',
            'login.required'=>'Это обязательное поле',
            'login.regex'=>'Разрешенные символы: латиница, цифры и тире',
            'phone.required'=>'Это обязательное поле',
            'phone.numeric'=>'Допускаются только цифры',
            'email.required'=>'Это обязательное поле',
            'email.email'=>'Пример заполнения: example@email.com',
            'password.min'=>'Минимальная длина пароля: 6 символов',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 403);
        }

        $userUnique = User::query()->where('passport',$request->passport)->where('id' , '!=', $user->id)->first();
        if($userUnique){
            $validation->getMessageBag()->add('passport', 'Данный номер документа уже используется');
            return response()->json($validation->errors(), 403);
        }

        $userUnique = User::query()->where('login',$request->login)->where('id' , '!=', $user->id)->first();
        if($userUnique){
            $validation->getMessageBag()->add('login', 'Данный логин уже занят');
            return response()->json($validation->errors(), 403);
        }

        $userUnique = User::query()->where('phone',$request->phone)->where('id' , '!=', $user->id)->first();
        if($userUnique){
            $validation->getMessageBag()->add('phone', 'Данный номер уже зарегистрирован');
            return response()->json($validation->errors(), 403);
        }

        $userUnique = User::query()->where('email',$request->email)->where('id' , '!=', $user->id)->first();
        if($userUnique){
            $validation->getMessageBag()->add('email', 'Данный адрес уже зарегистрирован');
            return response()->json($validation->errors(), 403);
        }

        $user->fio = $request->fio;
        $user->birthday = $request->birthday;
        $user->passport = $request->passport;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->login = $request->login;

        if($request->password){
           $user->password = md5($request->password); 
        }

        $user->update();

        return response()->json('Пользователь ' . $user->fio . ' обновлён', 200);
    }

    public function deleteUser(User $user){
        $user->delete();
        return response()->json('Пользователь ' . $user->fio . ' удалён', 200);
    }
}
