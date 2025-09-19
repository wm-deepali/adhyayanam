@extends('front.partials.app')
@section('header')
	  <title>{{$seo->title ?? $privacy->heading1}}</title>
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
        <li><a href="{{url('/')}}">Home</a></li>
        <li>{{$privacy->heading1}}</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <!-- Contact Page Section -->
  <section class="content-pages">
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-12">
          <div class="contents">
            <h3>{{$privacy->heading1}}</h3>
            {!!$privacy->description1!!}
          </div>
        </div>
      </div>

    </div>
  </section>

</body>
@endsection