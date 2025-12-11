<aside class="main-sidebar">
	<!-- sidebar-->
	<section class="sidebar position-relative">
		<div class="multinav">
			<div class="multinav-scroll" style="height: 97%;">
				<!-- sidebar menu-->
				<ul class="sidebar-menu" data-widget="tree">
					<li>
						<a href="{{route('user.dashboard')}}"><i data-feather="home"></i><span>Dashboard</span></a>
					</li>
					<li>
						<a href="{{route('user.orders')}}"><i data-feather="home"></i><span>Order History</span></a>
					</li>
					<li>
						<a href="{{ route('user.mycourses') }}">
							<i data-feather="user"></i>
							<span>My Courses</span>
						</a>
					</li>
					<li>
						<a href="{{ route('user.study-material') }}">
							<i data-feather="user"></i>
							<span>My Study Material</span>
						</a>
					</li>
					<!-- <li><a href="{{route('user-test-planner')}}"><i class="icon-Commit"><span class="path1"></span><span
									class="path2"></span></i>Test Planner</a></li>

					</li> -->
					<li class="treeview">
						<a href="#">
							<i data-feather="pie-chart"></i>
							<span>Test Series</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>

						<ul class="treeview-menu">
							<li><a href="{{route('user.test-series')}}"><i class="icon-Commit"><span
											class="path1"></span><span class="path2"></span></i>Test Series</a></li>
							<li><a href="{{route('user.test-papers')}}"><i class="icon-Commit"><span
											class="path1"></span><span class="path2"></span></i>Test Results</a></li>
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
						<a href="{{route('user.setting')}}"><i data-feather="home"></i><span>Setting</span></a>
					</li>
					<li>
						<a href="{{route('logout')}}"><i data-feather="log-out"></i><span>Logout</span></a>
					</li>
				</ul>

				<div class="sidebar-widgets">
					<div class="mx-25 mb-30 pb-20 side-bx bg-primary-light rounded20">
						<div class="text-center">
							<img src="https://edulearn-lms-admin-template.multipurposethemes.com/images/svg-icon/color-svg/custom-24.svg"
								class="sideimg p-5" alt="">
							<!-- <h4 class="title-bx text-primary">Best Education Admin</h4> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</aside>