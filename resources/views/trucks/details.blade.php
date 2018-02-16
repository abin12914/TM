@extends('layouts.app')
@section('title', 'Truck Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Truck
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Truck Details</li>
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
                        @if(!empty($truck))
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="/images/trucks/truck.gif" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ $truck->reg_number }}</h3>
                                <h5 class="widget-user-desc">{{ $truck->truckType->name }}</h5>
                            </div>
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-paperclip margin-r-5"></i> Reference Number
                                            </strong>
                                            <p class="text-muted multi-line">
                                                #{{ $truck->id }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-truck margin-r-5"></i> Registration Number
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $truck->reg_number }}
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-bus margin-r-5"></i> Truck Class
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $truck->truckType->name }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-file-text-o margin-r-5"></i> Description
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $truck->description or "-" }}
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-balance-scale margin-r-5"></i> Volume
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $truck->volume }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-puzzle-piece margin-r-5"></i> Body Type
                                            </strong>
                                            <p class="text-muted multi-line">
                                                @if(!empty($bodyTypes) && !empty($bodyTypes[$truck->body_type]))
                                                    {{ $bodyTypes[$truck->body_type] }}
                                                @else
                                                    <div class="text-red">
                                                        Error!
                                                    </div>
                                                @endif
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-calendar margin-r-5"></i> Insurance Certificate Valid Upto
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ Carbon\Carbon::parse($truck->insurance_upto)->format('d-m-Y') }}&emsp;
                                                @if($truck->insuranceFlag == 1)
                                                    <i class="fa fa-check text-green" title="Valid"> Valid</i>
                                                @elseif($truck->insuranceFlag == 2)
                                                    <i class="fa fa-warning text-orange" title="Expiring Soon.."> Expiring Soon..</i>
                                                @else
                                                    <i class="fa fa-times text-red" title="Expired.."> Expired</i>
                                                @endif
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-calendar margin-r-5"></i> Tax Certificate Valid Upto
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ Carbon\Carbon::parse($truck->tax_upto)->format('d-m-Y') }}&emsp;
                                                @if($truck->taxFlag == 1)
                                                    <i class="fa fa-check text-green" title="Valid"> Valid</i>
                                                @elseif($truck->taxFlag == 2)
                                                    <i class="fa fa-warning text-orange" title="Expiring Soon.."> Expiring Soon..</i>
                                                @else
                                                    <i class="fa fa-times text-red" title="Expired.."> Expired</i>
                                                @endif
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-calendar margin-r-5"></i> Fitness Certificate Valid Upto
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ Carbon\Carbon::parse($truck->fitness_upto)->format('d-m-Y') }}&emsp;
                                                @if($truck->fitnessFlag == 1)
                                                    <i class="fa fa-check-circle text-green" title="Valid"> Valid</i>
                                                @elseif($truck->fitnessFlag == 2)
                                                    <i class="fa fa-warning text-orange" title="Expiring Soon.."> Expiring Soon..</i>
                                                @else
                                                    <i class="fa fa-times text-red" title="Expired.."> Expired</i>
                                                @endif
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-calendar margin-r-5"></i> Permit Certificate Valid Upto
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ Carbon\Carbon::parse($truck->permit_upto)->format('d-m-Y') }}&emsp;
                                                @if($truck->permitFlag == 1)
                                                    <i class="fa fa-check-circle text-green" title="Valid"> Valid</i>
                                                @elseif($truck->permitFlag == 2)
                                                    <i class="fa fa-warning text-orange" title="Expiring Soon.."> Expiring Soon..</i>
                                                @else
                                                    <i class="fa fa-times text-red" title="Expired.."> Expired</i>
                                                @endif
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="clearfix"> </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="col-md-{{ (!$currentUser->isSuperAdmin()) ? "12" : "6" }}">
                                                <form action="{{ route('trucks.edit', $truck->id) }}" method="get" class="form-horizontal">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                                </form>
                                            </div>
                                            @if($currentUser->isSuperAdmin())
                                                <div class="col-md-6">
                                                    <form action="{{ route('trucks.destroy', $truck->id) }}" method="post" class="form-horizontal">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="button" class="btn btn-danger btn-block btn-flat delete_button">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
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