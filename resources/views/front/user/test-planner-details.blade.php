@extends('front.partials.app')

@section('header')
    <title>{{ $data->title }} - Test Planner | Adhyayanam</title>
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
                    <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none">Test Planner</a></li>
                    <li class="breadcrumb-item active text-dark-50">{{ Str::limit($data->title, 30) }}</li>
                </ul>
            </div>
        </section>

        <!-- Main Details Section -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-9">
                        <div class="card planner-detail-card border-0 shadow-xl rounded-4 overflow-hidden bg-white">
                            <!-- Optional Thumbnail / Banner (if you have one) -->
                            @if($data->thumbnail ?? false)
                            <img src="{{ url('storage/' . $data->thumbnail) }}" 
                                 class="card-img-top w-100" 
                                 alt="{{ $data->title }}"
                                 style="height: 320px; object-fit: cover;">
                            @else
                            <!-- Placeholder if no thumbnail -->
                            <div class="bg-card text-dark text-center py-5">
                                <i class="fas fa-clipboard-list fa-5x opacity-50 mb-3"></i>
                                <h3 class="fw-bold">Test Planner</h3>
                            </div>
                            @endif

                            <!-- Card Body -->
                            <div class="card-body p-4 p-md-5">
                                <!-- Title -->
                                <h1 class="h3 fw-bold text-dark mb-4 text-center text-md-start">
                                    {{ $data->title }}
                                </h1>

                                <!-- Short Description -->
                                <p class="lead text-muted mb-5 text-center text-md-start">
                                    {{ $data->short_description }}
                                </p>

                                <!-- Full Content -->
                                <div class="detail-content prose prose-lg text-gray-800 lh-lg mb-5">
                                    {!! $data->detail_content !!}
                                </div>

                                <!-- PDF Download Button -->
                                @if($data->pdf)
                                    <div class="text-center">
                                        <a href="{{ url('storage/' . $data->pdf) }}" 
                                           download="{{ $data->title }}"
                                           class="btn btn-success btn-lg px-5 py-3 shadow d-inline-flex align-items-center gap-3">
                                            <i class="fas fa-file-pdf fa-2x"></i>
                                            Download PDF
                                        </a>
                                    </div>
                                @else
                                    <div class="alert alert-info text-center">
                                        No PDF available for this planner.
                                    </div>
                                @endif

                                <!-- Back Button -->
                                <div class="mt-5 pt-4 border-top text-center">
                                    <a href="{{ route('test.planner.front') ?? url('/test-planner') }}" 
                                       class="btn btn-outline-secondary btn-lg px-5">
                                        <i class="fas fa-arrow-left me-2"></i> Back to Test Planners
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
        background:#e9e9e9;
    }
        .planner-detail-card {
            transition: all 0.3s ease;
        }
        .planner-detail-card:hover {
            box-shadow: 0 25px 60px rgba(0,0,0,0.15) !important;
        }

        .prose {
            font-size: 1.08rem;
            line-height: 1.9;
        }
        .prose h2, .prose h3, .prose h4 {
            color: #1f2937;
            margin: 2.5rem 0 1.25rem;
        }
        .prose p {
            margin-bottom: 1.6rem;
        }
        .prose ul, .prose ol {
            padding-left: 1.8rem;
            margin-bottom: 1.6rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
        }

        .btn-success {
            background: #198754;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background: #157347;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(25, 135, 84, 0.35);
        }

        @media (max-width: 991px) {
            .card-body {
                padding: 2rem 1.5rem !important;
            }
            img.card-img-top {
                height: 260px !important;
            }
        }
    </style>
@endsection