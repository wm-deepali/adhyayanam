@extends('front.partials.app')
{{-- @section('header')
<title>{{$seo->title ?? $cookies->heading1}}</title>
<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
<meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
<link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection --}}
@section('content')

	<body class="hidden-bar-wrapper">
		<!-- Page Title -->
		<section class="page-title">
			<div class="auto-container">
				<h2>Adhyayanam</h2>
				<ul class="bread-crumb clearfix">
					<li><a href="index.html">Home</a></li>
					<li>Course</li>
				</ul>
			</div>
		</section>
		<!-- End Page Title -->

		<!-- Course Section -->
		<section class="course-page-section-two">
			<div class="container">
				<div class="row clearfix">

					<!-- Sidebar Column -->
					<div class="sidebar-column col-lg-3 col-md-8 col-sm-12">
						<!-- Search Widget -->
						<div class="sidebar-widget search-box">
							<div class="widget-content">
								<form method="GET" action="{{ route('courses.filter', ['id' => $subcat]) }}"
									id="searchForm">
									<div class="form-group">
										<input type="search" name="search" value="{{ request('search') ?? '' }}"
											placeholder="Search">
										<button type="submit"><span class="icon fa fa-search"></span></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Blocks Column -->
					<div class="blocks-column col-lg-9 col-md-12 col-sm-12">

						<!-- Filter Box -->
						<div class="filter-box">

							<!-- Dropdown Filters Start -->
							<form method="GET" action="{{ route('courses.filter', ['id' => $subcat]) }}" id="filterForm"
								class="mb-3">
								<div class="row g-2">

									<!-- Subject -->
									<div class="col">
										<select name="subject_id" class="form-control">
											<option value="">--Select Subject--</option>
											@foreach($subjects as $subject)
												<option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
													{{ $subject->name }}
												</option>
											@endforeach
										</select>
									</div>

									<!-- Chapter -->
									<div class="col">
										<select name="chapter_id" class="form-control">
											<option value="">--Select Chapter--</option>
											@foreach($chapters as $chapter)
												<option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>
													{{ $chapter->name }}
												</option>
											@endforeach
										</select>
									</div>

									<!-- Topic -->
									<div class="col">
										<select name="topic_id" class="form-control">
											<option value="">--Select Topic--</option>
											@foreach($topics as $topic)
												<option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
													{{ $topic->name }}
												</option>
											@endforeach
										</select>
									</div>

									<!-- Submit Button -->
									<div class="col-auto">
										<button type="submit" class="btn btn-primary">Filter</button>
									</div>

								</div>
							</form>
							<!-- Dropdown Filters End -->
						</div>

						<!-- End Filter Box -->

						<div class="row clearfix">
							<!-- SM Block Five -->
							@foreach($courses as $course)
								<div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
									<div class="inner-box">
										<div class="image">
											<div class="tag">{{$course->examinationCommission->name}}</div>
											<a href="{{route('courses.detail', $course->id)}}"><img
													src="{{url('storage/' . $course->thumbnail_image)}}"
													alt="{{$course->image_alt_tag}}"></a>
										</div>
										<div class="lower-content">
											<div class="content">
												<div class="d-flex justify-content-between align-items-center">
													<ul class="feature-list">
														<li><span class="osd flaticon-hourglass"></span> <span
																class="osd tt">{{$course->duration}} Week</span></li>
													</ul>
													<div class="price">RS. {{$course->offered_price}}</div>

												</div>
												<h4><a href="service-detail.html">{{$course->name}}</a></h4>
												<div class="contents">
													<p class="mb-1">{{$course->course_heading}}</p>

													<small class="text-muted d-flex align-items-center gap-1">
														<span class="flaticon-internet"></span>
														<span>
															Learning Method: {{ $course->course_mode ?? 'Online' }}
														</span>
													</small>
												</div>

											</div>
											<div class="lower-box osd m">
												<div class="d-flex justify-content-between align-items-center">
													<div class="cm">
														<a class="course-btn osd"
															href="{{route('courses.detail', $course->id)}}">Register Now <span
																class="flaticon-arrow-pointing-to-right"></span></a>
													</div>
													<div class="cmm">
														<a class="course-btn osd"
															href="{{route('courses.detail', $course->id)}}">View
															Details <span class="flaticon-arrow-pointing-to-right"></span></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>


						<!-- Styled Pagination -->
						<ul class="styled-pagination">
							<li><a href="#" class="active">1</a></li>
							<li class="next"><a href="#"><span class="flaticon-arrow-pointing-to-right"></span></a></li>
						</ul>
						<!-- End Styled Pagination -->
					</div>
				</div>
			</div>
		</section>
	</body>
@endsection