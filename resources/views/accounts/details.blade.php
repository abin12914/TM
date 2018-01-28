@extends('layouts.app')
@section('title', 'Account Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Account
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Account Details</li>
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
                        @if(!empty($account))
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="{{ $account->accountDetail->image or "/images/accounts/default_account.png" }}" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ $account->account_name }}</h3>
                                @if(!empty($relationTypes))
                                    <h5 class="widget-user-desc">
                                        {{ !empty($relationTypes[$account->relation]) ? $relationTypes[$account->relation] : "Error!" }}
                                    </h5>
                                @else
                                    <h5 class="widget-user-desc">Error</h5>
                                @endif
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li>
                                        <a href="#">Account Name 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $account->account_name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Name 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">{{ $account->accountDetail->name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Phone
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $account->accountDetail->phone }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Address 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">{{ $account->accountDetail->address }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Relation 
                                            <div style="width: 30%;" class="pull-right">
                                                @if(!empty($relationTypes))
                                                    @if(!empty($relationTypes[$account->relation]))
                                                        <div class="external-event bg-blue text-center">
                                                            {{ $relationTypes[$account->relation] }}
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
                                        <a href="#">Type 
                                            <div style="width: 30%;" class="pull-right">
                                                @if(!empty($accountTypes))
                                                    @if(!empty($accountTypes[$account->type]))
                                                        <div class="external-event bg-aqua text-center">{{ $accountTypes[$account->type] }}</div>
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
                                        <a href="#">Financial Status On Account Registration 
                                            <div style="width: 30%;" class="pull-right">
                                                @if($account->financial_status == 0)
                                                    <div class="external-event bg-blue text-center">
                                                        None
                                                    </div>
                                                @elseif($account->financial_status == 1)
                                                    <div class="external-event bg-blue text-center">
                                                        Creditor (Company owe to the account holder)
                                                    </div>
                                                @else
                                                    <div class="external-event bg-blue text-center">
                                                        Debitor (Account holder owe to the company)
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Opening Balance 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">
                                                    {{ $account->opening_balance }}
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
                                        <form action="{{route('accounts.destroy', ['id' => $account->id])}}" method="post" class="form-horizontal">
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