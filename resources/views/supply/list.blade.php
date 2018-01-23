@extends('layouts.app')
@section('title', 'Supply List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Supply
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Supply List</li>
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
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($supplyTransportations))
                                            @foreach($supplyTransportations as $index => $transportation)
                                                <tr>
                                                    <td>{{ $index + $supplyTransportations->firstItem() }}</td>
                                                    <td>{{ Carbon\Carbon::parse($transportation->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $transportation->truck->reg_number }}</td>
                                                    <td>{{ $transportation->transaction->debitAccount->account_name }}</td>
                                                    <td>{{ $transportation->source->name }}</td>
                                                    <td>{{ $transportation->destination->name }}</td>
                                                    <td>{{ $transportation->material->name }}</td>
                                                    <td>
                                                        <button type="button" class="bg-aqua submit-button" type="button">Add</button>
                                                    </td>
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
                                    @if(!empty($supplyTransportations))
                                        {{ $supplyTransportations->appends(Request::all())->links() }}
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