@extends('layouts.app')
@section('content')
    <div class="jumbotron text-center">
        <h1>If <strong>YOU</strong> don't know what to do...</h1>
        <h2>Go to BAbook</h2>
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success">Register</a>
    </div>
@endsection