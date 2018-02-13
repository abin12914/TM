@extends('layouts.app')
@section('title', 'Truck Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Truck
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Truck Registration</li>
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
                            <h3 class="box-title" style="float: left;">Truck Details</h3>
                                <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                        </div><br>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="{{route('trucks.store')}}" method="post" class="form-horizontal" autocomplete="off">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="reg_number_state_code" class="col-md-3 control-label"><b style="color: red;">* </b> Registration Number : </label>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-2 col-xs-3 {{ !empty($errors->first('reg_number_state_code')) ? 'has-error' : '' }}">
                                                        <select class="form-control select2" name="reg_number_state_code" id="reg_number_state_code" tabindex="1" style="width: 100%;">
                                                            @if(!empty($stateCodes))
                                                                @foreach($stateCodes as $stateCode)
                                                                    <option value="{{ $stateCode->code }}" {{ empty(old('reg_number_state_code')) ? ($stateCode->code == 'KL' ? "selected" : "") : (old('reg_number_state_code') == $stateCode->code ? 'selected' : '') }}>{{ $stateCode->code }}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="" selected>Select state code</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 col-xs-2 {{ !empty($errors->first('reg_number_region_code')) ? 'has-error' : '' }}">
                                                        <input type="text" name="reg_number_region_code" class="form-control number_only" id="reg_number_region_code" placeholder="" value="{{ old('reg_number_region_code') }}" tabindex="2" maxlength="2">
                                                    </div>
                                                    <div class="col-md-2 col-xs-2 {{ !empty($errors->first('reg_number_unique_alphabet')) ? 'has-error' : '' }}">
                                                        <input type="text" name="reg_number_unique_alphabet" class="form-control alpha_only" id="reg_number_unique_alphabet" placeholder="" value="{{ old('reg_number_unique_alphabet') }}" tabindex="3" maxlength="2">
                                                    </div>
                                                    <div class="col-md-2 col-xs-2 {{ !empty($errors->first('reg_number_unique_digit')) ? 'has-error' : '' }}">
                                                        <input type="text" name="reg_number_unique_digit" class="form-control number_only" id="reg_number_unique_digit" placeholder="" value="{{ old('reg_number_unique_digit') }}" tabindex="4" maxlength="4">
                                                    </div>
                                                    <div class="col-md-4 col-xs-3 {{ !empty($errors->first('reg_number')) ? 'has-error' : '' }}">
                                                        <input type="text" name="reg_number" class="form-control" id="reg_number" value="{{ old('reg_number') }}" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($errors->first('reg_number')))
                                                <p style="color: red;" >{{$errors->first('reg_number')}}</p>
                                            @elseif(!empty($errors->first('reg_number_state_code')))
                                                <p style="color: red;" >{{$errors->first('reg_number_state_code')}}</p>
                                            @elseif(!empty($errors->first('reg_number_region_code')))
                                                <p style="color: red;" >{{$errors->first('reg_number_region_code')}}</p>
                                            @elseif(!empty($errors->first('reg_number_unique_alphabet')))
                                                <p style="color: red;" >{{$errors->first('reg_number_unique_alphabet')}}</p>
                                            @elseif(!empty($errors->first('reg_number_unique_digit')))
                                                <p style="color: red;" >{{$errors->first('reg_number_unique_digit')}}</p>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="col-md-3 control-label">Description : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('description')) ? 'has-error' : '' }}">
                                                @if(!empty(old('description')))
                                                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Truck Description" style="resize: none;" tabindex="5">{{ old('description') }}</textarea>
                                                @else
                                                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Truck Description" style="resize: none;" tabindex="5"></textarea>
                                                @endif
                                                @if(!empty($errors->first('description')))
                                                    <p style="color: red;" >{{$errors->first('description')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="truck_type" class="col-md-3 control-label"><b style="color: red;">* </b> Truck Type : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('truck_type')) ? 'has-error' : '' }}">
                                                <select class="form-control select2" name="truck_type" id="truck_type" tabindex="6" style="width: 100%;">
                                                    <option value="" {{ empty(old('truck_type')) ? 'selected' : '' }}>Select truck type</option>
                                                    @if(!empty($truckTypes))
                                                        @foreach($truckTypes as $truckType)
                                                            <option value="{{ $truckType->id }}" {{ (old('truck_type') == $truckType->id) ? 'selected' : '' }}>{{ $truckType->name }} - {{ $truckType->generic_quantity }} cubic unit class</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if(!empty($errors->first('truck_type')))
                                                    <p style="color: red;" >{{$errors->first('truck_type')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><b style="color: red;">* </b> Volume In Feet : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('volume')) ? 'has-error' : '' }}">
                                                <input type="text" class="form-control number_only" name="volume" id="volume" placeholder="Volume in cubic feet" value="{{ old('volume') }}" tabindex="7" maxlength="9">
                                                @if(!empty($errors->first('volume')))
                                                    <p style="color: red;" >{{$errors->first('volume')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="body_type" class="col-md-3 control-label"><b style="color: red;">* </b> Body Type : </label>
                                            <div class="col-md-9 {{ !empty($errors->first('body_type')) ? 'has-error' : '' }}">
                                                <select class="form-control select2" name="body_type" id="body_type" tabindex="8" style="width: 100%;">
                                                    <option value="" {{ empty(old('body_type')) ? 'selected' : '' }}>Select body type</option>
                                                    @if(!empty($bodyTypes))
                                                        @foreach($bodyTypes as $key => $bodyType)
                                                            <option value="{{ $key }}" {{ (old('body_type') == $bodyType) ? 'selected' : '' }}>
                                                                {{ $bodyType }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if(!empty($errors->first('body_type')))
                                                    <p style="color: red;" >{{$errors->first('body_type')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border">
                                            <h3 class="box-title" style="float: left;">Legal Details</h3>
                                            <p>&nbsp&nbsp&nbsp(Use expiry dates.)</p>
                                        </div><br>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="col-md-6 {{ !empty($errors->first('insurance_date')) ? 'has-error' : '' }}">
                                                    <label for="insurance_date" class="control-label"><b style="color: red;">* </b> Insurance Expires : </label>
                                                    <input type="text" class="form-control decimal_number_only datepicker" name="insurance_date" id="insurance_date" placeholder="Insurance expires" value="{{ old('insurance_date') }}" tabindex="9">
                                                    @if(!empty($errors->first('insurance_date')))
                                                        <p style="color: red;" >{{$errors->first('insurance_date')}}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 {{ !empty($errors->first('tax_date')) ? 'has-error' : '' }}">
                                                    <label for="tax_date" class="control-label"><b style="color: red;">* </b> Road Tax Expires : </label>
                                                    <input type="text" class="form-control decimal_number_only datepicker" name="tax_date" id="tax_date" placeholder="Road tax expires" value="{{ old('tax_date') }}" tabindex="10">
                                                    @if(!empty($errors->first('tax_date')))
                                                        <p style="color: red;" >{{$errors->first('tax_date')}}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ !empty($errors->first('fitness_date')) ? 'has-error' : '' }}">
                                                    <label for="fitness_date" class="control-label"><b style="color: red;">* </b> Certificate of Fitness Expires : </label>
                                                    <input type="text" class="form-control decimal_number_only datepicker" name="fitness_date" id="fitness_date" placeholder="Certificate of fitness expires" value="{{ old('fitness_date') }}" tabindex="11">
                                                    @if(!empty($errors->first('fitness_date')))
                                                        <p style="color: red;" >{{$errors->first('fitness_date')}}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 {{ !empty($errors->first('permit_date')) ? 'has-error' : '' }}">
                                                    <label for="permit_date" class="control-label"><b style="color: red;">* </b> Permit Expires : </label>
                                                    <input type="text" class="form-control decimal_number_only datepicker" name="permit_date" id="permit_date" placeholder="Permit expires" value="{{ old('permit_date') }}" tabindex="12">
                                                    @if(!empty($errors->first('permit_date')))
                                                        <p style="color: red;" >{{$errors->first('permit_date')}}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                                <div class="col-md-6 {{ !empty($errors->first('pollution_date')) ? 'has-error' : '' }}">
                                                    <label for="pollution_date" class="control-label"><b style="color: red;">* </b> Pollution Certificate Expires : </label>
                                                    <input type="text" class="form-control decimal_number_only datepicker" name="pollution_date" id="pollution_date" placeholder="Poluution under control certificate expires" value="{{ old('pollution_date') }}">
                                                    @if(!empty($errors->first('pollution_date')))
                                                        <p style="color: red;" >{{$errors->first('pollution_date')}}</p>
                                                    @endif
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="13">Clear</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="14">Submit</button>
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
    <script src="/js/registrations/truckRegistration.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection