@extends('front-users.layouts.app')

@section('title')
    {{$test->name}} Result
@endsection

@section('content')

    <style>
        .result-wrapper {
            width: 100%;
            padding: 20px;
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f4f7fb;
        }

        /* QUESTION CARD */

        .q-box {
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            margin-bottom: 18px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #eef1f6;
            transition: 0.3s;
        }

        .q-box:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }


        /* QUESTION TITLE */

        .q-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e2a3b;
            margin-bottom: 10px;
            line-height: 1.6;
        }


        /* STATUS TAG */

        .answer-tag {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            letter-spacing: .3px;
        }

        .correct {
            background: #19b76a;
            color: white;
        }

        .wrong {
            background: #e53935;
            color: white;
        }

        .pending {
            background: #ffb020;
            color: #222;
        }


        /* MCQ OPTIONS */

        .mcq-option {
            width: 100%;
            padding: 6px 12px;
            border-radius: 6px;
            display: inline-block;
            font-weight: 500;
            font-size: 14px;
            background: #f2f4f8;
            border: 1px solid #e4e7ec;
        }


        /* CHILD QUESTIONS */

        .child-box {
            margin: 10px 0;
            padding: 12px 15px;
            border-left: 4px solid #2c6cff;
            background: #f5f8ff;
            border-radius: 8px;
            font-size: 14px;
        }


        /* SCORE */

        .score-box {
            font-size: 32px;
            color: #004799;
            font-weight: 700;
            margin-top: 6px;
        }


        /* TABLE */

        .table td {
            padding: 6px 8px;
            font-size: 14px;
        }


        /* PROGRESS BAR */

        .progress {
            background: #e9edf3;
            border-radius: 10px;
        }


        /* BUTTON */

        .btn-primary {
            background: #2c6cff;
            border: none;
            border-radius: 6px;
        }

        .btn-primary:hover {
            background: #1a52d1;
        }


        /* SOLUTION BOX */

        .solution-box {
            background: #eef7ff;
            border: 1px solid #d8e8ff;
            padding: 10px;
            border-radius: 6px;
            margin-top: 6px;
            font-size: 14px;
        }


        /* REMARKS */

        .admin-remarks {
            background: #f5f7fa;
            border: 1px solid #e4e7ec;
            padding: 8px;
            border-radius: 6px;
            font-size: 14px;
        }


        /* FILE LINKS */

        .result-wrapper a {
            font-weight: 500;
            color: #2c6cff;
        }

        .result-wrapper a:hover {
            text-decoration: underline;
        }


        /* HEADING */

        .result-wrapper h2 {
            font-weight: 700;
            margin-bottom: 15px;
            color: #1a1f36;
        }


        /* STATUS CARD */

        .status-card {
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 15px;
        }


        /* SUMMARY CARD */

        .summary-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .summary-title {
            font-weight: 700;
            margin-bottom: 15px;
            color: #1e2a3b;
        }


        /* GRID */

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .stat-box {
            background: #f5f7fb;
            padding: 10px 14px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
        }

        .stat-value {
            font-size: 16px;
            font-weight: 700;
        }


        /* PROGRESS */

        .progress-area {
            margin-top: 10px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .modern-progress {
            height: 8px;
            background: #e9edf3;
            border-radius: 10px;
        }

        .modern-progress .progress-bar {
            background: #28a745;
            border-radius: 10px;
        }


        /* SCORE CARD */

        .score-card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);

        }

        .score-title {
            font-weight: 700;
            color: #1e2a3b;
        }

        .score-value {
            font-size: 38px;
            font-weight: 800;
            color: #2c6cff;
            margin-top: 10px;
        }

        .score-value span {
            font-size: 20px;
            color: #555;
        }

        .score-pending {
            font-size: 18px;
            color: #888;
            margin-top: 10px;
        }

        .attempt-number {
            margin-top: 10px;
            font-weight: 600;
            background: #f1f3f7;
            display: inline-block;
            padding: 5px 14px;
            border-radius: 6px;
        }

        .completed-date {
            margin-top: 15px;
            font-size: 14px;
            color: #444;
        }
    </style>

    <div class="result-wrapper">

        <div style="text-align:right;margin-bottom:15px;">
            <a href="{{ route('user.test-papers') }}" class="btn btn-sm btn-primary"
                style="font-weight:500;padding:7px 15px;">
                ⬅ Back To My Attempts
            </a>
        </div>

        <h2>{{$test->name}} - Result</h2>

        {{-- TEST STATUS --}}
        @if($attempt->status === 'pending' || $attempt->status === 'under_review')
            <div class="q-box" style="background:#fff4cd;border-left:5px solid #ffc400;">
                <h3 style="margin:0;color:#6a4f00;">Test Status: Pending Evaluation</h3>
                <p style="margin-top:6px;color:#6a4f00;">
                    Some subjective answers require manual checking.
                    Once reviewed, marks will be updated.
                </p>
            </div>
        @else
            <div class="q-box" style="background:#e7ffe8;border-left:5px solid #2fa058;">
                <h3 style="margin:0;color:#0e6c42;">Test Status: Completed</h3>
                <p style="margin-top:6px;color:#0e6c42;">
                    Your test has been evaluated successfully.
                </p>
            </div>
        @endif



        {{-- Final Score & Stats --}}
        <div class="row g-3" style="margin-bottom:30px;">

            {{-- PERFORMANCE SUMMARY --}}
            <div class="col-md-6">
                <div class="summary-card">

                    <h4 class="summary-title">Performance Summary</h4>

                    <div class="summary-grid">

                        <div class="stat-box">
                            <span class="stat-label">Total Questions</span>
                            <span class="stat-value">{{$attempt->total_questions}}</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">Attempted</span>
                            <span class="stat-value text-primary">{{$attempt->attempted_count}}</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">Not Attempted</span>
                            <span class="stat-value text-dark">{{$attempt->not_attempted}}</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">Correct</span>
                            <span class="stat-value text-success">{{$attempt->correct_count}}</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">Wrong</span>
                            <span class="stat-value text-danger">{{$attempt->wrong_count}}</span>
                        </div>

                    </div>

                    {{-- Progress --}}
                    @php $progress = ($attempt->attempted_count / $attempt->total_questions) * 100; @endphp

                    <div class="progress-area">

                        <div class="progress-label">
                            Progress <span>{{ round($progress) }}%</span>
                        </div>

                        <div class="progress modern-progress">
                            <div class="progress-bar" style="width: {{round($progress)}}%;"></div>
                        </div>

                    </div>

                </div>
            </div>


            {{-- FINAL SCORE --}}
            <div class="col-md-6">

                <div class="score-card">

                    <h3 class="score-title">Final Score</h3>

                    @if($attempt->status === 'published')

                        <div class="score-value">
                            {{$attempt->final_score}}
                            <span>/ {{$attempt->actual_marks}}</span>
                        </div>

                    @else

                        <div class="score-pending">
                            Pending Evaluation
                        </div>

                    @endif

                    <div class="attempt-number">
                        Attempt #{{$attemptCount}}
                    </div>

                    <div class="completed-date">

                        <small>Completed On</small>

                        <div>
                            @if($attempt->completed_at)
                                {{ \Carbon\Carbon::parse($attempt->completed_at)->format('d M Y, h:i A') }}
                            @else
                                -
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- Question-wise report --}}
        @foreach($mainAnswers as $ans)
            @php
                $eval = $ans->evaluation_status;

                $statusClass = match ($eval) {
                    'correct' => 'correct',
                    'wrong' => 'wrong',
                    'pending', 'partial' => 'pending',
                    default => 'pending'
                };

                $statusText = match ($eval) {
                    'correct' => "Correct ({$ans->obtained_marks})",
                    'wrong' => "Wrong ({$ans->obtained_marks})",
                    'pending' => "Pending Check",
                    'partial' => "Partially Correct ({$ans->obtained_marks})",
                    'not_evaluated' => 'Not Evaluated',
                    default => 'Attempted'
                };
            @endphp

            <div class="q-box">

                {{-- Question --}}
                <div class="q-title">
                    Q{{ $loop->iteration }}. {!! optional($ans->question)->question ?? '-' !!}
                </div>


                {{-- Show MCQ options first --}}
                @if(optional($ans->question)->question_type == 'MCQ')
                    <div style="margin-top:10px;">
                        <strong>Options:</strong>
                        <ul style="list-style:none;padding-left:0;margin-top:5px;">
                            @foreach(['option_a', 'option_b', 'option_c', 'option_d', 'option_e'] as $key)
                                @php
                                    $val = $ans->question->$key ?? null;
                                    if (!$val)
                                        continue;

                                    $optionKey = strtoupper(substr($key, -1));

                                    $isCorrect = trim($ans->question->answer) == $optionKey;
                                    $isSelected = trim($ans->answer_key) == $optionKey;
                                @endphp

                                <li style="margin-bottom:10px;">
                                    <span class="mcq-option" style="@if($isCorrect) background:#0ccb57;color:white;
                                       @elseif($isSelected) background:#e13838;color:white;
                                                       @endif">
                                        {{ $optionKey }}. {{ trim(strip_tags($val)) }}
                                    </span>

                                    <!--@if($isCorrect)-->
                                    <!--    <small style="color:#0a7d34;font-weight:600;">(Correct)</small>-->
                                    <!--@endif-->
                                </li>

                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- DO NOT show main answer for Story Based --}}
                @if(optional($ans->question)->question_type !== 'Story Based')

                    {{-- Main Answer --}}
                    <div style="margin-bottom:8px;">
                        <strong>Your Answer:</strong>

                        @if($ans->answer_text)
                            {{ $ans->answer_text }}
                        @elseif($ans->answer_file)
                            <a href="{{ asset('storage/student_attempts/' . $ans->answer_file) }}" target="_blank"
                                style="color:#007bff;text-decoration:underline;">
                                View Uploaded File
                            </a>
                        @else
                            <span style="color:#999;">Not Answered</span>
                        @endif

                        <span class="answer-tag {{ $statusClass }}" style="margin-left:8px;">
                            {{ $statusText }}
                        </span>
                        {{-- ============= SHOW SOLUTION (IF EXISTS) ============= --}}
                        @if(optional($ans->question)->has_solution == 'yes' && $ans->question->solution)
                            <div class="mt-2">
                                <strong>Solution:</strong>
                                <div class="solution-box">

                                    {!! $ans->question->solution !!}
                                </div>
                            </div>
                        @endif

                        {{-- ============= ADMIN REMARKS (SHOW FIRST) ============= --}}
                     {{-- REMARKS --}}

@if($ans->admin_remarks)
    <div class="mb-2">
        <strong style="color:#0a4d8c;">Admin Remarks:</strong>
        <div class="admin-remarks">{{ $ans->admin_remarks }}</div>
    </div>

@elseif($ans->teacher_remarks)
    <div class="mb-2">
        <strong style="color:#8c5700;">Teacher Remarks:</strong>
        <div class="admin-remarks">{{ $ans->teacher_remarks }}</div>
    </div>
@endif


{{-- FILES --}}

@if($ans->admin_file)
    <a href="{{ asset('storage/evaluation_files/' . $ans->admin_file) }}"
       target="_blank"
       class="btn btn-sm btn-info">
       View Admin File
    </a>

@elseif($ans->teacher_file)
    <a href="{{ asset('storage/evaluation_files/' . $ans->teacher_file) }}"
       target="_blank"
       class="btn btn-sm btn-secondary">
       View Teacher File
    </a>
@endif

                    </div>
                @endif


                {{-- CHILD QUESTIONS --}}
                @if(isset($childGrouped[$ans->question_id]))

                    <div style="margin-top:10px;font-weight:600;">Sub Questions:</div>

                    @foreach($childGrouped[$ans->question_id] as $child)

                        @php
                            $childEval = $child->evaluation_status;

                            $childClass = match ($childEval) {
                                'correct' => 'correct',
                                'wrong' => 'wrong',
                                'pending', 'partial' => 'pending',
                                default => 'pending'
                            };

                            $childText = match ($childEval) {
                                'correct' => "Correct ({$child->obtained_marks})",
                                'wrong' => "Wrong ({$child->obtained_marks})",
                                'pending' => "Pending Check",
                                'not_evaluated' => "Not Evaluated",
                                default => 'Attempted'
                            };

                            $childQue = optional($child->childQuestion);
                        @endphp

                        <div class="child-box">

                            <div><strong>Child Question:</strong> {!! $childQue->question ?? '-' !!}</div>

                            {{-- CHILD OPTIONS --}}
                            @php
                                $isChildMcq = !empty($childQue->answer) &&
                                    (!empty($childQue->option_a) || !empty($childQue->option_b));
                            @endphp

                            @if($isChildMcq)
                                <div style="margin-top:8px;">
                                    <strong>Options:</strong>
                                    <ul style="list-style:none;padding-left:0;margin-top:5px;">
                                        @foreach(['option_a', 'option_b', 'option_c', 'option_d', 'option_e'] as $key)
                                            @php
                                                $val = $childQue->$key ?? null;
                                                if (!$val)
                                                    continue;

                                                $optionKey = strtoupper(substr($key, -1));

                                                $isCorrect = trim($childQue->answer) == $optionKey;
                                                $isSelected = trim($child->answer_key) == $optionKey;
                                            @endphp

                                            <li style="margin-bottom:10px;">
                                                <span class="mcq-option" style="@if($isCorrect) background:#0ccb57;color:white;
                                                   @elseif($isSelected) background:#e13838;color:white;
                                                                           @endif">
                                                    {{ $optionKey }}. {{ trim(strip_tags($val)) }}
                                                </span>

                                                <!--@if($isCorrect)-->
                                                <!--    <small style="color:#0a7d34;font-weight:600;">(Correct)</small>-->
                                                <!--@endif-->
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- CHILD Answer --}}
                            <div style="margin-top:8px;">
                                <strong>Your Answer:</strong>

                                @if($child->answer_text)
                                    {{ $child->answer_text }}
                                @elseif($child->answer_file)
                                    <a href="{{ asset('storage/student_attempts/' . $child->answer_file) }}" target="_blank"
                                        style="color:#007bff;text-decoration:underline;">
                                        View Uploaded File
                                    </a>
                                @else
                                    <span style="color:#777;">Not Answered</span>
                                @endif

                                <span class="answer-tag {{ $childClass }}" style="margin-left:8px;">
                                    {{ $childText }}
                                </span>
                                {{-- ============= CHILD SOLUTION (IF EXISTS) ============= --}}
                                @if(optional($childQue)->has_solution == 'yes' && $childQue->solution)
                                    <div class="mt-2">
                                        <strong>Solution:</strong>
                                        <div class="solution-box">

                                            {!! $childQue->solution !!}
                                        </div>
                                    </div>
                                @endif

                                {{-- ============= ADMIN REMARKS ============= --}}
                                @if($child->admin_remarks)
                                    <div class="mt-2">
                                        <strong style="color:#0a4d8c;">Admin Remarks:</strong>
                                        <div class="admin-remarks">{{ $child->admin_remarks }}</div>
                                    </div>

                                    @if($child->admin_file)
                                        <a href="{{ asset('storage/evaluation_files/' . $child->admin_file) }}" target="_blank"
                                            class="btn btn-sm btn-info mt-2">View Admin File</a>
                                    @endif

                                @elseif($child->teacher_remarks)
                                    {{-- ============= TEACHER REMARKS ============= --}}
                                    <div class="mt-2">
                                        <strong style="color:#8c5700;">Teacher Remarks:</strong>
                                        <div class="admin-remarks">{{ $child->teacher_remarks }}</div>
                                    </div>

                                    @if($child->teacher_file)
                                        <a href="{{ asset('storage/evaluation_files/' . $child->teacher_file) }}" target="_blank"
                                            class="btn btn-sm btn-secondary mt-2">View Teacher File</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        @endforeach

    </div>

@endsection