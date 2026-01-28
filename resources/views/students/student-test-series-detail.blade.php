@extends('layouts.app')

@section('title', 'Test Series Detail')

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-0">{{ $testSeries->title }}</h5>
                    <small class="text-muted">
                        Student: <strong>{{ $student->name }}</strong>
                        | Order ID: <strong>{{ $order->order_code ?? 'N/A' }}</strong>
                    </small>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            {{-- SUMMARY --}}
            <div class="row text-center mb-4">
                <div class="col-md-3">
                    <div class="border rounded p-2">
                        <strong>{{ $testSeries->tests->count() }}</strong><br>
                        <small>Total Tests</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-2">
                        <strong>{{ count($attemptedTestIds) }}</strong><br>
                        <small>Attempted</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-2">
                        <strong>{{ $testSeries->tests->count() - count($attemptedTestIds) }}</strong><br>
                        <small>Pending</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-2">
                        <span class="badge bg-success">Active</span><br>
                        <small>Status</small>
                    </div>
                </div>
            </div>

            {{-- CATEGORY COUNTS --}}
            @php
                $chapterCount = $testSeries->testseries->where('type_name', 'Chapter Test')->count();
                $subjectCount = $testSeries->testseries->where('type_name', 'Subject Wise')->count();
                $topicCount   = $testSeries->testseries->where('type_name', 'Topic Wise')->count();
                $fullCount    = $testSeries->testseries->where('type_name', 'Full Test')->count();
                $prevCount    = $testSeries->testseries->where('paper_type', 1)->count();
            @endphp

            <div class="row mb-4">
                <div class="col-md-2"><span class="badge bg-light text-dark">Chapter: {{ $chapterCount }}</span></div>
                <div class="col-md-2"><span class="badge bg-light text-dark">Subject: {{ $subjectCount }}</span></div>
                <div class="col-md-2"><span class="badge bg-light text-dark">Topic: {{ $topicCount }}</span></div>
                <div class="col-md-2"><span class="badge bg-light text-dark">Full: {{ $fullCount }}</span></div>
                <div class="col-md-3"><span class="badge bg-light text-dark">Previous Year: {{ $prevCount }}</span></div>
            </div>

            {{-- TEST LIST --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Test Name</th>
                            <th>Type</th>
                            <th>Questions</th>
                            <th>Marks</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testSeries->tests as $test)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $test->name }}</strong>

                                    {{-- SYLLABUS INFO --}}
                                    <div class="text-muted small mt-1">
                                        @if($test->subject)
                                            <span><strong>Subject:</strong> {{ $test->subject->name }}</span>
                                        @endif
                                        @if($test->chapter)
                                            <span class="ms-2"><strong>Chapter:</strong> {{ $test->chapter->name }}</span>
                                        @endif
                                        @if($test->topic)
                                            <span class="ms-2"><strong>Topic:</strong> {{ $test->topic->name }}</span>
                                        @endif
                                    </div>
                                </td>

                                <td>{{ ucfirst($test->test_type) }}</td>
                                <td>{{ $test->total_questions }}</td>
                                <td>{{ $test->total_marks }}</td>
                                <td>{{ $test->duration }} min</td>

                                <td>
                                    @if(in_array($test->id, $attemptedTestIds))
                                        <span class="badge bg-success">Attempted</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No tests found for this test series.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection