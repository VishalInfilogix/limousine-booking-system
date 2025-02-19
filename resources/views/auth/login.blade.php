@extends('auth.layout')
@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg dark-color">Sign in to start your session</p>

    <form id="loginForm" method="POST" action="{{ route('submit-login') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" placeholder="Email" autocomplete="off" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" placeholder="Password"  autocomplete="off" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-eye-slash passwordIcon"></span>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <button type="submit" id="loginButton" class="btn-block theme-btn" title="Sign In">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <p class="mt-2 mb-1 text-end">
        <a class="theme-color text-xs" href="{{route('password.request')}}">Forgot Password?</a>
    </p>
</div>
@endsection