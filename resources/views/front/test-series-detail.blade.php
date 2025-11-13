@extends('front.partials.app')
@section('header')
	<title>{{ 'Test Series Detail' }}</title>
	<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
  <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection
@section('content')
@if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
@php
  $user_id = auth()->user()->id;
  $package_id = $testseries->id;
  $type ='Test Series';
  $checkExist = Helper::GetStudentOrder($type,$package_id,$user_id)
@endphp
@endif
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Test Series Detail</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="course-page-section-two bgx">
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-12 col-sm-12 col-md-8">
          <div class="test-s-l">
            <div class="image osd-f x"> 
              <div class="a-osds"><img src="{{asset('storage/'.$testseries->logo)}}" alt=""></div>
              <div class="user-rs"><span>{{$testseries->title}}</span></div>
            </div>
            <div class="last-update"><span class="icon flaticon-time osds"></span> <span class="lp-t">Last updated on
                {{$testseries->updated_at->format('M d,Y')}} </span></div>
            <div class="test-fst">
              <div class="fe-a"><b>{{count($testseries->testseries)}} Total Tests </b></div>
              <div class="fe-b"><span class="bg-g">@if($testseries->fee_type == 'Paid') Premium @else Free @endif Tests</span></div>
              <div class="fe-c"><span class="user"><span class="icon flaticon-user osdc"></span><span
                    class="usr-t">286.4k Users</span> </span>
              </div>
            </div>
            <div class="test-series-listings">
              <ul class="lstyle s">
                <li>{{$testseries->testseries->where('type_name','Chapter Test')->count()}} Chapter Test</li>
                  <li>{{$testseries->testseries->where('type_name','Current Affairs')->count()}} Current Affairs</li>
                  <li>{{$testseries->testseries->where('type_name','Subject Wise')->count()}} Subject Test</li>
                  <li>{{$testseries->testseries->where('type_name','Topic Wise')->count()}} Topic Test</li>
                  <li>+{{$testseries->testseries->where('type_name','Full Test')->count()}} more tests</li>
              </ul>
            </div>
            @if($testseries->fee_type == 'Paid')
            @if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
            
              @if(!$checkExist)
              <div class="add-this">
              <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="theme-btn btn-style-four osd"><span
                  class="txt">Add this test</span></a>

              </div>
              
               
              @endif
              @else
              <div class="add-this">
              <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="theme-btn btn-style-four osd"><span
                  class="txt">Add this test</span></a>

              </div>
            @endif
            @endif
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="progress-indicator">

                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mbdy">
                      <div class="dfx">
                        <div class="left-login">
                          <img src="{{url('images/online-test.png')}}">
                        </div>
                      </div>
                      <div class="dfxb"></div>
                      <div class="dfxc">
                        <!--div class="cplan">
                          <span class="your-plan">{{$testseries->title}}</span><span class="float-right-s"></span>
                        </div-->
                        <div class="plan-boxs">
                          <div class="plan-content">
                            <div class="plan-content-left">
                              <div class="yp">{{$testseries->title}} </div>
                              <!--div class="validity">Validity for 365 days</div-->
                            </div>
                            <div class="cart-price">
                              <div class="reg-p">{{$testseries->mrp}}</div>
                              <div class="off-price">RS. {{$testseries->price}}</div>
                            </div>
                          </div>
                        </div>
                        <div class="cplan brd">
                          <span class="your-plan saving">Your Total Savings </span><span
                            class="float-right-s">₹{{$testseries->mrp - $testseries->price }}</span>
                        </div>
                        <div class="cplan amount-p">
                          <span class="your-plan saving">Amount to be paid</span><span
                            class="float-right-s">₹{{$testseries->price}}</span>
                        </div>
                        @if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
                          
                          @if(!$checkExist)
                            <a href="{{route('user.process-order',['type' => 'test-series', 'id' => $testseries->id])}}" class="osd-cus">
                              <div class="cus-btn-osd">Proceed to Payment</div>
                            </a>
                            <div class="secure-p">
                              <i class="fa fa-lock"></i> Secure Payment
                            </div>
                          @else
                            <a href="Javascript:void(0);" class="osd-cus">
                              <div class="cus-btn-osd">Already Piad!</div>
                            </a>
                          @endif
                        @else
                        <a data-bs-toggle="modal" data-bs-target="#lr" class="osd-cus">
                          <div class="cus-btn-osd">Proceed to Payment</div>
                        </a>
                        @endif
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @if(auth()->user() == '' && isset(auth()->user()->type) && auth()->user()->type !='student')
        <div class="col-12 col-sm-12 col-md-4">
          <div class="r-form-ts comment-form">
            <div class="inner-form">
              <div class="f-h">Sign up To Adhyayanam Education and Test Your Exam Knowledge Now!</div>
            </div>
            <div class="form-test-l contact-form">
              
              <div class="btn-osd">
                <a data-bs-toggle="modal" data-bs-target="#lr" class="osd-cus">
                  <div class="cus-btn-osd">Start test</div>
                </a>
              </div>
            </div>
            <div class="bottom-number-iinroll">205.1k+ Enrolled this test series</div>
          </div>
        </div>
      </div>
      @endif

    </div>
  </section>
  <section class="course-page-section-two">
    <div class="auto-container">
      <div class="test-details-cont">

        <div class="row clearfix">
          <div class="col-sm-12 col-md-9">
            <h4> {{$testseries->title}} (New) All Tests ({{count($testseries->testseries)}})</h4>
            <!-- Course Info Tabs -->
            <div class="course-info-tabs osd">
              <!-- Course Tabs -->
              <div class="course-tabs tabs-box">
                <!-- Tab Btns -->
                <ul class="tab-btns tab-buttons clearfix osds">
                  <li data-tab="#mockup-test" class="tab-btn active-btn">Mockup Test</li>
                  <li data-tab="#course-curriculum" class="tab-btn">Previour Year Question Paper</li></a>
                </ul>

                <!-- Tabs Container -->
                <div class="tabs-content osd">

                  <!-- Tab / Active Tab -->
                  <div class="tab active-tab" id="mockup-test">
                    <div class="content">
                        @foreach($testseries->tests->where('paper_type','!=',1) as $testpaper)
                     
                      <div class="m-up-cont">
                        <div class="f-lex-grid">
                          <div class="t-name-mockup">
                              @if($testpaper->test_type == "free")
                              <div class="top-label"><span>FREE</span></div>
                              @endif
                            <div class="n-mcname"> {{$testpaper->name}} <span class="no-of-user-mt">39.3k
                                Users</span>
                            </div>
                          </div>
                          @if($testseries->fee_type == 'Paid')
                            @if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
                              @if(!$checkExist)
                                <div class="mockup-start-btn">
                                  <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="osd-cus s un"><span class="fa fa-lock osds" aria-hidden="true"></span>
                                    Unlcok
                                    test
                                  </a>
                                </div>
                              @else
                                <div class="mockup-start-btn">
                                  <a href="{{route('live-test', base64_encode($testpaper->id))}}" class="osd-cus s">Start test
                                    </a>
                                  </div>
                              @endif
                            @else
                                <div class="mockup-start-btn">
                                    <a data-bs-toggle="modal" data-bs-target="#lr"  class="osd-cus s un"><span class="fa fa-lock osds" aria-hidden="true"></span>
                                      Unlcok
                                      test
                                    </a>
                                  </div>
                            @endif
                          @else
                          @if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
                              <div class="mockup-start-btn">
                                  <a href="{{route('live-test', base64_encode($testpaper->id))}}" class="osd-cus s">Start test
                                    </a>
                                  </div>
                             
                            @else
                                <div class="mockup-start-btn">
                                <a data-bs-toggle="modal" data-bs-target="#lr"  class="osd-cus s">Start test
                                  </a>
                                </div>
                            @endif
                          @endif
                          
                         
                        </div>
                        <div class="bottom-section-mcts">
                          <div class="tq">
                            <i class="fa fa-question-circle" aria-hidden="true"></i> {{$testpaper->total_questions}} Questions
                          </div>
                          <div class="tq">
                            <span class="icon flaticon-file osds" aria-hidden="true"></span> <span class="pl-2">{{$testpaper->total_marks}}
                              Marks</span>
                          </div>
                          <div class="tq">
                            <span class="icon flaticon-time osds" aria-hidden="true"></span> <span class="pl-2">{{$testpaper->duration}}
                              Minute</span>
                          </div>
                        </div>
                      </div>
                     @endforeach
                    </div>
                  </div>

                  <!-- Tab -->
                  <div class="tab" id="course-curriculum">
                    <div class="content">
                       @foreach($testseries->tests->where('paper_type','=',1) as $testpaper)
                     
                      <div class="m-up-cont">
                        <div class="f-lex-grid">
                          <div class="t-name-mockup">
                              @if($testpaper->test_type == "free")
                              <div class="top-label"><span>FREE</span></div>
                              @endif
                            <div class="n-mcname"> {{$testpaper->name}} <span class="no-of-user-mt">39.3k
                                Users</span>
                            </div>
                          </div>
                          @if($testpaper->test_type == "free")
                              <div class="mockup-start-btn">
                           <a href="#" class="osd-cus s">Start test
                            </a>
                          </div>
                          @else
                           <div class="mockup-start-btn">
                            <a href="#" class="osd-cus s un"><span class="fa fa-lock osds" aria-hidden="true"></span>
                              Unlcok
                              test
                            </a>
                          </div>
                          @endif
                         
                        </div>
                        <div class="bottom-section-mcts">
                          <div class="tq">
                            <i class="fa fa-question-circle" aria-hidden="true"></i> {{$testpaper->total_questions}} Questions
                          </div>
                          <div class="tq">
                            <span class="icon flaticon-file osds" aria-hidden="true"></span> <span class="pl-2">{{$testpaper->total_marks}}
                              Marks</span>
                          </div>
                          <div class="tq">
                            <span class="icon flaticon-time osds" aria-hidden="true"></span> <span class="pl-2">{{$testpaper->duration}}
                              Minute</span>
                          </div>
                        </div>
                      </div>
                     @endforeach
                    </div>
                  </div>



                </div>

              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-3">
            <div class="side-widgets-ts">
              <div class="mts">
                <h5>More Test Series</h5>
              </div>
              <div class="sidew-conts">
                  @foreach($relatedtestseries as $testseriesr)
                <div class="sidew-cont">
                  <div class="mts-a">
                    <div class="sna">
                     {{$testseriesr->title}}
                    </div>
                    <div class="ts-btm">
                      <div class="test-fst">
                        <div class="fe-a">{{count($testseriesr->testseries)}} Total Tests </div>
                        <div class="fe-">{{$testseriesr->tests->where('test_type','free')->count()}} Free Tests</div>
                      </div>
                    </div>
                  </div>
                  <div class="rights-d" onclick="window.location.href='{{ route('test-series-detail', $testseriesr->slug) }}'">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </div>
                </div>
               @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <section class="test-series-s">
    <div class="auto-container">
      <div class="about-test-ser">
        <div class="cotent">
          <h5>About {{$testseries->title}} (New)</h5>
          <div>{!! $testseries->description !!}</div>
        </div>
      </div>
      <!-- Title Box -->
      <div class="title-box osd">
        <h3>FAQ's</h3>
      </div>
      <div class="inner-container">

        <!-- Accordion Box -->
        <ul class="accordion-box">

          <!-- Block -->
          <li class="accordion block">
            <div class="acc-btn active">
              <div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
                  class="icon icon-minus flaticon-minus-1"></span></div>Can I enter the program from high school?
            </div>
            <div class="acc-content current">
              <div class="content">
                <div class="text">It is a long established fact that a reader will be distracted by the readable content
                  of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                  normal distribution of letters, as opposed to using 'Content here, content here making it look like
                  readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</div>
              </div>
            </div>
          </li>

          <!-- Block -->
          <li class="accordion block">
            <div class="acc-btn">
              <div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
                  class="icon icon-minus flaticon-minus-1"></span></div>Which majors and minors are available for
              Secondary Education students?
            </div>
            <div class="acc-content">
              <div class="content">
                <div class="text">It is a long established fact that a reader will be distracted by the readable content
                  of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                  normal distribution of letters, as opposed to using 'Content here, content here making it look like
                  readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</div>
              </div>
            </div>
          </li>

          <!-- Block -->
          <li class="accordion block">
            <div class="acc-btn">
              <div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
                  class="icon icon-minus flaticon-minus-1"></span></div>What scholarships are available to students?
            </div>
            <div class="acc-content">
              <div class="content">
                <div class="text">It is a long established fact that a reader will be distracted by the readable content
                  of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                  normal distribution of letters, as opposed to using 'Content here, content here making it look like
                  readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</div>
              </div>
            </div>
          </li>

          <!-- Block -->
          <li class="accordion block">
            <div class="acc-btn">
              <div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
                  class="icon icon-minus flaticon-minus-1"></span></div>Can I study on a part time basis?
            </div>
            <div class="acc-content">
              <div class="content">
                <div class="text">It is a long established fact that a reader will be distracted by the readable content
                  of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                  normal distribution of letters, as opposed to using 'Content here, content here making it look like
                  readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</div>
              </div>
            </div>
          </li>

          <!-- Block -->
          <li class="accordion block">
            <div class="acc-btn">
              <div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
                  class="icon icon-minus flaticon-minus-1"></span></div>Can I set up an appointment with a prospective
              student advisor?
            </div>
            <div class="acc-content">
              <div class="content">
                <div class="text">It is a long established fact that a reader will be distracted by the readable content
                  of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                  normal distribution of letters, as opposed to using 'Content here, content here making it look like
                  readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</div>
              </div>
            </div>
          </li>

          <!-- Block -->
          <li class="accordion block">
            <div class="acc-btn">
              <div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
                  class="icon icon-minus flaticon-minus-1"></span></div>What are the admission requirements for x
              program?
            </div>
            <div class="acc-content">
              <div class="content">
                <div class="text">It is a long established fact that a reader will be distracted by the readable content
                  of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                  normal distribution of letters, as opposed to using 'Content here, content here making it look like
                  readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</div>
              </div>
            </div>
          </li>

        </ul>

      </div>

    </div>
  </section>

 
</body>
@endsection