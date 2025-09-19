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
        <h2>{{$data->title}}</h2>
      </div>
      <div class="smaterial-boxs">
        <div class="content">
          <h3 class="osd sm">{{$data->short_description}}</h3>
          {!!$data->detail_content!!}
        </div>
        <div class="pdf-tp">
          <a class="tp-btn" href="{{url('storage/'.$data->pdf)}}" download="{{$data->title}}">Download pdf<div></div></a>
        </div>

      </div>
    </div>
  </section>
</body>
@endsection