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
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-user-o margin-r-5"></i> Name
                                        </strong>
                                        <p class="text-muted">
                                            {{ $employee->account->name }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-book margin-r-5"></i> Account Name
                                        </strong>
                                        <p class="text-muted">
                                            {{ $employee->account->account_name }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-phone margin-r-5"></i> Phone
                                        </strong>
                                        <p class="text-muted">
                                            {{ $employee->account->phone or "-" }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-map-marker margin-r-5"></i> Address
                                        </strong>
                                        <p class="text-muted">
                                            {{ $employee->account->address or "-" }}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-tags margin-r-5"></i> Wage Type
                                        </strong>
                                        <p class="text-muted">
                                            @if(!empty($wageTypes) && !empty($wageTypes[$employee->wage_type]))
                                                {{ $wageTypes[$employee->wage_type] }}
                                            @else
                                                <div class="text-red">
                                                    Error!
                                                </div>
                                            @endif
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>
                                            <i class="fa fa-dollar margin-r-5"></i> {{ !empty($wageTypes) && !empty($wageTypes[$employee->wage_type]) ? $wageTypes[$employee->wage_type] : "Wage / Monthly Salary / Trip Bata" }}
                                        </strong>
                                        <p class="text-muted">
                                            {{ $employee->wage }} {{ $employee->wage_type == 3 ? "%" : "" }}
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
                                            <div class="col-md-{{ (!$currentUser->isSuperAdmin()) ? "12" : "6" }}">
                                                <form action="{{ route('employees.edit', $employee->id) }}" method="get" class="form-horizontal">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                                </form>
                                            </div>
                                            @if($currentUser->isSuperAdmin())
                                                <div class="col-md-6">
                                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="post" class="form-horizontal">
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