@extends('front-users.layouts.app')

@section('title')
    {{ $course->course_heading }} - Live Classes
@endsection

@section('content')
    <section class="content">

        {{-- ================= COURSE HEADER ================= --}}
        <div class="card mb-3">
    <div class="card-body">

        {{-- HEADER ROW --}}
        <div class="d-flex justify-content-between align-items-start mb-2">

            <div>
                <h4 class="fw-bold mb-1">{{ $course->course_heading }}</h4>
                <p class="text-muted mb-2">{{ $course->short_description }}</p>
            </div>

            {{-- BACK BUTTON --}}
            <a href="{{ url()->previous() }}"
               class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>

        <div class="text-muted mb-3">
            @if($firstLiveDate && $lastLiveDate)
                {{ \Carbon\Carbon::parse($firstLiveDate)->format('d M') }}
                -
                {{ \Carbon\Carbon::parse($lastLiveDate)->format('d M') }}
                • {{ $totalSessions }} sessions
            @endif
        </div>

        {{-- TEACHERS --}}
        <div class="d-flex align-items-center gap-4 flex-wrap">
            @foreach($teachers as $teacher)
                <div class="d-flex align-items-center">
                    <img src="{{ $teacher->profile_picture
                        ? asset('storage/' . $teacher->profile_picture)
                        : asset('images/default-avatar.png') }}"
                         class="rounded-circle me-2"
                         width="40" height="40">
                    <div>
                        <div class="fw-semibold">{{ $teacher->full_name }}</div>
                        <small class="text-muted">Teacher</small>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- ================= TABS ================= --}}
                <ul class="nav nav-pills mb-4 gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#scheduled">
                            📅 Scheduled
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#finished">
                            ✅ Finished
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#info">
                            ℹ️ Course Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#homework">
                            📝 Homework
                        </a>
                    </li>
                </ul>
                <div class="tab-content">

                    {{-- ================= SCHEDULED ================= --}}
                    <div class="tab-pane fade show active" id="scheduled">
                        @forelse($scheduledClasses as $class)
                            <div class="card mb-2 shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $class->title }}</h6>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($class->schedule_date)->format('d M Y') }},
                                            {{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($class->end_time)->format('h:i A') }}
                                        </small>
                                    </div>

                                    <a href="{{ $class->live_link }}" target="_blank" class="btn btn-success btn-sm px-3">
                                        <i class="bi bi-camera-video"></i> Join
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">No scheduled classes.</div>
                        @endforelse

                    </div>

                    {{-- ================= FINISHED ================= --}}
                    <div class="tab-pane fade" id="finished">
                        @forelse($finishedClasses as $class)
                            <div class="card mb-2 shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $class->title }}</h6>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($class->schedule_date)->format('d M Y') }},
                                            {{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($class->end_time)->format('h:i A') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">No finished classes.</div>
                        @endforelse
                    </div>

                    {{-- ================= COURSE INFO ================= --}}
                    <div class="tab-pane fade" id="info">
                        <div class="p-3">
                            {!! $course->detail_content ?? 'No additional course info.' !!}
                        </div>
                    </div>

                    {{-- ================= HOMEWORK ================= --}}
                    <div class="tab-pane fade" id="homework">

                        @forelse($finishedClasses as $class)
                            @php $submission = $class->homeworkSubmissions->first(); @endphp

                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-2">{{ $class->title }}</h6>

                                   <div class="d-flex flex-wrap gap-2 align-items-center">
    {{-- ASSIGNMENT (Teacher) --}}
    @if($class->assignment_file)
        <a href="{{ asset('storage/' . $class->assignment_file) }}" target="_blank"
           class="btn btn-outline-primary btn-sm">
            📥 Assignment
        </a>
    @endif

    {{-- UPLOAD OR VIEW SUBMISSION --}}
    @if(!$submission)
        <form action="{{ route('student.homework.upload') }}" method="POST"
              enctype="multipart/form-data"
              class="d-flex gap-2 align-items-center">
            @csrf
            <input type="hidden" name="video_id" value="{{ $class->id }}">
            <input type="file" name="assignment_file"
                   required accept=".pdf,.jpg,.jpeg,.png"
                   class="form-control form-control-sm">
            <button class="btn btn-primary btn-sm">Upload</button>
        </form>
    @else
        @php
            $filePath = $submission->assignment_file;
            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            $statusMap = [
                'submitted'   => ['label' => 'Submitted', 'class' => 'bg-primary'],
                'checked'     => ['label' => 'Checked', 'class' => 'bg-success'],
                'reviewed'    => ['label' => 'Reviewed', 'class' => 'bg-success'],
                'rejected'    => ['label' => 'Needs Correction', 'class' => 'bg-danger'],
                'resubmitted' => ['label' => 'Re-submitted', 'class' => 'bg-warning text-dark'],
                'late'        => ['label' => 'Late Submission', 'class' => 'bg-warning text-dark'],
            ];

            $status = $submission->status ?? 'submitted';
            $badge  = $statusMap[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-secondary'];
        @endphp

        {{-- STATUS --}}
        <span class="badge {{ $badge['class'] }}">
            {{ $badge['label'] }}
        </span>

        {{-- UPLOADED FILE --}}
        @if(in_array($ext, ['jpg', 'jpeg', 'png']))
            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                <img src="{{ asset('storage/' . $filePath) }}"
                     class="img-thumbnail"
                     style="max-width:120px;">
            </a>
        @else
            <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
               class="btn btn-outline-secondary btn-sm">
                📄 View Uploaded File
            </a>
        @endif

        {{-- SOLUTION --}}
        @if($class->solution_file)
            <a href="{{ asset('storage/' . $class->solution_file) }}" target="_blank"
               class="btn btn-success btn-sm">
                👁 View Solution
            </a>
        @endif
    @endif
</div>

{{-- 👇 TEACHER REMARKS & MARKS (FULL WIDTH – UI SAFE) --}}
@if($submission && ($submission->teacher_remark || $submission->marks !== null))
    <div class="mt-3 p-3 border rounded bg-light">

        @if($submission->marks !== null)
            <div class="fw-bold text-success mb-1">
                🎯 Marks: {{ $submission->marks }}
            </div>
        @endif

        @if($submission->teacher_remark)
            <div class="text-muted" style="white-space: pre-line;">
                📝 <strong>Teacher Remark:</strong><br>
                {{ $submission->teacher_remark }}
            </div>
        @endif

    </div>
@endif

                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">No homework available.</div>
                        @endforelse


                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection