@extends('front.partials.app')
@section('header')
  <title>Daily Booster</title>
@endsection
@section('content')

  <body class="hidden-bar-wrapper">
    <!-- Page Title -->
    <section class="page-title">
      <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
          <li><a href="{{url('/')}}">Home</a></li>
          <li>Daily Booster</li>
        </ul>
      </div>
    </section>
    <!-- End Page Title -->

    <section class="courses-section">
      <div class="auto-container">
        <!-- Sec Title -->
        <div class="sec-title">
          <h2 class="osd smx">Daily Booster Videos</h2>
        </div>
        <div class="row clearfix">
          @foreach($dailyBoosts as $data)
            <div class="course-block-two col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="video-inner-box x">
                <a href="{{ $data->youtube_url }}" target="_blank">
                  <img src="{{ url('storage/' . $data->thumbnail) }}" alt="{{ $data->title }}" />
                  <!-- your svg play button -->
                </a>

                <!-- Title -->
                <h5 class="mt-2">{{ $data->title }}</h5>

                <!-- Short description (strip html and limit length) -->
                <p style="font-size:14px; color:#555;">
                  {{ \Illuminate\Support\Str::limit(strip_tags($data->short_description), 120) }}
                </p>

                <!-- View Details (internal page) -->
                <a href="{{ route('daily.booster.detail', $data->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                  View Details
                </a>
              </div>
            </div>
          @endforeach

        </div>

        <!-- Bottom Box -->
        {{-- <div class="bottom-box text-center">
          <div class="button-box">
            <a href="#" class="theme-btn btn-style-three"><span class="txt">Load More Videos</span></a>
          </div>
        </div> --}}

      </div>
    </section>
  </body>
@endsection