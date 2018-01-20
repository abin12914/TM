@extends('layouts.app')
@section('title', 'Site List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Site
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('user-dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Site List</li>
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
                                            <th>Name</th>
                                            <th>Place</th>
                                            <th>Address</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($sites))
                                            @foreach($sites as $index => $site)
                                                <tr>
                                                    <td>{{ $index + $sites->firstItem() }}</td>
                                                    <td>{{ $site->name }}</td>
                                                    <td>{{ $site->place }}</td>
                                                    <td>{{ $site->address }}</td>
                                                    @if(!empty($siteTypes))
                                                        <td>{{ !empty($siteTypes[$site->site_type]) ? $siteTypes[$site->site_type] : "Error!" }}</td>
                                                    @else
                                                        <td>Error</td>
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
                                    @if(!empty($trucks))
                                        {{ $trucks->appends(Request::all())->links() }}
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