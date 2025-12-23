@component('mail::layout')
    {{-- Header --}}
    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="<?php echo Voyager::image($admin_logo_img); ?>" alt="Logo"><br>
            {{ Voyager::setting('admin.title', '') }} <br>
            {{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }}   @lang('স্বাস্থ্য শিক্ষা ও পরিবার কল্যাণ বিভাগ')
        @endcomponent
    @endslot
@endcomponent
