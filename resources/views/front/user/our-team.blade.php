@extends('front.partials.app')
@section('header')
  <title>Our Team</title>
@endsection
<style>
  .team-experience,
  .team-qualification {
    font-size: 14px;
    color: #555;
    margin-top: 4px;
  }

  .team-qualification {
    font-style: italic;
  }
</style>
@section('content')

  <body class="hidden-bar-wrapper">
    <!-- Page Title -->
    <section class="page-title">
      <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
          <li><a href="index.html">Home</a></li>
          <li>Our Team</li>
        </ul>
      </div>
    </section>
    <!-- End Page Title -->

    <!-- Team Page Section -->
    <section class="team-page-section">
      <div class="auto-container">
        <div class="row clearfix">

          <!-- Team Block -->
          @foreach($teams as $team)
            <div class="team-block col-lg-3 col-md-6 col-sm-12">
              <div class="inner-box">
                <div class="image">
                  <img src="{{ asset('storage/' . $team->profile_image) }}" alt="{{ $team->name }}" />
                </div>

                <div class="lower-content">
                  <div class="content">
                    <h5>{{ $team->name }}</h5>

                    {{-- Designation --}}
                    @if($team->designation)
                      <div class="designation">
                        {{ $team->designation }}
                      </div>
                    @endif

                    {{-- Experience --}}
                    @if($team->experience)
                      <div class="team-experience">
                        Experience: {{ $team->experience }}
                      </div>
                    @endif

                    {{-- Qualification / Education --}}
                    @if($team->education)
                      <div class="team-qualification">
                        Qualification: {{ $team->education }}
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <ul class="styled-pagination">
          <li><a href="#" class="active">1</a></li>
          <li class="next"><a href="#"><span class="flaticon-arrow-pointing-to-right"></span></a></li>
        </ul>
      </div>
    </section>
  </body>
@endsection