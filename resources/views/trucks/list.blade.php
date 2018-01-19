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
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
                                            <th>Registration Number</th>
                                            <th>Vehicle Type</th>
                                            <th>Capacity</th>
                                            <th>Body</th>
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
                                                    @if($truck->body_type == 1)
                                                        <td>Level</td>
                                                    @elseif($truck->body_type == 2)
                                                        <td>Extendend Body</td>
                                                    @elseif($truck->body_type == 3)
                                                        <td>Extra Extendend Body</td>
                                                    @else
                                                        <td>Invalid!</td>
                                                    @endif
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
                                    @if(!empty($trucks))
                                        {{ $trucks->appends(Request::all())->links() }}
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