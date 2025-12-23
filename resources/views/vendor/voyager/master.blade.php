<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <title>@yield('page_title', setting('admin.title') . " - " . setting('admin.description'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
   
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ asset('/public/backend_resources/images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif

<!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('/public/backend_resources/css/app.css') }}">

    <style>
        .kalpurush {
            font-family: 'kalpurush', sans-serif;
        }
        @if(app()->getLocale() === 'bn')
        html, body
        {
            font-family: 'kalpurush', sans-serif;
        }
        .login-container p, .login-button, .navbar > .container .navbar-brand, .navbar > .container-fluid .navbar-brand,
        .navbar .navbar-breadcrumb > li,
        .navbar .navbar-nav > li > a,
        .navbar .dropdown-menu .title,
        .navbar .dropdown-menu .message,
        .navbar .dropdown.profile .dropdown-menu .profile-info,
        .app-container .app-footer,
        .app-container .content-container .side-menu .navbar-header .navbar-brand,
        .app-container .content-container .side-menu .navbar-nav li a,
        .sub-title,
        .sub-title .description,
        .card .card-header .card-title .title,
        .card.summary-inline .card-body .content .title,
        .card.summary-inline .card-body .content .sub-title,
        .btn,
        .modal .modal-dialog .modal-header,
        .landing-page,
        .landing-page .navbar .navbar-header .navbar-brand
        {
            font-family: 'kalpurush', sans-serif;
        }
        @endif
    </style>

    @yield('css')

    <!-- Few Dynamic Styles -->
    <style type="text/css">
        .voyager .side-menu .navbar-header {
            background: {{ config('voyager.primary_color','#22A7F0') }};
            border-color: {{ config('voyager.primary_color','#22A7F0') }};
        }
    </style>

    <script>
        window.formValidatorConfig = {
            errorPlacement: function (error, e) {
                e.parents('.form-group').append(error);
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-success').addClass('has-error');
                $(e).closest('.help-block').remove();
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            }
        };
    </script>
    @yield('head')
</head>

<body class="voyager @if(isset($dataType) && isset($dataType->slug)){{ $dataType->slug }}@endif">

<div id="voyager-loader">
    <?php $admin_loader_img = Voyager::setting('admin.loader', ''); ?>
    @if($admin_loader_img == '')
        <img src="{{ voyager_asset('images/logo-icon.png') }}" alt="Voyager Loader">
    @else
        <img src="{{ Voyager::image($admin_loader_img) }}" alt="Voyager Loader">
    @endif
</div>

<?php
if (\Illuminate\Support\Str::startsWith(app('VoyagerAuth')->user()->avatar, 'http://') || \Illuminate\Support\Str::startsWith(app('VoyagerAuth')->user()->avatar, 'https://')) {
    $user_avatar = Voyager::image(auth()->user()->avatar);
} else {
    $user_avatar = Voyager::image(auth()->user()->avatar);
}
?>

<div class="app-container">
    <div class="fadetoblack visible-xs"></div>
    <div class="row content-container">
        @include('voyager::dashboard.navbar')
        @include('voyager::dashboard.sidebar')
        <script>
            (function () {
                var appContainer = document.querySelector('.app-container'),
                    sidebar = appContainer.querySelector('.side-menu'),
                    navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                    loader = document.getElementById('voyager-loader'),
                    hamburgerMenu = document.querySelector('.hamburger'),
                    sidebarTransition = sidebar.style.transition,
                    navbarTransition = navbar.style.transition,
                    containerTransition = appContainer.style.transition;


                sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
                    appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                        navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

                if(window.localStorage['voyager.stickySidebar'] === undefined) {
                    window.localStorage['voyager.stickySidebar'] = true;
                }

                if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] == 'true') {
                    appContainer.className += ' expanded no-animation';
                    loader.style.left = (sidebar.clientWidth / 2) + 'px';
                    hamburgerMenu.className += ' is-active no-animation';
                }

                navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
                sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
                appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
            })();
        </script>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body padding-top">
                @yield('page_header')
                <div id="voyager-notifications"></div>
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('voyager::partials.app-footer')

<!-- Javascript Libs -->
<script type="text/javascript" src="{{ asset('/public/backend_resources/js/app.js') }}"></script>
<script>
    @if(Session::has('alerts'))
        let alerts = {!! json_encode(Session::get('alerts')) !!};
        helpers.displayAlerts(alerts, toastr);
    @endif

    @if(Session::has('message'))

    // TODO: change Controllers to use AlertsMessages trait... then remove this
    var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
    var alertMessage = {!! json_encode(Session::get('message')) !!};
    var alerter = toastr[alertType];

    if (alerter) {
        alerter(alertMessage);
    } else {
        toastr.error("toastr alert-type " + alertType + " is unknown");
    }
    @endif
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.extend( true, $.fn.dataTable.defaults, {
        "language" : @json(__('datatable.meta')),
        "processing" : true,
        "ordering" : true,
        "searching" : true,
        "autoWidth": false,
        "order" : [[ 1, 'asc' ]]
    });

    $(function(){
        $('.bootstrap-datetimepicker').datetimepicker({
            // viewMode: 'months',
            format: 'YYYY-MM-DD HH:mm:ss',
            allowInputToggle: true,
        });
    });
</script>

@yield('media_manager')
@yield('javascript')
@stack('javascript')
@yield('validation', '')

</body>
</html>
