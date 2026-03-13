@extends('front.partials.app')

@section('header')
    <title>{{ $dailyBoost->title }} - Daily Booster | Adhyayanam</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

@section('content')
    <body class="hidden-bar-wrapper bg-light">

        <!-- Page Title -->
        <section class="page-title bg-card text-white py-5">
            <div class="container text-center">
                <h2 class="display-5 fw-bold text-center" style="width:70%; margin:auto;">{{ $dailyBoost->title }}</h2>
                <ul class="breadcrumb justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-dark text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="/" class="text-dark text-decoration-none">Daily Booster</a></li>
                    <li class="breadcrumb-item active text-dark-50">Details</li>
                </ul>
            </div>
        </section>

        <!-- Single Card Details -->
        <section class="content-section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-9">
                        <div class="card detail-card border-0 shadow-xl rounded-4 overflow-hidden bg-white">
                            <!-- Thumbnail -->
                            <img src="{{ url('storage/' . $dailyBoost->thumbnail) }}" 
                                 class="card-img-top w-100" 
                                 alt="{{ $dailyBoost->title }}"
                                 style="height: 380px; object-fit: cover;">

                            <!-- Card Body: All content here -->
                            <div class="card-body p-4 p-md-5">
                                <!-- Title (repeated for emphasis) -->
                                <h1 class="h3 fw-bold text-dark mb-4 text-center text-md-start">
                                    {{ $dailyBoost->title }}
                                </h1>

                                <!-- Meta + YouTube Button -->
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4 mb-5 pb-4 border-bottom">
                                    <div class="text-muted small d-flex align-items-center">
                                        <i class="far fa-calendar-alt text-primary me-2 fs-4"></i>
                                        <strong>Start Date:</strong> {{ $dailyBoost->start_date }}
                                    </div>

                                    <a href="{{ $dailyBoost->youtube_url }}" 
                                       target="_blank" 
                                       class="btn btn-danger btn-lg px-5 d-flex align-items-center gap-3 shadow">
                                        <i class="fab fa-youtube fs-3"></i>
                                        Watch on YouTube
                                    </a>
                                </div>

                                <!-- Detailed Content -->
                                <div class="detail-content prose prose-lg text-gray-800 lh-lg">
                                    {!! $dailyBoost->detail_content !!}
                                </div>

                                <!-- Back Button -->
                                <div class="mt-5 pt-4 border-top text-center">
                                    <a href="{{ route('daily.boost.front') }}" 
                                       class="btn btn-outline-secondary btn-lg px-5">
                                        <i class="fas fa-arrow-left me-2"></i> Back to Daily Booster List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>

    <!-- Custom Styles -->
    <style>
    .bg-card{
        background-color:#efefef !important;
    }
        .detail-card {
            transition: all 0.3s ease;
        }
        .detail-card:hover {
            box-shadow: 0 20px 50px rgba(0,0,0,0.15) !important;
        }

        .prose {
            font-size: 1.1rem;
            line-height: 1.85;
        }
        .prose h2, .prose h3 {
            color: #1f2937;
            margin: 2.5rem 0 1.25rem;
        }
        .prose p {
            margin-bottom: 1.5rem;
        }
        .prose ul, .prose ol {
            padding-left: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.35);
        }

        @media (max-width: 991px) {
            .card-body {
                padding: 1.5rem !important;
            }
            img.card-img-top {
                height: 280px !important;
            }
        }
    </style>
@endsection