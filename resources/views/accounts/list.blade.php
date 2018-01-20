@extends('layouts.app')
@section('title', 'Account List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Account
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Account List</li>
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
                                            <th>Account Name</th>
                                            <th>Type</th>
                                            <th>Relation</th>
                                            <th>Account Holder/Head</th>
                                            <th>Opening Credit</th>
                                            <th>Opening Debit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($accounts))
                                            @foreach($accounts as $index => $account)
                                                <tr>
                                                    <td>{{ $index + $accounts->firstItem() }}</td>
                                                    <td>{{ $account->account_name }}</td>
                                                    @if(!empty($accountTypes))
                                                        <td>{{ !empty($accountTypes[$account->type]) ? $accountTypes[$account->type] : "Error!" }}</td>
                                                    @else
                                                        <td>Error</td>
                                                    @endif
                                                    @if($account->relation == 0)
                                                        <td>Real/Nominal</td>
                                                    @elseif(!empty($relationTypes))
                                                        <td>
                                                            {{ !empty($relationTypes[$account->relation]) ? $relationTypes[$account->relation] : "Error!" }}
                                                        </td>
                                                    @else
                                                        <td>Error</td>
                                                    @endif
                                                    <td>{{ $account->accountDetail->name }}</td>
                                                    @if($account->financial_status == 1)
                                                        <td>{{ $account->opening_balance }}</td>
                                                        <td></td>
                                                    @elseif($account->financial_status == 2)
                                                        <td></td>
                                                        <td>{{ $account->opening_balance }}</td>
                                                    @else
                                                        <td>-</td>
                                                        <td>-</td>
                                                    @endif
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
                                    @if(!empty($accounts))
                                        {{ $accounts->appends(Request::all())->links() }}
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