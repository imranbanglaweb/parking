@php

$title = __('Edit Vehicle Number');
@endphp
@extends('voyager::master')

@section('page_title', $title)

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .error {
        color: red;
    }

    .form-group label.required::after {
        color: red;
        content: "*";
        left: 5px;
        position: relative;
    }

    [class*="col-"] {
        margin-bottom: 0px !important;
    }

::-webkit-input-placeholder { /* Edge */
  color: red;
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: red;
}

::placeholder {
  color: red;
}
</style>
@stop

@section('page_header')
<h1 class="page-title">
    {{ $title }}

    @can('browse', app(\App\Models\CarNumber::class))
    <a href="{{ route('voyager.car-numbers.index') }}" class="btn btn-warning">
        <span class="glyphicon glyphicon-list"></span>&nbsp;
        {{ __('voyager::generic.return_to_list') }}
    </a>
    @endcan
</h1>
@stop

@section('content')
<div class="page-content container-fluid">
    <form class="form-edit-add" role="form"
          action="#"
          method="POST" enctype="multipart/form-data" autocomplete="off" id="car_number_add_form">
        <!-- PUT Method if we are editing -->

        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    {{-- <div class="panel"> --}}
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="panel-body">
                        <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required" for="statios">{{ __('bread.car-numbers.stations') }}</label>

                                    <select name="station_id" id="station_id" class="form-control select2">
                                     <option value="">--Select One--</option>
                                      @foreach($stations as $station)
                                        <option @if($station->id==$car_number->station_id)selected @endif value="{{ $station->id}}">
                                            {{ $station->name}}
                                        </option>
                                       @endforeach
                                    </select>

                                </div>
                            </div>
                           <div class="col-md-6 project" >
                                 <div class="form-group">
                                    <label class="required" for="tenent_id">{{ __('bread.car-numbers.tenants') }}</label>

                                    <select name="tenant_id" id="tenant_id" class="form-control select2">
                                        <option value="">--Select One--</option>

                                    </select>

                                </div>

                            </div>
                             <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required" for="vehicle_type_id">{{ __('bread.car-numbers.vehicle_type') }}</label>

                                    <select name="vehicle_type_id" id="vehicle_type_id" class="form-control select2">
                                     <option value="">--Select One--</option>
                                         @foreach($vehicle_types as $vehicle_type)
                                        <option @if($car_number->vehicle_type_id==$vehicle_type->id) selected @endif value="{{ $vehicle_type->id}}">
                                            {{ $vehicle_type->name}}
                                        </option>
                                       @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required" for="area_id">{{ __('bread.car-numbers.areas') }}</label>

                                    <select name="area_id" id="area_id" class="form-control select2">
                                     <option value="">--Select One--</option>
                                      @foreach($areas as $area)
                                        <option @if($car_number->area_id==$area->id) selected @endif value="{{ $area->id}}">
                                            {{ $area->name}}
                                        </option>
                                       @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required" for="code_id">{{ __('bread.car-numbers.codes') }}</label>

                                    <select name="code_id" id="code_id" class="form-control select2">
                                     <option value="">--Select One--</option>
                                      @foreach($codes as $code)
                                        <option @if($car_number->code_id==$code->id) selected @endif value="{{ $code->id}}">
                                            {{ $code->name}}
                                        </option>
                                       @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required"   for="vehicle_number">{{ __('bread.car-numbers.vehicle_number') }}</label>
                                    <input type="text"  class="form-control name" id="vehicle_number" name="vehicle_number"
                                           value="{{$car_number->vehicle_number}}">
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required"   for="mobile_number">{{ __('bread.car-numbers.mobile_number') }}</label>
                                    <input type="text"  class="form-control name" id="mobile_number" name="mobile_number"
                                           value="{{$car_number->mobile_number}}">
                                </div>
                            </div>
                           <div class="col-md-6" >
                                <div class="form-group">
                                    <label   for="parking_number">{{ __('bread.car-numbers.parking_number') }}</label>
                                    <input type="text"  class="form-control name" id="parking_number" name="parking_number"
                                           value="{{$car_number->parking_number}}">
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="row">
                            <input type="hidden" name="locale" value="bn" id="locale">
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <img class="saving" style="display:none" src="{{ asset('public/images/saving.gif')}}" alt="Saving" width="90" height="30" style=''>
                                    <!--user permission end here-->
                                    <button type="submit" class="btn btn-primary save">
                                        <i class="fa fa-plus"></i>
                                        {{ __('voyager::generic.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

</div>
</form>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('public/backend_resources/js/form.js') }}"></script>

@stop
<!-- frontend validation for bread -->
@section('validation')
<script src="{{ asset('/public/backend_resources/js/jquery_validation_combine.js') }}"></script>

@if(app()->getLocale() === 'bn')
<script src="{{ asset('/public/backend_resources/js/validation_localization_bn.js') }}"></script>
@endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

<script>
//jQuery.validator.addMethod("unique", function(value, element, params) {
//        var matches = new Array();
//        $(".mobile").each(function(index, item) {
//            if (value == $(item).val()) {
//                matches.push(item);
//            }
//        });
//        return matches.length == 1;
//    }, "Mobile Number must be unique");

jQuery.validator.addMethod("exactlength", function(value, element, param) {
 return this.optional(element) || value.length == param;
}, $.validator.format("Please enter exactly {0} characters."));

$('document').ready(function () {
     let station_id = <?php echo $car_number->station_id;?>;
     let tenant_id=<?php echo $car_number->tenant_id;?>;
     let vehicle_type_id=<?php echo $car_number->vehicle_type_id;?>;
        $.ajax({
                url: "{{route('stations.tenants')}}",
                type: "POST",
                data: { 'station_id' : station_id,'tenant_id':tenant_id },
                success: function (data) {
                   $("#tenant_id").html(data);
                },
                error: function (data) {
                    $.each(data.responseJSON.errors, function (key, value) {
                        $('.alert-danger').html('');
                        $('.alert-danger').append('<p>' + value + '</p>');
                        $('.alert-danger').show();
                    });
                    setTimeout(() => {
                        $('.alert-danger').fadeOut(1000);
                    }, 5000);
                }
            });
//      $.ajax({
//                url: "{{route('stations.vehicle_type')}}",
//                type: "POST",
//                data: { 'station_id' : station_id,'vehicle_type_id':vehicle_type_id },
//                success: function (data) {
//                   $("#vehicle_type_id").html(data);
//                },
//                error: function (data) {
//                    $.each(data.responseJSON.errors, function (key, value) {
//                        $('.alert-danger').html('');
//                        $('.alert-danger').append('<p>' + value + '</p>');
//                        $('.alert-danger').show();
//                    });
//                    setTimeout(() => {
//                        $('.alert-danger').fadeOut(1000);
//                    }, 5000);
//                }
//            });

     $("#station_id").change(function(){
        var station_id = $("#station_id").val();
        $.ajax({
                url: "{{route('stations.tenants')}}",
                type: "POST",
                data: { 'station_id' : station_id },
                success: function (data) {
                   $("#tenant_id").html(data);
                },
                error: function (data) {
                    $.each(data.responseJSON.errors, function (key, value) {
                        $('.alert-danger').html('');
                        $('.alert-danger').append('<p>' + value + '</p>');
                        $('.alert-danger').show();
                    });
                    setTimeout(() => {
                        $('.alert-danger').fadeOut(1000);
                    }, 5000);
                }
            });

    });
//    $("#station_id").change(function(){
//        var station_id = $("#station_id").val();
//        $.ajax({
//                url: "{{route('stations.vehicle_type')}}",
//                type: "POST",
//                data: { 'station_id' : station_id },
//                success: function (data) {
//                   $("#vehicle_type_id").html(data);
//                },
//                error: function (data) {
//                    $.each(data.responseJSON.errors, function (key, value) {
//                        $('.alert-danger').html('');
//                        $('.alert-danger').append('<p>' + value + '</p>');
//                        $('.alert-danger').show();
//                    });
//                    setTimeout(() => {
//                        $('.alert-danger').fadeOut(1000);
//                    }, 5000);
//                }
//            });
//
//    });
     //$.validator.addClassRules("item_name",{required: true});
     //$.validator.addClassRules("price",{required: true});
    $("#car_number_add_form").validate({
        rules: {

                'station_id': {
                    required: true
                },
                'tenant_id': {
                    required: true
                },
                'area_id': {
                    required: true
                },
                'code_id': {
                    required: true
                },
                'vehicle_number': {
                    required: true
                },

                'vehicle_type_id': {
                    required: true
                },
            },
        submitHandler: function (form) {
            $('#voyager-loader').show();
            $('.saving').show();
            $('.save').hide();
            $.ajax({
                url: "{{route('car-numbers.store')}}",
                type: "POST",
                data: $('#car_number_add_form').serialize(),
                success: function (data) {
                    console.log(data);
                    $('#car_number_add_form').trigger("reset");
                    /* reseting form */
                    $('.alert-danger').hide();
                    $('#voyager-loader').hide();
                    $('.saving').hide();
                    $('.save').show();
                    toastr.success(data.success);
                    location.reload();
                },
                error: function (data) {
                    console.log(data);
                    $('#voyager-loader').hide();
                    $('.saving').hide();
                    $('.save').show();
                    $.each(data.responseJSON.errors, function (key, value) {
                        $('.alert-danger').html('');
                        $('.alert-danger').append('<p>' + value + '</p>');
                        $('.alert-danger').show();
                    });
                    setTimeout(() => {
                        $('.alert-danger').fadeOut(1000);
                    }, 5000);
                }
            });
        }
    });
});

</script>

@stop

