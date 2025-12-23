@extends('voyager::master')

@section('page_title', __('bread.users.model_name') )

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bookmark"></i> {{ __('bread.users.model_name') }}
        </h1>
        @can('add', app(\App\Models\User::class))
            <a href="{{ route('voyager.users.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
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
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{__($localPrefix . 'avatar')}}</th>
                                            <th>{{__($localPrefix . 'name')}}</th>
                                            <th>{{__($localPrefix . 'email')}}</th>
                                            <th>{{__($localPrefix . 'mobile')}}</th>
                                            <th>{{__($localPrefix . 'user_type')}}</th>
                                            <th>{{__($localPrefix . 'role')}}</th>
                                            <th>{{__('voyager::generic.actions')}}</th>
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
    <script>
        $(document).ready(function () {
            var dataTableParams = {!! json_encode(
                    array_merge([
                        "language" => __('voyager::datatable'),
                        "processing" => true,
                        "serverSide" => true,
                        "ordering" => true,
                        "searching" => true,
                        "stateSave"=> false,
                        "ajax" => [
                            "method" => "POST",
                            "url" => route("users.datatable"),
                        ],

                        "columns" => [
                            [ "data" => 'avatar'],
                            [ "data" => 'name', "name" => 'users.name'],
                            [ "data" => 'email', "name" => 'users.email'],
                            [ "data" => 'mobile', "name" => 'users.mobile'],
                            [ "data" => 'user_type', "name" => 'users.user_type'],
                            [ "data" => 'role_name', "name" => 'roles.display_name', 'visible' => true],
                            [ "data" => 'action', 'orderable' => false, 'searchable' => false]
                        ]
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
                $(this).unbind().bind('keyup', function(e) {
                    if(e.keyCode === 13) {
                        table.search( this.value ).draw();
                    }
                });
            });
        });
        $(document).on('click', 'td .delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.users.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });
        
    </script>
@stop


@section('head')

@endsection
