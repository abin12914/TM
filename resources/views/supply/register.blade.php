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

        @if (!empty($errors) && count($errors) > 0)
            <div class="alert alert-danger">
                <h4>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
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
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="supply_flag" value="true">
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
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                
                                                {{-- transportation form added --}}
                                                @include('forms.transportation')

                                            </div>
                                        </div>
                                        <div class="clearfix"> </div><br>
                                        <div class="row">
                                            <div class="box-footer">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <button type="button" class="btn btn-default" disabled>Prev</button>
                                                    <a href="#purchase_tab" data-toggle="tab" class="arrows">
                                                        <button type="button" class="btn btn-info pull-right">Next</button>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- /.box-footer -->
                                        </div>
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
                                        <div class="clearfix"> </div><br>
                                        <div class="row">
                                            <div class="box-footer">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <a href="#transportation_tab" data-toggle="tab" class="arrows">
                                                        <button type="button" class="btn btn-default">Prev</button>
                                                    </a>
                                                    <a href="#sale_tab" data-toggle="tab" class="arrows">
                                                        <button type="button" class="btn btn-info pull-right">Next</button>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- /.box-footer -->
                                        </div>
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
                                        <div class="clearfix"> </div><br>
                                        <div class="row">
                                            <div class="box-footer">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <a href="#purchase_tab" data-toggle="tab" class="arrows">
                                                        <button type="button" class="btn btn-default">Prev</button>
                                                    </a>
                                                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                                                </div>
                                            </div>
                                            <!-- /.box-footer -->
                                            <!-- /.col -->
                                        </div>
                                            <!-- /.col -->
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