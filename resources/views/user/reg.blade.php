@extends('layout.app')

@section('title')
    Регистрация
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
            <h1 style="color: #265BE3;" class="d-flex align-items-center justify-content-between mb-4">Регистрация <span style="margin-left: 7%" class="decorLine"></span></h1>
            <div class="mb-4">
                <input type="text" class="form-control" id="fio" name="fio" placeholder="ФИО">
            </div>
            <div class="mb-4">
                <label for="birthday" class="form-label">Дата рождения</label>
                <input type="date" class="form-control" id="birthday" name="birthday">
            </div>
            <div class="mb-4">
                <input type="number" class="form-control" id="passport" name="passport" placeholder="номер документа">
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" id="login" name="login" placeholder="логин">
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="телефон">
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="пароль">
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="подтвердите пароль">
            </div>
            <div class="mb-3 form-check">
                <label class="form-check-label" for="agreement">Я согласен на обработку данных</label>
                <input type="checkbox" class="form-check-input" id="agreement" name="agreement">
            </div>
            <button type="submit" class="btn col-6 btn-primary">регистрация</button>
        </form>
    </div>
@endsection
