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
          method="POST" enctype="multipart/form-data" autocomplete="off" id="car_number_edit_form">
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
                                    <label class="required"   for="name">{{ __('bread.car-numbers.veicle_number') }}</label>
                                    <input type="text"  class="form-control name" id="vehicle_number" name="vehicle_number"
                                           value="{{$car_number->vehicle_number}}">
                                </div>
                            </div>
                           <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required" for="station_id">{{ __('bread.car-numbers.stations') }}</label>

                                    <select name="station_id" id="station_id" class="form-control select2">
                                        <option value="">--Select One--</option>
                                        @foreach($stations as $station)
                                            <option <?php if($station->id==$car_number->station_id){echo 'selected';}?>  value="{{ $station->id}}">
                                            {{ $station->name}}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                           <div class="col-md-6 project" >
                                 <div class="form-group">
                                    <label class="" for="tenant_id">{{ __('bread.car-numbers.tenants') }}</label>

                                    <select name="tenant_id" id="tenant_id" class="form-control select2">
                                        <option value="">--Select One--</option>

                                    </select>

                                </div>

                            </div>

                             <div class="col-md-6" >
                                <div class="form-group">
                                    <label class="required" for="status">{{ __('bread.car-numbers.status') }}</label>

                                    <select name="status" id="status" class="form-control" name="status">
                                        <option <?php if($car_number->status==1){echo'selected';}?> value="1">Active</option>
                                        <option <?php if($car_number->status==0){echo'selected';}?> value="0">Inactive</option>

                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label  for="description">{{ __('bread.items.description') }}</label>
                                    <textarea name="description" id="description" cols="10" rows="5" class="form-control"
                                              >{{$item->description}}</textarea>

                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="row">
                            <input type="hidden" name="locale" value="bn" id="locale">
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <!--user permission end here-->
                                    <button type="submit" class="btn btn-primary save">
                                        <i class="fa fa-plus"></i>
                                        {{ __('voyager::generic.update') }}
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
    var product_category_id = $("#product_category_id").val();
    var item_sub_category = "<?php echo $item->sub_category_id?>";
        $.ajax({
                url: "{{route('sub-categories.sub-categories')}}",
                type: "POST",
                data: { 'product_category_id' : product_category_id,'item_sub_category':item_sub_category },
                success: function (data) {
                   $("#sub_category_id").html(data);
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
     $("#product_category_id").change(function(){
        var product_category_id = $("#product_category_id").val();
        $.ajax({
                url: "{{route('sub-categories.sub-categories')}}",
                type: "POST",
                data: { 'product_category_id' : product_category_id },
                success: function (data) {
                   $("#sub_category_id").html(data);
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
     //$.validator.addClassRules("item_name",{required: true});
     //$.validator.addClassRules("price",{required: true});
    $("#item_edit_form").validate({
        rules: {

                'product_category_id': {
                    required: true
                },
                'name': {
                    required: true
                },
            },
        submitHandler: function (form) {
            $('#voyager-loader').show();
            $.ajax({
                url: "{{route('items.update',['id' => $item->id])}}",
                type: "POST",
                data: $('#item_edit_form').serialize(),
                success: function (data) {
                    console.log(data);
                    $('#item_edit_form').trigger("reset");
                    /* reseting form */
                    $('.alert-danger').hide();
                    $('#voyager-loader').hide();
                    toastr.success(data.success);
                    location.reload();
                },
                error: function (data) {
                    console.log(data);
                    $('#voyager-loader').hide();
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

