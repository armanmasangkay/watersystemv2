<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Macrohon Water System - @yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('assets/img/logo-macrohon.png') }}" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
        <style>
            /* html {
                font-size: 10px;
            } */

            /* .mobile-offcanvas ul li a,
            .mobile-offcanvas ul li button{
                font-size: 15px !important;
            } */

            .clock {
                width: 30rem;
                height: 30rem;
                border: 7px solid #282828;
                box-shadow: inset 4px 4px 10px rgba(0,0,0,0.5),
                                inset -4px -4px 10px rgba(67,67,67,0.5);
                border-radius: 50%;
                position: relative;
                left: -4rem;
                top: -4rem;
                padding: 2rem;
                background-color: #282828;
                transform: scale(0.6);
            }

            .outer-clock-face {
                position: relative;
                width: 100%;
                height: 100%;
                border-radius: 100%;
                background: #282828;
                overflow: hidden;
            }

            .outer-clock-face::after {
                -webkit-transform: rotate(90deg);
                -moz-transform: rotate(90deg);
                transform: rotate(90deg)
            }

            .outer-clock-face::before,
            .outer-clock-face::after,
            .outer-clock-face .marking{
                content: '';
                position: absolute;
                width: 5px;
                height: 100%;
                background: #1df52f;
                z-index: 0;
                left: 49%;
            }

            .outer-clock-face .marking {
                background: #bdbdcb;
                width: 3px;
            }

            .outer-clock-face .marking.marking-one {
                -webkit-transform: rotate(30deg);
                -moz-transform: rotate(30deg);
                transform: rotate(30deg)
            }

            .outer-clock-face .marking.marking-two {
                -webkit-transform: rotate(60deg);
                -moz-transform: rotate(60deg);
                transform: rotate(60deg)
            }

            .outer-clock-face .marking.marking-three {
                -webkit-transform: rotate(120deg);
                -moz-transform: rotate(120deg);
                transform: rotate(120deg)
            }

            .outer-clock-face .marking.marking-four {
                -webkit-transform: rotate(150deg);
                -moz-transform: rotate(150deg);
                transform: rotate(150deg)
            }

            .inner-clock-face {
                position: absolute;
                top: 10%;
                left: 10%;
                width: 80%;
                height: 80%;
                background: #282828;
                -webkit-border-radius: 100%;
                -moz-border-radius: 100%;
                border-radius: 100%;
                z-index: 1;
            }

            .inner-clock-face::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 16px;
                height: 16px;
                border-radius: 18px;
                margin-left: -9px;
                margin-top: -6px;
                background: #4d4b63;
                z-index: 11;
            }

            .hand {
                width: 50%;
                right: 50%;
                height: 6px;
                background: #61afff;
                position: absolute;
                top: 50%;
                border-radius: 6px;
                transform-origin: 100%;
                transform: rotate(90deg);
                transition-timing-function: cubic-bezier(0.1, 2.7, 0.58, 1);
            }

            .hand.hour-hand {
                width: 30%;
                z-index: 3;
            }

            .hand.min-hand {
                height: 3px;
                z-index: 10;
                width: 40%;
            }

            .hand.second-hand {
                background: #ee791a;
                width: 45%;
                height: 2px;
            }
            
            .home{
                position: relative;
                top: -5rem;
            }
        </style>
    </head>
    <body class="bg-light bg-gradient" id="fs">
        @include('field-personnel.templates.navbar')
        <div class="container pb-0 mb-0">
            @yield('content')
        </div>

        <div class="container mt-5 {{ Request::is('admin/field-personnel/home') ? 'home' : '' }}" id="footer">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-muted text-center">&copy; Macrohon Municipal Water Works - 2021</h6>
                    <p class="text-muted text-center">Developed by: SLSU-CCSIT Development Team</p>
                    <p class="text-muted text-center">For more info visit us at <a href="https://www.facebook.com/jabsoftware">https://www.facebook.com/jabsoftware</a></p>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
        <script>
            feather.replace()
          </script>
        @yield('custom-js')
    </body>
</html>
