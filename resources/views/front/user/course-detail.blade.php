@extends('front.partials.app')

@section('header')
  <title>{{$course->meta_title ?? 'Course Details'}}</title>
  <meta name="description" content="{{ $course->meta_description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $course->meta_keyword ?? 'default, keywords' }}">
  <link rel="canonical" href="{{ url()->current() }}">
  <style>
      /* breadcrumb */

.ts-breadcrumb{
display:flex;
align-items:center;
flex-wrap:wrap;
gap:6px;
margin:10px 0 20px 0;
font-size:14px;
}

.ts-breadcrumb a{
color:#045279;
text-decoration:none;
font-weight:500;
}

.ts-breadcrumb a:hover{
text-decoration:underline;
}

.arrow{
color:#888;
font-size:16px;
margin:0 3px;
}

.current{
color:#555;
font-weight:600;
}

.editor-content{
line-height:1.7;
font-size:16px;
color:#444;
}

.editor-content h1,
.editor-content h2,
.editor-content h3,
.editor-content h4,
.editor-content h5{
margin-top:20px;
margin-bottom:10px;
font-weight:600;
}

.editor-content p{
margin-bottom:12px;
}

.editor-content ul{
padding-left:20px;
margin-bottom:15px;
}

.editor-content ul li{
list-style:disc;
margin-bottom:6px;
}

.editor-content ol{
padding-left:20px;
margin-bottom:15px;
}

.editor-content img{
max-width:100%;
height:auto;
margin:10px 0;
border-radius:6px;
}

.editor-content table{
width:100%;
border-collapse:collapse;
margin:15px 0;
}

.editor-content table td,
.editor-content table th{
border:1px solid #ddd;
padding:8px;
}

  </style>
@endsection

@section('content')

  <body class="hidden-bar-wrapper">

    <!-- Page Title -->
    <!--<section class="page-title">-->
    <!--  <div class="auto-container">-->
    <!--    <h2>Adhyayanam</h2>-->
    <!--    <ul class="bread-crumb clearfix">-->
    <!--      <li><a href="{{ url('/') }}">Home</a></li>-->
    <!--      <li>Course Detail</li>-->
    <!--    </ul>-->
    <!--    @include('front-users.layouts.includes.messages')-->
    <!--  </div>-->
    <!--</section>-->
    <!-- End Page Title -->


    <!-- Course Page Title -->
    <section class="course-page-title" style="background-image: url(images/background/pattern-10.png)">
      <div class="auto-container">
          <div class="ts-breadcrumb">

<a href="#">Home</a>

<span class="arrow">›</span>

<a href="#">UPSC</a>

<span class="arrow">›</span>

<a href="#">Prelims</a>

<span class="arrow">›</span>

<span class="current">UPSC Prelims 2026 Test Series</span>

</div>

        <h2>{{$course->course_heading}}</h2>
        <div class="d-flex flex-wrap">
          <div class="rating">
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star-o"></span>
            <i>4.9 (34 reviews)</i>
          </div>
          <div class="courses">{{ number_format(8277) }} enrolled on this course</div>
        </div>
        <div class="text">{{$course->short_description}}</div>
        @if($course->feature == 'on')
          <span class="badge bg-success">Featured</span>
        @endif
      </div>
    </section>
    <!-- End Course Page Title -->

    <!-- Course Detail Section -->
    <section class="course-detail-section">
      <div class="auto-container">

        <!-- Upper Box -->
        <div class="upper-box">
          <div class="row clearfix">

            <!-- Course Info -->
            <div class="course-info col-lg-3 col-md-6 col-sm-12">
              <div class="inner-box">
                <span class="icon flaticon-hourglass"></span>
                Duration
                <strong>{{$course->duration}} Weeks</strong>
              </div>
            </div>

            <!-- Weekly Study -->
            <div class="course-info col-lg-3 col-md-6 col-sm-12">
              <div class="inner-box">
                <span class="icon flaticon-three-o-clock-clock"></span>
                Weekly study
                <strong>2 Hours</strong>
              </div>
            </div>

            <!-- Course Mode -->
            <div class="course-info col-lg-3 col-md-6 col-sm-12">
              <div class="inner-box">
                <span class="icon flaticon-internet"></span>
                Mode
                <strong>{{$course->course_mode}}</strong>
              </div>
            </div>

            <!-- Last Update -->
            <div class="course-info col-lg-3 col-md-6 col-sm-12">
              <div class="inner-box">
                <span class="icon flaticon-document"></span>
                Last Update:
                <strong>{{ \Carbon\Carbon::parse($course->created_at)->format('M d Y') }}</strong>
              </div>
            </div>

          </div>
        </div>
        <!-- End Upper Box -->

        <div class="row clearfix">

          <!-- Content Column -->
          <div class="content-column col-lg-8 col-md-12 col-sm-12">
            <div class="inner-column">
              <div class="image">
                @if($course->youtube_url)
                  @php
                    preg_match("/youtu\.be\/([^\?\/]+)/", $course->youtube_url, $matches);
                    $video_id = $matches[1] ?? null;
                    $embed_url = $video_id ? "https://www.youtube.com/embed/$video_id" : null;
                  @endphp
                  @if($embed_url)
                    <iframe width="100%" height="500" src="{{ $embed_url }}" title="YouTube video player" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen></iframe>
                  @else
                    <img src="{{ asset('storage/' . $course->banner_image) }}"
                      alt="{{ $course->image_alt_tag ?? $course->course_heading }}" loading="lazy" />

                  @endif
                @else
                   <img src="{{ asset('storage/' . $course->banner_image) }}"
                      alt="{{ $course->image_alt_tag ?? $course->course_heading }}" loading="lazy" />
                @endif
              </div>

              <div class="news-detail">
                <div class="post-share-options x">
                  <div class="post-share-inner d-flex justify-content-between align-items-center flex-wrap">
                    <div class="tags-box">Share This Course :</div>
                    <ul class="social-box">
                      <li>
                        <a class="fa fa-facebook" target="_blank"
                          href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}">
                        </a>
                      </li>
                      <li>
                        <a class="fa fa-twitter" target="_blank"
                          href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($course->course_heading) }}">
                        </a>
                      </li>
                      <li>
                        <a class="fa fa-linkedin" target="_blank"
                          href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}">
                        </a>
                      </li>
                      <li>
                        <a class="fa fa-pinterest-p" target="_blank"
                          href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ url('storage/' . $course->banner_image) }}&description={{ urlencode($course->course_heading) }}">
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>


              <!-- Course Info Tabs -->
             

            </div>
          </div>

          <!-- Sidebar Column -->
          <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
            <div class="inner-column">
              <div class="content">
                <ul class="list">
                  <li>
                    <span class="icon flaticon-price-tag"></span>
                    Course Fee
                    <strong>RS. {{$course->course_fee}}</strong>
                  </li>
                  <li>
                    <span class="icon flaticon-agenda"></span>
                    No. of Classes
                    <strong>{{$course->num_classes}}</strong>
                  </li>
                  <li>
                    <span class="icon flaticon-folder"></span>
                    Topics Covered
                    <strong>{{$course->num_topics}}</strong>
                  </li>
                  <li>
                    <span class="icon flaticon-translation"></span>
                    Language
                    <strong>
                      @if($course->language_of_teaching == 'E')
                        English
                      @elseif($course->language_of_teaching == 'H')
                        Hindi
                      @else
                        {{$course->language_of_teaching}}
                      @endif
                    </strong>
                  </li>
                </ul>

                @if(auth()->user() && auth()->user()->email != '' && auth()->user()->type == 'student')
                  @php
                    $user_id = auth()->user()->id;
                    $package_id = $course->id;
                    $type = 'Course';
                    $checkExist = Helper::GetStudentOrder($type, $package_id, $user_id)
                  @endphp
                  @if(!$checkExist)
                    <a class="enroll-now theme-btn"
                      href="{{route('user.process-order', ['type' => 'course', 'id' => $course->id])}}">Enroll Now !</a>
                  @else
                    <a class="enroll-now theme-btn" href="Javascript:void(0);">Already Enrolled!</a>
                  @endif
                @else
                  <a class="enroll-now theme-btn" data-bs-toggle="modal" data-bs-target="#lr">Enroll Now !</a>
                @endif

              </div>
            </div>
          </div>

        </div>
         <div class="course-info-tabs">
                <div class="course-tabs tabs-box">
                  <!-- Tab Btns -->
                  <ul class="tab-btns tab-buttons clearfix cvx">
                    <li data-tab="#course-overview" class="tab-btn active-btn">Overview</li>
                    <li data-tab="#course-curriculum" class="tab-btn">Course Detail</li>
                    <!-- <a href="#">
                          <li class="tab-btn">Study Material</li>
                        </a>
                        <a href="#">
                          <li class="tab-btn">Test Series</li>
                        </a>
                        <a href="#">
                          <li data-tab="#course-instructor" class="tab-btn">Test Planner</li>
                        </a> -->
                    <!-- <li data-tab="#course-reviews" class="tab-btn">Reviews</li> -->
                  </ul>

                  <!-- Tabs Container -->
<div class="tabs-content">

<!-- Overview -->
<div class="tab active-tab" id="course-overview">
<div class="content editor-content">
{!! $course->course_overview !!}
</div>
</div>

<!-- Course Detail -->
<div class="tab" id="course-curriculum">
<div class="content editor-content">
{!! $course->detail_content !!}
</div>
</div>

<!-- Instructor -->
<div class="tab" id="course-instructor">
<div class="content editor-content">
<h4>Instructor</h4>
<p>It is a long established fact that a reader will be distracted by the readable content of a page...</p>
</div>
</div>

<!-- Reviews -->
<div class="tab" id="course-reviews">
<div class="content editor-content">
<p>Reviews section here...</p>
</div>
</div>

</div>

                </div>
              </div>

      </div>
    </section>

  </body>
@endsection