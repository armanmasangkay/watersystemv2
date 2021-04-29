<nav class="navbar navbar-expand-md navbar-light shadow-sm " style="background-color: #e3f2fd;"> 

    <div class="container px-3">
      <a class="navbar-brand" href="{{route('admin.dashboard')}}"><strong>MWS</strong> - Inpections</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          
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