@extends('layouts.app')
@section('title', 'Expense List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Expense
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Expense List</li>
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
                                            <th>Supplier</th>
                                            <th>Service</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($expenses))
                                            @foreach($expenses as $index => $expense)
                                                <tr>
                                                    <td>{{ $index + $expenses->firstItem() }}</td>
                                                    <td>{{ Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $expense->truck->reg_number }}</td>
                                                    <td>{{ $expense->transaction->creditAccount->account_name }}</td>
                                                    <td>{{ $expense->service->name }}</td>
                                                    <td>{{ $expense->bill_amount }}</td>
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
                                    @if(!empty($expenses))
                                        {{ $expenses->appends(Request::all())->links() }}
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