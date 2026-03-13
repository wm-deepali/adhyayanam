@extends('front.partials.app')

@section('header')
    <title>Test Planner - Adhyayanam</title>
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
                <h2 class="display-5 fw-bold">Adhyayanam</h2>
                <ul class="breadcrumb justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-dark-50">Test Planner</li>
                </ul>
            </div>
        </section>

        <!-- Test Planner Section -->
        <section class="course-page-section-two py-5">
            <div class="container">
                <!-- Section Title -->
                <div class="sec-title text-center mb-5">
                    <h2 class="display-6 fw-bold text-dark">Our Test Planner</h2>
                    <p class="text-muted mt-2">Structured test series to boost your preparation and track progress</p>
                </div>

                <div class="row g-4">
                    @foreach($testPlans as $data)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card test-plan-card h-100 border-0 shadow-sm rounded-4 overflow-hidden transition-all">
                                <div class="card-body d-flex flex-column p-4 text-center">
                                    <!-- Icon -->
                                    <div class="mb-4">
                                        <i class="fas fa-calendar-check fa-4x text-primary opacity-75"></i>
                                    </div>

                                    <!-- Title -->
                                    <h5 class="card-title fw-bold mb-3 line-clamp-2" style="min-height: 50px;">
                                        {{ $data->title }}
                                    </h5>

                                    <!-- Start Date -->
                                    <p class="text-muted mb-4 small">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        Starts on: <strong>{{ $data->start_date }}</strong>
                                    </p>

                                    <!-- View Details Button -->
                                    <div class="mt-auto">
                                        <a href="{{ route('test.planner.details', $data->id) }}" 
                                           class="btn btn-outline-primary btn-lg w-100 fw-medium">
                                            View Details <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Optional Load More -->
                {{-- 
                <div class="text-center mt-5">
                    <a href="#" class="btn btn-primary btn-lg px-5">Load More Test Planners</a>
                </div>
                --}}
            </div>
        </section>

    </body>

    <!-- Custom Styles -->
    <style>
        .test-plan-card {
            transition: all 0.3s ease;
            background: white;
            border-radius: 16px !important;
        }
        .test-plan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
        }
        .test-plan-card .btn-outline-primary {
            transition: all 0.3s ease;
        }
        .test-plan-card:hover .btn-outline-primary {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 576px) {
            .test-plan-card .card-body {
                padding: 1.5rem;
            }
        }
        .bg-card{
            background:#e9e9e9;
        }
    </style>
@endsection