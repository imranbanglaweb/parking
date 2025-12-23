<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">


            {{--<div class="panel widget center bgimage"
                 style="background-image:url({{ Voyager::image( Voyager::setting('admin.bg_image'), voyager_asset('images/bg.jpg') ) }}); background-size: cover; background-position: 0px;">
                <div class="dimmer"></div>
                <div class="panel-content">
                    <img src="{{ $user_avatar }}" class="avatar" alt="{{ app('VoyagerAuth')->user()->name }} avatar">
                    <h4>{{ ucwords(app('VoyagerAuth')->user()->name) }}</h4>
                    <p>{{ app('VoyagerAuth')->user()->email }}</p>

                    <a href="{{ route('voyager.profile') }}" class="btn btn-primary">{{ __('voyager::generic.profile') }}</a>
                    <div style="clear:both"></div>
                </div>
            </div>--}}

        </div>
        <div id="adminmenu">
            <admin-menu :items="{{ localizedMenu('admin', '_json') }}"></admin-menu>
        </div>
    </nav>
</div>
