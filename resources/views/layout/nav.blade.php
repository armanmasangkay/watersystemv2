<nav class="navbar navbar-expand-md navbar-dark bg-dark ">
    <div class="container-fluid px-3">
      <a class="navbar-brand" href="{{route('admin.dashboard')}}">MWS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('admin.dashboard')}}">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Customer
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{route('admin.register-customer')}}">New</a></li>
            </ul>
          </li>
        </ul>
        <span class="navbar-text">
          <form action="{{route('admin.logout')}}" method="post">
              @csrf
              <button type="submit" class="btn btn-link" id="logoutBtn">Logout</button>
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