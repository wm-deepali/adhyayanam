<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ ucwords($paper->name ?? '') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
        }
        h2, h3 {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table td, table th {
            border: 1px solid #000;
            padding: 6px;
        }
        table th {
            background: #f0f0f0;
        }
        .section-title {
            background: #007bff;
            color: #fff;
            padding: 6px 10px;
            font-size: 14px;
            margin-top: 15px;
        }
        .instructions {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 10px;
            background: #f9f9f9;
        }
        .instructions h3 {
            background: #007bff;
            color: #fff;
            padding: 5px 10px;
            margin-bottom: 8px;
        }
        .question {
            margin-top: 10px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 6px;
        }
        .question strong {
            display: block;
        }
    </style>
</head>
<body>

    <!-- 🟩 Header -->
    <h2>{{ ucwords($paper->name ?? '') }} ({{ $paper->test_code ?? '' }})</h2>

    <!-- 🟨 Paper Summary -->
    <div class="paper-summary">
        <table>
            <tr><td><strong>Language</strong></td><td>{{ $paper->language == '1' ? 'Hindi' : 'English' }}</td></tr>
            <tr><td><strong>Paper Type</strong></td><td>{{ $paper->paper_type == 0 ? 'Normal' : ($paper->paper_type == 1 ? 'Previous Year' : 'Current Affair') }}</td></tr>
            <tr><td><strong>Test Type</strong></td><td>{{ ucwords($paper->test_type ?? '') }}</td></tr>
            <tr><td><strong>Examination Commission</strong></td><td>{{ ucwords($paper->commission->name ?? '') }}</td></tr>
            <tr><td><strong>Category</strong></td><td>{{ ucwords($paper->category->name ?? '') }}</td></tr>
            <tr><td><strong>Sub Category</strong></td><td>{{ ucwords($paper->subcategory->name ?? '') }}</td></tr>
            <tr><td><strong>Subject</strong></td><td>{{ ucfirst($paper->subject->name ?? '') }}</td></tr>
            <tr><td><strong>Chapter</strong></td><td>{{ ucfirst($paper->chapter->name ?? '') }}</td></tr>
            <tr><td><strong>Topic</strong></td><td>{{ $paper->topic->name ?? '' }}</td></tr>
            <tr><td><strong>Test Name</strong></td><td>{{ ucwords($paper->name ?? '') }}</td></tr>
            <tr><td><strong>Duration</strong></td><td>{{ $paper->duration ?? 0 }} min</td></tr>
            <tr><td><strong>Total Questions</strong></td><td>{{ $paper->total_questions ?? 0 }}</td></tr>
            <tr><td><strong>Total Marks</strong></td><td>{{ $paper->total_marks ?? 0 }}</td></tr>
            <tr><td><strong>Has Negative Marks</strong></td><td>{{ ucfirst($paper->has_negative_marks) }}</td></tr>
            @if($paper->has_negative_marks == "yes")
                <tr><td><strong>Negative Marks Per Question</strong></td><td>{{ $paper->negative_marks_per_question ?? 0 }}</td></tr>
            @endif
            <tr><td><strong>Allow Re-Attempt</strong></td><td>{{ ucfirst($paper->allow_re_attempt) }}</td></tr>
            @if($paper->allow_re_attempt == "yes")
                <tr><td><strong>Number Of Re-Attempts Allowed</strong></td><td>{{ $paper->number_of_re_attempt_allowed ?? 0 }}</td></tr>
            @endif
            <tr><td><strong>Question Shuffling</strong></td><td>{{ ucfirst($paper->question_shuffling) }}</td></tr>
            <tr><td><strong>Question Added By</strong></td><td>{{ $paper->question_generated_by == 'random' ? 'Auto' : 'Manual' }}</td></tr>
        </table>
    </div>

    <!-- 🟦 Question Bifurcation -->
    <div class="section-title">Question Bifurcation</div>
    <table>
        <thead>
            <tr>
                <th style="width:40%">Question Type</th>
                <th>Total Questions</th>
                <th>Each Question Mark</th>
                <th>Total Marks</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MCQ</td>
                <td>{{ $paper->mcq_total_question ?? 0 }}</td>
                <td>{{ $paper->mcq_mark_per_question ?? 0 }}</td>
                <td>{{ $paper->mcq_total_marks ?? 0 }}</td>
            </tr>
            <tr>
                <td>Story Based</td>
                <td>{{ $paper->story_total_question ?? 0 }}</td>
                <td>{{ $paper->story_mark_per_question ?? 0 }}</td>
                <td>{{ $paper->story_total_marks ?? 0 }}</td>
            </tr>
            <tr>
                <td>Subjective</td>
                <td>{{ $paper->subjective_total_question ?? 0 }}</td>
                <td>{{ $paper->subjective_mark_per_question ?? 0 }}</td>
                <td>{{ $paper->subjective_total_marks ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    <!-- 🟧 Instructions -->
    @if(!empty($paper->test_instruction))
        <div class="instructions">
            <h3>Test Paper Instructions</h3>
            {!! $paper->test_instruction !!}
        </div>
    @endif

    <!-- 🟩 Questions -->
    <div class="section-title">Questions</div>
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

</body>
</html>
