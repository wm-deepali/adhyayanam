@extends('front.partials.app')
@section('header')
  <title>{{$studyMaterial->meta_title}}</title>
  <meta name="description" content="{{ $studyMaterial->meta_description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $studyMaterial->meta_keywords ?? 'default, keywords' }}">
@endsection
@section('content')
  <style>
    .collapse-content {
      max-height: 0px;
      /* Adjust the max-height as needed */
      overflow: hidden;
      transition: max-height 0.5s ease;
    }

    .collapse-content.expanded {
      max-height: none;
    }

    .related-materials h4 {
      font-size: 18px;
      border-bottom: 2px solid #eee;
      padding-bottom: 8px;
    }

    .related-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      transition: all 0.3s ease;
      border: 1px solid #eee;
    }

    .related-card:hover {
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      transform: translateY(-3px);
    }

    .related-thumb {
      width: 100%;
      height: 120px;
      overflow: hidden;
      border-radius: 8px;
      position: relative;
    }

    .related-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .paid-badge {
      position: absolute;
      top: 6px;
      left: 6px;
      background: #d9534f;
      color: #fff;
      padding: 2px 8px;
      font-size: 12px;
      border-radius: 4px;
    }

    .related-title {
      font-size: 15px;
      font-weight: 600;
      line-height: 1.3;
    }

    .related-title a {
      color: #333;
      text-decoration: none;
    }

    .related-title a:hover {
      color: #0069d9;
    }

    .related-desc {
      font-size: 13px;
      color: #666;
    }

    .related-btn {
      font-size: 13px;
      text-decoration: none;
      font-weight: 600;
      color: #0069d9;
    }
  </style>

  <body class="hidden-bar-wrapper">
    <!-- Page Title -->
    <section class="page-title">
      <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
          <li><a href="{{url('/')}}">Home</a></li>
          <li>{{$studyMaterial->title}} Details</li>
        </ul>
      </div>
    </section>
    <!-- End Page Title -->
    <section class="course-page-section-two">
      <div class="auto-container">
        <div class="row clearfix">

          <!-- Left Column: 9/12 -->
          <!-- Left Column: 9/12 -->
          <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="top-banner-sm mb-3">
              <div class="image">
                @if($studyMaterial->banner)
                  <img src="{{ url('storage/' . $studyMaterial->banner) }}" alt="{{ $studyMaterial->title }}"
                    style="width:100%; height:auto;">
                @endif
                @if($studyMaterial->IsPaid)
                  <div class="label-red">Paid</div>
                @endif
              </div>
            </div>

            <!-- Content Card -->
            <div class="smaterial-boxs p-3 border rounded mb-3">
              <h3>{{ $studyMaterial->title }}</h3>

              <!-- Metadata -->
              <ul class="study-meta mb-2">
                @if($studyMaterial->commission)
                <li><b>Commission:</b> {{ $studyMaterial->commission->name }}</li>@endif
                @if($studyMaterial->category)
                <li><b>Category:</b> {{ $studyMaterial->category->name }}</li>@endif
                @if($studyMaterial->subcategory)
                <li><b>Subcategory:</b> {{ $studyMaterial->subcategory->name }}</li>@endif

                {{-- Multiple Subjects --}}
                @if($studyMaterial->subjects->count())
                  <li><b>Subjects:</b>
                    {{ $studyMaterial->subjects->pluck('name')->implode(', ') }}
                  </li>
                @endif

                {{-- Multiple Chapters --}}
                @if($studyMaterial->chapters->count())
                  <li><b>Chapters:</b>
                    {{ $studyMaterial->chapters->pluck('name')->implode(', ') }}
                  </li>
                @endif

                {{-- Multiple Topics --}}
                @if($studyMaterial->topics->count())
                  <li><b>Topics:</b>
                    {{ $studyMaterial->topics->pluck('name')->implode(', ') }}
                  </li>
                @endif
              </ul>
              <li><b>Language:</b> {{ $studyMaterial->language }}</li>

              <!-- Short Description (full, no toggle) -->
              @if($studyMaterial->short_description)
                <p>{{ $studyMaterial->short_description }}</p>
              @endif
            </div>

            <!-- Detail Content -->
            <div class="detail-content p-3 border rounded mb-3">
              @php $contentLength = strlen($studyMaterial->detail_content); @endphp

              @if(auth()->user())
                @php
                  $user_id = auth()->user()->id;
                  $package_id = $studyMaterial->id;
                  $type = 'Study Material';
                  $checkExist = App\Helpers\Helper::GetStudentOrder($type, $package_id, $user_id)
                @endphp
                @if($studyMaterial->IsPaid == 0 || $checkExist)
                  {{-- User logged in and allowed to view content --}}
                  @if($contentLength > 300)
                    {!! Str::limit($studyMaterial->detail_content, 300, '') !!}
                    <span id="dots-{{ $studyMaterial->id }}">...</span>
                    <span id="more-{{ $studyMaterial->id }}" style="display: none;">
                      {!! substr($studyMaterial->detail_content, 300) !!}
                    </span>
                    <div class="col-12 d-flex justify-content-center mt-3">
                      <button type="button" class="btn btn-secondary" onclick="loadMore({{ $studyMaterial->id }})">
                        Read More
                      </button>
                    </div>
                  @else
                    {!! $studyMaterial->detail_content !!}
                  @endif
                @else
                  {{-- Paid content not purchased --}}
                  {!! Str::limit($studyMaterial->detail_content, 300, '') !!}
                  @if($contentLength > 300)
                    <span id="dots-{{ $studyMaterial->id }}">...</span>
                    <span id="more-{{ $studyMaterial->id }}" style="display: none;">
                      {!! substr($studyMaterial->detail_content, 300) !!}
                    </span>
                    <div class="col-12 d-flex justify-content-center mt-3">
                      <a href="{{ route('user.process-order', ['type' => 'study-material', 'id' => $studyMaterial->id]) }}"
                        class="btn btn-primary">Buy Now - &#8377;{{ $studyMaterial->price }}</a>
                    </div>
                  @endif
                @endif
              @else
                {{-- Not logged in --}}
                {!! Str::limit($studyMaterial->detail_content, 300, '') !!}
                @if($contentLength > 300)
                  <span id="dots-{{ $studyMaterial->id }}">...</span>
                  <span id="more-{{ $studyMaterial->id }}" style="display: none;">
                    {!! substr($studyMaterial->detail_content, 300) !!}
                  </span>
                  <div class="col-12 d-flex justify-content-center mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#lr">
                      Read More
                    </button>
                  </div>
                @endif
              @endif
            </div>

            <!-- 🔥 SECTIONS ADDED HERE -->
            @if($studyMaterial->sections->count())
              <div class="p-3 border rounded mb-3">
                <h4 class="mb-3">Sections</h4>

                @foreach($studyMaterial->sections as $section)
                  <div class="section-block">
                    <h5><b>{{ $section->title }}</b></h5>

                    @if($section->description)
                      <div>{!! $section->description !!}</div>
                    @endif
                  </div>
                @endforeach
              </div>
            @endif
            <!-- END SECTIONS -->

            <!-- PDF Download -->
            <div class="pdf-nt mt-3">
              @if($studyMaterial->is_pdf_downloadable)
                @if(auth()->user() && auth()->user()->email != '' && auth()->user()->type == 'student')
                  @php
                    $user_id = auth()->user()->id;
                    $package_id = $studyMaterial->id;
                    $type = 'Study Material';
                    $checkExist = App\Helpers\Helper::GetStudentOrder($type, $package_id, $user_id)
                  @endphp
                  @if($studyMaterial->IsPaid == 0 || $checkExist)
                    <a class="osd-cus s" href="{{ route('study.material.download', $studyMaterial->id) }}"
                      download="{{ $studyMaterial->topic }}">Download PDF</a>
                  @else
                    <div class="col-12 d-flex justify-content-center mt-3">
                      <a href="{{ route('user.process-order', ['type' => 'study-material', 'id' => $studyMaterial->id]) }}"
                        class="btn btn-primary">Buy Now - &#8377;{{ $studyMaterial->price }}</a>
                    </div>
                  @endif
                @else
                  {{-- Not logged in --}}
                  <a class="osd-cus s" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#lr">
                    Download PDF
                  </a>
                @endif
              @endif
            </div>

          </div>

          <!-- Right Column: 3/12 -->
          <div class="col-lg-3 col-md-12 col-sm-12">

            <div class="related-materials">
              <h4 class="mb-3" style="font-weight:600;">Related Study Materials</h4>

              <div class="related-list">

                @forelse($relatedMaterials as $material)
                  <div class="related-card mb-3 p-2">

                    {{-- Banner --}}
                    <a href="{{ route('study.material.details', $material->id) }}" class="d-block">
                      <div class="related-thumb">
                        <img src="{{ url('storage/' . $material->banner) }}" alt="{{ $material->title }}">
                        @if($material->IsPaid)
                          <span class="paid-badge">Paid</span>
                        @endif
                      </div>
                    </a>

                    {{-- Content --}}
                    <div class="related-card-body mt-2">
                      <h5 class="related-title mb-1">
                        <a href="{{ route('study.material.details', $material->id) }}">
                          {{ Str::limit($material->title, 40) }}
                        </a>
                      </h5>

                      @if($material->short_description)
                        <p class="related-desc mb-2">
                          {{ Str::limit($material->short_description, 60) }}
                        </p>
                      @endif

                      <a href="{{ route('study.material.details', $material->id) }}" class="related-btn">
                        View Details →
                      </a>
                    </div>

                  </div>
                @empty
                  <p>No related materials found.</p>
                @endforelse

              </div>
            </div>

          </div>

        </div>
      </div>
    </section>

    <script>
      function loadMore(id) {
        const dots = document.getElementById("dots-" + id);
        const moreText = document.getElementById("more-" + id);
        const btn = document.getElementById("read-more-btn");

        if (moreText.style.display === "none") {
          moreText.style.display = "inline";
          dots.style.display = "none";
          btn.textContent = 'Read Less';
        } else {
          moreText.style.display = "none";
          dots.style.display = "inline";
          btn.textContent = 'Read More';
        }
      }
    </script>

@endsection