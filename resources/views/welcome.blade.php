@extends('layouts.app')
@section('content')
    <header>
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('login') }}" class="btn-round" id="login-btn">Prisijungti</a>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('register') }}" class="btn-round" id="register-btn">Registruotis</a>
            </div>
        </div>
    </header>
@endsection