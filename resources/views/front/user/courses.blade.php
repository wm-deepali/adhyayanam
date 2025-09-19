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
	<section class="course-page-section osd">
		<div class="auto-container">
			<div class="row clearfix">
				@foreach($courses as $course)
				<div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image">
							<div class="tag">{{$course->examinationCommission->name}}</div>
							<a href="{{route('courses.detail',$course->id)}}"><img src="{{url('storage/'.$course->thumbnail_image)}}" alt="{{$course->image_alt_tag}}"></a>
						</div>
						<div class="lower-content">
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<ul class="feature-list">
										<li><span class="osd flaticon-hourglass"></span> <span class="osd tt">{{$course->duration}} Week</span></li>
									</ul>
									<div class="price">RS. {{$course->offered_price}}</div>
								</div>
								<h4><a href="service-detail.html">{{$course->name}}</a></h4>
								<div class="contents">
									<p>{{$course->course_heading}}</p>
								</div>
								<!-- <ul class="course-options">
									<li><span class="icon flaticon-book-1"></span>10 lessons</li>
									<li><span class="icon flaticon-user-1"></span>15 Students</li>
								</ul> -->
							</div>
							<div class="lower-box osd m">
								<div class="d-flex justify-content-between align-items-center">
									<div class="cm">
										<a class="course-btn osd" href="{{route('courses.detail',$course->id)}}">Register Now <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
									<div class="cmm">
										<a class="course-btn osd" href="{{route('courses.detail',$course->id)}}">View Details <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				{{-- <div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image">
							<div class="tag">UPSC</div>
							<a href="course-detail.html"><img src="images/resource/course-13.jpg" alt=""></a>
						</div>
						<div class="lower-content">
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<ul class="feature-list">
										<li><span class="osd flaticon-hourglass"></span> <span class="osd tt">4 Week</span></li>
									</ul>
									<div class="price">RS. 60.00</div>
								</div>
								<h4><a href="service-detail.html">IAS/UPSC Foundation Courses </a></h4>
								<div class="contents">
									<p>Live online classes offer the flexibility of access, expert guidance at your home, real-hourglass
										doubt
										solutions, interaction with other....</p>
								</div>
								<!-- <ul class="course-options">
									<li><span class="icon flaticon-book-1"></span>10 lessons</li>
									<li><span class="icon flaticon-user-1"></span>15 Students</li>
								</ul> -->
							</div>
							<div class="lower-box osd m">
								<div class="d-flex justify-content-between align-items-center">
									<div class="cm">
										<a class="course-btn osd" href="course-detail.html">Register Now <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
									<div class="cmm">
										<a class="course-btn osd" href="course-detail.html">View Details <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image">
							<div class="tag">UPSC</div>
							<a href="course-detail.html"><img src="images/resource/course-13.jpg" alt=""></a>
						</div>
						<div class="lower-content">
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<ul class="feature-list">
										<li><span class="osd flaticon-hourglass"></span> <span class="osd tt">4 Week</span></li>
									</ul>
									<div class="price">RS. 60.00</div>
								</div>
								<h4><a href="service-detail.html">IAS/UPSC Foundation Courses </a></h4>
								<div class="contents">
									<p>Live online classes offer the flexibility of access, expert guidance at your home, real-hourglass
										doubt
										solutions, interaction with other....</p>
								</div>
								<!-- <ul class="course-options">
									<li><span class="icon flaticon-book-1"></span>10 lessons</li>
									<li><span class="icon flaticon-user-1"></span>15 Students</li>
								</ul> -->
							</div>
							<div class="lower-box osd m">
								<div class="d-flex justify-content-between align-items-center">
									<div class="cm">
										<a class="course-btn osd" href="course-detail.html">Register Now <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
									<div class="cmm">
										<a class="course-btn osd" href="course-detail.html">View Details <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image">
							<div class="tag">UPSC</div>
							<a href="course-detail.html"><img src="images/resource/course-13.jpg" alt=""></a>
						</div>
						<div class="lower-content">
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<ul class="feature-list">
										<li><span class="osd flaticon-hourglass"></span> <span class="osd tt">4 Week</span></li>
									</ul>
									<div class="price">RS. 60.00</div>
								</div>
								<h4><a href="service-detail.html">IAS/UPSC Foundation Courses </a></h4>
								<div class="contents">
									<p>Live online classes offer the flexibility of access, expert guidance at your home, real-hourglass
										doubt
										solutions, interaction with other....</p>
								</div>
								<!-- <ul class="course-options">
									<li><span class="icon flaticon-book-1"></span>10 lessons</li>
									<li><span class="icon flaticon-user-1"></span>15 Students</li>
								</ul> -->
							</div>
							<div class="lower-box osd m">
								<div class="d-flex justify-content-between align-items-center">
									<div class="cm">
										<a class="course-btn osd" href="course-detail.html">Register Now <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
									<div class="cmm">
										<a class="course-btn osd" href="course-detail.html">View Details <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image">
							<div class="tag">UPSC</div>
							<a href="course-detail.html"><img src="images/resource/course-13.jpg" alt=""></a>
						</div>
						<div class="lower-content">
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<ul class="feature-list">
										<li><span class="osd flaticon-hourglass"></span> <span class="osd tt">4 Week</span></li>
									</ul>
									<div class="price">RS. 60.00</div>
								</div>
								<h4><a href="service-detail.html">IAS/UPSC Foundation Courses </a></h4>
								<div class="contents">
									<p>Live online classes offer the flexibility of access, expert guidance at your home, real-hourglass
										doubt
										solutions, interaction with other....</p>
								</div>
								<!-- <ul class="course-options">
									<li><span class="icon flaticon-book-1"></span>10 lessons</li>
									<li><span class="icon flaticon-user-1"></span>15 Students</li>
								</ul> -->
							</div>
							<div class="lower-box osd m">
								<div class="d-flex justify-content-between align-items-center">
									<div class="cm">
										<a class="course-btn osd" href="course-detail.html">Register Now <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
									<div class="cmm">
										<a class="course-btn osd" href="course-detail.html">View Details <span
												class="flaticon-arrow-pointing-to-right"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> --}}

			</div>
		</div>
	</section>
</body>
@endsection