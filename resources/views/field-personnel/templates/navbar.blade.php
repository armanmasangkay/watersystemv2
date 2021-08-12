

<span class="screen-darken"></span>
<div class="container px-0">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 pe-2">
        <button data-trigger="navbar_main" class="d-lg-none btn btn-white mt-2 d-flex justify-content-between align-items-center" type="button"><i data-feather="align-center" class="feather-18 me-2"></i>Menu</button>
        <button class="btn d-lg-none btn-primary btn-sm mt-2 me-1 search"><i data-feather="search" class="feather-20 me-1 pb-1"></i>Search</button>
        <button class="btn d-lg-none btn-sm mt-2 close"><i data-feather="x" class="feather-20 me-1 pb-1"></i></button>
    </div>
    <nav id="navbar_main" class="mobile-offcanvas navbar navbar-expand-lg navbar-dark bg-white">
        <div class="container-fluid">
            <div class="offcanvas-header">  
                <button class="btn-close float-end"></button>
            </div>
            <a class="navbar-brand text-primary" href="#"><strong>MWS - @yield('title')</strong></a>

            <ul class="navbar-nav">
                <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="#"><i data-feather="home" class="feather-18 me-2"></i> Home Page </a></li>
                <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="{{ route('field-reading') }}"><i data-feather="info" class="feather-18 me-2"></i> Meter Reading </a></li>
                <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="#"><i data-feather="activity" class="feather-18 me-2"></i> Services </a></li>
                <li class="nav-item my-md-0 my-1"> <a class="nav-link text-secondary" href="#"><i data-feather="key" class="feather-18 me-2"></i> Reset Password </a> </li>
                <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="#"><i data-feather="log-out" class="feather-18 me-2"></i> Sign-out </a></li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">  More items  </a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item text-secondary" href="#"> Submenu item 1</a></li>
                    <li><a class="dropdown-item text-secondary" href="#"> Submenu item 2 </a></li>
                    <li><a class="dropdown-item text-secondary" href="#"> Submenu item 3 </a></li>
                    </ul>
                </li> -->
            </ul>
            <!-- <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-secondary" href="#"> Menu item </a></li>
                <li class="nav-item"><a class="nav-link text-secondary" href="#"> Menu item </a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown"> Dropdown right </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item text-secondary" href="#"> Submenu item 1</a></li>
                    <li><a class="dropdown-item text-secondary" href="#"> Submenu item 2 </a></li>
                    </ul>
                </li>
            </ul> -->

        </div> <!-- container-fluid.// -->
    </nav>
</div>
