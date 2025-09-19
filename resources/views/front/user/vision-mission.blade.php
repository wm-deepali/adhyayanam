@extends('front.partials.app')
@section('header')
		<title>{{$seo->title ?? 'Vision & Mission'}}</title>
		<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
		<meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
		<link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Vision & Mission</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
<section class="popular-test-series">
			<div class="auto-container">
				<div class="row clearfix">
				    <!-- Content Column -->
					<div class="content-column col-lg-6 col-md-12 col-sm-12  contss">
						<div class="inner-columns">
							<!-- Sec Title -->
							<div class="sec-title osd-test">
							
								<h2>{{$vision->heading1}}</h2>
							</div>
							<div class="text">{{$vision->description1}}</div>
						
						</div>
					</div>
					<!-- Image Column -->
					<div class="image-column col-lg-6 col-md-12 col-sm-12   imgs">
						<div class="inner-column">
							<div class="pattern-one" style="background-image: url(images/background/pattern-1.png)"></div>
							<div class="image titlt" data-tilt="" data-tilt-max="4" style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
								<img src="{{asset('storage/' . $vision->image1) }}" alt="">
							</div>

						</div>
					</div>
						<div class="image-column col-lg-6 col-md-12 col-sm-12 imgs">
						<div class="inner-column">
							<div class="pattern-one" style="background-image: url(images/background/pattern-1.png)"></div>
							<div class="image titlt" data-tilt="" data-tilt-max="4" style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
								<img src="{{asset('storage/' . $vision->image2) }}" alt="">
							</div>

						</div>
					</div>
					<div class="content-column col-lg-6 col-md-12 col-sm-12 contss">
						<div class="inner-columns">
							<!-- Sec Title -->
							<div class="sec-title osd-test">
							
								<h2>{{$vision->heading2}}</h2>
							</div>
							<div class="text">{{$vision->description2}}</div>
						
						</div>
					</div>
					

				</div>
			</div>
	
	</section>
</body>
@endsection