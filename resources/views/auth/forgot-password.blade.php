<x-guest-layout>
    <x-slot:title>Forgot Password</x-slot>
    <div class="form-auth w-25">
        <!-- Session Status -->
        <i class="bi bi-person-square mb-4 fs-1"></i>
        <h1 class="h3 mb-1 fw-normal">Reset Password</h1>
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-2">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <div class="form-floating mb-2">
                <input type="email" class="form-control floatingInput" id="email" name="email" placeholder="name@example.com" required autofocus autocomplete="username" >
                <label for="email">Email</label>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">{{ __('Email Password Reset Link') }}</button>
        </form>
    </div>
</x-guest-layout>
