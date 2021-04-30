<nav class="navbar navbar-expand-md navbar-light shadow-sm " style="background-color: #e3f2fd;"> 
    <div class="container px-3">
      <a class="navbar-brand" href="{{route('admin.dashboard')}}"><strong>MWS</strong></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item m1-">
            <a class="nav-link m-1" aria-current="page" href="{{route('admin.dashboard')}}">
              <i data-feather="home" class="feather-16 m-1 mb-1"></i> Home
            </a>
          </li>
          <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i data-feather="users" class="feather-16 m-1"></i> Customer
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{route('admin.register-customer')}}">New</a></li>
              <li><a class="dropdown-item" href="{{route('admin.customers')}}">View All</a></li>
            </ul>
        
          </li>
          <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <i data-feather="align-left" class="feather-16 m-1"></i> Transactions
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="{{route('admin.transactions.create')}}">New Connection</a>
                <a class="dropdown-item" href="{{route('admin.reconnection')}}">Reconnection</a>
              </li>
            </ul>
        
          </li>
          <li class="nav-item dropdown pt-1">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i data-feather="settings" class="feather-16 m-1"></i> Settings
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Water Rates</a></li>
            </ul>
            
          </li>
        </ul>
        <span class="navbar-text mt-1">
          <form action="{{route('admin.logout')}}" method="post">
              @csrf
              <button type="submit" class="btn btn-link text-danger" id="logoutBtn" style="color:rgba(0,0,0,.55)">
                <i data-feather="log-out" class="feather-16 m-1"></i> Logout
              </button>
          </form>
        </span>
      </div>
    </div>
  </nav>

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


