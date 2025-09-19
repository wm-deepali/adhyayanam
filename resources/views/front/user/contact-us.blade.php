@extends('front.partials.app')
@section('header')
	  <title>Contact Us</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Contact Us</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <!-- Contact Page Section -->
  <section class="contact-page-section">
    <div class="auto-container">
      <div class="row clearfix">
        <!-- Form Column -->
        <div class="form-column col-lg-8 col-md-12 col-sm-12">
          <div class="inner-column">
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
            <div class="title-box">
              <h3>Get In Touch</h3>
              <div class="text">Fill the form our team will get back to you shortly!
              </div>
            </div>
            <!-- Comment Form -->
            <div class="comment-form contact-form">
              <form method="post" action="{{route('contact.inquiry.store')}}" id="contact-form">
                @csrf
                <div class="row clearfix">

                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <input type="text" name="name" placeholder="Your name*" required="">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <input type="text" name="email" placeholder="Email Address" required="">
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <input type="text" name="website" placeholder="Subject" required="">
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <textarea class="" name="message" placeholder="Enter your message"></textarea>
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <!-- Button Box -->
                    <div class="button-box">
                      <button class="theme-btn submit-btn">
                        Send Message
                      </button>
                    </div>
                  </div>

                </div>
              </form>
            </div>
            <!-- End Comment Form -->

          </div>
        </div>
        <!-- Info Column -->
        <div class="info-column col-lg-4 col-md-12 col-sm-12">
          <div class="inner-column">
            <!-- Contact List -->
            <ul class="contact-list">
              <li>
                <span class="icon flaticon-placeholder"></span>
                <strong>Find Us:</strong>
                {{$header->address ?? ''}}
              </li>
              <li>
                <span class="icon flaticon-phone-call-2"></span>
                <strong>Call us</strong>
                <a href="tel:{{$header->contact_number ?? ""}}">{{$header->contact_number ?? ""}}</a>
              </li>
              <li>
                <span class="icon flaticon-message"></span>
                <strong>Write to Us</strong>
                <a href="mailto:{{$header->email_id ?? ""}}">{{$header->email_id ?? ""}}</a>
              </li>
              <li>
                <span class="icon flaticon-message"></span>
                <strong>Follow us on</strong>
                <div class="s-icons">
                  <div class="row">
                    <div class="col-3 col-sm-4 col-md-3">
                      <a href="{{$socialMedia->facebook ?? "#"}}" target="_blank" class="flaticon-facebook"></a>
                    </div>
                    <div class="col-3 col-sm-4 col-md-3">
                      <a href="{{$socialMedia->instagram ?? "#"}}" target="_blank" class="flaticon-instagram"></a>
                    </div>
                    <div class="col-3 col-sm-4 col-md-3">
                      <a href="{{$socialMedia->twitter ?? "#"}}" target="_blank" class="flaticon-twitter"></a>
                    </div>
                    <div class="col-3 col-sm-4 col-md-3">
                      <a href="{{$socialMedia->linkdin ?? "#"}}" target="_blank" class="flaticon-link"><svg
                          xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" data-supported-dps="24x24"
                          fill="currentColor" class="mercado-match" width="24" height="24" focusable="false">
                          <path
                            d="M20.5 2h-17A1.5 1.5 0 002 3.5v17A1.5 1.5 0 003.5 22h17a1.5 1.5 0 001.5-1.5v-17A1.5 1.5 0 0020.5 2zM8 19H5v-9h3zM6.5 8.25A1.75 1.75 0 118.3 6.5a1.78 1.78 0 01-1.8 1.75zM19 19h-3v-4.74c0-1.42-.6-1.93-1.38-1.93A1.74 1.74 0 0013 14.19a.66.66 0 000 .14V19h-3v-9h2.9v1.3a3.11 3.11 0 012.7-1.4c1.55 0 3.36.86 3.36 3.66z">
                          </path>
                        </svg></a>
                    </div>
                    <div class="col-3 col-sm-4 col-md-3">
                      <a href="{{$socialMedia->youtube ?? "#"}}" target="_blank" class="flaticon-youtube"></a>
                    </div>

                  </div>

                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>

      <!-- Map Box -->
      <div class="map-box">
        {!!$header->map_embbed!!}
      </div>

    </div>
  </section>
</body>
@endsection