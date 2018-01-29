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
            <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Filter List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-header">
                        <form action="{{ route('sites.index') }}" method="get" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-4 {{ !empty($errors->first('site_type')) ? 'has-error' : '' }}">
                                            <label for="site_type" class="control-label">Site Type : </label>
                                            <select class="form-control select2" name="site_type" id="site_type" style="width: 100%">
                                                <option value="">Select site type</option>
                                                @if(!empty($siteTypes) && (count($siteTypes) > 0))
                                                    @foreach($siteTypes as $key => $siteType)
                                                        <option value="{{ $key }}" {{ (old('site_type') == $key || $params['site_type'] == $key) ? 'selected' : '' }}>{{ $siteType }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('site_type')))
                                                <p style="color: red;" >{{$errors->first('site_type')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('site_id')) ? 'has-error' : '' }}">
                                            <label for="site_id" class="control-label">Account : </label>
                                            <select class="form-control select2" name="site_id" id="site_id" style="width: 100%">
                                                <option value="">Select site</option>
                                                @if(!empty($sitesCombo) && (count($sitesCombo) > 0))
                                                    @foreach($sitesCombo as $site)
                                                        <option value="{{ $site->id }}" {{ (old('site_id') == $site->id || $params['id'] == $site->id) ? 'selected' : '' }}>{{ $site->name. " - ". $site->place }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('site_id')))
                                                <p style="color: red;" >{{$errors->first('site_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 {{ !empty($errors->first('no_of_records')) ? 'has-error' : '' }}">
                                            <label for="no_of_records" class="control-label">No Of Records Per Page : </label>
                                            <input type="text" class="form-control" name="no_of_records" id="no_of_records" value="{{ !empty(old('no_of_records')) ? old('no_of_records') : $noOfRecords }}">
                                            @if(!empty($errors->first('no_of_records')))
                                                <p style="color: red;" >{{$errors->first('no_of_records')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div><br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                    <button type="reset" class="btn btn-default btn-block btn-flat"  value="reset" tabindex="10">Clear</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="4"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </form>
                        <!-- /.form end -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    {{-- page header for printers --}}
                    @include('sections.print-head')
                    <div class="box-header no-print">
                        @if(!empty($params['site_type']) || !empty($params['id']))
                            <b>Filters applied!</b>
                        @endif
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 20%;">Place</th>
                                            <th style="width: 20%;">Address</th>
                                            <th style="width: 20%;">Type</th>
                                            <th style="width: 15%;" class="no-print">Details</th>
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
                                                    <td class="no-print">
                                                        <a href="{{ route('sites.show', ['id' => $site->id]) }}">
                                                            <button type="button" class="btn btn-default">Details</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if(!empty($sites))
                                    <div>
                                        Showing {{ $sites->firstItem(). " - ". $sites->lastItem(). " of ". $sites->total() }}
                                    </div>
                                    <div class=" no-print pull-right">
                                        {{ $sites->appends(Request::all())->links() }}
                                    </div>
                                @endif
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