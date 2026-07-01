@extends('front.partials.app')
@section('header')
	<title>Blog and Articles | {{$blog->heading}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom Modern Styles Scoped to Parent Class */
        :root {
            --blog-primary: #6366f1; /* Indigo */
            --blog-secondary: #ec4899; /* Pink */
            --blog-bg: #f8fafc;
            --blog-card: #ffffff;
            --blog-text-main: #0f172a;
            --blog-text-muted: #64748b;
        }

        .blog-detail-page-wrapper {
            font-family: 'Inter', sans-serif;
            background-color: var(--blog-bg);
            color: var(--blog-text-main);
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Hero Banner */
        .blog-detail-page-wrapper .blog-hero {
            position: relative;
            background: linear-gradient(135deg, var(--blog-primary), var(--blog-secondary));
            padding: 120px 0 80px;
            text-align: center;
            color: #fff;
            overflow: hidden;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.15);
            margin-bottom: 60px;
        }

        .blog-detail-page-wrapper .blog-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 10%, transparent 20%);
            background-size: 30px 30px;
            animation: moveBg 30s linear infinite;
            z-index: 1;
        }

        @keyframes moveBg {
            0% { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        .blog-detail-page-wrapper .blog-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .blog-detail-page-wrapper .blog-hero h2 {
            font-weight: 800;
            font-size: 3.5rem;
            margin-bottom: 25px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.15);
            line-height: 1.2;
            color: #ffffff;
        }
        
        .blog-detail-page-wrapper .blog-breadcrumb {
            list-style: none;
            padding: 0;
            display: inline-flex;
            gap: 12px;
            background: rgba(255, 255, 255, 0.15);
            padding: 12px 25px;
            border-radius: 30px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            align-items: center;
        }

        .blog-detail-page-wrapper .blog-breadcrumb li {
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            color: #ffffff;
        }

        .blog-detail-page-wrapper .blog-breadcrumb li a {
            color: #ffffff;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .blog-detail-page-wrapper .blog-breadcrumb li a:hover {
            opacity: 0.8;
            color: #ffffff;
        }

        .blog-detail-page-wrapper .blog-breadcrumb li:not(:last-child)::after {
            content: '\f105';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-left: 12px;
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Main Content Container */
        .blog-detail-page-wrapper .blog-main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .blog-detail-page-wrapper .blog-content-card {
            background: var(--blog-card);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.04);
            padding: 40px;
            margin-bottom: 40px;
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        
        .blog-detail-page-wrapper .blog-content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.08);
        }

        .blog-detail-page-wrapper .blog-featured-image {
            width: 100%;
            height: auto;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-bottom: 35px;
            object-fit: cover;
            max-height: 550px;
        }

        .blog-detail-page-wrapper .blog-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .blog-detail-page-wrapper .blog-tag {
            background: linear-gradient(135deg, var(--blog-secondary), #f43f5e);
            color: #fff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);
            display: inline-block;
        }

        .blog-detail-page-wrapper .blog-info {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            color: var(--blog-text-muted);
            font-size: 1rem;
            font-weight: 500;
        }

        .blog-detail-page-wrapper .blog-info li {
            display: flex;
            align-items: center;
        }

        .blog-detail-page-wrapper .blog-info li i {
            margin-right: 8px;
            color: var(--blog-primary);
            font-size: 1.1rem;
        }

        .blog-detail-page-wrapper .blog-title {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 30px;
            line-height: 1.25;
            background: -webkit-linear-gradient(45deg, var(--blog-text-main), var(--blog-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .blog-detail-page-wrapper .blog-description {
            font-size: 1.15rem;
            line-height: 1.9;
            color: #334155;
            margin-bottom: 45px;
        }

        .blog-detail-page-wrapper .blog-description p {
            margin-bottom: 20px;
        }
        
        .blog-detail-page-wrapper .blog-description img {
            max-width: 100%;
            border-radius: 12px;
            height: auto;
        }

        /* Share Options */
        .blog-detail-page-wrapper .blog-share {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 35px;
            border-top: 2px dashed #e2e8f0;
            flex-wrap: wrap;
            gap: 20px;
        }

        .blog-detail-page-wrapper .share-label {
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--blog-text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .blog-detail-page-wrapper .share-label i {
            color: var(--blog-primary);
        }

        .blog-detail-page-wrapper .social-icons {
            display: flex;
            gap: 12px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .blog-detail-page-wrapper .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f1f5f9;
            color: var(--blog-text-main);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            font-size: 1.1rem;
        }

        .blog-detail-page-wrapper .social-icons a.facebook:hover { background: #1877F2; color: #fff; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(24, 119, 242, 0.3); }
        .blog-detail-page-wrapper .social-icons a.twitter:hover { background: #1DA1F2; color: #fff; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(29, 161, 242, 0.3); }
        .blog-detail-page-wrapper .social-icons a.linkedin:hover { background: #0A66C2; color: #fff; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(10, 102, 194, 0.3); }
        .blog-detail-page-wrapper .social-icons a.pinterest:hover { background: #E60023; color: #fff; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(230, 0, 35, 0.3); }

        /* More Posts Pagination */
        .blog-detail-page-wrapper .post-pagination {
            display: flex;
            justify-content: space-between;
            gap: 25px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .blog-detail-page-wrapper .post-nav-card {
            flex: 1;
            min-width: 280px;
            background: var(--blog-card);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.4s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.02);
            z-index: 1;
        }
        
        .blog-detail-page-wrapper .post-nav-card.next {
            flex-direction: row-reverse;
            text-align: right;
        }

        .blog-detail-page-wrapper .post-nav-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05));
            z-index: -1;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .blog-detail-page-wrapper .post-nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.2);
        }
        
        .blog-detail-page-wrapper .post-nav-card:hover::before {
            opacity: 1;
        }

        .blog-detail-page-wrapper .post-nav-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e0e7ff;
            color: var(--blog-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .blog-detail-page-wrapper .post-nav-card:hover .post-nav-icon {
            background: var(--blog-primary);
            color: #fff;
            transform: scale(1.1);
        }

        .blog-detail-page-wrapper .post-nav-content {
            flex: 1;
        }

        .blog-detail-page-wrapper .post-nav-content h6 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--blog-text-main);
            line-height: 1.5;
            transition: color 0.3s ease;
        }

        .blog-detail-page-wrapper .post-nav-card:hover .post-nav-content h6 {
            color: var(--blog-primary);
        }

        .blog-detail-page-wrapper .post-nav-content span {
            font-size: 0.85rem;
            color: var(--blog-text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 800;
            display: block;
            margin-bottom: 8px;
        }

        /* Sidebar Styles */
        .blog-detail-page-wrapper .blog-sidebar {
            position: sticky;
            top: 100px;
        }

        .blog-detail-page-wrapper .blog-sidebar .widget {
            background: var(--blog-card);
            border-radius: 24px;
            padding: 35px 30px;
            margin-bottom: 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog-detail-page-wrapper .blog-sidebar .widget:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        }

        .blog-detail-page-wrapper .widget-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
            color: var(--blog-text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .blog-detail-page-wrapper .widget-title i {
            color: var(--blog-secondary);
        }

        .blog-detail-page-wrapper .widget-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, var(--blog-primary), var(--blog-secondary));
            border-radius: 4px;
        }

        /* Search Box */
        .blog-detail-page-wrapper .search-form {
            position: relative;
        }

        .blog-detail-page-wrapper .search-form input {
            width: 100%;
            padding: 16px 25px;
            border: 2px solid #e2e8f0;
            border-radius: 30px;
            outline: none;
            transition: all 0.3s ease;
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: var(--blog-text-main);
        }

        .blog-detail-page-wrapper .search-form input:focus {
            border-color: var(--blog-primary);
            background: #fff;
            box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.1);
        }

        .blog-detail-page-wrapper .search-form button {
            position: absolute;
            right: 6px;
            top: 6px;
            bottom: 6px;
            width: 44px;
            border: none;
            border-radius: 50%;
            background: var(--blog-primary);
            color: #fff;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .blog-detail-page-wrapper .search-form button:hover {
            background: var(--blog-secondary);
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.4);
        }

        /* Recent Posts */
        .blog-detail-page-wrapper .recent-post-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .blog-detail-page-wrapper .recent-post-item {
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 16px;
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .blog-detail-page-wrapper .recent-post-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            border-color: rgba(99, 102, 241, 0.1);
        }

        .blog-detail-page-wrapper .recent-post-thumb {
            width: 80px;
            height: 80px;
            border-radius: 14px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            position: relative;
        }

        .blog-detail-page-wrapper .recent-post-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .blog-detail-page-wrapper .recent-post-item:hover .recent-post-thumb img {
            transform: scale(1.15);
        }

        .blog-detail-page-wrapper .recent-post-info {
            flex: 1;
        }

        .blog-detail-page-wrapper .recent-post-info .date {
            font-size: 0.8rem;
            color: var(--blog-text-muted);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .blog-detail-page-wrapper .recent-post-info .date i {
            color: var(--blog-secondary);
        }

        .blog-detail-page-wrapper .recent-post-info h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .blog-detail-page-wrapper .recent-post-info h6 a {
            color: var(--blog-text-main);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .blog-detail-page-wrapper .recent-post-item:hover .recent-post-info h6 a {
            color: var(--blog-primary);
        }

        /* Tags Widget */
        .blog-detail-page-wrapper .tags-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .blog-detail-page-wrapper .tags-wrapper a {
            padding: 8px 18px;
            background: #f1f5f9;
            color: #475569;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .blog-detail-page-wrapper .tags-wrapper a:hover {
            background: linear-gradient(135deg, var(--blog-primary), var(--blog-secondary));
            color: #fff;
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .blog-detail-page-wrapper .blog-sidebar {
                margin-top: 40px;
                position: relative;
                top: 0;
            }
        }

        @media (max-width: 768px) {
            .blog-detail-page-wrapper .blog-title { font-size: 2.2rem; }
            .blog-detail-page-wrapper .blog-hero h2 { font-size: 2.5rem; }
            .blog-detail-page-wrapper .blog-hero { padding: 80px 0 60px; }
            .blog-detail-page-wrapper .blog-content-card { padding: 25px; }
            .blog-detail-page-wrapper .post-pagination { flex-direction: column; }
            .blog-detail-page-wrapper .post-nav-card { min-width: 100%; }
        }
        
        @media (max-width: 480px) {
            .blog-detail-page-wrapper .blog-title { font-size: 1.8rem; }
            .blog-detail-page-wrapper .blog-hero h2 { font-size: 2rem; }
            .blog-detail-page-wrapper .blog-meta { gap: 15px; }
            .blog-detail-page-wrapper .blog-info { flex-direction: column; gap: 10px; }
            .blog-detail-page-wrapper .blog-share { flex-direction: column; align-items: flex-start; }
        }
    </style>
@endsection
@section('content')
<body>
<div class="blog-detail-page-wrapper">
  <!-- Hero Section -->
  <section class="blog-hero">
    <div class="blog-hero-content">
      <h2>{{ Illuminate\Support\Str::limit($blog->heading, 40) }}</h2>
      <ul class="blog-breadcrumb">
        <li><a href="{{url('/')}}"><i class="fas fa-home me-1"></i> Home</a></li>
        @if($blog->type)
        <li><a href="javascript:void(0);">{{$blog->type}}</a></li>
        @endif
        <li>Blog Details</li>
      </ul>
    </div>
  </section>

  <div class="blog-main-container">
    <div class="row">
      <!-- Content Side -->
      <div class="col-lg-8 col-md-12 col-sm-12">
        <article class="blog-content-card">
          <img src="{{url('storage/'.$blog->image)}}" alt="{{$blog->heading}}" class="blog-featured-image" />
          
          <div class="blog-meta">
            <div class="blog-tag">{{$blog->type}}</div>
            <ul class="blog-info">
              <li><i class="fas fa-user-circle"></i> By {{$blog->user->name}}</li>
              <li><i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</li>
            </ul>
          </div>
          
          <h1 class="blog-title">{{$blog->heading}}</h1>
          
          <div class="blog-description">
            {!!$blog->description!!}
          </div>
          
          <!-- Share Options -->
          <div class="blog-share">
            <div class="share-label"><i class="fas fa-share-alt"></i> Share this article</div>
            <ul class="social-icons">
              <li><a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="#" class="twitter"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
              <li><a href="#" class="pinterest"><i class="fab fa-pinterest-p"></i></a></li>
            </ul>
          </div>
        </article>

        <!-- More Posts Navigation -->
        <div class="post-pagination mb-5">
            @if($prevBlog)
                <a href="{{ route('blog.details', $prevBlog->id) }}" class="post-nav-card prev">
                    <div class="post-nav-icon"><i class="fas fa-arrow-left"></i></div>
                    <div class="post-nav-content">
                        <span>Previous Post</span>
                        <h6>{!! nl2br(e(Illuminate\Support\Str::limit(wordwrap($prevBlog->heading, 25, "\n", true), 50))) !!}</h6>
                    </div>
                </a>
            @endif

            @if($nextBlog)
                <a href="{{ route('blog.details', $nextBlog->id) }}" class="post-nav-card next">
                    <div class="post-nav-content">
                        <span>Next Post</span>
                        <h6>{!! nl2br(e(Illuminate\Support\Str::limit(wordwrap($nextBlog->heading, 20, "\n", true), 45))) !!}</h6>
                    </div>
                    <div class="post-nav-icon"><i class="fas fa-arrow-right"></i></div>
                </a>
            @endif
        </div>
      </div>

      <!-- Sidebar Side -->
      <div class="col-lg-4 col-md-12 col-sm-12">
        <aside class="blog-sidebar">

          <!-- Search Widget -->
          <div class="widget search-widget">
            <h5 class="widget-title"><i class="fas fa-search"></i> Search</h5>
            <form method="post" action="#" class="search-form">
              <input type="search" name="search-field" placeholder="Search articles..." required>
              <button type="submit"><i class="fas fa-search"></i></button>
            </form>
          </div>

          <!-- Recent Post Widget -->
          <div class="widget recent-post-widget">
            <h5 class="widget-title"><i class="fas fa-fire"></i> Recent Posts</h5>
            <div class="recent-post-list">
                @foreach($relatedBlogs as $data)
                <div class="recent-post-item">
                  <div class="recent-post-thumb">
                    <a href="{{route('blog.details',$data->id)}}">
                        <img src="{{url('storage/'.$data->image)}}" alt="">
                    </a>
                  </div>
                  <div class="recent-post-info">
                    <span class="date"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</span>
                    <h6><a href="{{route('blog.details',$data->id)}}">{{ Illuminate\Support\Str::limit($data->heading, 12) }}</a></h6>
                  </div>
                </div>
                @endforeach
            </div>
          </div>

          <!-- Tags Widget -->
          <div class="widget tags-widget">
            <h5 class="widget-title"><i class="fas fa-tags"></i> Popular Tags</h5>
            <div class="tags-wrapper">
              <a href="#">Blog</a>
              <a href="#">Education</a>
              <a href="#">Teach</a>
              <a href="#">Business</a>
              <a href="#">Learning</a>
              <a href="#">Science</a>
              <a href="#">Design</a>
              <a href="#">Marketing</a>
              <a href="#">Book</a>
            </div>
          </div>

        </aside>
      </div>

    </div>
  </div>
</div>
</body>
@endsection