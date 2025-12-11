@extends('layouts.teacher-app')

@section('content')

<div class="bg-light rounded">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">Completed Evaluations</h4>

            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Test Paper</th>
                        <th>Paper Type</th>
                        <th>Final Score</th>
                        <th>Total Marks</th>
                        <th>Status</th>
                        <th>Evaluated On</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($attempts as $index => $attempt)
                        @php
                            $student = $attempt->student;
                            $test    = $attempt->test;

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
                        @endphp

                        <tr>
                            <td>{{ $attempts->firstItem() + $index }}</td>

                            <td>
                                {{ $student->name }}
                                <br>
                                <small class="text-muted">{{ $student->email }}</small>
                            </td>

                            <td>
                                {{ $test->name }}
                                <br>
                                <small class="text-muted">Test ID: {{ $test->id }}</small>
                            </td>

                            <td>
                                {{ $typeName }} ({{ ucfirst($test->test_paper_type) }})
                            </td>

                            <td><strong>{{ $attempt->final_score }}</strong></td>

                            <td>{{ $attempt->max_positive_score }}</td>

                            <td>
                                <span class="badge bg-success">Submitted</span>
                            </td>

                            <td>{{ $attempt->updated_at->format('d M Y h:i A') }}</td>

                            <td>
                                <a href="{{ route('teacher.results.evaluate', base64_encode($attempt->id)) }}"
                                   class="btn btn-sm btn-primary">
                                    View Evaluation
                                </a>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

            <div class="mt-2">
                {{ $attempts->links() }}
            </div>

        </div>
    </div>
</div>

@endsection
