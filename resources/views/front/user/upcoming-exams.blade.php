@extends('front.partials.app')

@section('header')
<title>{{ 'Upcoming Exams' }}</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endsection

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .upcoming-card-new {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #ffffff;
        border-radius: 24px;
        padding: 28px 32px;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 
                    0 10px 30px -10px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .upcoming-card-new:hover {
        transform: translateY(-3px);
        border-color: #cbd5e1;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 
                    0 20px 40px -15px rgba(0, 0, 0, 0.06);
    }

    /* Top */
    .upcoming-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 16px;
    }

    /* Badge */
    .upcoming-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        color: #475569;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.5;
        border: 1px solid #e2e8f0;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        transition: all 0.2s ease;
    }

    .badge-dot {
        width: 6px;
        height: 6px;
        background: #3b82f6;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Download Button */
    .download-btn {
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 50%;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
    }

    .download-btn:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #fff;
        transform: translateY(-1px);
    }

    /* Title */
    .upcoming-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 10px;
        letter-spacing: -0.02em;
    }

    /* Description */
    .upcoming-desc {
        color: #475569;
        font-size: 14px;
        line-height: 1.55;
        margin-bottom: 0;
    }

    /* Info List - Clean Row */
    .upcoming-info-list {
        display: flex;
        flex-direction: row;
        gap: 20px 32px;
        flex-wrap: wrap;
        width: 100%;
        margin-top: 0;
    }

    /* Info Item Left-Bordered */
    .upcoming-info-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 4px;
        padding-left: 14px;
        min-width: 120px;
        border-bottom: none;
        transition: border-color 0.2s ease;
    }

    /* Color Coded Border Timeline */
    .upcoming-info-item:nth-child(1) { border-left: 2px solid #3b82f6; } /* Ad Date - Blue */
    .upcoming-info-item:nth-child(2) { border-top: none; border-left: 2px solid #8b5cf6; } /* Exam Date - Violet */
    .upcoming-info-item:nth-child(3) { border-top: none; border-left: 2px solid #ef4444; } /* Last Date - Red */
    .upcoming-info-item:nth-child(4) { border-top: none; border-left: 2px solid #10b981; } /* Form Start - Emerald */

    .upcoming-info-item span {
        color: #64748b;
        font-weight: 600;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .upcoming-info-item strong {
        color: #1e293b;
        font-weight: 700;
        font-size: 14px;
    }

    /* Last Date Danger override */
    .upcoming-info-item strong.text-danger {
        color: #ef4444 !important;
        background: transparent !important;
        padding: 0 !important;
        border-radius: 0 !important;
        font-size: 14px !important;
    }

    /* Buttons */
    .upcoming-actions {
        margin-top: 0;
    }

    .btn-view-details {
        width: 100%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        background: #0f172a;
        color: #fff;
        padding: 14px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        border: none;
        box-shadow: 0 4px 10px 0 rgba(15, 23, 42, 0.08);
    }

    .btn-view-details:hover {
        color: #fff;
        background: #4f46e5;
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.2);
    }

    .btn-view-details i {
        transition: transform 0.2s ease;
    }

    .btn-view-details:hover i {
        transform: translateX(3px);
    }

    .disabled-btn {
        opacity: 1 !important;
        cursor: not-allowed;
        background: #f8fafc !important;
        color: #64748b !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: none !important;
    }

    .disabled-btn:hover {
        transform: none !important;
        box-shadow: none !important;
        background: #f8fafc !important;
    }

    /* Widescreen Horizontal Layout (min-width: 1200px) */
    @media (min-width: 1200px) {
        .upcoming-card-new {
            display: grid;
            grid-template-columns: 1.4fr 2.2fr 0.8fr;
            grid-template-rows: auto auto auto;
            align-items: center;
            gap: 12px 48px;
            padding: 28px 40px;
        }

        .upcoming-top {
            grid-column: 1;
            grid-row: 1;
            margin-bottom: 0;
            justify-content: flex-start;
            gap: 16px;
        }

        .upcoming-title {
            grid-column: 1;
            grid-row: 2;
            margin-bottom: 0;
            font-size: 22px;
        }

        .upcoming-desc {
            grid-column: 1;
            grid-row: 3;
            margin-bottom: 0;
        }

        .upcoming-info-list {
            grid-column: 2;
            grid-row: 1 / span 3;
        }

        .upcoming-actions {
            grid-column: 3;
            grid-row: 1 / span 3;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-view-details {
            padding: 14px 20px;
            width: auto;
            min-width: 150px;
        }
    }

    /* Medium Tablet Horizontal Layout (992px to 1199px) */
    @media (min-width: 992px) and (max-width: 1199px) {
        .upcoming-card-new {
            display: grid;
            grid-template-columns: 1.3fr 1.8fr 0.8fr;
            grid-template-rows: auto auto auto;
            align-items: center;
            gap: 10px 32px;
            padding: 24px 32px;
        }

        .upcoming-top {
            grid-column: 1;
            grid-row: 1;
            margin-bottom: 0;
            justify-content: flex-start;
            gap: 12px;
        }

        .upcoming-title {
            grid-column: 1;
            grid-row: 2;
            margin-bottom: 0;
            font-size: 20px;
        }

        .upcoming-desc {
            grid-column: 1;
            grid-row: 3;
            margin-bottom: 0;
            font-size: 13px;
        }

        .upcoming-info-list {
            grid-column: 2;
            grid-row: 1 / span 3;
            gap: 16px 24px;
        }

        .upcoming-info-item {
            padding-left: 10px;
            min-width: 110px;
        }

        .upcoming-info-item span {
            font-size: 9px;
        }

        .upcoming-info-item strong {
            font-size: 13px;
        }

        .upcoming-actions {
            grid-column: 3;
            grid-row: 1 / span 3;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-view-details {
            padding: 12px 24px;
            width: auto;
            min-width: 130px;
        }
    }

    /* Mobile & Portrait Tablet Layout */
    @media (max-width: 991px) {
        .upcoming-card-new {
            padding: 24px;
            gap: 20px;
        }

        .upcoming-top {
            margin-bottom: 0;
        }

        .upcoming-title {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .upcoming-info-list {
            gap: 16px 28px;
            margin-top: 4px;
        }

        .upcoming-info-item {
            padding-left: 12px;
        }

        .upcoming-actions {
            margin-top: 4px;
        }
    }

    /* Small Mobile Layout */
    @media (max-width: 480px) {
        .upcoming-info-list {
            flex-direction: column;
            gap: 16px;
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

                <div class="col-12 mb-4">

                    <div class="upcoming-card-new">

                        {{-- Top --}}
                        <div class="upcoming-top">

                            <div class="upcoming-badge">

                                <span class="badge-dot"></span>

                                {{ Str::limit($data->exam_commission->name ?? 'Government Exam', 28) }}

                            </div>

                            @if($data->pdf)

                            <a href="{{ asset('storage/' . $data->pdf) }}" target="_blank" class="download-btn">

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

                            {{ Str::limit($data->description ?? 'Important government exam notification with complete
                            details.', 120, '...') }}

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

                            <a href="{{ asset('storage/' . $data->pdf) }}" target="_blank" class="btn-view-details">

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