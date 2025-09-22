<meta charset="utf-8">
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

.mega-menu-container {
    display: none;
    position: fixed;
    left: 0;
    top:107px !important;
    width: 100vw;
    background: #fff;
    z-index: 1000;
    border-top: 2px solid orange;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.dropdown.active .mega-menu-container {
    display: flex;
}

.mega-menu-left {
    width: 20%;
    background: #f9f9f9;
    border-right: 1px solid #ddd;
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

.mega-menu-right {
    width: 80%;
    padding: 20px;
    max-height: 400px; /* Set a fixed height for the right panel */
    overflow-y: auto; /* Enable vertical scrolling */
    display: grid; /* Use CSS Grid for layout */
    /*grid-template-columns: repeat(3, 1fr); */
    gap: 20px; /* Space between grid items */
}

.mega-menu-panel {
    display: none;
    width: 100%;
    
}

.mega-menu-panel.active {
    display: block;
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
</style>
<link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet">
<link href="{{url('assets/css/style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<link href="{{url('assets/css/responsive.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700;900&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">
<link rel="icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<!-- Main Header -->
<header class="main-header">
<div class="page-wrapper">

    <!-- Header Top -->
    <div class="header-top">
        <div class="auto-container d-flex justify-content-between align-items-center flex-wrap">
            <!-- Left Box -->
            <div class="left-box d-flex flex-wrap">
                <ul class="info a">
                    <li><a href="#"><span class="icon flaticon-phone-call"></span><span class="m-80">{{$headerSettings->contact_number ?? ""}}</span></a></li>
                    <li style="padding: 0px !important;"><span>|</span></li>
                    <li><a href="#"><span class="icon flaticon-email"></span><span class="m-80">{{$headerSettings->email_id ?? ""}}</span></a></li>
                    <li style="padding: 0px !important;"><span>|</span></li>
                    <li style="padding-left: 0px !important;"><a href="#" style="padding-left: 0px !important;"><img src="{{url('images/resource/whatsapp.png')}}" /> <span class="m-80">{{$headerSettings->whatsapp_number ?? ""}}</span></a></li>
                </ul>
            </div>

            <!-- Right Box -->
            <div class="right-box d-flex flex-wrap">
                <div class="lr-box">
                    <div class="top-header-login">
                        <a href="{{route('neti.corner.index')}}" class="theme-btn btn-style-one"><span class="txt">Adhyayanam Corner</span></a>
                    </div>
                    <div class="top-header-login">
                        <a href="{{route('career')}}" class="theme-btn btn-style-one"><span class="txt">Career</span></a>
                    </div>
                    <div class="top-header-login">
                        <a href="{{route('contact.inquiry')}}" class="theme-btn btn-style-one"><span class="txt">Contact Us</span></a>
                    </div>
                    <div class="top-header-login">
                        @if(auth()->user() && auth()->user()->type == 'student')
                        <a href="{{route('user.dashboard')}}" class="theme-btn btn-style-one"><span class="txt"><i class="flaticon-add-user"></i> Dashboard</span></a>
                        @else
                        <a data-bs-toggle="modal" data-bs-target="#lr" class="theme-btn btn-style-one"><span class="txt"><i class="flaticon-add-user"></i> Sign Up / Sign Up</span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Lower -->
    <div class="header-lower">
        <div class="auto-container container-fluid">
            <div class="inner-container d-flex justify-content-between align-items-center flex-wrap">
                <div class="logo-box">
                    <div class="logo"><a href="{{url('/')}}"><img src="{{ url('images/Neti-logo.png')}}" style="width:150px;" alt="" title=""></a></div>
                </div>
                <div class="nav-outer d-flex align-items-center flex-wrap">
                    <!-- Mobile Navigation Toggler -->
                    <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
                    <!-- Main Menu -->
                    <nav class="main-menu show navbar-expand-md">
                        <div class="navbar-header">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li><a href="{{url('/')}}">Home</a></li>
                                <li class="dropdown">
                                    <a href="#">Our Institute</a>
                                    <div class="mega-menu-container">
                                        <div class="mega-menu-left">
                                            <div class="mega-menu-tab active" data-tab="tab-institute-1">Institute Info</div>
                                        </div>
                                        <div class="mega-menu-right">
                                            <div class="mega-menu-panel active" id="tab-institute-1">
                                                <h5>Institute Details</h5>
                                                <ul>
                                                    <li><a href="{{route('about')}}">About Us</a></li>
                                                    <li><a href="{{route('our.team.index')}}">Our Team</a></li>
                                                    <li><a href="{{route('vision.mission')}}">Vision & Mission</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Courses</a>
                                    <div class="mega-menu-container">
                                        <div class="mega-menu-left">
                                            @foreach($examinationCommission as $index => $commission)
                                            <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}" data-tab="tab-{{ $commission->id }}">
                                                {{ $commission->name }}
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mega-menu-right">
                                            @foreach($examinationCommission as $commission)
                                            <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}" id="tab-{{ $commission->id }}" style="width: 100%;
    display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                @foreach($commission->categories as $category)
                                                <div> <!-- Each category is a grid item -->
                                                    <h5>{{ $category->name }}</h5>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                        <li><a href="{{ route('courses.filter', $subCat->id) }}">{{ $subCat->name }}</a></li>
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
                                    <a href="#">Test Series</a>
                                    <div class="mega-menu-container">
                                        <div class="mega-menu-left">
                                            @foreach($examinationCommission as $index => $commission)
                                            <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}" data-tab="tab-test-{{ $commission->id }}">
                                                {{ $commission->name }}
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mega-menu-right">
                                            @foreach($examinationCommission as $commission)
                                            <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}" id="tab-test-{{ $commission->id }}" style="width: 100%;
    display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                @foreach($commission->categories as $category)
                                                <div> <!-- Each category is a grid item -->
                                                    <h5>{{ $category->name }}</h5>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                        <li><a href="{{route('test-series',['examid' => $commission->id, 'catid' => $category->id, 'subcat' => $subCat->id])}}">{{ $subCat->name }}</a></li>
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
                                    <a href="#">Study Material</a>
                                    <div class="mega-menu-container">
                                        <div class="mega-menu-left">
                                            @foreach($examinationCommission as $index => $commission)
                                            <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}" data-tab="tab-test-{{ $commission->id }}">
                                                {{ $commission->name }}
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mega-menu-right">
                                            @foreach($examinationCommission as $commission)
                                            <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}" id="tab-test-{{ $commission->id }}" style="width: 100%;
    display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                @foreach($commission->categories as $category)
                                                <div> <!-- Each category is a grid item -->
                                                    <h5>{{ $category->name }}</h5>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                      <li>
  <a href="{{ route('study.material.front', [
      'examid' => $commission->id,
      'catid' => $category->id,
      'subcat' => $subCat->id
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
                                    <a href="#">Current Affairs</a>
                                    <div class="mega-menu-container">
                                        <div class="mega-menu-left">
                                            <div class="mega-menu-tab active" data-tab="tab-current-affairs">Current Affairs</div>
                                        </div>
                                        <div class="mega-menu-right">
                                            <div class="mega-menu-panel active" id="tab-current-affairs">
                                                <h5>Current Affairs</h5>
                                                <ul>
                                                    <li><a href="{{route('current.index')}}">View Current Affairs</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a href="#">PYQ</a>
                                    <div class="mega-menu-container">
                                        <div class="mega-menu-left">
                                            @foreach($examinationCommission as $index => $commission)
                                            <div class="mega-menu-tab {{ $loop->first ? 'active' : '' }}" data-tab="tab-pyq-{{ $commission->id }}">
                                                {{ $commission->name }}
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="mega-menu-right">
                                            @foreach($examinationCommission as $commission)
                                            <div class="mega-menu-panel {{ $loop->first ? 'active' : '' }}" id="tab-pyq-{{ $commission->id }}" style="width: 100%;
    display: grid; grid-template-columns: 1fr 1fr 1fr;">
                                                @foreach($commission->categories as $category)
                                                <div> <!-- Each category is a grid item -->
                                                    <h5>{{ $category->name }}</h5>
                                                    <ul>
                                                        @foreach($category->subCategories as $subCat)
                                                        <li><a href="{{route('pyq-papers',['examid' => $commission->id, 'catid' => $category->id, 'subcat' => $subCat->id])}}">{{ $subCat->name }}</a></li>
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
                                    <div class="mega-menu-container">
                                        <div class="mega-menu-left">
                                            <div class="mega-menu-tab active" data-tab="tab-student-corner">Student Resources</div>
                                        </div>
                                        <div class="mega-menu-right">
                                            <div class="mega-menu-panel active" id="tab-student-corner">
                                                <h5>Resources</h5>
                                                <ul>
                                                    <li><a href="{{route('daily.boost.front')}}">Daily Booster</a></li>
                                                    <li><a href="{{route('test.planner.front')}}">Test Planner</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Lower -->

    <!-- Sticky Header -->
    <div class="sticky-header">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <div class="logo">
                <a href="{{url('/')}}" title=""><img src="{{url('images/Neti-logo.png')}}" style="width:150px;" alt="Adhyayanam Logo" title=""></a>
            </div>
            <nav class="main-menu"></nav>
            <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
        </div>
    </div><!-- End Sticky Menu -->

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn"><span class="icon flaticon-cancel"></span></div>
        <nav class="menu-box">
            <div class="nav-logo"><a href="index-2.html"><img src="{{url('images/logo.png')}}" alt="" title=""></a></div>
            <div class="menu-outer"></div>
        </nav>
    </div><!-- End Mobile Menu -->
</div>
</header>

<!-- Bottom header -->
@php
    $marquees = App\Models\Marquee::all();
@endphp
<div class="bottom-header">
    <div class="container">
        <div class="maq-container">
            <div class="latest-head">
                <span>LATEST NEWS :</span>
            </div>
            <div class="marq-info">
                <marquee class="mar" width="90%" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                    @foreach($marquees as $key=>$data)
                    <a style="text-decoration:none;color:white;" href="{{$data->link}}">{{$data->title}},</a>
                    @endforeach
                </marquee>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.mega-menu-tab');
    const panels = document.querySelectorAll('.mega-menu-panel');
    const dropdowns = document.querySelectorAll('.dropdown');
    const headerLower = document.querySelector('.header-lower');

    // Calculate the top position of the mega menu based on the header height
    const headerHeight = headerLower.offsetHeight;
    const megaMenus = document.querySelectorAll('.mega-menu-container');
    megaMenus.forEach(menu => {
        menu.style.top = `${headerHeight}px`;
    });

    // Choose activation method: 'hover' or 'click'
    const activationMethod = 'hover';

    // Handle activation for dropdowns
    dropdowns.forEach(dropdown => {
        if (activationMethod === 'hover') {
            dropdown.addEventListener('mouseenter', handleDropdownActivation);
            dropdown.addEventListener('mouseleave', handleDropdownDeactivation);
        } else {
            dropdown.addEventListener('click', function (e) {
                e.preventDefault();
                const isActive = this.classList.contains('active');
                dropdowns.forEach(d => d.classList.remove('active'));
                if (!isActive) {
                    this.classList.add('active');
                }
            });
        }
    });

    // Handle activation for mega menu tabs
    tabs.forEach(tab => {
        tab.addEventListener('mouseenter', handleTabActivation);
    });

    function handleDropdownActivation(e) {
        dropdowns.forEach(d => d.classList.remove('active'));
        this.classList.add('active');
    }

    function handleDropdownDeactivation(e) {
        this.classList.remove('active');
    }

    function handleTabActivation(e) {
        const parentContainer = this.closest('.mega-menu-container');
        const siblingTabs = parentContainer.querySelectorAll('.mega-menu-tab');
        const siblingPanels = parentContainer.querySelectorAll('.mega-menu-panel');

        siblingTabs.forEach(t => t.classList.remove('active'));
        siblingPanels.forEach(p => p.classList.remove('active'));

        const tabId = this.getAttribute('data-tab');
        const activePanel = document.getElementById(tabId);

        this.classList.add('active');
        if (activePanel) activePanel.classList.add('active');
    }

    // Close dropdowns when clicking outside (for click mode)
    if (activationMethod === 'click') {
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.dropdown')) {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });
    }
});
</script>