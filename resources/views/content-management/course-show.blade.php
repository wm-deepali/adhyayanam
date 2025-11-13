@extends('layouts.app')

@section('title', 'View | Course')

@section('content')
<div class="bg-light rounded p-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">View Course</h5>
                    <small class="text-muted">Detailed information about the course.</small>
                </div>
                <div>
                    <a href="{{ route('courses.course.edit', $course->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('courses.course.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            @include('layouts.includes.messages')

            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <strong>Feature:</strong>
                    <p>{{ $course->feature == 'on' ? 'Enabled' : 'Disabled' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Course Mode:</strong>
                    <p>{{ $course->course_mode ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Course Type:</strong>
                    <p>{{ $course->examinationCommission->name ?? '--' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Category:</strong>
                    <p>{{ $course->category->name ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Sub Category:</strong>
                    <p>{{ $course->subCategory->name ?? '--' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Course Name:</strong>
                    <p>{{ $course->name ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Subjects:</strong>
                    <p>
                        @forelse($subjects as $subject)
                            @if(in_array($subject->id, $course->subject_id ?? []))
                                <span class="badge bg-info text-light me-1">{{ $subject->name }}</span>
                            @endif
                        @empty
                            --
                        @endforelse
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Chapters:</strong>
                    <p>
                        @forelse($chapters as $chapter)
                            @if(in_array($chapter->id, $course->chapter_id ?? []))
                                <span class="badge bg-secondary me-1">{{ $chapter->name }}</span>
                            @endif
                        @empty
                            --
                        @endforelse
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Topics:</strong>
                    <p>
                        @forelse($topics as $topic)
                            @if(in_array($topic->id, $course->topic_id ?? []))
                                <span class="badge bg-success me-1">{{ $topic->name }}</span>
                            @endif
                        @empty
                            --
                        @endforelse
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Based On:</strong>
                    <p>{{ $course->based_on ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Duration:</strong>
                    <p>{{ $course->duration ?? '--' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Course Fee:</strong>
                    <p>{{ $course->course_fee ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Discount:</strong>
                    <p>{{ $course->discount ?? '--' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Offered Price:</strong>
                    <p>{{ $course->offered_price ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>No. of Classes:</strong>
                    <p>{{ $course->num_classes ?? '--' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>No. of Topics:</strong>
                    <p>{{ $course->num_topics ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Languages:</strong>
                    <p>
                        @if(!empty($course->language_of_teaching))
                            @foreach((array)$course->language_of_teaching as $lang)
                                <span class="badge bg-warning text-dark me-1">{{ $lang }}</span>
                            @endforeach
                        @else
                            --
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Course Heading:</strong>
                    <p>{{ $course->course_heading ?? '--' }}</p>
                </div>

                <div class="col-12 mb-3">
                    <strong>Short Description:</strong>
                    <p class="text-muted">{{ $course->short_description ?? '--' }}</p>
                </div>
            </div>

            {{-- Image Section --}}
            <div class="row g-3 mb-4 text-center">
                <div class="col-md-6">
                    <div class="border rounded p-3 bg-white h-100">
                        <strong>Thumbnail Image:</strong><br>
                        @if($course->thumbnail_image)
                            <img src="{{ asset('storage/' . $course->thumbnail_image) }}" 
                                 class="img-fluid mt-2 rounded shadow-sm" style="max-height: 150px; object-fit: contain;">
                        @else
                            <p class="mt-3 text-muted">--</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 bg-white h-100">
                        <strong>Banner Image:</strong><br>
                        @if($course->banner_image)
                            <img src="{{ asset('storage/' . $course->banner_image) }}" 
                                 class="img-fluid mt-2 rounded shadow-sm" style="max-height: 150px; object-fit: contain;">
                        @else
                            <p class="mt-3 text-muted">--</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="mb-4">
                <strong>Course Overview:</strong>
                <div class="border rounded bg-white p-3 mt-2">{!! $course->course_overview ?? '--' !!}</div>
            </div>

            <div class="mb-4">
                <strong>Detail Content:</strong>
                <div class="border rounded bg-white p-3 mt-2">{!! $course->detail_content ?? '--' !!}</div>
            </div>

            {{-- Meta Section --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Youtube URL:</strong>
                    <p>
                        @if($course->youtube_url)
                            <a href="{{ $course->youtube_url }}" target="_blank">{{ $course->youtube_url }}</a>
                        @else
                            --
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Meta Title:</strong>
                    <p>{{ $course->meta_title ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Meta Keywords:</strong>
                    <p>{{ $course->meta_keyword ?? '--' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Meta Description:</strong>
                    <p>{{ $course->meta_description ?? '--' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Alt Tag:</strong>
                    <p>{{ $course->image_alt_tag ?? '--' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
