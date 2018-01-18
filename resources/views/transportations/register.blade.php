@extends('layouts.app')
@section('title', 'Transportation Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Transportation
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Transportation Registration</li>
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
                            <h3 class="box-title" style="float: left;">Transportation Details</h3>
                                <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="{{route('accounts.store')}}" method="post" class="form-horizontal">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="col-sm-6 {{ !empty($errors->first('insurance_date')) ? 'has-error' : '' }}">
                                                <label for="insurance_date" class="control-label"><b style="color: red;">* </b> Truck : </label>
                                                <select class="form-control" name="relation_type" id="relation_type" tabindex="8">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    <option value="1" {{ (old('relation_type') == '1') ? 'selected' : '' }}>Supplier</option>
                                                    <option value="2" {{ (old('relation_type') == '2') ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ (old('relation_type') == '3') ? 'selected' : '' }}>Contractor</option>
                                                    <option value="4" {{ (old('relation_type') == '4') ? 'selected' : '' }}>General/Other</option>
                                                </select>
                                                @if(!empty($errors->first('insurance_date')))
                                                    <p style="color: red;" >{{$errors->first('insurance_date')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 {{ !empty($errors->first('tax_date')) ? 'has-error' : '' }}">
                                                <label for="tax_date" class="control-label"><b style="color: red;">* </b> Date : </label>
                                                <input type="text" class="form-control decimal_number_only datepicker" name="tax_date" id="tax_date" placeholder="Road tax expires" value="{{ old('tax_date') }}">
                                                @if(!empty($errors->first('tax_date')))
                                                    <p style="color: red;" >{{$errors->first('tax_date')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 {{ !empty($errors->first('insurance_date')) ? 'has-error' : '' }}">
                                                <label for="insurance_date" class="control-label"><b style="color: red;">* </b> Source : </label>
                                                <select class="form-control" name="relation_type" id="relation_type" tabindex="8">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    <option value="1" {{ (old('relation_type') == '1') ? 'selected' : '' }}>Supplier</option>
                                                    <option value="2" {{ (old('relation_type') == '2') ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ (old('relation_type') == '3') ? 'selected' : '' }}>Contractor</option>
                                                    <option value="4" {{ (old('relation_type') == '4') ? 'selected' : '' }}>General/Other</option>
                                                </select>
                                                @if(!empty($errors->first('insurance_date')))
                                                    <p style="color: red;" >{{$errors->first('insurance_date')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 {{ !empty($errors->first('tax_date')) ? 'has-error' : '' }}">
                                                <label for="tax_date" class="control-label"><b style="color: red;">* </b> Destination : </label>
                                                <select class="form-control" name="relation_type" id="relation_type" tabindex="8">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    <option value="1" {{ (old('relation_type') == '1') ? 'selected' : '' }}>Supplier</option>
                                                    <option value="2" {{ (old('relation_type') == '2') ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ (old('relation_type') == '3') ? 'selected' : '' }}>Contractor</option>
                                                    <option value="4" {{ (old('relation_type') == '4') ? 'selected' : '' }}>General/Other</option>
                                                </select>
                                                @if(!empty($errors->first('tax_date')))
                                                    <p style="color: red;" >{{$errors->first('tax_date')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 {{ !empty($errors->first('insurance_date')) ? 'has-error' : '' }}">
                                                <label for="insurance_date" class="control-label"><b style="color: red;">* </b> Contractor : </label>
                                                <select class="form-control" name="relation_type" id="relation_type" tabindex="8">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    <option value="1" {{ (old('relation_type') == '1') ? 'selected' : '' }}>Supplier</option>
                                                    <option value="2" {{ (old('relation_type') == '2') ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ (old('relation_type') == '3') ? 'selected' : '' }}>Contractor</option>
                                                    <option value="4" {{ (old('relation_type') == '4') ? 'selected' : '' }}>General/Other</option>
                                                </select>
                                                @if(!empty($errors->first('insurance_date')))
                                                    <p style="color: red;" >{{$errors->first('insurance_date')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 {{ !empty($errors->first('tax_date')) ? 'has-error' : '' }}">
                                                <label for="tax_date" class="control-label"><b style="color: red;">* </b> Rent Type : </label>
                                                <select class="form-control" name="relation_type" id="relation_type" tabindex="8">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    <option value="1" {{ (old('relation_type') == '1') ? 'selected' : '' }}>Supplier</option>
                                                    <option value="2" {{ (old('relation_type') == '2') ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ (old('relation_type') == '3') ? 'selected' : '' }}>Contractor</option>
                                                    <option value="4" {{ (old('relation_type') == '4') ? 'selected' : '' }}>General/Other</option>
                                                </select>
                                                @if(!empty($errors->first('tax_date')))
                                                    <p style="color: red;" >{{$errors->first('tax_date')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 {{ !empty($errors->first('insurance_date')) ? 'has-error' : '' }}">
                                                <label for="insurance_date" class="control-label"><b style="color: red;">* </b> Measurement : </label>
                                                <input type="text" class="form-control decimal_number_only datepicker" name="tax_date" id="tax_date" placeholder="Road tax expires" value="{{ old('tax_date') }}">
                                                @if(!empty($errors->first('insurance_date')))
                                                    <p style="color: red;" >{{$errors->first('insurance_date')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 {{ !empty($errors->first('tax_date')) ? 'has-error' : '' }}">
                                                <label for="tax_date" class="control-label"><b style="color: red;">* </b> Rent Rate : </label>
                                                <input type="text" class="form-control decimal_number_only datepicker" name="tax_date" id="tax_date" placeholder="Road tax expires" value="{{ old('tax_date') }}">
                                                @if(!empty($errors->first('tax_date')))
                                                    <p style="color: red;" >{{$errors->first('tax_date')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 {{ !empty($errors->first('insurance_date')) ? 'has-error' : '' }}">
                                                <label for="insurance_date" class="control-label"><b style="color: red;">* </b> Total Rent : </label>
                                                <input type="text" class="form-control decimal_number_only datepicker" name="tax_date" id="tax_date" placeholder="Road tax expires" value="{{ old('tax_date') }}">
                                                @if(!empty($errors->first('insurance_date')))
                                                    <p style="color: red;" >{{$errors->first('insurance_date')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 {{ !empty($errors->first('tax_date')) ? 'has-error' : '' }}">
                                                <label for="tax_date" class="control-label"><b style="color: red;">* </b> Material : </label>
                                                <select class="form-control" name="relation_type" id="relation_type" tabindex="8">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    <option value="1" {{ (old('relation_type') == '1') ? 'selected' : '' }}>Supplier</option>
                                                    <option value="2" {{ (old('relation_type') == '2') ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ (old('relation_type') == '3') ? 'selected' : '' }}>Contractor</option>
                                                    <option value="4" {{ (old('relation_type') == '4') ? 'selected' : '' }}>General/Other</option>
                                                </select>
                                                @if(!empty($errors->first('tax_date')))
                                                    <p style="color: red;" >{{$errors->first('tax_date')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6 {{ !empty($errors->first('tax_date')) ? 'has-error' : '' }}">
                                                <label for="tax_date" class="control-label"><b style="color: red;">* </b> Driver : </label>
                                                <select class="form-control" name="relation_type" id="relation_type" tabindex="8">
                                                    <option value="" {{ empty(old('relation_type')) ? 'selected' : '' }}>Select primary relation type</option>
                                                    <option value="1" {{ (old('relation_type') == '1') ? 'selected' : '' }}>Supplier</option>
                                                    <option value="2" {{ (old('relation_type') == '2') ? 'selected' : '' }}>Customer</option>
                                                    <option value="3" {{ (old('relation_type') == '3') ? 'selected' : '' }}>Contractor</option>
                                                    <option value="4" {{ (old('relation_type') == '4') ? 'selected' : '' }}>General/Other</option>
                                                </select>
                                                @if(!empty($errors->first('tax_date')))
                                                    <p style="color: red;" >{{$errors->first('tax_date')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 {{ !empty($errors->first('insurance_date')) ? 'has-error' : '' }}">
                                                <label for="insurance_date" class="control-label"><b style="color: red;">* </b> Driver Bata : </label>
                                                <input type="text" class="form-control decimal_number_only datepicker" name="tax_date" id="tax_date" placeholder="Road tax expires" value="{{ old('tax_date') }}">
                                                @if(!empty($errors->first('insurance_date')))
                                                    <p style="color: red;" >{{$errors->first('insurance_date')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-3">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="12">Clear</button>
                                    </div>
                                    <div class="col-xs-3">
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
@section('scripts')
    <script src="/js/registration/accountRegistration.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection