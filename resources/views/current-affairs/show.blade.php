@extends('layouts.app')

@section('title')
View Current Affair
@endsection

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $currentAffair->title }}</h5>
            <small>{{ $currentAffair->topic->name ?? '-' }}</small>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Short Description:</strong>
                <p>{{ $currentAffair->short_description }}</p>
            </div>

            <div class="mb-3">
                <strong>Details:</strong>
                <div class="border p-2 rounded bg-light">
                    {!! $currentAffair->details !!}
                </div>
            </div>

            <div class="mb-3">
                <strong>Publishing Date:</strong>
                <p>{{ $currentAffair->publishing_date }}</p>
            </div>

            <div class="mb-3 row">
                <div class="col-md-4">
                    <strong>Thumbnail:</strong><br>
                    @if($currentAffair->thumbnail_image)
                        <img src="{{ asset('storage/' . $currentAffair->thumbnail_image) }}" class="img-fluid img-thumbnail mt-2">
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </div>
                <div class="col-md-4">
                    <strong>Banner:</strong><br>
                    @if($currentAffair->banner_image)
                        <img src="{{ asset('storage/' . $currentAffair->banner_image) }}" class="img-fluid img-thumbnail mt-2">
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </div>
                <div class="col-md-4">
                    <strong>PDF File:</strong><br>
                    @if($currentAffair->pdf_file)
                        <a href="{{ asset('storage/' . $currentAffair->pdf_file) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-file-pdf"></i> View PDF
                        </a>
                    @else
                        <span class="text-muted">No PDF uploaded</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <strong>Alt Tag:</strong> <span>{{ $currentAffair->image_alt_tag ?? '-' }}</span>
            </div>

            <div class="mb-3">
                <strong>Meta Title:</strong> <span>{{ $currentAffair->meta_title ?? '-' }}</span>
            </div>

            <div class="mb-3">
                <strong>Meta Keywords:</strong> <span>{{ $currentAffair->meta_keyword ?? '-' }}</span>
            </div>

            <div class="mb-3">
                <strong>Meta Description:</strong> <span>{{ $currentAffair->meta_description ?? '-' }}</span>
            </div>

            <a href="{{ route('current.affairs.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
