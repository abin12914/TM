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
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-edit margin-r-5"></i> Site Name
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $site->name }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-map-marker margin-r-5"></i> Place
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $site->place }}
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-info-circle margin-r-5"></i> Address
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $site->address or "-" }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-tags margin-r-5"></i> Site Type
                                            </strong>
                                            <p class="text-muted multi-line">
                                                @if(!empty($siteTypes))
                                                    @if(!empty($siteTypes[$site->site_type]))
                                                        {{ $siteTypes[$site->site_type] }}
                                                    @else
                                                        <div class="text-red">Error!</div>
                                                    @endif
                                                @else
                                                    <div class="text-red">Error</div>
                                                @endif
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="clearfix"> </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="col-md-{{ (!$currentUser->isSuperAdmin()) ? "12" : "6" }}">
                                                <form action="{{ route('sites.edit', $site->id) }}" method="get" class="form-horizontal">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Edit</button>
                                                </form>
                                            </div>
                                            @if($currentUser->isSuperAdmin())
                                                <div class="col-md-6">
                                                    <form action="{{ route('sites.destroy', $site->id) }}" method="post" class="form-horizontal">
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