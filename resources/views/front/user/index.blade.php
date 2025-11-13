@extends('front.partials.app')
@section('header')
	  <title>Home|Adhyayanam IAS</title>
	  <meta name="description" content="Default Description">
    <meta name="keywords" content="default, keywords">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@section('content')
<body class="hidden-bar-wrapper">
	<!-- Page Load Modal -->
	@if(isset($popup) && isset($popup->pop_image))
        <div class='popup-onload'>
            <div class='cnt223'>
                <img src="{{ asset('storage/'.$popup->pop_image) }}" />
                <i class="fa fa-close close"></i>
            </div>
        </div>
    @endif

	<!-- Main Slider Section -->
	<section class="main-slider">
		<div class="main-slider-carousel owl-carousel owl-theme">

			<!-- Slide -->
			@foreach($banners->sortBy('position') as $data)
                <div class="slide" style="padding: 0px;">
                    <div class="f">
                        <a href="{{ isset($data->link) ? $data->link : '#' }}" target="_blank"><img src="{{ asset('storage/'.$data->image) }}" /></a>
                    </div>
                </div>
            @endforeach

		</div>
	</section>
	<section class="current-aff-osd">
		<div class="auto-container">
			<!-- Current Affairs Block -->
			<div class="row">
				<div class="col-12">
					<div class="sec-title centered">
						<h2 class="mb-osd">Current Affairs </h2>
					</div>
				</div>
				<div class="filter-box">
					<div class="d-flex justify-content-between align-items-center flex-wrap">
						<!-- Left Box -->
						<div class="left-box d-flex align-items-center">
							<div class="results date-filter"><input type="date" name="search" placeholder="Filter Date" required="">
							</div>
						</div>
						<!-- Right Box -->
						<div class="right-box d-flex align-items-center">
							<form method="post" action="#">
								<div class="form-group">
									<input type="search" name="search-field" value="" placeholder="Search" required="">
									<button type="submit"><span class="icon flaticon-search-1"></span></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				@foreach($topics as $topic)
				<div class="col-sm-12 col-md-6">
				  <div class="smaterial-box scrl">
						<div class="content">
							<h4 class="osd sm">{{$topic->name}}</h4>
							<div class="caf-n l">
								<ul>
								@if($topic->currentAffair)
								@foreach($topic->currentAffair as $affair)
								<li>
									<a href="{{route('current.details',$affair->id)}}">{{$affair->title.': '.$affair->short_description}}</a>
								</li>
								@endforeach
								@endif
								</ul>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				<div class="col-12">
					<div class="button-box">
						<a href="{{route('current.index')}}" class="theme-btn btn-style-three"><span class="txt">View All</span></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- current affairs end  -->
	<!-- Featured Section -->
	<section class="featured-section">
		<div class="auto-container">
			<div class="inner-container">
				<div class="row clearfix">

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="icon"><img style="max-width:70px;" src="{{ asset('storage/'.$feature->icon1) }}" alt=""></div>
                            <h4><a href="#">{{ $feature->title1 }}</a></h4>
                            <div class="text">{{ $feature->short_description1 }}</div>
                        </div>
                    </div>
                    
                    <!-- Feature Block -->
                    <div class="feature-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="icon"><img style="max-width:70px;" src="{{ asset('storage/'.$feature->icon2) }}" alt=""></div>
                            <h4><a href="#">{{ $feature->title2 }}</a></h4>
                            <div class="text">{{ $feature->short_description2 }}</div>
                        </div>
                    </div>
                    
                    <!-- Feature Block -->
                    <div class="feature-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="icon"><img style="max-width:70px;" src="{{ asset('storage/'.$feature->icon3) }}" alt=""></div>
                            <h4><a href="#">{{ $feature->title3 }}</a></h4>
                            <div class="text">{{ $feature->short_description3 }}</div>
                        </div>
                    </div>


				</div>
			</div>
		</div>
	</section>
	<!-- End Featured Section -->
	<!-- Course Section -->
	<section class="course-page-section osd">
		<div class="auto-container">
			<div class="row clearfix">
				<div class="col-12">
					<div class="sec-title centered">
						<!--<div class="title">Course</div>-->
						<h2 class="mb-osd">Courses We Offers </h2>
					</div>
				</div>
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
				<div class="col-12">
					<div class="button-box">
						<a href="{{route('courses')}}" class="theme-btn btn-style-three"><span class="txt">View All</span></a>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Course Page Section -->
	<!-- Current Affairs  -->
	<section class="current-affairs-section osd">
		<div class="container-fluid">
			<div class="sec-title centered">
				<!--<div class="title">Trending</div>-->
				<h2 class="mb-osd">Our Test Series</h2>
				<!--<section class="course-page-section-two">-->
				<div class="auto-container">
					<div class="row clearfix">



						<!-- Blocks Column -->
						<div class="blocks-column col-md-12 col-sm-12">


							<!-- End Filter Box -->

							<div class="row clearfix">
								@foreach($testSeries as $data)
								<div class="course-block-two style-two col-xl-3 col-lg-6 col-md-6 col-sm-12">
									<div class="inner-box">
										<div class="image osd-f">
											<a href="test-series-detail.html"><img src="{{url('storage/'.$data->logo)}}" alt=""></a>
											<div class="user-r"><span>{{$data->users_count}} Users</span></div>
										</div>
										<div class="lower-content osdc">
											<div class="content">

												<h4><a href="test-serie-detail.html"> {{$data->title}} </a></h4>
												<div class="number-of-test">{{$data->total_chapter+$data->total_affairs+$data->total_subjects+$data->free_tests}} Test <span class="green-free">| {{$data->free_tests}} Free</span></div>
												<div class="contents">
													<ul class="lstyle">
														<li>{{$data->total_chapter}} Chapter Test</li>
														<li>{{$data->total_affairs}} Current Affairs</li>
														<li>{{$data->total_subjects}} Subject Test</li>
													</ul>
												</div>
											</div>
											<div class="bottom-btn">
												<a class="course-btn osd" href="test-series-detail.html">View Test Series</a>
											</div>
										</div>
									</div>
								</div>
								@endforeach
							</div>



						</div>
						<div class="col-12">
							<div class="button-box">
								<a href="#" class="theme-btn btn-style-three"><span class="txt">View All</span></a>
							</div>
						</div>

					</div>

				</div>
				<!--</section>-->

			</div>
	</section>

	<!-- End Current Affairs  -->
	<!-- Study Materials  -->
	 @if(isset($studyCategories) && count($studyCategories) > 0)
	<section class="current-affairs-section osdb">
		<div class="auto-container">
			<div class="sec-title centered">
				<!--<div class="title">Adhyayanam Education </div>-->
				<h2 class="mb-osd">Our Study Materials </h2>
				<div class="row">
					@foreach($studyCategories as $category)
					<div class="course-block-two col-xl-3 col-lg-4 col-md-4 col-sm-6">
						<div class="inner-box">
							<div class="image">
								<a href="{{route('study.material.front')}}"><img src="{{ url('storage/'.$category->image)}}" alt="{{$category->alt_tag ?? ''}}" style="height:254px;"></a>
							</div>
							<div class="lower-content osd">
								<div class="content">
									<h4><a href="{{route('study.material.front')}}">{{$category->name}}</a></h4>

								</div>
							</div>
						</div>
					</div>
					@endforeach
					
					<div class="col-12">
						<div class="button-box">
							<a href="{{route('study.material.front')}}" class="theme-btn btn-style-three"><span class="txt">View All</span></a>
						</div>
					</div>
				</div>

			</div>
	</section>
@endif
	<!-- End Study Materials  -->
	<!-- Courses Section -->
	<section class="courses-section">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<h2>Daily Booster Videos</h2>
				<div class="title cavid">Trending Current Affairs</div>
			</div>
			<div class="row clearfix video">
				@foreach($dailyBoosts as $data)
				<div class="course-block-two col-xl-3 col-lg-6 col-md-6 col-sm-12">
				  <div class="video-inner-box x text-center">
					<a href="{{$data->youtube_url}}" target="_blank"> <img
						src="{{url('storage/'.$data->thumbnail)}}" />
					  <svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%">
						<path class="ytp-large-play-button-bg"
						  d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"
						  fill="#f00"></path>
						<path d="M 45,24 27,14 27,34" fill="#fff"></path>
					  </svg>
					</a>
				  </div>
				</div>
				@endforeach
				<div class="col-12">
					<!-- Bottom Box -->
					<div class="bottom-box text-center">
						<div class="button-box">
							<a href="{{route('daily.boost.front')}}" class="theme-btn btn-style-three"><span class="txt">View All Videos</span></a>
						</div>
					</div>
				</div>

			</div>



		</div>
	</section>

	<!-- Subject Section -->
	<section class="subject-section">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<h2>Notification</h2>
				<div class="title cavid">Upcoming Exams</div>
			</div>

			<div class="row clearfix">
				@foreach($upcomingExams as $data)
					{{--<div class="table-osd mb-5">
						<table class="osd-table" style="border-collapse: collapse; width: 100%;">
						<tbody>
							<tr>
							<td style="text-align: center; width: 99.7282%;" class="f22" colspan="6"><strong>Government
								Exams Upcoming:
								{{$data->exam_commission->name}}</strong></td>
							</tr>
							<tr>
							<td style="text-align: center; ">
								<p><strong>Name of Exam</strong></p>
							</td>
							<td style="text-align: center;">
								<p><strong>Date of Advertisement</strong></p>
							</td>
							<td style="text-align: center;">
								<p><strong>Exam Date</strong></p>
							</td>
							<td style="text-align: center;">
								<p><strong>Closing Date</strong></p>
							</td>
							<td style="text-align: center; ">
								<p><strong>Upcoming Government Exams 2024 Dates</strong></p>
							</td>
							<td style="text-align: center;">
								<p><strong>Download Details</strong></p>
							</td>
							</tr>
							
							<tr>
							<td style="text-align: center; ">
								<p><strong>{{$data->examination_name}}</strong></p>
							</td>
							<td style="text-align: center; ">{{$data->advertisement_date}}</td>
							<td style="text-align: center;">{{$data->examination_date}}</td>
							<td style="text-align: center;">{{$data->submission_last_date}}</td>
							<td style="text-align: center;">{{$data->form_distribution_date}}</td>
							<td style="text-align: center;"><a href="{{asset('storage/'.$data->pdf)}}" target="_blank" rel="noopener" download="{{$data->examination_name}}"><img
									src="{{url('/images/eye-black.png')}}" alt="" /></a></td>
							</tr>
						</tbody>
						</table>
					</div>--}}
					<div class="course-block col-lg-6 col-md-6 col-sm-12">
    					<div class="inner-box osdb">
    						<h4><a href="{{asset('public/'.$data->pdf)}}" target="_blank" rel="noopener" download="{{$data->examination_name}}">{{$data->examination_name}}; Download PDF</a></h4>
    						<div class="courses">{{$data->examination_name ??""}} has been declared on {{$data->advertisement_date ?? ""}} by {{$data->exam_commission->name ?? ""}}. Last Date of Submission {{$data->submission_last_date ?? ""}}</div>
    					</div>
    				</div>
				@endforeach
				<div class="col-12">
					<!-- Bottom Box -->
					<div class="bottom-box text-center">
						<div class="button-box">
							<a href="{{route('upcoming.exam.front')}}" class="theme-btn btn-style-three"><span class="txt">View All Upcoming Exams</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Subject Section -->




	<section class="courses-section teacher-f">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="top-content-osd">
				<h2>Adhyayanam IAS</h2>
				<div class="crack-any"> Crack any government exam with <b>India's Super Teachers</b></div>
				<div class="learn-frm">Learn from India's Best Teachers for <span class="clr-r">competitive exams</span> </div>
			</div>
			<div class="clearfix osd">
				@foreach($teams as $team)
				<div class="main-cont-teacher">
					<div class="t-box">
						<div class="t-img">
							<img src="{{url('storage/'.$team->profile_image)}}" alt="{{$team->name}}"/>
						</div>
						<div class="t-name">{{$team->name}}</div>
						<div class="taught-students">{{$team->experience}}</div>
					</div>
				</div>
				@endforeach
			</div>

		</div>
	</section>



	<!-- Testimonial Section -->
	<section class="testimonial-section osd">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<!--<div class="title">What Our Students Says!</div>-->
				<h2>Our Successful Best Students</h2>
			</div>
			<div class="three-item-carousel owl-carousel owl-theme">
				@foreach($testimonials as $data)
				<div class="testimonial-block">
				  <div class="inner-box">
					<div class="text">{{$data->message}} </div>
					<div class="author-box">
					  <div class="box-inner">
						<div class="author-image">
						  <img src="{{url('uploads/feed-photos/'.$data->photo)}}" alt="{{$data->message}}" />
						</div>
						<strong>{{$data->username}}</strong>
						<span class="quote-icon p-5"><img src="{{url('images/icons/quote-icon.png')}}" alt="" /></span>
					  </div>
					</div>
				  </div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	<!-- End Testimonial Section -->
	<section class="popular-test-series">
		<div class="auto-container">
			<div class="auto-container">
				<div class="row clearfix">
					<!-- Image Column -->
					<div class="image-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="pattern-one" style="background-image: url(images/background/pattern-1.png)"></div>
							<div class="image titlt" data-tilt="" data-tilt-max="4">
								<img src="{{asset('storage/'.$programmeFeautre->banner)}}" alt="">
							</div>

						</div>
					</div>
					<!-- Content Column -->
					<div class="content-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-columns">
							<!-- Sec Title -->
							<div class="sec-title osd-test">
								<div class="title">{{$programmeFeautre->heading}}</div>
								<h2>{{$programmeFeautre->title}}</h2>
							</div>
							<div class="text">{{$programmeFeautre->short_description}}</div>
							<div class="text-bold"><b>{{$programmeFeautre->feature}}</b></div>
							<div class="icon-box-test">
								<div class="i-bx1">
									<div class="inner-a">
										<div class="icon"><img src="{{asset('storage/'.$programmeFeautre->icon1)}}" alt="" style="max-width:40px;"/></div>
									</div>
									<div class="inner-b">{{$programmeFeautre->icon_title1}}</div>
								</div>
								<div class="i-bx1">
									<div class="inner-a">
										<div class="icon"><img src="{{asset('storage/'.$programmeFeautre->icon2)}}" alt="" style="max-width:40px;"/></div>
									</div>
									<div class="inner-b">{{$programmeFeautre->icon_title2}}</div>
								</div>
							</div>
							<div class="icon-box-test b">
								<div class="i-bx1">
									<div class="inner-a">
										<div class="icon"><img src="{{asset('storage/'.$programmeFeautre->icon3)}}" alt="" style="max-width:40px;"/></div>
									</div>
									<div class="inner-b">{{$programmeFeautre->icon_title3}}</div>
								</div>
								<div class="i-bx1">
									<div class="inner-a">
										<div class="icon"><img src="{{asset('storage/'.$programmeFeautre->icon4)}}" alt="" style="max-width:40px;"/></div>
									</div>
									<div class="inner-b">{{$programmeFeautre->icon_title4}}</div>
								</div>
							</div>
							<!-- Button Box -->
							<div class="button-box">
								<a href="#" class="theme-btn btn-style-four osd"><span class="txt">Explore</span></a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

	<!-- News Section -->
	<section class="news-section osd">
		<div class="icon-one" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="icon-two" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<!--<div class="title">News And Update</div>-->
				<h2>Learn more from our news and articles</h2>
			</div>
			<div class="swiper mySwiper">
				<div class="swiper-wrapper">
					@foreach($blogs as $blog)
					<div class="swiper-slide">
						<div class="news-block">
							<div class="inner-box wow fadeInLeft animated" data-wow-delay="0ms" data-wow-duration="1500ms"
								style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInLeft;">
								<div class="image">
									@if($blog->thumbnail)
										<a href="{{route('blog.details',$blog->id)}}"><img src="{{url('storage/'.$blog->thumbnail)}}" alt="{{$blog->heading}}" /></a>
									@else
										<a href="{{route('blog.details',$blog->id)}}"><img src="{{url('storage/'.$blog->image)}}" alt="{{$blog->heading}}" /></a>
									@endif
								</div>
								<div class="lower-content">
									<div class="tag">{{$blog->type}}</div>
									<ul class="post-info">
										<li>By {{$blog->user->name}}</li>
										<li>{{ Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</li>
									</ul>
									<h5><a href="{{route('blog.details',$blog->id)}}"> {{ Illuminate\Support\Str::limit($blog->heading, 40) }}</a></h5>
									<div class="text">{{ Illuminate\Support\Str::limit($blog->short_description, 70) }}...</div>
									<a class="more-post" href="{{route('blog.details',$blog->id)}}">Read more</a>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				<!--<div class="swiper-button-next"></div>-->
				<!--<div class="swiper-button-prev"></div>-->
				<!--<div class="swiper-pagination"></div>-->
				<div class="swiper-scrollbar"></div>
			</div>
		</div>
	</section>
	<!-- End News Section -->
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
	<script>
		var swiper = new Swiper(".mySwiper", {
			slidesPerView: 1, // Display one slide per view
			spaceBetween: 20, // Adjust spacing between slides
			breakpoints: {
				768: {
					slidesPerView: 3, // Display three slides per view on desktop
					spaceBetween: 40, // Adjust spacing between slides on desktop
				}
			},
			scrollbar: {
				el: ".swiper-scrollbar",
				hide: true,
			},
			autoplay: {
				delay: 5000, // Autoplay delay in milliseconds
				disableOnInteraction: false, // Continue autoplay even when user interacts with swiper
			},
		});
	</script>
    >
	<script>
		$(function () {
			var overlay = $('<div id="overlay"></div>');
			@if(isset($popup) && isset($popup->pop_image))
                // Show the overlay
                overlay.show();
                overlay.appendTo(document.body);
                $('.popup-onload').show();
            @endif
			$('.close').click(function () {
				$('.popup-onload').hide();
				overlay.appendTo(document.body).remove();
				return false;
			});




			$('.x').click(function () {
				$('.popup').hide();
				overlay.appendTo(document.body).remove();
				return false;
			});
		});
	</script>

</body>
@endsection