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
        <li><a href="index.html">Home</a></li>
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
        <div class="courses">8,277 enrolled on this course</div>
      </div>
      <div class="text">{{$course->short_description}}</div>
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

          <!-- Course Info -->
          <div class="course-info col-lg-3 col-md-6 col-sm-12">
            <div class="inner-box">
              <span class="icon flaticon-three-o-clock-clock"></span>
              Weekly study
              <strong>2 Hours</strong>
            </div>
          </div>

          <!-- Course Info -->
          <div class="course-info col-lg-3 col-md-6 col-sm-12">
            <div class="inner-box">
              <span class="icon flaticon-internet"></span>
              100% online
              <strong><a href="#">Online Class</a></strong>
            </div>
          </div>

          <!-- Course Info -->
          <div class="course-info col-lg-3 col-md-6 col-sm-12">
            <div class="inner-box">
              <span class="icon flaticon-document"></span>
              Last Update:
              <strong>{{Carbon\Carbon::parse($course->created_at)->format('M d Y')}}</strong>
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
              <iframe width="100%" height="500" src="{{$course->youtube_url}}"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              @else
                <img src="{{url('storage/'.$course->banner_image)}}" alt="{{$course->image_alt_tag}}" />
              @endif
            </div>
            <div class="news-detail">
              <div class="post-share-options x">
                <div class="post-share-inner d-flex justify-content-between align-items-center flex-wrap">
                  <div class="tags-box">Share This Course :</div>
                  <ul class="social-box">
                    <li><a class="fa fa-facebook" href="#"><span class=""></span></a></li>
                    <li><a class="fa fa-twitter" href="#"></a></li>
                    <li><a class="fa fa-linkedin" href="#"></a></li>
                    <li><a class="fa fa-pinterest-p" href="#"></a></li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Course Info Tabs -->
            <div class="course-info-tabs">
              <!-- Course Tabs -->
              <div class="course-tabs tabs-box">
                <!-- Tab Btns -->
                <ul class="tab-btns tab-buttons clearfix cvx">
                  <li data-tab="#course-overview" class="tab-btn active-btn">Overview</li>
                  <li data-tab="#course-curriculum" class="tab-btn">Course Detail</li></a>
                  <a href="#">
                    <li class="tab-btn">Study Material</li>
                  </a>
                  <a href="#">
                    <li class="tab-btn">Test Series</li>
                  </a>
                  <a href="#">
                    <li data-tab="#course-instructor" class="tab-btn">Test Planner</li>
                  </a>
                  <li data-tab="#course-reviews" class="tab-btn">Reviews</li>
                </ul>

                <!-- Tabs Container -->
                <div class="tabs-content">

                  <!-- Tab / Active Tab -->
                  <div class="tab active-tab" id="course-overview">
                    <div class="content">
                        {!!$course->course_overview!!}
                    </div>
                  </div>

                  <!-- Tab -->
                  <div class="tab" id="course-curriculum">
                    <div class="content">
                      {!!$course->detail_content!!}
                    </div>
                  </div>

                  <!-- Tab -->
                  <div class="tab" id="course-instructor">
                    <div class="content">
                      <h4>Instructor</h4>
                      <p>It is a long established fact that a reader will be distracted by the readable content of a
                        page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                        normal distribution of letters, as opposed to using 'Content here, content here', making it look
                        like readable English. Many desktop publishing packages and web page</p>
                      <p>On the course you will get an introduction to the chemistry and biology of forensic science.
                        You will examine the methods used in forensic science and learn about how these technique are
                        used in crime scenes and explained in the court room.</p>
                      <div class="row clearfix">
                        <div class="learn-box col-lg-5 col-md-5 col-sm-12">
                          <div class="box-inner">
                            <div class="icon flaticon-degree"></div>
                            <h5>Your learning, <br> your rules</h5>
                            <div class="learn-text">Courses are split into weeks, activities, and steps to help you keep
                              track of your learning</div>
                          </div>
                        </div>
                        <div class="learn-box style-two col-lg-7 col-md-7 col-sm-12">
                          <div class="box-inner">
                            <div class="icon flaticon-book-2"></div>
                            <h5>Join a global classroom</h5>
                            <ul class="check-list">
                              <li>Share ideas with your peers and course educators on every step of the course</li>
                              <li>Apply the chemistry knowledge acquired to approach the learning and understanding of
                                more </li>
                            </ul>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- Tab -->
                  <div class="tab" id="course-reviews">
                    <div class="content">

                      <!--Reviews Container-->
                      <div class="comments-area">
                        <!--Comment Box-->
                        <div class="comment-box">
                          <div class="comment">
                            <div class="author-thumb"><img src="images/resource/author-1.jpg" alt=""></div>
                            <div class="comment-inner">
                              <div class="comment-info clearfix">Steven Rich – March 17, 2022:</div>
                              <div class="rating">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star light"></span>
                              </div>
                              <div class="text">How all this mistaken idea of denouncing pleasure and praising pain was
                                born and I will give you a complete account of the system, and expound the actual
                                teachings.</div>
                            </div>
                          </div>
                        </div>
                        <!--Comment Box-->
                        <div class="comment-box reply-comment">
                          <div class="comment">
                            <div class="author-thumb"><img src="images/resource/author-2.jpg" alt=""></div>
                            <div class="comment-inner">
                              <div class="comment-info clearfix">William Cobus – April 21, 2022:</div>
                              <div class="rating">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star-half-empty"></span>
                              </div>
                              <div class="text">There anyone who loves or pursues or desires to obtain pain itself,
                                because it is pain sed, because occasionally circumstances occur some great pleasure.
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                      <!-- Comment Form -->
                      <div class="course-comment-form">
                        <h4>Add Your Comments</h4>
                        <div class="rating-box">
                          <div class="text"> Your Rating:</div>
                          <div class="rating">
                            <a href="#"><span class="fa fa-star"></span></a>
                          </div>
                          <div class="rating">
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                          </div>
                          <div class="rating">
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                          </div>
                          <div class="rating">
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                          </div>
                          <div class="rating">
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                          </div>
                        </div>
                        <form method="post" action="https://jufailitech.com/envatoitems/LMSOne/html/contact.html">
                          <div class="row clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label>First Name *</label>
                              <input type="text" name="username" placeholder="" required>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label>Last Name*</label>
                              <input type="email" name="email" placeholder="" required>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                              <label>Email*</label>
                              <input type="text" name="number" placeholder="" required>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                              <label>Your Comments*</label>
                              <textarea name="message" placeholder=""></textarea>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                              <button class="theme-btn btn-style-one">
                                <span class="txt">Submit now</span>
                              </button>

                            </div>

                          </div>
                        </form>

                      </div>

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
              <!-- <div class="price">RS. 199.00</div> -->
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
                  <strong>{{$course->language_of_teaching}}</strong>
                </li>
              </ul>
              @if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
                @php
                  $user_id = auth()->user()->id;
                  $package_id = $course->id;
                  $type ='Course';
                  $checkExist = Helper::GetStudentOrder($type,$package_id,$user_id)
                @endphp
                @if(!$checkExist)
                  <a class="enroll-now theme-btn" href="{{route('user.process-order',['type' => 'course', 'id' => $course->id])}}">Enroll Now !</a>
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