<x-guest-layout>
  <x-slot:title>Login</x-slot>

  <div class="form-auth w-25">
      <i class="bi bi-person-square mb-4 fs-1"></i>
      <h1 class="h3 mb-3 fw-normal">Sign-In</h1>
      <x-auth-session-status class="" :status="session('status')" />

      <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-floating">
            <input type="email" class="form-control floatingInput" id="email" name="email" placeholder="name@example.com" required autofocus autocomplete="username"  value="{{ env('APP_ENV') == 'local' ? 'admin@example.com' : '' }}">
            <label for="email">Email</label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          <div class="form-floating">
            <input type="password" class="form-control " id="password" name="password" placeholder="Password"  required autocomplete="current-password" value="{{ env('APP_ENV') == 'local' ? 'password' : '' }}" >
            <label for="password">Password</label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>

          <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
          </div>

          <div>
            @if (Route::has('password.request'))
              <a class=" link-primary" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
              </a>
            @endif
            <br>
            <a href="{{ route('register') }}" class="link-primary pt-2">Sign-Up</a>
          </div>

          <button class="btn btn-primary w-100 py-2 mt-2" type="submit">{{ __('Log in') }}</button>
      </form>
  </div>
</x-guest-layout>


