@extends('front.partials.app')

@section('header')
    <title>{{ $current_affair->meta_title ?? "Current Affairs" }}</title>
    <meta name="description" content="{{ $current_affair->meta_description }}">
    <meta name="keywords" content="{{ $current_affair->meta_keyword }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Bootstrap 5 CDN (latest stable as of now) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Font Awesome 6 CDN (for icons like calendar, arrow-right) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Your custom CSS below or in separate file -->
    <style>
    .bg-card{
        background-color:#efefef !important;
    }
        .prose { color: #374151; max-width: none; }
        .prose h2, .prose h3 { color: #1f2937; margin-top: 2rem; }
        .prose p { line-height: 1.85; margin-bottom: 1.5rem; }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        .glossy-card {
            position: relative;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border: 1px solid rgba(255,255,255,0.8);
            transition: all 0.3s ease;
        }
        .glossy-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
        }
        .glossy-card::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(to bottom right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.35) 50%, rgba(255,255,255,0) 100%);
            transform: rotate(30deg);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .glossy-card:hover::before { opacity: 1; }

        @media (min-width: 992px) {
            .sidebar-sticky { position: sticky; top: 80px; align-self: start; } /* adjust top value based on your header height */
        }
        @media (max-width: 991px) {
            .sidebar-section { margin-top: 3rem; }
        }
    </style>
@endsection

@section('content')
<body class="hidden-bar-wrapper bg-light">

    <!-- Page Title -->
    <section class="page-title bg-card text-dark py-5">
        <div class="container text-center">
            <h2 class="display-5 fw-bold">Adhyayanam</h2>
            <ul class="breadcrumb justify-content-center mt-3 mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-dark-50">Current Affairs Details</li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4 g-lg-5">

                <!-- Main Details (left on lg+, full on mobile) -->
                <div class="col-lg-8">
                    <div class="news-detail bg-white rounded-3 shadow overflow-hidden">
                        <div class="inner-box">
                            <div class="image">
                                <img src="{{ url('storage/' . $current_affair->thumbnail_image) }}"
                                     alt="{{ $current_affair->image_alt_tag ?? $current_affair->title }}"
                                     class="img-fluid w-100 object-cover" style="max-height: 520px;">
                            </div>
                            <div class="lower-content p-4 p-md-5">
                                <div class="d-flex align-items-center mb-4 text-muted small">
                                    <span class="me-3"><i class="far fa-calendar-alt text-primary me-2"></i> {{ $current_affair->publishing_date }}</span>
                                </div>
                                <h2 class="h3 fw-bold mb-4">{{ $current_affair->short_description }}</h2>
                                <div class="prose">
                                    {!! $current_affair->details !!}
                                </div>

                                <!-- Share -->
                                <div class="mt-5 pt-4 border-top">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                        <span class="fw-semibold">Share this:</span>
                                        <div class="d-flex gap-2">
                                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#" class="btn btn-outline-info btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
                                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                                            <a href="#" class="btn btn-outline-success btn-sm rounded-circle"><i class="fab fa-whatsapp"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Recent (right on lg+, below on mobile) -->
                <div class="col-lg-4 sidebar-section sidebar-sticky">
                    <div class="bg-white rounded-3 shadow mb-4 overflow-hidden">
                        <div class="bg-card text-dark px-4 py-3">
                            <h5 class="mb-0">Recent Updates</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($relatedBlogs as $data)
                            <a href="{{ route('blog.details', $data->id) }}" class="list-group-item list-group-item-action px-4 py-3">
                                <div class="d-flex gap-3">
                                    <img src="{{ url('storage/' . $data->image) }}" alt="" class="rounded shadow-sm" width="64" height="64" style="object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1 line-clamp-2">{{ Illuminate\Support\Str::limit($data->heading, 60) }}</h6>
                                        <small class="text-muted">{{ Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags (optional) -->
                    <div class="bg-white rounded-3 shadow p-4">
                        <h5 class="mb-3">Tags</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">UPSC</span>
                            <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">Current Affairs</span>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Economy</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Affairs – Glossy Cards -->
            <div class="mt-5 pt-4">
                <h2 class="text-center fw-bold mb-5">Related Current Affairs</h2>
                <div class="row g-4">
                    @foreach($relatedAffairs as $affair)
                    <div class="col-md-6 col-lg-4">
                        <div class="card glossy-card border-0 shadow h-100 overflow-hidden">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ url('storage/' . $affair->thumbnail_image) }}"
                                     alt="{{ $affair->image_alt_tag ?? $affair->title }}"
                                     class="card-img-top" style="height: 220px; object-fit: cover;">
                            </div>
                            <div class="card-body p-4">
                                <small class="text-muted d-block mb-2">{{ $affair->publishing_date }}</small>
                                <h5 class="card-title fw-semibold mb-3 line-clamp-2">{{ $affair->title }}</h5>
                                <p class="card-text text-muted small line-clamp-3 mb-3">{{ $affair->short_description }}</p>
                                <a href="{{ route('current.details', $affair->id) }}" class="btn btn-outline-primary btn-sm">
                                    Read More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</body>
@endsection