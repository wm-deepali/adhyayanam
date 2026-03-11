@extends('front.partials.app')

@section('header')
  <title>{{$course->meta_title ?? 'Course Details'}}</title>
  <meta name="description" content="{{ $course->meta_description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $course->meta_keyword ?? 'default, keywords' }}">
  <link rel="canonical" href="{{ url()->current() }}">

  <style>
    /* breadcrumb */

    .ts-breadcrumb {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 6px;
      margin: 10px 0 20px 0;
      font-size: 14px;
    }

    .ts-breadcrumb a {
      color: #045279;
      text-decoration: none;
      font-weight: 500;
    }

    .ts-breadcrumb a:hover {
      text-decoration: underline;
    }

    .arrow {
      color: #888;
      font-size: 16px;
      margin: 0 3px;
    }

    .current {
      color: #555;
      font-weight: 600;
    }

    .editor-content {
      line-height: 1.7;
      font-size: 16px;
      color: #444;
    }

    .editor-content h1,
    .editor-content h2,
    .editor-content h3,
    .editor-content h4,
    .editor-content h5 {
      margin-top: 20px;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .editor-content p {
      margin-bottom: 12px;
    }

    .editor-content ul {
      padding-left: 20px;
      margin-bottom: 15px;
    }

    .editor-content ul li {
      list-style: disc;
      margin-bottom: 6px;
    }

    .editor-content ol {
      padding-left: 20px;
      margin-bottom: 15px;
    }

    .editor-content img {
      max-width: 100%;
      height: auto;
      margin: 10px 0;
      border-radius: 6px;
    }

    .editor-content table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
    }

    .editor-content table td,
    .editor-content table th {
      border: 1px solid #ddd;
      padding: 8px;
    }
  </style>

@endsection

@section('content')

  <body class="hidden-bar-wrapper">


    <!-- Course Page Title -->
    <section class="course-page-title" style="background-image: url(images/background/pattern-10.png)">
      <div class="auto-container">

        <div class="ts-breadcrumb">

          <a href="{{ url('/') }}">Home</a>

          @if($course->examinationCommission)
                  <span class="arrow">›</span>

                  <a href="{{ route('courses', [
              'exam_id' => $course->examinationCommission->id
            ]) }}">
                    {{ $course->examinationCommission->name }}
                  </a>
          @endif


          @if($course->category)
                  <span class="arrow">›</span>

                  <a href="{{ route('courses', [
              'exam_id' => $course->examinationCommission->id,
              'category_id' => $course->category->id
            ]) }}">
                    {{ $course->category->name }}
                  </a>
          @endif


          @if($course->subCategory)
                  <span class="arrow">›</span>

                  <a href="{{ route('courses', [
              'exam_id' => $course->examinationCommission->id,
              'category_id' => $course->category->id,
              'sub_category_id' => $course->subCategory->id
            ]) }}">
                    {{ $course->subCategory->name }}
                  </a>
          @endif


          <span class="arrow">›</span>

          <span class="current">
            {{ $course->course_heading }}
          </span>

        </div>

        <h2>{{$course->course_heading}}</h2>
        <div class="d-flex flex-wrap">

          <div class="rating">

            @if(($totalReviews ?? 0) > 0)

              @php
                $rating = $avgRating ?? 0;
              @endphp

              @for ($i = 1; $i <= 5; $i++)
                @if($rating >= $i)
                  <span class="fa fa-star"></span>
                @elseif($rating >= $i - 0.5)
                  <span class="fa fa-star-half-o"></span>
                @else
                  <span class="fa fa-star-o"></span>
                @endif
              @endfor

              <i>{{ $avgRating }} ({{ $totalReviews }} reviews)</i>

            @else

              <span class="fa fa-star-o"></span>
              <span class="fa fa-star-o"></span>
              <span class="fa fa-star-o"></span>
              <span class="fa fa-star-o"></span>
              <span class="fa fa-star-o"></span>
              <span class="text-muted">No reviews yet</span>

            @endif

          </div>

          <div class="courses">
            <strong>{{ number_format($course->orders_count ?? 0) }}</strong> students enrolled
          </div>

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
                <strong>{{$course->weekly_study ?? 0}} Hours / Week</strong>
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
                    <strong>
                      ₹{{$course->offered_price}}
                      <del style="color:#999; font-size:14px; margin-left:6px;">
                        ₹{{$course->course_fee}}
                      </del>
                    </strong>
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
                  <a class="enroll-now theme-btn" href="{{route('student.login')}}">Enroll Now !</a>
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

              <li data-tab="#course-reviews" class="tab-btn">Reviews</li>
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

              <!-- Reviews -->
              <div class="tab" id="course-reviews">

                <div class="content editor-content">

                  <h4 class="mb-3">⭐ Student Reviews</h4>

                  {{-- Reviews List --}}
                  @if($course->reviews->count())

                    @foreach($course->reviews as $review)

                      <div class="border-bottom mb-3 pb-3">

                        <div class="d-flex justify-content-between">

                          <strong>{{ $review->student->name ?? 'Student' }}</strong>

                          <div>
                            {{ str_repeat('⭐', $review->rating) }}
                          </div>

                        </div>

                        <small class="text-muted">
                          {{ $review->created_at->format('d M Y') }}
                        </small>

                        <p class="mt-1 mb-0">
                          {{ $review->review }}
                        </p>

                      </div>

                    @endforeach

                  @else

                    <p class="text-muted">No reviews yet.</p>

                  @endif

                </div>

              </div>

            </div>

          </div>
        </div>

      </div>
    </section>

  </body>
@endsection