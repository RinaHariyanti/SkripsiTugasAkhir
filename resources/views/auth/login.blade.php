@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-image: url('img/background.jpg'); background-size: cover; height: 100vh; position: relative;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
        <div class="row justify-content-center py-5">
            <div class="col-md-3 mt-5">
                @include('layouts.messages')
                <div class="card" style="background-image: url('img/background.jpg'); background-size: cover;">
                    <div class="card-header bg-primary text-white">{{ __('Login') }}</div>

                    <div class="card-body" style="background-color: rgba(255, 255, 255, 0.8);">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                                @if (Route::has('register'))
                                    <button type="button" class="btn btn-secondary mt-2" onclick="window.location='{{ route('register') }}'">{{ __('Register') }}</button>
                                @endif
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link mt-2" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
