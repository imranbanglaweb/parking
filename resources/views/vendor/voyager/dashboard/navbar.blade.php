<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">

        <div class="navbar-header left" style="width: 250px;">
            <a class="navbar-brand" href="{{ route('voyager.dashboard') }}">
                <div class="logo-icon-container">
                    <?php $admin_logo_img = Auth::user()->station->header_logo;?>
                    @if($admin_logo_img == '')
                        <img src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                    @else
                        <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                    @endif
                </div>
                {{--<div class="title">{{ Voyager::setting('admin.title', '') }}</div>--}}
                <div class="title">
                    @if(strlen(Voyager::setting('admin.title', ''))<15)
                        {{ Voyager::setting('admin.title', '') }}
                    @else
                        {{ \Illuminate\Support\Str::limit(Voyager::setting('admin.title', ''), 13) }}
                    @endif
                </div>
            </a>
        </div><!-- .navbar-header -->
        <div class="navbar-header justify-content-md-center">
            <button class="hamburger breadcrumb back-btn badge-pill">
                <i class="fa fa-bars"></i>
            </button>
        </div>



        <ul class="nav justify-content-md-center top-right navbar-nav @if (config('voyager.multilingual.rtl')) navbar-left @else navbar-right @endif">
            <li class="nav-item">
                <div class="btn-group language">
                    <button onclick="document.getElementById('change_language').submit()" class="btn btn-sm btn-{{app()->getLocale() === 'en' ? 'primary': 'default'}} padding5 font-size-12 border-rad-left14">English</button>
                    <button onclick="document.getElementById('change_language').submit()"  class="btn btn-sm btn-{{app()->getLocale() === 'bn' ? 'primary': 'default'}} padding5 font-size-12 border-rad-right14">বাংলা</button>
                </div>
                <form method="post" action="{{route('change-language', app()->getLocale() === 'bn' ? 'en': 'bn')}}" id="change_language">
                    @csrf
                </form>
            </li>
{{--            <li class="dropdown dropdown-notification nav-item">--}}
{{--                <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="fa fa-envelope"></i><span class="badge badge-pill badge-warning badge-up">3</span></a>--}}
{{--                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">--}}
{{--                    <li class="dropdown-menu-header">--}}
{{--                        <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span><span class="notification-tag badge badge-warning float-right m-0">4 New</span></h6>--}}
{{--                    </li>--}}
{{--                    <li class="scrollable-container media-list"><a href="javascript:void(0)">--}}
{{--                            <div class="media">--}}
{{--                                <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span></div>--}}
{{--                                <div class="media-body">--}}
{{--                                    <h6 class="media-heading">Margaret Govan</h6>--}}
{{--                                    <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p><small>--}}
{{--                                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a><a href="javascript:void(0)">--}}
{{--                            <div class="media">--}}
{{--                                <div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span></div>--}}
{{--                                <div class="media-body">--}}
{{--                                    <h6 class="media-heading">Bret Lezama</h6>--}}
{{--                                    <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>--}}
{{--                                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time></small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a><a href="javascript:void(0)">--}}
{{--                            <div class="media">--}}
{{--                                <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span></div>--}}
{{--                                <div class="media-body">--}}
{{--                                    <h6 class="media-heading">Carie Berra</h6>--}}
{{--                                    <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>--}}
{{--                                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time></small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a><a href="javascript:void(0)">--}}
{{--                            <div class="media">--}}
{{--                                <div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span></div>--}}
{{--                                <div class="media-body">--}}
{{--                                    <h6 class="media-heading">Eric Alsobrook</h6>--}}
{{--                                    <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p><small>--}}
{{--                                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time></small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a></li>--}}
{{--                    <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="fa fa-bell"></i><span class="badge badge-pill badge-danger badge-up">{{$notifications->count()}}</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span><span class="notification-tag badge badge-danger float-right m-0">{{$notifications->count()}} New</span></h6>
                    </li>
                    <li class="scrollable-container media-list">
                        @foreach($notifications as $notification)
                            <a href="{{$notification->data['url']}}?read_notification={{$notification->id}}">
                                <div class="media">
                                    <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                                    <div class="media-body">
                                        <h6 class="media-heading">{{$notification->data['title']}}</h6>
                                        <p class="notification-text font-small-3 text-muted">{{$notification->data['body']}}</p><small>
                                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{{$notification->created_at->toDayDateTimeString()}}</time></small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </li>
{{--                    <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>--}}
                </ul>
            </li>

            <li class="dropdown dropdown-user nav-item">
                <a href="#" class="dropdown-toggle"
                        type="" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <img src="{{ $user_avatar }}" class="profile-img"> {{ app('VoyagerAuth')->user()->name }}<span
                        class="caret"></span>
                </a>
                <ul class="dropdown-menu popup" aria-labelledby="dropdownMenu1">
                    <li class="dropdown-item profile-img">
                        <img src="{{ $user_avatar }}" class="profile-img">
                        <div class="profile-body">
                            <h5>{{ app('VoyagerAuth')->user()->name }}</h5>
                            <h6>{{ app('VoyagerAuth')->user()->email }}</h6>
                        </div>
                    </li>
                    <li class="dropdown-item divider"></li>
                    <?php $nav_items = config('voyager.dashboard.navbar_items'); ?>
                    @if(is_array($nav_items) && !empty($nav_items))
                        @foreach($nav_items as $name => $item)
                            <li {!! isset($item['classes']) && !empty($item['classes']) ? 'class="'.$item['classes'].'"' : '' !!}>
                                @if(isset($item['route']) && $item['route'] == 'voyager.logout')
                                    <form action="{{ route('voyager.logout') }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-block">
                                            @if(isset($item['icon_class']) && !empty($item['icon_class']))
                                                <i class="{!! $item['icon_class'] !!}"></i>
                                            @endif
                                            {{__($name)}}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ isset($item['route']) && Route::has($item['route']) ? route($item['route']) : (isset($item['route']) ? $item['route'] : '#') }}" {!! isset($item['target_blank']) && $item['target_blank'] ? 'target="_blank"' : '' !!}>
                                        @if(isset($item['icon_class']) && !empty($item['icon_class']))
                                            <i class="{!! $item['icon_class'] !!}"></i>
                                        @endif
                                        {{__($name)}}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>
