

<span class="screen-darken"></span>
<div class="container-fluid bg-light nav nav-mobile px-0 border-md-bottom border-sm-bottom border-bottom border-lg-0">
    <div class="container px-0">
        <div class="d-flex justify-content-between align-items-center pb-2 pe-2">
            <button data-trigger="navbar_main" class="d-lg-none btn btn-white mt-2 d-flex justify-content-between align-items-center mb-2" type="button" style="font-size: 18px;"><i data-feather="align-center" class="feather-18 me-2"></i><strong>MENU</strong></button>
            @if(Request::is('admin/field-personnel/meter-reading*') || Request::is('admin/field-personnel/meter-services*'))
            <div class="d-flex justify-content-between align-items-center">
                <!-- <button class="btn d-lg-none btn-secondary btn-sm mt-2 me-1 help mb-2" style="height: 35px !important;"><i data-feather="help-circle" class="feather-18 me-1"></i> Ask Help</button> -->
                <button class="btn d-lg-none btn-primary btn-sm mt-2 me-1 search mb-2" style="height: 35px !important;"><i data-feather="search" class="feather-18"></i></button>
                <button class="btn d-lg-none btn-sm border btn-white mt-2 close mb-2 me-1" style="height: 35px !important;"><i data-feather="x" class="feather-20"></i></button>
            </div>
            @endif
        </div>
        <nav id="navbar_main" class="mobile-offcanvas navbar navbar-expand-lg navbar-dark bg-white">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-item-center mb-4">
                    <div class="d-flex justify-content-start align-item-center">
                        <div class="img-logo bg-light mb-3 mt-4 d-lg-none" align="center">
                            <img class="img" src="{{ asset('assets/img/man.png') }}" alt="user">
                        </div>
                        <div class="user d-lg-none ms-2">
                            <h4 class="mt-4 pt-3 mb-0">{{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <div class="offcanvas-header">  
                        <button class="btn-close float-end"></button>
                    </div>
                </div>
                <a class="navbar-brand text-secondary pb-2 border-md-bottom border-lg-2 border-secondary" href="#" style="font-size: 18px !important;"><strong>Macrohon Municipal Waterworks</strong></a>

                <ul class="navbar-nav ms-lg-3">
                    <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="{{ route('admin.home') }}"><i data-feather="home" class="feather-18 me-2"></i> Home Page </a></li>
                    <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="{{ route('admin.field-reading') }}"><i data-feather="info" class="feather-18 me-2"></i> Meter Reading </a></li>
                    <li class="nav-item my-md-0 my-1"><a class="nav-link text-secondary" href="{{ route('admin.meter-services') }}"><i data-feather="activity" class="feather-18 me-2"></i> Water Services </a></li>
                    <!-- <li class="nav-item my-md-0 d-none d-lg-block my-1"><a class="nav-link text-secondary" href="#"><i data-feather="repeat" class="feather-18 me-2"></i> Sync Data </a></li> -->
                    <li class="nav-item dropdown my-md-0 my-1 d-none d-lg-block">
                        <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather="user" class="feather-16 m-1"></i> Account
                        </a>
                        <ul class="dropdown-menu px-2" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{route('users.update-password.edit')}}"><i data-feather="key" class="feather-18 me-2"></i> Change Password </a>
                                <form action="{{ route('logout') }}" method="post" class="mb-0">
                                    @csrf
                                    <button class="nav-link text-secondary border-0 bg-white ms-2"><i data-feather="log-out" class="feather-18 me-2"></i> Sign-out </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item my-md-0 my-1 d-md-block d-lg-none"> <a class="nav-link text-secondary" href="#"><i data-feather="key" class="feather-18 me-2"></i> Reset Password </a> </li>
                    <li class="nav-item my-md-0 my-1 d-md-block d-lg-none">
                        <form action="{{ route('logout') }}" method="post" class="mb-0">
                            @csrf
                            <button class="nav-link text-secondary border-0 bg-white"><i data-feather="log-out" class="feather-18 me-2"></i> Sign-out </button>
                        </form>
                    </li>
                </ul>
                    <!-- <form action="" class="float-bottom d-flex justify-content-start align-items-center d-block d-lg-none">
                        <button class="btn btn-primary"><i data-feather="repeat" class="feather-18 mb-1 me-2"></i> Synchronize Data</button>
                        <a class="btn btn-secondary ps-2 ms-1 py-2" href="#" style="padding: 10px 10px 9px 10px !important;"><i data-feather="help-circle" class="feather-18 me-1 mb-1"></i> Ask Help </a>
                    </form> -->
            </div> <!-- container-fluid.// -->
        </nav>
    </div>
</div>
