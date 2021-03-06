@extends('layouts.app')
@section('title', 'Account Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Account
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Account Registration</li>
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
                            <h3 class="box-title" style="float: left;">Account Details</h3>
                                <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="{{route('accounts.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="account_name" class="col-md-3 control-label"><b style="color: red;">* </b> Account Name : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('account_name')) ? 'has-error' : '' }}">
                                                <input type="text" name="account_name" class="form-control" id="account_name" placeholder="Account Name" value="{{ old('account_name') }}" tabindex="1" maxlength="100">
                                                @if(!empty($errors->first('account_name')))
                                                    <p style="color: red;" >{{$errors->first('account_name')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="col-md-3 control-label">Description : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('description')) ? 'has-error' : '' }}">
                                                @if(!empty(old('description')))
                                                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description" style="resize: none;" tabindex="2" maxlength="200">{{ old('description') }}</textarea>
                                                @else
                                                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description" style="resize: none;" tabindex="2" maxlength="200"></textarea>
                                                @endif
                                                @if(!empty($errors->first('description')))
                                                    <p style="color: red;" >{{$errors->first('description')}}</p>
                                                @endif
                                            </div>
                                        </div><br>
                                        <div class="box-header with-border">
                                            <h3 class="box-title" style="float: left;">Personal Details</h3>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-md-3 control-label"><b style="color: red;">* </b> Name : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('name')) ? 'has-error' : '' }}">
                                                <input type="text" name="name" class="form-control alpha_only" id="name" placeholder="Account holder name" value="{{ old('name') }}" tabindex="3" maxlength="100">
                                                @if(!empty($errors->first('name')))
                                                    <p style="color: red;" >{{$errors->first('name')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="col-md-3 control-label"><b style="color: red;">* </b> Phone : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('phone')) ? 'has-error' : '' }}">
                                                <input type="text" name="phone" class="form-control number_only" id="phone" placeholder="Phone number" value="{{ old('phone') }}" tabindex="4" maxlength="13">
                                                @if(!empty($errors->first('phone')))
                                                    <p style="color: red;" >{{$errors->first('phone')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-md-3 control-label">Address : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('address')) ? 'has-error' : '' }}">
                                                @if(!empty(old('address')))
                                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" style="resize: none;" tabindex="5" maxlength="200">{{ old('address') }}</textarea>
                                                @else
                                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" style="resize: none;" tabindex="5" maxlength="200"></textarea>
                                                @endif
                                                @if(!empty($errors->first('address')))
                                                    <p style="color: red;" >{{$errors->first('address')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image_file" class="col-md-3 control-label">Image : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('image_file')) ? 'has-error' : '' }}">
                                                <input type="file" name="image_file" class="form-control" id="image_file" value="{{ old('image_file') }}" tabindex="6" accept="image/*">
                                                @if(!empty($errors->first('image_file')))
                                                    <p style="color: red;" >{{$errors->first('image_file')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="relation_type" class="col-md-3 control-label"><b style="color: red;">* </b> Primary Relation : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('relation_type')) ? 'has-error' : '' }}">
                                                <select class="form-control select2" name="relation_type" id="relation_type" tabindex="7" style="width: 100%;">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    @if(!empty($relationTypes))
                                                        @foreach($relationTypes as $key => $relationType)
                                                            <option value="{{ $key }}" {{ (old('relation_type') == $key) ? 'selected' : '' }}>
                                                                {{ $relationType }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if(!empty($errors->first('relation_type')))
                                                    <p style="color: red;" >{{$errors->first('relation_type')}}</p>
                                                @endif
                                            </div>
                                        </div><br>
                                        <div class="box-header with-border">
                                            <h3 class="box-title" style="float: left;">Financial Details</h3>
                                                <p>&nbsp&nbsp&nbsp</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="financial_status" class="col-md-3 control-label"><b style="color: red;">* </b> Financial Status : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('financial_status')) ? 'has-error' : '' }}">
                                                <select class="form-control select2" name="financial_status" id="financial_status" tabindex="8" style="width: 100%;">
                                                    <option value="" {{ empty(old('financial_status')) ? 'selected' : '' }}>Select financial status</option>
                                                    <option value="0" {{ (old('financial_status') == '0') ? 'selected' : '' }}>None (No pending transactions)</option>
                                                    <option value="2" {{ (old('financial_status') == '2') ? 'selected' : '' }}>Debitor (Account holder owe to the company)</option>
                                                    <option value="1" {{ (old('financial_status') == '1') ? 'selected' : '' }}>Creditor (Company owe to the account holder)</option>
                                                </select>
                                                @if(!empty($errors->first('financial_status')))
                                                    <p style="color: red;" >{{$errors->first('financial_status')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="opening_balance" class="col-md-3 control-label"><b style="color: red;">* </b> Opening Balance : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('opening_balance')) ? 'has-error' : '' }}">
                                                <input type="text" class="form-control decimal_number_only" name="opening_balance" id="opening_balance" placeholder="Opening balance" value="{{ old('opening_balance') }}" {{ old('financial_status') == '0' ? 'readonly' : '' }} tabindex="9" maxlength="8">
                                                @if(!empty($errors->first('opening_balance')))
                                                    <p style="color: red;" >{{$errors->first('opening_balance')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="10">Clear</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="11">Submit</button>
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