@extends('front.partials.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  .page-banner {
    padding: 35px 0 35px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e6f5f5 100%);
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
    margin-bottom: 1.2rem;
    line-height: 1.1;
  }

  .banner-subtitle {
    font-size: 1.18rem;
    color: #4a5568;
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
    background: #f7f7f7;
    color: #000;
    transition: all 0.25s ease;
    font-size: 15px;
    border: none;
  }

  .category-btn:hover,
  .category-btn.active {
    background: #4361ee;
    color: white;
    box-shadow: 0 2px 8px rgba(67, 97, 238, 0.18);
  }

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

  .category-divider {
    border: 0;
    height: 1px;
    background: #e2e8f0;
    margin: 1.2rem 0;
    opacity: 0.5;
  }

  .sub-divider {
    border: 0;
    height: 1px;
    background: #e2e8f0;
    margin: 0.75rem 0;
    opacity: 0.7;
  }

  .sub-list {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease;
  }

  .sub-list.show {
    max-height: 500px;
  }

  .category-arrow {
    font-size: 1rem;
    transition: transform 0.35s ease;
    margin-left: auto;
    opacity: 0.7;
  }

  .category-btn.active .category-arrow {
    transform: rotate(180deg);
  }

  .category-btn:hover .category-arrow {
    opacity: 1;
    transform: translateY(-1px);
  }

  .edu-course-card {
    margin-bottom: 2rem;
    perspective: 1000px;
  }

  .edu-card {
    background: white;
    border-radius: 1rem;
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
    border-radius: 20px;
    overflow: hidden;
    object-fit: fill;
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
    color: #ec4899;
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
    height: 52px;
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

  @media (max-width: 640px) {
    .edu-thumbnail {
      height: 180px;
    }

    .edu-title {
      font-size: 1.25rem;
    }
  }

  .commission-name {
    width: fit-content;
    font-size: 12px;
    color: gray;
    margin: 0px;
    background: #f8fbff;
    padding: 3px 10px;
    border-radius: 3px;
  }

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
          <h1 class="banner-heading">Study Materials</h1>
          <p class="banner-subtitle">
            Explore our wide range of thoughtfully designed Study Materials<br>
            crafted to help you learn, grow, and achieve your goals with confidence.
          </p>

          <ul class="bread-crumb clearfix">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('study.material.front') }}">Study Materials</a></li>

            @if(isset($selectedCommission))
              <li>
                <a href="{{ route('study.material.front', ['examSlug' => $selectedCommission->slug]) }}">
                  {{ $selectedCommission->name }}
                </a>
              </li>
            @endif

            @if(isset($selectedCategory))
              <li>
                <a href="{{ route('study.material.front', ['examSlug' => $selectedCommission->slug, 'catSlug' => $selectedCategory->slug]) }}">
                  {{ $selectedCategory->name }}
                </a>
              </li>
            @endif

            @if(isset($selectedSubCategory))
              <li>{{ $selectedSubCategory->name }}</li>
            @endif
          </ul>
        </div>
      </div>
    </section>
    <!-- End Page Title -->
    <section class="courses-section py-5 bg-white">
      <div class="container">
        <div class="row g-4">

          <!-- Left Sidebar (desktop) -->
          <div class="col-lg-4 col-xl-3 d-none d-lg-block">
            <div class="sidebar-categories card border-0 shadow-sm rounded-4 p-4 sticky-top"
              style="top: 100px;height:auto;">
              <h5 class="sidebar-title fw-bold mb-4">Browse Categories</h5>

              @foreach($commissions as $commission)
                @php
                  $isCommissionActive = isset($selectedCommission) && $selectedCommission->id == $commission->id;
                @endphp

                <button
                  class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0 d-flex align-items-center justify-content-between {{ $isCommissionActive ? 'active' : '' }}"
                  data-category="commission-{{ $commission->slug }}">

                  <span>{{ $commission->name }}</span>
                  <i class="fas fa-chevron-down category-arrow transition-all"></i>

                </button>

                <ul class="sub-list list-unstyled ms-3 {{ $isCommissionActive ? 'show' : '' }}"
                  id="sub-commission-{{ $commission->slug }}">

                  @foreach($commission->categories as $category)
                    <li class="mb-2">
                      <a href="{{ route('study.material.front', [
                            'examSlug' => $commission->slug,
                            'catSlug' => $category->slug
                          ]) }}"
                        class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none
                              {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active' : '' }}">
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
            <button
              class="btn btn-outline-primary d-lg-none mb-3 w-100 d-flex align-items-center justify-content-center gap-2"
              type="button" data-bs-toggle="offcanvas" data-bs-target="#categoryDrawer">
              <i class="fas fa-list-ul"></i> Browse Categories
            </button>

            <!-- Toolbar -->
            <div class="toolbar card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: #f7f7f7">
              <form method="GET"
                action="{{ route('study.material.front', array_filter([
                      'examSlug' => optional($selectedCommission)->slug,
                      'catSlug' => optional($selectedCategory)->slug,
                      'subCatSlug' => optional($selectedSubCategory)->slug,
                    ])) }}">

                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 px-4">

                  <!-- Search -->
                  <div class="input-group" style="max-width: 500px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                      <i class="fas fa-search text-muted"></i>
                    </span>

                    <input type="search" name="search" value="{{ request('search') }}"
                      class="form-control border-start-0 shadow-none rounded-end-pill"
                      placeholder="Search study material...">
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
                  </div>

                </div>
              </form>
            </div>

            <!-- Topic Pills -->
            <div class="topic-pills mb-4 d-flex flex-wrap gap-2" id="topicPills">

              @if($subcategories->isNotEmpty())

                <a href="{{ route('study.material.front', [
                      'examSlug' => $selectedCommission->slug,
                      'catSlug' => $selectedCategory->slug,
                    ]) }}"
                  class="btn {{ !isset($selectedSubCategory) ? 'btn-primary' : 'btn-outline-secondary' }} px-4 py-2">
                  All
                </a>

                @foreach($subcategories as $sub)
                  <a href="{{ route('study.material.front', [
                        'examSlug' => $selectedCommission->slug,
                        'catSlug' => $selectedCategory->slug,
                        'subCatSlug' => $sub->slug
                      ]) }}"
                    class="btn {{ isset($selectedSubCategory) && $selectedSubCategory->id == $sub->id ? 'btn-primary' : 'btn-outline-secondary' }} px-4 py-2">
                    {{ $sub->name }}
                  </a>
                @endforeach

              @else

                <span class="text-muted">Select a category to view sub categories</span>

              @endif

            </div>

            <!-- study material Grid -->
            <div class="row g-2">

              @if($studyMaterials->count())

                @foreach($studyMaterials as $material)

                  <div class="edu-course-card col-12 col-md-6 col-xl-4"
                    data-commission="{{ $material->commission->slug ?? $material->commission_id }}"
                    data-category="{{ $material->category_id ?? 'all' }}"
                    data-category-name="{{ addslashes($material->category->name ?? '') }}">

                    <div class="edu-card">
                      <div class="edu-card-image">
                        <a href="{{ route('study.material.details', [$material->slug, $material->id])) }}" class="block">
                          <img src="{{ url('storage/' . $material->banner) }}" alt="{{ $material->title }}"
                            class="edu-thumbnail">
                        </a>
                      </div>

                      <div class="edu-card-body">
                        <div class="edu-meta">
                          <div class="edu-duration">
                            {{ $material->is_pdf_downloadable ? 'Pdf Available' : ''}}
                          </div>

                          <div class="edu-price">
                            {{ $material->IsPaid ? '₹' . $material->price : 'Free' }}
                          </div>
                        </div>
                        <p class="commission-name">
                          {{$material->subcategory->name}}
                        </p>

                        <h3 class="edu-title">
                          <a href="{{ route('study.material.details', [$material->slug, $material->id]) }}">{{ $material->title }}</a>
                        </h3>

                        <p class="edu-description">{{ $material->short_description }}
                        </p>

                        <div class="edu-actions">

                          <a href="{{ route('study.material.details', [$material->slug, $material->id]) }}" class="edu-btn edu-btn-outline"
                            style="width: 100%;display: flex;justify-content: center; text-align: center;">
                            View Details
                            <span class="arrow-icon flaticon-arrow-pointing-to-right"></span>
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

                    <h4 class="fw-bold">No Study Material Found</h4>

                    <p class="text-muted">
                      Try adjusting your search or category filters.
                    </p>

                  </div>

                </div>

              @endif
            </div>

            {{ $studyMaterials->onEachSide(1)->links('pagination::bootstrap-5') }}

          </div>

          <!-- Left Sidebar – responsive offcanvas -->
          <div class="offcanvas offcanvas-start offcanvas-lg border-0 shadow-sm m-0" tabindex="-1" id="categoryDrawer"
            aria-labelledby="categoryDrawerLabel">

            <div class="offcanvas-header">
              <h5 class="offcanvas-title fw-bold" id="categoryDrawerLabel">Browse Categories</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr>

            @foreach($commissions as $commission)
              @php
                $isCommissionActiveMobile = isset($selectedCommission) && $selectedCommission->id == $commission->id;
              @endphp

              <button
                class="category-btn fw-semibold text-start w-100 py-3 px-4 rounded-3 mb-3 border-0 d-flex align-items-center justify-content-between {{ $isCommissionActiveMobile ? 'active' : '' }}"
                type="button" data-bs-toggle="collapse" data-bs-target="#sub-commission-mobile-{{ $commission->slug }}"
                aria-expanded="{{ $isCommissionActiveMobile ? 'true' : 'false' }}"
                aria-controls="sub-commission-mobile-{{ $commission->slug }}">
                <span>{{ $commission->name }}</span>
                <i class="fas fa-chevron-down category-arrow transition-all"></i>
              </button>

              <ul class="sub-list list-unstyled ms-3 collapse {{ $isCommissionActiveMobile ? 'show' : '' }}"
                id="sub-commission-mobile-{{ $commission->slug }}">
                @foreach($commission->categories as $category)
                  <li class="mb-2">
                    <a href="{{ route('study.material.front', [
                          'examSlug' => $commission->slug,
                          'catSlug' => $category->slug
                        ]) }}"
                      class="sub-btn d-block py-2 px-3 rounded-3 text-decoration-none
                            {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active' : '' }}">
                      {{ $category->name }}
                    </a>
                  </li>
                  <hr class="sub-divider">
                @endforeach
              </ul>
            @endforeach
          </div>

        </div>
      </div>
    </section>

    <!-- JavaScript -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Desktop sidebar toggle (mobile offcanvas uses Bootstrap's own collapse JS)
        document.querySelectorAll('.col-lg-4.d-none .category-btn[data-category]').forEach(btn => {
          btn.addEventListener('click', function () {
            const target = this.dataset.category; // e.g. "commission-upsc"
            const subList = document.getElementById(`sub-${target}`);
            const isAlreadyActive = this.classList.contains('active');

            document.querySelectorAll('.col-lg-4.d-none .category-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.col-lg-4.d-none .sub-list').forEach(list => list.classList.remove('show'));

            if (!isAlreadyActive && subList) {
              this.classList.add('active');
              subList.classList.add('show');
            }
          });
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