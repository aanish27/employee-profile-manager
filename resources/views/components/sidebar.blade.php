<div id="sidebar-long" class="d-flex flex-column  p-3 text-bg-dark d-none h-100" style="min-width: 200px; min-height: 100vh;">
    <a href="/" class="d-flex align-items-center text-light text-decoration-none">
        <i class="bi bi-amazon me-2 fs-3"></i>
        <span class="fs-5">Vista G</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
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
        <li>
            <a href="#" class="nav-link p-1 my-1 ">
                <i class="bi bi-clipboard-data pe-1 fs-5"></i>
                Dashboard
            </a>
        </li>
    </ul>
    <x-drop-down-side-bar :open="true" />
</div>

<div id="sidebar-short" class="d-flex flex-column flex-shrink-0 bg-dark h-100 " style="width: 3.6rem; min-height: 100vh;">
    <a href="/" class="d-block p-1 text-center link-body-emphasis text-decoration-none" title="Vista G" data-bs-toggle="tooltip" data-bs-placement="right">
        <i class="bi bi-amazon fs-2 text-light"></i>
        <span class="visually-hidden">Icon-only</span>
    </a>

    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
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
        <li>
            <a href="#" class="nav-link   border-bottom rounded-0" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
                <i class="bi bi-clipboard-data fs-4 text-center"></i>
            </a>
        </li>
    </ul>
    <x-drop-down-side-bar />
</div>


