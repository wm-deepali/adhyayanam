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
        }
        h2, h3 {
            margin: 5px 0;
        }
        .paper-summary, .question-section {
            margin-bottom: 20px;
        }
        .paper-summary table, .question-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .paper-summary table td, .question-section table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .question-title {
            margin: 10px 0;
            font-weight: bold;
        }
        .sub-question {
            margin-left: 20px;
        }
        .marks {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Paper Summary -->
    <div class="paper-summary">
        <h2>{{ ucwords($paper->name ?? '') }} ({{ $paper->test_code ?? '' }})</h2>
        <table>
            <tr><td><strong>Paper Type</strong></td><td>{{ $paper->paper_type == 0 ? 'Normal' : ($paper->paper_type == 1 ? 'Previous Year' : 'Current Affair') }}</td></tr>
            <tr><td><strong>Language</strong></td><td>{{ $paper->language == '1' ? 'Hindi' : 'English' }}</td></tr>
            <tr><td><strong>Fee Type</strong></td><td>{{ ucwords($paper->test_type ?? '') }}</td></tr>
            <tr><td><strong>Commission</strong></td><td>{{ ucwords($paper->commission->name ?? '') }}</td></tr>
            <tr><td><strong>Category</strong></td><td>{{ ucwords($paper->category->name ?? '') }}</td></tr>
            <tr><td><strong>SubCategory</strong></td><td>{{ ucwords($paper->subcategory->name ?? '') }}</td></tr>
            <tr><td><strong>Test Paper Type</strong></td><td>{{ $paper->test_paper_type }}</td></tr>
            <tr><td><strong>Subject</strong></td><td>{{ ucfirst($paper->subject->name ?? '') }}</td></tr>
            <tr><td><strong>Chapter</strong></td><td>{{ ucfirst($paper->chapter->name ?? '') }}</td></tr>
            <tr><td><strong>Topic</strong></td><td>{{ $paper->topic->name ?? '' }}</td></tr>
            <tr><td><strong>Total Questions</strong></td><td>{{ $paper->total_questions ?? 0 }}</td></tr>
            <tr><td><strong>Total Marks</strong></td><td>{{ $paper->total_marks ?? 0 }}</td></tr>
            <tr><td><strong>Duration</strong></td><td>{{ $paper->duration ?? 0 }} min</td></tr>
            <tr><td><strong>Question Shuffling</strong></td><td>{{ ucfirst($paper->question_shuffling) }}</td></tr>
            <tr><td><strong>Allow Re Attempt</strong></td><td>{{ ucfirst($paper->allow_re_attempt) }}</td></tr>
            @if($paper->allow_re_attempt == "yes")
                <tr><td><strong>Number Of Re Attempt Allowed</strong></td><td>{{ $paper->number_of_re_attempt_allowed ?? 0 }}</td></tr>
            @endif
            <tr><td><strong>Has Negative Marks</strong></td><td>{{ ucfirst($paper->has_negative_marks) }}</td></tr>
            @if($paper->has_negative_marks == "yes")
                <tr><td><strong>Negative Marks Per Question</strong></td><td>{{ $paper->negative_marks_per_question ?? 0 }}</td></tr>
            @endif
        </table>
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
                                            $subQuestion = Helper::getSubQuestionDetails(
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

</body>
</html>
