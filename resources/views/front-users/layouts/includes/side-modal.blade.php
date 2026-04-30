<!-- quick_user_toggle -->
<div class="modal modal-right fade" id="quick_user_toggle" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content slim-scroll3">
      <div class="modal-body p-30 bg-white">
        <div class="d-flex align-items-center justify-content-between pb-30">
          <h4 class="m-0">User Profile
          </h4>
          <a href="#" class="btn btn-icon btn-danger-light btn-sm no-shadow" data-bs-dismiss="modal">
            <span class="fa fa-close"></span>
          </a>
        </div>
        <div>
          <div class="d-flex flex-row">

            <!-- Profile Image -->
            <div>
              <img src="{{ auth()->user()->profile_image
  ? url('storage/' . auth()->user()->profile_image)
  : url('src/images/avatar/avatar-13.png') }}" alt="user" class="rounded bg-danger-light w-150"
                width="100">
            </div>

            <div class="ps-20">

              <!-- Name -->
              <h5 class="mb-0">
                {{ auth()->user()->name ?? 'User Name' }}
              </h5>

              <!-- Role -->
              <p class="my-5 text-fade">
                {{ auth()->user()->type ?? 'Student' }}
              </p>

              <!-- Email -->
              <a href="mailto:{{ auth()->user()->email }}">
                <span class="icon-Mail-notification me-5 text-success">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </span>
                {{ auth()->user()->email ?? 'No Email' }}
              </a>

            </div>
          </div>
        </div>
        <div class="dropdown-divider my-30"></div>
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
      </div>
    </div>
  </div>
</div>
<!-- /quick_user_toggle -->