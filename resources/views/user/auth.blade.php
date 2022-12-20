@extends('layout.app')

@section('title')
    Авторизация
@endsection

@section('main')
    <style>
        .decorLine{
            display: block;
            height: 0.313rem;
            background-color: #265BE3;
            width: 50%;
        }

        .form-control{
            border-color: #265BE3;
        }

        .btn{
            background: #F4C82C;
            border: none;
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh">
        <form class="col-4" method="post" action="{{route('auth')}}">
            @csrf
            @method('post')

            @if(session()->has('error'))
            <div class="d-flex justify-content-center mt-4">
                <div class="alert text-center alert-danger col-12">
                    {{session('error')}}
                </div>
            </div>
            @endif

            <h1 style="color: #265BE3;" class="d-flex align-items-center justify-content-between mb-4">Авторизация <span style="margin-left: 7%" class="decorLine"></span></h1>

            <div class="mb-4">
                <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login" value="{{old('login')}}" placeholder="логин">
                <div class="invalid-feedback">
                    @error('login')
                    {{$message}}
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="пароль">
                <div class="invalid-feedback">
                    @error('password')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn col-6 btn-primary">вход</button>
        </form>
    </div>
@endsection
