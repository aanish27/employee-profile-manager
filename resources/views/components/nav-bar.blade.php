<nav class="navbar w-100  ps-2 pe-3 bg-white shadow-sm" >
    <div class="nav-left d-flex align-items-center gap-2">
        <button id="sidebar-toggle"  href="" class="btn btn-nav m-0 p-0">
            <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
            </svg>
        </button>

        <form class="" role="search" >
            <input class="form-control me-5  rounded-5" style="height: 30px" type="search" placeholder="Search" aria-label="Search">
        </form>
    </div>

    <div class="nav-right d-flex align-items-center gap-2 ">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#022658" class="bi bi-bell" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
            </svg>
        <img class="rounded-5 " src="{{ asset('images/logo.webp') }}" alt="profile-picture"  style="border:2px solid #022658; width: 30px; height: 30px" >
        <div class="dropdown ">
            <a class="dropdown-toggle text-decoration-none fs-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black">
                Aanish
            </a>
            <ul class="dropdown-menu dropdown-menu-end"  style="opacity: 1;background-color: whitesmoke;">
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item " style=""> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                <li class="dropdown-item">Settings</li>
                <li class="dropdown-item">Profile</li>
            </ul>
        </div>
    </div>
</nav>
