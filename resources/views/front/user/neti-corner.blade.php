@extends('front.partials.app')
@section('header')
		<title>{{'Adhyayanam Education Corner'}}</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam IAS</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>Adhyayanam Corner</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="course-page-section-two">
    <div class="auto-container">

      <div class="top-banner-sm">
        <div class="image">
          <img src="images/main-slider/slider2.png" alt="">
        </div>
      </div>

  </section>
  <!-- Testimonial Section Two -->
  <section class="testimonial-section-two" style="padding-top: 0px;">
    <div class="icon-layer-one" style="background-image: url(images/icons/icon-7.png)"></div>
    <div class="auto-container">
      <!-- Sec Title -->
      <div class="sec-title">
        <h2>Our Successful Best <br> Students Review</h2>
      </div>
      <div class="two-item-carousel owl-carousel owl-theme">
        <!-- Testimonial Block -->
        @foreach($testimonials as $data)
        <div class="testimonial-block">
          <div class="inner-box">
            <div class="text">{{$data->message}} </div>
            <!-- Author Box -->
            <div class="author-box">
              <div class="box-inner">
                <div class="author-image">
                  <img src="{{url('uploads/feed-photos/'.$data->photo)}}" alt="{{$data->message}}" />
                </div>
                <strong>{{$data->username}}</strong>
                <span class="quote-icon"><img src="{{url('images/icons/quote-icon.png')}}" alt="" /></span>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
</body>
@endsection