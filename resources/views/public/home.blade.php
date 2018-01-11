@extends('layouts.public')
@section('title', 'Home')
@section('content')
@if(Session::has('message'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="alert-message">
        <h4>
            {!! Session::get('message') !!}
        </h4>
    </div>
@endif
@if(Session::has('fixed-message'))
    <div class="alert {{ Session::get('fixed-alert-class', 'alert-info') }}" id="fixed-alert-message">
        <h4 style="margin-left: 20px;">
            {!! Session::get('fixed-message') !!}
        </h4>
    </div>
@endif
<div class="login-box">
    <div class="login-logo">
        <div>
            <img src="/images/tipping.png" width: 100%; height="100">
            <br>
            <b>
                WELCOME TO<br>TRUCKING MANAGER
            </b>
        </div>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">
            <b>
                {{-- Trucking : The art or business of conveying articles or goods on trucks<br> --}}
                <i>Log in to start your session</i>
            </b>
        </p>
        <a href="{{route('login-view')}}">
            <button class="btn btn-primary btn-block btn-flat">Log In</button>
        </a>
        <br>
        <p class="login-box-msg">Need Help? <a>Contact</a> The Developer Team.</p>
    </div>
  <!-- /.login-box-body -->
</div>
@endsection