@extends('layouts.app')
@section('title', 'Supply Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Supply
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Supply Details</li>
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
        @if(!empty($supplyTransportation))
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">Transportation Details</h3>
                        </div><br>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Ref. No.</th>
                                                <th style="width: 10%;">Truck</th>
                                                <th style="width: 20%;">Source</th>
                                                <th style="width: 20%;">Destination</th>
                                                <th style="width: 10%;">Material</th>
                                                <th style="width: 10%;">Driver</th>
                                                <th style="width: 10%;">Driver Wage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $supplyTransportation->id }}</td>
                                                <td>{{ $supplyTransportation->truck->reg_number }}</td>
                                                <td>{{ $supplyTransportation->source->name }}</td>
                                                <td>{{ $supplyTransportation->destination->name }}</td>
                                                <td>{{ $supplyTransportation->material->name }}</td>
                                                <td>{{ $supplyTransportation->employee->account->account_name }}</td>
                                                <td>{{ $supplyTransportation->driver_wage }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.boxy -->
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row (main row) -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <!-- /.box-body -->
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">Rent Details</h3>
                        </div><br>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Ref. No.</th>
                                                <th style="width: 10%;">Date</th>
                                                <th style="width: 30%;">Contractor</th>
                                                <th style="width: 10%;">Rent type</th>
                                                <th style="width: 10%;">Measurement</th>
                                                <th style="width: 10%;">Rent rate</th>
                                                <th style="width: 10%;">Discount</th>
                                                <th style="width: 15%;">Total Rent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $supplyTransportation->id }}</td>
                                                <td>{{ Carbon\Carbon::parse($supplyTransportation->date)->format('d-m-Y') }}</td>
                                                <td class="text-red">{{ $supplyTransportation->transaction->debitAccount->account_name }}</td>
                                                @if(!empty($rentTypes))
                                                    <td>{{ !empty($rentTypes[$supplyTransportation->rent_type]) ? $rentTypes[$supplyTransportation->rent_type] : "Error!" }}</td>
                                                @else
                                                    <td>Error</td>
                                                @endif
                                                <td>{{ $supplyTransportation->measurement }}</td>
                                                <td>{{ $supplyTransportation->rent_rate }}</td>
                                                <td>0</td>
                                                <td>{{ $supplyTransportation->total_rent }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">Purchase Details</h3>
                        </div><br>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Ref. No.</th>
                                                <th style="width: 10%;">Date</th>
                                                <th style="width: 30%;">Supplier</th>
                                                <th style="width: 10%;">Measure type</th>
                                                <th style="width: 10%;">Quantity</th>
                                                <th style="width: 10%;">Rate</th>
                                                <th style="width: 10%;">Discount</th>
                                                <th style="width: 15%;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $supplyTransportation->purchase->id }}</td>
                                                <td>{{ Carbon\Carbon::parse($supplyTransportation->purchase->date)->format('d-m-Y') }}</td>
                                                <td class="text-red">{{ $supplyTransportation->purchase->transaction->creditAccount->account_name }}</td>
                                                @if(!empty($measureTypes))
                                                    <td>{{ !empty($measureTypes[$supplyTransportation->purchase->measure_type]) ? $measureTypes[$supplyTransportation->purchase->measure_type] : "Error!" }}</td>
                                                @else
                                                    <td>Error</td>
                                                @endif
                                                <td>{{ $supplyTransportation->purchase->quantity }}</td>
                                                <td>{{ $supplyTransportation->purchase->rate }}</td>
                                                <td>{{ $supplyTransportation->purchase->discount }}</td>
                                                <td>{{ $supplyTransportation->purchase->total_amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">Sale Details</h3>
                        </div><br>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Ref. No.</th>
                                                <th style="width: 10%;">Date</th>
                                                <th style="width: 30%;">Customer</th>
                                                <th style="width: 10%;">Measure type</th>
                                                <th style="width: 10%;">Quantity</th>
                                                <th style="width: 10%;">Rate</th>
                                                <th style="width: 10%;">Discount</th>
                                                <th style="width: 15%;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $supplyTransportation->sale->id }}</td>
                                                <td>{{ Carbon\Carbon::parse($supplyTransportation->sale->date)->format('d-m-Y') }}</td>
                                                <td class="text-red">{{ $supplyTransportation->sale->transaction->debitAccount->account_name }}</td>
                                                @if(!empty($measureTypes))
                                                    <td>{{ !empty($measureTypes[$supplyTransportation->sale->measure_type]) ? $measureTypes[$supplyTransportation->sale->measure_type] : "Error!" }}</td>
                                                @else
                                                    <td>Error</td>
                                                @endif
                                                <td>{{ $supplyTransportation->sale->quantity }}</td>
                                                <td>{{ $supplyTransportation->sale->rate }}</td>
                                                <td>{{ $supplyTransportation->sale->discount }}</td>
                                                <td>{{ $supplyTransportation->sale->total_amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"> </div><br>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-2">
                                <form action="{{ route('under.construction') }}" method="get" class="form-horizontal">
                                    {{-- route('accounts.edit', ['id' => $account->id]) --}}
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <form action="{{route('supply.destroy', ['id' => $supplyTransportation->id])}}" method="post" class="form-horizontal">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-block btn-flat">Delete</button>
                                </form>
                            </div>
                            <!-- /.col -->
                        </div><br>
                </div>
            </div>
        @endif
    </section>
    <!-- /.content -->
</div>
@endsection