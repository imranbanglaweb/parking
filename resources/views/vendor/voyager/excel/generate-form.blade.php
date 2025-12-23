@extends('voyager::master')

@section('page_title', __('Excel Form Generator'))


@section('page_header')
    <h1 class="page-title">
        <i class="voyager-news"></i> {{ __('Excel Form Generator') }}
        &nbsp
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <!-- form start -->
                    <div class="row" id="section" style="margin-top: 20px;">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <a href="{{route('excel-form-download.department')}}" class="btn btn-primary">{{__('Department Form')}}</a>
                                            <a href="{{route('excel-form-download.designation')}}" class="btn btn-success">{{__('Designation Form')}}</a>
                                            <a href="{{route('excel-form-download.employee')}}" class="btn btn-info">{{__('Employee Form')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>

    </script>
@stop
