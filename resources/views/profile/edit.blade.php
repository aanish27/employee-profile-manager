<x-app-layout>
    <x-slot:title> Profile Settings </x-slot:title>
    <div class="d-flex justify-content-center  align-items-center gap-5" style="height: 75vh;">
        <div id="profile_image" class="position-relative border-1">
            <img src="{{ $user->profile_pic ?  asset('storage/' . $user->profile_pic) : ''}} " class=" border-2 border-black border rounded-circle" height="300px" style="max-width: 300px; width: 500px; max-height: 500px;">
            <x-input-error  :messages="$errors->get('profile_pic')" />
        </div>
        <div class="w-50 h-50 mb-5">
            <ul class="nav nav-tabs" id="option_tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark" id="information-tab" data-bs-toggle="tab" data-bs-target="#information-tab-pane" type="button" role="tab" aria-controls="information-tab-pane" aria-selected="true">Personal Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-tab-pane" type="button" role="tab" aria-controls="password-tab-pane" aria-selected="false">Change Password</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="delete-account-tab" data-bs-toggle="tab" data-bs-target="#delete-account-tab-pane" type="button" role="tab" aria-controls="delete-account-tab-pane" aria-selected="false">Delete Account</button>
                </li>
            </ul>
            <div class="tab-content" id="profile_settings">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>


    <script type="module">
        $(function () {
        //sidebar
        $('#sidebar-toggle').on('click', function() {
            $('#sidebar-long').toggleClass('d-none');
            $('main').toggleClass('main-l-sidebar');
            $('#sidebar-short').toggleClass('d-none');
        });

        $('#profile_image').on('click', function () {
            $('#profile_pic').click();
        });

        $('#profile_pic').on('change', function () {
            $('#profile_update').submit();
        });


        });
    </script>
</x-app-layout>
