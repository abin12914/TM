@extends('layouts.app')
@section('title', 'Employee Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Employee
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Employee Details</li>
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
                        @if(!empty($employee))
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="{{ $employee->account->image or "/images/accounts/default_account.png" }}" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ $employee->account->name }}</h3>
                                <h5 class="widget-user-desc">Employee</h5>
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li>
                                        <a href="#">Name 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $employee->account->name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Account Name
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">{{ $employee->account->account_name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Address
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">
                                                    {{ $employee->account->address or "-" }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Phone
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $employee->account->phone or "-" }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Wage Type 
                                            <div style="width: 30%;" class="pull-right">
                                                @if(!empty($wageTypes) && !empty($wageTypes[$employee->wage_type]))
                                                    <div class="external-event bg-blue text-center">
                                                        {{ $wageTypes[$employee->wage_type] }}
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
                                        <a href="#">Wage / Monthly Salary / Trip Bata
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $employee->wage }} {{ $employee->wage_type == 3 ? "%" : "" }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget-user-header no-print">
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-3">
                                        <form action="{{ route('under.construction') }}" method="get" class="form-horizontal">
                                            {{-- route('trucks.edit', ['id' => $employee->id]) --}}
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                        </form>
                                    </div>
                                    <div class="col-xs-3">
                                        <form action="{{route('employees.destroy', ['id' => $employee->id])}}" method="post" class="form-horizontal">
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