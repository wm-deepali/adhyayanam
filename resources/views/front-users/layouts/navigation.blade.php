<style>
    .sidebar-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.sidebar-logo {
    max-height: 48px;
    width: auto;
}

.sidebar-close-btn {
    background: none;
    border: none;
    padding: 5px;
    cursor: pointer;
}

/* Mobile pe scroll height adjust */
@media (max-width: 991.98px) {
    .multinav-scroll {
        height: calc(100vh - 70px) !important;
    }
    
}
@media (min-width: 740px) {
    .sidebar-logo{
        display:none;
    }
}
</style>

<aside class="main-sidebar">
    <section class="sidebar position-relative">

        <!-- New Sidebar Header -->
        <div class="sidebar-header d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
            <!-- Left Side Logo -->
            <a href="{{ route('user.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ url('images/Neti-logo.png')}}" alt="Adhyayanam Logo" 
                     class="sidebar-logo" style="height: 45px;">
                <!-- Agar text logo chahiye to yeh use kar sakte ho -->
                <!-- <span class="fw-bold fs-4 text-primary">Adhyayanam</span> -->
            </a>

            <!-- Right Side Close Button (Mobile pe dikhega) -->
            <button type="button" class="btn-close sidebar-close-btn d-lg-none" 
                    aria-label="Close sidebar">
                <i data-feather="x" class="text-dark" style="width: 28px; height: 28px;"></i>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <div class="multinav">
            <div class="multinav-scroll" style="height: calc(100vh - 70px);">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">
                    <li>
                        <a href="{{route('user.dashboard')}}">
                            <i data-feather="home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.orders')}}">
                            <i data-feather="shopping-cart"></i>
                            <span>Order History</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.mycourses') }}">
                            <i data-feather="book"></i>
                            <span>My Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.study-material') }}">
                            <i data-feather="file-text"></i>
                            <span>My Study Material</span>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i data-feather="pie-chart"></i>
                            <span>Test Series</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('user.test-series')}}"><i class="icon-Commit"></i>Test Series</a></li>
                            <li><a href="{{ route('user.my-pyq-papers') }}"><i class="icon-Commit"></i>My PYQ Papers</a></li>
                            <li><a href="{{route('user.test-papers')}}"><i class="icon-Commit"></i>Test Results</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i data-feather="credit-card"></i>
                            <span>My Wallet</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route('student.wallet') }}">
                                    <i class="icon-Commit"></i>Wallet Transaction
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{route('user.setting')}}">
                            <i data-feather="settings"></i>
                            <span>Setting</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('logout')}}">
                            <i data-feather="log-out"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>

                <!-- Sidebar Widget (Promotion Box) -->
                <div class="sidebar-widgets mt-4">
                    <div class="mx-25 mb-30 pb-20 side-bx bg-primary-light rounded20">
                        <div class="text-center">
                            <img src="https://edulearn-lms-admin-template.multipurposethemes.com/images/svg-icon/color-svg/custom-24.svg"
                                 class="sideimg p-5" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>