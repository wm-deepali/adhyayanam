@extends('front-users.layouts.app')

@section('title')
    {{$test->name}} Result
@endsection

@section('content')

    <style>
        .result-wrapper {
            width: 100%;
            padding: 15px;
        }

        .q-box {
            padding: 15px;
            background: white;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: rgba(0, 0, 0, 0.08) 0px 4px 12px;
        }

        .q-title {
            font-size: 17px;
            font-weight: 600;
        }

        .answer-tag {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .correct {
            background: #0ccb57;
            color: white;
        }

        .wrong {
            background: #e13838;
            color: white;
        }

        .pending {
            background: #ffbe3a;
            color: black;
        }

        .child-box {
            margin: 8px 0;
            padding: 10px;
            border-left: 4px solid #0059ff;
            background: #eef4ff;
            border-radius: 7px;
        }

        .mcq-option {
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-block;
            font-weight: 500;
        }

        .score-box {
            font-size: 26px;
            color: #004799;
            font-weight: bold;
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
        <div class="row g-3">

            <div class="col-md-6">
                <div class="q-box">
                    <h4 style="font-weight:700;margin-bottom:10px;">Performance Summary</h4>

                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-secondary">Total Questions</td>
                                <td>{{$attempt->total_questions}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-secondary">Attempted</td>
                                <td><span class="badge bg-primary px-3">{{$attempt->attempted_count}}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-secondary">Not Attempted</td>
                                <td><span class="badge bg-dark px-3">{{$attempt->not_attempted}}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-secondary">Correct</td>
                                <td><span class="badge bg-success px-3">{{$attempt->correct_count}}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-secondary">Wrong</td>
                                <td><span class="badge bg-danger px-3">{{$attempt->wrong_count}}</span></td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Progress --}}
                    @php $progress = ($attempt->attempted_count / $attempt->total_questions) * 100; @endphp

                    <div class="mt-3">
                        <small style="font-size:13px;font-weight:600;color:#555;">Progress</small>
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar bg-success" style="width: {{round($progress)}}%;"></div>
                        </div>
                        <small>{{ round($progress) }}% Completed</small>
                    </div>
                </div>
            </div>

            {{-- FINAL SCORE --}}
            {{-- FINAL SCORE --}}
            <div class="col-md-6">
                <div class="q-box text-center">
                    <h3 class="mb-0">Final Score</h3>

                    @if($attempt->status === 'published')
                        <div class="score-box mt-2">
                            {{$attempt->final_score}} / {{$attempt->max_positive_score}}
                        </div>
                    @else
                        <div class="score-box mt-2" style="color:#888;font-size:18px;">
                            Pending Evaluation
                        </div>
                    @endif

                    <div class="mt-2">
                        <strong class="badge bg-dark px-3 py-2">Attempt #{{$attemptCount}}</strong>
                    </div>

                    <div class="mt-3">
                        <small style="font-size:13px;color:#555;">Completed On:</small><br>
                        <strong>
                            @if($attempt->completed_at)
                                {{ \Carbon\Carbon::parse($attempt->completed_at)->format('d M Y, h:i A') }}
                            @else
                                -
                            @endif
                        </strong>
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
                    'partial' => "Partially Correct",
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

                                <li style="margin-bottom:4px;">
                                    <span class="mcq-option" style="@if($isCorrect) background:#0ccb57;color:white;
                                       @elseif($isSelected) background:#e13838;color:white;
                                                       @endif">
                                        {{ $optionKey }}. {{ trim(strip_tags($val)) }}
                                    </span>

                                    @if($isCorrect)
                                        <small style="color:#0a7d34;font-weight:600;">(Correct)</small>
                                    @endif
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
                                <div class="p-2 border" style="background:#eef7ff;">
                                    {!! $ans->question->solution !!}
                                </div>
                            </div>
                        @endif

                        {{-- ============= ADMIN REMARKS (SHOW FIRST) ============= --}}
                        @if($ans->admin_remarks)
                            <div class="mt-2">
                                <strong style="color:#0a4d8c;">Admin Remarks:</strong>
                                <div class="p-2 border bg-light">{{ $ans->admin_remarks }}</div>
                            </div>

                            @if($ans->admin_file)
                                <a href="{{ asset('storage/evaluation_files/' . $ans->admin_file) }}" target="_blank"
                                    class="btn btn-sm btn-info mt-2">View Admin File</a>
                            @endif
                        @elseif($ans->teacher_remarks)
                            {{-- ============= TEACHER REMARKS (ONLY IF ADMIN EMPTY) ============= --}}
                            <div class="mt-2">
                                <strong style="color:#8c5700;">Teacher Remarks:</strong>
                                <div class="p-2 border bg-light">{{ $ans->teacher_remarks }}</div>
                            </div>

                            @if($ans->teacher_file)
                                <a href="{{ asset('storage/evaluation_files/' . $ans->teacher_file) }}" target="_blank"
                                    class="btn btn-sm btn-secondary mt-2">View Teacher File</a>
                            @endif
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

                                            <li style="margin-bottom:3px;">
                                                <span class="mcq-option" style="@if($isCorrect) background:#0ccb57;color:white;
                                                   @elseif($isSelected) background:#e13838;color:white;
                                                                           @endif">
                                                    {{ $optionKey }}. {{ trim(strip_tags($val)) }}
                                                </span>

                                                @if($isCorrect)
                                                    <small style="color:#0a7d34;font-weight:600;">(Correct)</small>
                                                @endif
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
                                        <div class="p-2 border" style="background:#eef7ff;">
                                            {!! $childQue->solution !!}
                                        </div>
                                    </div>
                                @endif

                                {{-- ============= ADMIN REMARKS ============= --}}
                                @if($child->admin_remarks)
                                    <div class="mt-2">
                                        <strong style="color:#0a4d8c;">Admin Remarks:</strong>
                                        <div class="p-2 border bg-light">{{ $child->admin_remarks }}</div>
                                    </div>

                                    @if($child->admin_file)
                                        <a href="{{ asset('storage/evaluation_files/' . $child->admin_file) }}" target="_blank"
                                            class="btn btn-sm btn-info mt-2">View Admin File</a>
                                    @endif

                                @elseif($child->teacher_remarks)
                                    {{-- ============= TEACHER REMARKS ============= --}}
                                    <div class="mt-2">
                                        <strong style="color:#8c5700;">Teacher Remarks:</strong>
                                        <div class="p-2 border bg-light">{{ $child->teacher_remarks }}</div>
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