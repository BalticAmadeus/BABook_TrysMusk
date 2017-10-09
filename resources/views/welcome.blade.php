@extends('layouts.app')
@section('content')
    <div class="row" id="loginRegisterBtn">
        <div class="col-md-12 text-center">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg" id="login-btn">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success btn-lg" id="register-btn">Register</a>
        </div>
    </div>
@endsection