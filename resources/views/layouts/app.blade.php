<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>

        @vite([ 'resources/css/app.css', 'resources/js/app.js',])
    </head>

    <body class="container-fluid p-0 d-flex">
        <x-sidebar/>
        <div class="w-100 p-0">
            <x-toast-message/>
            <x-nav-bar title="{{ $title }}"/>
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
