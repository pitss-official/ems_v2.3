@extends('layouts.app')

@section('content')

{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
<div class="card-header" style="background: none; text-align: center"><h3 style="color: white">{{ __('Reset Password') }}</h3></div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="collegeUID" class="col-md-4 col-form-label text-md-right">{{ __('College ID') }}</label>

                                <div class="col-md-6">
                                    <input id="collegeUID" type="number" class="form-control @if($errors->has('collegeUID')) is-invalid @endif " name="collegeUID" value="{{ $collegeUID ?? old('collegeUID') }}" required autocomplete="collegeUID" autofocus>

                                    @if($errors->has('collegeUID'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('collegeUID') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @if($errors->has('password')) is-invalid @endif " name="password" required autocomplete="new-password">

                                    @if($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
