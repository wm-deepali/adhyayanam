@extends('front.partials.app')
@section('header')
	  <title>Blog and Articles</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Blogs & Articles</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->

  <!-- Blog Page Section -->
  <section class="blog-page-section">
    <div class="auto-container">
      <div class="row clearfix">

        <!-- News Block -->
        @foreach($blogs as $blog)
        <div class="news-block col-lg-4 col-md-6 col-sm-12">
          <div class="inner-box">
            <div class="image">
              @if($blog->thumbnail)
              <a href="{{route('blog.details',$blog->id)}}"><img src="{{url('storage/'.$blog->thumbnail)}}" alt="{{$blog->heading}}" /></a>
              @else
              <a href="{{route('blog.details',$blog->id)}}"><img src="{{url('storage/'.$blog->image)}}" alt="{{$blog->heading}}" /></a>
              @endif
            </div>
            <div class="lower-content">
              <div class="tag">{{$blog->type}}</div>
              <ul class="post-info">
                <li>By {{$blog->user->name}}</li>
                <li>{{ Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</li>
              </ul>
              <h5><a href="{{route('blog.details',$blog->id)}}">{{$blog->heading}}</a></h5>
              <div class="text">{{ Illuminate\Support\Str::limit($blog->short_description, 100) }}...</div>
              <a class="more-post" href="{{route('blog.details',$blog->id)}}">Read more</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
</body>
@endsection
