<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}"><!-- Basic -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Site Metas -->
    <title>Admin - {{ Voyager::setting("admin.title") }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Site Icons -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ asset('backend_resources/images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
@endif

<!-- Bootstrap CSS -->
    <link href="{{ voyager_asset('login/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('login/css/style.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('login/css/all.min.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('login/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ voyager_asset('login/toster/index.css') }}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .container{margin-top: 0vh}
    </style>
</head>

<body>
<div id="particles-js" class="main-form-box">
    <div class="md-form">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="panel panel-login">
                        <div class="logo-top">
                            <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                            @if($admin_logo_img == '')
                                <a href="#"><img style="width:15%" src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="" /></a>
                            @else
                                <a href="#"><img style="width:15%" src="{{ Voyager::image($admin_logo_img) }}" alt="" /></a>
                            @endif
                        </div>
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-xl-12">
                                    <a href="#" id="register-form-link">Verify Your Account</a>
                                </div>
                            </div>
                        </div>
                        @if(!$errors->isEmpty())
                            <div class="alert alert-red">
                                <ul class="list-unstyled">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form class="form-edit-add" id="otp-form" action="{{ route('verification') }}" method="post" enctype="multipart/form-data" role="form" style="display: block;">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="icon-lp"><i class="fas fa-user-tie"></i></label>
                                            <input style="display:none" type="text" name="email" id="email" value="{{ $user?$user->email:'' }}" tabindex="1" class="form-control" required>
                                            <input type="text" name="otp" id="otp" value="{{ old('otp') }}" tabindex="1" class="form-control" placeholder="{{ __('voyager::generic.otp') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 offset-sm-0">
                                                    <input type="submit" name="otp-submit" id="otp-submit" tabindex="4" class="form-control btn btn-login otpsignin" value="{{ __('Submit') }}">
                                                </div>
                                                <div class="col-sm-6 offset-sm-0">
                                                    <input type="button" name="resend-otp" id="resend-otp" tabindex="4" class="form-control btn btn-login otpsignin" value="{{ __('Resend') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="{{route('voyager.login')}}" tabindex="5" class="forgot-password">back to login</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--					<p class="footer-company-name">All Rights Reserved. &copy; 2018 <a href="#">Login Register</a> Design By : <a href="https://html.design/">html design</a></p>-->

                </div>
            </div>
        </div>
    </div>

</div>


<script src="{{ voyager_asset('login/js/jquery.min.js') }}"></script>
<script src="{{ voyager_asset('login/js/bootstrap.min.js') }}"></script>
<script src="{{ voyager_asset('login/js/particles.min.js') }}"></script>
<script src="{{ voyager_asset('login/js/index.js') }}"></script>
<script type="text/javascript" src="{{ voyager_asset('js/form.js') }}"></script>
<script src="{{ asset('/backend_resources/js/jquery_validation_combine.js') }}"></script>
<script src="{{ asset('/backend_resources/js/validation_localization_bn.js') }}"></script>
<script src="{{ voyager_asset('login/toster/index.js') }}"></script>
<script src="{{ voyager_asset('login/toster/script.js') }}"></script>
<script type="text/javascript">
    $('.form-group input').focus(function () {
        $(this).parent().addClass('addcolor');
    }).blur(function () {
        $(this).parent().removeClass('addcolor');
    });

</script>
<script>
    $('document').ready(function () {

        /* Adding Jquery Validation rules  */

        jQuery.extend(jQuery.validator.messages, {
            required: "{{__('This field is required.')}}",
            email: "Email is required",
        });

        $.validator.addMethod(
            "regex",
            function (value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "{{__("Invalid Input")}}"
        );

        var addEditForm = $('form.form-edit-add');

        if (addEditForm.length) {
            var rules = {
                email: {
                    "required": true,
                    "email": true,
                },
                otp: {
                    required: true
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
                        required: "{{__("Email is required")}}"
                    },
                    otp: {
                        required: "{{__("Otp is required")}}"
                    }
                },
                errorElement: "em",
                errorPlacement: function (error, element) {

                    error.addClass("help-block");

                    element.parents(".form-group").addClass("has-feedback");

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
                            console.log(data);
                            toastada.success(data.message);
                            window.location.href='{{route('voyager.login')}}';
                            // location.reload();
                        })
                        .fail((data) => {
                            data.responseJSON.errors !== undefined
                                ? $.each(data.responseJSON.errors, (key, value) => toastada.error(value))
                                : toastada.error(data.responseJSON.message);
                        })
                        .always(() => {
                            $('#voyager-loader').hide();
                        });
                }
            });
        }
    });

    $(document).on('click', '#resend-otp', function () {

        let email = $('#email').val();
        if (!confirm('{{__('Are you sure you want to resend verification code ?')}}')) {
            return false;
        }
        $(this).attr("disabled", true);
        $.ajax({
            data: {
                email: email,
            },
            url: '{{route('resendOtp')}}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
        })
            .done((data) => {
                console.log(data);
                toastada.success(data.message);
                //window.location.href='{{route('voyager.login')}}';
                //location.reload();
            })
            .fail((data) => {
                data.responseJSON.errors !== undefined
                    ? $.each(data.responseJSON.errors, (key, value) => toastada.error(value))
                    : toastada.error(data.responseJSON.message);
            })
            .always(() => {
                $('#voyager-loader').hide();
            });

    })
</script>
</body>
</html>

