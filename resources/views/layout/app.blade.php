<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <script src="{{asset('public/js/bootstrap.bundle.js')}}"></script>
    <title>@yield('title')</title>
</head>
<body>
    <script src="{{asset('public\js\jquery-3.6.2.js')}}"></script>
    <script src="{{asset('public\js\vue.global.js')}}"></script>
<style>
    @font-face {
        font-family: Inter;
        src: url({{asset('public/fonts/Inter-Regular.ttf')}});
    }

    body{
        font-family: Inter;
    }

    h1, h2, h3, h4, h5{
        color: #265BE3;
    }
</style>
@include('layout.navbar')
@yield('main')
</body>
</html>
