<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        @vite([ 'resources/css/app.css', 'resources/js/app.js',])
    </head>

    <body class="container.fluid w-100 d-flex" >
        <x-sidebar/>
        <x-toast-message/>

        @section('main')

        @show

    </body>
</html>