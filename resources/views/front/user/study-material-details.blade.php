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
    /* Clean & Premium Study Material Details - Final Fixed Version */
    .study-detail-banner {
      background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 100%);
      padding: 60px 0 80px;
      position: relative;
    }

    .study-detail-title {
      font-size: 2.8rem;
      font-weight: 900;
      color: #1e293b;
      margin-bottom: 1rem;
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
      box-shadow: 0 4px 15px rgba(255,255,255,0.3);
      border: none;
    }

    .study-detail-buy-btn:hover {
      background: #f0fdf4;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(255,255,255,0.4);
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
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
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
    
    .wd-social-icons{
        display:none !important;
    }
  </style>

  <!-- Banner Patti (Simple Info) -->
  <section class="study-detail-banner">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12" style="padding:0px 50px;">
          <h1 class="study-detail-title">{{ $studyMaterial->title }}</h1>
          <p class="study-detail-short">{{ $studyMaterial->short_description }}</p>

          <div class="study-detail-meta">
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
            $hasPurchased = auth()->check() && \App\Helpers\Helper::GetStudentOrder('Study Material', $studyMaterial->id, auth()->id());
            $canAccess = !$studyMaterial->IsPaid || $hasPurchased;
          @endphp

          @if($studyMaterial->IsPaid)
            <span class="quick-patti-item fw-bold me-3"></span>
          @else
            <span class="quick-patti-item fw-bold text-success me-3"></span>
          @endif

          @if($canAccess)
            @if($studyMaterial->is_pdf_downloadable)
              <a href="{{ route('study.material.download', $studyMaterial->id) }}" 
                 class="study-detail-buy-btn">
                Download PDF
              </a>
            @else
              <button class="study-detail-buy-btn" disabled>Unlocked</button>
            @endif
          @else
            @auth
              <a href="{{ route('user.process-order', ['type'=>'study-material','id'=>$studyMaterial->id]) }}" 
                 class="study-detail-buy-btn">
                Buy Now - ₹{{ $studyMaterial->price }}
              </a>
            @else
              <button class="study-detail-buy-btn" data-bs-toggle="modal" data-bs-target="#lr">
                Login to Buy
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
          <div class="study-content border rounded-3 p-5 shadow-sm bg-white">
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
                  <a href="{{ route('user.process-order', ['type'=>'study-material','id'=>$studyMaterial->id]) }}" 
                     class="study-detail-buy-btn px-5 py-3">
                    Unlock Now - ₹{{ $studyMaterial->price }}
                  </a>
                @else
                  <button class="study-detail-buy-btn px-5 py-3" data-bs-toggle="modal" data-bs-target="#lr">
                    Login to Unlock
                  </button>
                @endauth
              </div>
            @endif
          </div>

          <!-- Sections -->
          @if($canAccess && $studyMaterial->sections->count())
            <div class="mt-5 border rounded-3 p-5 shadow-sm bg-white">
              <h3 class="mb-4 fw-bold">Sections</h3>
              @foreach($studyMaterial->sections as $section)
                <div class="mb-5 pb-4 border-bottom">
                  <h4 class="mb-3">{{ $section->title }}</h4>
                  {!! $section->description !!}
                </div>
              @endforeach
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