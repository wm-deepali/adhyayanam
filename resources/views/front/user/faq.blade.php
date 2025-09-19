@extends('front.partials.app')
@section('header')
	  <title>Faq's</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
	<!-- Page Title -->
	<section class="page-title">
		<div class="auto-container">
			<h2>Adhyayanam</h2>
			<ul class="bread-crumb clearfix">
				<li><a href="index.html">Home</a></li>
				<li>FAQ's</li>
			</ul>
		</div>
	</section>
	<!-- End Page Title -->

	<!-- End Testimonial Section Two -->
	<section class="faq-section">
		<div class="auto-container">
			<!-- Title Box -->
			<div class="title-box">
				<h3>FAQ's</h3>
			</div>
			<div class="inner-container">

				<!-- Accordion Box -->
				<ul class="accordion-box">

					<!-- Block -->
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