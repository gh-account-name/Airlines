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
        <form class="col-4">
            <h1 style="color: #265BE3;" class="d-flex align-items-center justify-content-between mb-4">Авторизация <span style="margin-left: 7%" class="decorLine"></span></h1>
            <div class="mb-4">
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="логин">
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="пароль">
            </div>
            <button type="submit" class="btn col-6 btn-primary">вход</button>
        </form>
    </div>
@endsection
