@props(['open' => false])
<div class="dropdown border-top">
    <a href="#" class="d-flex align-items-center text-light  justify-content-center p-3 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ Auth::user()->profile_pic ?  asset('storage/' . Auth::user()->profile_pic) : ''}} " alt="" width="32" height="32" class="border border-white  rounded-circle me-2">
        @if ($open)
            <strong>{{ Auth::user()->name }}</strong>
        @endif
    </a>
    <ul class="dropdown-menu text-small shadow p-1">
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><hr class="dropdown-divider mb-0 mt-0"></li>
        <li><a href="{{ route('profile.edit') }}" class="dropdown-item" >Profile</a></li>
    </ul>
</div>

