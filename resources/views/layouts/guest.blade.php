<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title></title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="container-fluid">
        <main class="d-flex justify-content-center align-items-center h-100 w-100" >
            {{ $slot }}
        </main>
    </body>
</html>
