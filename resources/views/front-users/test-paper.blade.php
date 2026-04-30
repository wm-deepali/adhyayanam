@extends('front-users.layouts.app')

@section('title', 'My Test Attempts')

@section('content')

    <style>
        /* ====================== DESKTOP TABLE ====================== */
        .table th {
            font-weight: 600;
        }

        /* ====================== MOBILE CARD VIEW ====================== */
        .attempt-mobile-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .attempt-mobile-header {
            background: #f8fafc;
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .attempt-mobile-body {
            padding: 20px;
        }

        .attempt-title {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 8px;
        }

        .attempt-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 18px 0;
        }

        .meta-item {
            font-size: 14px;
        }

        .meta-label {
            font-size: 12.5px;
            color: #64748b;
            display: block;
            margin-bottom: 3px;
        }

        .meta-value {
            font-weight: 500;
            color: #1e2937;
        }

        .score-box {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            margin: 15px 0;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 500;
        }
        
        @media (max-width: 740px) {
    
    .content {
    
    padding: 0 !important;
    
}

}
    </style>

    <section class="content py-4">
        <div class="container">

            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h4 class="m-0">📄 My Test Attempts</h4>
                </div>
            </div>

            @if($attemptedTests->count() > 0)

                <!-- ==================== DESKTOP TABLE VIEW ==================== -->
                <div class="d-none d-lg-block">
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
                                            <td>
                                                <strong>{{ $test->name ?? 'Unknown Test' }}</strong><br>
                                                <small class="text-muted">Test ID: #{{ $test->id }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info text-dark">Attempt #{{ $loop->iteration }}</span>
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
                                            <td>
                                                @if($attempt->status == 'published')
                                                    @php
                                                        $score = $attempt->final_score;
                                                        $total = $attempt->actual_marks;
                                                        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
                                                    @endphp
                                                    <strong>{{ $score }} / {{ $total }}</strong><br>
                                                    <small class="text-muted">{{ $percentage }}%</small>
                                                @else
                                                    <span class="text-muted">Waiting Evaluation</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($teacher)
                                                    👨‍🏫 {{ $teacher->full_name }}
                                                @else
                                                    <small class="text-muted">Not Assigned</small>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $attempt->created_at->format('d M Y | h:i A') }}
                                            </td>
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
                </div>

                <!-- ==================== MOBILE CARD VIEW ==================== -->
                <div class="d-lg-none">
                    @foreach($attemptedTests as $attempt)
                        @php
                            $test = $attempt->test;
                            $teacher = $attempt->assignedTeacher;
                            $score = $attempt->final_score ?? 0;
                            $total = $attempt->actual_marks ?? 0;
                            $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
                        @endphp

                        <div class="attempt-mobile-card">
                            <div class="attempt-mobile-header">
                                <div class="attempt-title">{{ $test->name ?? 'Unknown Test' }}</div>
                                <small class="text-muted">Test ID: #{{ $test->id }}</small>
                            </div>

                            <div class="attempt-mobile-body">
                                <div class="attempt-meta">
                                    <div class="meta-item">
                                        <span class="meta-label">Attempt</span>
                                        <span class="meta-value">#{{ $loop->iteration }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Paper Type</span>
                                        <span class="meta-value">
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
                                        </span>
                                    </div>
                                </div>

                                <!-- Score Box -->
                                <div class="score-box">
                                    @if($attempt->status == 'published')
                                        <strong class="fs-5">{{ $score }} / {{ $total }}</strong>
                                        <div class="text-muted">{{ $percentage }}% Score</div>
                                    @else
                                        <span class="text-muted">Waiting for Evaluation</span>
                                    @endif
                                </div>

                                <!-- Status & Teacher -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <span class="meta-label">Status</span><br>
                                        @if($attempt->status == 'published')
                                            <span class="status-badge bg-success text-white">Completed</span>
                                        @elseif($attempt->status == 'under_review')
                                            <span class="status-badge bg-primary text-white">Under Review</span>
                                        @elseif($attempt->status == 'pending')
                                            <span class="status-badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="status-badge bg-secondary text-white">{{ ucfirst($attempt->status) }}</span>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <span class="meta-label">Teacher</span><br>
                                        @if($teacher)
                                            <span>👨‍🏫 {{ $teacher->full_name }}</span>
                                        @else
                                            <small class="text-muted">Not Assigned</small>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date & Button -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Attempted On</small><br>
                                        <strong>{{ $attempt->created_at->format('d M Y | h:i A') }}</strong>
                                    </div>
                                    <a href="{{ route('user.test-result', base64_encode($attempt->id)) }}"
                                       class="btn btn-primary">
                                        View Result
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="alert alert-info text-center p-5 shadow-sm">
                    No attempted tests found yet.
                </div>
            @endif

        </div>
    </section>

@endsection