@extends('front.partials.app')
@section('header')
	  <title>{{$current_affair->meta_title ?? "Current Affairs"}}</title>
    <meta name="description" content="{{$current_affair->meta_description}}">
    <meta name="keywords" content="{{$current_affair->meta_keyword}}">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Current Affairs Details</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->

  <!-- Sidebar Page Container -->
  <div class="sidebar-page-container">
    <div class="auto-container">
      <div class="row clearfix">

        <!-- Content Side -->
        <div class="content-side col-lg-8 col-md-12 col-sm-12">
          <!-- News Detail-->
          <div class="news-detail">
            <div class="inner-box">
              <div class="image">
                <img src="{{url('storage/'.$current_affair->thumbnail_image)}}" alt="{{$current_affair->image_alt_tag ?? $current_affair->title}}" />
              </div>
              <div class="lower-content">
                <div class="d-flex align-items-center">
                  <ul class="post-info osd">
                    <li><span class="osd flaticon-calendar"></span> <span class="osd tt">{{$current_affair->publishing_date}}</span></li>
                  </ul>
                </div>
                <h2>{{$current_affair->short_description}}</h2>
                {!!$current_affair->details!!}
                <div class="post-share-options">
                  <div class="post-share-inner d-flex justify-content-between align-items-center flex-wrap">
                    <div class="tags-box"><a href="#">Share</a></div>
                    <ul class="social-box">
                      <li><a class="fa fa-facebook" href="#"><span class=""></span></a></li>
                      <li><a class="fa fa-twitter" href="#"></a></li>
                      <li><a class="fa fa-linkedin" href="#"></a></li>
                      <li><a class="fa fa-pinterest-p" href="#"></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Side -->
        <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
          <aside class="sidebar sticky-top">

            <!-- Search Widget -->
            <div class="sidebar-widget-two search-box">
              <div class="widget-content">
                <form method="post" action="#">
                  <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search" required>
                    <button type="submit"><span class="icon flaticon-search-1"></span></button>
                  </div>
                </form>
              </div>
            </div>


            <!-- Post Widget -->
            <div class="sidebar-widget-two post-widget">
              <div class="widget-content">
                <!-- Sidebar Title Two -->
                <div class="sidebar-title-two">
                  <h5>Recent post</h5>
                </div>
                @foreach($relatedBlogs as $data)
                <div class="post">
                  <div class="thumb">
                    <a href="{{route('blog.details',$data->id)}}"><img src="{{url('storage/'.$data->image)}}" alt=""></a>
                  </div>
                  <div class="post-date">{{ Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</div>
                  <h6><a href="{{route('blog.details',$data->id)}}">{{ Illuminate\Support\Str::limit($data->heading, 12) }}</a></h6>
                </div>
                @endforeach
              </div>
            </div>

            <!-- Tags Widget -->
            <div class="sidebar-widget-two tags-widget">
              <div class="widget-content">
                <!-- Sidebar Title Two -->
                <div class="sidebar-title-two">
                  <h5>Tags</h5>
                </div>
                <ul class="tag-list">
                  <li><a href="#">Blog</a></li>
                  <li><a href="#">Education</a></li>
                  <li><a href="#">Teach</a></li>
                  <li><a href="#">Business</a></li>
                  <li><a href="#">Learning</a></li>
                  <li><a href="#">Science</a></li>
                  <li><a href="#">Design</a></li>
                  <li><a href="#">Marketing</a></li>
                  <li><a href="#">Book</a></li>
                </ul>
              </div>
            </div>

          </aside>
        </div>

      </div>

      <div class="row clearfix mt-40">
        <div class="col-12">
          <div class="sec-title">
            <h2>Related Post</h2>
          </div>
        </div>
        @foreach($relatedAffairs as $affair)
        <div class="news-block cf col-lg-6 col-md-6 col-sm-12">
          <div class="inner-box">
            <div class="image">
              <a href="{{route('current.details',$affair->id)}}"><img src="{{url('storage/'.$affair->thumbnail_image)}}" alt="{{$affair->image_alt_tag}}" /></a>
            </div>
            <div class="lower-content">
              <ul class="post-info">
                <li>{{$affair->publishing_date}}</li>
              </ul>
              <h5><a href="{{route('current.details',$affair->id)}}">{{$affair->title}}</a></h5>
              <div class="text">{{$affair->short_description}}</div>
              <a class="more-post" href="{{route('current.details',$affair->id)}}">Read more</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</body>
@endsection