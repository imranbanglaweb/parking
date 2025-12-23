@extends('voyager::master')

@php
    $title = __("bread.$dataType->slug.model_name")  .' '. __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add'));
@endphp

@section('page_title', $title)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ $title }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form class="form-edit-add" role="form"
                          action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">

                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach($dataType->addRows as $row)
                                <div class="form-group">
                                    <label for="name">{{ $row->display_name }}</label>

                                    {!! Voyager::formField($row, $dataType, $dataTypeContent) !!}

                                </div>
                            @endforeach

                            <label for="permission">{{ __('voyager::generic.permissions') }}</label><br>
                            <a href="#" class="permission-select-all">{{ __('voyager::generic.select_all') }}</a> / <a href="#"  class="permission-deselect-all">{{ __('voyager::generic.deselect_all') }}</a>
                            <ul class="permissions checkbox">
                                <?php
                                    $role_permissions = (isset($dataTypeContent)) ? $dataTypeContent->permissions->pluck('key')->toArray() : [];
                                ?>
                                @foreach(Voyager::model('Permission')->all()->groupBy('table_name') as $table => $permissions)
                                    <li>
                                        <input type="checkbox" id="{{$table|'general_permissions'}}"
                                               class="permission-group">
                                        <label for="{{$table | "general_permissions"}}">
                                            @if(!empty($table))
                                                <strong>{{\Illuminate\Support\Str::title(str_replace('_',' ', $table))}}</strong>
                                            @else
                                                <strong>{{__("General Permissions")}}</strong>
                                            @endif
                                        </label>
                                        <ul>
                                            @php $groupByPermissions = $permissions->groupBy('sub_group'); @endphp
                                            @foreach($groupByPermissions as $groupName => $permissions)
                                                @if(strlen($groupName))
                                                    <li>
                                                        <input type="checkbox" id="permission-{{$groupName}}-sub" class="permission-sub-group" data-group="{{$groupName}}">
                                                        <label for="permission-{{$groupName}}-sub">{{$groupName}}</label>
                                                    </li>
                                                    <ul id="{{$groupName}}">
                                                        @foreach($permissions as $perm)
                                                            <li>
                                                                <input type="checkbox" id="permission-{{$perm->id}}" name="permissions[]" class="the-permission" value="{{$perm->id}}" @if(in_array($perm->key, $role_permissions)) checked @endif>
                                                                <label for="permission-{{$perm->id}}">{{\Illuminate\Support\Str::title(str_replace('_', ' ', $perm->key))}}</label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    @foreach($permissions as $perm)
                                                        <li>
                                                            <input type="checkbox" id="permission-{{$perm->id}}" name="permissions[]" class="the-permission" value="{{$perm->id}}" @if(in_array($perm->key, $role_permissions)) checked @endif>
                                                            <label for="permission-{{$perm->id}}">{{\Illuminate\Support\Str::title(str_replace('_', ' ', $perm->key))}}</label>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- panel-body -->
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">{{ __('voyager::generic.submit') }}</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        {{ csrf_field() }}
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/public/backend_resources/js/form.js') }}"></script>
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            $('.permission-group').on('change', function(){
                $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
            });

            $('.permission-select-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked(){
                $('.permission-group').each(function(){
                    var allChecked = true;
                    $(this).siblings('ul').find("input[type='checkbox']").each(function(){
                        if(!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function(){
                parentChecked();
            });

            $(document).on('change', '.permission-sub-group', function () {
                let group_id = $(this).data('group');

                $("#"+group_id).find("input[type='checkbox']").prop('checked', $(this).is(':checked'));
            });
        });
    </script>
@stop
