<x-app-layout>
    <x-slot:title>
        Dashboard
    </x-slot>



    <script type="module">
        const linkColor = $('.nav_link');
        linkColor.removeClass('active')
        $('.btn-dashboard').addClass('active');
    </script>
</x-app-layout>
