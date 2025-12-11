@extends('front-users.layouts.app')

@section('title', 'My Test Attempts')

@section('content')

    <div class="container mt-4">

        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="m-0">📄 My Test Attempts</h4>
            </div>
        </div>

        @if($attemptedTests->count() > 0)

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th width="30%">Test Name</th>
                                <th>Attempt #</th>
                                <th>Paper Type</th>
                                <th>Status</th>
                                <th>Score</th>
                                <th>Assigned Teacher</th>
                                <th>Attempted On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach($attemptedTests as $attempt)

                                @php
                                    $test = $attempt->test;
                                    $teacher = $attempt->assignedTeacher;
                                @endphp

                                <tr>

                                    {{-- TEST NAME + TYPE --}}
                                    <td>
                                        <strong>{{ $test->name ?? 'Unknown Test' }}</strong><br>

                                        <small class="text-muted">
                                            Test ID: #{{ $test->id }}
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $paperType = $test->paper_type;

                                            $typeName = match ($paperType) {
                                                1 => 'Previous Year',
                                                2 => 'Current Affair',
                                                default => (
                                                    is_null($test->topic_id) && is_null($test->subject_id) && is_null($test->chapter_id)
                                                    ? 'Full Test'
                                                    : (!is_null($test->subject_id) && is_null($test->chapter_id)
                                                        ? 'Subject Wise'
                                                        : (!is_null($test->chapter_id) && is_null($test->topic_id)
                                                            ? 'Chapter Wise'
                                                            : (!is_null($test->topic_id)
                                                                ? 'Topic Wise'
                                                                : '-'
                                                            )
                                                        )
                                                    )
                                                )
                                            };
                                            echo $typeName;
                                        @endphp
                                        ({{ ucfirst($test->test_paper_type) }})
                                    </td>

                                    {{-- ATTEMPT NUMBER --}}
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark">Attempt #{{ $loop->iteration }}</span>
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if($attempt->status == 'published')
                                            <span class="badge bg-success">Completed</span>

                                        @elseif($attempt->status == 'under_review')
                                            <span class="badge bg-primary">Under Review</span>

                                        @elseif($attempt->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>

                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($attempt->status) }}</span>
                                        @endif
                                    </td>

                                    {{-- SCORE --}}
                                    <td>
                                        @if($attempt->status == 'published')
                                            <strong>
                                                {{ $attempt->final_score }}/{{ $attempt->max_positive_score }}
                                            </strong>
                                        @else
                                            <span class="text-muted">Waiting Evaluation</span>
                                        @endif
                                    </td>

                                    {{-- ASSIGNED TEACHER --}}
                                    <td>
                                        @if($teacher)
                                            <span class="text-dark">
                                                👨‍🏫 {{ $teacher->full_name }}
                                            </span>
                                        @else
                                            <small class="text-muted">Not Assigned</small>
                                        @endif
                                    </td>

                                    {{-- DATE --}}
                                    <td>
                                        {{ $attempt->created_at->format('d M Y | h:i A') }}
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td>
                                        <a href="{{ route('user.test-result', base64_encode($attempt->id)) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            View Result
                                        </a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        @else
            <div class="alert alert-info text-center p-3 shadow-sm">
                No attempted tests found yet.
            </div>
        @endif

    </div>

@endsection