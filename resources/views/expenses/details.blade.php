@extends('layouts.app')
@section('title', 'Expense Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Expense
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Expense Details</li>
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
                        @if(!empty($expense))
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="/images/public/service.png" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ $expense->truck->reg_number }}</h3>
                                <h5 class="widget-user-desc">{{ $expense->service->name }}</h5>
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li>
                                        <a href="#">Truck Number 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $expense->truck->reg_number }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Supplier 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $expense->transaction->debitAccount->account_name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Date
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">
                                                    {{ Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Service 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $expense->service->name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Bill Amount 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">
                                                    {{ $expense->bill_amount }}
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
                                        <form action="{{route('expenses.destroy', ['id' => $expense->id])}}" method="post" class="form-horizontal">
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