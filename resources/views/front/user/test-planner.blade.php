@extends('front.partials.app')
@section('header')
	  <title>Test Planner</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>Test Planner</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="course-page-section-two">
    <div class="auto-container">
      <div class="sec-title">
        <h2>Our Test Planner</h2>
      </div>
      <div class="row clearfix">
        @foreach($testPlans as $data)
        <div class="news-block osd col-lg-3 col-md-6 col-sm-12">
          <div class="inner-box wow fadeInLeft animated animated" data-wow-delay="0ms" data-wow-duration="1500ms"
            style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInLeft;">
            <div class="lower-content osd text-center">
              <!-- <ul class="post-info">
                <li><i class="fa fa-calender"></i> <span class="d-t"> 04 Apri 2024</span></li>
              </ul> -->
              <h5 class="mt0"><a href="#">{{$data->title}}</a></h5>
              <div class="text s">Starts on {{$data->start_date}}</div>
              <a class="tp-btn" href="{{route('test.planner.details',$data->id)}}">View Details</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <!-- Bottom Box -->
      {{-- <div class="bottom-box text-center">
        <div class="button-box">
          <a href="#" class="theme-btn btn-style-three"><span class="txt">Load More Test Planner</span></a>
        </div>
      </div> --}}
    </div>
  </section>
</body>
@endsection