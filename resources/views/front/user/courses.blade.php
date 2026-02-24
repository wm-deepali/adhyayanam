@extends('front.partials.app')
{{-- @section('header')
<title>{{$seo->title ?? $cookies->heading1}}</title>
<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
<meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
<link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .page-banner {
 padding: 35px 0 35px;                    
  background: linear-gradient(135deg, #f0f4ff 0%, #e6f5f5 100%);  /* light pastel blue-green */
  /* Alternative pastel options: 
     #fff0f5 → #ffe4e1 (soft pink)
     #f0fff4 → #e6fffa (mint)
     #f3e8ff → #e0d7ff (light purple)
  */
  position: relative;
  overflow: hidden;
}

.page-banner::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 30% 70%, rgba(255,255,255,0.4) 0%, transparent 60%);
  pointer-events: none;
}

.auto-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

.banner-content {
  max-width: 780px;
  margin: 0 auto;
}

.banner-heading {
  font-size: 3.2rem;
  font-weight: 700;
  color: #1a2a44;               /* dark slate for contrast */
  margin-bottom: 1.2rem;
  line-height: 1.1;
}

.banner-subtitle {
  font-size: 1.18rem;
  color: #4a5568;               /* softer gray */
  line-height: 1.6;
  margin-bottom: 2rem;
}

.bread-crumb {
  margin-top: 1.5rem;
  font-size: 0.95rem;
  color: #718096;
}

.bread-crumb li {
  display: inline-block;
}

.bread-crumb li + li::before {
  content: "›";
  margin: 0 8px;
  color: #a0aec0;
}

.bread-crumb a {
  color: #4a5568;
  text-decoration: none;
}

.bread-crumb a:hover {
  color: #3182ce;
  text-decoration: underline;
}

/* Responsive adjustments */
@media (max-width: 767px) {
  .page-banner {
    padding: 70px 0 50px;
  }
  
  .banner-heading {
    font-size: 2.6rem;
  }
  
  .banner-subtitle {
    font-size: 1.05rem;
  }
}

</style>
<style>
  :root {
    --primary: #4361ee;
    --primary-light: #e0e7ff;
    --pastel: #f5faff;
    --gray: #f8f9fa;
    --text: #1e293b;
    --muted: #64748b;
    --radius: 0.9rem;
    --shadow: 0 6px 20px rgba(0,0,0,0.08);
  }

  .sidebar-categories {
    background: white;
    border-radius: var(--radius);
  }

  .category-btn {
    background: var(--pastel);
    color: var(--primary);
    border: none;
    transition: all 0.22s;
  }

  .category-btn:hover,
  .category-btn.active {
    background: var(--primary);
    color: white;
  }

  .sub-btn {
    color: var(--muted);
    transition: all 0.2s;
  }

  .sub-btn:hover,
  .sub-btn.active {
    background: var(--primary-light);
    color: var(--primary);
    font-weight: 600;
  }

  .category-divider {
    border: 0;
    height: 1px;
    background: #e2e8f0;
    margin: 1.2rem 0;
    opacity: 0.5;
  }

  .course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
    transition: all 0.3s ease;
  }

  .tag-pill {
    font-weight: 600;
  }
  /* Category button */
.category-btn {
 background: #f7f7f7;
    color: #000;
    transition: all 0.25s ease;
    font-size: 15px;
}

.category-btn:hover,
.category-btn.active {
  background: #4361ee;
  color: white;
  box-shadow: 0 2px 8px rgba(67, 97, 238, 0.18);
}

/* Sub-list items (button style) */
.sub-btn {
  color: #475569;
  background: white;
  border: 1px solid #e2e8f0;
  transition: all 0.2s ease;
}

.sub-btn:hover,
.sub-btn.active {
  background: #e0e7ff;
  color: #4361ee;
  border-color: #c7d2fe;
  font-weight: 600;
}

/* Dividers inside sub-list */
.sub-divider {
  border: 0;
  height: 1px;
  background: #e2e8f0;
  margin: 0.75rem 0;
  opacity: 0.7;
}

/* Hide sub-lists by default */
.sub-list {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.35s ease;
}

.sub-list.show {
  max-height: 500px; /* adjust if you have many items */
}
.edu-course-card {
    margin-bottom: 2rem;
    perspective: 1000px; /* subtle 3D feel on hover */
}

.edu-card {
    background: white;
    border-radius: 1rem; /* 16px */
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
    border: 1px solid #f1f5f9;
}

.edu-card:hover {
    transform: translateY(-10px) rotateX(2deg) rotateY(2deg);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.14);
}

.edu-card-image {
    position: relative;
}

.edu-thumbnail {
    width: 100%;
    height: 220px;
    border: 5px solid #ffffff;
    border-radius:20px;
    overflow:hidden;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}

.edu-card:hover .edu-thumbnail {
    transform: scale(1.06);
}

.edu-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #045279;
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 2rem;
    font-size: 10px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    z-index: 10;
}

.edu-card-body {
    padding: 15px;
}

.edu-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 0.95rem;
    color: #64748b;
}

.edu-duration .icon {
    margin-right: 0.4rem;
    font-size: 1.1rem;
}

.edu-price {
    font-weight: 700;
    font-size: 1.35rem;
    color: #ec4899; /* vibrant price color – change to your brand */
}

.edu-title {
    height: 55px;
    font-size: 1.4rem;
    line-height: 1.35;
    margin: 0 0 0.75rem;
    font-weight: 700;
    color: #1e293b;
}

.edu-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s;
}

.edu-title a:hover {
    color: #3b82f6;
}

.edu-description {
    height:52px;
    color: #64748b;
    font-size: 0.975rem;
    line-height: 1.6;
    margin: 0 0 1.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.edu-actions {
        display: flex;
    flex-direction: row;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: nowrap;
}

.edu-btn {
       padding: 0.5rem .8rem;
    border-radius: 9px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.edu-btn-primary {
    background: #045279;
    color: white;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.25);
}

.edu-btn-primary:hover {
    background: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
    border: 2px solid #045279;
}

.edu-btn-outline {
    background: transparent;
    border: 2px solid #045279;
    color: #045279;
}

.edu-btn-outline:hover {
    background: #045279;
    color: white;
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .edu-thumbnail {
        height: 180px;
    }
    .edu-title {
        font-size: 1.25rem;
    }
}
.category-arrow {
  font-size: 1rem;
  transition: transform 0.35s ease;
  margin-left: auto;           /* pushes arrow to right */
  opacity: 0.7;
}

.category-btn.active .category-arrow {
  transform: rotate(180deg);   /* ▼ → ▲ when open */
}

.category-btn:hover .category-arrow {
  opacity: 1;
  transform: translateY(-1px); /* subtle lift on hover */
}

</style>
@section('content')

	<body class="hidden-bar-wrapper">
		<!-- Page Title -->
		<section class="page-banner">
  <div class="auto-container">
    <div class="banner-content text-center">
      <h1 class="banner-heading">Courses</h1>
      <p class="banner-subtitle">
        Explore our wide range of thoughtfully designed courses<br>
        crafted to help you learn, grow, and achieve your goals with confidence.
      </p>

      <!-- Optional: small breadcrumb at bottom -->
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Courses</li>
      </ul>
    </div>
  </div>
</section>
		<!-- End Page Title -->
<section class="courses-section py-5 bg-white">
  <div class="container">
    <div class="row g-4">

      <!-- Left Sidebar -->
     <!-- Left Sidebar -->
<div class="col-lg-4 col-xl-3">
  <div class="sidebar-categories card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;height:70vh;">
    <h5 class="sidebar-title fw-bold mb-4">Browse Categories</h5>

    <!-- Science & Technology -->
    <!--<button class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0" data-category="science">-->
    <!--  Science & Technology-->
    <!--</button>-->
    <!-- Science & Technology -->
<button class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0 d-flex align-items-center justify-content-between"
  data-category="science">
  <span>Science & Technology</span>
  <i class="fas fa-chevron-down category-arrow transition-all"></i>
</button>

    <ul class="sub-list list-unstyled ms-3 " id="sub-science">
      <li class="mb-2">
        <a href="#" class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none" data-sub="physics">Physics</a>
      </li>
      <hr class="sub-divider">
      <li class="mb-2">
        <a href="#" class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none" data-sub="chemistry">Chemistry</a>
      </li>
      <hr class="sub-divider">
      <li class="mb-2">
        <a href="#" class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none" data-sub="biology">Biology</a>
      </li>
    </ul>

    <!-- Commerce & Accounts -->
    <button class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0 d-flex align-items-center justify-content-between"
  data-category="commerce">
  <span>Commerce & Accounts</span>
  <i class="fas fa-chevron-down category-arrow transition-all"></i>
</button>

    <!--<button class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0" data-category="commerce">-->
    <!--  Commerce & Accounts-->
    <!--</button>-->

    <ul class="sub-list list-unstyled ms-3 " id="sub-commerce">
      <li class="mb-2">
        <a href="#" class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none" data-sub="accounts">Accountancy</a>
      </li>
      <hr class="sub-divider">
      <li class="mb-2">
        <a href="#" class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none" data-sub="business">Business Studies</a>
      </li>
    </ul>

    <!-- Add more categories here in the same pattern -->
  </div>
</div>

      <!-- Right Content -->
      <div class="col-lg-8 col-xl-9">

        <!-- Toolbar -->
        <div class="toolbar card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: #f7f7f7">
          <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 px-4">
            <div class="input-group" style="max-width: 500px;">
              <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input type="search" class="form-control border-start-0 shadow-none rounded-end-pill" placeholder="Search courses, topics...">
            </div>
            <div class="d-flex align-items-center gap-3">
              <span class="text-muted fw-medium" style="white-space:nowrap;">Sort by:</span>
              <select class="form-select rounded-pill shadow-none" style="min-width: 180px;">
                <option>Recommended</option>
                <option>Newest First</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Topic Pills -->
        <div class="topic-pills mb-4 d-flex flex-wrap gap-2" id="topicPills">
          <!-- Default: Physics topics -->
          <button class="btn btn-primary  px-4 py-2 active">Mechanics</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Thermodynamics</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Electromagnetism</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Waves & Optics</button>
        </div>

        <!-- Course Grid -->
        <div class="row g-4" id="courseGrid">
          <!-- Physics / Mechanics courses -->
          @foreach($courses as $course)
								<div class="edu-course-card col-xl-4 col-lg-6 col-md-6 sm-12">
    <div class="edu-card">
        <div class="edu-card-image">
            <!--<div class="edu-tag">{{$course->examinationCommission->name}}</div>-->
            <a href="{{ route('courses.detail', $course->id) }}" class="block">
                <img 
                    src="{{ url('storage/' . $course->thumbnail_image) }}" 
                    alt="{{ $course->image_alt_tag }}" 
                    class="edu-thumbnail"
                >
            </a>
        </div>

        <div class="edu-card-body">
            <div class="edu-meta">
                <div class="edu-duration">
                    <span class="icon flaticon-hourglass"></span>
                    {{ $course->duration }} Week
                </div>
               
                <div class="edu-price">₹{{ $course->offered_price }}</div>
            </div>
             <p class="commission-name">{{$course->examinationCommission->name}}</p>

            <h3 class="edu-title">
                <a href="{{ route('courses.detail', $course->id) }}">{{ $course->name }}</a>
            </h3>

            <p class="edu-description">{{ $course->course_heading }}</p>

            <div class="edu-actions">
                
                <a href="{{ route('courses.detail', $course->id) }}" 
                   class="edu-btn edu-btn-outline" style="width: 100%;
    display: flex;
    justify-content: center;
    text-align: center;
">
                    View Details
                    <span class="arrow-icon flaticon-arrow-pointing-to-right"></span>
                </a>
            </div>
        </div>
    </div>
</div>
							@endforeach
          <!-- Add more course items with different data-topic -->
        </div>

        <!-- Pagination -->
       
      </div>
    </div>
  </div>
</section>

<!-- CSS -->


<!-- JavaScript -->

<script>
    // Category click → toggle its sub-list only
// Single clean handler for category buttons (arrow + sub-list toggle)
document.querySelectorAll('.category-btn').forEach(btn => {
  btn.addEventListener('click', function(e) {
    // e.preventDefault();   // only if needed – usually not required here

    const isAlreadyActive = this.classList.contains('active');

    // Close everything first
    document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.sub-list').forEach(list => list.classList.remove('show'));

    // Toggle current one
    if (!isAlreadyActive) {
      this.classList.add('active');

      const subId = `sub-${this.dataset.category}`;
      const subList = document.getElementById(subId);
      if (subList) {
        subList.classList.add('show');
      }
    }
    // If clicked when already open → it closes (arrow rotates back down)
  });
});

// Optional: Highlight sub-btn when clicked (for visual feedback)
document.querySelectorAll('.sub-btn').forEach(sub => {
  sub.addEventListener('click', function(e) {
    // e.preventDefault(); → remove if you want real navigation later

    // Remove active from all sub-btns
    document.querySelectorAll('.sub-btn').forEach(s => s.classList.remove('active'));
    // Add to clicked one
    this.classList.add('active');

    // Your existing code for updating right side topics/courses goes here...
    // Example:
    // const selectedSub = this.dataset.sub;
    // updateTopicPills(selectedSub);
    // filterCourses(selectedSub);
  });
});

</script>
<script>
  // Category click → expand sub-list
 

  // Sub-category click → highlight + change right side topics & courses
  document.querySelectorAll('.sub-btn').forEach(sub => {
    sub.addEventListener('click', function(e) {
      e.preventDefault();

      // Highlight clicked sub
      document.querySelectorAll('.sub-btn').forEach(s => s.classList.remove('active'));
      this.classList.add('active');

      const selectedSub = this.dataset.sub;

      // Change topic pills based on selected subject
      const pillsContainer = document.getElementById('topicPills');

      let newPills = '';

      if (selectedSub === 'physics') {
        newPills = `
          <button class="btn btn-primary  px-4 py-2 active">Mechanics</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Thermodynamics</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Electromagnetism</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Waves & Optics</button>
        `;
      } else if (selectedSub === 'chemistry') {
        newPills = `
          <button class="btn btn-primary  px-4 py-2 active">Organic Chemistry</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Inorganic Chemistry</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Physical Chemistry</button>
        `;
      } else if (selectedSub === 'accounts') {
        newPills = `
          <button class="btn btn-primary  px-4 py-2 active">Partnership Accounts</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Company Accounts</button>
          <button class="btn btn-outline-secondary  px-4 py-2">Cash Flow</button>
        `;
      } else {
        newPills = '<p class="text-muted">No topics available</p>';
      }

      pillsContainer.innerHTML = newPills;

      // For demo: filter courses (in real app → AJAX fetch courses by subject_id)
      document.querySelectorAll('.course-item').forEach(item => {
        if (item.dataset.topic === selectedSub || item.dataset.topic === 'accounts') {
          item.classList.remove('d-none');
        } else {
          item.classList.add('d-none');
        }
      });
    });
  });


  // Optional: auto open first category on load
  // document.querySelector('.category-btn[data-category="science"]').click();
</script>
		<!-- Course Section -->
	{{--	<section class="course-page-section-two">
			<div class="container">
				<div class="row clearfix">

					<!-- Sidebar Column -->
					<div class="sidebar-column col-lg-3 col-md-8 col-sm-12">
						<!-- Search Widget -->
						<div class="sidebar-widget search-box">
							<div class="widget-content">
								<form method="GET" action="{{ isset($subcat) && $subcat 
    ? route('courses.filter', ['id' => $subcat]) 
    : route('courses') }}"
									id="searchForm">
									<div class="form-group">
										<input type="search" name="search" value="{{ request('search') ?? '' }}"
											placeholder="Search">
										<button type="submit"><span class="icon fa fa-search"></span></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Blocks Column -->
					<div class="blocks-column col-lg-9 col-md-12 col-sm-12">

						<!-- Filter Box -->
						<div class="filter-box">

							<!-- Dropdown Filters Start -->
							<form method="GET" action="{{ isset($subcat) && $subcat 
    ? route('courses.filter', ['id' => $subcat]) 
    : route('courses') }}" id="filterForm"
								class="mb-3">
								<div class="row g-2">

									<!-- Subject -->
									<div class="col">
										<select name="subject_id" class="form-control">
											<option value="">--Select Subject--</option>
											@foreach($subjects as $subject)
												<option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
													{{ $subject->name }}
												</option>
											@endforeach
										</select>
									</div>

									<!-- Chapter -->
									<div class="col">
										<select name="chapter_id" class="form-control">
											<option value="">--Select Chapter--</option>
											@foreach($chapters as $chapter)
												<option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>
													{{ $chapter->name }}
												</option>
											@endforeach
										</select>
									</div>

									<!-- Topic -->
									<div class="col">
										<select name="topic_id" class="form-control">
											<option value="">--Select Topic--</option>
											@foreach($topics as $topic)
												<option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
													{{ $topic->name }}
												</option>
											@endforeach
										</select>
									</div>

									<!-- Submit Button -->
									<div class="col-auto">
										<button type="submit" class="btn btn-primary">Filter</button>
									</div>

								</div>
							</form>
							<!-- Dropdown Filters End -->
						</div>

						<!-- End Filter Box -->

						<div class="row clearfix">
							<!-- SM Block Five -->
							@foreach($courses as $course)
								<div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
									<div class="inner-box">
										<div class="image">
											<div class="tag">{{$course->examinationCommission->name}}</div>
											<a href="{{route('courses.detail', $course->id)}}"><img
													src="{{url('storage/' . $course->thumbnail_image)}}"
													alt="{{$course->image_alt_tag}}"></a>
										</div>
										<div class="lower-content">
											<div class="content">
												<div class="d-flex justify-content-between align-items-center">
													<ul class="feature-list">
														<li><span class="osd flaticon-hourglass"></span> <span
																class="osd tt">{{$course->duration}} Week</span></li>
													</ul>
													<div class="price">RS. {{$course->offered_price}}</div>

												</div>
												<h4><a href="service-detail.html">{{$course->name}}</a></h4>
												<div class="contents">
													<p class="mb-1">{{$course->course_heading}}</p>

													<small class="text-muted d-flex align-items-center gap-1">
														<span class="flaticon-internet"></span>
														<span>
															Learning Method: {{ $course->course_mode ?? 'Online' }}
														</span>
													</small>
												</div>

											</div>
											<div class="lower-box osd m">
												<div class="d-flex justify-content-between align-items-center">
													<div class="cm">
														<a class="course-btn osd"
															href="{{route('courses.detail', $course->id)}}">Register Now <span
																class="flaticon-arrow-pointing-to-right"></span></a>
													</div>
													<div class="cmm">
														<a class="course-btn osd"
															href="{{route('courses.detail', $course->id)}}">View
															Details <span class="flaticon-arrow-pointing-to-right"></span></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>


						<!-- Styled Pagination -->
						<ul class="styled-pagination">
							<li><a href="#" class="active">1</a></li>
							<li class="next"><a href="#"><span class="flaticon-arrow-pointing-to-right"></span></a></li>
						</ul>
						<!-- End Styled Pagination -->
					</div>
				</div>
			</div>
		</section> --}}
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	</body>
@endsection