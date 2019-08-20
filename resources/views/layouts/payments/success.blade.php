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
        @import url(https://fonts.googleapis.com/css?family=Raleway:400,700,600);
        .container{
            padding: 20px;
        }
        body{
            background-color: #f6f4f4;
            font-family: 'Raleway', sans-serif;
        }
        .teal{
            background-color: #ffc952 !important;
            color: #444444 !important;
        }
        a{
            color: #47b8e0 !important;
        }
        .message{
            text-align: left;
        }
        .price1{
            font-size: 40px;
            font-weight: 200;
            display: block;
            text-align: center;
        }
        .ui.message p {margin: 5px;}
    </style>
</head>
<body>
<div class="h-100 text-center">
    <img src="/icon.png" width="150px">
<div class="jumbotron text-xs-center">
    <h1 class="display-3">Thank You!</h1>
    <h1 class="display-6">Your Payment was Successful</h1>
    <p class="lead"><strong>Please check your email</strong> for receipt.</p>
    <p><strong>For any query contact : support@megaminds.club</strong></p>
    <hr>
    <p>
        Having trouble? <a href="mailto:support@megaminds.club">Contact us</a>
    </p>
    <p class="lead">
        <a class="btn btn-primary btn-sm" href="https://oms.megaminds.club/" role="button">Continue to homepage</a>
    </p>
</div>
</div></body>
</html>
