<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Macrohon Water System - @yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('assets/img/logo-macrohon.png') }}" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('assets/css/custom.css?v=1.1')}}">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    </head>
    <body class="bg-light bg-gradient">

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{route('consumer.dashboard')}}">Consumer Portal</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse d-lg-flex flex-row justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('consumer.signout')}}">
                        <i class="fas fa-sign-out-alt"></i> Sign out
                    </a>
                  </li>
                
                </ul>
              </div>
            </div>
        </nav>

        <div class="container">
            @yield('content')
        </div>

        <div class="container mt-5" id="footer">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-muted text-center">&copy; Macrohon Municipal Water Works - 2021</h6>
                    <p class="text-muted text-center">Developed by: SLSU-CCSIT Development Team</p>
                    <p class="text-muted text-center">For more info visit us at <a href="https://www.facebook.com/jabsoftware">https://www.facebook.com/jabsoftware</a></p>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    </body>
</html>
