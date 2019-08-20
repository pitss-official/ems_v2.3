<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
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
<div class="container">
    <div class="ui middle aligned center aligned grid">
        <div class="ui eight wide column">

            <form class="ui large form">

                <div class="ui icon negative message">
                    <i class="warning icon"></i>
                    <div class="content">
                        <div class="header">
                            Oops! Something went wrong.
                        </div>
                        <p>While trying to reserve money from your account</p>
                    </div>

                </div>

                <a href="/register"><span class="ui large teal submit fluid button">Try again</span></a>

            </form>
        </div>
        <div class="text-center"><h5>Is it an error? report your incident at pay@megaminds.club </h5></div>
    </div>
</div></div>
</body>
</html>
