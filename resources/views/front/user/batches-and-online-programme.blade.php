@extends('front.partials.app')
@section('header')
	<title>{{$seo->title?? 'Batches & Online Programme'}}</title>
	<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
    <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Batches & Online Programme</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->

  <!-- Course Section -->
  <section class="course-page-section osd">
    <div class="auto-container">
      <div class="bottom-header">
        <div class="containerss">
          <div class="maq-container">
            <div class="latest-head s">
              <span>New Lauch Courses :</span>
            </div>
            <div class="marq-info">
              <marquee class="mar" width="90%" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                Lorem ipsum dolor sit amet sunt in culpa qui officia deserunt mollit anim id est laborum duis aute irure
                dolor
              </marquee>
            </div>
          </div>
        </div>
      </div>
      <div class="row clearfix">
          @foreach($batches as $data)
        <div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
          <div class="inner-box">
            <div class="image">
              <a href="course-detail.html"><img src="{{url('storage/'.$data->thumbnail_image)}}" alt="{{$data->image_alt_tag}}"></a>
            </div>
            <div class="lower-content">
              <div class="content">
                <div class="d-flex justify-content-between align-items-center">
                  <ul class="feature-list osd">
                    <li><span class="osd flaticon-calendar"></span> <span class="osd tt"><b>Start From:</b> {{ Carbon\Carbon::parse($data->start_date)->format('d M Y') }}</span></li>
                  </ul>
                  <div class="price fee">₹{{$data->offered_price}}</div>
                </div>
                <h4><a href="service-detail.html">{{$data->name}}</a></h4>
                <div class="contents">
                  <p>{{ Illuminate\Support\Str::limit($data->batch_heading, 50) }}</p>
                </div>
                <div class="news-block osdn">
                  <a class="more-post" href="#">Read more</a>
                </div>
              </div>

            </div>
          </div>
        </div>
        @endforeach
        
        <div class="col-12">
          <ul class="styled-pagination">
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li class="next"><a href="#"><span class="flaticon-arrow-pointing-to-right"></span></a></li>
          </ul>
        </div>


      </div>
    </div>
  </section>
</body>
@endsection