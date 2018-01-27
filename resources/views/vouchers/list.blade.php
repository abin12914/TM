@extends('layouts.app')
@section('title', 'Vouchers & Receipts List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Vouchers & Receipts
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vouchers & Receipts List</li>
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
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 15%;">Date</th>
                                            <th style="width: 15%;">Transaction Type</th>
                                            <th style="width: 25%;">Receiver</th>
                                            <th style="width: 25%;">Giver</th>
                                            <th style="width: 15%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($vouchers))
                                            @foreach($vouchers as $index => $vouher)
                                                <tr>
                                                    <td>{{ $index + $vouchers->firstItem() }}</td>
                                                    <td>{{ Carbon\Carbon::parse($vouher->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $vouher->transaction_type == 1 ? "Receipt" : "Voucher" }}</td>
                                                    <td>{{ $vouher->transaction->debitAccount->account_name }}</td>
                                                    <td>{{ $vouher->transaction->creditAccount->account_name }}</td>
                                                    <td>{{ $vouher->amount }}</td>
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
                                    @if(!empty($vouchers))
                                        {{ $vouchers->appends(Request::all())->links() }}
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