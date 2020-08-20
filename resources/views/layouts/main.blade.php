<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ env('WEB_KEYWORDS') }}">
    <meta name="google-site-verification" content="{{ config('app.google_verification', '') }}">
    <link rel="canonical" href="{{ env('WEB_CANONICAL') }}">
    <meta name="description" content="{{ env('WEB_DESCRIPTION') }}">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>{{ config('app.name', 'My Blog') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">

</head>


<body>
<main>
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')
</main>


</body>
</html>
