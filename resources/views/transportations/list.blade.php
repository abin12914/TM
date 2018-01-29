@extends('layouts.app')
@section('title', 'Transportations List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Transportations
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Transportations List</li>
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
                        <form action="{{ route('transportations.index') }}" method="get" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-4 {{ !empty($errors->first('from_date')) ? 'has-error' : '' }}">
                                            <label for="from_date" class="control-label">From Date : </label>
                                            <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="{{ !empty(old('from_date')) ? old('from_date') : $params[0]['paramValue'] }}">
                                            @if(!empty($errors->first('from_date')))
                                                <p style="color: red;" >{{$errors->first('from_date')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('to_date')) ? 'has-error' : '' }}">
                                            <label for="to_date" class="control-label">To Date : </label>
                                            <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="{{ !empty(old('to_date')) ? old('to_date') : $params[1]['paramValue'] }}">
                                            @if(!empty($errors->first('to_date')))
                                                <p style="color: red;" >{{$errors->first('to_date')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('contractor_account_id')) ? 'has-error' : '' }}">
                                            <label for="contractor_account_id" class="control-label">Contractor : </label>
                                            <select class="form-control select2" name="contractor_account_id" id="contractor_account_id" style="width: 100%">
                                                <option value="">Select account</option>
                                                @if(!empty($accounts) && (count($accounts) > 0))
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->id }}" {{ (old('contractor_account_id') == $account->id || $params[7]['paramValue'] == $account->id) ? 'selected' : '' }}>
                                                            {{ $account->account_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('contractor_account_id')))
                                                <p style="color: red;" >{{$errors->first('contractor_account_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4 {{ !empty($errors->first('truck_id')) ? 'has-error' : '' }}">
                                            <label for="truck_id" class="control-label">Truck : </label>
                                            <select class="form-control select2" name="truck_id" id="truck_id" style="width: 100%">
                                                <option value="">Select truck</option>
                                                @if(!empty($trucks) && (count($trucks) > 0))
                                                    @foreach($trucks as $truck)
                                                        <option value="{{ $truck->id }}" {{ (old('truck_id') == $truck->id || $params[2]['paramValue'] == $truck->id) ? 'selected' : '' }}>{{ $truck->reg_number }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('truck_id')))
                                                <p style="color: red;" >{{$errors->first('truck_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('source_id')) ? 'has-error' : '' }}">
                                            <label for="source_id" class="control-label">Source : </label>
                                            <select class="form-control select2" name="source_id" id="source_id" style="width: 100%">
                                                <option value="">Select source</option>
                                                @if(!empty($sites) && (count($sites) > 0))
                                                    @foreach($sites as $site)
                                                        <option value="{{ $site->id }}" {{ (old('source_id') == $site->id || $params[3]['paramValue'] == $site->id) ? 'selected' : '' }}>{{ $site->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('source_id')))
                                                <p style="color: red;" >{{$errors->first('source_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('destination_id')) ? 'has-error' : '' }}">
                                            <label for="destination_id" class="control-label">Destination : </label>
                                            <select class="form-control select2" name="destination_id" id="destination_id" style="width: 100%">
                                                <option value="">Select source</option>
                                                @if(!empty($sites) && (count($sites) > 0))
                                                    @foreach($sites as $site)
                                                        <option value="{{ $site->id }}" {{ (old('destination_id') == $site->id || $params[4]['paramValue'] == $site->id) ? 'selected' : '' }}>{{ $site->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('destination_id')))
                                                <p style="color: red;" >{{$errors->first('destination_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4 {{ !empty($errors->first('driver_id')) ? 'has-error' : '' }}">
                                            <label for="driver_id" class="control-label">Driver : </label>
                                            <select class="form-control select2" name="driver_id" id="driver_id" style="width: 100%">
                                                <option value="">Select driver</option>
                                                @if(!empty($drivers) && (count($drivers) > 0))
                                                    @foreach($drivers as $driver)
                                                        <option value="{{ $driver->id }}" {{ (old('driver_id') == $driver->id || $params[5]['paramValue'] == $driver->id) ? 'selected' : '' }}>{{ $driver->account->accountDetail->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('driver_id')))
                                                <p style="color: red;" >{{$errors->first('driver_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('material_id')) ? 'has-error' : '' }}">
                                            <label for="material_id" class="control-label">Material : </label>
                                            <select class="form-control select2" name="material_id" id="material_id" style="width: 100%">
                                                <option value="">Select material</option>
                                                @if(!empty($materials) && (count($materials) > 0))
                                                    @foreach($materials as $material)
                                                        <option value="{{ $material->id }}" {{ (old('material_id') == $material->id || $params[6]['paramValue'] == $material->id) ? 'selected' : '' }}>{{ $material->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('driver_id')))
                                                <p style="color: red;" >{{$errors->first('driver_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('no_of_records')) ? 'has-error' : '' }}">
                                            <label for="no_of_records" class="control-label">No Of Records Per Page : </label>
                                            <input type="text" class="form-control" name="no_of_records" id="no_of_records" value="{{ !empty(old('no_of_records')) ? old('no_of_records') : $noOfRecords }}">
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
                                    <button type="reset" class="btn btn-default btn-block btn-flat"  value="reset" tabindex="10">Clear</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="4"><i class="fa fa-search"></i> Search</button>
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
                    <div class="box-header no-print">
                        @foreach($params as $param)
                            @if(!empty($param['paramValue']))
                                <b>Filters applied!</b>
                                @break
                            @endif
                        @endforeach
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 10%;">Date</th>
                                            <th style="width: 15%;">Truck</th>
                                            <th style="width: 10%;">Contractor</th>
                                            <th style="width: 10%;">Source</th>
                                            <th style="width: 10%;">Destination</th>
                                            <th style="width: 10%;" class="no-print">Material</th>
                                            <th style="width: 10%;">Total Rent</th>
                                            <th style="width: 10%;" class="no-print">Driver</th>
                                            <th style="width: 5%;" class="no-print">Driver Wage</th>
                                            <th style="width: 5%;" class="no-print">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($transportations))
                                            @foreach($transportations as $index => $transportation)
                                                <tr>
                                                    <td>{{ $index + $transportations->firstItem() }}</td>
                                                    <td>{{ Carbon\Carbon::parse($transportation->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $transportation->truck->reg_number }}</td>
                                                    <td>{{ $transportation->transaction->debitAccount->account_name }}</td>
                                                    <td>{{ $transportation->source->name }}</td>
                                                    <td>{{ $transportation->destination->name }}</td>
                                                    <td class="no-print">{{ $transportation->material->name }}</td>
                                                    <td>{{ $transportation->total_rent }}</td>
                                                    <td class="no-print">{{ $transportation->employee->account->accountDetail->name }}</td>
                                                    <td class="no-print">{{ $transportation->driver_wage }}</td>
                                                    <td class="no-print">
                                                        <a href="{{ route('transportations.show', ['id' => $transportation->id]) }}">
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
                                @if(!empty($transportations))
                                    <div>
                                        Showing {{ $transportations->firstItem(). " - ". $transportations->lastItem(). " of ". $transportations->total() }}<br>
                                    </div>
                                    <div class=" no-print pull-right">
                                        {{ $transportations->appends(Request::all())->links() }}
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