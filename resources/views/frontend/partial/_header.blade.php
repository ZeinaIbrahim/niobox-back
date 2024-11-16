<header id="header">
    <div id="header-logo">
        @php($logo = Helpers::get_business_settings('logo'))
        <a href="{{ route('home') }}" aria-label="">
            <img src="{{ Helpers::onErrorImage(
                        $logo,
                        asset('storage/app/public/ecommerce') . '/' . $logo,
                        asset('public/assets/admin/img/160x160/img2.jpg'),
                        'ecommerce/') }}"
                 alt="{{ translate('Logo') }}">
        </a>
    </div>
    <div id="header-search">
        <input type="text" />
    </div>
    <div id="header_menu">
        <a href="{{ route('frontend-store') }}">
            <div class="mobile-menu-item">
                <p>store</p>
            </div>
        </a>

        {{-- Check if the user is authenticated via the web guard --}}
        @if(Auth::guard('web')->check())
            <a href="{{ route('frontend-dashboard') }}">
                <div class="mobile-menu-item">
                    <p>dashboard</p>
                </div>
            </a>
        @else
            <a href="{{ route('frontend-login') }}">
                <div class="mobile-menu-item">
                    <p>login</p>
                </div>
            </a>
        @endif
    </div>
</header>
