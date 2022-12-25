@extends('layout.app')

@section('title')
    Мои билеты
@endsection

@section('main')
    <style>

        .form-control{
            border-color: #265BE3;
        }

    </style>
    <div class="container" id="myTicketsPage">

        <h2 class="text-center m-5 col-12">Мои билеты</h2>

        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">Логин</th>
                <th scope="col">Дата рождения</th>
                <th scope="col">Номер документа</th>
                <th scope="col">Email</th>
                <th scope="col">Телефон</th>
                <th scope="col">Действие</th>
              </tr>
            </thead>
            <tbody>
               
            </tbody>
          </table>
    </div>
@endsection