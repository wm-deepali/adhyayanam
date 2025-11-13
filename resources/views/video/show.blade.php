@extends('layouts.app')

@section('title', 'View Video / Live Class')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

<div class="bg-light rounded">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <div>
                    <h5 class="card-title mb-1 font-weight-bold">View Details</h5>
                    <small class="text-muted">Details for {{ ucfirst($video->type ?? 'Video') }}</small>
                </div>
                <div>
                    <a href="{{ route('video.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('video.edit', $video->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <div class="row">
                {{-- Type --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Type:</label>
                    <div class="text-muted">{{ ucfirst($video->type) ?? '--' }}</div>
                </div>

                {{-- Examination Commission --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Examination Commission:</label>
                    <div class="text-muted">{{ $video->examinationCommission->name ?? '--' }}</div>
                </div>

                {{-- Course Category --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Course Category:</label>
                    <div class="text-muted">{{ $video->category->name ?? '--' }}</div>
                </div>

                {{-- Sub Category --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Sub Category:</label>
                    <div class="text-muted">{{ $video->subCategory->name ?? '--' }}</div>
                </div>

                {{-- Course --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Course:</label>
                    <div class="text-muted">{{ $video->course->name ?? '--' }}</div>
                </div>

                {{-- Subject --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Subject:</label>
                    <div class="text-muted">{{ $video->subject->name ?? '--' }}</div>
                </div>

                {{-- Chapter --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Chapter:</label>
                    <div class="text-muted">{{ $video->chapter->name ?? '--' }}</div>
                </div>

                {{-- Topic --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Topic:</label>
                    <div class="text-muted">{{ $video->topic->name ?? '--' }}</div>
                </div>

                {{-- Title --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Title:</label>
                    <div class="text-dark">{{ $video->title ?? '--' }}</div>
                </div>

                {{-- Slug (for videos only) --}}
                @if($video->type == 'video')
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Slug:</label>
                        <div class="text-muted">{{ $video->slug ?? '--' }}</div>
                    </div>
                @endif

                {{-- Video / Live Details --}}
                @if($video->type == 'video')
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Video Type:</label>
                        <div class="text-muted">{{ $video->video_type ?? '--' }}</div>
                    </div>

                    @if($video->video_type == 'Storage')
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Video File:</label><br>
                            @if($video->video_file)
                                <a href="{{ asset('storage/'.$video->video_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-play-circle"></i> View Video
                                </a>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </div>
                    @else
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Video URL:</label><br>
                            @if($video->video_url)
                                <a href="{{ $video->video_url }}" target="_blank">{{ $video->video_url }}</a>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Duration:</label>
                        <div class="text-muted">{{ $video->duration ?? '--' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Access Till:</label>
                        <div class="text-muted">{{ $video->access_till ?? '--' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">No. of Times Can View:</label>
                        <div class="text-muted">{{ $video->no_of_times_can_view ?? '--' }}</div>
                    </div>
                @else
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Schedule Date:</label>
                        <div class="text-muted">{{ $video->schedule_date ?? '--' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Start Time:</label>
                        <div class="text-muted">{{ $video->start_time ?? '--' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">End Time:</label>
                        <div class="text-muted">{{ $video->end_time ?? '--' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Teacher:</label>
                        <div class="text-muted">{{ $video->teacher->full_name ?? '--' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Live Class Link:</label><br>
                        @if($video->live_link)
                            <a href="{{ $video->live_link }}" target="_blank">{{ $video->live_link }}</a>
                        @else
                            <span class="text-muted">--</span>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Images Section --}}
            <div class="mt-4">
                <h6 class="font-weight-bold border-bottom pb-2 mb-3">Media</h6>
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 bg-white shadow-sm h-100">
                            <strong>Thumbnail Image:</strong><br>
                            @if($video->image)
                                <img src="{{ asset('storage/'.$video->image) }}" class="img-fluid mt-2 rounded" style="max-height: 160px; object-fit: contain;">
                            @else
                                <p class="mt-3 text-muted">--</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 bg-white shadow-sm h-100">
                            <strong>Cover Image:</strong><br>
                            @if($video->cover_image)
                                <img src="{{ asset('storage/'.$video->cover_image) }}" class="img-fluid mt-2 rounded" style="max-height: 160px; object-fit: contain;">
                            @else
                                <p class="mt-3 text-muted">--</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 bg-white shadow-sm h-100">
                            <strong>Assignment:</strong><br>
                            @if($video->assignment)
                                <img src="{{ asset('storage/'.$video->assignment) }}" class="img-fluid mt-2 rounded" style="max-height: 160px; object-fit: contain;">
                            @else
                                <p class="mt-3 text-muted">--</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Status:</label><br>
                    @if($video->status == 'active')
                        <span class="badge badge-success px-2 py-1">Active</span>
                    @else
                        <span class="badge badge-danger px-2 py-1">Inactive</span>
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <div class="mt-3">
                <label class="font-weight-bold">Content:</label>
                <div class="border p-3 rounded bg-white shadow-sm">
                    {!! $video->content ?? '--' !!}
                </div>
            </div>

            <div class="mt-4 text-right">
                <form action="{{ route('video.destroy', $video->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this video?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
