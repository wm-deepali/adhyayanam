<style>
    .sidebar-header {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
        .sidebar-logo {
            display: none;
        }
    }

    .sidebar-toggle-btn {
        background: none;
        border: none;
        padding: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease;
        border-radius: 4px;
    }

    .sidebar-toggle-btn:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Mobile floating trigger styling */
    .mobile-sidebar-toggle-btn {
        position: fixed;
        top: 24px;
        left: 15px;
        z-index: 9999;
        background: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 05px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .mobile-sidebar-toggle-btn:active {
        transform: scale(0.9);
    }

    /* Hide the mobile floating button when sidebar is open or on larger screens */
    .sidebar-open .mobile-sidebar-toggle-btn {
        display: none !important;
    }

    @media (min-width: 768px) {
        .mobile-sidebar-toggle-btn {
            display: none !important;
        }
    }

    /* Adjustments when sidebar is collapsed on desktop */
    .sidebar-collapse .sidebar-header {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
        justify-content: center !important;
    }
    
    .sidebar-collapse .sidebar-logo-wrapper {
        display: none !important;
    }
    
    .sidebar-collapse .sidebar-close-btn {
        display: none !important;
    }
</style>

<!-- Mobile Floating Toggle Button (visible only on mobile when sidebar is closed) -->
<button type="button" class="mobile-sidebar-toggle-btn" aria-label="Open sidebar">
    <i data-feather="menu" class="text-dark" style="width: 24px; height: 24px;"></i>
</button>

<aside class="main-sidebar">
    <section class="sidebar position-relative">

        <!-- New Sidebar Header -->
        <div class="sidebar-header d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
            <!-- Left Side Logo & Brand -->
            <a href="{{url('/')}}" class="d-flex align-items-center gap-2 text-decoration-none sidebar-logo-wrapper">
                <img src="{{ url('images/Neti-logo.png')}}" alt="Adhyayanam Logo" class="sidebar-logo"
                    style="height: 45px;">
            </a>

            <!-- Menu Button to Toggle Sidebar -->
            <!--<button type="button" class="sidebar-toggle-btn" aria-label="Toggle sidebar">-->
            <!--    <i data-feather="menu" class="text-dark" style="width: 28px; height: 28px;"></i>-->
            <!--</button>-->

            <!-- Right Side Close Button (Mobile pe dikhega) -->
            <button type="button" class="btn-close sidebar-close-btn d-lg-none" aria-label="Close sidebar">
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
                        <a href="{{route('user.profile')}}">
                            <i data-feather="user"></i>
                            <span>My Profile</span>
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
                            <li><a href="{{ route('user.my-pyq-papers') }}"><i class="icon-Commit"></i>My PYQ Papers</a>
                            </li>
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

<script>
    document.addEventListener('click', function(e) {
        // Toggle sidebar using the hamburger/toggle button
        const toggleBtn = e.target.closest('.sidebar-toggle, [data-toggle="push-menu"], .sidebar-toggle-btn, .mobile-sidebar-toggle-btn');
        if (toggleBtn) {
            e.preventDefault();
            if (window.innerWidth < 768) {
                document.body.classList.toggle('sidebar-open');
            } else {
                document.body.classList.toggle('sidebar-collapse');
            }
            return;
        }

        // Close sidebar using the close button inside sidebar header
        const closeBtn = e.target.closest('.sidebar-close-btn');
        if (closeBtn) {
            e.preventDefault();
            document.body.classList.remove('sidebar-open');
            return;
        }

        // Close sidebar if clicking outside of the sidebar on mobile devices
        if (window.innerWidth < 768 && document.body.classList.contains('sidebar-open')) {
            const sidebar = document.querySelector('.main-sidebar');
            if (sidebar && !sidebar.contains(e.target)) {
                document.body.classList.remove('sidebar-open');
            }
        }
    });
</script>