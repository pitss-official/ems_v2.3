@extends('layouts.auth')

@section('content')
    {{----}}
    <div class="login-box card">{{--<div class="card-header">{{ __('Login') }}</div>--}}
        <div class="card-body">
            <a href="javascript:void(0)" class="text-center db"><img src="{{@asset('/kepler/assets/images/logo-icon.png')}}" alt="Home"><br><img src="{{@asset('/kepler/assets/images/logo-text.png')}}" alt="Home"></a><br>
            <form method="POST" action="{{ route('login') }}" class="form-horizontal {{ $errors->has('email') ? 'form-control-line' : 'form-material' }}" id="loginform">
                @csrf
                <h3 class="box-title m-b-20">Member Login</h3>
                <div class="form-group {{ $errors->has('email') ? 'has-danger' : '' }}">
                    <div class="col-xs-12">
                        <input id="email" class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}" type="text" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('E-Mail Address or User ID') }}">
                        @if ($errors->has('email'))
                            <span class="form-control-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" type="password" required="" placeholder="Password"> </div>
                    @if ($errors->has('password'))
                        <span class="form-control-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary pull-left p-t-0">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-dark pull-right" href="{{ route('password.request') }}">
                                <i class="fa fa-lock m-r-5"></i>{{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="social">
                            <a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>
                            <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="form-group m-b-2">
                    <div class="col-sm-12 text-center">
                        <p>Still waiting to Join? <a href="/register" class="text-info m-l-5"><b>Sign Up</b></a></p>
                    </div>

                </div>

                <div class="form-group"><hr>
                    <div class="col-sm-12">
                        <p class="text-center">Made with <span class="text-danger">&hearts;</span> for MegaMinds</p>
                        <p class="text-center"><a href="https://www.nukrip.com" class=""><b>&copy; 2019 Nukrip Technologies Private Limited</b></a></p>
                    </div>
                </div>
            </form>
            <form class="form-horizontal" id="recoverform" action="index.html">
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3>Recover Password</h3>
                        <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" required="" placeholder="Email"> </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


