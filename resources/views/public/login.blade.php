@extends('layouts.public')
@section('title', 'Login')
@section('stylesheets')
<!-- iCheck -->
<link rel="stylesheet" href="/css/plugins/iCheck/square/blue.css">
@endsection
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a>TRUCKING MANAGER</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @if (Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible" id="alert-message">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>
                    {!! Session::get('message') !!}
                </h4>
            </div>
        @endif
        <p class="login-box-msg">Sign in to start your session</p>
        @if($errors->has('username_password'))
            <p class="login-box-msg" style="color: red;" >{{$errors->first('username_password')}}</p>
        @endif
        <form action="{{ route('login.action') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback {{ ($errors->has('username') || $errors->has('username_password')) ? "has-error" : "" }}">
                <input type="text" class="form-control" name="username" placeholder="User name" value="{{ old('username') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if($errors->has('username'))
                    <p style="color: red;" >{{$errors->first('username')}}</p>
                @endif
            </div>
            <div class="form-group has-feedback {{ ($errors->has('password') || $errors->has('username_password')) ? "has-error" : "" }}">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if($errors->has('password'))
                    <p style="color: red;" >{{$errors->first('password')}}</p>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="rememberUser" value="true">&nbsp; Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="#">Forgot password?</a><br>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
@section('scripts')
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
@endsection