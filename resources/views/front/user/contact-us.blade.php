@extends('front.partials.app')

@section('header')
    <title>Contact Us</title>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@section('content')

    <body class="hidden-bar-wrapper">

        <!-- Page Title -->
        <section class="page-title">
            <div class="auto-container">

                <h2>Adhyayanam</h2>

                <ul class="bread-crumb clearfix">
                    <li>
                        <a href="{{ url('/') }}">
                            Home
                        </a>
                    </li>

                    <li>
                        Contact Us
                    </li>
                </ul>

            </div>
        </section>
        <!-- End Page Title -->


        <!-- Contact Page -->
        <section class="contact-page-section">

            <div class="auto-container">

                <div class="row clearfix">

                    <!-- Form Column -->
                    <div class="form-column col-lg-7 col-md-12 col-sm-12">

                        <div class="inner-column contact-form-card">

                            <div class="sec-title mb-4">

                                <h2>
                                    Get In Touch
                                </h2>

                                <div class="text">
                                    Have questions? Our team will get back to you shortly.
                                </div>

                            </div>


                            {{-- Success --}}
                            @if(session('success'))

                                <div class="alert alert-success alert-dismissible fade show">

                                    {{ session('success') }}

                                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                                    </button>

                                </div>

                            @endif


                            {{-- Error --}}
                            @if($errors->any())

                                <div class="alert alert-danger alert-dismissible fade show">

                                    <ul class="mb-0">

                                        @foreach($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                        @endforeach

                                    </ul>

                                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                                    </button>

                                </div>

                            @endif


                            <div class="comment-form contact-form">

                                <form method="POST" action="{{ route('contact.inquiry.store') }}">

                                    @csrf

                                    <div class="row clearfix">

                                        {{-- Name --}}
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">

                                            <input type="text" name="name" value="{{ old('name') }}"
                                                placeholder="Your Name *" required>

                                        </div>


                                        {{-- Email --}}
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">

                                            <input type="email" name="email" value="{{ old('email') }}"
                                                placeholder="Email Address *" required>

                                        </div>


                                        {{-- Subject --}}
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">

                                            <input type="text" name="subject" value="{{ old('subject') }}"
                                                placeholder="Subject">

                                        </div>


                                        {{-- Message --}}
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">

                                            <textarea name="message"
                                                placeholder="Write your message">{{ old('message') }}</textarea>

                                        </div>


                                        {{-- Button --}}
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">

                                            <button class="theme-btn submit-btn">

                                                Send Message

                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>


                    <!-- Info Column -->
                    <div class="info-column col-lg-5 col-md-12 col-sm-12">

                        <div class="inner-column">

                            {{-- Office Addresses --}}
                            @foreach($officeAddresses as $office)

                                <div class="office-card">

                                    <div class="office-header">

                                        <span class="office-icon flaticon-placeholder"></span>

                                        <h4>
                                            {{ $office->office_type }}
                                        </h4>

                                    </div>


                                    <div class="office-address">

                                        {!! nl2br(e($office->address)) !!}

                                    </div>


                                    @if($office->phone)

                                        <div class="office-contact-item">

                                            <span class="flaticon-phone-call-2"></span>

                                            <a href="tel:{{ $office->phone }}">

                                                {{ $office->phone }}

                                            </a>

                                        </div>

                                    @endif


                                    @if($office->email)

                                        <div class="office-contact-item">

                                            <span class="flaticon-message"></span>

                                            <a href="mailto:{{ $office->email }}">

                                                {{ $office->email }}

                                            </a>

                                        </div>

                                    @endif

                                </div>

                            @endforeach


                            {{-- Social Media --}}
                            <div class="office-card">

                                <div class="office-header">

                                    <span class="office-icon flaticon-share"></span>

                                    <h4>
                                        Follow Us
                                    </h4>

                                </div>

                                <div class="social-icons-wrap">

                                    @if(!empty($socialMedia->facebook))
                                        <a href="{{ $socialMedia->facebook }}" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif

                                    @if(!empty($socialMedia->instagram))
                                        <a href="{{ $socialMedia->instagram }}" target="_blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif

                                    @if(!empty($socialMedia->twitter))
                                        <a href="{{ $socialMedia->twitter }}" target="_blank">
                                            <i class="fab fa-x-twitter"></i>
                                        </a>
                                    @endif

                                    @if(!empty($socialMedia->youtube))
                                        <a href="{{ $socialMedia->youtube }}" target="_blank">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    @endif

                                    @if(!empty($socialMedia->linkdin))
                                        <a href="{{ $socialMedia->linkdin }}" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    @endif

                                    @if(!empty($socialMedia->whatsapp))
                                        <a href="{{ $socialMedia->whatsapp }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Maps --}}
                @if($officeAddresses->count())

                    <div class="office-maps-section">

                        <div class="sec-title text-center mb-5">

                            <h2>
                                Our Locations
                            </h2>

                        </div>

                        <div class="row">

                            @foreach($officeAddresses as $office)

                                @if($office->map_link)

                                    <div class="map-card">

                                        <h4 class="map-title">
                                            {{ $office->office_type }}
                                        </h4>

                                        <div class="map-box">

                                            <iframe src="https://maps.google.com/maps?q={{ urlencode($office->address) }}&output=embed"
                                                width="100%" height="350" style="border:0;" loading="lazy">
                                            </iframe>

                                        </div>

                                        <div class="mt-3">
                                            <a href="{{ $office->map_link }}" target="_blank" class="theme-btn btn-style-one">
                                                View on Google Maps
                                            </a>
                                        </div>

                                    </div>

                                @endif

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>

        </section>


        <style>
            .contact-form-card {
                background: #fff;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
            }

            .office-card {
                background: #fff;
                padding: 28px;
                border-radius: 18px;
                margin-bottom: 25px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }

            .office-header {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 18px;
            }

            .office-header h4 {
                margin: 0;
                font-size: 22px;
                font-weight: 700;
            }

            .office-icon {
                font-size: 30px;
                color: #0d6efd;
            }

            .office-address {
                line-height: 1.9;
                color: #4b5563;
                margin-bottom: 18px;
            }

            .office-contact-item {
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .office-contact-item span {
                color: #0d6efd;
            }

            .social-icons-wrap {
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
            }

            .social-icons-wrap a {
                width: 46px;
                height: 46px;
                border-radius: 50%;
                background: #f1f5f9;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #111827;
                transition: 0.3s;
            }

            .social-icons-wrap a:hover {
                background: #0d6efd;
                color: #fff;
            }

            .office-maps-section {
                margin-top: 70px;
            }

            .map-card {
                background: #fff;
                padding: 20px;
                border-radius: 18px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }

            .map-title {
                margin-bottom: 18px;
                font-size: 22px;
                font-weight: 700;
            }

            .map-box iframe {
                width: 100%;
                height: 350px;
                border: 0;
                border-radius: 14px;
            }

            @media(max-width:768px) {

                .contact-form-card {
                    padding: 25px;
                }

                .office-card {
                    padding: 22px;
                }

                .map-box iframe {
                    height: 250px;
                }
            }
        </style>

    </body>

@endsection