@extends('front.partials.app')
@section('header')
	  <title>Career</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>Carrer</li>
      </ul>
    </div>
  </section>
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
            <h3>Start your Carrer with Adhyayanam</h3>
            <div class="text">Fill the form our team will get back to you shortly!
            </div>
          </div>
          <!-- Comment Form -->
          <div class="comment-form contact-form">
            <form method="POST" action="{{ route('career.store') }}" enctype="multipart/form-data" id="career-form">
              @csrf
              <div class="row clearfix">
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <select name="position" required>
                          <option value="">Post Applying For</option>
                          <option value="Teaching">Teaching</option>
                          <option value="Graphics Designer">Graphics Designer</option>
                      </select>
                  </div>
          
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="text" name="name" placeholder="Your name*" required>
                  </div>
          
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="text" name="email" placeholder="Email Address" required>
                  </div>
          
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="text" name="mobile" placeholder="Mobile Number" required>
                  </div>
          
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <select name="gender" required>
                          <option value="">Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                      </select>
                  </div>
          
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <input type="date" name="dob" placeholder="Date of Birth" required>
                  </div>
          
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <select name="experience" required>
                          <option value="">Total Experience</option>
                          <option value="1 year">1 year</option>
                          <option value="2 years">2 years</option>
                          <option value="3 years">3 years</option>
                          <option value="4 years">4 years</option>
                          <option value="5 years+">5 years+</option>
                      </select>
                  </div>
          
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <select name="qualification" required>
                          <option value="">Highest Qualification</option>
                          <option value="High School">High School</option>
                          <option value="Intermediate">Intermediate</option>
                          <option value="Bachelor">Bachelor</option>
                          <option value="Master">Master</option>
                          <option value="B.ed">B.ed</option>
                          <option value="Other">Other</option>
                      </select>
                  </div>
          
                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                      <textarea name="message" placeholder="Enter detail"></textarea>
                  </div>
          
                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                      <input type="file" name="cv" placeholder="Browse File" required>
                  </div>
          
                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                      <!-- Button Box -->
                      <div class="button-box">
                          <button class="theme-btn submit-btn">Apply Now</button>
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