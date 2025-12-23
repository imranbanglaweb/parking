@extends('voyager::master')

@section('page_title', __('Insert Data From Excel File'))


@section('page_header')
    <h1 class="page-title">
        <i class="voyager-news"></i> {{ __('Insert Data From Excel File') }}
        &nbsp
    </h1>
    @include('voyager::multilingual.language-selector')
@stop
@section('css')
    <style>
        .none {
            display: none;
        }
    </style>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row" id="section" style="margin-top: 20px;">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="form-group" style="margin-top: 15px">
                                        <label for="section_employee" style="padding: 10px; background: #007fbf; color: white; border-radius: 25px">
                                            <input type="radio" name='excel' value='employee' id="section_employee" data-id="employee" />
                                            {{__('Insert Employee')}}
                                        </label>
                                        <label for="section_designation" style="padding: 10px; background: #007fbf; color: white; border-radius: 25px">
                                            <input type="radio" name='excel' value='designation' id="section_designation" data-id="designation" />
                                            {{__('Insert Designation')}}
                                        </label>

                                        <label for="section_department" style="padding: 10px; background: #007fbf; color: white; border-radius: 25px">
                                            <input type="radio" name='excel' value='department' id="section_department" data-id="department" />
                                            {{__('Insert Department')}}
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body none" id="employee" style="margin-top: 10px;">
                                    <h3>{{__('Insert Employee')}}</h3>
                                    <form action="{{route('excel-form-insert-employee.upload')}}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <br>
                                                    <label for="employee_excel">{{__('Select Excel File')}}</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="file" class="" name="employee_excel" id="employee_excel" accept=".xlsx">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-success">{{__('Submit')}}</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="panel-body none" id="designation" style="margin-top: 10px;">
                                    <h3>{{__('Insert Designation')}}</h3>
                                    <form action="{{route('excel-form-insert-designation.upload')}}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <br>
                                                    <label for="employee_excel">{{__('Select Excel File')}}</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="file" class="" name="designation_excel" id="designation_excel" accept=".xlsx">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-success">{{__('Submit')}}</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="panel-body none" id="department" style="margin-top: 10px;">
                                    <h3>{{__('Insert Department')}}</h3>
                                    <form action="{{route('excel-form-insert-department.upload')}}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <br>
                                                    <label for="employee_excel">{{__('Select Excel File')}}</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="file" class="" name="department_excel" id="department_excel" accept=".xlsx">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-success">{{__('Submit')}}</button>
                                        </div>
                                    </form>
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
        $(':radio').change(function (event) {
            var id = $(this).data('id');
            $('#' + id).removeClass('none').siblings().addClass('none');
        });

        $(document).on("submit", "form", function(){
            $('#voyager-loader').show();
        });
    </script>
@stop
