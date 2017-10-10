<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BAbook') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .navbar-inverse{
            background: rgba(10, 0, 10, 0.5);
            border: none;
        }

        .dropdown-menu{
            background: rgba(10, 0, 10, 0.5);
            color: #666666;
        }

        .dropdown-menu > li > a:hover{
            color: #666666;
            background: none;
        }

        header {
            background-image: url("../images/spaceAndLogo.jpg");
            background-position: center;
            background-size: cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        header>div{
            margin-top: 70vh;
        }

        .container-fluid{
            background-image: url("../images/space.jpg");
            background-position: center;
            background-size: cover;
            height: 100vh;
        }

        #authPanel{
            margin-top: 20%;
            //background: rgba(10, 0, 10, 0.3);
        }

        .navbar{
            margin-bottom: 0px;
        }


        #login-btn, #register-btn:hover{
            background-color: #b700b9;
            color: #fff;
            font-size: 1.3em;
            text-decoration: none;
        }
        #register-btn, #login-btn:hover {
            color: #fff;
            background-color: inherit;
            border: 1px solid #fff;
            font-size: 1.3em;
            text-decoration: none;
        }
        .btn-round{
            border-radius: 19px !important;
            padding: 10px 50px;
        }

        /*==================================================
=            Bootstrap 3 Media Queries             =
==================================================*/

        /*==========  Mobile First Method  ==========*/

        /* Custom, iPhone Retina */
        @media only screen and (min-width : 320px) {

        }

        /* Extra Small Devices, Phones */
        @media only screen and (min-width : 480px) {

        }

        /* Small Devices, Tablets */
        @media only screen and (min-width : 768px) {

        }

        /* Medium Devices, Desktops */
        @media only screen and (min-width : 992px) {

        }

        /* Large Devices, Wide Screens */
        @media only screen and (min-width : 1200px) {

        }

        /*==========  Non-Mobile First Method  ==========*/

        /* Large Devices, Wide Screens */
        @media only screen and (max-width : 1200px) {

        }

        /* Medium Devices, Desktops */
        @media only screen and (max-width : 992px) {

        }

        /* Small Devices, Tablets */
        @media only screen and (max-width : 768px) {
            #register-btn, #register-btn:hover{
                font-size: 1em;
                color: #fff;
                text-decoration: underline;
                background-color: inherit;
                border: none;
            }
            #register-btn:hover{
                text-decoration: none;
            }
        }

        /* Extra Small Devices, Phones */
        @media only screen and (max-width : 480px) {

        }

        /* Custom, iPhone Retina */
        @media only screen and (max-width : 320px) {

        }
    </style>
</head>
<body>
    <div id="app">
        @guest
            @else
                @include('inc.navbar')
            @endguest
            <div class="container-fluid">
                @yield('content')
            </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/events.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

</body>
</html>
