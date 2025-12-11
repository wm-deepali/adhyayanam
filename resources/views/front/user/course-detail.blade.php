@extends('front.partials.app')

@section('header')
  <title>{{$course->meta_title ?? 'Course Details'}}</title>
  <meta name="description" content="{{ $course->meta_description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $course->meta_keyword ?? 'default, keywords' }}">
  <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

  <body class="hidden-bar-wrapper">

    <!-- Page Title -->
    <section class="page-title">
      <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Course Detail</li>
        </ul>
        @include('front-users.layouts.includes.messages')
      </div>
    </section>
    <!-- End Page Title -->

    <!-- Course Page Title -->
    <section class="course-page-title" style="background-image: url(images/background/pattern-10.png)">
      <div class="auto-container">
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
                    <img src="{{ url('storage/' . $course->banner_image) }}" alt="{{$course->image_alt_tag}}" />
                  @endif
                @else
                  <img src="{{ url('storage/' . $course->banner_image) }}" alt="{{$course->image_alt_tag}}" />
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
                      <div class="content">
                        {!! $course->course_overview !!}
                      </div>
                    </div>

                    <!-- Course Detail -->
                    <div class="tab" id="course-curriculum">
                      <div class="content">
                        {!! $course->detail_content !!}
                      </div>
                    </div>

                    <!-- Instructor / Test Planner -->
                    <div class="tab" id="course-instructor">
                      <div class="content">
                        <h4>Instructor</h4>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a
                          page...</p>
                      </div>
                    </div>

                    <!-- Reviews -->
                    <div class="tab" id="course-reviews">
                      <div class="content">
                        <p>Reviews section here...</p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

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

      </div>
    </section>

  </body>
@endsection