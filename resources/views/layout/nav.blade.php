  <nav class="navbar navbar-expand-md navabr-light border-bottom pt-3 pb-3">
    <div class="container{{ Request::is('admin/consumer-ledger*') ? '-fluid px-5' : ' px-3' }}">
      <a class="navbar-brand text-dark pe-4" href="{{route('admin.dashboard')}}"><strong>MWS</strong></a>
      <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span data-feather="align-center" class="text-secondary"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 pt-lg-0 pt-md-2">
          @adminonly(Auth::user()->role)
          <li class="nav-item m1-">
            <a class="nav-link m-1 text-secondary" aria-current="page" href="{{route('admin.dashboard')}}">
              <i data-feather="home" class="feather-16 m-1 mb-1"></i> Home
            </a>
          </li>
          @endadminonly
          <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i data-feather="users" class="feather-16 m-1"></i> Consumer
            </a>
            <ul class="dropdown-menu px-2" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{route('admin.existing-customers.create')}}">Data Entry</a></li>
              {{-- <li><a class="dropdown-item" href="{{route('admin.consumer-ledger')}}">Ledger Card</a></li> --}}
              <li><a class="dropdown-item" href="{{route('admin.existing-customers.index')}}">View Lists</a></li>
            </ul>
          </li>
          @adminonly(Auth::user()->role)
          {{-- <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <i data-feather="align-left" class="feather-16 m-1"></i> Transactions
            </a>
            <ul class="dropdown-menu px-2" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="{{route('admin.services.create')}}">New Connection</a>
                <a class="dropdown-item" href="{{route('admin.reconnection')}}">Reconnection</a>
                <a class="dropdown-item" href="{{route('admin.transactions-lists')}}">List of Transactions</a>
                <a class="dropdown-item" href="{{route('admin.transfer-meter')}}">Transfer of Meter</a>
              </li>
            </ul>
          </li> --}}
          @endadminonly


          @adminonly(Auth::user()->role)
          <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <i data-feather="users" class="feather-16 m-1"></i> Accounts
            </a>
            <ul class="dropdown-menu px-2" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="{{route('admin.users.create')}}">New</a>
                <a class="dropdown-item" href="{{route('admin.users.index')}}">View</a>
                {{-- <a class="dropdown-item" href="{{route('admin.cashiers.index')}}">Cashiers</a>
                <a class="dropdown-item" href="{{route('admin.reader')}}">Meter Reader</a>
                <a class="dropdown-item" href="{{route('admin.admin')}}">System Admin</a> --}}
              </li>
            </ul>
          </li>
          @endadminonly

          @adminonly(Auth::user()->role)
          <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <i data-feather="tool" class="feather-16 m-1"></i> Services
            </a>
            <ul class="dropdown-menu px-2" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="{{route('admin.services.create')}}">New</a>
                <a class="dropdown-item" href="{{route('admin.services-list.index')}}">List of Services</a>
                <a class="dropdown-item" href="{{route('admin.request-approvals')}}">Requests</a>
              </li>
            </ul>
          </li>
          @endadminonly


          @adminonly(Auth::user()->role)
          <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i data-feather="settings" class="feather-16 m-1"></i> Settings
            </a>
            <ul class="dropdown-menu px-2" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Water Rates</a></li>
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#surchargeModel">Surcharge</a></li>
            </ul>
          </li>
          @endadminonly
        </ul>
        <span class="navbar-text mt-1 pt-0">
          <form action="{{route('admin.logout')}}" method="post">
              @csrf
              <button type="submit" class="btn btn-link text-danger" id="logoutBtn">
                <i data-feather="log-out" class="feather-16 m-1"></i> Logout
              </button>
          </form>
        </span>
      </div>
    </div>
  </nav>

@auth
      @include('templates.water-rate')
      @include('templates.surcharge')
  @endauth

  <style>
    #logoutBtn{
      text-decoration: none;
      color:rgba(255,255,255,.55);
      cursor: pointer;
      text-align: left;
      padding: 0;
    }
    #logoutBtn:hover{
      color:#fff;
    }
    .navbar-text{
      height:3.1rem;
    }

  </style>


