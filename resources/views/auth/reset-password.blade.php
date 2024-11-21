<x-guest-layout>
    <x-slot:title>Reset Password</x-slot>
     <div class="form-auth w-25">
        <i class="bi bi-person-square mb-4 fs-1"></i>
        <h1 class="h3 mb-3 fw-normal">Reset Password</h1>
        <x-auth-session-status :status="session('status')" />
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-floating">
                <input type="email" class="form-control floatingInput" id="email" name="email"  value={{ $request->email }}  required autofocus>
                <label for="email">Email</label>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-floating">
                <input type="password" class="form-control floatingInput" id="password" name="password" placeholder="New Password"  required>
                <label for="password">Password</label>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="form-floating">
                <input type="password" class="form-control floatingInput" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"  required >
                <label for="password_confirmation">Confirm Password</label>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button class="btn btn-primary w-100 py-2 mt-3" type="submit">{{ __('Log in') }}</button>
    </form>
  </div>
</x-guest-layout>
