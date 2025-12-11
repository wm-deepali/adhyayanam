@extends('front.partials.app')

@section('header')
    <title>{{ $dailyBoost->title }}</title>
@endsection

@section('content')
<section class="page-title">
  <div class="auto-container">
    <h2>{{ $dailyBoost->title }}</h2>
    <ul class="bread-crumb clearfix">
      <li><a href="{{ url('/') }}">Home</a></li>
      <li><a href="{{ route('daily.boost.front') }}">Daily Booster</a></li>
      <li>Details</li>
    </ul>
  </div>
</section>

<section class="content-section py-4">
  <div class="auto-container">
    <div class="row">
      <div class="col-md-5">
        <img src="{{ url('storage/' . $dailyBoost->thumbnail) }}" class="img-fluid rounded" alt="{{ $dailyBoost->title }}">
        <p class="mt-2"><strong>Start Date:</strong> {{ $dailyBoost->start_date }}</p>
        <a href="{{ $dailyBoost->youtube_url }}" target="_blank" class="btn btn-danger">Watch on YouTube</a>
      </div>

      <div class="col-md-7">
        <div class="detail-content mt-0">
          {!! $dailyBoost->detail_content !!}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
