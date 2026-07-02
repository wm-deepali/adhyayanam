@extends('front-users.layouts.app')

@section('title')
	Dashboard
@endsection

@section('content')
	<section class="content">
<style>
    /* Show/hide based on screen width via media query */
    @media (max-width: 767.98px) {
        .desktop-only-dashboard {
            display: none !important;
        }
        .mobile-only-dashboard {
            display: block !important;
        }
        
        .fixed .content-wrapper {
            margin-top: 60px; 
        }

        .box-body > *:last-child {
            margin-bottom: 0;
            justify-content: center;
        }

        .box-body {
            text-align: center;
        }
        .content {
            min-height: 250px;
            padding: 1.5rem 0px; 
        }
        
        .text-overflow {

    white-space: inherit;
}
    }
    
    @media (min-width: 768px) {
        .mobile-only-dashboard {
            display: none !important;
        }
    }

    /* Styling for the custom dashboard layout on mobile view */
    .mobile-only-dashboard .dashboard-card-container {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        text-decoration: none !important;
    }

    .mobile-only-dashboard .dashboard-card {
        width: 65px !important;
        height: 65px !important;
        border-radius: 18px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: none !important;
        transition: transform 0.2s ease !important;
        border: none !important;
        outline: none !important;
    }
    
    .mobile-only-dashboard .dashboard-card:active {
        transform: scale(0.92) !important;
    }
    
    .mobile-only-dashboard .dashboard-card-label {
        font-size: 11px !important;
        font-weight: 500 !important;
        color: #4a5060 !important;
        margin-top: 8px !important;
        line-height: 1.3 !important;
        white-space: normal !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
    }
    
    /* Horizontal scrolling for tab navigation on mobile */
    html body .mobile-only-dashboard .custom-dashboard-tabs {
        border: none !important;
        background-color: #f1f3f5 !important;
        padding: 4px !important;
        border-radius: 30px !important;
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        scrollbar-width: none !important; /* Firefox */
        -ms-overflow-style: none !important;  /* IE and Edge */
    }
    
    html body .mobile-only-dashboard .custom-dashboard-tabs::-webkit-scrollbar {
        display: none !important; /* Chrome, Safari and Opera */
    }
    
    html body .mobile-only-dashboard .custom-dashboard-tabs .nav-item {
        flex: 0 0 auto !important;
    }
    
    html body .mobile-only-dashboard .custom-dashboard-tabs .nav-link {
        color: #7f839a !important;
        background: transparent !important;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        padding: 8px 20px !important;
        border-radius: 30px !important;
        transition: all 0.2s ease !important;
        white-space: nowrap !important;
        display: inline-block !important;
    }
    
    html body .mobile-only-dashboard .custom-dashboard-tabs .nav-link.active {
        color: #023896 !important;
        background: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        border: none !important;
        outline: none !important;
    }
    
    html body .mobile-only-dashboard .last-border-none:last-child {
        border-bottom: none !important;
    }

    .mobile-only-dashboard .premium-mobile-card {
        background: #ffffff !important;
        border-radius: 20px !important;
        padding: 20px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
        border: 1px solid rgba(0, 0, 0, 0.03) !important;
        margin-bottom: 20px !important;
    }

    .mobile-only-dashboard .progress-bar-container {
        margin-bottom: 20px !important;
    }

    .mobile-only-dashboard .progress-info {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 8px !important;
    }

    .mobile-only-dashboard .progress-title {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #2b3040 !important;
    }

    .mobile-only-dashboard .progress-value {
        font-size: 12px !important;
        font-weight: 500 !important;
        color: #8a90a0 !important;
    }

    .mobile-only-dashboard .custom-progress {
        height: 8px !important;
        background-color: #f1f3f5 !important;
        border-radius: 4px !important;
        overflow: hidden !important;
    }

    .mobile-only-dashboard .custom-progress-bar {
        height: 100% !important;
        border-radius: 4px !important;
    }

    .mobile-only-dashboard .premium-list-item {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 15px 0 !important;
        border-bottom: 1px solid #f8f9fa !important;
        transition: transform 0.2s ease !important;
    }

    .mobile-only-dashboard .premium-list-item:last-child {
        border-bottom: none !important;
    }

    .mobile-only-dashboard .course-avatar {
        width: 46px !important;
        height: 46px !important;
        border-radius: 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        flex-shrink: 0 !important;
    }

    .mobile-only-dashboard .course-details {
        display: flex !important;
        flex-direction: column !important;
        margin-left: 14px !important;
        flex-grow: 1 !important;
        overflow: hidden !important;
        text-align: left !important;
    }

    .mobile-only-dashboard .course-title {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #1a1e2d !important;
        margin-bottom: 2px !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
        overflow: hidden !important;
        text-align: left !important;
    }

    .mobile-only-dashboard .course-price {
        font-size: 12px !important;
        font-weight: 500 !important;
        color: #0ad076 !important;
        text-align: left !important;
    }

    .mobile-only-dashboard .premium-view-btn {
        background-color: #fdf5e6 !important;
        color: #ff9f00 !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        padding: 6px 16px !important;
        border-radius: 20px !important;
        text-decoration: none !important;
        border: none !important;
        transition: all 0.2s ease !important;
        display: inline-block !important;
    }

    .mobile-only-dashboard .premium-view-btn:active {
        background-color: #ff9f00 !important;
        color: white !important;
    }

    .mobile-only-dashboard .notice-board-scroll {
        max-height: 250px !important;
        overflow: auto !important;
        padding-right: 5px !important;
    }
    
    .mobile-only-dashboard .notice-board-scroll::-webkit-scrollbar {
        width: 4px !important;
        height: 4px !important;
    }
    
    .mobile-only-dashboard .notice-board-scroll::-webkit-scrollbar-track {
        background: #f1f3f5 !important;
        border-radius: 4px !important;
    }
    
    .mobile-only-dashboard .notice-board-scroll::-webkit-scrollbar-thumb {
        background: #ced4da !important;
        border-radius: 4px !important;
    }
    
    .box-body .btn.btn-sm {
    margin: 0px;
    padding: 6px 0px;
    display: flex;
    width: 80px;
    justify-content: center;
}

.box-body .d-flex.flex-column.fw-500 .text-fade {
    color: #222223 !important;
    font-size: 10px;
}
</style>
		<div class="row desktop-only-dashboard">
			<div class="col-xl-9 col-12">
				<div class="box bg-success asdsadsa">
					<div class="box-body d-flex p-0">
						<div class="flex-grow-1 p-30 flex-grow-1 bg-img bg-none-md"
							style="background-position: right bottom; background-size: auto 100%; background-image: url({{ !empty($dashboardBanner->image) ? asset('storage/' . $dashboardBanner->image) : 'https://edulearn-lms-admin-template.multipurposethemes.com/images/svg-icon/color-svg/custom-30.svg' }})">
							<div class="row">
								<div class="col-12 col-xl-7">
									<h1 class="mb-0 fw-600">{{ $dashboardBanner->title ?? 'Learn With Effectively With Us!' }}</h1>
									<p class="my-10 fs-16 text-white-70">{{ $dashboardBanner->subtitle ?? 'Get 30% off every course on january.' }}</p>
									<div class="mt-45 d-md-flex align-items-center">
										<div class="me-30 mb-30 mb-md-0">
											<div class="d-flex align-items-center">
												<div
													class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-danger b-1 border-white rounded-circle">
													<i class="fa fa-graduation-cap"></i>
												</div>
												<div>
													<h5 class="mb-0">Students</h5>
													<p class="mb-0 text-white-70">{{ number_format($studentCount) }}+</p>
												</div>
											</div>
										</div>
										<div>
											<div class="d-flex align-items-center">
												<div
													class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-warning b-1 border-white rounded-circle">
													<i class="fa fa-user"></i>
												</div>
												<div>
													<h5 class="mb-0">Expert Mentors</h5>
													<p class="mb-0 text-white-70">{{ number_format($teacherCount) }}+</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 col-xl-5"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-12">
				<div class="box bg-transparent no-shadow">
					<div class="box-body p-xl-0 text-center">
						<h3 class="px-30 mb-20">Have More<br>knoledge to share?</h3>
						<a href="{{ route('courses') }}" class="waves-effect waves-light w-p100 btn btn-primary"><i
								class="fa fa-plus me-15"></i> Explore Courses</a>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<a class="box box-link-shadow text-center pull-up" href="{{ route('courses') }}">
							<div class="box-body py-5 bg-primary-light px-5">
								<p class="fw-500 text-primary text-overflow">Courses</p>
							</div>
							<div class="box-body p-10">
								<h1 class="countnm fs-40 m-0">{{ $courseCount }}</h1>
							</div>
						</a>
					</div>
					<div class="col-6">
						<a class="box box-link-shadow text-center pull-up" href="{{ route('test-series-list') }}">
							<div class="box-body py-5 bg-primary-light px-5">
								<p class="fw-500 text-primary text-overflow">Test Series</p>
							</div>
							<div class="box-body p-10">
								<h1 class="countnm fs-40 m-0">{{ $testSeriesCount  }}</h1>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-12">
				<div class="box no-shadow mb-0 bg-transparent">
					<div class="box-header no-border px-0">
						<h3 class="fw-500 box-title">Popular Courses</h3>
						<div class="box-controls pull-right d-md-flex d-none">
							<a href="{{ route('courses') }}">All Courses</a>
						</div>
					</div>
				</div>
				<div>

	@foreach($courses as $course)
<div class="box mb-15 pull-up">
    <div class="box-body">
        <div class="d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center">
                @php   
                $colors = ['warning', 'danger', 'success', 'primary'];
                $color = $colors[$loop->index % count($colors)];
                @endphp 
				
				<div class="me-15 bg-{{ $color }} h-50 w-50 l-h-55 rounded text-center">
                    <span class="fs-20">
                        {{ strtoupper(substr($course->title ?? $course->name, 0, 1)) }}
                    </span>
                </div>

                <div class="d-flex flex-column fw-500">
                    <a href="{{ route('courses.detail', $course->id) }}" class="text-dark mb-1 fs-16">
                        {{ $course->title ?? $course->name }}
                    </a>

                    <span class="text-fade">
                        ₹{{ $course->offered_price ?? 0 }}
                    </span>
                </div>
            </div>

            <div>
                <a href="{{ route('courses.detail', $course->id) }}"
                   class="btn btn-sm btn-warning-light">
                    View
                </a>
            </div>

        </div>
    </div>
</div>
@endforeach


				</div>
			</div>
			<div class="col-xl-4 col-12">
				<div class="box no-shadow mb-0 bg-transparent">
					<div class="box-header no-border px-0">
						<h3 class="fw-500 box-title">Current Activity</h3>
					</div>
				</div>
				<div class="box">
					<div class="box-body pb-0">
						<div class="mb-15 w-p100 d-flex align-items-center justify-content-between">
							<div>
								<h3 class="my-0">Monthly Progress</h3>
								<p class="mb-0 text-fade">This is the latest Improvement</p>
							</div>
							<div class="input-group w-auto">
								<button type="button" class="btn btn-primary-light btn-circle" id="daterange-btn">
									<p><i class="fa fa-calendar"></i></p>
								</button>
							</div>
						</div>
						<div id="charts_widget_2_chart"></div>
					</div>
				</div>

				<div class="row">
					<div class="col-7">
						<div class="box bg-warning">
							<div class="box-body">
								<h2 class="my-0 fw-600 text-white">{{ number_format($courseCount) }}+</h2>
								<p class="mb-10 text-white-80">Completed Course</p>
							</div>
						</div>
					</div>
					<div class="col-5">
						<div class="box bg-danger">
							<div class="box-body">
								<h2 class="my-0 fw-600 text-white">{{ number_format($videoCourseCount) }}+</h2>
								<p class="mb-10 text-white-80">Video Course</p>
							</div>
						</div>
						<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-xl modal-dialog-centered">
								<div class="modal-content">
									<div class="ratio ratio-16x9">
										<iframe
											src="http://player.vimeo.com/video/473177594?title=0&amp;portrait=0&amp;byline=0&amp;autoplay=1"
											title="video" allowfullscreen></iframe>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="col-xl-4 col-12">
				<div class="box no-shadow mb-0 bg-transparent">
					<div class="box-header no-border px-0">
						<h3 class="fw-500 box-title">Best Instructors</h3>
						<div class="box-controls pull-right d-md-flex d-none">
							<a href="#">See All</a>
						</div>
					</div>
				</div>
				<div>

					@foreach($teachers as $teacher)
						<div class="box mb-15 pull-up">
							<div class="box-body">
								<div class="d-flex align-items-center justify-content-between">

									<!-- LEFT -->
									<div class="d-flex align-items-center">
										<div class="me-15 mb-1">
											<img src="{{ $teacher->profile_picture ? asset('storage/' . $teacher->profile_picture) : url('src/images/avatar/avatar-1.png') }}"
												class="bg-primary-light avatar avatar-lg rounded-circle" alt="">
										</div>

										<div class="d-flex flex-column fw-500">
											<a href="#" class="text-dark hover-primary mb-1 fs-16">
												{{ $teacher->full_name }}
											</a>

											<span class="text-fade">
												{{ $teacher->total_experience ?? 0 }} Years Experience
											</span>
										</div>
									</div>

									<!-- RIGHT -->
									<div class="d-flex align-items-center">
										<!--<a href="#" class="waves-effect waves-light btn btn-sm btn-secondary ms-10">-->
										<!--	View Profile-->
										<!--</a>-->
									</div>
								</div>
							</div>
						</div>
					@endforeach

				</div>
			</div>
			<div class="col-xl-6 col-12">
				<div class="box">
					<div class="box-header no-border">
						<h3 class="box-title">Top 5 Test Performance</h3>
					</div>
					<div class="box-body">
						<div id="performance_chart"></div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-12">
				<div class="box">
					<div class="box-header no-border">
						<h3 class="box-title">Overall Pass Percentage</h3>
					</div>
					<div class="box-body" style="min-height: 275px;">
						<div id="pass_chart"></div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-12">
				<div class="box">
					<div class="box-header no-border">
						<h3 class="box-title">Content Usage</h3>
					</div>
					<div class="box-body text-center pt-60">
						<p class="text-primary">
    @if($usageChange > 0)
        {{ $usageChange }}% higher than last month
    @elseif($usageChange < 0)
        {{ abs($usageChange) }}% lower than last month
    @else
        No change from last month
    @endif
</p>
						<div id="usage_chart"></div>
					</div>
				</div>
			</div>
			<div class="col-xl-8 col-12">
				<div class="row">

					<div class="col-xl-5 col-lg-6 col-12">
						<div class="box">
							<div class="box-header no-border">
								<h3 class="box-title">Test completion</h3>
								<ul class="box-controls pull-right d-md-flex d-none">
									<li>
										<a href="https://netiias.com/design/courses.html"
											class="btn btn-primary-light px-10 base-font">View All</a>
									</li>
								</ul>
							</div>
							<div class="box-body">
								<div class="mb-25">
									<div class="d-flex align-items-center justify-content-between">
										<div class="w-p85">
											<div class="progress progress-sm mb-0">
												<div class="progress-bar progress-bar-primary" role="progressbar"
													aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
													style="width: {{ $inProgressPercent }}%">
												</div>
											</div>
										</div>
										<div>
											<div>{{ $inProgressPercent }}%</div>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<p class="mb-0 text-primary">In Progress</p>
										<p class="text-fade mb-0">{{ $inProgressTests }} Tests</p>
									</div>
								</div>
								<div class="mb-25">
									<div class="d-flex align-items-center justify-content-between">
										<div class="w-p85">
											<div class="progress progress-sm mb-0">
												<div class="progress-bar progress-bar-success" role="progressbar"
													aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
													     style="width: {{ $completedPercent }}%">
												</div>
											</div>
										</div>
										<div>
                                            <div>{{ $completedPercent }}%</div>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<p class="mb-0 text-primary">Completed</p>
										<p class="text-fade mb-0">{{ $completedTests }} Tests</p>
									</div>
								</div>
								<div class="mb-25">
									<div class="d-flex align-items-center justify-content-between">
										<div class="w-p85">
											<div class="progress progress-sm mb-0">
												<div class="progress-bar progress-bar-warning" role="progressbar"
													aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"
													style="width: {{ $inactivePercent }}%">
												</div>
											</div>
										</div>
										<div>
											<div>{{ $inactivePercent }}%</div>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<p class="mb-0 text-primary">Inactive</p>
										<p class="text-fade mb-0">{{ $inactiveTests }} Tests</p>
									</div>
								</div>
								
							</div>
						</div>
					</div>

					<!-- upcoming class start -->
					<div class="col-xl-7 col-lg-6 col-12">
						<div class="box bg-transparent no-shadow mb-30">
							<div class="box-header no-border pb-0">
								<h3 class="box-title">Upcoming Classes</h3>
								<ul class="box-controls pull-right d-md-flex d-none">
									<li>
										<a href="https://netiias.com/design/courses.html"
											class="btn btn-primary-light px-10 base-font">View All</a>
									</li>
								</ul>
							</div>
						</div>

						@forelse($upcomingClasses as $class)

							@php
								$colors = ['warning', 'primary', 'danger', 'info'];
								$color = $colors[$loop->index % count($colors)];
							@endphp

							<div class="box mb-15 pull-up">
								<div class="box-body">
									<div class="d-flex align-items-center justify-content-between">

										<!-- LEFT -->
										<div class="d-flex align-items-center">
											<div class="me-15 bg-{{ $color }} h-50 w-50 l-h-68 rounded text-center">
												<span class="icon-Book-open fs-24"></span>
											</div>

											<div class="d-flex flex-column fw-500">
												<span class="text-dark mb-1 fs-16">
													{{ $class->title ?? 'Live Class' }}
												</span>

												<span class="text-fade">
													{{ $class->teacher->full_name ?? 'Instructor' }},
													{{ \Carbon\Carbon::parse($class->schedule_date)->format('d M') }}
													at {{ $class->start_time }}
												</span>
											</div>
										</div>

										<!-- RIGHT -->
										<a href="{{  $class->live_link ?? '#' }}" target="_blank"
											class="btn btn-sm btn-{{ $color }} ms-10">
											Join Now
											<!--<span class="icon-Arrow-right fs-24"></span>-->
										</a>

									</div>
								</div>
							</div>

						@empty
							<div class="text-center text-fade">
								No Upcoming Classes
							</div>
						@endforelse


					</div>
					<!-- Upcoming Classes end -->

				</div>
			</div>

			<!-- notice board start -->
			<div class="col-xl-4 col-12">
				<div class="box">
					<div class="box-header no-border">
						<h3 class="box-title">Notice board</h3>
					</div>
					<div class="box-body p-0">
						<div class="act-div">
							<div class="media-list media-list-hover">
								@foreach($notices as $notice)

									@php
										$icon = 'fa-bell';
										$bg = 'bg-primary-light';

										if ($notice->type == 'pdf') {
											$icon = 'fa-file-pdf-o';
											$bg = 'bg-danger-light';
										} elseif ($notice->type == 'link') {
											$icon = 'fa-link';
											$bg = 'bg-info-light';
										} elseif ($notice->type == 'page') {
											$icon = 'fa-file-text-o';
											$bg = 'bg-warning-light';
										}
									@endphp

									<div class="media bar-0">
										<span class="avatar avatar-lg {{ $bg }} rounded">
											<i class="fa {{ $icon }}"></i>
										</span>

										<div class="media-body">
											<p class="d-flex align-items-center justify-content-between">

												@if($notice->type == 'pdf' && $notice->file)
													<a class="hover-success fs-16" href="{{ asset('storage/' . $notice->file) }}"
														target="_blank">
														{{ $notice->title }}
													</a>

												@elseif($notice->type == 'link' && $notice->url)
													<a class="hover-success fs-16" href="{{ $notice->url }}" target="_blank">
														{{ $notice->title }}
													</a>

												@elseif($notice->type == 'page')
													<a class="hover-success fs-16" href="{{ route('notice.show', $notice->id) }}">
														{{ $notice->title }}
													</a>
												@endif

											</p>
										</div>
									</div>

								@endforeach

							</div>
						</div>
					</div>
					<div class="box-footer text-center p-20">
						<!--<a href="{{ url('/') }}" class="btn w-p100 btn-primary-light p-5">View all</a>-->
						<a href="https://netiias.com/design/courses.html" class="btn w-p100 btn-primary-light p-5">View all</a>
					</div>
				</div>
			</div>
			<!-- notice board end -->

		</div><!-- /Desktop View -->

		<!-- Mobile View -->
		<div class="d-block d-md-none mobile-only-dashboard">
			<!-- Mobile Header -->
		

			<!-- 1st Row Cards -->
			<div class="row g-3 mb-4">
				<!-- My Orders -->
				<div class="col-3">
					<a href="{{ route('user.orders') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #e6f0fa;">
							<i data-feather="shopping-cart" style="color: #007bff; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">My Orders</div>
					</a>
				</div>
				<!-- Test Series -->
				<div class="col-3">
					<a href="{{ route('user.test-series') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #fdf5e6;">
							<i data-feather="pie-chart" style="color: #ff9f00; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">Test Series</div>
					</a>
				</div>
				<!-- Courses -->
				<div class="col-3">
					<a href="{{ route('user.mycourses') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #e6f7f5;">
							<i data-feather="book" style="color: #00bfa5; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">Courses</div>
					</a>
				</div>
				<!-- Study Material -->
				<div class="col-3">
					<a href="{{ route('user.study-material') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #fbebee;">
							<i data-feather="file-text" style="color: #e91e63; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">Study Material</div>
					</a>
				</div>
			</div>

			<!-- Green Banner (from dashboard desktop view) -->
			<div class="box bg-success rounded-4 mb-4 overflow-hidden shadow-sm border-0">
				<div class="box-body p-3">
					<h4 class="fw-bold text-white mb-2 fs-18">{{ $dashboardBanner->title ?? 'Learn Effectively With Us!' }}</h4>
					<p class="text-white-80 fs-13 mb-3">{{ $dashboardBanner->subtitle ?? 'Get 30% off every course on january.' }}</p>
					<div class="d-flex gap-4">
						<div class="d-flex align-items-center gap-2">
							<div class="bg-danger rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 32px; height: 32px;">
								<i class="fa fa-graduation-cap text-white fs-14"></i>
							</div>
							<div>
								<div class="fs-13 fw-bold text-white mb-0">{{ number_format($studentCount) }}+</div>
								<div class="fs-10 text-white-70">Students</div>
							</div>
						</div>
						<div class="d-flex align-items-center gap-2">
							<div class="bg-warning rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 32px; height: 32px;">
								<i class="fa fa-user text-white fs-14"></i>
							</div>
							<div>
								<div class="fs-13 fw-bold text-white mb-0">{{ number_format($teacherCount) }}+</div>
								<div class="fs-10 text-white-70">Mentors</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- 2nd Row Cards -->
			<div class="row g-3 mb-4">
				<!-- Test Papers -->
				<div class="col-3">
					<a href="{{ route('user.test-series') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #f5ebfa;">
							<i data-feather="file" style="color: #a020f0; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">Test Papers</div>
					</a>
				</div>
				<!-- PYQ -->
				<div class="col-3">
					<a href="{{ route('user.my-pyq-papers') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #eafbe7;">
							<i data-feather="archive" style="color: #2e7d32; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">PYQ</div>
					</a>
				</div>
				<!-- Test Results -->
				<div class="col-3">
					<a href="{{ route('user.test-papers') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #e0f7fa;">
							<i data-feather="award" style="color: #00838f; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">Test Results</div>
					</a>
				</div>
				<!-- My Wallet -->
				<div class="col-3">
					<a href="{{ route('student.wallet') }}" class="dashboard-card-container">
						<div class="dashboard-card" style="background-color: #fff3e0;">
							<i data-feather="credit-card" style="color: #ef6c00; width: 24px; height: 24px;"></i>
						</div>
						<div class="dashboard-card-label">My Wallet</div>
					</a>
				</div>
			</div>

			<!-- Notice Board -->
			<div class="box mb-4 shadow-sm border-0 rounded-3">
				<div class="box-header no-border px-3 py-3 border-bottom d-flex align-items-center justify-content-between">
					<h4 class="fw-bold text-dark mb-0 fs-18">Notice Board</h4>
					<a href="{{ url('/') }}" class="text-primary fs-14 text-decoration-none fw-bold">View All</a>
				</div>
				<div class="box-body p-3">
					<div class="notice-board-scroll">
						<div class="media-list">
							@forelse($notices as $notice)
								@php
									$icon = 'fa-bell';
									$bg = 'bg-primary-light';
									$textColor = 'text-primary';

									if ($notice->type == 'pdf') {
										$icon = 'fa-file-pdf-o';
										$bg = 'bg-danger-light';
										$textColor = 'text-danger';
									} elseif ($notice->type == 'link') {
										$icon = 'fa-link';
										$bg = 'bg-info-light';
										$textColor = 'text-info';
									} elseif ($notice->type == 'page') {
										$icon = 'fa-file-text-o';
										$bg = 'bg-warning-light';
										$textColor = 'text-warning';
									}
								@endphp
								<div class="d-flex align-items-center gap-3 py-2 border-bottom last-border-none">
									<div class="avatar avatar-md rounded d-flex align-items-center justify-content-center {{ $bg }}" style="width: 42px; height: 42px; flex-shrink: 0;">
										<i class="fa {{ $icon }} {{ $textColor }} fs-18"></i>
									</div>
									<div class="flex-grow-1 overflow-hidden">
										@if($notice->type == 'pdf' && $notice->file)
											<a class="text-dark hover-primary fs-15 text-overflow fw-500 text-decoration-none" href="{{ asset('storage/' . $notice->file) }}" target="_blank">
												{{ $notice->title }}
											</a>
										@elseif($notice->type == 'link' && $notice->url)
											<a class="text-dark hover-primary fs-15 text-overflow fw-500 text-decoration-none" href="{{ $notice->url }}" target="_blank">
												{{ $notice->title }}
											</a>
										@elseif($notice->type == 'page')
											<a class="text-dark hover-primary fs-15 text-overflow fw-500 text-decoration-none" href="{{ route('notice.show', $notice->id) }}">
												{{ $notice->title }}
											</a>
										@endif
									</div>
								</div>
							@empty
								<div class="text-center py-3 text-fade">No notices available</div>
							@endforelse
						</div>
					</div>
				</div>
			</div>

			<!-- Tabs -->
			<div class="mb-4">
				<ul class="nav nav-pills custom-dashboard-tabs mb-3 d-flex justify-content-between p-1 bg-light rounded-pill" role="tablist">
					<li class="nav-item flex-grow-1 text-center" role="presentation">
						<a class="nav-link active rounded-pill py-2 px-1  text-center" id="pills-test-tab" data-toggle="pill" data-target="#pills-test" data-bs-toggle="pill" data-bs-target="#pills-test" href="#pills-test" role="tab" aria-controls="pills-test" aria-selected="true">
							Test Progress
						</a>
					</li>
					<li class="nav-item flex-grow-1 text-center" role="presentation">
						<a class="nav-link rounded-pill py-2 px-1  text-center" id="pills-classes-tab" data-toggle="pill" data-target="#pills-classes" data-bs-toggle="pill" data-bs-target="#pills-classes" href="#pills-classes" role="tab" aria-controls="pills-classes" aria-selected="false">
							Live Classes
						</a>
					</li>
					<li class="nav-item flex-grow-1 text-center" role="presentation">
						<a class="nav-link rounded-pill py-2 px-1  text-center" id="pills-instructors-tab" data-toggle="pill" data-target="#pills-instructors" data-bs-toggle="pill" data-bs-target="#pills-instructors" href="#pills-instructors" role="tab" aria-controls="pills-instructors" aria-selected="false">
							Instructors
						</a>
					</li>
				</ul>
				
				<div class="tab-content" id="pills-tabContent">
					<!-- Tab 1: Test Completions -->
					<div class="tab-pane fade show active" id="pills-test" role="tabpanel" aria-labelledby="pills-test-tab">
						<div class="premium-mobile-card">
							<h5 class="fw-bold mb-4 fs-16 text-dark text-start">Test Completions</h5>
							<!-- In Progress -->
							<div class="progress-bar-container">
								<div class="progress-info">
									<span class="progress-title text-primary">In Progress</span>
									<span class="progress-value">{{ $inProgressPercent }}% ({{ $inProgressTests }} Tests)</span>
								</div>
								<div class="custom-progress">
									<div class="custom-progress-bar bg-primary" role="progressbar" style="width: {{ $inProgressPercent }}%"></div>
								</div>
							</div>
							<!-- Completed -->
							<div class="progress-bar-container">
								<div class="progress-info">
									<span class="progress-title text-success">Completed</span>
									<span class="progress-value">{{ $completedPercent }}% ({{ $completedTests }} Tests)</span>
								</div>
								<div class="custom-progress">
									<div class="custom-progress-bar bg-success" role="progressbar" style="width: {{ $completedPercent }}%"></div>
								</div>
							</div>
							<!-- Inactive -->
							<div class="progress-bar-container mb-0">
								<div class="progress-info">
									<span class="progress-title text-warning">Inactive</span>
									<span class="progress-value">{{ $inactivePercent }}% ({{ $inactiveTests }} Tests)</span>
								</div>
								<div class="custom-progress">
									<div class="custom-progress-bar bg-warning" role="progressbar" style="width: {{ $inactivePercent }}%"></div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Tab 2: Upcoming Classes -->
					<div class="tab-pane fade" id="pills-classes" role="tabpanel" aria-labelledby="pills-classes-tab">
						<div class="premium-mobile-card">
							<h5 class="fw-bold mb-3 fs-16 text-dark text-start">Upcoming Classes</h5>
							<div>
								@forelse($upcomingClasses as $class)
									@php
										$colors = ['warning', 'primary', 'danger', 'info'];
										$color = $colors[$loop->index % count($colors)];
									@endphp
									<div class="premium-list-item">
										<div class="d-flex align-items-center flex-grow-1 overflow-hidden">
											<div class="course-avatar bg-{{ $color }}-light text-{{ $color }}">
												<i class="fa fa-book fs-16"></i>
											</div>
											<div class="course-details">
												<span class="course-title text-dark fw-bold">{{ $class->title ?? 'Live Class' }}</span>
												<span class="text-fade fs-11 text-start">
													{{ $class->teacher->full_name ?? 'Instructor' }},
													{{ \Carbon\Carbon::parse($class->schedule_date)->format('d M') }} at {{ $class->start_time }}
												</span>
											</div>
										</div>
										<a href="{{ $class->live_link ?? '#' }}" target="_blank" class="premium-view-btn">
											Join
										</a>
									</div>
								@empty
									<div class="text-center py-3 text-fade">No Upcoming Classes</div>
								@endforelse
							</div>
						</div>
					</div>
					
					<!-- Tab 3: Best Instructors -->
					<div class="tab-pane fade" id="pills-instructors" role="tabpanel" aria-labelledby="pills-instructors-tab">
						<div class="premium-mobile-card">
							<h5 class="fw-bold mb-3 fs-16 text-dark text-start">Best Instructors</h5>
							<div>
								@forelse($teachers as $teacher)
									<div class="premium-list-item">
										<div class="d-flex align-items-center flex-grow-1 overflow-hidden">
											<img src="{{ $teacher->profile_picture ? asset('storage/' . $teacher->profile_picture) : url('src/images/avatar/avatar-1.png') }}"
												 class="avatar rounded-circle border" alt="Instructor" style="width: 44px; height: 44px; object-fit: cover; flex-shrink: 0;">
											<div class="course-details">
												<span class="course-title text-dark fw-bold">{{ $teacher->full_name }}</span>
												<span class="text-fade fs-11 text-start">{{ $teacher->total_experience ?? 0 }} Years Experience</span>
											</div>
										</div>
										<a href="#" class="premium-view-btn">
											Profile
										</a>
									</div>
								@empty
									<div class="text-center py-3 text-fade">No instructors available</div>
								@endforelse
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Popular Courses -->
			<div class="premium-mobile-card mb-4">
				<div class="d-flex align-items-center justify-content-between mb-3">
					<h4 class="fw-bold text-dark mb-0 fs-18">Popular Courses</h4>
					<a href="{{ route('courses') }}" class="text-primary fs-14 text-decoration-none fw-bold">All Courses</a>
				</div>
				<div>
					@forelse($courses as $course)
						@php   
							$colors = ['warning', 'danger', 'success', 'primary'];
							$color = $colors[$loop->index % count($colors)];
						@endphp
						<div class="premium-list-item">
							<div class="d-flex align-items-center flex-grow-1 overflow-hidden">
								<div class="course-avatar bg-{{ $color }}-light text-{{ $color }}">
									{{ strtoupper(substr($course->title ?? $course->name, 0, 1)) }}
								</div>
								<div class="course-details">
									<a href="{{ route('courses.detail', $course->id) }}" class="course-title text-decoration-none">
										{{ $course->title ?? $course->name }}
									</a>
									<span class="course-price">₹{{ $course->offered_price ?? 0 }}</span>
								</div>
							</div>
							<a href="{{ route('courses.detail', $course->id) }}" class="premium-view-btn">
								View
							</a>
						</div>
					@empty
						<div class="text-center py-3 text-fade">No courses available</div>
					@endforelse
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->

	<script>
    var testNames = @json($testNames);
    var testScores = @json($testScores);
    var passData = [{{ $passed }}, {{ $failed }}];
	var usageData = @json($usageData);
    var monthlyProgress = @json($monthlyProgress);

</script>
@endsection