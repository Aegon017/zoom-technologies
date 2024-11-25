<header id="zt-header" class="zt-header-main {{ request()->is('/') ? 'header-style-three' : 'header-style-two' }}  ">
    <div class="zt-header-three clearfix">
        <div class="container">
            <div class="zt-brand-logo float-left">
                <a href="{{ route('render.home') }}"><img src="{{ asset('frontend/assets/img/logo.png') }}"
                        alt="Zoom Group company logo"></a>
            </div>
            <div class="zt-header-cart-login float-right">
                <li class="nav-item dropdown list-style-none">
                    <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user home-icon-user {{ request()->is('/') ? 'text-light' : 'text-dark' }}"></i>
                    </a>
                    <div class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown">
                        @auth
                            <a class="dropdown-item" href="{{route('render.myOrders')}}" style="padding-left: 19px"><i
                                    class="fas fa-shopping-cart"></i> My Orders</a>
                            <a class="dropdown-item" href="{{route('render.myOrders')}}"><i class="fas fa-bookmark"></i> My Courses</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-book"></i> Study Material</a>
                            <x-student-courses />
                            <a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-id-badge"></i>
                                Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" @click.prevent="$root.submit();"><i
                                        class="fas fa-sign-out-alt"></i> Logout</a>
                            </form>
                        @endauth
                        @guest
                            <a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>
                                Login</a>
                        @endguest
                    </div>
                </li>
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
                            <a href="https://www.zoomcybersense.com" target="_blank">Solutions</a>
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
                                        <a href="https://www.zoomcybersense.com" target="_blank">Solutions</a>
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
