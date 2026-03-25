@extends('front.partials.app')

@section('header')
  <title>{{ $studyMaterial->meta_title ?? $studyMaterial->title . ' | Adhyayanam IAS' }}</title>
  <meta name="description" content="{{ $studyMaterial->meta_description ?? $studyMaterial->short_description }}">
  <meta name="keywords" content="{{ $studyMaterial->meta_keywords ?? 'study material, notes, UPSC, IAS' }}">
  <link rel="canonical" href="{{ url()->current() }}">
  <!-- Free version (yeh use kar rahe ho toh fa-file-pdf nahi milega) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Agar pro version use kar rahe ho toh yeh link hona chahiye -->
  <link rel="stylesheet" href="https://kit.fontawesome.com/your-kit-code.js">
@endsection

@section('content')
  <style>

    .study-detail-banner {
      background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 100%);
      padding: 60px 0 80px;
      position: relative;
    }

    .study-detail-title {
      font-size: 2.8rem;
      font-weight: 900;
      color: #1e293b;
      margin-bottom: 0px;
      margin-top: -10px;
    }

    .study-detail-short {
      font-size: 1.15rem;
      line-height: 1.7;
      color: #475569;
      margin-bottom: 1.5rem;
    }

    .study-detail-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      font-size: 1rem;
      color: #64748b;
    }

    .study-detail-meta-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .study-detail-quick-patti {
      width: 80%;
      margin: auto;
      border-radius: 7px;
      margin-top: 20px;
      background: linear-gradient(90deg, #9e9e9e 0%, #032369 100%);
      color: white;
      padding: 20px 0;

    }

    .quick-patti-item {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .study-detail-buy-btn {
      background: white;
      color: #15803d;
      font-weight: 700;
      font-size: 1.15rem;
      padding: 12px 28px;
      border-radius: 12px;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
      border: none;
    }

    .study-detail-buy-btn:hover {
      background: #f0fdf4;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.4);
    }

    .study-detail-content {
      padding: 50px 0 40px;
      font-size: 1.1rem;
      line-height: 1.9;
      color: #334155;
    }

    .preview-blur {
      position: relative;
      max-height: 500px;
      overflow: hidden;
    }

    .preview-blur::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 140px;
      background: linear-gradient(to top, white 30%, transparent 100%);
    }

    .unlock-box {
      background: #f8fafc;
      border-radius: 12px;
      padding: 40px;
      text-align: center;
      margin-top: 40px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .related-materials {
      background: #f8fafc;
      border-radius: 12px;
      padding: 24px;
      /*margin-top: 40px;*/
    }

    .related-item {
      border-bottom: 1px solid #e5e7eb;
      background: #fff;
      padding: 10px;
    }

    .related-item:last-child {
      border-bottom: none;
    }

    .related-item a {
      color: #1d4ed8;
      font-weight: 600;
      text-decoration: none;
    }

    .related-item a:hover {
      text-decoration: underline;
    }

    .related-badge {
      font-size: 0.85rem;
      padding: 4px 10px;
      border-radius: 20px;
      margin-left: 8px;
    }

    @media (max-width: 992px) {
      .study-detail-quick-patti .row {
        text-align: center;
      }

      .study-detail-buy-btn {
        margin-top: 16px;
      }
    }

    .wd-social-icons {
      display: none !important;
    }

    .ts-breadcrumb {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 6px;
      margin: 10px 0 0px 0;
      font-size: 14px;
    }

    .ts-breadcrumb a {
      color: #045279;
      text-decoration: none;
      font-weight: 500;
    }

    .ts-breadcrumb a:hover {
      text-decoration: underline;
    }

    .hierarchy-container {
      gap: 20px;
      max-width: 100%;
      display: flex;
      align-items: center;
    }

    .level-item {
      padding: 14px 18px;
      border-radius: 10px;
      /*margin-bottom: 10px;*/
      border: 1px solid rgba(0, 0, 0, 0.08);
      transition: all 0.18s ease;
      cursor: pointer;
    }

    .level-item:hover {
      transform: translateX(4px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .item-content {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 1.05rem;
      font-weight: 500;
      color: #333;
    }

    .item-title {
      flex: 1;
    }

    .subject-level {
      font-size: 1.15rem;
      font-weight: 600;
    }

    .chapter-level {
      font-size: 1.02rem;
    }

    .topic-level {
      font-size: 0.98rem;
      padding-left: 30px;
    }

    .children-container {
      position: relative;
    }

    .children-container:before {
      content: "";
      position: absolute;
      left: -20px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #dee2e6;
    }

    .sections-accordion-container {
      max-width: 1100px;
      margin: 0 auto;
    }

    .custom-accordion .accordion-item {
      border: none !important;
      border-radius: 12px !important;
      overflow: hidden;
      transition: all 0.22s ease;
    }

    .custom-accordion .accordion-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
    }

    .custom-accordion .accordion-button {
      padding: 0rem 1.5rem;
      font-size: 1.1rem;
      background: white;
      color: #222;
      border: none;
      border-radius: 12px !important;
      position: relative;
    }

    .custom-accordion .accordion-button:not(.collapsed) {
      background: #f8f9fa;
      color: #0d6efd;
      box-shadow: inset 0 -2px 0 #0d6efd;
    }

    .custom-accordion .accordion-button:focus {
      box-shadow: none;
      border-color: transparent;
    }

    .custom-accordion .accordion-button::after {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23222'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
      filter: brightness(0.7);
    }

    .custom-accordion .accordion-body {
      padding: 1rem 2rem;
      font-size: 1rem;
      line-height: 1.7;
      border-top: 1px solid #e9ecef;
    }

    .section-title {
      font-weight: 600;
      color: #1a1a1a;
    }

    .short-desc {
      font-size: 0.95rem;
      max-width: 380px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      margin-top: -25px;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
      .short-desc {
        display: none !important;
      }

      .custom-accordion .accordion-button {
        font-size: 1.05rem;
        padding: 1rem 1.25rem;
      }

      .custom-accordion .accordion-body {
        padding: 1.25rem 1.5rem;
      }
      .study-detail-banner {
    background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 100%);
    padding: 10px 0 40px;
    position: relative;
}
.study-detail-title {
    font-size: 22px;
    font-weight: 900;
    color: #1e293b;
    margin-bottom: 0px;
    margin-top: 0px;
}
.ts-breadcrumb {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0px;
    margin: 10px 0 0px 0;
    font-size: 12px;
    margin-bottom: 15px;
}
.study-detail-short {
    font-size: 16px;
    line-height: 1.5;
    color: #475569;
    margin-bottom: 10px;
}
.study-detail-quick-patti {
    width: 93%;
    margin: auto;
    border-radius: 7px;
    margin-top: 20px;
    background: linear-gradient(90deg, #9e9e9e 0%, #032369 100%);
    color: white;
    padding: 19px 0;
}
    }
    
    .px-responsive {
    padding-left: 20px;
    padding-right: 20px;
}

/* Tablet (md to lg) - 25px */
@media (min-width: 768px) and (max-width: 991.98px) {
    .px-responsive {
        padding-left: 25px;
        padding-right: 25px;
    }
}

/* Desktop (lg and above) - 50px */
@media (min-width: 992px) {
    .px-responsive {
        padding-left: 50px;
        padding-right: 50px;
    }
}
  </style>

  <!-- Banner Patti (Simple Info) -->
  <section class="study-detail-banner">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12 px-responsive" >
          <div class="ts-breadcrumb">
            <a href="{{ url('/') }}">Home</a>

            @if($studyMaterial->commission)
              <span class="arrow">›</span>
              <a href="#">{{ $studyMaterial->commission->name }}</a>
            @endif

            @if($studyMaterial->category)
              <span class="arrow">›</span>
              <a href="#">{{ $studyMaterial->category->name }}</a>
            @endif

            <span class="arrow">›</span>
            <span class="current">{{ $studyMaterial->title }}</span>

          </div>

          <h1 class="study-detail-title">{{ $studyMaterial->title }}</h1>
          <p class="study-detail-short">{{ $studyMaterial->short_description }}</p>

          <div class="study-detail-meta mb-4">
            <div class="study-detail-meta-item">
              <i class="fas fa-calendar-alt"></i>
              Updated: {{ \Carbon\Carbon::parse($studyMaterial->updated_at)->format('M d, Y') }}
            </div>

            @if($studyMaterial->is_pdf_downloadable)
              <div class="study-detail-meta-item">
                <i class="fas fa-file-pdf"></i>
                PDF Available
              </div>
            @endif

            @if($studyMaterial->IsPaid)
              <div class="study-detail-meta-item">
                <i class="fas fa-lock"></i>
                Premium Material
              </div>
            @else
              <div class="study-detail-meta-item">
                <i class="fas fa-unlock"></i>
                Free Access
              </div>
            @endif

          </div>

          <!-- Static Card View Hierarchy -->
          <!-- Static Compact Button-Card Hierarchy -->
          <div class="content-card-view mt-2">
            <h2 class="mb-2 text-center text-lg-start" style="font-size:24px;">Subject Details</h2>

            <div class="hierarchy-container flex-wrap">

              @forelse($studyMaterial->subjects as $subject)

                <div class="level-item subject-level" style="background: linear-gradient(90deg, #e3f2fd, #bbdefb);">

                  <div class="item-content">

                    <i class="fas fa-book me-3 text-primary"></i>

                    <span class="item-title">
                      {{ $subject->name }}
                    </span>

                    @php
                      $chapterCount = $studyMaterial->chapters
                        ->where('subject_id', $subject->id)
                        ->count();
                    @endphp

                    @if($chapterCount)
                      <span class="badge bg-primary ms-auto">
                        {{ $chapterCount }} Chapters
                      </span>
                    @else
                      <span class="badge bg-info ms-auto">
                        Subject Wise
                      </span>
                    @endif

                  </div>

                </div>

              @empty
              @endforelse

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gradient Patti (Price + Buy + Quick Info) -->
  <section class="study-detail-quick-patti">
    <div class="container">
      <div class="row align-items-center justify-content-between">
        <div class="col-lg-8 col-md-6">
          <div class="d-flex flex-wrap gap-4 quick-patti-item">
            <div>Type: <strong>Study Material</strong></div>
            <div>Format: <strong>{{ $studyMaterial->is_pdf_downloadable ? 'PDF' : 'Online Notes' }}</strong></div>
            <div>Updated: <strong>{{ \Carbon\Carbon::parse($studyMaterial->updated_at)->format('M d, Y') }}</strong></div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 text-lg-end text-md-center mt-3 mt-md-0">
          @php
            $isLoggedIn = auth()->check();
            $hasPurchased = $isLoggedIn && \App\Helpers\Helper::GetStudentOrder('Study Material', $studyMaterial->id, auth()->id());

            $canAccess = $isLoggedIn && (!$studyMaterial->IsPaid || $hasPurchased);
          @endphp

          @if($studyMaterial->IsPaid)
            <span class="quick-patti-item fw-bold me-3"></span>
          @else
            <span class="quick-patti-item fw-bold text-success me-3"></span>
          @endif

          @if($canAccess)
            @if($studyMaterial->is_pdf_downloadable)
              <a href="{{ route('study.material.download', $studyMaterial->id) }}" class="study-detail-buy-btn">
                Download PDF
              </a>
            @else
              <button class="study-detail-buy-btn" disabled>Unlocked</button>
            @endif
          @else
            @auth
              <a href="{{ route('user.process-order', ['type' => 'study-material', 'id' => $studyMaterial->id]) }}"
                class="study-detail-buy-btn">
                Buy Now - ₹{{ $studyMaterial->price }}
              </a>
            @else
              <button class="study-detail-buy-btn" href="{{route('student.login')}}">
                Login to Unlock{{ $studyMaterial->IsPaid ? ' - ₹' . $studyMaterial->price : ''}}
              </button>
            @endauth
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="study-detail-content py-5 bg-white">
    <div class="container">
      <div class="row g-5">
        <!-- Left: Content -->
        <div class="col-lg-8">
          <div class="study-content border rounded-3 p-3 p-sm-3 p-md-4 p-lg-5 shadow-sm bg-white">
            @if($canAccess)
              {!! $studyMaterial->detail_content !!}
            @else
              <div class="preview-blur">
                {{ Str::limit(strip_tags($studyMaterial->detail_content), 1200) }}
              </div>
              <div class="unlock-box text-center py-5 mt-5">
                <h4 class="text-muted mb-4">Full Content is Locked</h4>
                <p class="text-muted mb-4">Purchase to unlock complete notes</p>
                @auth
                  <a href="{{ route('user.process-order', ['type' => 'study-material', 'id' => $studyMaterial->id]) }}"
                    class="study-detail-buy-btn px-5 py-3">
                    Unlock Now - ₹{{ $studyMaterial->price }}
                  </a>
                @else
                  <button class="study-detail-buy-btn px-5 py-3" href="{{route('student.login')}}">
                     Login to Unlock{{ $studyMaterial->IsPaid ? ' - ₹' . $studyMaterial->price : ''}}
                  </button>
                @endauth
              </div>
            @endif
          </div>

          <!-- Sections -->
          @if($canAccess && $studyMaterial->sections->count())
            <div class="mt-5 sections-accordion-container">
              <h3 class="mb-4 fw-bold text-center text-md-start">Sections / Modules</h3>

              <div class="accordion custom-accordion" id="sectionsAccordion">
                @foreach($studyMaterial->sections as $section)
                  <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                    <h2 class="accordion-header" id="heading-{{ $section->id }}">
                      <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $section->id }}" aria-expanded="false"
                        aria-controls="collapse-{{ $section->id }}">

                        <div
                          class="d-flex flex-column flex-md-column justify-content-between align-items-md-start w-100 pe-3">
                          <span class="section-title">{{ $section->title }}</span>

                          <span class="short-desc d-none d-md-inline text-muted ">
                            {{ Str::limit(strip_tags($section->description), 45, '...') }}
                          </span>
                        </div>
                      </button>
                    </h2>

                    <div id="collapse-{{ $section->id }}" class="accordion-collapse collapse"
                      aria-labelledby="heading-{{ $section->id }}" data-bs-parent="#sectionsAccordion">
                      <div class="accordion-body bg-light-subtle">
                        {!! $section->description !!}
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>

        <!-- Right: Related Materials -->
        <div class="col-lg-4">
          <div class="related-materials">
            <h4 class="mb-4 fw-bold">Related Study Materials</h4>
            @forelse($relatedMaterials as $material)
              <div class="related-item">
                <a href="{{ route('study.material.details', $material->id) }}" class="d-block mb-2">
                  <strong>{{ Str::limit($material->title, 45) }}</strong>
                </a>
                <p class="small text-muted mb-2">
                  {{ Str::limit($material->short_description, 70) }}
                </p>
                <div>
                  @if($material->IsPaid)
                    <span class="badge bg-warning text-dark related-badge">Premium</span>
                  @else
                    <span class="badge bg-success related-badge">Free</span>
                  @endif
                  @if($material->is_pdf_downloadable)
                    <span class="badge bg-info ms-2 related-badge">PDF</span>
                  @endif
                </div>
              </div>
            @empty
              <p class="text-muted">No related materials</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection