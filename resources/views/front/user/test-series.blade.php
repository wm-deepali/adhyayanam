@extends('front.partials.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  .page-banner {
    padding: 35px 0 35px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e6f5f5 100%);
    /* light pastel blue-green */
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
    background: radial-gradient(circle at 30% 70%, rgba(255, 255, 255, 0.4) 0%, transparent 60%);
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
    color: #1a2a44;
    /* dark slate for contrast */
    margin-bottom: 1.2rem;
    line-height: 1.1;
  }

  .banner-subtitle {
    font-size: 1.18rem;
    color: #4a5568;
    /* softer gray */
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

  .bread-crumb li+li::before {
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


  :root {
    --primary: #4361ee;
    --primary-light: #e0e7ff;
    --pastel: #f5faff;
    --gray: #f8f9fa;
    --text: #1e293b;
    --muted: #64748b;
    --radius: 0.9rem;
    --shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
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
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12) !important;
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
    max-height: 500px;
    /* adjust if you have many items */
  }


  .category-arrow {
    font-size: 1rem;
    transition: transform 0.35s ease;
    margin-left: auto;
    /* pushes arrow to right */
    opacity: 0.7;
  }

  .category-btn.active .category-arrow {
    transform: rotate(180deg);
    /* ▼ → ▲ when open */
  }

  .category-btn:hover .category-arrow {
    opacity: 1;
    transform: translateY(-1px);
    /* subtle lift on hover */
  }

  .newtestseries-card {
    transition: all 0.35s ease;
    border-radius: 16px !important;
  }

  .newtestseries-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08) !important;
  }

  .newtestseries-logo-frame {
    width: 100%;
    height: 200px !important;
    padding: 8px;
    background: white;
    /*box-shadow: 0 4px 12px rgba(0,0,0,0.1);*/
  }

  .newtestseries-title {
    font-size: 1.4rem !important;
    min-height: 50px;
  }

  .newtestseries-divider {
    border-top: 2px solid #dee2e6 !important;
  }

  .newtestseries-test-count {
    font-size: 1.1rem !important;
  }

  .newtestseries-free {
    font-weight: 600 !important;
  }

  .newtestseries-features .newtestseries-feature-row {
    font-size: 1.05rem !important;
  }

  .newtestseries-label {
    color: #555 !important;
    flex: 0 0 60% !important;
  }

  .newtestseries-value {
    color: #222 !important;
    font-weight: 600 !important;
    text-align: right !important;
  }

  .newtestseries-view-btn {
    background: linear-gradient(90deg, #0d6efd, #0056b3) !important;
    color: white !important;
    border: none !important;
    font-size: 1.1rem !important;
    transition: all 0.3s !important;
  }

  .newtestseries-view-btn:hover {
    background: linear-gradient(90deg, #0056b3, #004085) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25) !important;
  }

  .newtestseries-all-btn {
    font-size: 1.2rem !important;
    padding: 14px 40px !important;
  }


  /* Custom Pagination */

  .pagination {
    gap: 6px;
  }

  .pagination .page-link {
    border: none;
    background: #f1f5f9;
    color: #045279;
    font-weight: 600;
    padding: 10px 16px;
    border-radius: 8px;
    transition: all .25s ease;
  }

  .pagination .page-link:hover {
    background: #045279;
    color: white;
  }

  .pagination .page-item.active .page-link {
    background: #045279;
    color: white;
    box-shadow: 0 3px 10px rgba(4, 82, 121, 0.25);
  }

  .pagination .page-item.disabled .page-link {
    background: #e2e8f0;
    color: #94a3b8;
  }
</style>
@section('content')

  <body class="hidden-bar-wrapper">
    <!-- Page Title -->
    <section class="page-banner">
      <div class="auto-container">
        <div class="banner-content text-center">
          <h1 class="banner-heading">Test Series</h1>
          <p class="banner-subtitle">
            Explore our wide range of thoughtfully designed Test Series<br>
            crafted to help you learn, grow, and achieve your goals with confidence.
          </p>

          <!-- Optional: small breadcrumb at bottom -->
          <ul class="bread-crumb clearfix">
            <li><a href="index.html">Home</a></li>
            <li>Test Series</li>
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
            <div class="sidebar-categories card border-0 shadow-sm rounded-4 p-4 sticky-top"
              style="top: 100px;height:70vh;">
              <h5 class="sidebar-title fw-bold mb-4">Browse Categories</h5>

              <!-- Science & Technology -->
              <!--<button class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0" data-category="science">-->
              <!--  Science & Technology-->
              <!--</button>-->
              <!-- Science & Technology -->
              @foreach($commissions->take(3) as $commission)

                <button
                  class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0 d-flex align-items-center justify-content-between"
                  data-category="commission-{{ $commission->id }}">

                  <span>{{ $commission->name }}</span>
                  <i class="fas fa-chevron-down category-arrow transition-all"></i>

                </button>


                <ul class="sub-list list-unstyled ms-3" id="sub-commission-{{ $commission->id }}">

                  @foreach($commission->categories->take(3) as $category)

                              <li class="mb-2">
                                <a href="{{ route('test-series-list', [
                      'exam_id' => $commission->id,
                      'category_id' => $category->id
                    ]) }}"
                                  class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none 
                                                                                    {{ request('category_id') == $category->id ? 'active' : '' }}">

                                  {{ $category->name }}

                                </a>
                              </li>

                              <hr class="sub-divider">

                  @endforeach

                </ul>

              @endforeach

            </div>
          </div>

          <!-- Right Content -->
          <div class="col-lg-8 col-xl-9">

            <!-- Toolbar -->
            <div class="toolbar card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: #f7f7f7">
              <form method="GET" action="{{ route('test-series-list') }}">

                <!-- Keep existing filters -->
                <input type="hidden" name="exam_id" value="{{ request('exam_id') }}">
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                <input type="hidden" name="sub_category_id" value="{{ request('sub_category_id') }}">

                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 px-4">

                  <!-- Search -->
                  <div class="input-group" style="max-width: 500px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                      <i class="fas fa-search text-muted"></i>
                    </span>

                    <input type="search" name="search" value="{{ request('search') }}"
                      class="form-control border-start-0 shadow-none rounded-end-pill"
                      placeholder="Search test series...">
                  </div>

                  <!-- Sort -->
                  <div class="d-flex align-items-center gap-3">
                    <span class="text-muted fw-medium" style="white-space:nowrap;">Sort by:</span>

                    <select name="sort" class="form-select rounded-pill shadow-none" style="min-width: 180px;"
                      onchange="this.form.submit()">
                      <option value="">Recommended</option>

                      <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                        Newest First
                      </option>

                      <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                        Price: Low to High
                      </option>

                      <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                        Price: High to Low
                      </option>

                    </select>

                    <!-- Search Button -->
                    <button class="btn btn-primary rounded-pill px-4">
                      Search
                    </button>
                  </div>

                </div>
              </form>
            </div>

            <!-- Topic Pills -->
            <div class="topic-pills mb-4 d-flex flex-wrap gap-2" id="topicPills">

              @if($subcategories->isNotEmpty())


                @foreach($subcategories->take(3) as $sub)

                          <a href="{{ route('test-series-list', [
                    'exam_id' => request('exam_id'),
                    'category_id' => request('category_id'),
                    'sub_category_id' => $sub->id
                  ]) }}"
                            class="btn {{ request('sub_category_id') == $sub->id ? 'btn-primary' : 'btn-outline-secondary' }} px-4 py-2">

                            {{ $sub->name }}

                          </a>

                @endforeach

              @else

                <span class="text-muted">Select a category to view sub categories</span>

              @endif

            </div>

            <!-- test seies Grid -->
            <div class="row g-4 testseries-grid" style="margin-bottom:10px;">

              @if($testPackages->count())

                @foreach($testPackages as $data)
                  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 testseries-card"
                    data-commission="{{ strtolower($data->commission->slug ?? $data->commission->id) }}"
                    data-category="{{ $data->category_id ?? 'all' }}">
                    <!-- SAME CARD DESIGN AS ORIGINAL -->
                    <div class="newtestseries-card rounded-4 shadow-sm h-100 overflow-hidden position-relative"
                      style="background: linear-gradient(135deg, {{ $loop->index % 3 == 0 ? '#e6f0ff' : ($loop->index % 3 == 1 ? '#eaffea' : '#f3e6ff') }}, #ffffff); border: 1px solid #e0e0e0;">
                      <div class="newtestseries-card-inner p-3 d-flex flex-column h-100">
                        <!-- Logo -->
                        <div class="newtestseries-logo-wrapper text-center mb-2">
                          <div class="newtestseries-logo-frame border-5 border-white mx-auto">
                            <img src="{{ url('storage/' . $data->logo) }}" alt="{{ $data->title }}"
                              class="w-100 h-100 object-cover">
                          </div>
                        </div>
                        <!-- Title -->
                        <h4 class="newtestseries-title fw-bold text-start mb-1 text-dark">
                          {{ $data->title }}
                        </h4>
                        <!-- Test Count -->
                        <div class="newtestseries-test-count d-flex justify-content-between align-items-center mb-2">
                          <span class="newtestseries-count-left fw-medium text-primary">
                            {{ count($data->testseries) }} Test
                            <span class="newtestseries-free text-success ms-1">
                              | {{ $data->fee_type == 'paid' ? 'Premium' : 'Free' }}
                            </span>
                          </span>
                          <span class="newtestseries-count-right small text-muted">Available
                            Now</span>
                        </div>
                        <!-- Features Table -->
                        <div class="newtestseries-features mb-4 flex-grow-1">
                          <div class="newtestseries-feature-row d-flex justify-content-between py-2 border-bottom">
                            <span class="newtestseries-label">Chapter Test</span>
                            <span class="newtestseries-value fw-medium">
                              {{ $data->testseries->where('type_name', 'Chapter Test')->count() }}
                            </span>
                          </div>
                          <div class="newtestseries-feature-row d-flex justify-content-between py-2 border-bottom">
                            <span class="newtestseries-label">Current Affairs</span>
                            <span class="newtestseries-value fw-medium">
                              {{ $data->testseries->where('type_name', 'Current Affairs')->count() }}
                            </span>
                          </div>
                          <div class="newtestseries-feature-row d-flex justify-content-between py-2">
                            <span class="newtestseries-label">Subject Test</span>
                            <span class="newtestseries-value fw-medium">
                              {{ $data->testseries->where('type_name', 'Subject Wise')->count() }}
                            </span>
                          </div>
                        </div>
                        <!-- View Button -->
                        <div class="mt-auto">
                          <a href="{{ route('test-series-detail', $data->slug) }}"
                            class="newtestseries-view-btn btn w-100 py-2 fw-medium d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-arrow-right-circle"></i>
                            View Test Series
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach

              @else

                <!-- Empty State -->
                <div class="col-12">

                  <div class="text-center py-5">

                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>

                    <h4 class="fw-bold">No Test Series Found</h4>

                    <p class="text-muted">
                      Try adjusting your search or category filters.
                    </p>

                  </div>

                </div>

              @endif

            </div>


            {{ $testPackages->links('pagination::bootstrap-5') }}
            <!-- Pagination -->

          </div>
        </div>
      </div>
    </section>

    <!-- CSS -->


    <!-- JavaScript -->

    <script>
      document.addEventListener("DOMContentLoaded", function () {

        const examId = "{{ request('exam_id') }}";

        if (examId) {

          const btn = document.querySelector(`[data-category="commission-${examId}"]`);
          const list = document.getElementById(`sub-commission-${examId}`);

          if (btn && list) {
            btn.classList.add("active");
            list.classList.add("show");
          }

        }

      });
      document.querySelectorAll('.category-btn').forEach(btn => {

        btn.addEventListener('click', function () {

          const target = this.dataset.category;
          const subList = document.getElementById(`sub-${target}`);

          const isAlreadyActive = this.classList.contains('active');

          document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
          document.querySelectorAll('.sub-list').forEach(list => list.classList.remove('show'));

          if (!isAlreadyActive) {
            this.classList.add('active');
            subList.classList.add('show');
          }

        });

      });


      document.addEventListener("click", function (e) {

        if (e.target.closest(".pagination a")) {
          window.scrollTo({
            top: 0,
            behavior: "smooth"
          });
        }

      });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
@endsection