@extends('front.partials.app')
@section('header')
		<title>{{'Feedback & Testinomial'}}</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Feedback & Testinomial</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="carrer-page">
    <div class="auto-container">
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
            <h3>Submit Feedback & Testinomial</h3>
            <div class="text">Fill the form for Feedback & Testinomial!
            </div>
          </div>
          <!-- Comment Form -->
          <div class="comment-form contact-form">
            <form method="post" action="{{route('feed.back.store')}}" id="carrer-form" enctype="multipart/form-data">
              @csrf
              <div class="row clearfix">

                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                  
                  <select class="form-control" name="type" required>
                    <option>Select Option</option>
                    <option value="1">Feedback</option>
                    <option value="2">Testinomial</option>
                  </select>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                  <input type="text" name="username" placeholder="Your name*" required="">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                  <input type="text" name="email" placeholder="Email Address" required="">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                  <input type="text" name="number" placeholder="Mobile Number" required="">
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                  <textarea class="" name="message" placeholder="Enter detail"></textarea>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                  <label>Add Photo</label>
                  <input type="file" name="photo" placeholder="Browse Photo" required="">
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                  <!-- Button Box -->
                  <div class="button-box">
                    <button type="submit" class="theme-btn submit-btn">
                      Submit now
                    </button>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
@endsection