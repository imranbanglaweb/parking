@extends('voyager::master')

@section('page_title', __('bread.car-numbers.model_name') )

@section('page_header')
<div class="container-fluid">
    <h1 class="page-title">
        <i class="voyager-bookmark"></i> {{ __('bread.car-numbers.model_name') }}
    </h1>
    @can('add', app(\App\Models\CarNumber::class))
    <a href="{{ route('voyager.car-numbers.create') }}" class="btn btn-success btn-add-new">
        <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
    </a>
    @endcan
    @can('delete', app(\App\Models\CarNumber::class))
        @if($usesSoftDeletes)
        <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle"
               data-on="{{ __('voyager::bread.soft_deletes_off') }}"
               data-off="{{ __('voyager::bread.soft_deletes_on') }}">
        @endif
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
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="no-space">{{__('S/L')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'stations')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'tenants')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'vehicle_type')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'vehicle_number')}}</th>
                                            <th class="no-space">{{__($localPrefix . 'parking_number')}}</th>
                                            <th class="no-space">{{__('voyager::generic.status')}}</th>
                                            <th class="no-space ">{{__('voyager::generic.actions')}}</th>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(document).ready(function () {
     var showSoftdeleted = "<?php echo $showSoftDeleted;?>";
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
                        "url" => route("car-numbers.datatable"),
                ],
                "columns" => [
                        [ "data" => 'DT_RowIndex','name'=>'DT_RowIndex','orderable' => false, 'searchable' => false],
                        [ "data" => 'station', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'tenant', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'vehicle_type', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'],
                        [ "data" => 'vehicle_number', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'parking_number', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'status', 'orderable' => false, 'searchable' => false, 'className' => 'nopadding'],
                        [ "data" => 'action', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle nowarap']
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

@stop

@section('validation')
@if(app()->getLocale() === 'bn')
<script src="{{ asset('/public/backend_resources/js/validation_localization_bn.js') }}"></script>
@endif

@stop
