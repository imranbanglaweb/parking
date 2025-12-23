@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
    $title = __(($edit ? 'Edit ' : 'Add ') . 'User');
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
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ $title }}

        @can('browse', app(\App\Models\User::class))
            <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
                <span class="glyphicon glyphicon-list"></span>&nbsp;
                {{ __('voyager::generic.return_to_list') }}
            </a>
        @endcan
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" id="user_add_edit"
              action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
                <input type="hidden" name="id" id="id" value="{{$dataTypeContent->getKey()}}"/>
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
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

                        <div class="panel-body">
                            <div class="row">
                                @if(auth()->user()->id != $dataTypeContent->id)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_type">{{ __('User Type') }}</label>
                                            <select name="user_type" id="user_type" class="form-controll select2">
                                                <option selected disabled>{{ __('Select User Type') }}</option>
                                                @foreach($userTypes as $key => $type)
                                                    <option
                                                        {{ $edit && $dataTypeContent->user_type === $key ? 'selected' : (old('user_type') === $key ? 'selected': '')}} value="{{$key}}">{{$type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="user_type" id="user_type"
                                           value="{{$dataTypeContent->user_type}}">
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_id">{{ __('Department') }}</label>
                                        <select name="department_id" id="department_id" class="form-controll select2">
                                            <option selected disabled>{{ __('Select Department') }}</option>
                                            @foreach($departments as $department)
                                            <option @if($department->id==$dataTypeContent->department_id){{'selected'}} @endif value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="station_id">{{ __('Station') }}</label>
                                        <select name="station_id" id="station_id" class="form-controll select2">
                                            <option selected disabled>{{ __('Select Station') }}</option>
                                            @foreach($stations as $station)
                                            <option @if($station->id==$dataTypeContent->station_id){{'selected'}} @endif value="{{$station->id}}">{{$station->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('voyager::generic.name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="{{ __('voyager::generic.name') }}"
                                               value="{{ old('name', $dataTypeContent->name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('voyager::generic.email') }}</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="{{ __('voyager::generic.email') }}"
                                               value="{{ old('email', $dataTypeContent->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">{{ __('Mobile Number') }}</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                               placeholder="{{ __('Mobile Number') }}"
                                               value="{{ old('mobile', $dataTypeContent->mobile ) }}"
                                               aria-describedby="helpBlock_username">
                                        <span id="helpBlock_username" class="help-block">[{{__("Valid format")}}: 01XXXXXXXXX ({{__('No need to add country code.')}})]</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">{{ __('voyager::generic.password') }}</label>
                                        @if(isset($dataTypeContent->password))
                                            <br>
                                            <small>{{ __('voyager::profile.password_hint') }}</small>
                                        @endif
                                        <input type="password" class="form-control" id="password" name="password"
                                               value=""
                                               autocomplete="new-password">
                                        <small class="d-block text-danger" id="confirm_password_message"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">{{ __('Confirm Password') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation" value=""
                                               autocomplete="new-password">
                                    </div>
                                </div>

                                @php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                @endphp
                                @can('editRoles', $dataTypeContent)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="default_role">{{ __('voyager::profile.role_default') }}</label>
                                            @php
                                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                                $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                                $options = $row->details;
                                            @endphp
                                            @include('voyager::formfields.relationship',  ['options' => $options, 'row' => $row])
                                        </div>
                                    </div>
                                    @if($edit)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    for="additional_roles">{{ __('voyager::profile.roles_additional') }}</label>
                                                @php
                                                    $row     = $dataTypeRows->where('field', 'user_belongstomany_role_relationship')->first();
                                                    $options = $row->details;
                                                    \Illuminate\Support\Facades\Log::debug((array) $options);
                                                @endphp
                                                @include('voyager::formfields.relationship',  ['options' => $options, 'row' => $row])
                                            </div>
                                        </div>
                                    @endif
                                @endcan
                                @can('changeUserStatus', $dataTypeContent)
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_verifier">{{__('voyager::generic.is_verifier')}}</label>
                                        <select name="is_verifier" id="is_verifier"
                                                class="form-control select2"
                                        >
                                            <option value="0"
                                                    @if(old('is_verifier', $dataTypeContent->is_verifier) == "0") selected @endif>{{__('hr.no')}}</option>
                                            <option value="1"
                                                    @if(old('is_verifier', $dataTypeContent->is_verifier) == "1") selected @endif>{{__('hr.yes')}}</option>
                                        </select>
                                    </div>
                                </div>
                                @endcan
                                @if((auth()->user()->id != $dataTypeContent->id) && $edit)
                                    @can('changeUserStatus', $dataTypeContent)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">{{__('voyager::generic.status')}}</label>
                                                <select name="status" id="status"
                                                        class="form-control select2"
                                                >
                                                    <option value="1"
                                                            @if(old('status', $dataTypeContent->status) == "1") selected @endif>{{__('hr.active')}}</option>
                                                    <option value="0"
                                                            @if(old('status', $dataTypeContent->status) == "0") selected @endif>{{__('hr.Inactive')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endcan
                                @endif
                                <input type="hidden" name="locale" value="bn" id="locale">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if(isset($dataTypeContent->avatar))
                                    <img id="user_img"
                                         src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}"
                                         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;"/>
                                @endif
                                <input onchange="previewFile()" type="file" data-name="avatar" name="avatar">
                            </div>
                        </div>
                    </div>
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body text-right">
                            <div class="form-group">
                                <!--user permission end here-->
                                <button type="submit" class="btn btn-primary save">
                                    {{ __('voyager::generic.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--user permission start from here-->
            @if(Auth::user()->id != $dataTypeContent->id && !is_null($dataTypeContent->getKey()))
                @can('editUserPermission', $dataTypeContent)
                    <label for="permission">{{ __('voyager::generic.permissions') }}</label><br>

                    <ul class="permissions checkbox">

                        @foreach($allPermissionTableNames as $table => $permission)
                            <li>
                                <input type="checkbox" id="{{$table|'general_permissions'}}"
                                       class="permission-group">
                                <label for="{{$table | "general_permissions"}}">
                                    @if(!empty($table))
                                        <strong>{{Illuminate\Support\Str::title(str_replace('_',' ', $table))}}</strong>
                                    @else
                                        <strong>{{__("General Permissions")}}</strong>
                                    @endif
                                </label>
                                <ul>
                                    @foreach($permission as $perm)
                                        <li>
                                            <input type="checkbox" id="permission-{{$perm->id}}"
                                                   name="permissions[]"
                                                   class="the-permission" value="{{$perm->id}}"
                                                   @if(in_array($perm->key, $userPermissions)) checked @endif>
                                            <label
                                                @if(in_array($perm->key, $customPermissions) ) class="user-custom-permission"
                                                @endif for="permission-{{$perm->id}}">{{Illuminate\Support\Str::title(str_replace('_', ' ', $perm->key))}}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
            @endcan
        @endif
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
              enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/public/backend_resources/js/form.js') }}"></script>
    <script>
        $('document').ready(function () {

            $('.toggleswitch').bootstrapToggle();

            @if(Auth::user()->id != $dataTypeContent->id && !is_null($dataTypeContent->getKey()))
            @can('editUserPermission', $dataTypeContent)
            $('.permission-select-all').on('click', function () {
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function () {
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked() {
                $('.permission-group').each(function () {
                    var allChecked = true;
                    $(this).siblings('ul').find("input[type='checkbox']").each(function () {
                        if (!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function () {
                parentChecked();
            });

            $('.the-permission').click(function () {

                var $this = $(this);
                var customClass = 'permission-' + $this.val();
                var user_id = {{$dataTypeContent->id}};
                let checked = $this.prop('checked');

                if (checked) {
                    if (!confirm("{{__('Are you sure you you want to add this permission?')}}")) {
                        return false;
                    }
                } else if (!confirm("{{__('Are you sure you want to remove this permission?')}}")) {
                    return false;
                }
                $this.hide();
                $this.parent().prepend("<img src='" + "{{asset('ajax-loader-tiny.gif')}}" + "' >");
                $.ajax({
                    data: {
                        permission_id: $this.val(),
                        user_id: user_id,
                        checkboxStatus: $(this).is(':checked'),
                    },
                    url: "{{ route('change_user_permission')  }}",
                    dataType: 'JSON',
                    type: 'POST',
                }).done(function (data, textStatus, jqXHR) {
                    console.log(data);
                    $this.parent().find('img').remove();
                    $this.show();
                    $('label[for="' + customClass + '"]').addClass('user-custom-permission');
                    toastr.success("{{__("Permission has been updated successfully")}}");
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $this.parent().find('img').remove();
                    $this.show();
                    toastr.error("{{__("Sorry! problem in updating the permission")}}");
                    console.log(jqXHR, textStatus, errorThrown);
                });
            });

            $('.permission-group').on('change', function () {
                var $this = $(this);
                var user_id = {{$dataTypeContent->id}};
                var checked = $this.prop('checked');
                if (checked) {
                    if (!confirm("{{__('Are you sure you you want to add all permissions under this group?')}}")) {
                        $this.prop('checked', false);
                        return false;
                    }
                } else if (!confirm("{{__('Are you sure you want to remove all permissions under this group?')}}")) {
                    $this.prop('checked', true);
                    return false;
                }
                $this.hide();
                $this.parent().prepend("<img src='" + "{{asset('ajax-loader-tiny.gif')}}" + "' >");
                var allPermissionIds = [];
                $(this).siblings('ul').find("input[type='checkbox']").each(function (key, element) {
                    if ($(element).val()) {
                        allPermissionIds.push($(element).val());
                    }
                });
                console.log(allPermissionIds);

                $.ajax({
                    data: {
                        permission_ids: allPermissionIds,
                        user_id: user_id,
                        checkboxStatus: checked,
                    },
                    url: "{{ route('change_user_permissions')  }}",
                    dataType: 'JSON',
                    type: 'POST',
                }).done(function (data, textStatus, jqXHR) {
                    console.log(data);
                    $this.parent().find('img').remove();
                    $this.show();
                    $this.siblings('ul').find("input[type='checkbox']").each(function (key, element) {
                        if ($(element).val()) {
                            $('label[for="permission-' + $(element).val() + '"]').addClass('user-custom-permission');
                        }
                        $(element).prop('checked', checked);
                    });
                    toastr.success("{{__("Permissions have been updated successfully")}}");
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $this.parent().find('img').remove();
                    $this.show();
                    toastr.error("{{__("Sorry! problem in updating permissions")}}");
                    console.log(jqXHR, textStatus, errorThrown);
                });

            });
            @endcan
            @endif

            @if(auth()->user()->id != $dataTypeContent->id)
            $('#user_type').change(function (e) {
                var userType = $(this).val();

                if (userType === "{{\App\Models\User::SUPER_ADMIN}}") {
                    $("#company_id, #branch_id, #department_id, #employee_id").each(function (index, elem) {
                        $(elem).prop('required', false).parent().find('label').removeClass('required');
                    });
                } else {
                    $("#company_id, #branch_id, #department_id, #employee_id").each(function (index, elem) {
                        $(elem).prop('required', true).parent().find('label').addClass('required');
                    });
                }
            });
            @endif
        });


    </script>
@stop
<!-- frontend validation for bread -->
@section('validation')
    <script src="{{ asset('/public/backend_resources/js/jquery_validation_combine.js') }}"></script>

    @if(app()->getLocale() === 'bn')
        <script src="{{ asset('/public/backend_resources/js/validation_localization_bn.js') }}"></script>
    @endif

    <script>
        $('document').ready(function () {

            /* Adding Jquery Validation rules  */

            jQuery.extend(jQuery.validator.messages, {
                required: "{{__('This field is required.')}}",
                email: "ইমেইল ভুল হয়েছে",
            });

            $.validator.addMethod(
                "regex",
                function (value, element, regexp) {
                    console.log(regexp);
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "{{__("Invalid Input")}}"
            );

            var addEditForm = $('form.form-edit-add');

            if (addEditForm.length) {
                var rules = {
                    name: {
                        "required": true,
                        "minlength": 2
                    },
                    email: {
                        "required": true,
                        "email": true,

                    },
                     station_id: {
                        "required": true,

                    },
                    user_type: {
                        required: true
                    },
                    mobile: {
                        "required": true,
                        "regex": "^01[1-9][0-9]{8}$",
                    },
                    password: {
                        required: @if(!$edit) true @else false @endif
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    }
                };
                $.each(rules, function (key, value) {
                    if (typeof value.required != 'undefined' && value.required) {
                        $('input[name="' + key + '"], select[name="' + key + '"]').prop('required', true).parent().find('label').addClass('required');
                    }
                });

                addEditForm.validate({
                    onkeyup: false,
                    ignore: [],
                    rules: rules,
                    messages: {
                        email: {
                            remote: "{{__("Email has already been taken.")}}"
                        },
                        mobile: {
                            regex: "{{__("Invalid Mobile number.")}}"
                        },
                        password_confirmation: {
                            equalTo: "{{__("Password didn't match.")}}"
                        },
                        user_type: {
                            required: "{{ __("User type is required.") }}"
                        }
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element) {

                        error.addClass("help-block");

                        element.parents(".form-group").addClass("has-feedback");

                        if (element.prop("type") === "checkbox") {
                            error.insertAfter(element.parent("label"));
                        } else if (element.hasClass('select2-ajax') || element.hasClass('select2') || element.hasClass('select2-ajax-custom')) {
                            error.insertAfter(element.parents(".form-group").find('.select2-container'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    success: function (label, element) {
                        console.log("success", $(element));
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        console.log("unhighlight", $(element));
                        $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                    },
                    submitHandler: function (form) {
                        $('#voyager-loader').show();
                        var formData = new FormData(form);
                        $.ajax({
                            url: addEditForm.attr('action'),
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData
                        })
                            .done((data) => {
                                toastr.success(data.message);
                                location.reload();
                            })
                            .fail((data) => {
                                data.responseJSON.errors !== undefined
                                    ? $.each(data.responseJSON.errors, (key, value) => toastr.error(value))
                                    : toastr.error(data.responseJSON.message);
                            })
                            .always(() => {
                                $('#voyager-loader').hide();
                            });
                    }
                });
            }
        });

        //let originalImage = $('#user_img').attr('src');

        function previewFile() {
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                $('#user_img').attr('src', reader.result)
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@stop

