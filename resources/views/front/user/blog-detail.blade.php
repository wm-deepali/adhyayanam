@extends('front.partials.app')
@section('header')
	  <title>Blog and Articles|{{$blog->heading}}</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Blog Details</li>
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
                <img src="{{url('storage/'.$blog->image)}}" alt="" />
              </div>
              <div class="lower-content">
                <div class="d-flex align-items-center">
                  <div class="tag">{{$blog->type}}</div>
                  <ul class="post-info">
                    <li>By {{$blog->user->name}}</li>
                    <li>{{ Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</li>
                  </ul>
                </div>
                <h2>{{$blog->heading}}</h2>
                {!!$blog->description!!}
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
                <!-- End Post Share Options -->

                <!-- More Posts -->
                <div class="more-posts">
                  <div class="more-posts-inner d-flex justify-content-between flex-wrap">
                    @if($prevBlog)
                        <div class="new-post">
                            <div class="prev-arrow flaticon-left-arrow-2"><a href="{{ route('blog.details', $prevBlog->id) }}"></a></div>
                            <div class="post-inner">
                                <a href="{{ route('blog.details', $prevBlog->id) }}">
                                    {!! nl2br(e(Illuminate\Support\Str::limit(wordwrap($prevBlog->heading, 25, "\n", true), 50))) !!}
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="new-post">
                            <div class="prev-arrow flaticon-left-arrow-2"></div>
                            <div class="post-inner">
                                <span><h6>No previous blog</h6></span>
                            </div>
                        </div>
                    @endif

                    @if($nextBlog)
                        <div class="new-post">
                            <div class="next-arrow flaticon-right-arrow"><a href="{{ route('blog.details', $nextBlog->id) }}"></a></div>
                            <div class="post-inner">
                                <a href="{{ route('blog.details', $nextBlog->id) }}">
                                    {!! nl2br(e(Illuminate\Support\Str::limit(wordwrap($nextBlog->heading, 20, "\n", true), 45))) !!}
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="new-post">
                            <div class="next-arrow flaticon-right-arrow"></div>
                            <div class="post-inner">
                                <span><h6>No next blog</h6></span>
                            </div>
                        </div>
                    @endif
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
    </div>
  </div>
</body>
@endsection