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
                @if($studyMaterial->subject)
                <li><b>Subject:</b> {{ $studyMaterial->subject->name }}</li>@endif
                @if($studyMaterial->chapter)
                <li><b>Chapter:</b> {{ $studyMaterial->chapter->name }}</li>@endif
                @if($studyMaterial->topic)
                <li><b>Topic:</b> {{ $studyMaterial->topic->name }}</li>@endif
              </ul>

              <!-- Short Description (full, no toggle) -->
              @if($studyMaterial->short_description)
                <p>{{ $studyMaterial->short_description }}</p>
              @endif
            </div>

            <!-- Detail Content -->
            <div class="detail-content p-3 border rounded mb-3">
              @php $contentLength = strlen($studyMaterial->detail_content); @endphp

              @if(auth()->user())
                @if($studyMaterial->IsPaid == 0 || Helper::GetStudentOrder('Study Material', $studyMaterial->id, auth()->user()->id))
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


            <!-- PDF Download -->
            <div class="pdf-nt mt-3">
              @if($studyMaterial->is_pdf_downloadable)
                @if(auth()->user())
                  @if($studyMaterial->IsPaid == 0 || Helper::GetStudentOrder('Study Material', $studyMaterial->id, auth()->user()->id))
                    <a class="osd-cus s" href="{{ route('study.material.download', $studyMaterial->id) }}"
                      download="{{ $studyMaterial->topic }}">Download PDF</a>
                  @else
                    <a class="osd-cus s" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#lr">
                      Download PDF
                    </a>
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
              <h4>Related Study Materials</h4>
              <div class="related-list">
                @forelse($relatedMaterials as $material)
                  <div class="related-item mb-3 border rounded p-2 d-flex">
                    {{-- Banner --}}
                    @if($material->banner)
                      <div class="related-img me-2" style="flex-shrink:0;">
                        <img src="{{ url('storage/' . $material->banner) }}" alt="{{ $material->title }}"
                          style="width:80px; height:80px; object-fit:cover;">
                      </div>
                    @endif

                    {{-- Content --}}
                    <div class="related-content">
                      <h5 class="mb-1">
                        <a href="{{ route('study.material.details', $material->id) }}">
                          {{ $material->title }}
                          @if($material->IsPaid)
                            <span class="label-red">Paid</span>
                          @endif
                        </a>
                      </h5>
                      @if($material->short_description)
                        <p class="mb-1" style="font-size:0.9rem;">
                          {{ Str::limit($material->short_description, 60) }}
                        </p>
                      @endif
                      <a href="{{ route('study.material.details', $material->id) }}"
                        class="btn btn-sm btn-outline-primary">View More</a>
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