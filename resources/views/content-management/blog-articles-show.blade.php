@extends('layouts.app')

@section('title')
    View Blog
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Blog Details</h5>
                    <h6 class="card-subtitle text-muted">View blog & article information</h6>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <hr>

            {{-- Content --}}
            <div class="row">

                <div class="col-md-12 mb-3">
                    <strong>Heading</strong>
                    <div class="border rounded p-2 bg-white">
                        {{ $blog->heading }}
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <strong>Short Description</strong>
                    <div class="border rounded p-2 bg-white">
                        {{ $blog->short_description ?? '--' }}
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <strong>Description</strong>
                    <div class="border rounded p-3 bg-white">
                        {!! $blog->description !!}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Type</strong>
                    <div>{{ $blog->type ?? '--' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Added By</strong>
                    <div>{{ $blog->user->name ?? 'N/A' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Image</strong><br>
                    @if($blog->image)
                        <img src="{{ asset('storage/'.$blog->image) }}"
                             class="img-thumbnail mt-2"
                             style="max-width: 200px;">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Thumbnail</strong><br>
                    @if($blog->thumbnail)
                        <img src="{{ asset('storage/'.$blog->thumbnail) }}"
                             class="img-thumbnail mt-2"
                             style="max-width: 200px;">
                    @else
                        <span class="text-muted">No thumbnail</span>
                    @endif
                </div>

                <div class="col-md-12 mt-3 text-muted">
                    <small>
                        Created on {{ $blog->created_at->format('d M Y, h:i A') }}
                    </small>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection