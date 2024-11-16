<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    @php($icon = \App\Model\BusinessSetting::where(['key' => 'fav_icon'])->first()->value)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/app/public/ecommerce/' . $icon ?? '') }}">
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/icon-set/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/color.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/image-loading.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/home.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/mobile-menu.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/banner.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/category.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/latest-product.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/store.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/featered-category.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/cart.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/auth.css')}}">
    @stack('css_or_js')
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/toastr.css')}}">

</head>
<body id="body-frontend">
    @include('frontend.partial._header')
    <main id="body-content" role="main" class="main pointer-event">
        <div id="body-content-container">
            @yield('content')
            @include('frontend.partial._footer')
            @include('frontend.partial.mobile-menu')
        </div>
    </main>

    @stack('script')
    <script src="{{asset('public/assets/admin/js/toastr.js')}}"></script>
    {!! Toastr::message() !!}
    @if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
    @endif
    @stack('script_2')
    <script src="{{asset('public/assets/frontend/js/cart.js')}}"></script>
    <script src="{{asset('public/assets/frontend/js/wish-list.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.image-load');
            images.forEach(img => {
                img.addEventListener('load', () => {
                    img.classList.add('loaded');
                    const placeholder = img.previousElementSibling;
                    if (placeholder && placeholder.classList.contains('image-placeholder')) {
                        placeholder.style.display = 'none';
                    }
                });
                if (img.complete) {
                    img.classList.add('loaded');
                    const placeholder = img.previousElementSibling;
                    if (placeholder && placeholder.classList.contains('image-placeholder')) {
                        placeholder.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>

</html>
