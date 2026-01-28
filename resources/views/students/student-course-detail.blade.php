@extends('layouts.app')

@section('title', 'Course Detail')

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h5>{{ $course->course_heading }}</h5>
                    <small class="text-muted">
                        Student: {{ $student->name }} |
                        Order ID: {{ $order->order_code ?? 'N/A' }}
                    </small>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            {{-- SUMMARY --}}
            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <strong>{{ $totalLessons }}</strong><br>
                    <small>Total Lessons</small>
                </div>
                <div class="col-md-4">
                    <strong>{{ $completedLessons }}</strong><br>
                    <small>Completed</small>
                </div>
                <div class="col-md-4">
                    <strong>{{ $totalLessons - $completedLessons }}</strong><br>
                    <small>Pending</small>
                </div>
            </div>

            {{-- LESSON LIST --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lesson</th>
                            <th>Teacher</th>
                            <th>Homework</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course->videos as $video)
                            @php
                                $submission = $video->homeworkSubmissions->first();
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->teacher->full_name ?? '—' }}</td>
                                <td>
                                    @if($video->assignment_file)
                                        <span class="badge bg-info">Assigned</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($submission)
                                        <span class="badge bg-success">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection