<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="manifest" href="/app.json">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Event Management System for Organizations which facilitates easy management, online enrollments, ticket booking, online payments and much more">
    <meta name="author" content="Nukrip Technologies Private Limited">
    <link rel="icon" type="image/png" sizes="16x16" href="/kepler/assets/images/favicon.png">
    <title>{{ config('app.name', 'EMS') }}</title>
    <link href="{{@asset('/css/app.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<div id="app">
    <div class="">
<section id="wrapper">
    <div class="h-100">
    <div class="login-register" style="background-image:url(/backgrounds/process_{{@rand(1,173)}}.jpg);">
        @yield('content')
    </div>
    </div>
</section>
    </div>
</div>
<script src="{{@asset('/js/app.js')}}"></script>
<script src="{{@asset('/js/applet.js')}}"></script>
<script src="{{@asset('/js/sideMenu.js')}}"></script>
</body>

</html>