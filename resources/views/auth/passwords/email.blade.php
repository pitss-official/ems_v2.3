@extends('layouts.app')

@section('content')
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
                    <div class="card-header" style="background: none; text-align: center"><h3 style="color: white">{{ __('Reset Password') }}</h3></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="collegeUID" class="col-md-4 col-form-label text-md-right">{{ __('College ID') }}</label>

                                <div class="col-md-6">
                                    <input id="collegeUID" type="collegeUID" class="form-control @if($errors->has('collegeUID')) is-invalid @endif " name="collegeUID" value="{{ old('collegeUID') }}" required autocomplete="collegeUID" autofocus>

                                    @if($errors->has('collegeUID'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('collegeUID') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
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
