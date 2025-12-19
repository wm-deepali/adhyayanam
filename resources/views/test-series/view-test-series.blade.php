@extends('layouts.app')

@section('title')
    Test Series | View
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
    <style>
        .question-bank-main-page {
            width: 100%;
            height: auto;
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 10px
        }

        .button-actns-questn {
            text-align: center;
            padding: 107px 0;
        }

        .button-actns-questn i {
            display: block;
            width: 100%;
            padding: 10px;
            color: #fff;
        }

        .form-section {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 7px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .question-bank {
            display: flex;
            flex-direction: row;
            gap: 20px;
            border-top: 1px solid gray;
            margin-top: 30px;
            padding-top: 20px;
        }

        .table-warning th {
            background-color: #fff200 !important;
            color: #000;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
    <div class="col">
        <h5 class="card-title">{{ ucwords($test_series->title ?? "") }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">View Test Series section here.</h6>
    </div>

    <div>
        <a href="{{ route('test.series.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
</div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="mt-3 row">
                    <div class="col-md-4">
                        <p><strong>Title:</strong> {{ ucwords($test_series->title ?? "") }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Language:</strong> {{ $test_series->language == 1 ? 'Hindi' : 'English' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Fee Type:</strong> {{ ucfirst($test_series->fee_type ?? "") }}</p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Commission:</strong> {{ $test_series->commission->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Category:</strong> {{ $test_series->category->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>SubCategory:</strong> {{ $test_series->subcategory->name ?? '-' }}</p>
                    </div>

                    @if($test_series->fee_type == 'paid')
                        <div class="col-md-4">
                            <p><strong>MRP (₹):</strong> {{ $test_series->mrp }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Discount (%):</strong> {{ $test_series->discount }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Offered Price (₹):</strong> {{ $test_series->price }}</p>
                        </div>
                    @endif

                    <div class="col-md-4">
                        <p><strong>Total Papers:</strong> {{ $test_series->total_paper }}</p>
                    </div>

                    <div class="col-md-12 mt-3">
                        <p><strong>Short Description:</strong></p>
                        <div>{!! $test_series->short_description ?? '<em>No description provided</em>' !!}</div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <p><strong>Description:</strong></p>
                        <div>{!! $test_series->description ?? '<em>No description provided</em>' !!}</div>
                    </div>

                    {{-- Show image/thumbnail if available --}}
                    @if(!empty($test_series->logo))
                        <div class="col-md-4 mt-3">
                            <p><strong>Thumbnail:</strong></p>
                            <img src="{{ asset('storage/' . $test_series->logo) }}" alt="Test Series Image" width="200"
                                class="rounded">
                        </div>
                    @endif

                    {{-- ✅ Test Paper Summary Table --}}
                    @if(isset($test_series->testseries) && count($test_series->testseries) > 0)
                        @php
                            $typeNames = [
                                1 => "Full Test",
                                2 => "Subject Wise",
                                3 => "Chapter Wise",
                                4 => "Topic Wise",
                                5 => "Current Affair Based",
                                6 => "PYQ",
                            ];

                            $paperTypes = ["MCQ", "Subjective", "Passage", "Combined"];

                            $counts = [];

                            foreach ($typeNames as $typeKey => $typeName) {
                                foreach ($paperTypes as $paperType) {
                                    $counts[$typeName][$paperType] = $test_series->testseries
                                        ->where('type', $typeKey)
                                        ->where('test_paper_type', $paperType)
                                        ->count();
                                }
                            }
                        @endphp

                        <div class="col-md-12 mt-4">
                            <h4>Test Paper Summary</h4>
                            <hr>
                            <table class="table table-bordered table-striped text-center align-middle">
                                <thead class="table-warning">
                                    <tr>
                                        <th style="background: yellow;">Test Type</th>
                                        @foreach($paperTypes as $col)
                                            <th style="background: yellow;">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($counts as $typeName => $papers)
                                        <tr>
                                            <td><strong>{{ $typeName }}</strong></td>
                                            @foreach($paperTypes as $paperType)
                                                <td>{{ $papers[$paperType] ?? 0 }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif


                       {{-- Test Paper Details --}}
                    @if(isset($test_series->testseries) && count($test_series->testseries) > 0)
                        <div class="col-md-12 mt-4">
                            <h4>Test Papers</h4>
                            <hr>
                            @foreach($test_series->testseries as $details)

                            @php
    $paperId = 'paper_' . $details->id;
@endphp

<div class="accordion mb-3" id="accordion_{{ $paperId }}">
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading_{{ $paperId }}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse_{{ $paperId }}" aria-expanded="false"
                aria-controls="collapse_{{ $paperId }}">
                {{ $details->test_paper_type ?? '' }} Paper
            </button>
        </h2>

        <div id="collapse_{{ $paperId }}" class="accordion-collapse collapse"
            aria-labelledby="heading_{{ $paperId }}"
            data-bs-parent="#accordion_{{ $paperId }}">
            <div class="accordion-body">

             <p><strong>Test Generated By:</strong>
                    {{ ucfirst($details->test_generated_by ?? 'Unknown') }}
                </p>

                {{-- Existing question rendering logic --}}
                @php
                    $relatedTests = $test_series->tests->where('id', $details->test_id);
                @endphp

                @foreach($relatedTests as $testpaper)
                 @php
    $testDetails = $testpaper->testDetails()->with('question')->get();
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

                $marks = $testDetail->positive_mark ?? $testpaper->positive_marks_per_question;
                $negative_marks = $testDetail->sub_negative_mark ?? $testpaper->negative_marks_per_question;

                // ✅ Parent index for main question
                $parentIndex = $parentMainIndex[$testDetail->parent_question_id] ?? 0;

                // ✅ Track sub-index per parent
                $subIndex[$testDetail->parent_question_id] = ($subIndex[$testDetail->parent_question_id] ?? 0) + 1;

                // ✅ Convert sub-index to Roman numerals
                $romanIndex = strtolower(\App\Helpers\Helper::toRoman($subIndex[$testDetail->parent_question_id]));
            @endphp

            @include('test-series.sub-questions', [
                'question' => $subQuestion,
                'marks' => $marks,
                'negative_marks' => $negative_marks,
                'index' => $romanIndex,
                'parentIndex' => $parentIndex
            ])
        @elseif($testDetail->question)
            {{-- ✅ Main Question --}}
            @php
                $question = $testDetail->question;
                $marks = $testDetail->positive_mark ?? $testpaper->positive_marks_per_question;
                $negative_marks = $testDetail->negative_mark ?? $testpaper->negative_marks_per_question;

                $parentMainIndex[$testDetail->question_id] = $mainIndex;
            @endphp

            @include('test-series.questions', [
                'question' => $question,
                'marks' => $marks,
                'negative_marks' => $negative_marks,
                'index' => $mainIndex
            ])
            @php $mainIndex++; @endphp
        @endif
    @endforeach
@endif

                @endforeach
            </div>
        </div>
    </div>
</div>


                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection