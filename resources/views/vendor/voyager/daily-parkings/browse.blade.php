@extends('voyager::master')

@section('page_title', __('bread.daily-parkings.model_name') )

@section('page_header')
<div class="container-fluid">
    <h1 class="page-title">
        <i class="voyager-truck"></i> {{ __('bread.daily-parkings.model_name') }}
    </h1>

    @can('delete', app(\App\Models\DailyParking::class))
        @if($usesSoftDeletes)
        <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle"
               data-on="{{ __('voyager::bread.soft_deletes_off') }}"
               data-off="{{ __('voyager::bread.soft_deletes_on') }}">
        @endif
    @endcan
    @can('sync', app(\App\Models\DailyParking::class))
    <a id="sync" style="margin-left:10px" class="btn btn-success btn-add-new">
        <i class="voyager-refresh"></i> <span>{{ __('Sync') }}</span>
    </a>
    @endcan
</div>

<style>
    #dataTable .btn-sm {
        padding: 3px 8px;
        margin: 0 2px;
        font-size: .8rem;
    }
</style>
@stop

@section('content')
<div class="page-content browse container-fluid">
    @include('voyager::alerts')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                             @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            <form method="post" action="{{ route('daily-parkings.print-daily-parking') }}" class="search-report" id="search-report" role="form" enctype="multipart/form-data" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="row">
                                     <div class="col-sm-12 col-md-2">
                                        <input class="form-control" type="text" name="start_date" id="start_date" placeholder="select Start date" value="" />
                                    </div>
                                     <div class="col-sm-12 col-md-2" >

                                     <input class="form-control" type="text" name="end_date" id="end_date" placeholder="select End date" value="" />
                                    </div>
                                     @if(Auth::user()->isAdmin())
                                <div class="col-sm-12 col-md-2" >

                                        <select class="form-control select2" id="station_id" name="station_id">
                                            <option value="" >{{ __('--Select one--') }}</option>
                                            @foreach($stations as $station)
                                            <option value="{{$station->id}}" >
                                                {{$station->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                </div>
                                @else
                                <input class="form-control "id="station_id" type="hidden" name="station_id"
                                       value="{{Auth::user()->station_id}}">

                                @endif
                                <div class="col-sm-12 col-md-3 project" >

                                    <select name="tenant_id" id="tenant_id" class="form-control select2">
                                        <option value="">--Select One--</option>

                                    </select>

                            </div>
                             <div class="col-sm-12 col-md-3" >

                                    <select name="vehicle_type_id" id="vehicle_type_id" class="form-control select2">
                                     <option value="">--Select One--</option>

                                    </select>
                            </div>


                                     <div class="col-sm-12 col-md-2">
                                        <input class="form-control" type="text" name="vehicle_number" id="vehicle_number" placeholder="Vehicle Number" value="" />
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <select name="payment_status" id="payment_status" class="form-control select2">

                                            <option selected value="">{{__('--Select Payment Status--')}}</option>
                                            <option  value="Paid">{{__('Paid')}}</option>
                                            <option  value="Free">{{__('Free')}}</option>

                                        </select>

                                    </div>
                                    @if(Auth::user()->isAdmin())
                                    <div class="col-sm-12 col-md-2">
                                        <select name="added_by" id="added_by" class="form-control select2">

                                            <option selected value="">{{__('--Select User--')}}</option>

                                        </select>

                                    </div>
                                    @endif

                                    <div class="col-sm-12 col-md-2">
                                        <button class="btn btn-primary search" id="btn_search" style="margin-top:0px" name="search" type="button" > Search</button>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <button class="btn btn-warning export" name="action" value="pdf"  id="" style="margin-top:0px" type="submit" > Export PDF</button>
                                        <button class="btn btn-success export" name="action" value="excell"  id="" style="margin-top:0px" type="submit" > Export Excel</button>

                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="no-space">{{__('S/L')}}</th>

                                            <th class="no-space">{{__($localPrefix . 'station')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'tenants')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'token_number')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'vehicle_type')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'vehicle_number')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'mobile_number')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'clock_in')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'clock_out')}}</th>
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
</div>

<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('voyager::generic.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}?
                </h4>
            </div>
            <div class="modal-body" id="delete_model_body"></div>
            <div class="modal-footer">
                <form action="#" id="delete_form" method="POST">
                    {{ method_field("DELETE") }}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-danger pull-right delete-confirm"
                           value="{{ __('voyager::generic.delete_this_confirm') }}">
                </form>
                <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('public/backend_resources/js/form.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend_resources/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/backend_resources/js/bootstrap-datepicker.min.js') }}"></script>

<link href="{{ asset('public/backend_resources/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script>
      $(function() {

    $('#start_date').datepicker({
        orientation: "auto bottom",
        format: 'yyyy-mm-dd',
        autoclose:true,
        todayHighlight: true,
    });
    $('#end_date').datepicker({
        orientation: "auto bottom",
        format: 'yyyy-mm-dd',
        autoclose:true,
        todayHighlight: true,
    });

    });
</script>
<script>
$(document).ready(function () {
    let station_id = <?php echo Auth::user()->station_id;?>;

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
      $.ajax({
                url: "{{route('stations.vehicle_type')}}",
                type: "POST",
                data: { 'station_id' : station_id},
                success: function (data) {
                   $("#vehicle_type_id").html(data);
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
     $("#station_id").change(function(){
        var station_id = $("#station_id").val();
        $.ajax({
                url: "{{route('stations.users')}}",
                type: "POST",
                data: { 'station_id' : station_id },
                success: function (data) {
                   $("#added_by").html(data);
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
    $("#station_id").change(function(){
        var station_id = $("#station_id").val();
        $.ajax({
                url: "{{route('stations.vehicle_type')}}",
                type: "POST",
                data: { 'station_id' : station_id },
                success: function (data) {
                   $("#vehicle_type_id").html(data);
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




        $(document).on('click', '#sync', function(){
            $('#voyager-loader').show();
        $.ajax({
                url: "{{route('daily-parkings.sync')}}",
                //dataType: 'JSON',
                type: 'post',
                success: function (data) {
                        toastr.success(data.success);
                        $('#voyager-loader').hide();

                        },

                        error: function (data) {
                                toastr.danger(data.error);
                                $('#voyager-loader').hide();

                        }
            });
        ;
    });


     var showSoftdeleted = "<?php echo $showSoftDeleted;?>";
    var dataTableParams = {!! json_encode(
        array_merge([
                "language" => __('voyager::datatable'),
                "processing" => true,
                "serverSide" => true,
                "ordering" => true,
                "searching" => false,
                "stateSave" => false,
                "ajax" => [
                        "type" => "Post",
                        "url" => route("daily-parkings.datatable"),
                ],
                "columns" => [
                        [ "data" => 'DT_RowIndex','name'=>'DT_RowIndex','orderable' => false, 'searchable' => false],
                        [ "data" => 'station', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle','visible'=>Auth::user()->isAdmin() ? true :false ],
                        [ "data" => 'tenant', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'token_number', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'vehicle_type', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'vehicle_number', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'mobile_number', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'clock_in', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'clock_out', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],

                ]
        ],
                config('voyager.dashboard.data_tables', []))
        , true) !!};
        dataTableParams.ajax.data = {
                showSoftDeleted: showSoftdeleted,
            };
             let table = $('#dataTable').DataTable(dataTableParams);


        $(document).on('focus', '.dataTables_filter input', function() {
$(this).unbind().bind('keyup', function(e) {
if (e.keyCode === 13) {
table.search(this.value).draw();
}
});
});
});
$(document).on('click', 'td .delete', function (e) {
    $('#delete_form')[0].action = '{{ route('voyager.car-numbers.destroy', '__id') }}'.replace('__id', $(this).data('id'));
    $('#delete_modal').modal('show');
});


 @if($usesSoftDeletes)
        $(function () {
            $('#show_soft_deletes').change(function () {
                if ($(this).prop('checked')) {
                    $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge( ['showSoftDeleted' => 1]), true)) }}"></a>');
                } else {
                    $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge( ['showSoftDeleted' => 0]), true)) }}"></a>');
                }

                $('#redir')[0].click();
            })
        })
        @endif
</script>
<script type="text/javascript">
     $("#btn_search").click(function (e) {
            $("#dataTable").dataTable().fnDestroy();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var station_id = $('#station_id').val();
            var tenant_id = $('#tenant_id').val();
            var vehicle_type_id = $('#vehicle_type_id').val();
            var vehicle_number = $('#vehicle_number').val();
            var payment_status = $('#payment_status').val();
            var added_by = $('#added_by').val();

            let tableConfig ={!! json_encode(
                    array_merge([
                        "language" => __('voyager::datatable'),
                        "processing" => true,
                        "serverSide" => true,
                        "ordering" => true,
                        "searching" => false,
                        "stateSave" => false,
                        "ajax" => [
                                "type" => "Post",
                                "data"=>[],
                                "url" => route("daily-parkings.datatable"),
                        ],

                         "columns" => [
                        [ "data" => 'DT_RowIndex','name'=>'DT_RowIndex','orderable' => false, 'searchable' => false],
                        [ "data" => 'station', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle','visible'=>Auth::user()->isAdmin() ? true :false ],
                        [ "data" => 'tenant', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'token_number', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'vehicle_type', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'vehicle_number', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'mobile_number', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'clock_in', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'clock_out', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],

                            ]

                        ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!};

            tableConfig.ajax.data = {
                start_date: start_date,
                end_date: end_date,
                station_id: station_id,
                tenant_id: tenant_id,
                vehicle_type_id: vehicle_type_id,
                vehicle_number: vehicle_number,
                payment_status: payment_status,
                added_by: added_by,

            };
            var table = $('#dataTable').DataTable(tableConfig);

        });

</script>
@stop

@section('validation')
@if(app()->getLocale() === 'bn')
<script src="{{ asset('/public/backend_resources/js/validation_localization_bn.js') }}"></script>
@endif

@stop
