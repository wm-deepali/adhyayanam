@extends('layouts.app')

@section('title')
    Test Paper | View
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
    <style>
        /* Keep your previous styles as is */
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="card-title">{{ ucwords($paper->name ?? "") }} ({{ $paper->test_code ?? "" }})</h5>
        <h6 class="card-subtitle mb-2 text-muted">View Test Paper section here.</h6>
    </div>
    <div>
        <a href="{{ route('test-papers.download', $paper->id) }}" class="btn btn-primary">
            <i class="fa fa-download"></i> Download PDF
        </a>
    </div>
</div>


                <div class="mt-2">
                    <div class="row">
                        <!-- Paper Info -->
                        <div class="col-md-4">
                            <p><strong>Paper Name</strong>: {{ ucwords($paper->name ?? "") }}
                                ({{ $paper->test_code ?? "" }})</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Paper Type</strong>:
                                {{ $paper->paper_type == 0 ? 'Normal' : ($paper->paper_type == 1 ? 'Previous Year' : 'Current Affair') }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Language</strong>: {{ $paper->language == '1' ? 'Hindi' : 'English' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Fee Type</strong>: {{ ucwords($paper->test_type ?? "") }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Commission</strong>: {{ ucwords($paper->commission->name ?? "") }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Category</strong>: {{ ucwords($paper->category->name ?? "") }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>SubCategory</strong>: {{ ucwords($paper->subcategory->name ?? "") }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Test Paper Type</strong>: {{ $paper->test_paper_type }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Subject</strong>: {{ ucfirst($paper->subject->name ?? "") }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Chapter</strong>: {{ ucfirst($paper->chapter->name ?? "") }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Topic</strong>: {{ $paper->topic->name ?? "" }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Total Question</strong>: {{ $paper->total_questions ?? 0 }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Duration</strong>: {{ $paper->duration ?? 0 }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Total Marks</strong>: {{ $paper->total_marks ?? 0 }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Question Shuffling</strong>: {{ ucfirst($paper->question_shuffling) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Allow Re Attempt</strong>: {{ ucfirst($paper->allow_re_attempt) }}</p>
                        </div>
                        @if($paper->allow_re_attempt == "yes")
                            <div class="col-md-4">
                                <p><strong>Number Of Re Attempt Allowed</strong>:
                                    {{ $paper->number_of_re_attempt_allowed ?? 0 }}</p>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <p><strong>Has Negative Marks</strong>: {{ ucfirst($paper->has_negative_marks) }}</p>
                        </div>
                        @if($paper->has_negative_marks == "yes")
                            <div class="col-md-4">
                                <p><strong>Negative Marks Per Question</strong>: {{ $paper->negative_marks_per_question ?? 0 }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Questions Section -->
                    <div class="question-bank mt-4">
                        @php
                            $testDetails = $paper->testDetails()->with('question')->get();
                        @endphp

                        @if($testDetails->count())
                            @foreach($testDetails as $key => $testDetail)
                                    @if(isset($testDetail->sub_question_id) && $testDetail->sub_question_id != "")
                                        @php
                                            $subQuestion = \App\Helpers\Helper::getSubQuestionDetails(
                                                $testDetail->sub_question_id,
                                                $testDetail->test_question_type,
                                                $testDetail->sub_negative_mark,
                                                $testDetail->sub_positive_mark
                                            );
                                            $marks = $testDetail->sub_positive_mark;
                                        @endphp
                                        @include('test-series.sub-questions', [
                                            'question' => $subQuestion,
                                            'marks' => $marks,
                                            'index' => $key
                                        ])
                                    @elseif(isset($testDetail->question))
                                    @php
                                        $question = $testDetail->question;
                                        $marks = $testDetail->positive_mark ?? $paper->positive_marks_per_question;
                                    @endphp
                                            @include('test-series.questions', [
                                                'question' => $question,
                                                'marks' => $marks,
                                                'index' => $key
                                            ])
                                @endif
                            @endforeach
                        @else
                        <p class="text-center">No questions found for this test paper.</p>
                        @endif    
                    </div>

                    {{-- Instructions Section --}}
@if(!empty($paper->test_instruction))
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <strong>Instructions</strong>
        </div>
        <div class="card-body">
            {!! $paper->test_instruction !!}
        </div>
    </div>
@endif


                </div>
            </div>
        </div>
    </div>

@endsection
