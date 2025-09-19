@extends('front.partials.app')
@section('header')
	<title>{{$seo->title?? $about->heading1}}</title>
	<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
    <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection
@section('content')
<body class="hidden-bar-wrapper">
	<!-- Page Title -->
	<section class="page-title">
		<div class="auto-container">
			<h2>Adhyayanam IAS</h2>
			<ul class="bread-crumb clearfix">
				<li><a href="{{url('/')}}">Home</a></li>
				<li>About us</li>
			</ul>
		</div>
	</section>
	<!-- End Page Title -->

	<!-- Choose Section Two -->
	<section class="choose-section-two">
		<div class="icon-one" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="icon-two" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="icon-three" style="background-image: url(images/icons/icon-6.png)"></div>
		<div class="auto-container">
			<div class="row clearfix">
				<div class="col-12">
					<iframe width="100%" height="500" src="{{$about->youtube_url}}"
						title="YouTube video player" frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
						referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				</div>

				<!-- Content Column -->
				<div class="col-12">
					<div class="contents mt-40">
						
						{!!$about->description1!!}
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Choose Section Two -->

	<!-- Featured Section / Style Two -->
	<section class="featured-section style-two">
		<div class="auto-container">
			<div class="inner-container">
				<div class="pattern-layer" style="background-image: url(images/background/pattern-5.png)"></div>
				<div class="row clearfix">

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="icon flaticon-book"></div>
							<h4><a href="course-detail.html">100% Graduate course</a></h4>
							<div class="text">100+ Video Course inside</div>
						</div>
					</div>

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="icon flaticon-identification"></div>
							<h4><a href="course-detail.html">Learn with experts</a></h4>
							<div class="text">Learn our course with Expert</div>
						</div>
					</div>

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="icon flaticon-certificate"></div>
							<h4><a href="course-detail.html">Online degrees</a></h4>
							<div class="text">Get Online Degree certificate</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- End Featured Section / Style Two -->

	<!-- Counter Boxed -->
	<section class="counter-section">
		<div class="auto-container">
			<div class="inner-container">
				<div class="row clearfix">

					<!-- Counter Column -->
					<div class="counter-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon osdx"><img src="images/stu.png" alt="" /></span>
							<div class="counter"><span class="odometer" data-count="415"></span> +</div>
							<div class="counter-text">Students Enrolled</div>
						</div>
					</div>

					<!-- Counter Column -->
					<div class="counter-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon osdx"><img src="images/class-c.png" alt="" /></span>
							<div class="counter"><span class="odometer" data-count="5"></span> k+</div>
							<div class="counter-text">Class Completed</div>
						</div>
					</div>

					<!-- Counter Column -->
					<div class="counter-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon osdx"><img src="images/skins.png" alt="" /></span>
							<div class="counter"><span class="odometer" data-count="20"></span> +</div>
							<div class="counter-text">Skilled Instructors</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- End Counter Boxed -->


	<!-- Join Section -->
	<section class="join-section">
		<div class="icon-one" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="icon-two" style="background-image: url(images/icons/icon-2.png)"></div>
		<div class="auto-container">
			<div class="row clearfix">

				<!-- Image Column -->
				<div class="image-column col-lg-6 col-md-12 col-sm-12">
					<div class="inner-column">
						<div class="pattern-layer" style="background-image: url(images/background/pattern-7.png)"></div>
						<div class="pattern-layer-two" style="background-image: url(images/background/pattern-8.png)"></div>
						<div class="image titlt" data-tilt data-tilt-max="4">
							<img src="images/resource/join.jpg" alt="" />
						</div>
					</div>
				</div>

				<!-- Content Column -->
				<div class="content-column col-lg-6 col-md-12 col-sm-12">
					<div class="inner-column">
						<!-- Sec Title -->
						<div class="sec-title">
							<div class="title">Join us</div>
							<h2>Come join us as we <br> spread knowledge.</h2>
							<div class="text">Create online courses and coaching services.t is a long established fact that a reader
								will be distracted by the readable content of a page when looking at its layout. </div>
						</div>
						<div class="button-box">
							<a href="./career.html" class="theme-btn btn-style-three"><span class="txt">Teaching Now</span></a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Join Section -->

	<!-- Testimonial Section Two -->
	<section class="testimonial-section-two">
		<div class="icon-layer-one" style="background-image: url(images/icons/icon-7.png)"></div>
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title">
				<!-- <div class="title">Student Review</div> -->
				<h2>Our Students <br> Review</h2>
			</div>
			<div class="two-item-carousel owl-carousel owl-theme">

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-7.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								CA Student
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-8.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								CA Student
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-7.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								CA Student
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-8.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								Online Lecturer and businees
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-7.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								Online Lecturer and businees
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-8.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								Online Lecturer and businees
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Testimonial Section Two -->
	<section class="faq-section osd">
		<div class="auto-container">
			<!-- Title Box -->
			<div class="title-box">
				<h3>FAQ's</h3>
			</div>
			<div class="inner-container">

				<!-- Accordion Box -->
				<ul class="accordion-box">

					@foreach($faqs as $index => $faq)
					<li class="accordion block">
						<div class="acc-btn {{ $index === 0 ? 'active' : '' }}">
							<div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
									class="icon icon-minus flaticon-minus-1"></span></div>{{$faq->question}}</div>
						<div class="acc-content {{ $index === 0 ? 'current' : '' }}">
							<div class="content">
								<div class="text">{{$faq->answer}}</div>
							</div>
						</div>
					</li>
					@endforeach

				</ul>

			</div>
		</div>
	</section>
</body>
@endsection