@extends('front.partials.app')

@section('header')
    <title>Daily Booster - Adhyayanam</title>
    <!-- Bootstrap 5 CDN (if not already in layout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

@section('content')
    <body class="hidden-bar-wrapper bg-light">

        <!-- Page Title -->
        <section class="page-title bg-card text-white py-5">
            <div class="container text-center">
                <h2 class="display-5 fw-bold">Adhyayanam</h2>
                <ul class="breadcrumb justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-dark-50">Daily Booster</li>
                </ul>
            </div>
        </section>

        <!-- Daily Booster Section -->
        <section class="courses-section py-5">
            <div class="container">
                <!-- Section Title -->
                <div class="sec-title text-center mb-5">
                    <h2 class="display-6 fw-bold text-dark">Daily Booster Videos</h2>
                    <p class="text-muted mt-2">Short, focused videos to boost your daily preparation</p>
                </div>

                <div class="row g-4">
                    @foreach($dailyBoosts as $data)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card video-card h-100 border-0 shadow-sm overflow-hidden rounded-2 transition-all">
                                <!-- Thumbnail with Play Overlay -->
                                <div class="position-relative overflow-hidden p-2">
                                    <img src="{{ url('storage/' . $data->thumbnail) }}" 
                                         alt="{{ $data->title }}" 
                                         class="card-img-top" 
                                         style="height: 200px; object-fit: cover;">
                                    
                                    <!-- Play Button Overlay -->
                                    <div class="play-overlay position-absolute top-50 start-50 translate-middle">
                                        <a href="{{ $data->youtube_url }}" target="_blank" class="btn btn-play rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-play fa-2x text-white"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body d-flex flex-column p-2" style="margin-top: -10px;">
                                    <h5 class="card-title fw-bold mb-3 line-clamp-2" style="min-height: 50px;">
                                        {{ $data->title }}
                                    </h5>
                                    <p class="card-text text-muted small mb-4 line-clamp-3" style="min-height: 60px;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($data->short_description), 120) }}
                                    </p>
                                    <div class="mt-auto">
                                        <a href="{{ route('daily.booster.detail', $data->id) }}" 
                                           class="btn btn-outline-primary btn-sm w-100">
                                            View Details <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Optional Load More (uncomment if needed) -->
                <!-- 
                <div class="text-center mt-5">
                    <a href="#" class="btn btn-primary btn-lg px-5">Load More Videos</a>
                </div>
                -->
            </div>
        </section>

    </body>

    <!-- Custom CSS -->
    <style>
    .bg-card{
        background-color:#efefef !important;
    }
        .video-card {
            transition: all 0.3s ease;
            background: white;
        }
        .video-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }

        .play-overlay .btn-play {
            width: 70px;
            height: 70px;
            background: rgba(220, 53, 69, 0.9); /* red play button */
            transition: all 0.3s ease;
        }
        .video-card:hover .btn-play {
            transform: scale(1.15);
            background: rgba(220, 53, 69, 1);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 576px) {
            .video-card .card-body {
                padding: 1.25rem;
            }
        }
    </style>
@endsection