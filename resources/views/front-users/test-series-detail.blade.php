@extends('front-users.layouts.app')

@section('title')
    Test Series Detail
@endsection

<style>
.cb-item{
     align-items:center ;
}
     @media (max-width: 740px) {
.content{
    padding:0px !important;
}
.card-body{
    padding:10px !important;
   
    flex-direction:column !important;
    gap:10px !important;
}
.cb-item{
     align-items:start !important;
}
}

.filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: end;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 16px;
    border-radius: 14px;
    margin-bottom: 16px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 170px;
}

.filter-group label {
    font-size: 12.5px;
    font-weight: 600;
    color: #64748b;
}

.filter-group select {
    border: 1px solid #d1d5db;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 14px;
    background: #fff;
    color: #1e2937;
}

.filter-reset-btn {
    border: 1px solid #d1d5db;
    background: #fff;
    color: #374151;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    height: fit-content;
}

.filter-reset-btn:hover {
    border-color: #ef4444;
    color: #ef4444;
}

.filter-empty-state {
    display: none;
}

.paper-status-badge {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
    display: inline-block;
    margin-top: 6px;
}

.status-completed {
    background: #dcfce7;
    color: #15803d;
}

.status-in-progress {
    background: #fef3c7;
    color: #92400e;
}

.status-not-attempted {
    background: #f1f5f9;
    color: #64748b;
}

@media (max-width: 740px) {
    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        min-width: 100%;
    }
}
</style>

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

        // Helper to work out Full/Subject/Chapter/Topic wise labelling (same logic used in admin evaluate view)
        $resolvePaperType = function ($testpaper) {
            if ($testpaper->paper_type == 1) return 'Previous Year';
            if ($testpaper->paper_type == 2) return 'Current Affair';

            if (is_null($testpaper->topic_id) && is_null($testpaper->subject_id) && is_null($testpaper->chapter_id)) {
                return 'Full Test';
            }
            if (!is_null($testpaper->subject_id) && is_null($testpaper->chapter_id)) {
                return 'Subject Wise';
            }
            if (!is_null($testpaper->chapter_id) && is_null($testpaper->topic_id)) {
                return 'Chapter Wise';
            }
            if (!is_null($testpaper->topic_id)) {
                return 'Topic Wise';
            }
            return '-';
        };

        // Helper to render attempt status for a paper
        $resolveAttemptStatus = function ($testpaper) use ($attempts) {
            $attempt = $attempts->get($testpaper->id);

            if (!$attempt) {
                return ['label' => 'Not Attempted', 'class' => 'status-not-attempted', 'btn_label' => 'Attempt Now'];
            }

            if ($attempt->status === 'in_progress') {
                return ['label' => 'In Progress', 'class' => 'status-in-progress', 'btn_label' => 'Resume Test'];
            }

            return ['label' => 'Completed', 'class' => 'status-completed', 'btn_label' => 'Retake Test'];
        };
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
                        <div class="card-body ">

                            <div class="text-center mb-3">
                                <img src="{{ $testseries->logo ? asset('storage/' . $testseries->logo) : asset('images/placeholder-logo.png') }}"
                                    class="img-fluid rounded"
                                    style="max-height:150px;max-width:150px;"
                                    alt="{{ $testseries->title }}">
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
                                Last updated on {{ $testseries->updated_at?->format('d M, Y') }}
                            </p>

                            {{-- Category Wise Counts --}}
                            @php
                                $fullCount = $testseries->testseries->where('type', 1)->count();
                                $subjectCount = $testseries->testseries->where('type', 2)->count();
                                $chapterCount = $testseries->testseries->where('type', 3)->count();
                                $topicCount = $testseries->testseries->where('type', 4)->count();
                                $currentCount = $testseries->testseries->where('type', 5)->count();
                                $prevCount = $testseries->testseries->where('type', 6)->count();
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
                                        <div class="list-group-item">Current Affair Papers: {{ $currentCount }}</div>
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
                                    <a href="{{ route('user.process-order', ['type' => 'test-series', 'id' => $testseries->id]) }}"
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

                                        {{-- =============== MOCK TESTS FILTER BAR =============== --}}
                                        @if($subjects->count() || $chapters->count() || $topics->count())
                                            <div class="filter-bar" data-section="mock">

                                                <div class="filter-group">
                                                    <label>Subject</label>
                                                    <select class="filter-select" data-type="subject">
                                                        <option value="all">All Subjects</option>
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Chapter</label>
                                                    <select class="filter-select" data-type="chapter">
                                                        <option value="all">All Chapters</option>
                                                        @foreach($chapters as $chapter)
                                                            <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Topic</label>
                                                    <select class="filter-select" data-type="topic">
                                                        <option value="all">All Topics</option>
                                                        @foreach($topics as $topic)
                                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Paper Type</label>
                                                    <select class="filter-select" data-type="papertype">
                                                        <option value="all">All Types</option>
                                                        <option value="Full Test">Full Test</option>
                                                        <option value="Subject Wise">Subject Wise</option>
                                                        <option value="Chapter Wise">Chapter Wise</option>
                                                        <option value="Topic Wise">Topic Wise</option>
                                                        <option value="Current Affair">Current Affair</option>
                                                    </select>
                                                </div>

                                                <button type="button" class="filter-reset-btn" data-reset="mock">
                                                    Reset Filters
                                                </button>

                                            </div>
                                        @endif

                                        @forelse($testseries->tests->where('paper_type', '!=', 1) as $testpaper)
                                            @php
                                                $status = $resolveAttemptStatus($testpaper);
                                                $paperTypeLabel = $resolvePaperType($testpaper);
                                            @endphp
                                            <div class="card mb-2 shadow-sm mock-test-row"
                                                data-subject="{{ $testpaper->subject_id ?? 'none' }}"
                                                data-chapter="{{ $testpaper->chapter_id ?? 'none' }}"
                                                data-topic="{{ $testpaper->topic_id ?? 'none' }}"
                                                data-papertype="{{ $paperTypeLabel }}">
                                                <div class="card-body cb-item d-flex justify-content-between ">

                                                    <div>
                                                        <strong>{{ $testpaper->name }}</strong>

                                                        {{-- ✅ TEST SYLLABUS --}}
                                                        <div class="text-muted small mt-1">
                                                            <span class="badge bg-light text-dark border">{{ $paperTypeLabel }}</span>

                                                            @if($testpaper->subject)
                                                                <span class="ms-2"><strong>Subject:</strong> {{ $testpaper->subject->name }}</span>
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

                                                        <span class="paper-status-badge {{ $status['class'] }}">
                                                            {{ $status['label'] }}
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('test.instruction', base64_encode($testpaper->id)) }}"
                                                            class="btn btn-success btn-sm">
                                                            {{ $status['btn_label'] }}
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-3">No mock tests available in this series yet.</p>
                                        @endforelse

                                        <div class="filter-empty-state text-center py-4 text-muted" data-empty="mock">
                                            No tests match the selected filters.
                                        </div>

                                    </div>


                                    {{-- Previous Year Tests --}}
                                    <div class="tab-pane fade" id="previous">

                                        {{-- =============== PREVIOUS YEAR FILTER BAR =============== --}}
                                        @if($subjects->count() || $chapters->count() || $topics->count())
                                            <div class="filter-bar" data-section="previous">

                                                <div class="filter-group">
                                                    <label>Subject</label>
                                                    <select class="filter-select" data-type="subject">
                                                        <option value="all">All Subjects</option>
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Chapter</label>
                                                    <select class="filter-select" data-type="chapter">
                                                        <option value="all">All Chapters</option>
                                                        @foreach($chapters as $chapter)
                                                            <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Topic</label>
                                                    <select class="filter-select" data-type="topic">
                                                        <option value="all">All Topics</option>
                                                        @foreach($topics as $topic)
                                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <button type="button" class="filter-reset-btn" data-reset="previous">
                                                    Reset Filters
                                                </button>

                                            </div>
                                        @endif

                                        @forelse($testseries->tests->where('paper_type', 1) as $testpaper)
                                            @php
                                                $status = $resolveAttemptStatus($testpaper);
                                            @endphp
                                            <div class="card mb-2 shadow-sm previous-test-row"
                                                data-subject="{{ $testpaper->subject_id ?? 'none' }}"
                                                data-chapter="{{ $testpaper->chapter_id ?? 'none' }}"
                                                data-topic="{{ $testpaper->topic_id ?? 'none' }}">
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

                                                        <span class="paper-status-badge {{ $status['class'] }}">
                                                            {{ $status['label'] }}
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('test.instruction', base64_encode($testpaper->id)) }}"
                                                            class="btn btn-success btn-sm">
                                                            {{ $status['btn_label'] }}
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-3">No previous year papers available in this series yet.</p>
                                        @endforelse

                                        <div class="filter-empty-state text-center py-4 text-muted" data-empty="previous">
                                            No tests match the selected filters.
                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function applyFilters(section) {
                const bar = document.querySelector(`.filter-bar[data-section="${section}"]`);
                if (!bar) return;

                const selects = bar.querySelectorAll('.filter-select');
                const filters = {};

                selects.forEach(sel => {
                    filters[sel.dataset.type] = sel.value;
                });

                const rowClass = section === 'mock' ? '.mock-test-row' : '.previous-test-row';
                const rows = document.querySelectorAll(rowClass);
                let visibleCount = 0;

                rows.forEach(row => {
                    let matches =
                        (!filters.subject || filters.subject === 'all' || row.dataset.subject === filters.subject) &&
                        (!filters.chapter || filters.chapter === 'all' || row.dataset.chapter === filters.chapter) &&
                        (!filters.topic || filters.topic === 'all' || row.dataset.topic === filters.topic);

                    if (filters.papertype !== undefined) {
                        matches = matches && (filters.papertype === 'all' || row.dataset.papertype === filters.papertype);
                    }

                    row.style.display = matches ? '' : 'none';
                    if (matches) visibleCount++;
                });

                const emptyState = document.querySelector(`[data-empty="${section}"]`);
                if (emptyState) {
                    emptyState.style.display = (visibleCount === 0 && rows.length > 0) ? 'block' : 'none';
                }
            }

            document.querySelectorAll('.filter-bar').forEach(bar => {
                const section = bar.dataset.section;

                bar.querySelectorAll('.filter-select').forEach(sel => {
                    sel.addEventListener('change', () => applyFilters(section));
                });

                const resetBtn = bar.querySelector('[data-reset]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', () => {
                        bar.querySelectorAll('.filter-select').forEach(sel => sel.value = 'all');
                        applyFilters(section);
                    });
                }
            });
        });
    </script>

@endsection