@extends('front.partials.app')
@section('header')
	  <title>Call-Back</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Call Back</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="carrer-page">
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-sm-12 col-md-6">
          <img src="./images/resource/call-back.svg" />
        </div>
        <div class="col-sm-12 col-md-6">
          <div class="form-column">
            <div class="inner-column osd-c">
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              <div class="title-box mb-b">
                <h3>Call Back Now</h3>
                <div class="text">Fill the form our team will get back to you shortly!
                </div>
              </div>
              <!-- Comment Form -->
              <div class="comment-form contact-form">
                <form method="post" action="{{route('callback.inquiry.store')}}" id="carrer-form">
                  @csrf
                  <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <select name="query_for">
                        <option>Query For</option>
                        <option>Teaching</option>
                        <option>Test Series</option>
                        <option>Current Affairs</option>
                      </select>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="text" name="full_name" placeholder="Your Full Name*" required="">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="text" name="mobile" placeholder="Mobile Number" required="">
                    </div>


                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="text" name="email" placeholder="Email Address" required="">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                      <!-- Button Box -->
                      <div class="button-box">
                        <button class="theme-btn submit-btn">
                          Request Call Back
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
@endsection