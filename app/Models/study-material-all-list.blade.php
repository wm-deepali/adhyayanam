@extends('front.partials.app')
@section('header')
<title>{{$topic->meta_title}}</title>
  <meta name="description" content="{{ $topic->meta_description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $topic->meta_keywords ?? 'default, keywords' }}">   
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Neti IAS</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>Study Materials View All</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="course-page-section-two">
    <div class="auto-container">

      <div class="top-banner-sm">
        <div class="image">
          <img src="{{url('storage/'.$topic->image)}}" alt="{{$topic->alt_tag}}">
        </div>
      </div>

      <div class="smaterial-box">
        <div class="content">
          <h4 class="osd sm">{{$topic->name}}</h4>
          <div class="row">
            @foreach($topic->studyMaterials as $data)
            <div class="col-sm-12 col-md-4">
              <div class="cm-all"><a href="{{route('study.material.details',$data->id)}}">{{$data->title}}</a></div>
            </div>
            @endforeach
          </div>
        </div>

      </div>
  </section>
</body>
@endsection