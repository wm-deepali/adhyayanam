@extends('front.partials.app')

@section('header')
    <title>Syllabus - Adhyayanam</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection

<style>
    .bg-card{
        background-color:#efefef !important;
    }
</style>

@section('content')
    <body class="hidden-bar-wrapper bg-light">

        <!-- Page Title -->
        <section class="page-title bg-card text-white py-5">
            <div class="container text-center">
                <h2 class="display-5 fw-bold">Adhyayanam</h2>
                <ul class="breadcrumb justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-dark-50">Syllabus</li>
                </ul>
            </div>
        </section>

        <!-- Syllabus Section -->
        <section class="syllabus-section py-5">
            <div class="container">
                <div class="row g-4">

                    <!-- Left Sidebar: Subjects (fixed height + scroll) -->
                    <div class="col-lg-3">
                        <div class="bg-white rounded-3 shadow-sm border p-3 p-lg-4 " style="top: 130px;">
                            <h5 class="mb-3 fw-bold text-center text-lg-start">Subjects</h5>

                            <!-- Fixed height scrollable subjects list -->
                            <div class="subjects-scroll" style="max-height: 780px; overflow-y: auto; padding-right: 8px;">
                                <ul class="subject-list list-unstyled mb-0">
                                    <li>
                                        <a href="{{ route('syllabus.front', [$commissionId ?? null, $categoryId ?? null, $subCategoryId ?? null]) }}"
                                           class="d-block px-3 py-2 rounded mb-1 text-decoration-none small {{ !request('subject') ? 'active' : '' }}">
                                            All Subjects
                                        </a>
                                    </li>
                                    @foreach($subjects as $subject)
                                        <li>
                                            <a href="{{ route('syllabus.front', [$commissionId ?? null, $categoryId ?? null, $subCategoryId ?? null, 'subject' => $subject->id]) }}"
                                               class="d-block px-3 py-2 rounded mb-1 text-decoration-none small {{ request('subject') == $subject->id ? 'active' : '' }}">
                                                {{ $subject->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Syllabus Content (already fixed height + scroll) -->
                    <div class="col-lg-9">
                        <div class="bg-white rounded-3 shadow-sm border p-4 p-lg-5">
                            @if($syllabus->isEmpty())
                                <div class="alert alert-info text-center py-5 mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No syllabus available for this selection.
                                </div>
                            @else
                                <div class="syllabus-scroll-container" style="max-height: 780px; overflow-y: auto; padding-right: 10px;">
                                    @foreach($syllabus as $item)
                                        <div class="syllabus-item mb-3 p-4 border rounded bg-light-subtle shadow-sm">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="fw-bold mb-0">
                                                    {{ $item->title }}
                                                    <small class="text-muted ms-2">({{ $item->type }})</small>
                                                </h5>
                                                @if($item->pdf)
                                                    <a href="{{ asset('storage/' . $item->pdf) }}" target="_blank"
                                                       class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="text-dark lh-lg small">
                                                {!! $item->detail_content !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </body>

    <!-- Custom Styles -->
    <style>
        /* Subjects sidebar scroll styling */
        .subjects-scroll {
            scrollbar-width: thin;
            scrollbar-color: #adb5bd #f1f3f5;
        }
        .subjects-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .subjects-scroll::-webkit-scrollbar-track {
            background: #f1f3f5;
            border-radius: 10px;
        }
        .subjects-scroll::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 10px;
        }
        .subjects-scroll::-webkit-scrollbar-thumb:hover {
            background: #6c757d;
        }

        /* Subject list compact spacing */
        .subject-list a {
            color: #333;
            transition: all 0.25s ease;
            font-size: 0.85rem;
            background: aliceblue;
        }
        .subject-list a:hover,
        .subject-list a.active {
            background-color: #ff8a00;
            color: white;
            font-weight: 600;
            padding-left: 18px !important;
        }

        /* Syllabus content scroll */
        .syllabus-scroll-container {
            scrollbar-width: thin;
            scrollbar-color: #adb5bd #f1f3f5;
        }
        .syllabus-scroll-container::-webkit-scrollbar {
            width: 8px;
        }
        .syllabus-scroll-container::-webkit-scrollbar-track {
            background: #f1f3f5;
            border-radius: 10px;
        }
        .syllabus-scroll-container::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 10px;
        }
        .syllabus-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #6c757d;
        }

        /* Hover effect on syllabus cards */
        .syllabus-item {
            transition: all 0.2s ease;
        }
        .syllabus-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        @media (max-width: 991px) {
            .sticky-lg-top {
                position: static !important;
            }
            .subjects-scroll,
            .syllabus-scroll-container {
                max-height: 500px; /* mobile par thoda chhota */
            }
        }
    </style>
@endsection