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
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li>
                                        <a href="#">Registration Number 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $truck->reg_number }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Class Of Truck 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">{{ $truck->truckType->name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Descriptiion 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $truck->description }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Volume 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">{{ $truck->volume }} cft</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Body Type 
                                            <div style="width: 200px;" class="pull-right">
                                                @if(!empty($bodyTypes) && !empty($bodyTypes[$truck->body_type]))
                                                    <div class="external-event bg-blue text-center">
                                                        {{ $bodyTypes[$truck->body_type] }}
                                                    </div>
                                                @else
                                                    <div class="external-event bg-red text-center">
                                                        Error!
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Insurance Certificate Valid Upto 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-{{ !empty($insuranceFlag) ? $insuranceFlag : 'orange' }} text-center">
                                                    {{ Carbon\Carbon::parse($truck->insurance_upto)->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Tax Certificate Valid Upto 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-{{ !empty($taxFlag) ? $taxFlag : 'orange' }} text-center">
                                                    {{ Carbon\Carbon::parse($truck->tax_upto)->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Fitness Certificate Valid Upto 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-{{ !empty($fitnessFlag) ? $fitnessFlag : 'orange' }} text-center">
                                                    {{ Carbon\Carbon::parse($truck->fitness_upto)->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Permit Valid Upto 
                                            <div style="width: 200px;" class="pull-right">
                                                <div class="external-event bg-{{ !empty($permitFlag) ? $permitFlag : 'orange' }} text-center">
                                                    {{ Carbon\Carbon::parse($truck->permit_upto)->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget-user-header">
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-3">
                                        <form action="{{ route('under.construction') }}" method="get" class="form-horizontal">
                                            {{-- route('trucks.edit', ['id' => $truck->id]) --}}
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                        </form>
                                    </div>
                                    <div class="col-xs-3">
                                        <form action="{{route('trucks.destroy', ['id' => $truck->id])}}" method="post" class="form-horizontal">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-block btn-flat">Delete</button>
                                        </form>
                                    </div>
                                    <!-- /.col -->
                                </div><br>
                            </div>
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