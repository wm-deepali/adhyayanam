@extends('front.partials.app')

@section('header')
    <title>{{ $studyMaterial->meta_title }}</title>
    <meta name="description" content="{{ $studyMaterial->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $studyMaterial->meta_keywords ?? '' }}">
@endsection

@section('content')

<style>
    .study-content {
        font-size: 16px;
        line-height: 1.75;
        color: #333;
    }
    .study-content img {
        max-width: 100%;
        height: auto;
    }
    .preview-box {
        max-height: 240px;
        overflow: hidden;
        position: relative;
    }
    .preview-overlay {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 120px;
        background: linear-gradient(transparent, #fff);
    }
</style>

@php
    $hasPurchased = false;

    if(auth()->check()){
        $hasPurchased = \App\Helpers\Helper::GetStudentOrder(
            'Study Material',
            $studyMaterial->id,
            auth()->id()
        );
    }

    $canViewFull = $studyMaterial->IsPaid == 0 || $hasPurchased;
@endphp

<section class="page-title">
    <div class="auto-container">
        <h2>Study Material</h2>
        <ul class="bread-crumb clearfix">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>{{ $studyMaterial->title }}</li>
        </ul>
    </div>
</section>

<section class="course-page-section-two">
    <div class="auto-container">
        <div class="row clearfix">

            <!-- LEFT CONTENT -->
            <div class="col-lg-9">

                {{-- Banner --}}
                @if($studyMaterial->banner)
                    <img src="{{ asset('storage/'.$studyMaterial->banner) }}"
                         alt="{{ $studyMaterial->title }}"
                         class="img-fluid mb-3">
                @endif

                {{-- Price Box --}}
                @if($studyMaterial->IsPaid)
                    <div class="alert alert-warning d-flex justify-content-between align-items-center">
                        <strong>Paid Study Material</strong>
                        <span class="fs-5 fw-bold">₹ {{ $studyMaterial->price }}</span>
                    </div>
                @endif

                {{-- Title --}}
                <div class="p-3 border rounded mb-3">
                    <h3>{{ $studyMaterial->title }}</h3>

                    @if($studyMaterial->short_description)
                        <p>{{ $studyMaterial->short_description }}</p>
                    @endif
                </div>

                {{-- MAIN CONTENT --}}
                <div class="p-3 border rounded mb-3 study-content">

                    @if($canViewFull)
                        {!! $studyMaterial->detail_content !!}
                    @else
                        <div class="preview-box">
                            {{ Str::limit(strip_tags($studyMaterial->detail_content), 300) }}
                            <div class="preview-overlay"></div>
                        </div>

                        <div class="text-center mt-3">
                            @auth
                                <a href="{{ route('user.process-order',['type'=>'study-material','id'=>$studyMaterial->id]) }}"
                                   class="btn btn-primary">
                                    Buy Now – ₹{{ $studyMaterial->price }}
                                </a>
                            @else
                                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#lr">
                                    Login to Unlock
                                </button>
                            @endauth
                        </div>
                    @endif

                </div>

                {{-- SECTIONS (PAID PROTECTED) --}}
                @if($canViewFull && $studyMaterial->sections->count())
                    <div class="p-3 border rounded mb-3">
                        <h4>Sections</h4>

                        @foreach($studyMaterial->sections as $section)
                            <div class="mb-3">
                                <h5>{{ $section->title }}</h5>
                                {!! $section->description !!}
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- PDF DOWNLOAD --}}
                @if($studyMaterial->is_pdf_downloadable)
                    <div class="mt-3">
                        @if($canViewFull)
                            <a href="{{ route('study.material.download',$studyMaterial->id) }}"
                               class="btn btn-success">
                                Download PDF
                            </a>
                        @else
                            <div class="text-center">
                                <a href="{{ route('user.process-order',['type'=>'study-material','id'=>$studyMaterial->id]) }}"
                                   class="btn btn-primary">
                                    Buy to Download PDF
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

            </div>

            <!-- RIGHT SIDEBAR -->
            <div class="col-lg-3">
                <h5 class="mb-3">Related Materials</h5>

                @forelse($relatedMaterials as $material)
                    <div class="border rounded p-2 mb-3">
                        <a href="{{ route('study.material.details',$material->id) }}">
                            <strong>{{ Str::limit($material->title,40) }}</strong>
                        </a>
                        <p class="small text-muted">
                            {{ Str::limit($material->short_description,60) }}
                        </p>
                    </div>
                @empty
                    <p>No related materials</p>
                @endforelse
            </div>

        </div>
    </div>
</section>

@endsection
