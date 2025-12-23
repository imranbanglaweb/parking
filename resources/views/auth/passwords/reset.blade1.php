<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Admin - {{ Voyager::setting("admin.title") }}</title>
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif
    <style>
        body {
            background-image: url('{{ Voyager::image( Voyager::setting("admin.bg_image"), voyager_asset("images/inventory2.png") ) }}');
            background-color: {{ Voyager::setting("admin.bg_color", "#FFFFFF" ) }};
        }

        body.login .login-sidebar {
            border-top: 5px solid{{ config('voyager.primary_color','#22A7F0') }};
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
        .error{
            color: #CA3515;
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
<div class="container-fluid">
    <div class="row">
        <div class="faded-bg animated"></div>
        <div class="hidden-xs col-sm-7 col-md-8">
            <div class="clearfix">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="logo-title-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn"
                                 src="{{ voyager_asset('images/inventory-logo.png') }}" alt="Logo Icon">
                        @else
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn"
                                 src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                        <div class="copy animated fadeIn">
                            <h1>{{ Voyager::setting('admin.title', 'Voyager') }}</h1>
                            <p>{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

            <div class="login-container" style="top:40%">

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
                    <div class="form-group form-group-default" id="emailGroup">
                        <label>{{ __('voyager::generic.email') }}</label>
                        <div class="controls">
                            <input type="text" name="email" id="email" value="{{ $email ?? old('email') }}"
                                   class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group form-group-default" id="passwordGroup">
                        <label for="password">{{ __('voyager::generic.password') }}</label>
                        <div class="controls">
                            <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group form-group-default" id="">
                        <label for="password-confirm">{{ __('voyager::generic.retype_pass') }}</label>
                        <div class="controls">
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required autocomplete="new-password">
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
