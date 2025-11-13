@extends('layouts.app')

@section('title')
Daily Booster || View
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title">View</h5>
                    <h6 class="card-subtitle mb-2 text-muted">View Daily Booster details here.</h6>
                </div>
                <div>
                    <a href="{{ route('daily.boost.edit', $dailyBooster->id) }}" class="btn btn-sm btn-primary me-2">
                        <i class="fa fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('daily.boost.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="row">
                <!-- Title -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Title:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->title ?? '--' }}</p>
                </div>

                <!-- Start Date -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Start Date:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->start_date ? date('d M Y', strtotime($dailyBooster->start_date)) : '--' }}</p>
                </div>

                <!-- YouTube URL -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">YouTube URL:</label>
                    @if($dailyBooster->youtube_url)
                        <a href="{{ $dailyBooster->youtube_url }}" target="_blank" class="d-block text-primary">
                            {{ $dailyBooster->youtube_url }}
                        </a>
                    @else
                        <p class="form-control-plaintext">--</p>
                    @endif
                </div>

                <!-- Short Description -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Short Description:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->short_description ?? '--' }}</p>
                </div>

                <!-- Description -->
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Description:</label>
                    <div class="border rounded p-3 bg-white">
                        {!! $dailyBooster->detail_content ?? '<p class="text-muted">--</p>' !!}
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Thumbnail:</label><br>
                    @if($dailyBooster->thumbnail)
                        <img src="{{ asset('storage/' . $dailyBooster->thumbnail) }}" 
                             alt="{{ $dailyBooster->image_alt_tag ?? 'Thumbnail' }}" 
                             class="rounded border shadow-sm" 
                             style="width:150px; height:auto; object-fit:contain;">
                    @else
                        <p class="form-control-plaintext">--</p>
                    @endif
                </div>

                <!-- Image Alt Tag -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Image Alt Tag:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->image_alt_tag ?? '--' }}</p>
                </div>

                <!-- Meta Title -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Meta Title:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->meta_title ?? '--' }}</p>
                </div>

                <!-- Meta Keyword -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Meta Keyword:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->meta_keyword ?? '--' }}</p>
                </div>

                <!-- Meta Description -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Meta Description:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->meta_description ?? '--' }}</p>
                </div>

                <!-- Created / Updated -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Created At:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->created_at ? $dailyBooster->created_at->format('d M Y, h:i A') : '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Updated At:</label>
                    <p class="form-control-plaintext">{{ $dailyBooster->updated_at ? $dailyBooster->updated_at->format('d M Y, h:i A') : '--' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
