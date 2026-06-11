@extends('front.partials.app')

@section('header')
<title>{{$course->meta_title ?? 'Course Details'}}</title>
<meta name="description" content="{{ $course->meta_description ?? 'Default Description' }}">
<meta name="keywords" content="{{ $course->meta_keyword ?? 'default, keywords' }}">
<link rel="canonical" href="{{ url()->current() }}">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    /* Global style context for this page */
    .hidden-bar-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background-color: #f8fafc;
        color: #334155;
    }

    /* ====================== PAGE TITLE / HERO SECTION ====================== */
    /* ====================== PAGE TITLE / HERO SECTION ====================== */
    body.hidden-bar-wrapper .course-page-title {
        position: relative;
        background: linear-gradient(135deg, #0b1528 0%, #1e293b 100%) !important;
        padding: 60px 0 80px !important;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    body.hidden-bar-wrapper .course-page-title::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.15) 0%, rgba(255, 255, 255, 0) 60%);
        pointer-events: none;
    }

    body.hidden-bar-wrapper .course-page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background: linear-gradient(to top, #f8fafc, transparent);
        pointer-events: none;
    }

    body.hidden-bar-wrapper .course-page-title h2 {
        font-size: 38px;
        font-weight: 800;
        color: #ffffff !important;
        margin-bottom: 20px;
        line-height: 1.25;
        letter-spacing: -0.03em;
    }

    body.hidden-bar-wrapper .course-page-title .text,
    body.hidden-bar-wrapper .course-page-title div.text {
        font-size: 15px;
        line-height: 1.65;
        color: #e2e8f0 !important;
        max-width: 800px;
        margin-bottom: 24px;
    }

    /* Breadcrumbs - Enforcing high contrast color for all link states */
    body.hidden-bar-wrapper .ts-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 24px;
        font-size: 13px;
        font-weight: 500;
    }

    body.hidden-bar-wrapper .ts-breadcrumb a,
    body.hidden-bar-wrapper .ts-breadcrumb a:link,
    body.hidden-bar-wrapper .ts-breadcrumb a:visited {
        color: #a5b4fc !important; /* Soft premium indigo-blue links */
        text-decoration: none;
        transition: color 0.2s ease;
    }

    body.hidden-bar-wrapper .ts-breadcrumb a:hover {
        color: #ffffff !important;
        text-decoration: underline !important;
    }

    body.hidden-bar-wrapper .ts-breadcrumb .arrow {
        color: rgba(255, 255, 255, 0.4) !important;
        font-size: 14px;
    }

    body.hidden-bar-wrapper .ts-breadcrumb .current {
        color: #ffffff !important;
        font-weight: 600;
    }

    /* Rating & Enrolled count in Hero */
    body.hidden-bar-wrapper .course-page-title .d-flex {
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    body.hidden-bar-wrapper .course-page-title .rating,
    body.hidden-bar-wrapper .course-page-title .courses {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        padding: 8px 16px !important;
        border-radius: 9999px !important;
        font-size: 13px !important;
        color: #e2e8f0 !important;
        margin: 0 !important;
        height: auto !important;
        line-height: 1 !important;
    }

    body.hidden-bar-wrapper .course-page-title .rating span.fa {
        font-size: 12px;
        color: #fbbf24 !important; /* Rich amber-yellow */
    }

    body.hidden-bar-wrapper .course-page-title .rating i {
        color: #cbd5e1 !important;
        font-style: normal;
        font-weight: 500;
    }

    body.hidden-bar-wrapper .course-page-title .courses strong {
        color: #a5b4fc !important;
        font-size: 14px;
        font-weight: 700;
    }

    /* Style the theme's default pseudo-element icon inside .courses */
    body.hidden-bar-wrapper .course-page-title .courses::before {
        background: rgba(255, 255, 255, 0.1) !important;
        color: #a5b4fc !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        margin-right: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 28px !important;
        height: 28px !important;
        border-radius: 50% !important;
        vertical-align: middle !important;
        font-size: 11px !important;
        position:unset;
    }

    .course-page-title .badge {
        padding: 6px 14px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
        text-transform: uppercase !important;
        border-radius: 8px !important;
    }

.course-page-title .badge.bg-success {
    background: rgb(236 148 0) !important;
    color: #ffffff !important;
    border: 1px solid rgb(236 148 0) !important;
}

.course-detail-section .upper-box {

    padding: 50px 30px 30px !Important;
   
}
    /* ====================== UPPER BOX INFO CARDS ====================== */
    .course-detail-section {
        padding-top: 0 !important;
        margin-top: -40px;
        position: relative;
        z-index: 10;
    }

    .upper-box {
        margin-bottom: 40px;
    }

    .upper-box .course-info {
        margin-bottom: 0;
    }

    .upper-box .inner-box {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        gap: 6px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .upper-box .inner-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px -10px rgba(0, 0, 0, 0.06);
        border-color: rgba(37, 99, 235, 0.2);
    }

    .upper-box .inner-box .icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(37, 99, 235, 0.06);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }

    .upper-box .inner-box:hover .icon {
        background: #2563eb;
        color: #ffffff;
    }

    .upper-box .inner-box strong {
        color: #0f172a;
        font-size: 16px;
        font-weight: 700;
        text-transform: none;
        letter-spacing: 0;
        margin-top: 4px;
    }

    /* ====================== LEFT COLUMN - MEDIA & SHARING ====================== */
    .content-column .image {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px -15px rgba(0, 0, 0, 0.1);
        background: #000;
        margin-bottom: 30px;
    }

    .content-column .image img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s ease;
    }

    .content-column .image:hover img {
        transform: scale(1.02);
    }

    .content-column .image iframe {
        display: block;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 45px -15px rgba(0, 0, 0, 0.15);
    }

    /* Social Share Box */
    .news-detail .post-share-options {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 18px 24px;
        margin-bottom: 40px;
    }

    .news-detail .post-share-options .tags-box {
        font-weight: 700;
        font-size: 14px;
        color: #0f172a;
    }

    .news-detail .post-share-options .social-box {
        display: flex;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .news-detail .post-share-options .social-box li a {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .news-detail .post-share-options .social-box li a:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .news-detail .post-share-options .social-box li a.fa-facebook:hover {
        background: #3b5998;
    }

    .news-detail .post-share-options .social-box li a.fa-twitter:hover {
        background: #1da1f2;
    }

    .news-detail .post-share-options .social-box li a.fa-linkedin:hover {
        background: #0077b5;
    }

    .news-detail .post-share-options .social-box li a.fa-pinterest-p:hover {
        background: #bd081c;
    }

    /* ====================== SIDEBAR CTA PRICE CARD ====================== */
    .sidebar-column .inner-column {
        position: sticky;
        top: 30px;
    }

    .sidebar-column .content {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        padding: 36px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .sidebar-column .content .list {
        list-style: none;
        padding: 0;
        margin: 0 0 28px 0;
    }

    .sidebar-column .content .list li {
        display: flex;
        align-items: center;
        /*justify-content: space-between;*/
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #475569;
        gap:10px;
    }


.course-detail-section .sidebar-column .enroll-now {
    position: unset !IMPORTANT;
    margin-bottom: 10px;
}

    .sidebar-column .content .list li:first-child {
        padding-top: 0;
        font-size: 15px;
    }

    .sidebar-column .content .list li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .sidebar-column .content .list li .icon {
        color: #2563eb;
        font-size: 18px;
        margin-right: 8px;
        vertical-align: middle;
    }

    .sidebar-column .content .list li strong {
        color: #0f172a;
        font-weight: 700;
        font-size: 15px;
        margin-top:0px;
    }

    .sidebar-column .content .list li strong del {
        font-weight: 500;
        color: #94a3b8;
    }

    /* Price Item Special Styling */
    .sidebar-column .content .list li:first-child strong {
        font-size: 24px;
        color: #2563eb;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Main CTA Button */
    .sidebar-column .enroll-now {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff !important;
        padding: 16px 28px;
        border-radius: 16px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
    }

    .sidebar-column .enroll-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        filter: brightness(1.05);
    }

    .sidebar-column .enroll-now[href="Javascript:void(0);"] {
        background: #e2e8f0;
        color: #64748b !important;
        box-shadow: none;
        cursor: not-allowed;
    }

    /* ====================== TABS SECTION ====================== */
    .course-info-tabs {
        margin-top: 40px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        padding: 36px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.03);
    }

    .course-tabs .tab-btns {
        background: #f1f5f9;
        border-radius: 16px;
        padding: 6px;
        display: inline-flex;
        gap: 6px;
        margin-bottom: 30px;
        width: 100%;
        max-width: 480px;
        list-style: none;
    }

    .course-tabs .tab-btns .tab-btn {
        flex: 1;
        text-align: center;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .course-tabs .tab-btns .tab-btn:hover {
        color: #0f172a;
    }

    .course-tabs .tab-btns .tab-btn.active-btn {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.04), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
    }

    .tabs-content .tab {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .tabs-content .tab.active-tab {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Rich Text Content Styling */
    .editor-content {
        line-height: 1.8;
        font-size: 16px;
        color: #334155;
    }

    .editor-content h1,
    .editor-content h2,
    .editor-content h3,
    .editor-content h4,
    .editor-content h5 {
        color: #0f172a;
        margin-top: 30px;
        margin-bottom: 14px;
        font-weight: 700;
    }

    .editor-content h1 {
        font-size: 24px;
    }

    .editor-content h2 {
        font-size: 20px;
    }

    .editor-content h3 {
        font-size: 18px;
    }

    .editor-content p {
        margin-bottom: 16px;
    }

    .editor-content ul,
    .editor-content ol {
        padding-left: 24px;
        margin-bottom: 20px;
    }

    .editor-content ul li {
        list-style: none;
        position: relative;
        margin-bottom: 8px;
        padding-left: 14px;
    }

    .editor-content ul li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #2563eb;
        font-weight: bold;
    }

    .editor-content ol li {
        margin-bottom: 8px;
    }

    .editor-content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .editor-content table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 24px 0;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .editor-content table th {
        background: #f8fafc;
        color: #0f172a;
        font-weight: 700;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }

    .editor-content table td,
    .editor-content table th {
        border-right: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 16px;
        font-size: 14px;
    }

    .editor-content table td:last-child,
    .editor-content table th:last-child {
        border-right: none;
    }

    .editor-content table tr:last-child td {
        border-bottom: none;
    }

    /* Reviews Styling */
    .editor-content .border-bottom {
        border-bottom: 1px solid #f1f5f9 !important;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .editor-content .border-bottom:last-child {
        border-bottom: none !important;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    /* ====================== MOBILE BOTTOM FIXED BAR ====================== */
    .mobile-fixed-price-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        box-shadow: 0 -4px 30px rgba(0, 0, 0, 0.06);
        z-index: 9999;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        gap: 20px;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
    }

    .price-section {
        flex: 1;
    }

    .price-label {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 2px;
    }

    .price-value {
        font-size: 20px;
        font-weight: 800;
        color: #2563eb;
    }

    .price-value del {
        font-size: 14px;
        color: #94a3b8;
        margin-left: 6px;
        font-weight: 500;
    }

    .enroll-section {
        flex-shrink: 0;
    }

    .enroll-btn {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: white !important;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.2);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .enroll-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .enroll-btn.disabled {
        background: #e2e8f0 !important;
        color: #64748b !important;
        box-shadow: none;
        cursor: not-allowed;
    }
    
    .course-detail-section .sidebar-column .enroll-now {
    position: unset;
  
}

.course-detail-section .sidebar-column .enroll-now:before{
    border:none;
}

.course-detail-section .sidebar-column ul .icon {
    position: unset !important;
   
}

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .course-page-title {
            padding: 40px 0 60px !important;
        }

        .course-page-title h2 {
            font-size: 28px;
        }

        .upper-box {
            margin-bottom: 24px;
        }

        .upper-box .inner-box {
            padding: 16px;
            border-radius: 16px;
        }

        .upper-box .inner-box .icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
            border-radius: 10px;
        }

        .upper-box .inner-box strong {
            font-size: 14px;
        }

        .course-info-tabs {
            padding: 24px;
            border-radius: 20px;
            margin-top: 30px;
        }

        .course-tabs .tab-btns {
            max-width: 100%;
        }
    }

    @media (max-width: 576px) {
        .mobile-fixed-price-bar {
            padding-bottom: max(12px, env(safe-area-inset-bottom));
        }

        .course-page-title h2 {
            font-size: 24px;
        }

        .course-page-title .d-flex {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }
</style>

@endsection

@section('content')

<body class="hidden-bar-wrapper">


    <!-- Course Page Title -->
    <section class="course-page-title" style="background-image: url(images/background/pattern-10.png)">
        <div class="auto-container">

            <div class="ts-breadcrumb">

                <a href="{{ url('/') }}">Home</a>

                @if($course->examinationCommission)
                <span class="arrow">›</span>

                <a href="{{ route('courses', [
              'exam_id' => $course->examinationCommission->id
            ]) }}">
                    {{ $course->examinationCommission->name }}
                </a>
                @endif


                @if($course->category)
                <span class="arrow">›</span>

                <a href="{{ route('courses', [
              'exam_id' => $course->examinationCommission->id,
              'category_id' => $course->category->id
            ]) }}">
                    {{ $course->category->name }}
                </a>
                @endif


                @if($course->subCategory)
                <span class="arrow">›</span>

                <a href="{{ route('courses', [
              'exam_id' => $course->examinationCommission->id,
              'category_id' => $course->category->id,
              'sub_category_id' => $course->subCategory->id
            ]) }}">
                    {{ $course->subCategory->name }}
                </a>
                @endif


                <span class="arrow">›</span>

                <span class="current">
                    {{ $course->course_heading }}
                </span>

            </div>

            <h2>{{$course->name}}</h2>
            <div class="d-flex flex-wrap">

                <div class="rating">

                    @if(($totalReviews ?? 0) > 0)

                    @php
                    $rating = $avgRating ?? 0;
                    @endphp

                    @for ($i = 1; $i <= 5; $i++) @if($rating>= $i)
                        <span class="fa fa-star"></span>
                        @elseif($rating >= $i - 0.5)
                        <span class="fa fa-star-half-o"></span>
                        @else
                        <span class="fa fa-star-o"></span>
                        @endif
                        @endfor

                        <i>{{ $avgRating }} ({{ $totalReviews }} reviews)</i>

                        @else

                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                        <span class="text-white>No reviews yet</span>

                        @endif

                </div>

                <div class="courses">
                    <strong>{{ number_format($course->orders_count ?? 0) }}</strong> students enrolled
                </div>

            </div>
            <div class="text-white" style="font-size:20px;">
    {{$course->course_heading}}
</div>

            <div class="text">{{$course->short_description}}</div>
            @if($course->feature == 'on')
            <span class="badge bg-success">Featured</span>
            @endif
        </div>
    </section>
    <!-- End Course Page Title -->

    <!-- Course Detail Section -->
    <section class="course-detail-section">
        <div class="auto-container">

            <!-- Upper Box -->
            <div class="upper-box py-4">
                <div class="row g-3 g-lg-4">

                    <!-- Course Info Cards -->
                    <div class="course-info col-6 col-lg-3">
                        <div class="inner-box h-100">
                            <span class="icon flaticon-hourglass"></span>
                            Duration
                            <strong>{{$course->duration}} Weeks</strong>
                        </div>
                    </div>

                    <div class="course-info col-6 col-lg-3">
                        <div class="inner-box h-100">
                            <span class="icon flaticon-three-o-clock-clock"></span>
                            Weekly study
                            <strong>{{$course->weekly_study ?? 0}} Hours / Week</strong>
                        </div>
                    </div>

                    <div class="course-info col-6 col-lg-3">
                        <div class="inner-box h-100">
                            <span class="icon flaticon-internet"></span>
                            Mode
                            <strong>{{$course->course_mode}}</strong>
                        </div>
                    </div>

                    <div class="course-info col-6 col-lg-3">
                        <div class="inner-box h-100">
                            <span class="icon flaticon-document"></span>
                            Last Update
                            <strong>{{ \Carbon\Carbon::parse($course->created_at)->format('M d Y') }}</strong>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Upper Box -->

            <div class="row clearfix">

                <!-- Content Column -->
                <div class="content-column col-lg-8 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="image">
                            @if($course->youtube_url)
                            @php
                            preg_match("/youtu\.be\/([^\?\/]+)/", $course->youtube_url, $matches);
                            $video_id = $matches[1] ?? null;
                            $embed_url = $video_id ? "https://www.youtube.com/embed/$video_id" : null;
                            @endphp
                            @if($embed_url)
                            <iframe width="100%" height="500" src="{{ $embed_url }}" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                            @else
                            <img src="{{ asset('storage/' . $course->banner_image) }}"
                                alt="{{ $course->image_alt_tag ?? $course->course_heading }}" loading="lazy" />

                            @endif
                            @else
                            <img src="{{ asset('storage/' . $course->banner_image) }}"
                                alt="{{ $course->image_alt_tag ?? $course->course_heading }}" loading="lazy" />
                            @endif
                        </div>

                        <div class="news-detail">
                            <div class="post-share-options x">
                                <div
                                    class="post-share-inner d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="tags-box">Share This Course :</div>
                                    <ul class="social-box">
                                        <li>
                                            <a class="fa fa-facebook" target="_blank"
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}">
                                            </a>
                                        </li>
                                        <li>
                                            <a class="fa fa-twitter" target="_blank"
                                                href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($course->course_heading) }}">
                                            </a>
                                        </li>
                                        <li>
                                            <a class="fa fa-linkedin" target="_blank"
                                                href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}">
                                            </a>
                                        </li>
                                        <li>
                                            <a class="fa fa-pinterest-p" target="_blank"
                                                href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ url('storage/' . $course->banner_image) }}&description={{ urlencode($course->course_heading) }}">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <!-- Course Info Tabs -->


                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="content">
                            <ul class="list">
                                <li>
                                    <span class="icon flaticon-price-tag"></span>
                                    Course Fee
                                    <strong>
                                        ₹{{$course->offered_price}}
                                        <del style="color:#999; font-size:14px; margin-left:6px;">
                                            ₹{{$course->course_fee}}
                                        </del>
                                    </strong>
                                </li>
                                <li>
                                    <span class="icon flaticon-agenda"></span>
                                    No. of Classes
                                    <strong>{{$course->num_classes}}</strong>
                                </li>
                                <li>
                                    <span class="icon flaticon-folder"></span>
                                    Topics Covered
                                    <strong>{{$course->num_topics}}</strong>
                                </li>
                                <li>
                                    <span class="icon flaticon-translation"></span>
                                    Language
                                    <strong>
                                        @if($course->language_of_teaching == 'E')
                                        English
                                        @elseif($course->language_of_teaching == 'H')
                                        Hindi
                                        @else
                                        {{$course->language_of_teaching}}
                                        @endif
                                    </strong>
                                </li>
                            </ul>

                            @if(auth()->user() && auth()->user()->email != '' && auth()->user()->type == 'student')
                            @php
                            $user_id = auth()->user()->id;
                            $package_id = $course->id;
                            $type = 'Course';
                            $checkExist = Helper::GetStudentOrder($type, $package_id, $user_id)
                            @endphp
                            @if(!$checkExist)
                            <a class="enroll-now theme-btn"
                                href="{{route('user.process-order', ['type' => 'course', 'id' => $course->id])}}">Enroll
                                Now !</a>
                            @else
                            <a class="enroll-now theme-btn" href="Javascript:void(0);">Already Enrolled!</a>
                            @endif
                            @else
                            <a class="enroll-now theme-btn" href="{{route('student.login')}}">Enroll Now !</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="mobile-fixed-price-bar d-lg-none">
                    <div class="price-section">
                        <span class="price-label">Course Fee</span>
                        <div class="price-value">
                            ₹{{$course->offered_price}}
                            <del>₹{{$course->course_fee}}</del>
                        </div>
                    </div>

                    <div class="enroll-section">
                        @if(auth()->user() && auth()->user()->email != '' && auth()->user()->type == 'student')
                        @php
                        $user_id = auth()->user()->id;
                        $package_id = $course->id;
                        $type = 'Course';
                        $checkExist = Helper::GetStudentOrder($type, $package_id, $user_id)
                        @endphp
                        @if(!$checkExist)
                        <a class="enroll-btn"
                            href="{{route('user.process-order', ['type' => 'course', 'id' => $course->id])}}">
                            Enroll Now
                        </a>
                        @else
                        <a class="enroll-btn disabled" href="Javascript:void(0);">Already Enrolled</a>
                        @endif
                        @else
                        <a class="enroll-btn" href="{{route('student.login')}}">Enroll Now</a>
                        @endif
                    </div>
                </div>

            </div>
            <div class="course-info-tabs">
                <div class="course-tabs tabs-box">
                    <!-- Tab Btns -->
                    <ul class="tab-btns tab-buttons clearfix cvx">
                        <li data-tab="#course-overview" class="tab-btn active-btn">Overview</li>
                        <li data-tab="#course-curriculum" class="tab-btn">Course Detail</li>

                        <li data-tab="#course-reviews" class="tab-btn">Reviews</li>
                    </ul>

                    <!-- Tabs Container -->
                    <div class="tabs-content">

                        <!-- Overview -->
                        <div class="tab active-tab" id="course-overview">
                            <div class="content editor-content">
                                {!! $course->course_overview !!}
                            </div>
                        </div>

                        <!-- Course Detail -->
                        <div class="tab" id="course-curriculum">
                            <div class="content editor-content">
                                {!! $course->detail_content !!}
                            </div>
                        </div>

                        <!-- Reviews -->
                        <div class="tab" id="course-reviews">

                            <div class="content editor-content">

                                <h4 class="mb-3">⭐ Student Reviews</h4>

                                {{-- Reviews List --}}
                                @if($course->reviews->count())

                                @foreach($course->reviews as $review)

                                <div class="border-bottom mb-3 pb-3">

                                    <div class="d-flex justify-content-between">

                                        <strong>{{ $review->student->name ?? 'Student' }}</strong>

                                        <div>
                                            {{ str_repeat('⭐', $review->rating) }}
                                        </div>

                                    </div>

                                    <small class="text-muted">
                                        {{ $review->created_at->format('d M Y') }}
                                    </small>

                                    <p class="mt-1 mb-0">
                                        {{ $review->review }}
                                    </p>

                                </div>

                                @endforeach

                                @else

                                <p class="text-muted">No reviews yet.</p>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

</body>
@endsection