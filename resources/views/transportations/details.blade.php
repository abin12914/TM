@extends('layouts.app')
@section('title', 'Transportation Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Transportation
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Transportation Details</li>
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
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                        @if(!empty($transportation))
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="/images/trucks/truck-transportation.png" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ $transportation->truck->reg_number }}</h3>
                                <h5 class="widget-user-desc">{{ $transportation->transaction->debitAccount->account_name }}</h5>
                            </div>
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-tag margin-r-5"></i> Reference Number
                                        </strong>
                                        <p class="text-muted">
                                            #{{ $transportation->transaction->id }}/{{ $transportation->id }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-truck margin-r-5"></i> Truck Number
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->truck->reg_number }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-book margin-r-5"></i> Contractor
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->transaction->debitAccount->account_name }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-calendar margin-r-5"></i> Date
                                        </strong>
                                        <p class="text-muted">
                                            {{ Carbon\Carbon::parse($transportation->date)->format('d-m-Y') }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-map-marker margin-r-5"></i> Source
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->source->name }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-map-marker margin-r-5"></i> Destination
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->destination->name }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-barcode margin-r-5"></i> Material
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->material->name }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-tag margin-r-5"></i> Rent Type
                                        </strong>
                                        <p class="text-muted">
                                            @if(!empty($rentTypes))
                                                @if(!empty($rentTypes[$transportation->rent_type]))
                                                    {{ $rentTypes[$transportation->rent_type] }}
                                                @else
                                                    <div class="text-red">Error!</div>
                                                @endif
                                            @else
                                                <div class="text-red">Error</div>
                                            @endif
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-balance-scale margin-r-5"></i> Measurement
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->measurement }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-dollar margin-r-5"></i> Rent Rate
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->rent_rate }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-dollar margin-r-5"></i> Total Rent
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->total_rent }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-user margin-r-5"></i> Driver & Wage
                                        </strong>
                                        <p class="text-muted">
                                            {{ $transportation->employee->account->account_name }} - {{ $transportation->driver_wage }}
                                        </p>
                                        <hr>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="clearfix"> </div>
                                    <div class="row">
                                        <div class="col-xs-4"></div>
                                        <div class="col-xs-4">
                                            <div class="col-md-6">
                                                <form action="{{ route('transportations.edit', $transportation->id) }}" method="get" class="form-horizontal">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                <form action="{{ route('transportations.destroy', $transportation->id) }}" method="post" class="form-horizontal">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="button" class="btn btn-danger btn-block btn-flat delete_button">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        @endif
                    </div>
                    <!-- /.widget-user -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection