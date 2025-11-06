@extends('layouts.app')

@section('title')
    Test Paper | View
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title">{{ ucwords($paper->name ?? "") }} ({{ $paper->test_code ?? "" }})</h5>
                        <h6 class="card-subtitle mb-2 text-muted">View Test Paper details below.</h6>
                    </div>
                    <div>
                        <a href="{{ route('test-papers.download', $paper->id) }}" class="btn btn-primary">
                            <i class="fa fa-download"></i> Download PDF
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="row">

                        {{-- 1. Language --}}
                        <div class="col-md-4">
                            <p><strong>Language:</strong> {{ $paper->language == '1' ? 'Hindi' : 'English' }}</p>
                        </div>

                        {{-- 2. Paper Type --}}
                        <div class="col-md-4">
                            <p><strong>Paper Type:</strong>
                                {{ $paper->paper_type == 0 ? 'Normal' : ($paper->paper_type == 1 ? 'Previous Year' : 'Current Affair') }}
                            </p>
                        </div>

                        {{-- 3. Test Type --}}
                        <div class="col-md-4">
                            <p><strong>Test Type:</strong> {{ ucwords($paper->test_type ?? "") }}</p>
                        </div>

                        {{-- 4. Examination Commission --}}
                        <div class="col-md-4">
                            <p><strong>Examination Commission:</strong> {{ ucwords($paper->commission->name ?? "") }}</p>
                        </div>

                        {{-- 5. Category --}}
                        <div class="col-md-4">
                            <p><strong>Category:</strong> {{ ucwords($paper->category->name ?? "") }}</p>
                        </div>

                        {{-- 6. Sub Category --}}
                        <div class="col-md-4">
                            <p><strong>Sub Category:</strong> {{ ucwords($paper->subcategory->name ?? "") }}</p>
                        </div>

                        {{-- 7. Subject --}}
                        <div class="col-md-4">
                            <p><strong>Subject:</strong> {{ ucfirst($paper->subject->name ?? "") }}</p>
                        </div>

                        {{-- 8. Chapter --}}
                        <div class="col-md-4">
                            <p><strong>Chapter:</strong> {{ ucfirst($paper->chapter->name ?? "") }}</p>
                        </div>

                        {{-- 9. Topic --}}
                        <div class="col-md-4">
                            <p><strong>Topic:</strong> {{ $paper->topic->name ?? "" }}</p>
                        </div>

                        {{-- 10. Test Name --}}
                        <div class="col-md-4">
                            <p><strong>Test Name:</strong> {{ ucwords($paper->name ?? "") }}</p>
                        </div>

                        {{-- 11. Duration --}}
                        <div class="col-md-4">
                            <p><strong>Duration (minutes):</strong> {{ $paper->duration ?? 0 }}</p>
                        </div>

                        {{-- 12. Total Questions --}}
                        <div class="col-md-4">
                            <p><strong>Total Questions:</strong> {{ $paper->total_questions ?? 0 }}</p>
                        </div>

                        {{-- 13. Total Marks --}}
                        <div class="col-md-4">
                            <p><strong>Total Marks:</strong> {{ $paper->total_marks ?? 0 }}</p>
                        </div>

                        {{-- 14. Question Bifurcation Table --}}
                        <div class="col-12 mt-3 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white py-2">
                                    <strong>Question Bifurcation</strong>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-bordered mb-0 text-center align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 40%">Question Type</th>
                                                <th>Total Questions</th>
                                                <th>Each Question Mark</th>
                                                <th>Total Marks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div
                                                        class="form-check d-flex justify-content-center align-items-center">
                                                        <input class="form-check-input me-2" type="checkbox" {{ ($paper->mcq_total_question ?? 0) > 0 ? 'checked' : '' }}
                                                            disabled>
                                                        <label class="form-check-label">MCQ</label>
                                                    </div>
                                                </td>
                                                <td>{{ $paper->mcq_total_question ?? 0 }}</td>
                                                <td>{{ $paper->mcq_mark_per_question ?? 0 }}</td>
                                                <td>{{ $paper->mcq_total_marks ?? 0 }}</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div
                                                        class="form-check d-flex justify-content-center align-items-center">
                                                        <input class="form-check-input me-2" type="checkbox" {{ ($paper->story_total_question ?? 0) > 0 ? 'checked' : '' }}
                                                            disabled>
                                                        <label class="form-check-label">Story Based</label>
                                                    </div>
                                                </td>
                                                <td>{{ $paper->story_total_question ?? 0 }}</td>
                                                <td>{{ $paper->story_mark_per_question ?? 0 }}</td>
                                                <td>{{ $paper->story_total_marks ?? 0 }}</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div
                                                        class="form-check d-flex justify-content-center align-items-center">
                                                        <input class="form-check-input me-2" type="checkbox" {{ ($paper->subjective_total_question ?? 0) > 0 ? 'checked' : '' }}
                                                            disabled>
                                                        <label class="form-check-label">Subjective</label>
                                                    </div>
                                                </td>
                                                <td>{{ $paper->subjective_total_question ?? 0 }}</td>
                                                <td>{{ $paper->subjective_mark_per_question ?? 0 }}</td>
                                                <td>{{ $paper->subjective_total_marks ?? 0 }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        {{-- 15. Negative Marking --}}
                        <div class="col-md-4">
                            <p><strong>Has Negative Marks:</strong> {{ ucfirst($paper->has_negative_marks) }}</p>
                        </div>
                        @if($paper->has_negative_marks == "yes")
                            <div class="col-md-4">
                                <p><strong>Negative Marks Per Question:</strong> {{ $paper->negative_marks_per_question ?? 0 }}
                                </p>
                            </div>
                        @endif

                        {{-- 16. Re-Attempt Status --}}
                        <div class="col-md-4">
                            <p><strong>Allow Re-Attempt:</strong> {{ ucfirst($paper->allow_re_attempt) }}</p>
                        </div>
                        @if($paper->allow_re_attempt == "yes")
                            <div class="col-md-4">
                                <p><strong>Number Of Re-Attempts Allowed:</strong>
                                    {{ $paper->number_of_re_attempt_allowed ?? 0 }}</p>
                            </div>
                        @endif

                        {{-- 17. Reshuffling Status --}}
                        <div class="col-md-4">
                            <p><strong>Question Shuffling:</strong> {{ ucfirst($paper->question_shuffling) }}</p>
                        </div>

                        {{-- 18. Question Generated By --}}
                        <div class="col-md-4">
                            <p><strong>Question Generated By:</strong>
                                {{ $paper->question_generated_by == 'random' ? 'Auto' : 'Manual' }}
                            </p>
                        </div>

                    </div>

                    {{-- 19. Instructions (moved above questions) --}}
                    @if(!empty($paper->test_instruction))
                        <div class="card mt-4">
                            <div class="card-header bg-primary text-white">
                                <strong>Test Paper Instructions</strong>
                            </div>
                            <div class="card-body">
                                {!! $paper->test_instruction !!}
                            </div>
                        </div>
                    @endif

                    {{-- 20. Questions Section --}}
                    <div class="question-bank mt-4">
                        <h5><strong>All Questions in This Test Paper:</strong></h5>
                        @php
                            $testDetails = $paper->testDetails()->with('question')->get();
                            $mainIndex = 1;
                            $parentMainIndex = [];
                            $subIndex = [];
                        @endphp

                        @if($testDetails->count())
                            @foreach($testDetails as $testDetail)
                                        @if(!empty($testDetail->parent_question_id))
                                            {{-- ✅ Sub Question --}}
                                            @php
                                                $subQuestion = \App\Helpers\Helper::getSubQuestionDetails(
                                                    $testDetail->question_id,
                                                    $testDetail->test_question_type,
                                                    $testDetail->sub_negative_mark,
                                                    $testDetail->sub_positive_mark
                                                );

                                                $marks = $testDetail->positive_mark ?? $paper->positive_marks_per_question;

                                                // ✅ Get parent main index (e.g. Q1)
                                                $parentIndex = $parentMainIndex[$testDetail->parent_question_id] ?? 0;

                                                // ✅ Track sub-index per parent
                                                $subIndex[$testDetail->parent_question_id] = ($subIndex[$testDetail->parent_question_id] ?? 0) + 1;

                                                // ✅ Convert sub-index to Roman (i, ii, iii, ...)
                                                $romanIndex = strtolower(\App\Helpers\Helper::toRoman($subIndex[$testDetail->parent_question_id]));
                                            @endphp

                                            @include('test-series.sub-questions', [
                                                'question' => $subQuestion,
                                                'marks' => $marks,
                                                'negative_marks' => $testDetail->sub_negative_mark ?? $paper->negative_marks_per_question,
                                                'index' => $romanIndex,
                                                'parentIndex' => $parentIndex
                                            ])
                                         @elseif($testDetail->question)
                                    {{-- ✅ Main Question --}}
                                            @php
                                                $question = $testDetail->question;
                                                $marks = $testDetail->positive_mark ?? $paper->positive_marks_per_question;
                                                $parentMainIndex[$testDetail->question_id] = $mainIndex;
                                            @endphp

                                                    @include('test-series.questions', [
                                                        'question' => $question,
                                                        'marks' => $marks,
                                                        'negative_marks' => $testDetail->negative_mark ?? $paper->negative_marks_per_question,
                                                        'index' => $mainIndex
                                                    ])
                                        @php $mainIndex++; @endphp
                                @endif
                            @endforeach
                        @else
        <p class="text-center">No questions found for this test paper.</p>
    @endif

                        </div>
                    </div>
                </div>
            </div>
@endsection