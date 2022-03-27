{{-- /*
|--------------------------------------------------------------------------
|
| Aplikasi Peduli Diri
| Disusun oleh Apriza Prasetio
|
|--------------------------------------------------------------------------
|
| Instagram : @aprizaprasetio
| Youtube : Apriza Prasetio
|
|--------------------------------------------------------------------------
*/ --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title') - Peduli Diri</title>
</head>
<body @yield('background')>
    @yield('header')
    <div class="container flex justify-center mx-auto">
        @yield('body')
    </div>
</body>
</html>