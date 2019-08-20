{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <title>{{ config('app.name', 'Laravel') }}</title>--}}
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
{{--</head>--}}
{{--<body>--}}
{{--    <div id="app">--}}
{{--        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
{{--            <div class="container">--}}
{{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                    {{ config('app.name') }}--}}
{{--                </a>--}}
{{--                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--                    <span class="navbar-toggler-icon"></span>--}}
{{--                </button>--}}

{{--                <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                    <!-- Left Side Of Navbar -->--}}
{{--                    <ul class="navbar-nav mr-auto">--}}

{{--                    </ul>--}}

{{--                    <!-- Right Side Of Navbar -->--}}
{{--                    <ul class="navbar-nav ml-auto">--}}
{{--                        <!-- Authentication Links -->--}}
{{--                        @guest--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--                            </li>--}}
{{--                            @if (Route::has('register'))--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            <li class="nav-item dropdown">--}}
{{--                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                    {{ Auth::user()->name }} <span class="caret"></span>--}}
{{--                                </a>--}}

{{--                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                                    <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                                       onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                        {{ __('Logout') }}--}}
{{--                                    </a>--}}

{{--                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                                        @csrf--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        @endguest--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </nav>--}}

{{--        <main class="py-4">--}}
{{--            @yield('content')--}}
{{--        </main>--}}
{{--    </div>--}}
{{--</body>--}}
{{--</html>--}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ asset('/assests/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/colors/blue.css')}}">
    <style>
        .wizard-header>h2{
            color: white !important;
        }
        .wht{
            color: white !important;
        }
        select{
            color: grey !important;
        }
        body,html,#app {
            height: 100vh;
        }
        #particles-js{
            width: 100%;
            height: 100%;
            position: fixed;
            background-color: #000;
            background-image: url('{{asset('images/reg/bg-'.rand(1,3).'.jpg')}}');
            background-size: cover;
            background-position: 50% 50%;
            background-repeat: no-repeat;
        }

        .body-particles{
            position: absolute;
            top: 0;
            left: 0;
            z-index: 100;
        }


        .blurred-box{
            /*position: relative;*/
            /*width: 250px;*/
            /*height: 350px;*/
            /*top: calc(50% - 175px);*/
            /*left: calc(50% - 125px);*/
            background: inherit;
            border-radius: 2px;
            overflow: hidden;
            backdrop-filter: blur(8px);
            color: white;
        }
        .card-title{
            color: white;
        }
        /*input{*/
        /*    color: white;*/
        /*}*/
        .blurred-box:after{
            content: '';
            /*width: 300px;*/
            /*height: 300px;*/
            background: inherit;
            position: absolute;
            /*left: -25px;*/
            /*left position*/
            /*right: 0;*/
            /*top: -25px;*/
            /*top position*/
            /*bottom: 0;*/
            box-shadow: inset 0 0 0 200px rgba(255,255,255,0.05);
            filter: blur(10px);
        }

    </style>
</head>
<body>
<div class="body-particles w-100">
    <div id="app">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center">
                <div class="blurred-box" style="border-radius: 100px">
                    <img src="{{@asset('/icon.png')}}" STYLE="z-index: 444; width: 150px">
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="blurred-box" style="text-align: center">Student Organization<br><strong>MegaMinds</strong><br>Under the aegis of Division of Student Welfare, Lovely Professional University<br></div>
            </div>
            <div class="row align-items-center mt-lg-5">
                <div class="col-lg-9 col-sm-12 mx-auto">
                    <div class="card blurred-box h-100 border-primary justify-content-center mt-5">
                        <div class="pt-lg-5 pb-lg-5 pt-md-5 pb-md-5 p-5">
                            @yield('content')
                        </div>
                    </div>
                    <div class="blurred-box" style="text-align: center">&copy;2019-20 MegaMinds WebDev Team, All Rights Reserved</div>
                </div>
            </div>
        </div></div></div><div id="particles-js"></div>
{{--<div id="app" class="container h-100">--}}
{{--    <div class="row">--}}
{{--        <div class="col-lg-3"><img class="logoimg" src="/icon.png" style=""/></div>--}}
{{--    </div>--}}
{{--    <div class="row align-items-center h-100">--}}
{{--        --}}
{{--    </div>--}}
{{--</div>--}}
</body>
<script>
    particlesJS("particles-js", {"particles":{"number":{"value":100,"density":{"enable":true,"value_area":1024}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"/icon.png","width":300,"height":300}},"opacity":{"value":0.5,"random":true,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":1,"random":true,"anim":{"enable":true,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.2,"width":1},"move":{"enable":true,"speed":1,"direction":"none","random":true,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});var count_particles, stats, update; stats = new Stats; stats.setMode(0); stats.domElement.style.position = 'absolute'; stats.domElement.style.left = '0px'; stats.domElement.style.top = '0px'; document.body.appendChild(stats.domElement); count_particles = document.querySelector('.js-count-particles'); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
</script>
</html>

