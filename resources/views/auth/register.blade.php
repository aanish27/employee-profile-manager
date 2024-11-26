<x-guest-layout>
    <x-slot:title>Sign Up</x-slot>
    <div class="form-auth w-25">
        <i class="bi bi-person-square mb-4 fs-1"></i>
        <h1 class="h3 mb-3 fw-normal">Sign-Up</h1>
        <x-auth-session-status class="" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-floating">
                <input type="text" class="form-control floatingInput" id="name" name="name" placeholder="name" required autofocus>
                <label for="name">Name</label>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="form-floating">
                <input type="email" class="form-control floatingInput" id="email" name="email" placeholder="name@example.com" required >
                <label for="email">Email</label>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-floating">
                <input type="password" class="form-control " id="password" name="password" placeholder="Password"  required autocomplete="current-password" >
                <label for="password">Password</label>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="form-floating">
                <input type="password" class="form-control floatingInput" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"  required >
                <label for="password_confirmation">Confirm Password</label>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <a href="{{ route('login') }}" class="d-block mt-2">Already Registered?</a>
            <button class="btn btn-primary w-100 py-2 mt-2" type="submit">{{ __('Sign Up') }}</button>
        </form>
    </div>
</x-guest-layout>

