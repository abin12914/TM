@extends('layouts.app')
@section('title', 'Truck List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Truck
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Truck List</li>
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
        <div class="row  no-print">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Filter List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-header">
                        <form action="{{ route('trucks.index') }}" method="get" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-4 {{ !empty($errors->first('truck_type_id')) ? 'has-error' : '' }}">
                                            <label for="truck_type_id" class="control-label">Truck Type : </label>
                                            <select class="form-control select2" name="truck_type_id" id="truck_type_id" style="width: 100%" tabindex="1">
                                                <option value="">Select truck type</option>
                                                @if(!empty($truckTypes) && (count($truckTypes) > 0))
                                                    @foreach($truckTypes as $truckType)
                                                        <option value="{{ $truckType->id }}" {{ (old('truck_type_id') == $truckType->id || $params['truck_type_id'] == $truckType->id) ? 'selected' : '' }}>{{ $truckType->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('truck_type_id')))
                                                <p style="color: red;" >{{$errors->first('truck_type_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('truck_id')) ? 'has-error' : '' }}">
                                            <label for="truck_id" class="control-label">Truck : </label>
                                            <select class="form-control select2" name="truck_id" id="truck_id" style="width: 100%" tabindex="2">
                                                <option value="">Select truck</option>
                                                @if(!empty($trucksCombo) && (count($trucksCombo) > 0))
                                                    @foreach($trucksCombo as $truck)
                                                        <option value="{{ $truck->id }}" {{ (old('truck_id') == $truck->id || $params['id'] == $truck->id) ? 'selected' : '' }}>{{ $truck->reg_number }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('truck_id')))
                                                <p style="color: red;" >{{$errors->first('truck_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('no_of_records')) ? 'has-error' : '' }}">
                                            <label for="no_of_records" class="control-label">No Of Records Per Page : </label>
                                            <input type="text" class="form-control" name="no_of_records" id="no_of_records" value="{{ !empty(old('no_of_records')) ? old('no_of_records') : $noOfRecords }}" tabindex="3">
                                            @if(!empty($errors->first('no_of_records')))
                                                <p style="color: red;" >{{$errors->first('no_of_records')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div><br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                    <button type="reset" class="btn btn-default btn-block btn-flat"  value="reset" tabindex="4">Clear</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="5"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </form>
                        <!-- /.form end -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    {{-- page header for printers --}}
                    @include('sections.print-head')
                    <div class="box-header">
                        @if(!empty($params['truck_type_id']) || !empty($params['id']))
                            <b>Filters applied!</b>
                        @endif
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 30%;">Registration Number</th>
                                            <th style="width: 30%;">Vehicle Type</th>
                                            <th style="width: 10%;">Capacity</th>
                                            <th style="width: 10%;">Body</th>
                                            <th style="width: 15%;" class="no-print">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($trucks))
                                            @foreach($trucks as $index => $truck)
                                                <tr>
                                                    <td>{{ $index + $trucks->firstItem() }}</td>
                                                    <td>{{ $truck->reg_number }}</td>
                                                    <td>{{ $truck->truckType->name }}</td>
                                                    <td>{{ $truck->volume }}</td>
                                                    @if(!empty($bodyTypes))
                                                        <td>{{ !empty($bodyTypes[$truck->body_type]) ? $bodyTypes[$truck->body_type] : "Error!" }}</td>
                                                    @else
                                                        <td>Error</td>
                                                    @endif
                                                    <td class="no-print">
                                                        <a href="{{ route('trucks.show', ['id' => $truck->id]) }}">
                                                            <button type="button" class="btn btn-default">Details</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if(!empty($trucks))
                                    <div>
                                        Showing {{ $trucks->firstItem(). " - ". $trucks->lastItem(). " of ". $trucks->total() }}
                                    </div>
                                    <div class="no-print pull-right">
                                        {{ $trucks->appends(Request::all())->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.boxy -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection