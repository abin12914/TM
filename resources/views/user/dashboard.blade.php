@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="/bower_components/fullcalendar/dist/fullcalendar.min.css">
@endsection
@section('content')
<style type="text/css">
#calendar td {
    text-align: center;
}
.fc-unthemed .fc-today {
  background-color: lightgoldenrodyellow;
  color: red;
}
</style>
<div class="content-wrapper no-print">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    @if (Session::has('message'))
        <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="alert-message">
            <h4>
                {!! Session::get('message') !!}
            </h4>
        </div>
    @endif
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ !empty($transportationCount) ? $transportationCount : '00' }}</h3>
                        <p>Registered Transportations</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-road"></i>
                    </div>
                    <a href="{{ route('transportations.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ !empty($truckCount) ? $truckCount : '00' }}</h3>
                        <p>Registered Trucks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-truck"></i>
                    </div>
                    <a href="{{ route('trucks.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ !empty($warnCertificateCount) ? $warnCertificateCount : '00' }}</h3>
                        <p>Certificates Expiring Soon</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-certificate"></i>
                    </div>
                    <a href="{{ route('trucks.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ !empty($expiredCertificateCount) ? $expiredCertificateCount : '00' }}</h3>
                        <p>Certificates Expired</p>
                    </div>
                    <div class="icon">
                        <i class="fa  fa-certificate"></i>
                    </div>
                    <a href="{{ route('trucks.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </div>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
<script src="/bower_components/moment/moment.js"></script>
<!-- fullCalendar 2.2.5-->
<script src="/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="/js/dashboard.js?rndstr={{ rand(1000,9999) }}"></script>
<script type="text/javascript">
    var loggedUser = '';
    var truckCertificates = [];
    @if(Session::has('loggedUser'))
        loggedUser = "{{ $currentUser->name }}";
    @endif
    @if(!empty($trucks) && $trucks->count() > 0 && $settings->track_certificate == 1)
        @foreach($trucks as $truck)
            var insuranceColor  = "{{ $truck->insuranceFlag == 1 ? "#00a65a" : ($truck->insuranceFlag == 2 ? '#f39c12' : '#f56954') }}";
            var taxColor        = "{{ $truck->taxFlag == 1 ? "#00a65a" : ($truck->taxFlag == 2 ? '#f39c12' : '#f56954') }}";
            var fitnessColor    = "{{ $truck->fitnessFlag == 1 ? "#00a65a" : ($truck->fitnessFlag == 2 ? '#f39c12' : '#f56954') }}";
            var permitColor     = "{{ $truck->permitFlag == 1 ? "#00a65a" : ($truck->permitFlag == 2 ? '#f39c12' : '#f56954') }}";

            truckCertificates.push({
                title           : '{{ $truck->reg_number }} - Insurance',
                start           : '{{ $truck->insurance_upto }}',
                allDay          : true,
                backgroundColor : insuranceColor,
                borderColor     : insuranceColor,
            }, {
                title           : '{{ $truck->reg_number }} - Tax',
                start           : '{{ $truck->tax_upto }}',
                allDay          : true,
                backgroundColor : taxColor,
                borderColor     : taxColor,
            }, {
                title           : '{{ $truck->reg_number }} - Fitness',
                start           : '{{ $truck->fitness_upto }}',
                allDay          : true,
                backgroundColor : fitnessColor,
                borderColor     : fitnessColor,
            }, {
                title           : '{{ $truck->reg_number }} - Permit',
                start           : '{{ $truck->permit_upto }}',
                allDay          : true,
                backgroundColor : permitColor,
                borderColor     : permitColor,
            });
        @endforeach
    @endif
</script>
@endsection