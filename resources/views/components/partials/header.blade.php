<header id="zt-header" class="zt-header-main {{ request()->is('/') ? 'header-style-three' : 'header-style-two' }}  ">
    <div class="zt-header-three clearfix">
        <div class="container">
            <div class="zt-brand-logo float-left">
                <a href="{{ route('render.home') }}"><img src="{{ asset('frontend/assets/img/logo.png') }}"
                        alt="Zoom Group company logo"></a>
            </div>
            <div class="zt-header-cart-login float-right">
                <div class="my-account pr-3">
                    <a class="dropbtn"><i class="fas fa-user {{ request()->is('/') ? '' : 'text-dark' }}"></i></a>
                    <div class="dropdown-content">
                        @if (auth()->user())
                            <a href="{{ route('dashboard') }}"><i class="far mr-2 fa-address-card"></i>My account</a>
                            <a href="{{ route('profile.show') }}"><i class="far mr-2 fa-user"></i>Profile</a>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a class="logout-text" href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="zt-main-nav-wrap float-right">
                <nav class="zt-main-navigation ul-li">
                    <ul id="main-nav" class="navbar-nav text-capitalize clearfix">
                        <li>
                            <a href="{{ route('render.home') }}">Home</a>
                        </li>
                        <li><a href="#">About</a></li>
                        <li>
                            <a href="{{ route('render.course.list') }}">Courses</a>
                        </li>
                        <li>
                            <a href="#">Solutions</a>
                        </li>
                        <li>
                            <a href="{{ route('render.upcoming.batches') }}">Upcoming Schedule</a>
                        </li>
                        <li>
                            <a href="{{ route('render.news.list') }}">News</a>
                        </li>
                        <li>
                            <a href="{{ route('render.contact') }}">Conatct Us</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="zt-mobile-menu-wrap">
                <div class="zt-mobile_menu position-relative">
                    <div class="zt-mobile_menu_button zt-open_mobile_menu">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="zt-mobile_menu_wrap">
                        <div class="mobile_menu_overlay zt-open_mobile_menu"></div>
                        <div class="zt-mobile_menu_content">
                            <div class="zt-mobile_menu_close zt-open_mobile_menu">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="m-brand-logo text-center">
                                <a href="{{ route('render.home') }}"><img
                                        src="{{ asset('frontend/assets/img/logo.png') }}"
                                        alt="Zoom Group company logo"></a>
                            </div>
                            <nav class="zt-mobile-main-navigation  clearfix ul-li">
                                <ul id="m-main-nav" class="navbar-nav text-capitalize clearfix">
                                    <li>
                                        <a href="{{ route('render.home') }}">Home</a>
                                    </li>
                                    <li><a href="#">About</a></li>
                                    <li>
                                        <a href="{{ route('render.course.list') }}">Courses</a>
                                    </li>
                                    <li>
                                        <a href="#">Solutions</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('render.upcoming.batches') }}">Upcoming Schedule</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('render.news.list') }}">News</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('render.contact') }}">Conatct Us</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
