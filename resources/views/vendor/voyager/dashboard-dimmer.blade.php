@php
$logo='';
if(isset($station_data->logo)){
        $logo='url(public/storage/'.$station_data->logo.')';
        $logo = str_replace('\\', '/', $logo);
}
$title = __('Dashboard');
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

    .registration_form_option {

        background-image: url("public/images/car.png");
        background-color: #cccccc;
        -moz-box-shadow: inset 0 0 5px #000000;
        -webkit-box-shadow: inset 0 0 5px #000000;
        box-shadow: inset 0 0 5px #000000;
        height:100px;
        width:100px;
        text-align:center;
        display:inline-block;
        vertical-align:top;
        font-size:1.5em;
        cursor:pointer;
        padding:1em;
        margin: 0px 20px 15px 20px;
        background-size:cover;


    }
    .registration_form_option_jeep{
        background-image: url("public/images/jeep.jpg");
        background-color: #cccccc;
        -moz-box-shadow: inset 0 0 5px #000000;
        -webkit-box-shadow: inset 0 0 5px #000000;
        box-shadow: inset 0 0 5px #000000;
        height:100px;
        width:100px;
        text-align:center;
        display:inline-block;
        vertical-align:top;
        font-size:1.5em;
        cursor:pointer;
        padding:1em;
        margin: 0px 20px 15px 20px;
        background-size:cover;
    }
    .registration_form_option3 {

        background-image: url("public/images/logo.jpg");
        background-color: #cccccc;
        -moz-box-shadow: inset 0 0 5px #000000;
        -webkit-box-shadow: inset 0 0 5px #000000;
        box-shadow: inset 0 0 5px #000000;
        height:100px;
        width:100px;
        text-align:center;
        display:inline-block;
        vertical-align:top;
        font-size:1.5em;
        cursor:pointer;
        padding:1em;
        margin: 0px 20px 15px 20px;
        background-size:cover;


    }
    .registration_form_option_bike{

        background-image: url("public/images/bike.jpg");
        background-color: #cccccc;
        -moz-box-shadow: inset 0 0 5px #000000;
        -webkit-box-shadow: inset 0 0 5px #000000;
        box-shadow: inset 0 0 5px #000000;
        height:100px;
        width:100px;
        text-align:center;
        display:inline-block;
        vertical-align:top;
        font-size:1.5em;
        cursor:pointer;
        padding:1em;
        margin: 0px 20px 15px 20px;
        background-size:cover;


    }
.logo-print{
       width:220px;
       margin-left:5%;
       margin-top:-5px;
       display: list-item;
       list-style-image: <?php echo $logo; ?>;
       list-style-position: inside;
       position: relative;
       display:inherit;
   }

    [type=radio]{
        display:none;
    }
    [type=radio]:checked + label{
        border:solid 2px red
    }

</style>
@stop



@section('content')
@can('add', app(\App\Models\DailyParking::class))
<div class="page-content container-fluid">

            <div class="centered logo-print" >

            </div>
        <div class="row">
            <div class="col-md-6">
                <form class="form-edit-add" role="form"
          action="#"
          method="POST" enctype="multipart/form-data" autocomplete="off" id="parking_form">
        <!-- PUT Method if we are editing -->

        {{ csrf_field() }}
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

                                <div class="col-md-12" >
                                    <div class="form-group" style="text-align:center">
                                        <input type="radio" class="v_type" id="reg_option_1" name="vehicle_type_id" value="1" />

                                        <label class="registration_form_option" for="reg_option_1">

                                        </label>

                                        <input type="radio" class="v_type" id="reg_option_3" name="vehicle_type_id" value="3" />

                                        <label class="registration_form_option_jeep" for="reg_option_3">

                                        </label>
                                        <input type="hidden" class="registration_form_option3" for="reg_option_3" />


                                        <input type="radio" class="v_type" id="reg_option_2" name="vehicle_type_id" value="2" />
                                        <label class="registration_form_option_bike" for="reg_option_2">

                                        </label>

                                    </div>
                                </div>
                                @if(Auth::user()->isAdmin())
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label class="required" for="station_id">{{ __('bread.daily-parkings.station') }}</label>
                                        <select class="form-control select2" id="station_id" name="station_id">
                                            <option value="" >{{ __('--Select one--') }}</option>
                                            @foreach($stations as $station)
                                            <option value="{{$station->id}}" >
                                                {{$station->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @else
                                <input class="form-control "id="station_id" type="hidden" name="station_id"
                                       value="{{Auth::user()->station_id}}">

                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required"  for="vehicle_number">{{ __('bread.daily-parkings.vehicle_number') }}</label>
                                        <input class="form-control "id="vehicle_number" type="text" name="vehicle_number"
                                               value="">
                                        <div id="carNumber"></div>
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label class="required" for="tenant_id">{{ __('bread.daily-parkings.customer') }}</label>
                                        <select class="form-control" id="tenant_id" name="tenant_id">
                                            <option value="" >{{ __('--Select one--') }}</option>

                                        </select>
                                    </div>
                                </div>


                                 <div class="col-md-6" >
                                    <div class="form-group">
                                        <label class="required" for="area_id">{{ __('bread.daily-parkings.areas') }}</label>
                                        <select class="form-control" id="area_id" name="area_id">
                                            <option value="" >{{ __('--Select one--') }}</option>
                                            @foreach($areas as $area)
                                            <option value="{{$area->id}}" >
                                                {{$area->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label class="required" for="code_id">{{ __('bread.daily-parkings.codes') }}</label>
                                        <select class="form-control" id="code_id" name="code_id">
                                            <option value="" >{{ __('--Select one--') }}</option>
                                            @foreach($codes as $code)
                                            <option value="{{$code->id}}" >
                                                {{$code->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label  for="mobile_number">{{ __('bread.daily-parkings.mobile_number') }}</label>
                                        <input class="form-control "id="mobile_number" type="text" name="mobile_number"
                                               value="">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                                    <input type="hidden" name="locale" value="bn" id="locale">
                                    <div class="col-md-12 text-center">
                                        <div class="form-group" id="submitting">
                                            <img class="saving" style="display:none"  alt="Saving" width="90" height="30" style=''>
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
            </form>
                <div class="col-md-6" style="margin-top:10px">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('bread.daily-parkings.tenants') }}</th>
                                    <th>{{ __('bread.daily-parkings.vehicle_number') }}</th>
                                    <th>{{ __('bread.daily-parkings.token_number') }}</th>
                                    <th>{{ __('bread.daily-parkings.clock_in') }}</th>
                                    <th class="text-center">{{__('voyager::generic.actions')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>


</div>

</div>
@endcan

<div class="modal modal-success fade" tabindex="-1" id="myModal" role="dialog">

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
<script type="text/javascript" src="{{ asset('public/backend_resources/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend_resources/js/bootstrap-datepicker.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="{{ asset('public/backend_resources/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
    $(document).on('click', '.out', function(){
        $.ajax({
                data: {
                    daily_parking_id: $(this).data("id"),
                },
                url: "{{route('daily-parkings.out-data')}}",
                //dataType: 'JSON',
                type: 'post',
                success: function (data) {
                    $("#myModal").html(data);
                    $("#myModal").modal('show');
                }
            });
        ;
    });


 $('#vehicle_number').keyup(function(){
        $('#mobile_number').val('');
        $('#area_id option:selected').removeAttr('selected');
        $('#code_id option:selected').removeAttr('selected');
        $('#tenant_id option:selected').removeAttr('selected');
        var query = $(this).val();
        var vehicle_type=$("input:radio.v_type:checked").val();
        //alert(vehicle_type);
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('daily-parkings.get_vehicle_number') }}",
          method:"POST",
          data:{query:query,vehicle_type:vehicle_type, _token:_token},
          success:function(data){
           //console.log(data)
           if(data!=null){
                $('#carNumber').fadeIn();
                $('#carNumber').html(data);
            }
          }
         });
        }
    });

    $(document).on('click', '.vehicle_details', function(){

        $('#vehicle_number').val($(this).text());
        $('#carNumber').fadeOut();
        $('#mobile_number').val($(this).data("mobile"));
        $("#area_id option[value='" + $(this).data("area") + "']").attr("selected","selected");
        $("#code_id option[value='" + $(this).data("code") + "']").attr("selected","selected");
        $("#tenant_id option[value='" + $(this).data("tenent") + "']").attr("selected","selected");
         $.ajax({
                data: {
                    vehicle_type_id: $('input[name="vehicle_type_id"]:checked').val(),
                    tenant_id: $(this).data("tenent"),
                },
                url: "{{route('daily-parkings.check-parking-limit')}}",
                //dataType: 'JSON',
                type: 'post',
                success: function (data) {

                    if(data==3){
                        if(confirm('Your Parking is full. You need to pay for this vehicle')) {
                            return true;
                        }

                        return true;
                    }else if(data==4){
                        alert('Please select vehicle type/Tenent');
                    }
                    else{
                        return true;
                    }
                }
            });
    });

});
</script>

<script>
        $(document).ready(function () {

             var station_id = $('#station_id').val();
            $.ajax({
                data: {
                    station_id: station_id,
                },
                url: "{{route('daily-parkings.station_wise_customer')}}",
                //dataType: 'JSON',
                type: 'post',
                success: function (data) {
                    console.log(data);
                    $('#tenant_id').html(data.html);
                }
            });


var dataTableParams = {!! json_encode(
        array_merge([
                "language" => __('voyager::datatable'),
                "processing" => true,
                "serverSide" => true,
                "ordering" => true,
                "searching" => true,
                "stateSave" => false,
                "ajax" => [
                        "type" => "Post",
                        "url" => route("daily-parkings.dashboard-datatable"),
                ],
               "columns" => [
                            [ "data" => 'tenant', 'name' => 'daily_parkings.tenant','className'=>'nikosh-ban','orderable' => false,'searchable' => false],
                            [ "data" => 'vehicle_number', 'name' => 'daily_parkings.vehicle_number','className'=>'nikosh-ban','orderable' => false],
                            [ "data" => 'token_number', "name" => 'daily_parkings.token_number','orderable' => false ],
                            [ "data" => 'clock_in','name'=>'daily_parkings.clock_in', 'orderable' => false, 'searchable' => false],
                            [ "data" => 'action', 'orderable' => false, 'searchable' => false,'className'=>'action_width'],
                        ],
        ],

        config('voyager.dashboard.data_tables', []))
        , true) !!};
        let table = $('#dataTable').DataTable(dataTableParams);


        let showSoftDeletes = 0;
        $('#show_soft_deletes').change(function () {
showSoftDeletes = $(this).prop('checked') ? 1 : 0;
        table.draw();

});
        $(document).on('focus', '.dataTables_filter input', function() {

if (e.keyCode === 13) {
table.search(this.value).draw();
}

});

});

    </script>

<script>
        $("#tenant_id").change(function(){

         $.ajax({
                data: {
                    vehicle_type_id: $('input[name="vehicle_type_id"]:checked').val(),
                    tenant_id: $('#tenant_id').val(),
                },
                url: "{{route('daily-parkings.check-parking-limit')}}",
                //dataType: 'JSON',
                type: 'post',
                success: function (data) {
                    console.log(data);

                    if(data==3){
                        Swal.fire(
                            'Alert!',
                            'Your Parking is full. You need to pay for this vehicle',
                            'warning'
                          )

                        return true;
                    }else if(data==4){
                         Swal.fire(
                            'Required',
                            'Please select vehicle type',
                            'error'
                          );
                  $('#tenant_id option:first').prop('selected',true);
                    }
                    else{
                        return true;
                    }
                }
            });
});

 $("#station_id").change(function () {
            var $this = $(this);
            $.ajax({
                data: {
                    station_id: $this.val(),
                },
                url: "{{route('daily-parkings.station_wise_customer')}}",
                //dataType: 'JSON',
                type: 'post',
                success: function (data) {
                    console.log(data);
                    $('#tenant_id').html(data.html);
                }
            });
        });




        jQuery.validator.addMethod("exactlength", function(value, element, param) {
        return this.optional(element) || value.length == param;
        }, $.validator.format("Please enter exactly {0} characters."));
        $('document').ready(function () {

//$.validator.addClassRules("item_name",{required: true});
//$.validator.addClassRules("price",{required: true});
    $("#parking_form").validate({
    rules: {

        'vehicle_type_id': {
        required: true
        },
        'station_id': {
        required: true
        },
        'tenant_id': {
        required: true
        },
        'vehicle_number': {
        required: true
        },
        'area_id': {
        required: true
        },
        'code_id': {
        required: true
        },
        errorPlacement: function(error, element)
        {
        if (element.is(":radio"))
        {
            error.appendTo(element.parents('.front-error'));
        }

        }
},
        submitHandler: function (form) {

        $('#voyager-loader').show();
                $('.saving').show();
                $('.save').hide();
                $.ajax({
                url: "{{route('daily-parkings.store')}}",
                        type: "POST",
                        data: $('#parking_form').serialize(),
                        success: function (data) {
                        console.log(data);
                                $('#parking_form').trigger("reset");
                                /* reseting form */
                                $('.alert-danger').hide();
                                $('#voyager-loader').hide();
                                $('.saving').hide();
                                $('.save').show();
                                toastr.success(data.success);
                                w=window.open();
                                w.document.write(data.receit);
                                w.print();
                                w.close();
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
                                setTimeout(function(){ $('.alert-danger').fadeOut(1000) }, 3000);
                        }
                });
        }
});
});

</script>
@stop

