@extends('layouts.app')
@section('title', 'Supply Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Supply
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Supply Registration</li>
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
                    <!-- form start -->
                    <form action="{{route('supply.store')}}" method="post" class="form-horizontal">
                        <!-- nav-tabs-custom -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#transportation_tab" data-toggle="tab">Transportation Details</a></li>
                                <li class=""><a href="#purchase_tab" data-toggle="tab">Purchase Details</a></li>
                                <li class=""><a href="#sale_tab" data-toggle="tab">Sale Details</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="transportation_tab">
                                    <div class="box-body">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                
                                                {{-- transportation form added --}}
                                                @include('forms.transportation')

                                            </div>
                                        </div>
                                        <div class="clearfix"> </div><br><br>
                                        <div class="row">
                                            <div class="col-xs-4"></div>
                                            <div class="col-xs-4">
                                                <a href="#purchase_tab">
                                                    <button type="button" class="btn btn-primary btn-block">
                                                        Next
                                                    </button>
                                                </a>
                                            </div>
                                            <!-- /.col -->
                                        </div><br>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="purchase_tab">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                
                                                {{-- purchase form added --}}
                                                @include('forms.purchase')

                                            </div>
                                        </div>
                                        <div class="clearfix"> </div><br><br>
                                        <div class="row">
                                            <div class="col-xs-4"></div>
                                            <div class="col-xs-4">
                                                <a href="#sale_tab">
                                                    <button type="button" class="btn btn-primary btn-block">
                                                        Next
                                                    </button>
                                                </a>
                                            </div>
                                            <!-- /.col -->
                                        </div><br>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="sale_tab">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                
                                                {{-- purchase form added --}}
                                                @include('forms.sale')

                                            </div>
                                        </div>
                                        <div class="clearfix"> </div><br><br>
                                        <div class="row">
                                            <div class="row">
                                            <div class="col-xs-3"></div>
                                            <div class="col-xs-3">
                                                <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="12">Clear</button>
                                            </div>
                                            <div class="col-xs-3">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="11">Submit</button>
                                            </div>
                                            <!-- /.col -->
                                        </div><br>
                                            <!-- /.col -->
                                        </div><br>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /. nav-tabs-custom -->
                    </form>
                    <!-- /. form -->
                </div>
                <!-- /.col-md-8 -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
    <script src="/js/registrations/transportationRegistration.js?rndstr={{ rand(1000,9999) }}"></script>
    <script src="/js/registrations/supplyRegistration.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection