@extends('layouts.app')
@section('title', 'Site Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Site
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Site Registration</li>
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
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">Site Details</h3>
                                <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="{{route('sites.store')}}" method="post" class="form-horizontal" autocomplete="off">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="site_name" class="col-md-3 control-label"><b style="color: red;">* </b> Site Name : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('site_name')) ? 'has-error' : '' }}">
                                                <input type="text" name="site_name" class="form-control" id="site_name" placeholder="Site Name" value="{{ old('site_name') }}"  tabindex="1" maxlength="200" tabindex="1">
                                                @if(!empty($errors->first('site_name')))
                                                    <p style="color: red;" >{{$errors->first('site_name')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="place" class="col-md-3 control-label"><b style="color: red;">* </b> Place : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('place')) ? 'has-error' : '' }}">
                                                <input type="text" name="place" class="form-control" id="place" placeholder="Place" value="{{ old('place') }}"  tabindex="2" maxlength="200">
                                                @if(!empty($errors->first('place')))
                                                    <p style="color: red;" >{{$errors->first('place')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-md-3 control-label">Address : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('address')) ? 'has-error' : '' }}">
                                                @if(!empty(old('address')))
                                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" style="resize: none;" maxlength="200" tabindex="3">{{ old('address') }}</textarea>
                                                @else
                                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" style="resize: none;" maxlength="200" tabindex="3"></textarea>
                                                @endif
                                                @if(!empty($errors->first('address')))
                                                    <p style="color: red;" >{{$errors->first('address')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="location_type" class="col-md-3 control-label"><b style="color: red;">* </b> Location Type : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('location_type')) ? 'has-error' : '' }}">
                                                <select class="form-control select2" name="location_type" id="location_type" tabindex="4" style="width: 100%;">
                                                    <option value="" {{ empty(old('location_type')) ? 'selected' : '' }}>Select location type</option>
                                                    @if(!empty($siteTypes))
                                                        @foreach($siteTypes as $key => $siteType)
                                                            <option value="{{ $key }}" {{ (old('location_type') == $key) ? 'selected' : '' }}>
                                                                {{ $siteType }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if(!empty($errors->first('location_type')))
                                                    <p style="color: red;" >{{$errors->first('location_type')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="5">Clear</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="6">Submit</button>
                                    </div>
                                    <!-- /.col -->
                                </div><br>
                            </div>
                        </form>
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
@section('scripts')
    {{-- <script src="/js/registration/accountRegistration.js?rndstr={{ rand(1000,9999) }}"></script> --}}
@endsection