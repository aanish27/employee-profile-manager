<section >
    <header>
        <h2>{{ __('Profile Information') }}</h2>
        <p>{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <div class="d-flex gap-5 w-100">
        <div class="position-relative">
            <img  src="{{ asset('storage/' . $user->profile_pic) }}" class=" border-2 border-black border rounded-circle" height="250px" style="max-width: 250px; width: 250px; max-height: 250px;">
            {{-- <button class="position-absolute end-0  rounded-circle fs-3 btn btn-success"><i class="bi bi-pencil"></i></button> --}}
        </div>
        <form class="d-none" id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form enctype="multipart/form-data" method="post" class="w-100 row" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <div class="mb-2 col-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text"  :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error  :messages="$errors->get('name')" />
            </div>
            <div class="mb-2 col-3">
                <x-input-label for="profile_pic" :value="__('Change Profile Pic')" />
                <x-text-input id="profile_pic" name="profile_pic" type="file"  :value="old('profile_pic', $user->profile_pic)" />
                <x-input-error  :messages="$errors->get('profile_pic')" />
            </div>
            <div class="mb-2 col-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email"  :value="old('email', $user->email)" required />
                <x-input-error  :messages="$errors->get('email')" />
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p>
                            {{ __('Your email address is unverified.') }}
                                <button form="send-verification" >{{ __('Click here to re-send the verification email.') }}</button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p>{{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="">
                <x-primary-button class="col-2">{{ __('Save') }}</x-primary-button>
                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>

</section>
