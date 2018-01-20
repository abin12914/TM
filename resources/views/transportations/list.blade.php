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
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Truck</th>
                                            <th>Contractor</th>
                                            <th>Source</th>
                                            <th>Destination</th>
                                            <th>Material</th>
                                            <th>Rent Type</th>
                                            <th>Measurement</th>
                                            <th>Rate</th>
                                            <th>Total Rent</th>
                                            <th>Driver</th>
                                            <th>Driver Wage</th>
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
                                                    <td>{{ $transportation->material->name }}</td>
                                                    @if(!empty($rentTypes))
                                                        <td>
                                                            {{ !empty($rentTypes[$transportation->rent_type]) ? $rentTypes[$transportation->rent_type] : "Error!" }}
                                                        </td>
                                                    @else
                                                        <td>Error</td>
                                                    @endif
                                                    <td>{{ $transportation->measurement }}</td>
                                                    <td>{{ $transportation->rent_rate }}</td>
                                                    <td>{{ $transportation->total_rent }}</td>
                                                    <td>{{ $transportation->employee->account->accountDetail->name }}</td>
                                                    <td>{{ $transportation->driver_wage }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row no-print">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    @if(!empty($transportations))
                                        {{ $transportations->appends(Request::all())->links() }}
                                    @endif
                                </div>
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