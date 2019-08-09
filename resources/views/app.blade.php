<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if(env('APP_ENV')=='production')
            <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
        <style>
            a:hover{
                text-decoration: none!important;
            }
        </style>
    </head>
    <body>
    <div id=app></div>
    @if(env('APP_ENV')=='production')
        <script src="{{ secure_asset('js/app.js')}}"></script>
    @else
        <script src="{{ asset('js/app.js')}}"></script>
    @endif
    </body>
</html>
