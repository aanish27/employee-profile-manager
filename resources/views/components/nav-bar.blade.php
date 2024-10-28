<nav class="navbar w-100  py-1 ps-2 pe-3 bg-white shadow-sm" >
    <div class="nav-left d-flex align-items-center gap-2 justify-content-center">
        <button id="sidebar-toggle"  href="" class="btn btn-nav m-0 p-0">
            <i class="bi bi-justify fs-5 "></i>
        </button>
        <h1 class="fs-5 my-0" >{{ $title }}</h1>
    </div>

    <div class="nav-right d-flex align-items-center gap-2 ">
        <i class="bi bi-box-arrow-right fs-5 "></i>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
