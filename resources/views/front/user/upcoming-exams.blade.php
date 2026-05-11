@extends('front.partials.app')

@section('header')
    <title>{{ 'Upcoming Exams' }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

<style>
    .upcoming-card-new {
        background: #fff;
        border-radius: 22px;
        padding: 24px;
        height: 100%;
        transition: all 0.35s ease;
        border: 1px solid #edf2f7;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }

    .upcoming-card-new:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.10);
    }

    /* Top */
    .upcoming-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 22px;
    }

    /* Badge */
    .upcoming-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f4f7fb;
        color: #045279;
        padding: 10px 16px;
        border-radius: 14px;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
        border: 1px solid #e3ebf5;
    }

    .badge-dot {
        width: 8px;
        height: 8px;
        background: #0d6efd;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Download Button */
    .download-btn {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 12px;
        background: #f4f7fb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #045279;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid #e5edf7;
    }

    .download-btn:hover {
        background: #045279;
        color: #fff;
    }

    /* Title */
    .upcoming-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.4;
        margin-bottom: 14px;
        min-height: 68px;
    }

    /* Description */
    .upcoming-desc {
        color: #6b7280;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 22px;
    }

    /* Info */
    .upcoming-info-list {
        margin-top: auto;
    }

    .upcoming-info-item {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .upcoming-info-item span {
        color: #64748b;
    }

    .upcoming-info-item strong {
        color: #111827;
        text-align: right;
    }

    /* Buttons */
    .upcoming-actions {
        margin-top: 26px;
    }

    .btn-view-details {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(90deg, #045279, #0d6efd);
        color: #fff;
        padding: 14px 18px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-view-details:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(13, 110, 253, 0.25);
    }

    .disabled-btn {
        opacity: 0.75;
        cursor: not-allowed;
        background: #94a3b8 !important;
    }

    .disabled-btn:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* Responsive */
    @media(max-width:768px) {

        .upcoming-title {
            font-size: 20px;
            min-height: auto;
        }

        .upcoming-card-new {
            padding: 20px;
        }

        .upcoming-info-item {
            flex-direction: column;
            gap: 4px;
        }

        .upcoming-info-item strong {
            text-align: left;
        }
    }
</style>

@section('content')

    <body class="hidden-bar-wrapper">

        <!-- Page Title -->
        <section class="page-title">
            <div class="auto-container">

                <h2>Adhyayanam</h2>

                <ul class="bread-crumb clearfix">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>

                    <li>Upcoming Exams</li>
                </ul>

            </div>
        </section>
        <!-- End Page Title -->


        <!-- Upcoming Exams -->
        <section class="course-page-section-two">
            <div class="auto-container">

                <div class="row g-4">

                    @foreach($upcomingExams as $data)

                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                            <div class="upcoming-card-new">

                                {{-- Top --}}
                                <div class="upcoming-top">

                                    <div class="upcoming-badge">

                                        <span class="badge-dot"></span>

                                        {{ Str::limit($data->exam_commission->name ?? 'Government Exam', 28) }}

                                    </div>

                                    @if($data->pdf)

                                        <a href="{{ asset('storage/' . $data->pdf) }}"
                                            target="_blank"
                                            class="download-btn">

                                            <i class="fa-solid fa-download"></i>

                                        </a>

                                    @endif

                                </div>


                                {{-- Title --}}
                                <h4 class="upcoming-title">

                                    {{ $data->examination_name }}

                                </h4>


                                {{-- Description --}}
                                <p class="upcoming-desc">

                                    {{ Str::limit($data->description ?? 'Important government exam notification with complete details.', 120, '...') }}

                                </p>


                                {{-- Dates --}}
                                <div class="upcoming-info-list">

                                    <div class="upcoming-info-item">

                                        <span>Advertisement Date</span>

                                        <strong>
                                            {{ $data->advertisement_date ?? 'N/A' }}
                                        </strong>

                                    </div>

                                    <div class="upcoming-info-item">

                                        <span>Exam Date</span>

                                        <strong>
                                            {{ $data->examination_date ?? 'TBA' }}
                                        </strong>

                                    </div>

                                    <div class="upcoming-info-item">

                                        <span>Last Date</span>

                                        <strong class="text-danger">
                                            {{ $data->submission_last_date ?? 'N/A' }}
                                        </strong>

                                    </div>

                                    @if($data->form_distribution_date)

                                        <div class="upcoming-info-item">

                                            <span>Form Start Date</span>

                                            <strong>
                                                {{ $data->form_distribution_date }}
                                            </strong>

                                        </div>

                                    @endif

                                </div>


                                {{-- Action --}}
                                <div class="upcoming-actions">

                                    @if($data->pdf)

                                        <a href="{{ asset('storage/' . $data->pdf) }}"
                                            target="_blank"
                                            class="btn-view-details">

                                            <i class="fa-solid fa-eye me-2"></i>

                                            View Details

                                        </a>

                                    @else

                                        <button class="btn-view-details disabled-btn">

                                            <i class="fa-solid fa-clock me-2"></i>

                                            Coming Soon

                                        </button>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>
        </section>

    </body>
@endsection