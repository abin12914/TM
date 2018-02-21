@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Profile</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @if (Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="alert-message">
                <h4>
                  {{ Session::get('message') }}
                </h4>
            </div>
        @endif
        <!-- Main row -->
        <div class="row no-print">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header">
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ !empty($currentUser->image) ? $currentUser->image : '/images/user/default_user.jpg' }}" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username text-capitalize">{{ $currentUser->user_name }}'s profile</h3>
                            <div class="widget-user-desc">&nbsp;&nbsp;&nbsp;<i class="text-red">Update required fields.</i>/&nbsp;<i class="text-maroon">Leaving empty won't update current values.</i>/&nbsp;<i class="text-orange"><b>"Current password" </b>field is mandatory.</i>
                            </div>
                        </div>
                        <form action="{{ route('user.profile.action') }}" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="user_name" class="col-md-3 control-label"> User Name : </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="user_name" placeholder="User Name" value="{{ !empty(old('user_name'))? old('user_name') : $currentUser->user_name }}" tabindex="1">
                                                @if(!empty($errors->first('user_name')))
                                                    <p style="color: red;" >{{$errors->first('user_name')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-md-3 control-label"> Name : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('name')) ? 'has-error' : '' }}">
                                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ !empty(old('name'))? old('name') : $currentUser->name }}" tabindex="2" >
                                                @if(!empty($errors->first('name')))
                                                    <p style="color: red;" >{{$errors->first('name')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="col-md-3 control-label"> Phone : </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="phone" placeholder="User Phone" value="{{ !empty(old('phone')) ? old('phone') : $currentUser->phone }}" tabindex="3">
                                                @if(!empty($errors->first('phone')))
                                                    <p style="color: red;" >{{$errors->first('phone')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image_file" class="col-md-3 control-label">Image : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('image_file')) ? 'has-error' : '' }}">
                                                <input type="file" name="image_file" class="form-control" id="image_file" tabindex="4" accept="image/*">
                                                @if(!empty($errors->first('image_file')))
                                                    <p style="color: red;" >{{$errors->first('image_file')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="old_password" class="col-md-3 control-label"><b style="color: red;">* </b> Current Password : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('old_password')) ? 'has-error' : '' }}">
                                                <input type="password" name="old_password" class="form-control" placeholder="Password"  tabindex="5">
                                                @if(!empty($errors->first('old_password')))
                                                    <p style="color: red;" >{{$errors->first('old_password')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-3 control-label"> New Password : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('password')) ? 'has-error' : '' }}">
                                                <input type="password" name="password" class="form-control" placeholder="Password"  tabindex="6">
                                                @if(!empty($errors->first('password')))
                                                    <p style="color: red;" >{{$errors->first('password')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation" class="col-md-3 control-label"> Confirm New Password : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('password')) ? 'has-error' : '' }}">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" tabindex="7">
                                                @if(!empty($errors->first('password')))
                                                    <p style="color: red;" >{{ $errors->first('password') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="9">Clear</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="8">Update</button>
                                    </div>
                                </div><br>
                            </div>
                        </form >
                    </div>
                    <!-- /.box primary -->
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection