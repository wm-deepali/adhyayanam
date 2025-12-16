@extends('layouts.app')

@section('title', 'Evaluate Attempt')

@section('content')

    <style>
        .block-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            background: white;
        }

        .box-heading {
            background: #0c66ff;
            color: white;
            padding: 6px 15px;
            font-weight: 600;
            border-radius: 4px;
        }

        .unattempted {
            color: #888;
            font-style: italic;
            font-weight: 600;
        }
    </style>

    <form id="adminEvaluationForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

        {{--================== STUDENT DETAILS ==================--}}
        <div class="block-card">
            <div class="box-heading">Student Details</div>

            <table class="table table-bordered mt-2">
                <tr>
                    <th>Name</th>
                    <td>{{ $attempt->student->name ?? '-' }}</td>

                    <th>Email</th>
                    <td>{{ $attempt->student->email ?? '-' }}</td>

                    <th>Mobile</th>
                    <td>{{ $attempt->student->mobile ?? '-' }}</td>
                </tr>
            </table>
        </div>


        {{--================== TEST DETAILS ==================--}}
        <div class="block-card">
            <div class="box-heading">Test Details</div>

            <table class="table table-bordered mt-2">

                <tr>
                    <th>Examination Commission</th>
                    <td>{{ $attempt->test->commission->name ?? '-' }}</td>

                    <th>Examination Category</th>
                    <td>{{ $attempt->test->category->name ?? '-' }}</td>

                    <th>Sub Category</th>
                    <td>{{ $attempt->test->subcategory->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Test Name</th>
                    <td>
                        {{ $attempt->test->name }}
                        @if($attempt->test->test_code)
                            <span style="color:blue;font-weight:bold;">
                                ({{ $attempt->test->test_code }})
                            </span>
                        @endif
                    </td>

                    <th>Paper Type</th>
                    <td>
                        @php
                            $paperType = $attempt->test->paper_type;
                            $typeName = match ($paperType) {
                                1 => 'Previous Year',
                                2 => 'Current Affair',
                                default => (
                                    is_null($attempt->test->topic_id) && is_null($attempt->test->subject_id) && is_null($attempt->test->chapter_id)
                                    ? 'Full Test'
                                    : (!is_null($attempt->test->subject_id) && is_null($attempt->test->chapter_id)
                                        ? 'Subject Wise'
                                        : (!is_null($attempt->test->chapter_id) && is_null($attempt->test->topic_id)
                                            ? 'Chapter Wise'
                                            : (!is_null($attempt->test->topic_id)
                                                ? 'Topic Wise'
                                                : '-'
                                            )
                                        )
                                    )
                                )
                            };
                        @endphp

                        {{ $typeName }} ({{ ucfirst($attempt->test->test_paper_type) }})
                    </td>

                    <th>Test Mode</th>
                    <td>{{ $attempt->test->mrp > 0 ? 'Paid' : 'Free' }}</td>
                </tr>

                <tr>
                    <th>Total Marks</th>
                    <td>{{ $attempt->test->total_marks ?? '0' }}</td>

                    <th>Duration</th>
                    <td>{{ $attempt->test->duration }} Minutes</td>

                    <th>Has Negative Marks</th>
                    <td>
                        @if($attempt->test->has_negative_marks)
                            Yes ({{ $attempt->test->negative_marks_per_question }}%)
                        @else
                            No
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Questions Attempted</th>
                    <td>{{ $attempt->attempted_count ?? 0 }}</td>

                    <th>Questions Skipped</th>
                    <td>{{ $attempt->not_attempted ?? 0 }}</td>

                    <th>Test Attempted On</th>
                    <td>{{ $attempt->created_at->format('d M, Y h:i A') }}</td>
                </tr>

                <tr>
                    <th>Time Taken</th>
                    <td>{{ gmdate('H:i:s', $attempt->time_taken ?? 0) }}</td>

                    <th>Marks Obtained</th>
                    <td>
                        @if($attempt->status === 'evaluated')
                            <span class="text-success fw-bold">
                                {{ $attempt->final_score }}
                            </span>
                        @else
                            <span class="text-danger fw-bold">
                                Pending
                            </span>
                        @endif
                    </td>

                    <th>Result Status</th>
                    <td>
                        @php $status = strtolower($attempt->status) @endphp

                        <span class="fw-bold 
                                                                                            {{ $status == 'evaluated' ? 'text-success' :
        ($status == 'pending' ? 'text-warning' : 'text-primary') }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                </tr>

            </table>
        </div>


        {{-- ================= SUMMARY SECTION ================= --}}
        @if(!empty($summary))
            <div class="block-card">
                <div class="box-heading">Question Type Summary</div>

                <table class="table table-bordered text-center mt-2">
                    <thead style="background:#0098c7;color:white;">
                        <tr>
                            <th>Type</th>
                            <th>Total</th>
                            <th>Correct</th>
                            <th>Partial Correct</th>
                            <th>Incorrect</th>
                            <th>Skipped</th>
                            <th>Negative Marks</th>
                            <th>Marks Obtained</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($summary as $type => $row)
                            <tr>
                                <td class="fw-bold">{{ $type }}</td>

                                <td>{{ $row['total'] }}</td>

                                {{-- Correct --}}
                                <td>
                                    @if($row['has_pending'])
                                        <span class="text-warning fw-bold">Pending</span>
                                    @else
                                        {{ $row['correct'] ?: 0 }}
                                    @endif
                                </td>

                                {{-- Partial --}}
                                <td>
                                    @if($row['has_pending'])
                                        <span class="text-warning fw-bold">Pending</span>
                                    @else
                                        {{ $row['partial'] ?: 0 }}
                                    @endif
                                </td>

                                {{-- Incorrect --}}
                                <td>
                                    @if($row['has_pending'])
                                        <span class="text-warning fw-bold">Pending</span>
                                    @else
                                        {{ $row['incorrect'] ?: 0 }}
                                    @endif
                                </td>

                                <td>{{ $row['skipped'] ?: 0 }}</td>
                                <td>{{ $row['negative'] ?: 0 }}</td>

                                <td><strong>{{ $row['obtained'] }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif


        {{-- ================= QUESTION LIST ================= --}}
        <div class="block-card">
            <div class="box-heading">Questions Paper</div>

            @foreach($mainAnswers as $index => $ans)
                <div class="p-3" style="border-bottom:1px solid #ddd">

                    {{-- If STORY BASED → layout is DIFFERENT --}}
                    @if($ans->question->question_type == 'Story Based')

                        <h5><strong>{{ $index + 1 }}.</strong> {!! $ans->question->question !!}</h5>

                        @if(isset($childGrouped[$ans->question_id]))
                            <div class="mt-3">
                                <strong>Sub Questions:</strong>

                                @foreach($childGrouped[$ans->question_id] as $child)

                                    @php
                                        $cq = $child->childQuestion;  // <-- correct key
                                        $isMCQ = (!empty($cq->answer) || !empty($cq->option_a) || !empty($cq->option_b));
                                        $isSubjective = (!$isMCQ); // no options + no answer = subjective
                                    @endphp

                                    <div class="row p-3 mt-3 bg-light border rounded">

                                        {{-- LEFT SIDE --}}
                                        <div class="col-md-9">
                                            <strong>Statement:</strong>
                                            {!! $cq->question ?? ''!!}


                                            {{-- =============== MCQ CHILD =============== --}}
                                            @if($isMCQ)

                                                <div class="row mt-3">

                                                    @foreach(['option_a', 'option_b', 'option_c', 'option_d', 'option_e'] as $opt)
                                                        @php
                                                            $val = $cq->$opt;
                                                            if (!$val)
                                                                continue;

                                                            $letter = strtoupper(substr($opt, -1));
                                                            $correct = trim($cq->answer) == $letter;
                                                            $selected = trim($child->answer_key) == $letter;
                                                        @endphp

                                                        <div class="col-md-6 mb-2">
                                                            <div class="p-2 border rounded d-flex justify-content-between align-items-center"
                                                                style="background:{{ $selected ? '#e2e2e2' : '#fff' }}">
                                                                <span><strong>{{ $letter }}.</strong> {{ strip_tags($val) }}</span>

                                                                @if($correct)
                                                                    <span class="text-success fw-bold">✔</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                                <p class="mt-2">
                                                    <strong>Correct Answer:</strong> {{ strtoupper($cq->answer) }}
                                                </p>

                                            @endif


                                            {{-- =============== SUBJECTIVE CHILD =============== --}}
                                            @if($isSubjective)

                                                <div class="mt-2">
                                                    <strong>Your Answer:</strong><br>

                                                    @if($child->answer_text)
                                                        <div class="p-2 border bg-white">{{ $child->answer_text }}</div>
                                                    @elseif($child->answer_file)
                                                        <a href="{{ asset('storage/student_attempts/' . $child->answer_file) }}"
                                                            class="btn btn-sm btn-primary" target="_blank">View File</a>
                                                    @else
                                                        <span class="unattempted">Not Attempted</span>
                                                    @endif
                                                </div>

                                                {{-- ================= TEACHER REMARKS ================= --}}
                                                @if($child->teacher_remarks)
                                                    <div class="mt-2 text-start">
                                                        <strong>Teacher Remarks:</strong>
                                                        <div class="p-2 border rounded bg-light">{{ $child->teacher_remarks }}</div>
                                                    </div>
                                                @endif

                                                @if($child->teacher_file)
                                                    <a href="{{ asset('storage/evaluation_files/' . $child->teacher_file) }}"
                                                        class="btn btn-sm btn-secondary mt-2" target="_blank">
                                                        View Teacher File
                                                    </a>
                                                @endif

                                                {{-- ================= ADMIN REMARKS ================= --}}
                                                @if($child->admin_remarks)
                                                    <div class="mt-3 text-start">
                                                        <strong>Admin Remarks:</strong>
                                                        <div class="p-2 border rounded bg-white">{{ $child->admin_remarks }}</div>
                                                    </div>
                                                @endif

                                                @if($child->admin_file)
                                                    <a href="{{ asset('storage/evaluation_files/' . $child->admin_file) }}"
                                                        class="btn btn-sm btn-info mt-2" target="_blank">
                                                        View Admin File
                                                    </a>
                                                @endif
                                            @endif
                                        </div>

                                        {{-- RIGHT PANEL --}}
                                        <div class="col-md-3 text-center" style="border-left:1px solid #ccc;">

                                            <p>
                                                <strong>Status:</strong>
                                                @if($child->attempt_status == 'attempted')
                                                    <span class="text-success">Attempted</span>
                                                @else
                                                    <span class="text-danger">Not Attempted</span>
                                                @endif
                                            </p>

                                            <hr>

                                            {{-- Assign Marks ONLY for subjective child --}}
                                            @if($isSubjective && \App\Helpers\Helper::canAccess('manage_test_attempts_edit'))
                                                <button type="button" class="btn btn-dark w-100"
                                                    onclick="openMarksModal('{{ $child->id }}','{{ $child->positive_mark }}','{{ $child->obtained_marks }}')">
                                                    Assign Marks
                                                </button>
                                            @endif


                                            {{-- For MCQ show correct answer --}}
                                            @if($isMCQ)
                                                <p class="mt-2"><strong>Correct:</strong> {{ strtoupper($cq->answer) }}</p>
                                            @endif

                                            <p class="mt-2">
                                                <strong>Marks:</strong>
                                                <span id="marks-display-{{ $child->id }}">
                                                    {{ $child->obtained_marks ?? 0 }}
                                                </span> / {{ $child->positive_mark }}
                                            </p>

                                        </div>

                                    </div>

                                @endforeach
                            </div>
                        @endif

                    @else
                        <div class="d-flex justify-content-between">
                            {{-- LEFT SIDE --}}
                            <div style="width:75%; padding-right:15px;">

                                <h5><strong>{{ $index + 1 }}.</strong> {!! $ans->question->question !!}</h5>

                                {{-- MCQ BLOCK --}}
                                @if($ans->question->question_type == 'MCQ')
                                    <div class="row mt-3">
                                        @foreach(['option_a', 'option_b', 'option_c', 'option_d', 'option_e'] as $opt)
                                            @php
                                                $val = $ans->question->$opt;
                                                if (!$val)
                                                    continue;
                                                $letter = strtoupper(substr($opt, -1));
                                                $correct = trim($ans->question->answer) == $letter;
                                                $selected = trim($ans->answer_key) == $letter;
                                            @endphp

                                            <div class="col-md-6 mb-2">
                                                <div class="p-2 border rounded d-flex justify-content-between align-items-center"
                                                    style="background:{{ $selected ? '#e2e2e2' : '#fff' }}">
                                                    <strong>{{ $letter }}.</strong> {{ strip_tags($val) }}

                                                    @if($correct)
                                                        <span class="text-success fw-bold">✔</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <p class="mt-2"><strong>Correct Answer:</strong> {{ strtoupper($ans->question->answer) }}</p>
                                @endif

                                {{-- SUBJECTIVE BLOCK --}}
                                @if($ans->question->question_type == 'Subjective')

                                    {{-- Solution --}}
                                    @if($ans->question->has_solution == 'yes' && $ans->question->solution)
                                        <button type="button" class="btn btn-primary btn-sm mt-2"
                                            onclick="openSolutionModal(`{!! $ans->question->solution !!}`)">View Solution</button>
                                    @endif

                                    <div class="mt-3">
                                        <strong>Your Answer:</strong><br>

                                        @if($ans->answer_text)
                                            <div class="p-2 border bg-light">{{ $ans->answer_text }}</div>
                                        @elseif($ans->answer_file)
                                            <a href="{{ asset('storage/student_attempts/' . $ans->answer_file) }}"
                                                class="btn btn-sm btn-primary" target="_blank">View File</a>
                                        @else
                                            <span class="unattempted">Not Attempted</span>
                                        @endif
                                    </div>

                                    {{-- ================= TEACHER REMARKS ================= --}}
                                    @if($ans->teacher_remarks)
                                        <div class="mt-2 text-start">
                                            <strong>Teacher Remarks:</strong>
                                            <div class="p-2 border rounded bg-light">{{ $ans->teacher_remarks }}</div>
                                        </div>
                                    @endif

                                    @if($ans->teacher_file)
                                        <a href="{{ asset('storage/evaluation_files/' . $ans->teacher_file) }}"
                                            class="btn btn-sm btn-secondary mt-2" target="_blank">
                                            View Teacher File
                                        </a>
                                    @endif

                                    {{-- ================= ADMIN REMARKS ================= --}}
                                    @if($ans->admin_remarks)
                                        <div class="mt-3 text-start">
                                            <strong>Admin Remarks:</strong>
                                            <div class="p-2 border rounded bg-white">{{ $ans->admin_remarks }}</div>
                                        </div>
                                    @endif

                                    @if($ans->admin_file)
                                        <a href="{{ asset('storage/evaluation_files/' . $ans->admin_file) }}"
                                            class="btn btn-sm btn-info mt-2" target="_blank">
                                            View Admin File
                                        </a>
                                    @endif
                                @endif
                            </div>

                            {{-- RIGHT SIDE PANEL --}}
                            <div style="width:25%; border-left:1px solid #ccc; padding-left:15px; text-align:center;">

                                <p>
                                    <strong>Status:</strong>
                                    @if($ans->attempt_status == 'attempted')
                                        <span class="text-success">Attempted</span>
                                    @else
                                        <span class="text-danger">Not Attempted</span>
                                    @endif
                                </p>

                                <hr>

                                @if(
                                        $ans->question->question_type == "Subjective" &&
                                        \App\Helpers\Helper::canAccess('manage_test_attempts_edit')
                                    )
                                    <button type="button" class="btn btn-dark w-100"
                                        onclick="openMarksModal('{{ $ans->id }}', '{{ $ans->positive_mark }}', '{{ $ans->obtained_marks }}')">
                                        Assign Marks
                                    </button>
                                @endif

                                <p class="mt-2">
                                    <strong>Marks:</strong>
                                    <span id="marks-display-{{ $ans->id }}">
                                        {{ $ans->obtained_marks ?? 0 }}
                                    </span> / {{ $ans->positive_mark }}
                                </p>

                            </div>

                        </div>
                    @endif

                </div>
            @endforeach

        </div>


        @if(\App\Helpers\Helper::canAccess('manage_test_attempts_edit'))
            <div class="block-card mt-4">
                <div class="box-heading">Final Evaluation Status</div>

                <div class="row mt-3">

                    {{-- STATUS DROPDOWN --}}
                    <div class="col-md-4">
                        <label class="fw-bold">Status</label>
                        <select name="final_status" class="form-control">
                            <option value="pending" {{ $attempt->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="under_review" {{ $attempt->status == 'under_review' ? 'selected' : '' }}>
                                Under Review
                            </option>
                            <option value="published" {{ $attempt->status == 'published' ? 'selected' : '' }}>
                                Published
                            </option>
                        </select>
                    </div>

                    {{-- UPLOAD FINAL FILE --}}
                    <div class="col-md-4">
                        <label class="fw-bold">Upload Final Evaluated File</label>
                        <input type="file" name="final_file" class="form-control">
                    </div>

                    {{-- SHOW EXISTING FILE --}}
                    @if($attempt->final_file)
                        <div class="col-md-4 mt-4">
                            <a href="{{ asset('storage/evaluations/' . $attempt->final_file) }}" class="btn btn-primary"
                                target="_blank">
                                View Uploaded File
                            </a>
                        </div>
                    @endif
                </div>

                <div class="text-end mt-4">
                    <button type="button" class="btn btn-success btn-lg" onclick="submitAdminEvaluation()">
                        ✅ Save Evaluation
                    </button>
                </div>
            </div>
        @endif

    </form>

    {{-- ================= VIEW SOLUTION MODAL ================= --}}
    <div class="modal fade" id="solutionModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5>Solution</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="solutionContent"></div>

            </div>
        </div>
    </div>

    {{-- ================= ASSIGN MARKS MODAL ================= --}}
    <div class="modal fade" id="marksModal">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-dark text-white">
                    <h5>Assign Marks</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="adminMarksForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="question_id" id="marks_question_id">

                        <label class="fw-bold">Marks</label>
                        <input type="number" name="marks" id="marks_value" class="form-control" step="0.5" min="0">

                        <label class="fw-bold mt-3">Remarks</label>
                        <textarea name="remarks" id="marks_remarks" class="form-control" rows="3"></textarea>

                        <label class="fw-bold mt-3">Upload File</label>
                        <input type="file" name="file" id="marks_file" class="form-control">
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="submitMarks()">Assign Marks</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function openSolutionModal(content) {
            document.getElementById("solutionContent").innerHTML = content;
            new bootstrap.Modal(document.getElementById('solutionModal')).show();
        }

        function openMarksModal(id, max, obtained) {
            document.getElementById("marks_question_id").value = id;
            document.getElementById("marks_value").value = obtained ?? "";
            new bootstrap.Modal(document.getElementById('marksModal')).show();
        }

        function submitMarks() {
            let qid = document.getElementById("marks_question_id").value;
            let marks = document.getElementById("marks_value").value;

            if (marks === "" || marks < 0) {
                alert("Please enter valid marks.");
                return;
            }

            let formData = new FormData(document.getElementById("adminMarksForm"));

            fetch("{{ route('admin.assign-marks') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        document.getElementById("marks-display-" + qid).innerText = marks;

                        // Close modal
                        bootstrap.Modal.getInstance(document.getElementById("marksModal")).hide();
                    } else {
                        alert(data.msg ?? "Failed to assign marks.");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Server Error");
                });
        }

        function submitAdminEvaluation() {
            let form = document.getElementById("adminEvaluationForm");
            let formData = new FormData(form);

            fetch("{{ route('admin.save-evaluation') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        alert("Evaluation saved successfully!");
                        location.reload();
                    } else {
                        alert(data.msg ?? "Something went wrong!");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Server error!");
                });
        }

    </script>

@endsection