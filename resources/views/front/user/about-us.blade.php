@extends('front.partials.app')
@section('header')
	<title>{{$seo->title?? $about->heading1}}</title>
	<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
    <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    
     <style>
        /* Scoped variables & design tokens */
        :root {
            --font-primary: 'Inter', sans-serif;
            --font-heading: 'Outfit', sans-serif;
            --bg-primary: #f8fafc;
            --bg-dark: #0b0f19;
            --brand-primary: #045279;
            --brand-primary-hover: hsl(224, 76%, 58%);
            --brand-accent: hsl(243, 75%, 59%);
            --brand-accent-glow: rgba(99, 102, 241, 0.15);
            --amber-accent: hsl(38, 92%, 50%);
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-light: rgba(226, 232, 240, 0.8);
            --transition-smooth: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .adhy-about-wrapper {
            font-family: var(--font-primary);
            background-color: var(--bg-primary);
            color: #334155;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            position: relative;
        }

        .adhy-about-wrapper h1,
        .adhy-about-wrapper h2,
        .adhy-about-wrapper h3,
        .adhy-about-wrapper h4,
        .adhy-about-wrapper h5,
        .adhy-about-wrapper h6 {
            font-family: var(--font-heading);
            color: var(--text-dark);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Creative Hero Section */
        .adhy-about-wrapper .about-hero-creative {
            position: relative;
            background: linear-gradient(145deg, #070a13 0%, #151d30 100%) !important;
            padding: 90px 0 130px !important;
            overflow: hidden;
            border-radius: 0 0 50px 50px;
            /* Creative curved bottom */
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Glow lights in hero */
        .adhy-about-wrapper .about-hero-creative .glow-spot {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
            filter: blur(45px);
            border-radius: 50%;
            pointer-events: none;
        }

        .adhy-about-wrapper .about-hero-creative .glow-spot-1 {
            top: -10%;
            right: 5%;
        }

        .adhy-about-wrapper .about-hero-creative .glow-spot-2 {
            bottom: -20%;
            left: -5%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.06) 0%, rgba(255, 255, 255, 0) 70%);
        }

        .adhy-about-wrapper .about-hero-creative h1 {
            font-size: 56px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.04em;
            line-height: 1.15;
            margin-bottom: 18px;
        }

        .adhy-about-wrapper .about-hero-creative .subtitle {
            color: #94a3b8;
            font-size: 19px;
            font-weight: 500;
            max-width: 600px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Breadcrumbs inside Hero */
        .adhy-about-wrapper .creative-breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .adhy-about-wrapper .creative-breadcrumb a {
            color: #a5b4fc !important;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .creative-breadcrumb a:hover {
            color: #ffffff !important;
        }

        .adhy-about-wrapper .creative-breadcrumb .arrow {
            color: rgba(255, 255, 255, 0.3) !important;
            font-size: 11px;
        }

        .adhy-about-wrapper .creative-breadcrumb .current {
            color: #ffffff !important;
        }

        /* Layered Glass Cards Showcase */
        .adhy-about-wrapper .hero-showcase {
            position: relative;
            height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .adhy-about-wrapper .showcase-card {
            position: absolute;
            border-radius: 24px;
            padding: 24px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .showcase-card h1,
        .adhy-about-wrapper .showcase-card h2,
        .adhy-about-wrapper .showcase-card h3,
        .adhy-about-wrapper .showcase-card h4,
        .adhy-about-wrapper .showcase-card h5,
        .adhy-about-wrapper .showcase-card h6 {
            color: #ffffff !important;
        }

        .adhy-about-wrapper .showcase-card-main {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            width: 290px;
            z-index: 2;
            transform: rotate(-3deg) translate(-20px, -10px);
            color: #ffffff;
        }

        .adhy-about-wrapper .showcase-card-main:hover {
            transform: rotate(0deg) scale(1.03) translate(-20px, -10px);
        }

        .adhy-about-wrapper .showcase-card-sub {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            width: 260px;
            z-index: 1;
            transform: rotate(6deg) translate(80px, 30px);
            color: rgba(255, 255, 255, 0.85);
        }

        .adhy-about-wrapper .showcase-card-sub:hover {
            transform: rotate(0deg) scale(1.03) translate(80px, 30px);
        }

        .adhy-about-wrapper .showcase-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 10px;
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .adhy-about-wrapper .showcase-badge-gold {
            background: rgba(245, 158, 11, 0.2);
            color: #fde047;
        }

        /* Glassmorphic Stats Strip (Overlaps Hero bottom) */
        .adhy-about-wrapper .stats-strip-wrapper {
            margin-top: -65px;
            position: relative;
            z-index: 25;
            margin-bottom: 80px;
        }

        .adhy-about-wrapper .stats-dashboard {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 35px 25px;
            box-shadow: 0 20px 45px -15px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .adhy-about-wrapper .stat-card {
            text-align: center;
            padding: 10px 15px;
            border-right: 1px solid rgba(226, 232, 240, 0.8);
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .stat-card:last-child {
            border-right: none;
        }

        .adhy-about-wrapper .stat-card .value {
            font-size: 40px;
            font-weight: 800;
            font-family: var(--font-heading);
            margin-bottom: 4px;
            letter-spacing: -0.03em;
            background: #045279;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .adhy-about-wrapper .stat-card .label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .adhy-about-wrapper .stat-card:hover {
            transform: translateY(-4px);
        }

        /* Section utilities & badges */
        .adhy-about-wrapper .section-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(37, 99, 235, 0.06);
            color: var(--brand-primary);
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 18px;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .adhy-about-wrapper .section-badge-amber {
            background: rgba(245, 158, 11, 0.06);
            color: #d97706;
            border-color: rgba(245, 158, 11, 0.1);
        }

        .adhy-about-wrapper .section-title {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.03em;
            margin-bottom: 20px;
        }

        .adhy-about-wrapper .text-muted-custom {
            color: #475569;
            font-size: 15.5px;
            line-height: 1.7;
        }

        /* Introduction Section */
        .adhy-about-wrapper .intro-section {
            padding: 40px 0 80px;
        }

        .adhy-about-wrapper .intro-image-block {
            position: relative;
            padding: 10px;
        }

        .adhy-about-wrapper .intro-image-block img {
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.15);
            border: 5px solid #ffffff;
            transition: var(--transition-smooth);
            width: 100%;
        }

        .adhy-about-wrapper .intro-image-block:hover img {
            transform: scale(1.02);
        }

        /* Features & Highlight */
        .adhy-about-wrapper .features-section {
            padding: 85px 0;
            background: #ffffff;
        }

        .adhy-about-wrapper .features-card {
            background: #f8fafc;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            padding: 28px;
            height: 100%;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .features-card:hover {
            transform: translateY(-5px);
            background: #ffffff;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.05);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .adhy-about-wrapper .features-card .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(37, 99, 235, 0.06);
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 20px;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .features-card:hover .icon-box {
            background: var(--brand-primary);
            color: #ffffff;
        }

        .adhy-about-wrapper .features-card h4 {
            font-size: 18px;
            font-weight: 750;
            margin-bottom: 10px;
        }

        .adhy-about-wrapper .features-card p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.55;
            margin-bottom: 0;
        }

        /* Vision & Mission Double Cards */
        .adhy-about-wrapper .vision-mission-section {
            background: #f1f5f9;
            padding: 90px 0;
        }

        .adhy-about-wrapper .vm-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 24px;
            padding: 45px;
            height: 100%;
            position: relative;
            z-index: 2;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
            overflow: hidden;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .vm-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
        }

        .adhy-about-wrapper .vm-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 160px;
            height: 160px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.04) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: -1;
        }

        .adhy-about-wrapper .vm-card-amber::before {
            background: radial-gradient(circle, rgba(245, 158, 11, 0.04) 0%, rgba(255, 255, 255, 0) 70%);
        }

        .adhy-about-wrapper .vm-card .large-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 25px;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .vm-card-blue .large-icon {
            background: rgba(37, 99, 235, 0.08);
            color: var(--brand-primary);
        }

        .adhy-about-wrapper .vm-card-blue:hover .large-icon {
            background: var(--brand-primary);
            color: #ffffff;
        }

        .adhy-about-wrapper .vm-card-amber .large-icon {
            background: rgba(245, 158, 11, 0.08);
            color: var(--amber-accent);
        }

        .adhy-about-wrapper .vm-card-amber:hover .large-icon {
            background: var(--amber-accent);
            color: #ffffff;
        }

        .adhy-about-wrapper .vm-card h3 {
            font-size: 26px;
            margin-bottom: 18px;
            font-weight: 800;
        }

        .adhy-about-wrapper .vm-card p {
            font-size: 15px;
            line-height: 1.7;
            color: #475569;
            margin-bottom: 16px;
        }

        .adhy-about-wrapper .vm-card p:last-child {
            margin-bottom: 0;
        }

        /* Why Choose Us & Checklist Layout */
        .adhy-about-wrapper .choose-section {
            padding: 95px 0;
            background: #ffffff;
        }

        .adhy-about-wrapper .strength-card {
            display: flex;
            gap: 15px;
            background: #f8fafc;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 18px;
            padding: 20px 24px;
            align-items: flex-start;
            height: 100%;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .strength-card:hover {
            transform: translateY(-3px);
            border-color: rgba(37, 99, 235, 0.2);
            background: #ffffff;
            box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.04);
        }

        .adhy-about-wrapper .strength-card .chk-icon {
            color: #10b981;
            font-size: 20px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .adhy-about-wrapper .strength-card h5 {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0;
            line-height: 1.45;
        }

        /* Our Commitment Pillars */
        .adhy-about-wrapper .commitment-section {
            padding: 90px 0;
            background: #f8fafc;
        }

        .adhy-about-wrapper .commitment-banner {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 28px;
            padding: 45px;
            color: #ffffff;
            margin-bottom: 50px;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.15);
        }

        .adhy-about-wrapper .commitment-banner h3 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 18px;
        }

        .adhy-about-wrapper .commitment-banner p {
            color: #94a3b8;
            font-size: 15.5px;
            line-height: 1.7;
            margin-bottom: 0;
        }

        .adhy-about-wrapper .pillar-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            height: 100%;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .pillar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.06);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .adhy-about-wrapper .pillar-card .icon-wrap {
            width: 58px;
            height: 58px;
            background: rgba(37, 99, 235, 0.06);
            color: var(--brand-primary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .pillar-card:hover .icon-wrap {
            background: var(--brand-primary);
            color: #ffffff;
        }

        .adhy-about-wrapper .pillar-card h5 {
            font-size: 15px;
            font-weight: 750;
            color: #1e293b;
            margin-bottom: 0;
        }

        /* Join Us CTA */
        .adhy-about-wrapper .join-section {
            padding: 0 0 90px;
            background: #ffffff;
        }

        .adhy-about-wrapper .join-cta-card {
            position: relative;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 32px;
            padding: 70px 50px;
            color: #ffffff;
            overflow: hidden;
            z-index: 1;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .adhy-about-wrapper .join-cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
        }

        .adhy-about-wrapper .join-cta-card h2 {
            color: #ffffff;
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -0.03em;
        }

        .adhy-about-wrapper .join-cta-card p {
            color: #94a3b8;
            font-size: 16px;
            max-width: 700px;
            margin-bottom: 35px;
            line-height: 1.65;
        }

        .adhy-about-wrapper .btn-join-primary {
            background: #045279;
            color: #ffffff !important;
            padding: 15px 30px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.35);
            border: none;
        }

        .adhy-about-wrapper .btn-join-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.45);
            filter: brightness(1.08);
        }

        .adhy-about-wrapper .btn-join-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff !important;
            padding: 15px 30px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: var(--transition-smooth);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .adhy-about-wrapper .btn-join-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .adhy-about-wrapper .team-signature {
            margin-top: 30px;
            font-size: 14px;
            font-weight: 700;
            color: #fbbf24;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* Responsive styling refinements */
        @media (max-width: 991px) {
            .adhy-about-wrapper .about-hero-creative {
                padding: 70px 0 100px !important;
            }

            .adhy-about-wrapper .about-hero-creative h1 {
                font-size: 42px;
            }

            .adhy-about-wrapper .hero-showcase {
                height: 320px;
                margin-top: 30px;
            }

            .adhy-about-wrapper .showcase-card-main {
                width: 250px;
            }

            .adhy-about-wrapper .showcase-card-sub {
                width: 220px;
            }

            .adhy-about-wrapper .stat-card {
                border-right: none;
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
                padding-bottom: 15px;
            }

            .adhy-about-wrapper .stat-card:last-child {
                border-bottom: none;
            }

            .adhy-about-wrapper .section-title {
                font-size: 30px;
            }

            .adhy-about-wrapper .vm-card {
                padding: 30px;
            }

            .adhy-about-wrapper .vm-card h3 {
                font-size: 22px;
            }

            .adhy-about-wrapper .join-cta-card {
                padding: 45px 30px;
            }

            .adhy-about-wrapper .join-cta-card h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 576px) {
            .adhy-about-wrapper .about-hero-creative h1 {
                font-size: 32px;
            }

            .adhy-about-wrapper .about-hero-creative .subtitle {
                font-size: 16px;
            }

            .adhy-about-wrapper .hero-showcase {
                display: none;
                /* Hide visual collage on mobile screen for cleaner structure */
            }

            .adhy-about-wrapper .btn-join-primary,
            .adhy-about-wrapper .btn-join-secondary {
                width: 100%;
                justify-content: center;
            }
        }

        .adhy-about-wrapper .hero-showcase-bg-img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px;
            opacity: 0.15;
            filter: grayscale(100%) contrast(120%);
            pointer-events: none;
            z-index: 0;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .hero-showcase:hover .hero-showcase-bg-img {
            opacity: 0.25;
            transform: scale(1.02);
        }

        .adhy-about-wrapper .vm-card-img-wrap {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            height: 200px;
            margin-bottom: 25px;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .adhy-about-wrapper .vm-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-smooth);
        }

        .adhy-about-wrapper .vm-card:hover .vm-card-img-wrap img {
            transform: scale(1.05);
        }
    </style>
@endsection
@section('content')


<body class="hidden-bar-wrapper">
	<!-- Page Title -->
	<section class="page-title">
		<div class="auto-container">
			<h2>Adhyayanam IAS</h2>
			<ul class="bread-crumb clearfix">
				<li><a href="{{url('/')}}">Home</a></li>
				<li>About us</li>
			</ul>
		</div>
	</section>
	<!-- End Page Title -->

	<!-- Choose Section Two -->
	<section class="choose-section-two">
		<div class="icon-one" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="icon-two" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="icon-three" style="background-image: url(images/icons/icon-6.png)"></div>
		<div class="auto-container">
			<div class="row clearfix">
				<div class="col-12">
					@php
    $youtubeUrl = $about->youtube_url;

    preg_match(
        '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/',
        $youtubeUrl,
        $matches
    );

    $videoId = $matches[1] ?? '';
@endphp

@if($videoId)
    <iframe
        width="100%"
        height="500"
        src="https://www.youtube.com/embed/{{ $videoId }}"
        title="YouTube video player"
        frameborder="0"
        allowfullscreen>
    </iframe>
@endif
				</div>

				<!-- Content Column -->
				<div class="col-12">
					<div class="contents mt-40">
						
						{!!$about->description1!!}
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Choose Section Two -->

	<!-- Featured Section / Style Two -->
	<section class="featured-section style-two">
		<div class="auto-container">
			<div class="inner-container">
				<div class="pattern-layer" style="background-image: url(images/background/pattern-5.png)"></div>
				<div class="row clearfix">

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="icon flaticon-book"></div>
							<h4><a href="course-detail.html">100% Graduate course</a></h4>
							<div class="text">100+ Video Course inside</div>
						</div>
					</div>

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="icon flaticon-identification"></div>
							<h4><a href="course-detail.html">Learn with experts</a></h4>
							<div class="text">Learn our course with Expert</div>
						</div>
					</div>

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="icon flaticon-certificate"></div>
							<h4><a href="course-detail.html">Online degrees</a></h4>
							<div class="text">Get Online Degree certificate</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- End Featured Section / Style Two -->

	<!-- Counter Boxed -->
	<section class="counter-section">
		<div class="auto-container">
			<div class="inner-container">
				<div class="row clearfix">

					<!-- Counter Column -->
					<div class="counter-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon osdx"><img src="images/stu.png" alt="" /></span>
							<div class="counter"><span class="odometer" data-count="415"></span> +</div>
							<div class="counter-text">Students Enrolled</div>
						</div>
					</div>

					<!-- Counter Column -->
					<div class="counter-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon osdx"><img src="images/class-c.png" alt="" /></span>
							<div class="counter"><span class="odometer" data-count="5"></span> k+</div>
							<div class="counter-text">Class Completed</div>
						</div>
					</div>

					<!-- Counter Column -->
					<div class="counter-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon osdx"><img src="images/skins.png" alt="" /></span>
							<div class="counter"><span class="odometer" data-count="20"></span> +</div>
							<div class="counter-text">Skilled Instructors</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- End Counter Boxed -->


	<!-- Join Section -->
	<section class="join-section">
		<div class="icon-one" style="background-image: url(images/icons/icon-1.png)"></div>
		<div class="icon-two" style="background-image: url(images/icons/icon-2.png)"></div>
		<div class="auto-container">
			<div class="row clearfix">

				<!-- Image Column -->
				<div class="image-column col-lg-6 col-md-12 col-sm-12">
					<div class="inner-column">
						<div class="pattern-layer" style="background-image: url(images/background/pattern-7.png)"></div>
						<div class="pattern-layer-two" style="background-image: url(images/background/pattern-8.png)"></div>
						<div class="image titlt" data-tilt data-tilt-max="4">
							<img src="images/resource/join.jpg" alt="" />
						</div>
					</div>
				</div>

				<!-- Content Column -->
				<div class="content-column col-lg-6 col-md-12 col-sm-12">
					<div class="inner-column">
						<!-- Sec Title -->
						<div class="sec-title">
							<div class="title">Join us</div>
							<h2>Come join us as we <br> spread knowledge.</h2>
							<div class="text">Create online courses and coaching services.t is a long established fact that a reader
								will be distracted by the readable content of a page when looking at its layout. </div>
						</div>
						<div class="button-box">
							<a href="./career.html" class="theme-btn btn-style-three"><span class="txt">Teaching Now</span></a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Join Section -->

	<!-- Testimonial Section Two -->
	<section class="testimonial-section-two">
		<div class="icon-layer-one" style="background-image: url(images/icons/icon-7.png)"></div>
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title">
				<!-- <div class="title">Student Review</div> -->
				<h2>Our Students <br> Review</h2>
			</div>
			<div class="two-item-carousel owl-carousel owl-theme">

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-7.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								CA Student
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-8.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								CA Student
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-7.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								CA Student
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-8.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								Online Lecturer and businees
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-7.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								Online Lecturer and businees
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Testimonial Block -->
				<div class="testimonial-block">
					<div class="inner-box">
						<div class="text">Very good training, help me to understand the basics. The training contains a lot of
							pract information lorem you need to be the best runway looks from new york lorem </div>
						<!-- Author Box -->
						<div class="author-box">
							<div class="box-inner">
								<div class="author-image">
									<img src="images/resource/author-8.jpg" alt="" />
								</div>
								<strong>Prashant Yadav</strong>
								Online Lecturer and businees
								<span class="quote-icon"><img src="images/icons/quote-icon.png" alt="" /></span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Testimonial Section Two -->
	<section class="faq-section osd">
		<div class="auto-container">
			<!-- Title Box -->
			<div class="title-box">
				<h3>FAQ's</h3>
			</div>
			<div class="inner-container">

				<!-- Accordion Box -->
				<ul class="accordion-box">

					@foreach($faqs as $index => $faq)
					<li class="accordion block">
						<div class="acc-btn {{ $index === 0 ? 'active' : '' }}">
							<div class="icon-outer"><span class="icon icon-plus flaticon-plus-sign"></span> <span
									class="icon icon-minus flaticon-minus-1"></span></div>{{$faq->question}}</div>
						<div class="acc-content {{ $index === 0 ? 'current' : '' }}">
							<div class="content">
								<div class="text">{{$faq->answer}}</div>
							</div>
						</div>
					</li>
					@endforeach

				</ul>

			</div>
		</div>
	</section>
	
	<div class="hidden-bar-wrapper">
    <!-- Scoped About Page Wrapper -->
    <div class="adhy-about-wrapper">

        <!-- Creative Hero Section (Curved Background & Glow) -->
        <section class="about-hero-creative">
            <div class="glow-spot glow-spot-1"></div>
            <div class="glow-spot glow-spot-2"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-left">
                        <div class="creative-breadcrumb">
                            <a href="/">Home</a>
                            <span class="sep"><i class="fa-solid fa-angle-right arrow"></i></span>
                            <span class="current">About Us</span>
                        </div>
                        <h1>About Adhyayanam IAS</h1>
                        <div class="subtitle">Shaping future leaders through academic excellence, research-driven
                            curriculum, and holistic mentorship.</div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero-showcase">
                            <!-- Background Image under floating cards -->
                            <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=800"
                                alt="Students mentoring background" class="hero-showcase-bg-img">

                            <!-- Showcase Card 1 (Main) -->
                            <div class="showcase-card showcase-card-main">
                                <span class="showcase-badge">Premium focus</span>
                                <h5 class="fw-bold mb-2">Elite Mentorship</h5>
                                <p class="small text-white-100 mb-0">Learn directly from retired bureaucrats and domain
                                    experts.</p>
                            </div>
                            <!-- Showcase Card 2 (Sub) -->
                            <div class="showcase-card showcase-card-sub">
                                <span class="showcase-badge showcase-badge-gold">Selection Rate</span>
                                <h5 class="fw-bold mb-2">95% Success Rate</h5>
                                <p class="small text-white-100 mb-0">Continuous test tracking with state-of-the-art
                                    results.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Strip (Floating Overlapping the Hero) -->
        <section class="stats-strip-wrapper">
            <div class="container">
                <div class="stats-dashboard">
                    <div class="row g-4 justify-content-center">
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="value">415+</div>
                                <div class="label">Students Enrolled</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="value">5,000+</div>
                                <div class="label">Classes Completed</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="value">20+</div>
                                <div class="label">Expert Faculty</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="value">95%</div>
                                <div class="label">Success Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Introduction Section -->
        <section class="intro-section">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="mb-4 text-left">
                            <span class="section-badge">Who We Are</span>
                            <h2 class="section-title">Empowering Aspirants, <br>Transforming Lives</h2>
                        </div>
                        <p class="text-muted-custom mb-3 text-left">
                            <strong>Adhyayanam IAS</strong> is one of India's leading research and training institutes
                            dedicated to empowering aspirants preparing for Civil Services, Judicial Services, State
                            PCS, and various competitive examinations across the country.
                        </p>
                        <p class="text-muted-custom mb-4 text-left">
                            Our mission is to transform aspirations into achievements through an integrated learning
                            approach that combines expert guidance, innovative teaching methods, technology-driven
                            learning, and personalized mentorship.
                        </p>
                    </div>

                    <div class="col-lg-6">
                        <div class="intro-image-block">
                            <!-- Premium Educational Image -->
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800"
                                alt="Students learning together in Adhyayanam IAS">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features & Highlights (Cards on Left, Image on Right) -->
        <section class="features-section">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <!-- Cards Grid (Left side) -->
                    <div class="col-lg-7">
                        <div class="mb-5 text-left">
                            <span class="section-badge section-badge-amber">Academy Highlights</span>
                            <h2 class="section-title">Designed For Elite Academic Performance</h2>
                            <p class="text-muted-custom">Explore our comprehensive training programs and support
                                features built to help you excel.</p>
                        </div>

                        <div class="row g-4">
                            <!-- Card 1 -->
                            <div class="col-sm-6 text-left">
                                <div class="features-card">
                                    <div class="icon-box"><i class="fa-solid fa-landmark"></i></div>
                                    <h4>UPSC Civil Services</h4>
                                    <p>Complete preparation for Prelims, Mains, and Interview stages with current
                                        affairs.</p>
                                </div>
                            </div>
                            <!-- Card 2 -->
                            <div class="col-sm-6 text-left">
                                <div class="features-card">
                                    <div class="icon-box"><i class="fa-solid fa-map"></i></div>
                                    <h4>State PCS Exams</h4>
                                    <p>State Public Service Commission papers with specialized localized course modules.
                                    </p>
                                </div>
                            </div>
                            <!-- Card 3 -->
                            <div class="col-sm-6 text-left">
                                <div class="features-card">
                                    <div class="icon-box"><i class="fa-solid fa-scale-balanced"></i></div>
                                    <h4>Judicial Services</h4>
                                    <p>Focused coaching covering local procedural law papers and extensive mock
                                        sessions.</p>
                                </div>
                            </div>
                            <!-- Card 4 -->
                            <div class="col-sm-6 text-left">
                                <div class="features-card">
                                    <div class="icon-box"><i class="fa-solid fa-school"></i></div>
                                    <h4>CUET Entrance</h4>
                                    <p>Structured coaching to help you get selected in prestigious Central Universities.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Featured Image) -->
                    <div class="col-lg-5">
                        <div class="intro-image-block">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800">

                        </div>
                        <div class="intro-image-block">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section (2 cards Left and Right) -->
        <section class="vision-mission-section">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-badge">Our Directives</span>
                    <h2 class="section-title">Vision & Mission</h2>
                </div>
                <div class="row g-4 text-left">
                    <!-- Vision Card -->
                    <div class="col-lg-6">
                        <div class="vm-card vm-card-blue">
                            <div class="vm-card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=600"
                                    alt="Our Vision and Commitment">
                            </div>
                            <div class="large-icon">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                            <h3>Our Vision & Commitment</h3>
                            <p>
                                Our vision is to nurture knowledgeable, ethical, and visionary leaders who contribute
                                meaningfully to society and public administration.
                            </p>
                            <p>
                                Through continuous research, innovative teaching methodologies, and exam-oriented
                                preparation strategies, we strive to provide students with the most relevant and
                                effective learning experience.
                            </p>
                            <p>
                                From your first day of preparation to your final selection, Adhyayanam IAS remains your
                                trusted academic partner.
                            </p>
                        </div>
                    </div>

                    <!-- Mission Card -->
                    <div class="col-lg-6">
                        <div class="vm-card vm-card-amber">
                            <div class="vm-card-img-wrap">
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600"
                                    alt="Our Mission and Approach">
                            </div>
                            <div class="large-icon">
                                <i class="fa-solid fa-bullseye"></i>
                            </div>
                            <h3>Our Mission & Approach</h3>
                            <p>
                                We do not simply prepare students for examinations; we help them build confidence,
                                analytical thinking, leadership qualities, and decision-making skills that are essential
                                for public service and professional success.
                            </p>
                            <p>
                                We continuously research and develop effective learning resources that align with
                                evolving examination patterns, creating a student-centric ecosystem designed to help
                                candidates perform at their highest potential.
                            </p>
                            <p>
                                Join Adhyayanam IAS and take the first step towards a successful career in Civil
                                Services, Judicial Services, and Competitive Examinations.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Strengths List Section -->
        <section class="choose-section">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5 text-left">
                        <div class="mb-4">
                            <span class="section-badge section-badge-amber">Why Choose Us</span>
                            <h2 class="section-title">A Student-Centric Learning Ecosystem</h2>
                        </div>
                        <p class="text-muted-custom mb-4">
                            At Adhyayanam IAS, we believe every aspirant deserves the right guidance, resources, and
                            support to achieve success. Our ecosystem is built to maximize potential.
                        </p>

                        <!-- Mini Quote card -->
                        <div class="p-4 bg-light border-start border-warning border-4 rounded-3 text-left">
                            <p class="font-italic text-dark mb-0" style="font-size: 14.5px;">
                                "We do not simply prepare students for examinations; we help them build confidence,
                                analytical thinking, leadership qualities, and decision-making skills that are essential
                                for public service and professional success."
                            </p>
                        </div>

                        <!-- Visual representation of planning/success -->
                        <div class="mt-4 text-left">
                            <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=600"
                                class="img-fluid rounded-4 shadow-sm border" alt="Planning and study organization"
                                style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <h4 class="mb-4 text-dark font-weight-bold text-left">Our Key Strengths</h4>
                        <div class="row g-3 text-left">
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>High-quality Online & Offline Courses</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>Comprehensive Materials & Notes</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>Regular Performance Analysis</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>Personal Mentorship & Guidance</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>Flexible Adaptive Environment</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>Daily Current Affairs PDFs & Videos</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>The Hindu & Indian Express Editorials</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="strength-card">
                                    <i class="fa-solid fa-circle-check chk-icon"></i>
                                    <h5>Daily Quizzes & Answer Writing</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Commitment Section -->
        <section class="commitment-section">
            <div class="container">
                <div class="commitment-banner text-left">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <h3>Our Commitment</h3>
                            <p class="mb-3">
                                We continuously research and develop effective learning resources that align with
                                evolving examination patterns. Our goal is not only to help students clear examinations
                                but also to build confidence, analytical thinking, and leadership qualities essential
                                for public service careers.
                            </p>
                            <p>
                                Whether you are preparing for UPSC, State PCS, Judicial Services, or other competitive
                                examinations, Adhyayanam IAS provides the guidance, strategy, and support needed to
                                achieve your goals.
                            </p>
                        </div>
                        <div class="col-lg-4 text-center text-lg-end">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=600"
                                class="img-fluid rounded-4 border border-white-10" alt="Dedication and support"
                                style="max-height: 180px; object-fit: cover; opacity: 0.85; filter: contrast(110%);">
                        </div>
                    </div>
                </div>

                <!-- 4 Core Pillars Row -->
                <div class="row g-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="pillar-card">
                            <div class="icon-wrap"><i class="fa-solid fa-bullseye"></i></div>
                            <h5>100% Student Focused Approach</h5>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="pillar-card">
                            <div class="icon-wrap"><i class="fa-solid fa-headset"></i></div>
                            <h5>24×7 Academic Support</h5>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="pillar-card">
                            <div class="icon-wrap"><i class="fa-solid fa-globe"></i></div>
                            <h5>Online + Offline Ecosystem</h5>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="pillar-card">
                            <div class="icon-wrap"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                            <h5>Research Based Preparation</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Join Us CTA Section -->
        <section class="join-section">
            <div class="container">
                <div class="join-cta-card text-left">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2>Join the Adhyayanam IAS Family</h2>
                            <p>
                                Take the first step toward a successful career in public service. Let us guide you on a
                                transformative learning journey that goes beyond traditional coaching methods and
                                prepares you for excellence.
                            </p>
                            <p class="opacity-75 mb-4" style="font-size: 14.5px;">
                                Connect with our academic counselors today to find the right program for your goals,
                                access premium sample materials, and schedule a free mentorship session.
                            </p>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="/" class="btn-join-primary">Explore Courses <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                <a href="Javascript:void(0);" class="btn-join-secondary">Talk to Counselor</a>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=600"
                                class="img-fluid rounded-4 mb-3" alt="Students celebrating success"
                                style="max-height: 140px; width: 100%; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.1); opacity: 0.9;">
                            <div class="team-signature">
                                <div>Your Success Begins Here.</div>
                                <div class="mt-2 text-white opacity-75">Team Adhyayanam IAS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    </div>

</body>
@endsection