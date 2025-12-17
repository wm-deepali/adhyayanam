@extends('layouts.app')

@section('title', 'View | Course')

@section('content')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="bg-light rounded p-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <div>
                    <h5 class="card-title mb-1 font-weight-bold">View Course</h5>
                    <small class="text-muted">Complete course overview & structure</small>
                </div>
                <div class="d-flex gap-2">
                    @if(\App\Helpers\Helper::canAccess('manage_courses_edit'))
                        <a href="{{ route('courses.course.edit', $course->id) }}"
                           class="btn btn-sm btn-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    @endif
                    <a href="{{ route('courses.course.index') }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            @include('layouts.includes.messages')

            {{-- BASIC DETAILS --}}
            <div class="row mt-3">

                <div class="col-md-6 mb-3">
                    <strong>Feature:</strong>
                    <div class="text-muted">{{ $course->feature === 'on' ? 'Enabled' : 'Disabled' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Course Mode:</strong>
                    <div class="text-muted">{{ $course->course_mode ?? '--' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Examination Commission:</strong>
                    <div class="text-muted">{{ $course->examinationCommission->name ?? '--' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Category:</strong>
                    <div class="text-muted">{{ $course->category->name ?? '--' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Sub Category:</strong>
                    <div class="text-muted">{{ $course->subCategory->name ?? '--' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Course Name:</strong>
                    <div class="text-muted">{{ $course->name }}</div>
                </div>

                {{-- SUBJECTS --}}
                <div class="col-md-6 mb-3">
                    <strong>Subjects:</strong>
                    <div>
                        @forelse($subjects as $subject)
                            @if(in_array($subject->id, $course->subject_id ?? []))
                                <span class="badge bg-info text-light me-1 mb-1">
                                    {{ $subject->name }}
                                </span>
                            @endif
                        @empty
                            <span class="text-muted">--</span>
                        @endforelse
                    </div>
                </div>

                {{-- CHAPTERS (FIXED & ALWAYS VISIBLE) --}}
                <div class="col-md-6 mb-3">
                    <strong>Chapters:</strong>
                    <div>
                        @if(!empty($course->chapter_id))
                            @foreach($chapters as $chapter)
                                @if(in_array($chapter->id, $course->chapter_id))
                                    <span class="badge bg-secondary me-1 mb-1">
                                        {{ $chapter->name }}
                                    </span>
                                @endif
                            @endforeach
                        @else
                            <span class="text-muted">No chapters assigned</span>
                        @endif
                    </div>
                </div>

                {{-- TOPICS --}}
                <div class="col-md-6 mb-3">
                    <strong>Topics:</strong>
                    <div>
                        @if(!empty($course->topic_id))
                            @foreach($topics as $topic)
                                @if(in_array($topic->id, $course->topic_id))
                                    <span class="badge bg-success me-1 mb-1">
                                        {{ $topic->name }}
                                    </span>
                                @endif
                            @endforeach
                        @else
                            <span class="text-muted">--</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Based On:</strong>
                    <div class="text-muted">{{ $course->based_on ?? '--' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Duration:</strong>
                    <div class="text-muted">{{ $course->duration }} Weeks</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Course Fee:</strong>
                    <div class="text-muted">₹ {{ $course->course_fee }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Discount:</strong>
                    <div class="text-muted">{{ $course->discount }}%</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Offered Price:</strong>
                    <div class="text-muted">₹ {{ $course->offered_price }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>No. of Classes:</strong>
                    <div class="text-muted">{{ $course->num_classes }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>No. of Topics:</strong>
                    <div class="text-muted">{{ $course->num_topics }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Languages:</strong>
                    <div>
                        @foreach((array) $course->language_of_teaching as $lang)
                            <span class="badge bg-warning text-dark me-1">{{ $lang }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Course Heading:</strong>
                    <div class="text-muted">{{ $course->course_heading }}</div>
                </div>

                <div class="col-12 mb-3">
                    <strong>Short Description:</strong>
                    <div class="text-muted">{{ $course->short_description }}</div>
                </div>
            </div>

            {{-- IMAGES --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6 text-center">
                    <div class="border rounded p-3 bg-white">
                        <strong>Thumbnail Image</strong><br>
                        <img src="{{ asset('storage/'.$course->thumbnail_image) }}"
                             class="img-fluid mt-2 rounded"
                             style="max-height:150px">
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="border rounded p-3 bg-white">
                        <strong>Banner Image</strong><br>
                        <img src="{{ asset('storage/'.$course->banner_image) }}"
                             class="img-fluid mt-2 rounded"
                             style="max-height:150px">
                    </div>
                </div>
            </div>

            {{-- FORMATTED CONTENT (FIXED) --}}
            <div class="mb-4">
                <strong>Course Overview:</strong>
                <div class="border rounded bg-white p-3 mt-2">
                    {!! $course->course_overview !!}
                </div>
            </div>

            <div class="mb-4">
                <strong>Detail Content:</strong>
                <div class="border rounded bg-white p-3 mt-2">
                    {!! $course->detail_content !!}
                </div>
            </div>

            {{-- META --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>YouTube URL:</strong>
                    <div>
                        <a href="{{ $course->youtube_url }}" target="_blank">
                            {{ $course->youtube_url }}
                        </a>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Meta Title:</strong>
                    <div class="text-muted">{{ $course->meta_title }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Meta Keywords:</strong>
                    <div class="text-muted">{{ $course->meta_keyword }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Meta Description:</strong>
                    <div class="text-muted">{{ $course->meta_description }}</div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
