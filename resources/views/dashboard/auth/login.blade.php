<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Login</title>
        @vite([ 'resources/css/app.css', 'resources/js/app.js' ,'resources/css/custom.sign-in.css'])
    </head>

    <body class="d-flex align-items-center py-4 bg-body-tertiary">
        <main class="form-signin w-100 m-auto" >
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <i class="bi bi-person-square fs-1"></i>
          <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
          
          <div class="form-floating">
            <input type="email" class="form-control floatingInput" id="email" name="email" placeholder="name@example.com" required autofocus autocomplete="username"  value="{{ env('APP_ENV') == 'local' ? 'admin@example.com' : '' }}">
            <label for="email">Email</label>
            {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
          </div>

          <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"  required autocomplete="current-password" value="{{ env('APP_ENV') == 'local' ? 'password' : '' }}" >
                <label for="password">Password</label>
                {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
          </div>

          <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    {{ __('Remember me') }}
                </label>
          </div>
          <button class="btn btn-primary w-100 py-2" type="submit">{{ __('Log in') }}</button>
        </form>
      </main>
 </body>
</html>
