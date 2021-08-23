

<span class="screen-darken"></span>
<div class="container-fluid bg-white nav px-0 border-md-bottom border-sm-bottom border-bottom border-lg-0">
    <div class="container px-0">
        <div class="d-flex justify-content-between align-items-center pb-2 pe-2">
            <button data-trigger="navbar_main" class="d-lg-none btn btn-white mt-2 d-flex justify-content-between align-items-center mb-2" type="button"><i data-feather="align-center" class="feather-18 me-2"></i><strong>MENU</strong></button>
            @if(Request::is('field-personnel/meter-reading*') || Request::is('field-personnel/meter-services*'))
            <button class="btn d-lg-none btn-primary btn-sm mt-2 me-1 search mb-2" style="height: 35px !important;"><i data-feather="search" class="feather-18"></i></button>
            <button class="btn d-lg-none btn-sm btn-white mt-2 close mb-2 me-1" style="height: 35px !important;"><i data-feather="x" class="feather-20"></i></button>
            @endif
        </div>
        <nav id="navbar_main" class="mobile-offcanvas navbar navbar-expand-lg navbar-dark bg-white">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-item-center">
                    <div class="d-flex justify-content-start align-item-center">
                        <div class="img-logo bg-light mb-3 mt-1 d-lg-none" align="center">
                            <img class="img" src="{{ asset('assets/img/man.png') }}" alt="user">
                        </div>
                        <div class="user d-lg-none ms-2">
                            <h6 class="mt-3 mb-0">Nobegin Masob</h6>
                            <p>darksidebug</p>
                        </div>
                    </div>
                    <div class="offcanvas-header">  
                        <button class="btn-close float-end"></button>
                    </div>
                </div>
                <a class="navbar-brand text-secondary pb-2 border-md-bottom border-lg-2 border-secondary" href="#"><strong>MWS <span class="d-block d-lg-none"> - @yield('title')</span></strong></a>

                <ul class="navbar-nav ms-lg-3">
                    <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="#"><i data-feather="home" class="feather-18 me-2"></i> Home Page </a></li>
                    <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="{{ route('field-reading') }}"><i data-feather="info" class="feather-18 me-2"></i> Meter Reading </a></li>
                    <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="{{ route('meter-services') }}"><i data-feather="activity" class="feather-18 me-2"></i> Water Services </a></li>
                    <li class="nav-item my-md-0 d-none d-lg-block my-1"><a class="nav-link text-secondary" href="#"><i data-feather="repeat" class="feather-18 me-2"></i> Sync Data </a></li>
                    <li class="nav-item dropdown my-md-0 my-1 d-none d-lg-block">
                        <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather="user" class="feather-16 m-1"></i> Account
                        </a>
                        <ul class="dropdown-menu px-2" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="#"><i data-feather="key" class="feather-18 me-2"></i> Reset Password </a>
                            <a class="dropdown-item" href="#"><i data-feather="log-out" class="feather-18 me-2"></i> Sign-out </a>
                        </li>
                        </ul>
                    </li>
                    <li class="nav-item my-md-0 my-1 d-md-block d-lg-none"> <a class="nav-link text-secondary" href="#"><i data-feather="key" class="feather-18 me-2"></i> Reset Password </a> </li>
                    <li class="nav-item my-md-0 my-1 d-md-block d-lg-none"><a class="nav-link text-secondary" href="#"><i data-feather="log-out" class="feather-18 me-2"></i> Sign-out </a></li>
                </ul>
                <form action="" class="float-bottom d-lg-none">
                    <button class="btn btn-primary"><i data-feather="repeat" class="feather-18 mb-1 me-2"></i> Synchronize Data</button>
                </form>
            </div> <!-- container-fluid.// -->
        </nav>
    </div>
</div>
