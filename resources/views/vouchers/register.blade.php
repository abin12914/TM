@extends('layouts.app')
@section('title', 'Vouchers & Reciepts Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Vouchers & Reciepts
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vouchers & Reciepts Registration</li>
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
        <div class="row no-print">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#transaction_debit" data-toggle="tab">Debit / <b>Reciept</b></a></li>
                            <li class=""><a href="#transaction_credit" data-toggle="tab">Credit / <b>Voucher</b></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="transaction_debit">
                                <!-- form start -->
                                <form action="{{route('vouchers.store')}}" method="post" class="form-horizontal">
                                    <div class="box-body">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="hidden" name="transaction_type" value="1">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title" style="float: left;">Cash Reciept Registration</h3>
                                                    <p>&nbsp&nbsp&nbsp(Cash recieved from the selected account)</p>
                                                </div><br><br>
                                                @include('forms.voucher-reciept')
                                            </div>
                                        </div><br>
                                        <div class="clearfix"> </div><br>
                                        <div class="row">
                                            <div class="col-xs-3"></div>
                                            <div class="col-xs-3">
                                                <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="11">Clear</button>
                                            </div>
                                            <div class="col-xs-3">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="10">Submit</button>
                                            </div>
                                            <!-- /.col -->
                                        </div><br>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="transaction_credit">
                                <!-- form start -->
                                <form action="{{route('vouchers.store')}}" method="post" class="form-horizontal">
                                    <div class="box-body">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="hidden" name="transaction_type" value="2">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title" style="float: left;">Cash Payment Registration</h3>
                                                    <p>&nbsp&nbsp&nbsp(Cash paid to the selected account.)</p>
                                                </div><br><br>
                                                @include('forms.voucher-reciept')
                                            </div>
                                        </div><br>
                                        <div class="clearfix"> </div><br>
                                        <div class="row">
                                            <div class="col-xs-3"></div>
                                            <div class="col-xs-3">
                                                <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="11">Clear</button>
                                            </div>
                                            <div class="col-xs-3">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="10">Submit</button>
                                            </div>
                                            <!-- /.col -->
                                        </div><br>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
    <script src="/js/registrations/voucherRecieptRegistration.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection