@extends('layouts.app')
@section('title', 'Site Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Site
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Site Details</li>
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
                        @if(!empty($site))
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="/images/public/location.png" alt="Location Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ $site->name }}</h3>
                                <h5 class="widget-user-desc">{{ $site->place }}</h5>
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li>
                                        <a href="#">Site Name 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $site->name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Place 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-aqua text-center">{{ $site->place }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Address 
                                            <div style="width: 30%;" class="pull-right">
                                                <div class="external-event bg-blue text-center">{{ $site->address or "-" }}</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Site Type 
                                            <div style="width: 30%;" class="pull-right">
                                                @if(!empty($siteTypes))
                                                    @if(!empty($siteTypes[$site->site_type]))
                                                        <div class="external-event bg-aqua text-center">
                                                            {{ $siteTypes[$site->site_type] }}
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
                                </ul>
                            </div>
                            <div class="widget-user-header">
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-3">
                                        <form action="{{ route('under.construction') }}" method="get" class="form-horizontal">
                                            {{-- route('sites.edit', ['id' => $site->id]) --}}
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                        </form>
                                    </div>
                                    <div class="col-xs-3">
                                        <form action="{{route('sites.destroy', ['id' => $site->id])}}" method="post" class="form-horizontal">
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