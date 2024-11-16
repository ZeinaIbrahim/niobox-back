<section id="mobile-menu">
    <a href="{{route('home')}}">
        <div class="mobile-menu-item">

                <p>
                home
                </p>


        </div>
    </a>
    <a href="{{route('frontend-store')}}">
        <div class="mobile-menu-item">

                <p>
                store
                </p>


        </div>
    </a>
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
</section>
