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
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li>
                                        <a href="#">Truck Number 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $transportation->truck->reg_number }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Contractor 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $transportation->transaction->debitAccount->account_name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Date
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">
                                                    {{ Carbon\Carbon::parse($transportation->date)->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Source 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $transportation->source->name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Destination 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">
                                                    {{ $transportation->destination->name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Material 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $transportation->material->name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">RentType 
                                            <div style="width: 30%;" class="pull-right">
                                                @if(!empty($rentTypes))
                                                    @if(!empty($rentTypes[$transportation->rent_type]))
                                                        <div class="external-event bg-blue text-center">
                                                            {{ $rentTypes[$transportation->rent_type] }}
                                                        </div>
                                                    @else
                                                        <div class="external-event bg-red text-center">Error!</div>
                                                    @endif
                                                @else
                                                    <div class="external-event bg-red text-center">Error</div>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Measurement 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $transportation->measurement }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Rent Rate 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">
                                                    {{ $transportation->rent_rate }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Total Rent 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $transportation->total_rent }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Driver 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">
                                                    {{ $transportation->employee->account->account_name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Driver Wage 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $transportation->driver_wage }}
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
                                            {{-- route('accounts.edit', ['id' => $account->id]) --}}
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                        </form>
                                    </div>
                                    <div class="col-xs-3">
                                        <form action="{{route('transportations.destroy', ['id' => $transportation->id])}}" method="post" class="form-horizontal">
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