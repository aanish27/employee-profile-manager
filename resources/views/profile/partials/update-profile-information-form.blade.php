<section class="tab-pane fade show active" id="information-tab-pane" role="tabpanel" aria-labelledby="information-tab" tabindex="0">
    <header class="pt-3">
        <h2>{{ __('Profile Information') }}</h2>
        <p>{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form class="d-none" id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form enctype="multipart/form-data" method="post" class="row d-flex w-50" action="{{ route('profile.update') }}" id="profile_update">
        @csrf
        @method('patch')

        <div class="mb-2 col-9">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"  :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error  :messages="$errors->get('name')" />
        </div>

        <div class="mb-2 col-9">
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

        <div class="mb-2 col-4" hidden>
            <x-input-label for="profile_pic" :value="__('Change Profile Pic')" />
            <x-text-input id="profile_pic" name="profile_pic" type="file" />
        </div>

        <div>
            <x-primary-button id="btn_personal_submit" class="col-5">{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                >{{ __('Profile Information Updated Succesfully') }}</p>
            @endif
        </div>
    </form>
</section>
