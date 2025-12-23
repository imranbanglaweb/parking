@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <button id="open_calendar" class="btn btn-primary">{{__('Calendar')}}</button>
                <button id="open_list" class="btn btn-info">{{__('Holiday List')}}</button>
            </div>
        </div>
    </div>

    @php $emptyModel = app($dataType->model_name); @endphp
    <div id="section_list_header" class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        </h1>
        @can('add', $emptyModel)
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('bulkDelete', $dataType->model_name)
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('restore', app($dataType->model_name))
            @if($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle"
                       data-on="{{ __('voyager::bread.soft_deletes_off') }}"
                       data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach(Voyager::actions() as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')

    <div class="container-fluid">
        @include('voyager::alerts')
    </div>
    <div id="section_list" class="page-content browse container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <select id="search_key" name="key">
                                        @foreach($searchable as $key)
                                            <option value="{{ $key }}" @if($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)){{ 'selected' }}@endif>{{ ucwords(str_replace('_', ' ', $key)) }}</option>
                                        @endforeach
                                    </select>
                                    <select id="filter" name="filter">
                                        <option value="contains" @if($search->filter == "contains"){{ 'selected' }}@endif>
                                            contains
                                        </option>
                                        <option value="equals" @if($search->filter == "equals"){{ 'selected' }}@endif>
                                            =
                                        </option>
                                    </select>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control"
                                               placeholder="{{ __('voyager::generic.search') }}" name="s"
                                               value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                            </form>
                        @endif
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    @can('delete',app($dataType->model_name))
                                        <th>
                                            <input type="checkbox" class="select_all">
                                        </th>
                                    @endcan
                                    @foreach($dataType->browseRows as $row)
                                        <th>
                                            @if ($isServerSide)
                                                <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                    @endif
                                                    {{ $row->display_name }}
                                                    @if ($isServerSide)
                                                        @if ($row->isCurrentSortField($orderBy))
                                                            @if ($sortOrder == 'asc')
                                                                <i class="voyager-angle-up pull-right"></i>
                                                            @else
                                                                <i class="voyager-angle-down pull-right"></i>
                                                            @endif
                                                        @endif
                                                </a>
                                            @endif
                                        </th>
                                    @endforeach
                                    <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataTypeContent as $data)
                                    <tr>
                                        @can('delete',app($dataType->model_name))
                                            <td>
                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}"
                                                       value="{{ $data->getKey() }}">
                                            </td>
                                        @endcan
                                        @foreach($dataType->browseRows as $row)
                                            @php
                                                if ($data->{$row->field.'_browse'}) {
                                                    $data->{$row->field} = $data->{$row->field.'_browse'};
                                                }
                                            @endphp
                                            <td>
                                                @if (isset($row->details->view))
                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse'])
                                                @elseif($row->type == 'image')
                                                    <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif"
                                                         style="width:100px">
                                                @elseif($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])
                                                @elseif($row->type == 'select_multiple')
                                                    @if(property_exists($row->details, 'relationship'))

                                                        @foreach($data->{$row->field} as $item)
                                                            {{ $item->{$row->field} }}
                                                        @endforeach

                                                    @elseif(property_exists($row->details, 'options'))
                                                        @if (!empty(json_decode($data->{$row->field})))
                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif
                                                    @endif

                                                @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                    @if (@count(json_decode($data->{$row->field})) > 0)
                                                        @foreach(json_decode($data->{$row->field}) as $item)
                                                            @if (@$row->details->options->{$item})
                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {{ __('voyager::generic.none') }}
                                                    @endif

                                                @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                    {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                    {{ property_exists($row->details, 'format') ? \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) : $data->{$row->field} }}
                                                @elseif($row->type == 'checkbox')
                                                    @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                        @if($data->{$row->field})
                                                            <span class="label label-info">{{ $row->details->on }}</span>
                                                        @else
                                                            <span class="label label-primary">{{ $row->details->off }}</span>
                                                        @endif
                                                    @else
                                                        {{ $data->{$row->field} }}
                                                    @endif
                                                @elseif($row->type == 'color')
                                                    <span class="badge badge-lg"
                                                          style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                @elseif($row->type == 'text')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                @elseif($row->type == 'text_area')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    @if(json_decode($data->{$row->field}) !== null)
                                                        @foreach(json_decode($data->{$row->field}) as $file)
                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                                                               target="_blank">
                                                                {{ $file->original_name ?: '' }}
                                                            </a>
                                                            <br/>
                                                        @endforeach
                                                    @else
                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}"
                                                           target="_blank">
                                                            Download
                                                        </a>
                                                    @endif
                                                @elseif($row->type == 'rich_text_box')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                @elseif($row->type == 'coordinates')
                                                    @include('voyager::partials.coordinates-static-image')
                                                @elseif($row->type == 'multiple_images')
                                                    @php $images = json_decode($data->{$row->field}); @endphp
                                                    @if($images)
                                                        @php $images = array_slice($images, 0, 3); @endphp
                                                        @foreach($images as $image)
                                                            <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif"
                                                                 style="width:50px">
                                                        @endforeach
                                                    @endif
                                                @elseif($row->type == 'media_picker')
                                                    @php
                                                        if (is_array($data->{$row->field})) {
                                                            $files = $data->{$row->field};
                                                        } else {
                                                            $files = json_decode($data->{$row->field});
                                                        }
                                                    @endphp
                                                    @if ($files)
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif"
                                                                     style="width:50px">
                                                            @endforeach
                                                        @else
                                                            <ul>
                                                                @foreach (array_slice($files, 0, 3) as $file)
                                                                    <li>{{ $file }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                        @if (count($files) > 3)
                                                            {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                        @endif
                                                    @elseif (is_array($files) && count($files) == 0)
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @elseif ($data->{$row->field} != '')
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif"
                                                                 style="width:50px">
                                                        @else
                                                            {{ $data->{$row->field} }}
                                                        @endif
                                                    @else
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @endif
                                                @else
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <span>{{ $data->{$row->field} }}</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="no-sort no-click" id="bread-actions">
                                            @foreach(Voyager::actions() as $action)
                                                @if (!method_exists($action, 'massAction'))
                                                    @include('voyager::bread.partials.actions', ['action' => $action])
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                    's' => $search->value,
                                    'filter' => $search->filter,
                                    'key' => $search->key,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder,
                                    'showSoftDeleted' => $showSoftDeleted,
                                ])->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="section_calender" class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i
                                class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->display_name_singular) }}
                        ?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{--    Event Modal Update--}}
    <div class="modal modal-info fade" tabindex="-1" id="calendar_modal_edit" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="voyager-pen"></i>
                        Edit Calendar Event
                    </h4>
                </div>
                <form action="{{route('calender.events.update')}}" id="event_update_form" method="POST" class="align-content-center">
                    {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        @can('showCompanyField', \App\Models\Calendar::class)
                            <label for="company_id">{{__('Company')}}</label>
                            <select name="company_id" id="company_id"
                                    class="form-control select2-ajax-custom"
                                    data-url="{{route('api.index')}}" data-model="{{App\Models\Company::class}}"
                                    data-dependent-fields="{{json_encode(['branch_id','department_id'])}}"
                                    data-label="title"
                                    required
                            >
                                <option value="">{{__('voyager::generic.none')}}</option>
                                @foreach($companies as $companyId => $companyTitle)
                                    <option value="{{ $companyId }}" @if(old('company_id') == $companyId) selected @endif>{{ $companyTitle }}</option>
                                @endforeach
                            </select>
                        @endcan
                        @cannot('showCompanyField', \App\Models\Calendar::class)
                            <input type="hidden" name="company_id" value="{{auth()->user()->company_id}}">
                        @endcannot

                        @can('showBranchField', \App\Models\Calendar::class)
                            <label for="branch_id">{{__('Branch')}}</label>
                            <select name="branch_id" id="branch_id"
                                    class="form-control select2-ajax-custom"
                                    data-url="{{route('api.index')}}" data-model="{{App\Models\Branch::class}}"
                                    data-depend-on="{{json_encode(['company_id'])}}"
                                    data-dependent-fields="{{json_encode(['department_id'])}}"
                                    data-label="name"
                            >
                                <option value="">{{__('voyager::generic.none')}}</option>
                                @if(!empty($branches))
                                    @foreach($branches as $branchId => $branchName)
                                        <option value="{{ $branchId }}" @if(old('branch_id') == $branchId) selected @endif>{{ $branchName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endcan
                        @cannot('showBranchField', \App\Models\Calendar::class)
                            <input type="hidden" name="branch_id" value="{{auth()->user()->branch_id}}">
                        @endcannot

                        @can('showDepartmentField', \App\Models\Calendar::class)
                            <label for="department_id">{{__('Department')}}</label>
                            <select name="department_id" id="department_id"
                                    class="form-control select2-ajax-custom"
                                    data-url="{{route('api.index')}}" data-model="{{App\Models\Department::class}}"
                                    data-depend-on="{{json_encode(['company_id', 'branch_id'])}}"
                                    data-label="name"
                            >
                                <option value="">{{__('voyager::generic.none')}}</option>
                                @if(!empty($departments))
                                    @foreach($departments as $deptId => $deptName)
                                        <option value="{{ $deptId }}" @if(old('department_id') == $deptId) selected @endif>{{ $deptName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endcan
                        @cannot('showDepartmentField', \App\Models\Calendar::class)
                            <input type="hidden" name="department_id" value="{{auth()->user()->department_id}}">
                        @endcannot
                    </div>
                    <div class="form-group">
                        <input name="title" required type="text" class="form-control" id="event_title_edit" placeholder="Type Event">
                        <input name="id" required type="hidden" id="event_id_edit">
                        <input name="more" required type="hidden" id="event_add_more">
                        <input name="start_date" required type="hidden" id="event_date_more">
                    </div>
                    <div class="form-group">
                        <textarea name="details" class="form-control" id="event_details_edit" cols="30"></textarea>
                    </div>
                    <div class="form-group">
                        <select name="event_type" id="event_type_edit" class="form-control" required>
                            <option value="">Select Option</option>
                            @foreach($type as $typ)
                                <option value="{{$typ}}">{{$typ}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <a   onclick="eventDelete()" title="Delete" id="event_delete_btn" class="btn btn-sm btn-danger pull-right delete">
                            <i class="voyager-trash"></i>
                        </a>
                        <input id="update_event_btn" type="submit" class="btn btn-success pull-right" value="Update">
                        <a onclick="addMoreEvent()" id="new_btn_event" class="btn btn-primary btn-add-new pull-right">
                            <i class="voyager-plus"></i> <span>New</span>
                        </a>
                        <button  type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{--    Event Modal Add--}}
    <div class="modal modal-info fade" tabindex="-1" id="calendar_modal_add" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="voyager-plus"></i>
                        {{__('Add Calendar Event')}}
                    </h4>
                </div>
                <form action="{{route('calender.events.add')}}" id="new_event_form" method="POST">
                    {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        @can('showCompanyField', \App\Models\Calendar::class)
                            <label for="company_id_add">{{__('Company')}}</label>
                            <select name="company_id" id="company_id_add"
                                    class="form-control select2-ajax-custom"
                                    data-url="{{route('api.index')}}" data-model="{{App\Models\Company::class}}"
                                    data-dependent-fields="{{json_encode(['branch_id','department_id'])}}"
                                    data-label="title"
                                    required
                            >
                                <option value="">{{__('voyager::generic.none')}}</option>
                                @foreach($companies as $companyId => $companyTitle)
                                    <option value="{{ $companyId }}" @if(old('company_id') == $companyId) selected @endif>{{ $companyTitle }}</option>
                                @endforeach
                            </select>
                        @endcan
                        @cannot('showCompanyField', \App\Models\Calendar::class)
                            <input type="hidden" name="company_id" value="{{auth()->user()->company_id}}">
                        @endcannot

                        @can('showBranchField', \App\Models\Calendar::class)
                            <label for="branch_id_add">{{__('Branch')}}</label>
                            <select name="branch_id" id="branch_id_add"
                                    class="form-control select2-ajax-custom"
                                    data-url="{{route('api.index')}}" data-model="{{App\Models\Branch::class}}"
                                    data-depend-on="{{json_encode(['company_id'])}}"
                                    data-dependent-fields="{{json_encode(['department_id'])}}"
                                    data-label="name"
                            >
                                <option value="">{{__('voyager::generic.none')}}</option>
                                @if(!empty($branches))
                                    @foreach($branches as $branchId => $branchName)
                                        <option value="{{ $branchId }}" @if(old('branch_id') == $branchId) selected @endif>{{ $branchName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endcan
                        @cannot('showBranchField', \App\Models\Calendar::class)
                            <input type="hidden" name="branch_id" value="{{auth()->user()->branch_id}}">
                        @endcannot

                        @can('showDepartmentField', \App\Models\Calendar::class)
                            <label for="department_id_add">{{__('Department')}}</label>
                            <select name="department_id" id="department_id_add"
                                    class="form-control select2-ajax-custom"
                                    data-url="{{route('api.index')}}" data-model="{{App\Models\Department::class}}"
                                    data-depend-on="{{json_encode(['company_id', 'branch_id'])}}"
                                    data-label="name"
                            >
                                <option value="">{{__('voyager::generic.none')}}</option>
                                @if(!empty($departments))
                                    @foreach($departments as $deptId => $deptName)
                                        <option value="{{ $deptId }}" @if(old('department_id') == $deptId) selected @endif>{{ $deptName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endcan
                        @cannot('showDepartmentField', \App\Models\Calendar::class)
                            <input type="hidden" name="department_id" value="{{auth()->user()->department_id}}">
                        @endcannot
                    </div>
                    <div class="form-group">
                        <input name="title" required type="text" class="form-control" id="event_title_add" placeholder="Type Event">
                        <input name="start_date" required type="hidden" id="event_date">
                    </div>
                    <div class="form-group">
                        <textarea name="details" class="form-control" id="event_details_add" cols="30" placeholder="Event Details"></textarea>
                    </div>
                    <div class="form-group">
                            <select name="event_type" id="event_type_add" class="form-control" required>
                                @foreach($type as $typ)
                                <option value="{{$typ}}" @if($typ == \App\Models\Calendar::HOLIDAY) selected @endif>{{$typ}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right"
                               value="Save">
                        <button type="button" class="btn btn-default pull-right"
                                data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{--    Event Modal Delete--}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_event_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i
                            class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} Event ?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{route('calendar.event.delete')}}" id="delete_form" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="event_id">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop


@section('css')
    <link rel="stylesheet" href="{{ url('public/backend_resources/js/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/backend_resources/js/fullcalendar/custom-fullcalendar.css') }}">

    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script src="{{ url('public/backend_resources/js/fullcalendar/fullcalendar.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [['targets' => -1, 'searchable' =>  false, 'orderable' => false]],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
            $('#search-input select').select2({
                minimumResultsForSearch: Infinity
            });
            @endif

            @if ($isModelTranslatable)
            $('.side-body').multilingual();
            //Reinitialise the multilingual features when they change tab
            $('#dataTable').on('draw.dt', function () {
                $('.side-body').data('multilingual').init();
            })
            @endif
            $('.select_all').on('click', function (e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if($usesSoftDeletes)
        @php
            $params = [
                's' => $search->value,
                'filter' => $search->filter,
                'key' => $search->key,
                'order_by' => $orderBy,
                'sort_order' => $sortOrder,
            ];
        @endphp
        $(function () {
            $('#show_soft_deletes').change(function () {
                if ($(this).prop('checked')) {
                    $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 1]), true)) }}"></a>');
                } else {
                    $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 0]), true)) }}"></a>');
                }

                $('#redir')[0].click();
            })
        })
        @endif
        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function () {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });
    </script>

    {{--   Custom JS    --}}
    <script>
        {{-- Configure FullCalendar--}}
        $(document).ready(function() {

            /** add form validation for new event form */
            var eventUpdateFormValidator =  $("#event_update_form").validate({
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    element.parents(".form-group").addClass("has-feedback");
                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else if(element.hasClass('select2-ajax') || element.hasClass('select2')) {
                        error.insertAfter(element.parents(".form-group").find('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                }
            });
            var newEventFormValidator =  $("#new_event_form").validate({
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    element.parents(".form-group").addClass("has-feedback");
                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else if(element.hasClass('select2-ajax') || element.hasClass('select2')) {
                        error.insertAfter(element.parents(".form-group").find('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable:false,
                header:{
                    left:'prev, next today',
                    center: 'title',
                    right:'prev next'
                },
                overlap: false,
                eventLimit: true,
                eventLimitText: "{{__("See more")}}",
                views: {
                    month: {
                        eventLimit: 2
                    }
                },
                events: {!! json_encode($events) !!},
                eventRender: function(event, element) {
                    element.find('.fc-title').append("<br/> <small>" + event.description + "</small> <br/><small class='float-right'>" + event.type + "</small>");
                },
                selectHelper:true,
                eventClick:function(event)
                {
                    console.log('event click');
                    if(!event.edit_permission) {
                        return false;
                    }
                    if(!event.delete_permission){
                        $('#event_delete_btn').hide();
                    } else {
                        $('#event_delete_btn').show();
                    }

                    $('#event_id_edit').val(event.id);
                    $('#event_id').val(event.id);
                    $('#event_add_more').val(0);
                    $('#update_event_btn').val('Update');

                    $('#company_id').val(event.company_id).trigger('change');
                    if(event.branch_id){
                        $('#branch_id').val(event.branch_id).trigger('change');
                    } else {
                        $('#branch_id').val("");
                    }

                    if(event.department_id){
                        $('#department_id').val(event.department_id).trigger('change');
                    } else {
                        $('#department_id').val("");
                    }


                    $('#event_title_edit').val(event.title);
                    $('#event_details_edit').val(event.description);
                    $('#event_type_edit').val(event.type);
                    $('#event_date_more').val(event.start.format());
                    $('#calendar_modal_edit').modal('show');

                    eventUpdateFormValidator.resetForm();

                    $("#event_update_form .form-group").each(function(index, elem){
                        $(elem).removeClass("has-feedback").removeClass("has-error").removeClass("has-success");
                    });

                },

                dayClick:function(date, jsEvent, view)
                {
                    @can('add', app(\App\Models\Calendar::class))
                        console.log('dayClick click');
                        var allEvents = $("#calendar").fullCalendar("clientEvents");
                        var exists = false;
                        $.each(allEvents, function (index, value) {
                            if (new Date(value.start).toDateString() === new Date(date).toDateString()) {
                                exists = true;
                            }
                        });

                        if (!exists) {
                            $('#event_title_add').val('');
                            $('#event_details_add').val('');
                            $('#event_type_add').val("{{\App\Models\Calendar::HOLIDAY}}");
                            $('#event_date').val(date.format());
                            $('#calendar_modal_add').modal('show');
                            newEventFormValidator.resetForm();
                            $("#new_event_form .form-group").each(function(index, elem){
                                $(elem).removeClass("has-feedback").removeClass("has-error").removeClass("has-success");
                            });
                        }
                    @endcan
                }
            });

        });


        {{-- Event Deleting Modal Show --}}
        function eventDelete() {
            $('#calendar_modal_edit').modal('hide');
            $('#delete_event_modal').modal('show');
        }

        {{-- Add More Event Form Showing Function --}}
        function addMoreEvent() {
            $('#event_delete_btn').hide();
            $('#update_event_btn').val('Add');
            $("#new_btn_event").hide();
            $('#event_add_more').val(1);
            $('#event_title_edit').val('');
            $('#event_details_edit').val('');
            $('#event_type_edit').val("{{\App\Models\Calendar::HOLIDAY}}");
        }

        {{-- Calendar Or Event List Show/Hide --}}
        $("#section_list_header").hide('slow');
        $("#section_list").hide('slow');

        $("#open_calendar").click(function() {
            $("#section_calender").show('slow');
            $("#section_list_header").hide('slow');
            $("#section_list").hide('slow');
        });

        $("#open_list").click(function() {
            $("#section_calender").hide('slow');
            $("#section_list_header").show('slow');
            $("#section_list").show('slow');
        });
    </script>
@stop
