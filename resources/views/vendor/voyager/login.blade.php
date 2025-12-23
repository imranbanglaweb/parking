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
        <link rel="shortcut icon" href="{{ asset('/public/backend_resources/images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif

    <!-- Bootstrap CSS -->
    <link href="{{ asset('/public/backend_resources/login/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- Site CSS -->
    <link rel="stylesheet" href="{{ asset('/public/backend_resources/login/css/style.css') }}">
	<!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('/public/backend_resources/login/css/all.min.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('/public/backend_resources/login/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/backend_resources/login/toster/index.css') }}">

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
<!--						<div class="logo-top">
                                                     <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                                                        @if($admin_logo_img == '')
                                                        <a href="#"><img style="width:15%" src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="" /></a>
                                                        @else
                                                        <a href="#"><img style="width:15%" src="{{ Voyager::image($admin_logo_img) }}" alt="" /></a>
                                                        @endif
						</div>-->
						<div class="panel-heading">
							<div class="row">
								<div class="col-lg-12 col-sm-12 col-xl-12">
									<a href="#" class="active" id="login-form-link">Parking Management System</a>
								</div>
<!--								<div class="col-lg-6 col-sm-6 col-xl-6">
									<a href="#" id="register-form-link">Register</a>
								</div>
								<div class="or">OR</div>-->
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
									<form id="login-form" action="{{ route('voyager.login') }}" method="post" role="form" style="display: block;">
                                         {{ csrf_field() }}
										<div class="form-group">
											<label class="icon-lp"><i class="fas fa-user-tie"></i></label>
											<input type="email" name="email" id="email" value="{{ old('email') }}" tabindex="1" class="form-control" placeholder="{{ __('voyager::generic.email') }}" required>
										</div>
										<div class="form-group">
											<label class="icon-lp"><i class="fas fa-key"></i></label>
											<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="{{ __('voyager::generic.password') }}" required>
										</div>
										<div class="che-box">
											<label class="checkbox-in">
                                                                                            <input name="remember" type="checkbox" tabindex="3" id="remember" value="1"> <span></span>
												{{ __('voyager::generic.remember_me') }}
											</label>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 offset-sm-3">
													<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login signin" value="{{ __('voyager::generic.login') }}">
												</div>
											</div>
										</div>
<!--										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">
													<div class="text-center">
														<a data-toggle="modal" data-target="#forgot_password_modal" tabindex="5" class="forgot-password">Forgot Password?</a>
													</div>
												</div>
											</div>
										</div>-->
									</form>
									<form class="form-edit-add" id="register-form" action="{{ route('register') }}" method="post" role="form" style="display: none;">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="icon-lp"><i class="fas fa-user-tie"></i></label>
                                            <input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Full Name" value="" required="">
                                        </div>
										<div class="form-group">
											<label class="icon-lp"><i class="fas fa-envelope"></i></label>
											<input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="" required="">
										</div>
                                        <div class="form-group">
                                            <label class="icon-lp"><i class="fas fa-phone"></i></label>
                                            <input type="text" name="mobile" id="mobile" tabindex="1" class="form-control" placeholder="Email Mobile Number" pattern="^(\+88)?01[1-9][0-9]{8}$" value="" required="">
                                        </div>

										<div class="form-group">
											<label class="icon-lp"><i class="fas fa-key"></i></label>
											<input type="password" name="password" id="password_r" tabindex="2" class="form-control" placeholder="Password" required="">
										</div>
										<div class="form-group">
											<label class="icon-lp"><i class="fas fa-key"></i></label>
											<input type="password" name="password_confirmation" id="password_confirmation" tabindex="2" class="form-control" placeholder="Confirm Password" required="">
										</div>
{{--										<div class="che-box">--}}
{{--											<label class="checkbox-in">--}}
{{--												<input name="checkbox" type="checkbox"> <span></span>I agree to the <a href="#"> Terms and Conditions </a> and <a href="#">Privacy Policy </a>--}}
{{--											</label>--}}
{{--										</div>--}}

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 offset-sm-3">
													<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
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

<!-- Forgot password Modal -->
<div class="modal" id="forgot_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #eee;">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('voyager::generic.password_forgot_heading') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="password_reset_form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="alert alert-success" style="display:none"></div>
                    <div class="row">
                        <div class="form-group row col-md-12">
                            <label class="col-sm-3 col-form-label" for="email">{{ __('voyager::generic.email') }} <span
                                    class="required">&#42;</span></label>
                            <div class="col-sm-9">
                                <input style="border:1px solid #ddd" name="email" type="email" class="form-control"

                                       value="{{ old('email') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: snow;text-align: center">
                    <button type="reset" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('voyager::generic.close') }}</button>
                    <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.send_email') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{ asset('/public/backend_resources/login/js/jquery.min.js') }}"></script>
<script src="{{ asset('/public/backend_resources/login/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/public/backend_resources/login/js/particles.min.js') }}"></script>
<script src="{{ asset('/public/backend_resources/login/js/index.js') }}"></script>
<script src="{{ asset('/public/backend_resources/js/form.js') }}"></script>
<script src="{{ asset('/public/backend_resources/js/jquery_validation_combine.js') }}"></script>
<script src="{{ asset('/public/backend_resources/js/validation_localization_bn.js') }}"></script>
<script src="{{ asset('/public/backend_resources/login/toster/index.js') }}"></script>
<script src="{{ asset('/public/backend_resources/login/toster/script.js') }}"></script>
	<script type="text/javascript">
		$(function() {
			$('#login-form-link').click(function(e) {
				$("#login-form").delay(100).fadeIn(100);
				$("#register-form").fadeOut(100);
				$('#register-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});
			$('#register-form-link').click(function(e) {
				$("#register-form").delay(100).fadeIn(100);
				$("#login-form").fadeOut(100);
				$('#login-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});
		});

		$('.form-group input').focus(function () {
			$(this).parent().addClass('addcolor');
		}).blur(function () {
			$(this).parent().removeClass('addcolor');
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
                    required: "{{__('voyager::generic.email_required')}}",
                    email: "{{__('voyager::generic.valid_email')}}"
                }

            },
            submitHandler: function (form) {
                $('.reset').removeClass('hidden');
                $('.save').addClass('hidden');
                $.ajax({
                    url: "{{route('password.email')}}",
                    type: "POST",
                    data: $('#password_reset_form').serialize(),
                    success: function (data, status) {
                        if (status == 'success') {
                            $("#password_reset_form").trigger("reset");
                            $('.alert-success').html('');
                            $('.alert-success').append('<p>' + 'A link has been sent to your email. Click the link to set your new password.' + '</p>');
                            $('.alert-success').show();
                            $('.reset').addClass('hidden');
                            $('.save').removeClass('hidden');

                        }
                        setTimeout(() => {
                            $('.alert-success').fadeOut(1000);
                            $('#forgot_password_modal').modal('hide');
                        }, 5000);

                    },
                    error: function (data) {
                        console.log(data.status);
                        $('.alert-danger').html('');
                        if(data.status==403) {
                            $('.alert-danger').append('<p>' + data.responseJSON.message + '</p>');
                        }else{
                            $('.alert-danger').append('<p>' + 'Internal Server Error' + '</p>');
                        }
                        $('.alert-danger').show();
                        $('.reset').addClass('hidden');
                        $('.save').removeClass('hidden');
                        $.each(data.responseJSON.errors, function (key, value) {
                            $('.alert-danger').html('');
                            $('.alert-danger').append('<p>' + value + '</p>');
                            $('.alert-danger').show();
                            $('.reset').addClass('hidden');
                            $('.save').removeClass('hidden');
                        });
                        setTimeout(() => {
                            $('.alert-danger').fadeOut(1000);
                        }, 5000);
                    }
                });
            }
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
                name: {
                    "required": true,
                    "minlength": 2
                },
                email: {
                    "required": true,
                    "email": true,
                },
                mobile: {
                    "required": true,
                    "regex": "^01[1-9][0-9]{8}$",
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    equalTo: "#password_r"
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
                    name: {
                        required: "{{__("Name is required")}}"
                    },
                    email: {
                        required: "{{__("Email is required")}}"
                    },
                    mobile: {
                        required: "{{__("Mobile number is required.")}}",
                        regex: "{{__("Invalid Mobile number.")}}"
                    },
                    password_confirmation: {
                        equalTo: "{{__("Password didn't match.")}}"
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
                            console.log(data);
                            toastada.success(data.message);
                            var slug=data.user_id;
                            var url = '{{ route("verify", ":slug") }}';
                            url = url.replace(':slug', slug);
                            window.location.href=url;
                        })
                        .fail((data) => {
                            data.responseJSON.errors !== undefined
                                ? $.each(data.responseJSON.errors, (key, value) => toastada.error(value))
                                : toastada.error(data.responseJSON.message);;
                        })
                        .always(() => {
                            $('#voyager-loader').hide();
                        });
                }
            });
        }
    });
</script>
</body>
</html>

