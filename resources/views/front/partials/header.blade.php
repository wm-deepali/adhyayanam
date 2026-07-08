@if (trim($__env->yieldContent('header')))
    @yield('header')
@endif
@php
    $headerSettings = App\Models\HeaderSetting::first();
    $pageCategories = Helper::getPageCategories();
    $examinationCommission = App\Models\ExaminationCommission::with('categories.subCategories')->get();
@endphp
<meta name="google" content="notranslate">
<!-- Stylesheets -->
<style>
    /* Unified mega menu styles for all dropdowns */
    .dropdown {
        position: relative;
    }

    .main-header .main-menu .navigation {
        position: static;
    }

    /* ==================== FIX: SIMPLE DROPDOWN (About Us, Student Corner etc.) ==================== */
    .main-header .main-menu .navigation>li.dropdown>ul {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 220px;
        background: #fff;
        z-index: 1001;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        border-top: 2px solid orange;
        padding: 8px 0;
        margin: 0;
        list-style: none;
    }

    .main-header .main-menu .navigation>li.dropdown>ul>li {
        display: block;
        float: none;
        margin: 0;
    }

    .main-header .main-menu .navigation>li.dropdown>ul>li>a {
        display: block;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        white-space: nowrap;
    }

    .main-header .main-menu .navigation>li.dropdown>ul>li>a:hover {
        background: #fdf3e7;
        color: orange;
    }

    .mega-menu-container {
        display: none;
        position: fixed;
        left: 0;
        top: 210px;
        /* fallback 107px */
        width: 100vw;
        background: #fff;
        z-index: 1000;
        border-top: 2px solid orange;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }



    .mega-menu-left {
        width: 20%;
        background: #f9f9f9;
        border-right: 1px solid #ddd;
        overflow-y: auto;
        height: 100vh;

        /* Firefox */
        scrollbar-width: thin;
        scrollbar-color: #999 #f1f1f1;
        padding-bottom: 20px
    }

    /* Chrome, Edge, Safari */
    .mega-menu-left::-webkit-scrollbar {
        width: 6px;
    }

    .mega-menu-left::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .mega-menu-left::-webkit-scrollbar-thumb {
        background: #999;
        border-radius: 10px;
    }

    .mega-menu-left::-webkit-scrollbar-thumb:hover {
        background: #777;
    }


    .mega-menu-tab {
        padding: 15px 20px;
        cursor: pointer;
        font-weight: 600;
        border-bottom: 1px solid #eee;
    }

    .mega-menu-tab:hover,
    .mega-menu-tab.active {
        background: orange;
        color: #fff;
    }


    /* --- Fix Mega Menu UI (Restores old look but keeps new working script) --- */
    .mega-menu-right {
        width: 80%;
        padding: 20px;
        max-height: 400px;
        /* Set a fixed height for the right panel */
        overflow-y: auto;
        /* Enable vertical scrolling */
        display: grid;
        /* Use CSS Grid for layout */
        /*grid-template-columns: repeat(3, 1fr); */
        gap: 20px;
        /* Space between grid items */
    }

    .mega-menu-panel {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
    }

    .mega-menu-panel.active {
        opacity: 1;
        visibility: visible;
        position: relative;
    }

    .dropdown.active .mega-menu-container {
        display: flex !important;
    }

    .mega-menu-panel h5 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .mega-menu-panel ul {
        list-style: none;
        padding: 0;
    }

    .mega-menu-panel ul li {
        margin-bottom: 5px;
    }

    .mega-menu-panel ul li a {
        text-decoration: none;
        color: #333;
    }

    .mega-menu-panel ul li a:hover {
        color: orange;
    }

    .mega-menu-panel {
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .mega-menu-panel.active {
        opacity: 1;
    }

    .main-header .main-menu .navigation>li {
        position: relative;
        float: left;
        transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -webkit-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        margin-right: 25px;
    }

    /* ==================== NEW: HEADER MIDDLE (Logo + Search + Login) ==================== */
    .header-middle {
        padding: 18px 0;
        border-bottom: 1px solid #eee;
    }

    .header-middle .inner-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        flex-wrap: wrap;
    }

    .header-middle .logo-box .logo img {
        width: 100px;
    }

    /* ==================== FIX: MAIN NAVIGATION BAR LOOK ==================== */
    .header-lower {
        background: #fff;
        border-bottom: 1px solid #eee;
    }

    .main-header .main-menu .navigation {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin: 0;
    }

    .main-header .main-menu .navigation>li {
        margin-right: 0;
        display: flex;
        align-items: center;
    }

    .main-header .main-menu .navigation>li>a {
        display: flex;
        align-items: center;
        padding: 18px 16px;
        font-size: 15px;
        font-weight: 600;
        color: #222;
        position: relative;
        transition: color 0.25s ease;
    }

    .main-header .main-menu .navigation>li>a::after {
        content: '';
        position: absolute;
        left: 16px;
        right: 16px;
        bottom: 12px;
        height: 2px;
        background: orange;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.25s ease;
    }

    .main-header .main-menu .navigation>li:hover>a,
    .main-header .main-menu .navigation>li.dropdown.active>a {
        color: orange;
    }

    .main-header .main-menu .navigation>li:hover>a::after,
    .main-header .main-menu .navigation>li.dropdown.active>a::after {
        transform: scaleX(1);
    }

    /* Thoda even spacing dropdown caret ke saath */
    .main-header .main-menu .navigation>li.dropdown>a {
        padding-right: 22px;
    }

    /* Search Box */
    .header-search-box {
        position: relative;
        flex: 1 1 420px;
        max-width: 520px;
        min-width: 0;
    }

    .header-search-box .search-form {
        display: flex;
        align-items: center;
        border: 1px solid #e0e0e0;
        border-radius: 30px;
        padding: 4px 4px 4px 20px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .header-search-box input[type="text"] {
        flex: 1 1 auto;
        min-width: 0;
        width: 100%;
        border: none;
        outline: none;
        font-size: 14px;
        padding: 8px 10px;
        background: transparent;
    }

    .header-search-box .search-btn {
        border: none;
        background: orange;
        color: #fff;
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        padding: 0;
    }

    .header-search-box .search-btn svg {
        width: 16px;
        height: 16px;
        display: block;
    }

    /* Suggestions Dropdown */
    .search-suggestions {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        z-index: 1100;
        max-height: 320px;
        overflow-y: auto;
    }

    .search-suggestions.active {
        display: block;
    }

    .search-suggestions .suggestion-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 18px;
        cursor: pointer;
        border-bottom: 1px solid #f5f5f5;
    }

    .search-suggestions .suggestion-item:last-child {
        border-bottom: none;
    }

    .search-suggestions .suggestion-item:hover {
        background: #fdf3e7;
    }

    .search-suggestions .suggestion-name {
        font-size: 14px;
        color: #222;
        font-weight: 500;
    }

    .search-suggestions .suggestion-type {
        font-size: 11px;
        color: #999;
        background: #f2f2f2;
        padding: 2px 8px;
        border-radius: 10px;
        white-space: nowrap;
        margin-left: 10px;
    }

    .search-suggestions .suggestion-empty {
        padding: 14px 18px;
        font-size: 13px;
        color: #999;
        text-align: center;
    }

    /* Login/Signup button in middle section */
    .header-middle .auth-box .theme-btn {
        white-space: nowrap;
    }


    .desktop-sticky-menu {
        display: block
    }

    @media (max-width: 991px) {
        .header-middle .inner-container {
            justify-content: space-between;
        }

        .header-middle .logo-box {
            order: 1;
        }

        .header-middle .auth-box {
            order: 2;
        }

        .header-search-box {
            order: 3;
            flex: 1 1 100%;
            max-width: 100%;
            margin-top: 12px;
        }

        .desktop-sticky-menu {
            display: none !important;
        }
    }

    @media (max-width: 480px) {
        .header-middle .auth-box .theme-btn .txt {
            font-size: 12px;
        }

        .header-search-box input[type="text"] {
            font-size: 13px;
        }
    }
</style>
<link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet">
<link href="{{url('assets/css/style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<link href="{{url('assets/css/responsive.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700;900&display=swap"
    rel="stylesheet">
<link rel="shortcut icon" href="{{url('images/fav.ico')}}" type="image/x-icon">
<link rel="icon" href="{{url('images/fav.ico')}}" type="image/x-icon">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<style>
    .container {
        max-width: 100%;
    }

    .mobile-menu .navigation li.dropdown ul {
        display: none;
        padding-left: 20px;
    }

    .mobile-menu .navigation li.dropdown.open>a {
        color: orange;
        font-weight: 600;
    }

    .overflow-hidden {
        overflow: hidden;
    }

    @media (max-width: 767px) {
        .btn-style-one {
            background: #fff !important;
            color: black !important;
            border: 1px solid gray !important;
            border-radius: 4px;
        }
    }

    @media only screen and (max-width: 767px) {
        .main-header>div .logo {
            display: block;
        }
    }
</style>

<!-- Main Header -->
<header class="main-header dg">
    <div class="page-wrapper">

        <!-- ==================== NEW MOBILE HEADER ==================== -->
        <div class="mobile-custom-header d-block d-lg-none">
            <!-- 1. Top bar small color #045279 -->
            <div style="background-color: #045279; height: 6px; width: 100%;"></div>

            <!-- 2. Logo and Icons in one row -->
            <div
                style="display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; background: #fff; border-bottom: 1px solid #e0e0e0;">
                <!-- Left: Logo -->
                <div class="mobile-logo">
                    <a href="{{url('/')}}">
                        <img src="{{ url('images/Neti-logo.png') }}" style="height: 60px; width: auto;" alt="Logo">
                    </a>
                </div>

                <!-- Right side: 3 icons -->
                <div style="display: flex; align-items: center;">
                    <!-- Search Icon -->
                    <a href="javascript:void(0);" id="mobileSearchIconBtn"
                        style="color: #333; margin-right: 15px; display: flex; align-items: center;">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            style="width: 22px; height: 22px;">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                        </svg>
                    </a>

                    <!-- User Icon -->
                    @if(auth()->user() && auth()->user()->type == 'student')
                        <a href="{{route('user.dashboard')}}"
                            style="color: #333; margin-right: 15px; font-size: 22px; line-height: 1; display: flex; align-items: center;">
                            <i class="flaticon-add-user"></i>
                        </a>
                    @else
                        <a href="{{route('student.login')}}"
                            style="color: #333; margin-right: 15px; font-size: 22px; line-height: 1; display: flex; align-items: center;">
                            <i class="flaticon-add-user"></i>
                        </a>
                    @endif

                    <!-- Menu Icon -->
                    <div class="mobile-nav-toggler"
                        style="color: #333; font-size: 22px; cursor: pointer; line-height: 1; display: flex; align-items: center;">
                        <span class="icon flaticon-menu"></span>
                    </div>
                </div>
            </div>

            <!-- Mobile Search Box (Hidden by default) -->
            <div id="mobileSearchBox"
                style="display: none; padding: 10px 20px; background: #f9f9f9; border-bottom: 1px solid #eee;">
                <!-- Search Box (static for now, suggestions logic ready for dynamic data later) -->
                <div class="header-search-box" id="mobileHeaderSearchBox"
                    style="max-width: 100%; margin-top: 0; width: 100%; flex: 1 1 100%;">
                    <form class="search-form" onsubmit="return false;">
                        <input type="text" id="mobileGlobalSearchInput"
                            placeholder="Search courses, test series, packages..." autocomplete="off">
                        <button type="button" class="search-btn" id="mobileGlobalSearchBtn" aria-label="Search">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </button>
                    </form>
                    <div class="search-suggestions" id="mobileSearchSuggestions"></div>
                </div>
            </div>
        </div>
        <!-- ==================== END NEW MOBILE HEADER ==================== -->

        <!-- ==================== SECTION 1: HEADER TOP ==================== -->
        <div class="header-top d-none d-lg-block">
            <div class="auto-container d-flex justify-content-between align-items-center flex-wrap">
                <!-- Left Box -->
                <div class="left-box d-flex flex-wrap">
                    <ul class="info a">
                        <li><a href="#"><span class="icon flaticon-phone-call"></span><span
                                    class="m-80">{{$headerSettings->contact_number ?? ""}}</span></a></li>
                        <li style="padding: 0px !important;"><span>|</span></li>
                        <li><a href="#"><span class="icon flaticon-email"></span><span
                                    class="m-80">{{$headerSettings->email_id ?? ""}}</span></a></li>
                        <li style="padding: 0px !important;"><span>|</span></li>
                        <li style="padding-left: 0px !important;"><a href="#" style="padding-left: 0px !important;"><img
                                    src="{{url('images/resource/whatsapp.png')}}" /> <span
                                    class="m-80">{{$headerSettings->whatsapp_number ?? ""}}</span></a></li>
                    </ul>
                </div>

                <!-- Right Box -->
                <div class="right-box d-flex flex-wrap">
                    <div class="lr-box">
                        <div class="top-header-login">
                            <a href="{{route('neti.corner.index')}}" class="theme-btn btn-style-one"><span
                                    class="txt">Adhyayanam Corner</span></a>
                        </div>
                        <div class="top-header-login">
                            <a href="{{route('career')}}" class="theme-btn btn-style-one"><span
                                    class="txt">Career</span></a>
                        </div>
                        <div class="top-header-login">
                            <a href="{{route('contact.inquiry')}}" class="theme-btn btn-style-one"><span
                                    class="txt">Contact Us</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top -->


        <!-- ==================== SECTION 2: LOGO + SEARCH + LOGIN/SIGNUP ==================== -->
        <div class="header-middle d-none d-lg-block">
            <div class="auto-container container-fluid">
                <div class="inner-container">

                    <!-- Logo -->
                    <div class="logo-box">
                        <div class="logo"><a href="{{url('/')}}"><img src="{{ url('images/Neti-logo.png')}}" alt=""
                                    title=""></a></div>
                    </div>

                    <!-- Search Box (static for now, suggestions logic ready for dynamic data later) -->
                    <div class="header-search-box" id="headerSearchBox">
                        <form class="search-form" onsubmit="return false;">
                            <input type="text" id="globalSearchInput"
                                placeholder="Search courses, test series, packages..." autocomplete="off">
                            <button type="button" class="search-btn" id="globalSearchBtn" aria-label="Search">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </button>
                        </form>
                        <div class="search-suggestions" id="searchSuggestions"></div>
                    </div>

                    <!-- Login / Signup -->
                    <div class="auth-box">
                        @if(auth()->user() && auth()->user()->type == 'student')
                            <a href="{{route('user.dashboard')}}" class="theme-btn btn-style-one"><span class="txt"><i
                                        class="flaticon-add-user"></i> Dashboard</span></a>
                        @else
                            <a href="{{route('student.login')}}" class="theme-btn btn-style-one"><span class="txt"><i
                                        class="flaticon-add-user"></i> LogIn / Sign Up</span></a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <!-- End Header Middle -->


        <!-- ==================== SECTION 3: MENU (unchanged mega menu logic) ==================== -->
        <div class="header-lower d-none d-lg-block">
            <div class="auto-container container-fluid">
                <div class="inner-container d-flex justify-content-between align-items-center flex-wrap">
                    <div class="nav-outer d-flex align-items-center flex-wrap" style="width: 100%;">

                        <!-- Mobile Navigation Toggler -->
                        <div class="mobile-nav-toggler"> <span class="icon flaticon-menu"></span></div>

                        <!-- Main Menu -->
                        <nav class="main-menu show navbar-expand-md">
                            <div class="navbar-header">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li><a href="{{url('/')}}">Home</a></li>

                                    <li class="dropdown">
                                        <a href="#">About Us</a>
                                        <ul>
                                            <li><a href="{{route('about')}}">About Us</a></li>
                                            <li><a href="{{route('our.team.index')}}">Our Team</a></li>
                                            <li><a href="{{route('vision.mission')}}">Vision & Mission</a></li>
                                        </ul>
                                    </li>

                                    <!-- Courses Dropdown -->
                                    <li class="dropdown">
                                        <a href="#">Courses</a>
                                        <div class="mega-menu-container">
                                            <div class="mega-menu-left">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}"
                                                        data-tab="tab-course-{{ $commission->id }}">
                                                        {{ $commission->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mega-menu-right">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}"
                                                        id="tab-course-{{ $commission->id }}"
                                                        style="width: 100%; display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                        @foreach($commission->categories as $category)
                                                            <div>
                                                                <h5>{{ $category->name }}</h5>
                                                                <ul>
                                                                    @foreach($category->subCategories as $subCat)
                                                                                                                        <li>
                                                                                                                            <a href="{{ route('courses', [
                                                                            'examSlug' => $commission->slug,
                                                                            'catSlug' => $category->slug,
                                                                            'subCatSlug' => $subCat->slug
                                                                        ]) }}">
                                                                                                                                {{ $subCat->name }}
                                                                                                                            </a>
                                                                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Test Series Dropdown -->
                                    <li class="dropdown">
                                        <a href="#">Test Series</a>
                                        <div class="mega-menu-container">
                                            <div class="mega-menu-left">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}"
                                                        data-tab="tab-test-{{ $commission->id }}">
                                                        {{ $commission->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mega-menu-right">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}"
                                                        id="tab-test-{{ $commission->id }}"
                                                        style="width: 100%; display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                        @foreach($commission->categories as $category)
                                                            <div>
                                                                <h5>{{ $category->name }}</h5>
                                                                <ul>
                                                                    @foreach($category->subCategories as $subCat)
                                                                                                                        <li>
                                                                                                                            <a href="{{ route('test-series-list', [
                                                                            'examSlug' => $commission->slug,
                                                                            'catSlug' => $category->slug,
                                                                            'subCatSlug' => $subCat->slug
                                                                        ]) }}">
                                                                                                                                {{ $subCat->name }}
                                                                                                                            </a>
                                                                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Study Material Dropdown -->
                                    <li class="dropdown">
                                        <a href="#">Study Material</a>
                                        <div class="mega-menu-container">
                                            <div class="mega-menu-left">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}"
                                                        data-tab="tab-study-{{ $commission->id }}">
                                                        {{ $commission->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mega-menu-right">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}"
                                                        id="tab-study-{{ $commission->id }}"
                                                        style="width: 100%; display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                        @foreach($commission->categories as $category)
                                                            <div>
                                                                <h5>{{ $category->name }}</h5>
                                                                <ul>
                                                                    @foreach($category->subCategories as $subCat)
                                                                                                                        <li>
                                                                                                                            <a href="{{ route('study.material.front', [
                                                                            'examSlug' => $commission->slug,
                                                                            'catSlug' => $category->slug,
                                                                            'subCatSlug' => $subCat->slug
                                                                        ]) }}">
                                                                                                                                {{ $subCat->name }}
                                                                                                                            </a>
                                                                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>

                                    <li><a href="{{route('current.index')}}"> Current Affairs</a></li>

                                    <!-- PYQ Dropdown -->
                                    <li class="dropdown">
                                        <a href="#">PYQ</a>
                                        <div class="mega-menu-container">
                                            <div class="mega-menu-left">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}"
                                                        data-tab="tab-pyq-{{ $commission->id }}">
                                                        {{ $commission->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mega-menu-right">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}"
                                                        id="tab-pyq-{{ $commission->id }}"
                                                        style="width: 100%; display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                        @foreach($commission->categories as $category)
                                                            <div>
                                                                <h5>{{ $category->name }}</h5>
                                                                <ul>
                                                                    @foreach($category->subCategories as $subCat)
                                                                                                                        <li><a href="{{route(
                                                                            'pyq-papers',
                                                                            [
                                                                                'examSlug' => $commission->slug,
                                                                                'catSlug' => $category->slug,
                                                                                'subCatSlug' => $subCat->slug
                                                                            ]
                                                                        )}}">{{ $subCat->name }}</a>
                                                                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Syllabus Dropdown -->
                                    <li class="dropdown">
                                        <a href="#">Syllabus</a>
                                        <div class="mega-menu-container">
                                            <div class="mega-menu-left">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}"
                                                        data-tab="tab-syllabus-{{ $commission->id }}">
                                                        {{ $commission->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mega-menu-right">
                                                @foreach($examinationCommission as $commission)
                                                    <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}"
                                                        id="tab-syllabus-{{ $commission->id }}"
                                                        style="width: 100%; display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                        @foreach($commission->categories as $category)
                                                            <div>
                                                                <h5>{{ $category->name }}</h5>
                                                                <ul>
                                                                    @foreach($category->subCategories as $subCat)
                                                                                                                        <li>
                                                                                                                            <a href="{{ route('syllabus.front', [
                                                                            'examSlug' => $commission->slug,
                                                                            'catSlug' => $category->slug,
                                                                            'subCatSlug' => $subCat->slug
                                                                        ]) }}">
                                                                                                                                {{ $subCat->name }}
                                                                                                                            </a>
                                                                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>

                                    <li class="dropdown">
                                        <a href="#">Student Corner</a>
                                        <ul>
                                            <li><a href="{{route('daily.boost.front')}}">Daily Booster</a></li>
                                            <li><a href="{{route('test.planner.front')}}">Test Planner</a></li>
                                            <li><a href="{{route('batches.index')}}">Batches & Program</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <!-- Main Menu End-->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Lower (Menu) -->


        <!-- Sticky Header -->
        <div class="sticky-header" style="padding:0px 0px;">
            <!-- Desktop Layout -->
            <div class="container d-none d-lg-flex justify-content-between align-items-center flex-wrap">
                <div class="logo">
                    <a href="{{url('/')}}" title=""><img src="{{url('images/Neti-logo.png')}}" style="width:100px;"
                            alt="Adhyayanam Logo" title=""></a>
                </div>
                <nav class="main-menu"></nav>
                <div class="d-flex align-items-center" style="padding-right: 15px;">
                    <div class="top-header-login top-header-login1" style="margin-right: 20px;">
                        @if(auth()->user() && auth()->user()->type == 'student')
                            <a href="{{route('user.dashboard')}}" class="theme-btn btn-style-one"><span class="txt"><i
                                        class="flaticon-add-user"></i> Dashboard</span></a>
                        @else
                            <a href="{{route('student.login')}}" class="theme-btn btn-style-one"><span class="txt"><i
                                        class="flaticon-add-user"></i> LogIn / Sign Up</span></a>
                        @endif
                    </div>
                    <div class="mobile-nav-toggler"
                        style="color: #333; font-size: 24px; cursor: pointer; line-height: 1; display: flex; align-items: center;">
                        <span class="icon flaticon-menu"></span>
                    </div>
                </div>
            </div>

            <!-- Mobile Layout -->
            <div class="container d-flex d-lg-none justify-content-between align-items-center"
                style="padding: 10px 15px; background: #fff;">
                <!-- Left: Logo -->
                <div class="logo">
                    <a href="{{url('/')}}">
                        <img src="{{ url('images/Neti-logo.png') }}" style="height: 50px; width: auto;" alt="Logo">
                    </a>
                </div>

                <!-- Right: 3 Icons -->
                <div style="display: flex; align-items: center;">
                    <!-- Search Icon -->
                    <a href="javascript:void(0);" class="mobileSearchIconBtn"
                        style="color: #333; margin-right: 15px; display: flex; align-items: center;">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            style="width: 22px; height: 22px;">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                        </svg>
                    </a>

                    <!-- User Icon -->
                    @if(auth()->user() && auth()->user()->type == 'student')
                        <a href="{{route('user.dashboard')}}"
                            style="color: #333; margin-right: 15px; font-size: 22px; line-height: 1; display: flex; align-items: center;">
                            <i class="flaticon-add-user"></i>
                        </a>
                    @else
                        <a href="{{route('student.login')}}"
                            style="color: #333; margin-right: 15px; font-size: 22px; line-height: 1; display: flex; align-items: center;">
                            <i class="flaticon-add-user"></i>
                        </a>
                    @endif

                    <!-- Menu Icon -->
                    <div class="mobile-nav-toggler"
                        style="color: #333; font-size: 22px; cursor: pointer; line-height: 1; display: flex; align-items: center;">
                        <span class="icon flaticon-menu"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Sticky Menu -->


        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-cancel"></span></div>

            <nav class="menu-box">
                <div class="nav-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ url('images/Neti-logo.png') }}" alt="Logo" style="width: 100px;">
                    </a>
                </div>

                <div class="menu-outer1">
                    <ul class="navigation clearfix">
                        <li><a href="{{url('/')}}">Home</a></li>

                        <li class="dropdown">
                            <a href="#">Our Institute</a>
                            <ul>
                                <li><a href="{{route('about')}}">About Us</a></li>
                                <li><a href="{{route('our.team.index')}}">Our Team</a></li>
                                <li><a href="{{route('vision.mission')}}">Vision & Mission</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">Courses</a>
                            <ul>
                                @foreach($examinationCommission as $commission)
                                    <li class="dropdown">
                                        <a href="#">{{$commission->name}}</a>
                                        <ul>
                                            @foreach($commission->categories as $category)
                                                <li class="dropdown">
                                                    <a href="#">{{$category->name}}</a>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                                                                <li>
                                                                                                    <a href="{{ route('courses', [
                                                                'examSlug' => $commission->slug,
                                                                'catSlug' => $category->slug,
                                                                'subCatSlug' => $subCat->slug
                                                            ]) }}">
                                                                                                        {{ $subCat->name }}
                                                                                                    </a>
                                                                                                </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">Test Series</a>
                            <ul>
                                @foreach($examinationCommission as $commission)
                                    <li class="dropdown">
                                        <a href="#">{{$commission->name}}</a>
                                        <ul>
                                            @foreach($commission->categories as $category)
                                                <li class="dropdown">
                                                    <a href="#">{{$category->name}}</a>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                                                                <li>
                                                                                                    <a href="{{ route('test-series-list', [
                                                                'examSlug' => $commission->slug,
                                                                'catSlug' => $category->slug,
                                                                'subCatSlug' => $subCat->slug
                                                            ]) }}">
                                                                                                        {{ $subCat->name }}
                                                                                                    </a>
                                                                                                </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">Study Material</a>
                            <ul>
                                @foreach($examinationCommission as $commission)
                                    <li class="dropdown">
                                        <a href="#">{{$commission->name}}</a>
                                        <ul>
                                            @foreach($commission->categories as $category)
                                                <li class="dropdown">
                                                    <a href="#">{{$category->name}}</a>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                                                                <li>
                                                                                                    <a href="{{ route('study.material.front', [
                                                                'examSlug' => $commission->slug,
                                                                'catSlug' => $category->slug,
                                                                'subCatSlug' => $subCat->slug
                                                            ]) }}">
                                                                                                        {{ $subCat->name }}
                                                                                                    </a>
                                                                                                </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">Current Affairs</a>
                            <ul>
                                <li><a href="{{route('current.index')}}">View Current Affairs</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">PYQ</a>
                            <ul>
                                @foreach($examinationCommission as $commission)
                                    <li class="dropdown">
                                        <a href="#">{{$commission->name}}</a>
                                        <ul>
                                            @foreach($commission->categories as $category)
                                                <li class="dropdown">
                                                    <a href="#">{{$category->name}}</a>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                                                                <li>
                                                                                                    <a href="{{route('pyq-papers', [
                                                                'examSlug' => $commission->slug,
                                                                'catSlug' => $category->slug,
                                                                'subCatSlug' => $subCat->slug
                                                            ])}}">
                                                                                                        {{ $subCat->name }}
                                                                                                    </a>
                                                                                                </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">Syllabus</a>
                            <ul>
                                @foreach($examinationCommission as $commission)
                                    <li class="dropdown">
                                        <a href="#">{{$commission->name}}</a>
                                        <ul>
                                            @foreach($commission->categories as $category)
                                                <li class="dropdown">
                                                    <a href="#">{{$category->name}}</a>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                                                                <li>
                                                                                                    <a href="{{ route('syllabus.front', [
                                                                'examSlug' => $commission->slug,
                                                                'catSlug' => $category->slug,
                                                                'subCatSlug' => $subCat->slug
                                                            ]) }}">
                                                                                                        {{ $subCat->name }}
                                                                                                    </a>
                                                                                                </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">Student Corner</a>
                            <ul>
                                <li><a href="{{route('daily.boost.front')}}">Daily Booster</a></li>
                                <li><a href="{{route('test.planner.front')}}">Test Planner</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>


<!-- Bottom header -->


<script>
    $(document).ready(function () {

        // ==================== MOBILE MENU ====================
        $('.mobile-nav-toggler').on('click', function () {
            $('.mobile-menu').addClass('active');
        });

        $('.mobile-menu .close-btn, .menu-backdrop').on('click', function () {
            $('.mobile-menu').removeClass('active');
        });

        // ==================== MOBILE DROPDOWN - FIXED VERSION ====================
        $(document).on('click', '.mobile-menu .navigation li.dropdown > a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();   // Yeh line zaroori hai nested ke liye

            var $li = $(this).parent('li');

            // Agar already open hai to close kar do
            if ($li.hasClass('open')) {
                $li.removeClass('open');
                $li.find('ul').first().slideUp(250);
                return;
            }

            // Sab open dropdowns close kar do (sirf same level ke)
            $li.siblings('li.dropdown').removeClass('open').find('ul').slideUp(250);

            // Current ko open kar do
            $li.addClass('open');
            $li.find('ul').first().slideDown(250);
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.mobile-menu, .mobile-nav-toggler').length) {
                $('.mobile-menu').removeClass('active');
            }
        });

        // Resize handler
        $(window).on('resize', function () {
            if ($(window).width() > 991) {
                $('.mobile-menu').removeClass('active');
                $('.mobile-menu .navigation li.dropdown').removeClass('open');
                $('.mobile-menu .navigation li.dropdown ul').hide();
            }
        });

        // ==================== DESKTOP MEGA MENU ====================
        $('.dropdown').hover(function () {
            if ($(window).width() > 991) {
                $('.dropdown').removeClass('active');
                $(this).addClass('active');
            }
        }, function () {
            if ($(window).width() > 991) {
                $(this).removeClass('active');
            }
        });

        // Mega Menu Tab Switching
        $('.mega-menu-tab').on('click', function () {
            var $parent = $(this).closest('.mega-menu-container');

            $parent.find('.mega-menu-tab').removeClass('active');
            $parent.find('.mega-menu-panel').removeClass('active');

            $(this).addClass('active');
            $('#' + $(this).data('tab')).addClass('active');
        });

        // Close mega menu when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown').removeClass('active');
            }
        });

        // Resize Handler
        $(window).on('resize', function () {
            if ($(window).width() > 991) {
                $('.mobile-menu').removeClass('active');
                $('body').removeClass('overflow-hidden');
            }
        });

        // Close mobile menu on Escape key
        $(document).on('keydown', function (e) {
            if (e.key === "Escape") {
                $('.mobile-menu').removeClass('active');
                $('body').removeClass('overflow-hidden');
            }
        });



    });
</script>


<script>
    $(function () {

        let searchTimeout;

        function renderResults(results, $box) {

            $box.empty();

            if (!results.length) {
                $box.html(
                    '<div class="suggestion-empty">No results found</div>'
                ).addClass('active');
                return;
            }

            results.forEach(function (item) {

                $box.append(`
                <a href="${item.url}" class="suggestion-item"
                   style="text-decoration:none;color:inherit;">
                    <div>
                        <div class="suggestion-name">
                            ${item.name}
                        </div>

                        ${item.breadcrumb
                        ? `<small style="color:#777">
                                ${item.breadcrumb}
                               </small>`
                        : ''
                    }
                    </div>

                    <span class="suggestion-type">
                        ${item.type}
                    </span>
                </a>
            `);
            });

            $box.addClass('active');
        }

        function performSearch(query, $box) {

            if (query.length < 2) {
                $box.removeClass('active').empty();
                return;
            }

            $.ajax({
                url: "{{ route('global.search') }}",
                type: "GET",
                data: {
                    q: query
                },
                success: function (response) {

                    if (response.success) {
                        renderResults(response.results, $box);
                    }
                },
                error: function () {
                    $box.html(
                        '<div class="suggestion-empty">Search failed</div>'
                    ).addClass('active');
                }
            });
        }

        // Desktop

        $('#globalSearchInput').on('keyup', function () {

            clearTimeout(searchTimeout);

            let query = $(this).val().trim();

            searchTimeout = setTimeout(function () {
                performSearch(query, $('#searchSuggestions'));
            }, 300);

        });

        // Mobile

        $('#mobileGlobalSearchInput').on('keyup', function () {

            clearTimeout(searchTimeout);

            let query = $(this).val().trim();

            searchTimeout = setTimeout(function () {
                performSearch(query, $('#mobileSearchSuggestions'));
            }, 300);

        });

        // Hide dropdown

        $(document).on('click', function (e) {

            if (!$(e.target).closest('#headerSearchBox').length) {
                $('#searchSuggestions')
                    .removeClass('active')
                    .empty();
            }

            if (!$(e.target).closest('#mobileSearchBox').length) {
                $('#mobileSearchSuggestions')
                    .removeClass('active')
                    .empty();
            }

        });

    });
</script>