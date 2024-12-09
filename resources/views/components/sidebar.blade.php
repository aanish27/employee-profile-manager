<div id="sidebar-long" class="d-flex flex-column  p-3 text-bg-dark d-none" style="min-width: 200px; min-height: 100vh;">
    <a href="/" class="d-flex align-items-center text-light text-decoration-none">
        <i class="bi bi-amazon me-2 fs-3"></i>
        <span class="fs-5">Vista G</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
         <li>
            <a href="#" class="nav-link p-1 my-1 ">
                <i class="bi bi-clipboard-data pe-1 fs-5"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item ">
            <a  href="{{ route('companys.index') }}" class="nav-link p-1 my-1 btn-company"  aria-current="page">
                <i class="bi bi-building pe-1 fs-5"></i>
                Company
            </a>
        </li>
        <li>
            <a href="{{ route('employee') }}" class="nav-link p-1 my-1 btn-employee">
                <i class="bi bi-person pe-1 fs-5"></i>
                Employee
            </a>
        </li>
        <li>
            <a href="{{ route('user.index') }}" class="nav-link p-1 my-1 btn-user">
                <i class="bi bi-person-badge pe-1 fs-5"></i>
                User
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/logo.webp') }}" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow p-1">
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider mb-0 mt-0""></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item " style=""> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>

<div id="sidebar-short" class="d-flex flex-column flex-shrink-0 bg-dark " style="width: 3.6rem; min-height: 100vh;">
    <a href="/" class="d-block p-1 text-center link-body-emphasis text-decoration-none" title="Vista G" data-bs-toggle="tooltip" data-bs-placement="right">
        <i class="bi bi-amazon fs-2 text-light"></i>
        <span class="visually-hidden">Icon-only</span>
    </a>

    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li>
            <a href="{{ route('dashboard') }}" class="nav-link   border-bottom rounded-0 btn-dashboard" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
                <i class="bi bi-clipboard-data fs-4 text-center"></i>
            </a>
        </li>
        <li class="nav-item ">
            <a  href="{{ route('companys.index') }}" class="nav-link border-bottom btn-company rounded-0" title="Company" data-bs-toggle="tooltip" data-bs-placement="right">
                <i class="bi bi-building fs-4 text-center"></i>
            </a>
        </li>
        <li>
            <a href="{{ route('employee') }}" class="nav-link   border-bottom rounded-0 btn-employee" title="Employee" data-bs-toggle="tooltip" data-bs-placement="right">
                <i class="bi bi-person fs-4 text-center"></i>
            </a>
        </li>
        <li>
             <a href="{{ route('user.index') }}" class="nav-link   border-bottom rounded-0 btn-user" title="User" data-bs-toggle="tooltip" data-bs-placement="right">
                <i class="bi bi-person-badge fs-4 text-center"></i>
            </a>
        </li>

    </ul>

    <div class="dropdown border-top">
        <a href="#" class="d-flex align-items-center text-light  justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/logo.webp') }}" alt="" width="32" height="32" class="rounded-circle me-2">
        </a>
        <ul class="dropdown-menu text-small shadow p-1">
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider mb-0 mt-0"></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
        </ul>
    </div>
</div>


