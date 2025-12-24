@extends('front-users.layouts.app')

@section('title')
    Test Series Detail
@endsection

@section('content')

    @php
        $user_id = auth()->id();
        $package_id = $testseries->id ?? null;
        $type = 'Test Series';

        // Check purchase (returns order data or null)
        $checkExist = ($user_id && $package_id)
            ? \App\Helpers\Helper::GetStudentOrder($type, $package_id, $user_id)
            : null;

        $totalTests = $testseries->tests->count() ?? 0;
    @endphp

    <section class="page-title mb-3">
        <div class="container">
            <h2>{{ $testseries->title }}</h2>
            <ul class="breadcrumb">
                <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                <li>Test Series Detail</li>
            </ul>
        </div>
    </section>

    <section class="testseries-detail py-3">
        <div class="container">
            <div class="row">

                <div class="col-md-12">

                    {{-- Test Series Summary --}}
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">

                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $testseries->logo) }}" class="img-fluid rounded"
                                    style="max-height:150px;max-width:150px;">
                            </div>

                            <h3 class="mb-2">{{ $testseries->title }}</h3>

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <div>
                                    <strong>{{ $totalTests }}</strong> Total Papers
                                </div>

                                <div>
                                    <span
                                        class="badge {{ $testseries->fee_type == 'paid' ? 'bg-warning text-dark' : 'bg-success' }}">
                                        {{ $testseries->fee_type == 'paid' ? 'Premium' : 'Free' }}
                                    </span>
                                </div>

                            </div>

                            <p class="text-muted">
                                Last updated on {{ \Carbon\Carbon::parse($testseries->updated_at)->format('d M, Y')}}
                            </p>

                            {{-- Category Wise Counts --}}
                            @php
                                $chapterCount = $testseries->testseries->where('type_name', 'Chapter Test')->count();
                                $subjectCount = $testseries->testseries->where('type_name', 'Subject Wise')->count();
                                $topicCount = $testseries->testseries->where('type_name', 'Topic Wise')->count();
                                $fullCount = $testseries->testseries->where('type_name', 'Full Test')->count();
                                $prevCount = $testseries->testseries->where('paper_type', 1)->count();
                            @endphp

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group mb-3">
                                        <div class="list-group-item">Chapter Tests: {{ $chapterCount }}</div>
                                        <div class="list-group-item">Subject Tests: {{ $subjectCount }}</div>
                                        <div class="list-group-item">Topic Tests: {{ $topicCount }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="list-group mb-3">
                                        <div class="list-group-item">Full Tests: {{ $fullCount }}</div>
                                        <div class="list-group-item">Previous Year Papers: {{ $prevCount }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <h5 class="mt-3">About this Test Series</h5>
                            <div class="text-muted">
                                {!! $testseries->description !!}
                            </div>

                        </div>
                    </div>


                    {{-- Tests Listing --}}
                    <div class="card shadow-sm">
                        <div class="card-header fw-bold">
                            All Available Tests
                        </div>

                        <div class="card-body">

                            {{-- PAID but NOT PURCHASED --}}
                            @if($testseries->fee_type == 'paid' && !$checkExist)
                                <div class="alert alert-warning text-center mb-3">
                                    🔒 This is a premium test series.
                                    Please purchase to access tests.
                                </div>

                                <div class="text-center mb-3">
                                    <a href="{{ route('order.checkout', ['package_id' => $testseries->id, 'type' => 'Test Series']) }}"
                                        class="btn btn-primary btn-lg">
                                        Buy Now
                                    </a>
                                </div>

                                <hr>
                            @endif


                            {{-- SHOW TESTS ONLY IF FREE OR PURCHASED --}}
                            @if($testseries->fee_type == 'free' || $checkExist)

                                <ul class="nav nav-tabs mb-3" id="testTabs">

                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mockup">
                                            Mock Tests
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#previous">
                                            Previous Year Papers
                                        </button>
                                    </li>

                                </ul>

                                <div class="tab-content">

                                    {{-- Mockup Tests --}}
                                    <div class="tab-pane fade show active" id="mockup">

                                        @foreach($testseries->tests->where('paper_type', '!=', 1) as $testpaper)
                                            <div class="card mb-2 shadow-sm">
                                                <div class="card-body d-flex justify-content-between align-items-center">

                                                    <div>
                                                        <strong>{{ $testpaper->name }}</strong>

                                                        {{-- ✅ TEST SYLLABUS --}}
                                                        <div class="text-muted small mt-1">
                                                            @if($testpaper->subject)
                                                                <span><strong>Subject:</strong> {{ $testpaper->subject->name }}</span>
                                                            @endif

                                                            @if($testpaper->chapter)
                                                                <span class="ms-2"><strong>Chapter:</strong>
                                                                    {{ $testpaper->chapter->name }}</span>
                                                            @endif

                                                            @if($testpaper->topic)
                                                                <span class="ms-2"><strong>Topic:</strong>
                                                                    {{ $testpaper->topic->name }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="text-muted small mt-1">
                                                            {{ $testpaper->total_questions }} Questions |
                                                            {{ $testpaper->total_marks }} Marks |
                                                            {{ $testpaper->duration }} mins
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('live-test', base64_encode($testpaper->id)) }}"
                                                            class="btn btn-success btn-sm">
                                                            Attempt Now
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach


                                    </div>


                                    {{-- Previous Year Tests --}}
                                    <div class="tab-pane fade" id="previous">

                                        @foreach($testseries->tests->where('paper_type', 1) as $testpaper)
                                            <div class="card mb-2 shadow-sm">
                                                <div class="card-body d-flex justify-content-between align-items-center">

                                                    <div>
                                                        <strong>{{ $testpaper->name }}</strong>

                                                        {{-- ✅ TEST SYLLABUS --}}
                                                        <div class="text-muted small mt-1">
                                                            @if($testpaper->subject)
                                                                <span><strong>Subject:</strong> {{ $testpaper->subject->name }}</span>
                                                            @endif

                                                            @if($testpaper->chapter)
                                                                <span class="ms-2"><strong>Chapter:</strong>
                                                                    {{ $testpaper->chapter->name }}</span>
                                                            @endif

                                                            @if($testpaper->topic)
                                                                <span class="ms-2"><strong>Topic:</strong>
                                                                    {{ $testpaper->topic->name }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="text-muted small mt-1">
                                                            {{ $testpaper->total_questions }} Questions |
                                                            {{ $testpaper->total_marks }} Marks |
                                                            {{ $testpaper->duration }} mins
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('live-test', base64_encode($testpaper->id)) }}"
                                                            class="btn btn-success btn-sm">
                                                            Attempt Now
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach


                                    </div>

                                </div>

                            @endif

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection