<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ ucwords($paper->name ?? '') }}</title>
    <link rel="icon" href="https://www.adhyayanam.co.in/public/images/fav.ico" sizes="any">
    <link rel="shortcut icon" href="https://www.adhyayanam.co.in/public/images/fav.ico">
    <style>
        body {
            font-family: 'notodevanagari', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #2d3748;
            margin: 0;
            padding: 0;
        }

        /* Force Devanagari font everywhere, even over inline styles from rich text editor */
        body,
        table,
        td,
        th,
        p,
        span,
        div,
        strong,
        li,
        h1,
        h2,
        h3,
        h4,
        .question,
        .instructions,
        .paper-summary {
            font-family: 'notodevanagari', sans-serif !important;
        }

        .pdf-content {
            padding: 20px 30px 60px 30px;
        }

        h2,
        h3 {
            margin: 5px 0;
            color: #1a365d;
        }

        h2 {
            font-size: 18px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }

        table td,
        table th {
            border: 1px solid #cbd5e0;
            padding: 5px 8px;
            vertical-align: middle;
        }

        table td strong {
            font-weight: 600;
            color: #4a5568;
        }

        table th {
            background: #f7fafc;
            color: #2d3748;
            font-weight: bold;
        }

        .section-title {
            background: #1a365d;
            color: #fff;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .instructions {
            border: 1px solid #cbd5e0;
            border-left: 4px solid #1a365d;
            padding: 12px;
            margin-top: 15px;
            background: #f8fafc;
        }

        .instructions h3 {
            background: #1a365d;
            color: #fff;
            padding: 6px 12px;
            margin-bottom: 10px;
            font-size: 13px;
            margin-top: 0;
        }

        .question {
            display: block;
            margin-top: 15px;
            margin-bottom: 15px;
            border: 1px solid #b8c2cc;
            border-top: 3px solid #1a365d;
            padding: 10px 12px;
            background-color: #ebf4ff;
        }

        .question strong {
            display: block;
            color: #1a365d;
            font-size: 13px;
            margin-bottom: 6px;
        }

        /* ========================= */
        /* 🔹 Elegant Letterhead Styles */
        /* ========================= */
        .letterhead-wrapper {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .letterhead-band {
            height: 4px;
            background-color: #1a365d;
            margin-bottom: 2px;
            width: 100%;
        }

        .letterhead-accent-band {
            height: 1.5px;
            background-color: #d69e2e;
            margin-bottom: 8px;
            width: 100%;
        }

        .pdf-header {
            text-align: center;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 2px double #1a365d;
        }

        .pdf-header img {
            height: 70px;
            max-height: 85px;
        }

        .site-name {
            font-family: 'notodevanagari', sans-serif;
            font-size: 24px;
            font-weight: bold;
            color: #1a365d;
            letter-spacing: 1px;
        }

        .header-tagline {
            font-family: 'notodevanagari', sans-serif;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #718096;
            margin-top: 8px;
            font-weight: bold;
        }

        .header-contact-info {
            font-family: 'notodevanagari', sans-serif;
            font-size: 9px;
            color: #718096;
            margin-top: 6px;
            letter-spacing: 0.5px;
        }

        table.ref-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-top: 0px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }

        table.ref-table td {
            border: none;
            padding: 4px 0;
            font-size: 11px;
            color: #4a5568;
        }

        /* ========================= */
        /* 🔹 Elegant Footer Styles */
        /* ========================= */
        .pdf-footer {
            position: fixed;
            bottom: 15px;
            left: 30px;
            right: 30px;
            text-align: center;
            font-size: 9px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }

        .pdf-footer table.footer-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 0;
        }

        .pdf-footer table.footer-table td {
            border: none;
            padding: 0;
            font-size: 9px;
            color: #718096;
        }
    </style>
</head>

<body>

    <!-- ======================================= -->
    <!-- 🔹 LETTERHEAD TYPE HEADER (CENTERED LOGO) -->
    <!-- ======================================= -->
    <div class="letterhead-wrapper">
        <div class="letterhead-band"></div>
        <div class="letterhead-accent-band"></div>

        <div class="pdf-header">
            @if($logoBase64)
                <div style="margin-bottom: 6px;">
                    <img src="{{ $logoBase64 }}">
                </div>
            @else
                <div class="site-name">{{ config('app.name') }}</div>
            @endif
            <div class="header-tagline">{{ strtoupper(config('app.name') ?? 'Assessment') }} • ONLINE ASSESSMENT</div>
        </div>
    </div>

    <div class="pdf-content">
        <!-- Letterhead Document Meta (Reference and Date) -->
        <table class="ref-table">
            <tr>
                <td style="text-align: left; width: 50%;">
                    <strong>Ref:</strong> {{ $paper->test_code ?? 'N/A' }}
                </td>
                <td style="text-align: right; width: 50%;">
                    <strong>Date:</strong> {{ date('d-M-Y') }}
                </td>
            </tr>
        </table>

        <!-- EXISTING HEADER (UNCHANGED) -->
        <h2>{{ ucwords($paper->name ?? '') }} ({{ $paper->test_code ?? '' }})</h2>

        <!-- EXISTING PAPER SUMMARY (UNCHANGED) -->
        <div class="paper-summary">
            <table>
                <tr>
                    <td><strong>Language</strong></td>
                    <td>{{ $paper->language == '1' ? 'Hindi' : 'English' }}</td>
                </tr>
                <tr>
                    <td><strong>Paper Type</strong></td>
                    <td>{{ $paper->paper_type == 0 ? 'Normal' : ($paper->paper_type == 1 ? 'Previous Year' : 'Current
                        Affair') }}</td>
                </tr>
                <tr>
                    <td><strong>Test Type</strong></td>
                    <td>{{ ucwords($paper->test_type ?? '') }}</td>
                </tr>
                <tr>
                    <td><strong>Examination Commission</strong></td>
                    <td>{{ ucwords($paper->commission->name ?? '') }}</td>
                </tr>
                <tr>
                    <td><strong>Category</strong></td>
                    <td>{{ ucwords($paper->category->name ?? '') }}</td>
                </tr>
                <tr>
                    <td><strong>Sub Category</strong></td>
                    <td>{{ ucwords($paper->subcategory->name ?? '') }}</td>
                </tr>
                <tr>
                    <td><strong>Subject</strong></td>
                    <td>{{ ucfirst($paper->subject->name ?? '') }}</td>
                </tr>
                <tr>
                    <td><strong>Chapter</strong></td>
                    <td>{{ ucfirst($paper->chapter->name ?? '') }}</td>
                </tr>
                <tr>
                    <td><strong>Topic</strong></td>
                    <td>{{ $paper->topic->name ?? '' }}</td>
                </tr>
                <tr>
                    <td><strong>Test Name</strong></td>
                    <td>{{ ucwords($paper->name ?? '') }}</td>
                </tr>
                <tr>
                    <td><strong>Duration</strong></td>
                    <td>{{ $paper->duration ?? 0 }} min</td>
                </tr>
                <tr>
                    <td><strong>Total Questions</strong></td>
                    <td>{{ $paper->total_questions ?? 0 }}</td>
                </tr>
                <tr>
                    <td><strong>Total Marks</strong></td>
                    <td>{{ $paper->total_marks ?? 0 }}</td>
                </tr>
                <tr>
                    <td><strong>Has Negative Marks</strong></td>
                    <td>{{ ucfirst($paper->has_negative_marks) }}</td>
                </tr>
                @if($paper->has_negative_marks == "yes")
                    <tr>
                        <td><strong>Negative Marks Per Question</strong></td>
                        <td>{{ $paper->negative_marks_per_question ?? 0 }}</td>
                    </tr>
                @endif
                <tr>
                    <td><strong>Allow Re-Attempt</strong></td>
                    <td>{{ ucfirst($paper->allow_re_attempt) }}</td>
                </tr>
                @if($paper->allow_re_attempt == "yes")
                    <tr>
                        <td><strong>Number Of Re-Attempts Allowed</strong></td>
                        <td>{{ $paper->number_of_re_attempt_allowed ?? 0 }}</td>
                    </tr>
                @endif
                <tr>
                    <td><strong>Question Shuffling</strong></td>
                    <td>{{ ucfirst($paper->question_shuffling) }}</td>
                </tr>
                <tr>
                    <td><strong>Question Added By</strong></td>
                    <td>{{ $paper->question_generated_by == 'random' ? 'Auto' : 'Manual' }}</td>
                </tr>
            </table>
        </div>

        <!-- Question Bifurcation -->
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

        <!-- Instructions -->
        @if(!empty($paper->test_instruction))
            <div class="instructions">
                <h3>Test Paper Instructions</h3>
                {!! \App\Helpers\Helper::cleanFontStyle($paper->test_instruction) !!}
            </div>
        @endif

        <!-- Questions -->
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
                ])      @elseif(isset($testDetail->question))
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

    <!-- ========================= -->
    <!-- 🔹 ELEGANT FOOTER DESIGN -->
    <!-- ========================= -->
    <div class="pdf-footer">
        <table class="footer-table">
            <tr>
                <td style="text-align: left;">
                    © {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.
                </td>
                <td style="text-align: right;">
                    Confidential Assessment Document
                </td>
            </tr>
        </table>
    </div>

</body>

</html>