<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Admin - {{ Voyager::setting("admin.title") }}</title>
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif
    <style>


        body.login .login-sidebar {
            border-top: 0px;
            min-height: 100%;
            display: flex;
            align-items: center;
        }
        hr{
            border:1px solid #2A3948;
            margin-left:30px ;
            margin-right:30px ;
            opacity:0.7;
        }
        @media (max-width: 767px) {
            body.login .login-sidebar {
                border-top: 0px !important;
                border-left: 5px solid{{ config('voyager.primary_color','#22A7F0') }};
            }
        }

        body.login .form-group-default.focused {
            border-color: {{ config('voyager.primary_color','#22A7F0') }};
        }

        .login-button, .bar:before, .bar:after {
            background: {{ config('voyager.primary_color','#22A7F0') }};
        }

        .remember-me-text {
            padding: 0 5px;
        }

        .required {
            color: #CA3515;
        }

        .error {
            color: #CA3515;
        }

        /* enable absolute positioning */
        .inner-addon {
            position: relative;
            border: 1px solid #dee5ed;
            border-radius: 5px;
        }

        /* style glyph */
        .inner-addon .glyphicon {
            position: absolute;
            padding: 10px;
            pointer-events: none;
        }

        /* align glyph */
        .left-addon .glyphicon  { left:  0px;}
        .right-addon .glyphicon { right: 0px;}

        /* add padding  */
        .left-addon input  { padding-left:  30px; }
        .right-addon input { padding-right: 30px; }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 login-sidebar">

            <div class="login-container">
                <div class="">
                    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                    @if($admin_logo_img == '')
                        <div class="text-center">
                            <img class=""
                                 src="{{ voyager_asset('images/inventory-logo.png') }}" alt="Logo Icon">
                        </div>
                    @else
                        <div class="text-center">
                            <img class=""
                                 src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        </div>
                    @endif
                    <div class="copy">
                        <h1>{{ __('স্বাস্থ্য শিক্ষা ও পরিবার কল্যাণ বিভাগ') }}</h1>
                        <p>{{ Voyager::setting('admin.title', 'Voyager') }}</p>
{{--                        <p>{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>--}}
                    </div>
                </div> <!-- .logo-title-container -->

                {{--                <h4>{{ __('voyager::login.signin_below') }}</h4>--}}
                @if(!$errors->isEmpty())
                    <div class="alert alert-red">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group" id="emailGroup">
                        <div class="inner-addon left-addon controls">
                            <i class="glyphicon glyphicon-envelope"></i>
                            <input type="email" required class="form-control" name="email" id="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('voyager::generic.email') }}" />
                        </div>
                    </div>

                    <div class="form-group" id="passwordGroup">
                        <div class="inner-addon left-addon controls">
                            <i class="glyphicon glyphicon-lock"></i>
                            <input type="password" required class="form-control" name="password" value="{{ old('user_name') }}" placeholder="{{ __('voyager::generic.password') }}" />
                        </div>
                    </div>
                    <div class="form-group" id="password-confirm">
                        <div class="inner-addon left-addon controls">
                            <i class="glyphicon glyphicon-lock"></i>
                            <input type="password" required class="form-control" id="password-confirm" name="password_confirmation" placeholder="{{ __('voyager::generic.retype_pass') }}" autocomplete="new-password" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block login-button">
                        <span class="signingin hidden"><span class="voyager-refresh"></span> {{ __('voyager::login.loggingin') }}...</span>
                        <span class="signin">{{ __('voyager::generic.pass_reset') }}</span>
                    </button>
                </form>

                <div style="clear:both"></div>


            </div> <!-- .login-container -->

        </div> <!-- .login-sidebar -->

        <div class="hidden-xs col-sm-6 col-md-6 logo-bg">
            <div class="clearfix">
                <img style="height:100vh;width:100%"
                     src="{{ Voyager::image( Voyager::setting("admin.bg_image"), voyager_asset("images/inventory2.png") ) }}"/>
            </div>
        </div>
    </div> <!-- .row -->
</div> <!-- .container-fluid -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    var email = document.querySelector('[name="email"]');
    var password = document.querySelector('[name="password"]');
    btn.addEventListener('click', function (ev) {
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    email.focus();
    document.getElementById('emailGroup').classList.add("focused");

    // Focus events for email and password fields
    email.addEventListener('focusin', function (e) {
        document.getElementById('emailGroup').classList.add("focused");
    });
    email.addEventListener('focusout', function (e) {
        document.getElementById('emailGroup').classList.remove("focused");
    });

    password.addEventListener('focusin', function (e) {
        document.getElementById('passwordGroup').classList.add("focused");
    });
    password.addEventListener('focusout', function (e) {
        document.getElementById('passwordGroup').classList.remove("focused");
    });
    $("#password_reset_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            email: {
                required: "ই-মেইল অবশ্যই দিতে হবে।",
                email: "সঠিক ই-মেইল প্রদান করুন। "
            }

        },
        submitHandler: function (form) {
            $.ajax({
                url: "{{route('password.email')}}",
                type: "POST",
                data: $('#password_reset_form').serialize(),
                success: function (data,status) {
                    console.log(status)
                    if (status=='success') {
                        $("#password_reset_form").trigger("reset");
                        $('.alert-success').html('');
                        $('.alert-success').append('<p>' + 'আপনার ই-মেইল এ একটি লিংক পাঠানো হয়েছে। লিংক এ ক্লিক করে আপনার নতুন পাসওয়ার্ড সেট করুন। ' + '</p>');
                        $('.alert-success').show();

                    }
                    setTimeout(() => {
                        $('.alert-success').fadeOut(1000);
                        $('#forgot_password_modal').modal('hide');
                    }, 5000);

                },
                error: function (data) {
                    console.log(data);
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
</script>
</body>
</html>
