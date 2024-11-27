<x-app-layout>
    <x-slot:title> Profile Settings </x-slot:title>

    <div class="px-2 m-0">
        <div class="py-2">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="py-2" >
            @include('profile.partials.update-password-form')
        </div>

        <div class="py-2 py-0 ">
            @include('profile.partials.delete-user-form')
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

        });
    </script>
</x-app-layout>
