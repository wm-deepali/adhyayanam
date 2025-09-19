@extends('front.partials.app')
@section('header')
	  <title>Current Affairs</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Current Affairs</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->

  <!-- Blog Page Section -->
  <section class="blog-page-section">
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-12 col-sm-6">
          <div class="sec-title">
            <h2>Monthly Trending Current Affairs</h2>
          </div>
        </div>
        <div class="col-12 col-sm-12">
          <div class="filter-box">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <!-- Left Box -->
              <div class="left-box d-flex align-items-center">
                <div class="results date-filter"><input type="date" name="search" placeholder="Filter Date" required="">
                </div>
              </div>
              <!-- Right Box -->
              <div class="right-box d-flex align-items-center">
                <div class="form-group">
                  <select name="currency" class="">
                    <option>Recently Added</option>
                    <option>Added 01</option>
                    <option>Added 02</option>
                    <option>Added 03</option>
                    <option>Added 04</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Current Affairs Block -->
        <div class="row">
          @foreach($topics as $topic)
          <div class="col-sm-12 col-md-6">
            <div class="smaterial-box scrl">
              <div class="content">
                <h4 class="osd sm">{{$topic->name}}</h4>
                <div class="caf-n l">
                  <ul>
                    @if($topic->currentAffair)
                    @foreach($topic->currentAffair as $affair)
                    <li>
                      <a href="{{route('current.details',$affair->id)}}">{{$affair->title.': '.$affair->short_description}}</a>
                    </li>
                    @endforeach
                    @endif
                  </ul>
                </div>
              </div>
					  </div>
          </div>
          @endforeach
        </div>
        <!-- <div class="news-block cf col-lg-6 col-md-6 col-sm-12">
          <div class="inner-box">
            <div class="image">
              <a href="current-affair-detail.html"><img src="images/resource/news-1.jpg" alt="" /></a>
            </div>
            <div class="lower-content">
              <ul class="post-info">
                <li>02 Feb 2024</li>
              </ul>
              <h5><a href="current-affair-detail.html">The Monetary Policy Committee (MPC) of the Reserve Bank of India
                  (RBI)</a></h5>
              <div class="text">The Monetary Policy Committee (MPC) of the Reserve Bank of India (RBI)...</div>
              <a class="more-post" href="current-affair-detail.html">Read more</a>
            </div>
          </div>
        </div> -->
        <!-- Current Affairs Block -->
        <!-- <div class="news-block cf col-lg-6 col-md-6 col-sm-12">
          <div class="inner-box">
            <div class="image">
              <a href="current-affair-detail.html"><img src="images/resource/news-1.jpg" alt="" /></a>
            </div>
            <div class="lower-content">
              <ul class="post-info">
                <li>02 Feb 2024</li>
              </ul>
              <h5><a href="current-affair-detail.html">The Monetary Policy Committee (MPC) of the Reserve Bank of India
                  (RBI)</a></h5>
              <div class="text">The Monetary Policy Committee (MPC) of the Reserve Bank of India (RBI)...</div>
              <a class="more-post" href="current-affair-detail.html">Read more</a>
            </div>
          </div>
        </div> -->
        <!-- Current Affairs Block -->
        <!-- <div class="news-block cf col-lg-6 col-md-6 col-sm-12">
          <div class="inner-box">
            <div class="image">
              <a href="current-affair-detail.html"><img src="images/resource/news-1.jpg" alt="" /></a>
            </div>
            <div class="lower-content">
              <ul class="post-info">
                <li>02 Feb 2024</li>
              </ul>
              <h5><a href="current-affair-detail.html">The Monetary Policy Committee (MPC) of the Reserve Bank of India
                  (RBI)</a></h5>
              <div class="text">The Monetary Policy Committee (MPC) of the Reserve Bank of India (RBI)...</div>
              <a class="more-post" href="current-affair-detail.html">Read more</a>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-12">
          <ul class="styled-pagination">
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li class="next"><a href="#"><span class="flaticon-arrow-pointing-to-right"></span></a></li>
          </ul>
        </div> -->



      </div>
      <!-- Bottom Box -->
      <div class="bottom-box text-center">
        <div class="button-box">
          <a href="#" class="theme-btn btn-style-three"><span class="txt">Load More </span></a>
        </div>
      </div>
    </div>
  </section>
</body>
@endsection